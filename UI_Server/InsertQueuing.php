<?php
    
    include '../Server_UI/GetRecentLeagueIdphp.php';
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
        $userId = $_GET['userId'];
        $stockName = $_GET['stockName'];
        $amount = $_GET['amount'];
        $sellBuy = $_GET['sellBuy'];
        $price = $_GET['price'];
        $minMax = $_GET['minMax'];

        $insertQuery = "INSERT INTO `dbstock`.`queuing` (`id`, `userId`, `stockName`, `leagueId`, `amount`, `sellBuy`, `price`, `minMax`, `finish`) 
                                VALUES ('NULL', '$userId', '$stockName', '$League_id', '$amount', '$sellBuy', '$price', '$minMax', '0');";

        echo $insertQuery;

        $result = mysqli_query($connect, $insertQuery);
    }
?>