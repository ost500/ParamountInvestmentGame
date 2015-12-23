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
        $Name = $_GET['Name'];
        $query = "SELECT * FROM queuing WHERE userID='$Name' AND leagueId='$League_id' AND finish='0';";
        $result = mysqli_query($connect, $query);

        $xml = "<?xml version='1.0' encoding='UTF-8'?>";
        $xml .= "<queuing>";

        $total_record = $result->num_rows;
        for($i=0 ; $i < $total_record ; $i++)
        {
            $result->data_seek($i);
            $Return = $result->fetch_array();

            $xml .= "<id>".$Return['id']."</id>";
            $xml .= "<userID>".$Return['userId']."</userID>";
            $xml .= "<stockName>".$Return['stockName']."</stockName>";
            $xml .= "<leagueId>".$Return['leagueId']."</leagueId>";
            $xml .= "<amount>".$Return['amount']."</amount>";
            $xml .= "<sellBuy>".$Return['sellBuy']."</sellBuy>";
            $xml .= "<price>".$Return['price']."</price>";
            $xml .= "<userOption>".$Return['userOption']."</userOption>";
            $xml .= "<limitAmount>".$Return['limitAmount']."</limitAmount>";
            $xml .= "<minMax>".$Return['minMax']."</minMax>";
        }

        $xml .= "</queuing>";
        header('Content-type: text/xml');
        echo $xml;
    }
?>
