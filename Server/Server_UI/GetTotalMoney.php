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
        $query = "SELECT total_money FROM league_stat 
                    WHERE id = '$Name' AND league_id = '$League_id';";
        $result = mysqli_query($connect, $query);
        $Return = $result->fetch_array();
        $totalValue = $Return['total_money'];

        $xml = "<?xml version='1.0' encoding='UTF-8'?>";
        $xml .= "<player>";
        $xml .= "<id>".$Name."</id>";
        $xml .= "<total>".$totalValue."</total>";
        $xml .= "</player>";
        header('Content-type: text/xml');
        echo $xml;
    }
?>
