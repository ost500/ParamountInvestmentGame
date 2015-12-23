<?php
    $connect = mysqli_connect("localhost", "root", "soft2015","dbstock");

    if(mysqli_connect_errno())
    {
        printf("Connect failed : %s\n", mysqli_connect_errno());
        exit();
    }
    else
    {
        $query = "SELECT * FROM finace";
        $result = mysqli_query($connect, $query);
        
        $xml = "<?xml version='1.0' encoding='UTF-8'?>";
        $xml .= "<Stock>\n";

        $total_record = $result->num_rows;

        for($i = 0; $i < $total_record; $i ++)
	{
            	$result->data_seek($i);

            	$row = $result->fetch_array();
            
		$xml .= "<name>".	$row['name'].	"</name>\n";
        	$xml .= "<open>".	$row['open'].	"</open>\n";
		$xml .= "<high>".	$row['high'].	"</high>\n";
		$xml .= "<low>".	$row['low'].	"</low>\n";
		$xml .= "<close>".	$row['close'].	"</close>\n";
		$xml .= "<volume>".	$row['volume'].	"</volume>\n";
		$xml .= "<Adj_close>".	$row['Adj_close']."</Adj_close>\n";
        }

        $xml .= "</Stock>\n";
        header('Content-type: text/xml');
        echo $xml;
    }
?>
