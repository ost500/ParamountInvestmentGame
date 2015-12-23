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
	$Stock = $_GET['Stock'];
	$query = "SELECT amount FROM CurStock WHERE id='$Name' and stockname='$Stock';";
        $result = mysqli_query($connect, $query);
        $Return = $result->fetch_array();
        $amount = $Return['amount'];

        $xml = "<?xml version='1.0' encoding='UTF-8'?>";
        $xml .= "<finace>";
        $xml .= "<name>".$Name."</name>";
        $xml .= "<amount>".$amount."</amount>";
        $xml .= "</finace>";
        header('Content-type: text/xml');
        echo $xml;
    }
?>
