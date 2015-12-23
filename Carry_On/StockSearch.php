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
        $query = "SELECT count(name) AS cnt FROM finace WHERE name='$Name'";
        $result = mysqli_query($connect, $query);
        $Return = $result->fetch_array();
        
        $cnt = $Return['cnt'];

        if( $cnt != '1')   //finace don't have
        {
            $query = "INSERT INTO finace(`name`) VALUES ('$Name');";
            $result = mysqli_query($connect, $query);
            sleep(3);
        }

        $query = "SELECT * FROM finace WHERE name='$Name'";
        $result = mysqli_query($connect, $query);
        $Return = $result->fetch_array();
        $stockName = $Return['name'];
        $open = $Return['open'];
        $high = $Return['high'];
        $low = $Return['low'];
        $close = $Return['close'];
        $volume = $Return['volume'];
        $Adj_close = $Return['Adj_close'];

        $xml = "<?xml version='1.0' encoding='UTF-8'?>";

        $xml .= "<SearchStock>\n";
        $xml .= "<name>".$stockName."</name>";
        $xml .= "<open>".$open."</open>";
        $xml .= "<high>".$high."</high>";
        $xml .= "<low>".$low."</low>";
        $xml .= "<close>".$close."</close>";
        $xml .= "<volume>".$volume."</volume>";
        $xml .= "<Adj_close>".$Adj_close."</Adj_close>";
        $xml .= "</SearchStock>\n";

        header('Content-type: text/xml');
        echo $xml;
    }
?>
