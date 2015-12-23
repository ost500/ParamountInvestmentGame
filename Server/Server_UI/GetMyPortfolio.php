<?php

    $connect = mysqli_connect("localhost", "root", "soft2015","dbstock");

    if(mysqli_connect_errno())
    {
        printf("Connect failed : %s\n", mysqli_connect_errno());
        exit();
    }
    else
    {
        $Name = $_GET['Name'];
        $League_Id = $_GET['league_id'];
        $querySwitch = $_GET['querySwitch'];

        if($querySwitch == 1)
        {
            $query = "SELECT CurStock.stockname AS stockname, CurStock.amount AS amount, finace.open AS open, CurStock.league_id AS leagueId
                    FROM CurStock
                    INNER JOIN finace ON CurStock.stockname = finace.name
                    WHERE CurStock.id =  '$Name' AND CurStock.league_id = '$League_Id'";
        }
        else
        {
            $query = "SELECT CurStock.stockname AS stockname, CurStock.amount AS amount, finace.open AS open, CurStock.league_id AS leagueId
                    FROM CurStock
                    INNER JOIN finace ON CurStock.stockname = finace.name
                    WHERE CurStock.id =  '$Name' AND CurStock.league_id = '$League_Id' AND amount <> 0";
        }
        
        $result = mysqli_query($connect, $query);
        

        $xml = "<?xml version='1.0' encoding='UTF-8'?>";
        
        $xml .= "<CurStock>\n";
        $total_record = $result->num_rows;
        for($i = 0; $i < $total_record; $i ++)
        {
            $result->data_seek($i);

            $row = $result->fetch_array();
            
            $xml .= "<stockname>".$row['stockname']."</stockname>\n";
            $xml .= "<amount>".$row['amount']."</amount>\n";
            $xml .= "<open>".$row['open']."</open>\n";
            $xml .= "<league_id>".$row['leagueId']."</league_id>\n";
            
            
        }
        $xml .= "</CurStock>\n";
        header('Content-type: text/xml');
        echo $xml;

    }
?>
