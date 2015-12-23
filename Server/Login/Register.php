<?php

    $connect = mysqli_connect("localhost", "root", "soft2015","dbstock");

    if(mysqli_connect_errno())
    {
        printf("Connect failed : %s\n", mysqli_connect_errno());
        exit();
    }
    else
    {
        $id = $_GET['id'];
        $password = $_GET['password'];
        $mail = $_GET['mail'];

        $query = "INSERT INTO player(id, password, mail) VALUES('$id', '$password', '$mail');";
        $result = mysqli_query($connect, $query);

        $xml = "<?xml version='1.0' encoding='UTF-8'?>";
        $xml .= "<register>";
        $xml .= "<id>".$id."</id>";
        $xml .= "<result>".$result."</result>";
        $xml .= "</register>";
        header('Content-type: text/xml');
        echo $xml;
    }
?>
