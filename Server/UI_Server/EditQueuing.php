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
        $id = $_GET['id'];
        $amount = $_GET['amount'];
        $sellBuy = $_GET['sellBuy'];
        $price = $_GET['price'];
        $minMax = $_GET['minMax'];

        $insertQuery = "UPDATE queuing SET amount='$amount', sellBuy='$sellBuy', price='$price', minMax='$minMax' WHERE id='$id'";

        $result = mysqli_query($connect, $insertQuery);
    }
?>