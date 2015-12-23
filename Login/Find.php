<?php

    $connect = mysqli_connect("localhost", "root", "soft2015","dbstock");

    if(mysqli_connect_errno())
    {
        printf("Connect failed : %s\n", mysqli_connect_errno());
        exit();
    }
    else
    {
        $mail = $_GET['mail'];
        $query = "SELECT * FROM player WHERE mail='$mail';";
        $result = mysqli_query($connect, $query);
        $Return = $result->fetch_array();

        $id = $Return['id'];

        $xml = "<?xml version='1.0' encoding='UTF-8'?>";
        $xml .= "<find>";
        $xml .= "<id>".$id."</id>";
        $xml .= "</find>";
        
        header('Content-type: text/xml');
        echo $xml;
    }
?>