<?php
 
    include '/var/www/html/Server_UI/GetRecentLeagueIdphp.php';
    $xmlstr = new SimpleXMLElement($League_id_xml);
    $League_id = $xmlstr->League_id;

    $connect = mysqli_connect("localhost", "root", "soft2015","dbstock");

    if(mysqli_connect_errno())
    {
        printf("Connect failed : %s\n", mysqli_connect_errno());
        exit();
    }
    else
    {
        while(1)
        {
            $deleteQuery = "DELETE FROM queuing WHERE leagueId < '$League_id';";
            mysqli_query($connect, $deleteQuery);

            //예약 목록에 있는 주식들 가격 가져오는 부분
            $priceQuery = "SELECT DISTINCT finace.name, finace.open FROM queuing LEFT JOIN finace ON queuing.stockName=finace.name WHERE queuing.finish='0'";
            $priceResult = mysqli_query($connect, $priceQuery);

            //예약 목록 가져오는 부분
            $queuingLoadQuery = "SELECT * FROM queuing WHERE finish='0'";
            $queuingResult = mysqli_query($connect, $queuingLoadQuery);

            $priceTotalRecord = $priceResult->num_rows;
            $queuingTotalRecord = $queuingResult->num_rows;

            //예약 목록으로 전체 반복
            for($i = 0 ; $i < $queuingTotalRecord ; $i ++)
            {
                $queuingResult->data_seek($i);
                $queuingRow = $queuingResult->fetch_array();

                //해당 주식의 가격 가져오는 반복
                for($j = 0 ; $j < $priceTotalRecord ; $j ++)
                {
                    $priceResult->data_seek($j);
                    $priceRow = $priceResult->fetch_array();

                    if($queuingRow['stockName'] == $priceRow['name'])
                    {
                        $nowPrice = $priceRow['open'];  //nowPrice => 해당 주식의 현재 금액
                        break;
                    }
                }

                if($queuingRow['minMax'] == 'min')
                {
                    if($queuingRow['price'] < $nowPrice)    //하한가를 입력했는데 현재금액이 더 클 때
                    {
                        continue;
                    }
                }
                else
                {
                    if($queuingRow['price'] > $nowPrice)    //상한가를 입력했는데 현재금액이 더 작을 떄
                    {
                        continue;
                    }
                }

                //설정한 금액이 범위에 들어 왔을 때

                //구매
                $LoginID = $queuingRow['userId'];
                $stockName = $queuingRow['stockName'];
                $nowId = $queuingRow['id'];
                $Ddate = date("Ymd");

                if($queuingRow['sellBuy'] == 'buy')
                {
                    $getCashQuery = "SELECT cash FROM league_stat WHERE league_id='$League_id' AND id='$LoginID'";
                    $cashResult = mysqli_query($connect, $getCashQuery);

                    $cashReturn = $cashResult->fetch_array();
                    $nowCash = $cashReturn['cash'];         //nowCash => 현재 가지고 있는 현금

                    $needCash = $queuingRow['amount'] * $nowPrice;

                    if($nowCash >= $needCash)           //보유 현금으로 구매 가능
                    {
                        $buyCash = $needCash;
                        $buyAmount = $queuingRow['amount'];
                    }
                    else                                //보유 현금으로 희망하는 양 구매 불가
                    {
                        $buyAmount = floor($nowCash / $nowPrice);   //현재 잔액으로 최대 구매가능 양 계산
                        $buyCash = $buyAmount * $nowPrice;

                        if($buyAmount == 0)
                        {
                            continue;
                        }
                    }

                    $cntCurStockQuery = "SELECT count(id) AS cnt FROM CurStock WHERE id='$LoginID' AND
                                            stockname='$stockName' AND league_id='$League_id'";
                    $cntCurStockResult = mysqli_query($connect, $cntCurStockQuery);
                    $cntCurStockRow = $cntCurStockResult->fetch_array();
                    $cntCurStock = $cntCurStockRow['cnt'];

                    if($cntCurStock > 0)
                    {
                        $buyCurStockQuery = "UPDATE CurStock SET amount = amount+'$buyAmount'
                                            WHERE id='$LoginID' AND stockname='$stockName' AND league_id='$League_id'";  //CurStock Update Query
                    }
                    else
                    {
                        $buyCurStockQuery = "INSERT INTO CurStock(id, stockname, amount, league_id)
                                        VALUES('$LoginID', '$stockName', '$buyAmount', '$League_id')";  //CurStock Insert Query
                    }
                    mysqli_query($connect, $buyCurStockQuery);

                    $buyLogQuery = "INSERT INTO Log(id, stockname, amount, price, date, league_id)
                                    VALUES('$LoginID', '$stockName', '$buyAmount', '$nowPrice', '$Ddate', '$League_id')";
                    mysqli_query($connect, $buyLogQuery);

                    $finishQuery = "UPDATE queuing SET finish='1' WHERE id='$nowId'";
                    mysqli_query($connect, $finishQuery);

                    $newCashQuery = "UPDATE league_stat SET cash=cash-'$buyCash' WHERE id='$LoginID'";
                    mysqli_query($connect, $newCashQuery);

                    $insertMessageQuery = "INSERT INTO queuingMessage(userId, leagueId, stockName, price, amount, dDate, value, buySell)
                                            VALUES('$LoginID', '$League_id', '$stockName', '$nowPrice', '$buyAmount', '$Ddate', '$buyCash', 'buy')";
                    mysqli_query($connect, $insertMessageQuery);
                }
                else        //판매
                {
                    $haveAmountQuery = "SELECT amount FROM CurStock WHERE id='$LoginID' AND
                                            stockname='$stockName' AND league_id='$League_id'";
                    $haveAmountResult = mysqli_query($connect, $haveAmountQuery);
                    $haveAmountRow = $haveAmountResult->fetch_array();
                    $haveAmount = $haveAmountRow['amount'];

                    if($haveAmount >= $queuingRow['amount'])    //보유 주식이 희망 판매량보다 많을 때
                    {
                        $sellAmount = $queuingRow['amount'];
                    }
                    else if($haveAmount <= 0)                   //보유 주식이 없을 때
                    {
                        continue;
                    }
                    else                                        //희망 판매량보다 부족할 때
                    {
                        $sellAmount = $haveAmount;
                    }
                    $sellCash = $sellAmount * $nowPrice;

                    $sellCurStockQuery = "UPDATE CurStock SET amount = amount-'$sellAmount'
                                            WHERE id='$LoginID' AND stockname='$stockName' AND league_id='$League_id'";
                    mysqli_query($connect, $sellCurStockQuery);

                    $newCashQuery = "UPDATE league_stat SET cash=cash+'$sellCash' WHERE id='$LoginID'";
                    mysqli_query($connect, $newCashQuery);

                    $sellLogQuery = "INSERT INTO Log(id, stockname, amount, price, date, league_id)
                                    VALUES('$LoginID', '$stockName', '-$sellAmount', '$nowPrice', '$Ddate', '$League_id')";
                    mysqli_query($connect, $sellLogQuery);

                    $insertMessageQuery = "INSERT INTO queuingMessage(userId, leagueId, stockName, price, amount, dDate, value, buySell)
                                            VALUES('$LoginID', '$League_id', '$stockName', '$nowPrice', '$sellAmount', '$Ddate', '$sellCash', 'sell')";
                    mysqli_query($connect, $insertMessageQuery);

                    $finishQuery = "UPDATE queuing SET finish='1' WHERE id='$nowId'";
                    mysqli_query($connect, $finishQuery);
                }
            }

            System("clear");
            echo "Queuing System 작동 중\n";
            echo "건드리지 마시오...";
        }
    }
?>
