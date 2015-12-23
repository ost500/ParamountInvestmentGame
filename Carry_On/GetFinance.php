#!/usr/bin/php -q
<?php

    function get_currency($from_currency, $to_currency)
    {
        $url = 'http://download.finance.yahoo.com/d/quotes.csv?s='.$from_currency.$to_currency.'=X&f=sl1d1t1c1ohgv&e=.csv';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $currency_csv = curl_exec($ch);
        curl_close ($ch);
 
        $csv_data = explode(',', $currency_csv);
        $currency_value = -1;
        if(sizeof($csv_data) == 9 && isset($csv_data[1]))
        {
            $currency_value = (float)$csv_data[1];
            $currency_value = number_format($currency_value,2, '.', '');
 
            // FIXME: Do Something
        }
        unset($csv_data); unset($currency_csv);
        return $currency_value;
    }

	$connect = mysqli_connect("localhost", "root", "soft2015","dbstock");

    if(mysqli_connect_errno()){
        printf("Connect failed : %s\n", mysqli_connect_errno());
        exit();
    }
    else
    {

        while(1)
        {

            
        $queryFinancelist = "SELECT name FROM finace;";
        $FinanceName ="";
        $resultList = mysqli_query($connect, $queryFinancelist);
            while($returnList = $resultList->fetch_assoc())
            {
                $FinanceName .= $returnList['name'].",";
            }
            
            //이름이 없는경우 삭제해준다.

          

                //echo $returnList['name'];
                //$FinanceName = $returnList['name'];
                $BASE_URL = "http://query.yahooapis.com/v1/public/yql";
                $yql_query = "select * from csv where url='http://download.finance.yahoo.com/d/quotes.csv?s=";
                $yql_query .= $FinanceName;
                $yql_query .="&f=sl1d1t1c1ohgv&e=.csv' and columns='symbol,price,date,time,change,col1,high,low,col2'";
                $yql_query_url = $BASE_URL . "?q=" . urlencode($yql_query) . "&format=xml";
                //환율
                
                //echo $yql_query_url."\n";
                
            $Currency = get_currency('USD','KRW');
                


            // $BASE_URL = "http://query.yahooapis.com/v1/public/yql";
            // $yql_query = "select * from csv where url='http://download.finance.yahoo.com/d/quotes.csv?s=005930.KS,YHOO,GOOG,IBM&f=sl1d1t1c1ohgv&e=.csv' and columns='symbol,price,date,time,change,col1,high,low,col2'";
            // $yql_query_url = $BASE_URL . "?q=" . urlencode($yql_query) . "&format=xml";
            // //환율
            //$currency_url = "http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.xchange%20where%20pair%20in%20(%22USDKRW%22)&format=xml&env=store://datatables.org/alltableswithkeys&callback=";


            // Make call with cURL
            
                //환율
                
                //echo $Currency."\n";


                
                $response = file_get_contents($yql_query_url);
                $object = simplexml_load_string($response);


                $results = $object->results;
                $row = $results->row;
                $SymbolAndOpen = "";
                foreach($row as $value){
                    
                    $symbol = $value->symbol;
                    $close = $value->col1;
                    $open = $value->price;
                    $high = $value->high;
                    $low = $value->low;
                    $volume = $value->col2;
                    $Adj_close = $value->change;
                    //print $close."currency non translated\n";
                    //환율 계산
                    if(strpos($symbol, ".KS") !== false)
                    {
                        
                        if($Currency == 0 || $Currency == NULL)
                        {
                            continue;
                        }
                        $close = round($close / $Currency, 2);
                        $open = round($open / $Currency, 2);
                        $high = round($high / $Currency, 2);
                        $low = round($low / $Currency, 2);
                        $Adj_close = round($Adj_close / $Currency, 2);
                        //echo $close."currency translated\n";
                                                
                    }
                    $SymbolAndOpen .= $symbol." = ".$open." ";
			         

                    if($open == 0 || $high == 0 || $low == 0 || $open == 'NULL' || $high == 'NULL' || $symbol =='')
                    {   
                        $SymbolAndOpen .= "DELETED\n";
                        $queryFinanceDel = "DELETE FROM finace WHERE name = '$symbol';";
                        mysqli_query($connect, $queryFinanceDel);
                    }
                    else
                    {
                        
                        $qry = "INSERT INTO finace(name,open,high,low,close,volume,Adj_close) VALUES('$symbol', '$open', '$high','$low','$close','$volume','$Adj_close');";
                        $result = mysqli_query($connect, $qry);
                        if($result == TRUE){
                            $SymbolAndOpen .= "INSERTED\n";
                            //echo "A record has been inserted.";
                        }
                        else {
                            $SymbolAndOpen .= "UPDATED\n";
                            $upqry = "UPDATE finace SET name = '$symbol', open = '$open', high = '$high', low = '$low', close = '$close', volume = '$volume', Adj_close ='$Adj_close' WHERE name = '$symbol';";
                            $result2 = mysqli_query($connect, $upqry);
                            //echo $result2."\n";
                        }    
                    }
                }
                    

                    

            

            
    		System("clear");
    		echo $SymbolAndOpen."실행중 건드리지 마시오...";	
                //echo "Keep going";
               
        

}

    }
?>
