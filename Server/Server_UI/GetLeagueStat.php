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
        
        
        $queryLeague = "SELECT *
                    FROM league
                    WHERE league_id = '$League_id';";

        $queryNumpeople = "SELECT count(*) AS numpeople
                            FROM league_stat
                            WHERE league_id = '$League_id';";

        $result = mysqli_query($connect, $queryLeague);
        $resultNumpeople = mysqli_query($connect, $queryNumpeople);

        
        $row = $result->fetch_array();
        $rowNum = $resultNumpeople->fetch_array();


        $xml = "<?xml version='1.0' encoding='UTF-8'?>";
        $xml .= "<league>\n";
        $xml .= "<league_name>".$row['league_name']."</league_name>\n";
        $xml .= "<numpeople>".$rowNum['numpeople']."</numpeople>\n";
        $xml .= "<league_start_date>".$row['league_start_date']."</league_start_date>\n";
        $xml .= "<league_end_date>".$row['league_end_date']."</league_end_date>\n";
        
        $xml .= "</league>\n";
        header('Content-type: text/xml');
        echo $xml;
       

    }
?>