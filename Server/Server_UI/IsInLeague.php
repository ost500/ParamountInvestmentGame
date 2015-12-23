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
		 $ID = $_GET["id"];	

    	$queryLeagueCount=" SELECT count(id) AS cnt from league_stat where league_id ='$League_id'  AND id ='$ID'; ";
    	$result = mysqli_query($connect, $queryLeagueCount);

    	$Return_count= $result->fetch_array();
    	
    	

    	$xml = "<?xml version='1.0' encoding='UTF-8'?>";
        $xml .= "<isinleague>";
        $xml .= "<join>".$Return_count['cnt']."</join>";
        $xml .= "</isinleague>";
        header('Content-type: text/xml');
        echo $xml;

    }

 ?>