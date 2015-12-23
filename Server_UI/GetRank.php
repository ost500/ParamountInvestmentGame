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
        //$Name = $_GET['Name'];
        $query = "SELECT  id
                        ,total_money
                        ,(      SELECT  COUNT(*)
                                FROM    league_stat T2
                                WHERE   T2.total_money > T1.total_money
                                AND league_id = '$League_id') +1 Ranking
                    FROM    league_stat T1
                    WHERE league_id = '$League_id'
                    ORDER BY Ranking";
        $result = mysqli_query($connect, $query);
        $Return = $result->fetch_array();

        $xml = "<?xml version='1.0' encoding='UTF-8'?>";
        
        $xml .= "<Ranking>\n";
        $total_record = $result->num_rows;
        for($i = 0; $i < $total_record; $i ++){
            $result->data_seek($i);

            $row = $result->fetch_array();
            
            $xml .= "<id>".$row['id']."</id>\n";
            $xml .= "<total_money>".$row['total_money']."</total_money>\n";
            $xml .= "<Rank>".$row['Ranking']."</Rank>\n";
            $eachRank = $row['Ranking'];
            $eachID = $row['id'];
            $queryRankUp = "UPDATE league_stat
                            SET rank = '$eachRank'
                            WHERE id = '$eachID' AND league_id=$League_id;"; 
            mysqli_query($connect, $queryRankUp);
            
        }
        $xml .= "</Ranking>\n";
        header('Content-type: text/xml');
        echo $xml;

    }
?>