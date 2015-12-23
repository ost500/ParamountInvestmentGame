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
        $query = "SELECT open FROM finace where name = '$Name';";
        $result = mysqli_query($connect, $query);
        $Return = $result->fetch_array();
        $openValue = $Return['open'];

        $xml = "<?xml version='1.0' encoding='UTF-8'?>";
        $xml .= "<finace>";
        $xml .= "<name>".$Name."</name>";
        $xml .= "<open>".$openValue."</open>";
        $xml .= "</finace>";
        header('Content-type: text/xml');
        echo $xml;
    }
?>