<?php
	$connect = mysqli_connect("localhost", "root", "soft2015","dbstock");

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


    if(mysqli_connect_errno()){
        printf("Connect failed : %s\n", mysqli_connect_errno());
        exit();
    }
    else
    {
        
        $FinanceName = $_GET['Name'];
    
        
            //echo $returnList['name'];

        $BASE_URL = "http://query.yahooapis.com/v1/public/yql";
        $yql_query = "select * from csv where url='http://download.finance.yahoo.com/d/quotes.csv?s=";
        $yql_query .= $FinanceName;
        $yql_query .="&f=sl1d1t1c1ohgv&e=.csv' and columns='symbol,price,date,time,change,col1,high,low,col2'";
        $yql_query_url = $BASE_URL . "?q=" . urlencode($yql_query) . "&format=xml";
        //환율
        
        $Currency = get_currency('USD','KRW');
    

        $response = file_get_contents($yql_query_url);
        $object = simplexml_load_string($response);


        $results = $object->results;
        $row = $results->row;

        
        

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
                $close = round($close / $Currency, 2);
                $open = round($open / $Currency, 2);
                $high = round($high / $Currency, 2);
                $low = round($low / $Currency, 2);
                $Adj_close = round($Adj_close / $Currency, 2);
                //echo $close."currency translated\n";
            }

            $xml2 = "<?xml version='1.0' encoding='UTF-8'?>";
            $xml2 .= "<SearchStock>";
            $xml2 .= "<name>".$symbol."</name>";
            $xml2 .= "<open>".$open."</open>";
            $xml2 .= "<high>".$high."</high>";
            $xml2 .= "<low>".$low."</low>";
            $xml2 .= "<close>".$close."</close>";
            $xml2 .= "<volume>".$volume."</volume>";
            $xml2 .= "<Adj_close>".$Adj_close."</Adj_close>";
            $xml2 .= "</SearchStock>";
            header('Content-type: text/xml');
        
            echo $xml2;

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
                    //echo "A record has been inserted.";
                }
                else {
                    $upqry = "UPDATE finace SET name = '$symbol', open = '$open', high = '$high', low = '$low', close = '$close', volume = '$volume', Adj_close ='$Adj_close' WHERE name = '$symbol';";
                    $result2 = mysqli_query($connect, $upqry);
                    //echo $result2."\n";
                }
            }    
            
            //echo "Keep going";
        }

    }
?>