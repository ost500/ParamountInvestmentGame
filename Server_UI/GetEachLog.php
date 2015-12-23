<?php
	$connect = mysqli_connect("localhost", "root", "soft2015","dbstock");

    if(mysqli_connect_errno())
    {
        printf("Connect failed : %s\n", mysqli_connect_errno());
        exit();
    }
    else
    {
        $ID = $_GET["id"];
        $stockName = $_GET["stockName"];
        $League_id = $_GET["league_id"];

        $querySelect = "SELECT * FROM Log 
                        WHERE id = '$ID' 
                        AND stockname = '$stockName'
                        AND league_id = '$League_id';";

        $resultLog = mysqli_query($connect, $querySelect);
        
        $xml = "<?xml version='1.0' encoding='UTF-8'?>";
        
        $xml .= "<Log>\n";
        $total_record = $resultLog->num_rows;
        for($i = 0; $i < $total_record; $i ++){
            $resultLog->data_seek($i);

            $row = $resultLog->fetch_array();
            
            $xml .= "<id>".$row['id']."</id>\n";
            $xml .= "<stockname>".$row['stockname']."</stockname>\n";
            $xml .= "<amount>".$row['amount']."</amount>\n";
            $xml .= "<price>".$row['price']."</price>\n";
            $xml .= "<date>".$row['date']."</date>\n";
            $xml .= "<league_id>".$row['league_id']."</league_id>\n";
            
            
        }
        $xml .= "</Log>\n";
        header('Content-type: text/xml');
        echo $xml;
        


    }
?>