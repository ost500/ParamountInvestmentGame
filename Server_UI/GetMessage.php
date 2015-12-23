<?php
    include './GetRecentLeagueIdphp.php';
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
        $deleteQuery = "DELETE FROM queuingMessage WHERE leagueId < '$League_id'";
        mysqli_query($connect, $deleteQuery);

        $Name = $_GET['Name'];
        $query = "SELECT * FROM queuingMessage WHERE userId='$Name' AND leagueId='$League_id'";
        $result = mysqli_query($connect, $query);
        $Return = $result->fetch_array();

        $xml = "<?xml version='1.0' encoding='UTF-8'?>";
        $xml .= "<message>\n";
        $total_record = $result->num_rows;
        for($i = 0; $i < $total_record; $i ++)
        {
            $result->data_seek($i);

            $row = $result->fetch_array();
            
            $xml .= "<userId>".$row['userId']."</userId>\n";
            $xml .= "<stockName>".$row['stockName']."</stockName>\n";
            $xml .= "<price>".$row['price']."</price>\n";
            $xml .= "<amount>".$row['amount']."</amount>\n";
            $xml .= "<dDate>".$row['dDate']."</dDate>\n";
            $xml .= "<value>".$row['value']."</value>\n";
            $xml .= "<buySell>".$row['buySell']."</buySell>\n";            
        }
        $xml .= "</message>\n";
        header('Content-type: text/xml');
        echo $xml;

        $oldDeleteQuery = "DELETE FROM queuingMessage WHERE userId='$Name' AND leagueId='$League_id'";
        mysqli_query($connect, $oldDeleteQuery);
    }
?>