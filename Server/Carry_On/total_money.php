<?php
    include '../Server_UI/GetRecentLeagueId.php';
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
            //플레이어의 이름을 다 받아온다
            $query = 'SELECT id FROM player;';
            $result = mysqli_query($connect, $query);

            $IDAndMoney = "";
            //player table 안에 player수 만큼 while문을 돌린다.
            //row 에는 모든 player 의 이름이 들어가 있다.
            while($row = $result->fetch_assoc())
            {
                $Sum_Value = 0;
                

            //$total_money= SELECT total_money FROM player WHERE id=

            //특정유저가 가지고 있는 보유 주식만큼 돌아서
            //현재 시가로 따져서 더해줘야 된다.

            //stock 에는 row에서 따온 이름으로 , 이름으로된 모든 주식을 가져온다.
                //echo $row['id'];
                $IDENTI = $row['id'];
                $queryStock = "SELECT stockname, amount 
                                FROM CurStock 
                                WHERE id= '$IDENTI' AND league_id = '$League_id'; ";
                $result2 = mysqli_query($connect, $queryStock);
                
                    while($row2 = $result2->fetch_assoc()){
                        //특정 소유자의 모든 주식을 가져온다 여기서
                        //stock에는 특정 소유자의 주식 이름이 들어 가 있다.
                        //echo $row2['stockname'], $row2['amount'];
                        $StockName = $row2['stockname'];
                        $Amount = $row2['amount'];

                        $open = "SELECT open FROM finace 
                                 WHERE name='$StockName';";
                        $result3 = mysqli_query($connect, $open);

                        $Return = $result3->fetch_array();
                        $Value_open = $Return['open'];
                        $Sum_Value += $Value_open * $Amount;
                            // total = total + (open * 소유하고 있는 주식 )
                    }
                $queryCash ="SELECT cash FROM league_stat 
                             WHERE id= '$IDENTI' AND league_id = '$League_id'; ";
                $result3 = mysqli_query($connect,$queryCash);
                $Return_Cash = $result3->fetch_array();
                $Value_Cash = $Return_Cash['cash'];

                $Sum_Value= $Sum_Value + $Value_Cash;

                

                $queryTotalUp ="UPDATE league_stat 
                                SET total_money = '$Sum_Value' 
                                WHERE id = '$IDENTI' AND league_id = '$League_id';";
                mysqli_query($connect,$queryTotalUp);


                $IDAndMoney .= $IDENTI." = ".$Sum_Value."\n";

            }
            sleep(1);
            System("clear");
            
            include '../Server_UI/GetRank.php';
            echo $IDAndMoney."League_id = ".$League_id."실행중 건드리지 마시오 ...";
        }
        

    }
?>