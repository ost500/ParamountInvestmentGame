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

        $query = "UPDATE player SET password='$password' WHERE id='$id';";
        $result = mysqli_query($connect, $query);

        $xml = "<?xml version='1.0' encoding='UTF-8'?>";
        $xml .= "<change>";
        $xml .= "<id>".$id."</id>";
        $xml .= "<result>".$result."</result>";
        $xml .= "</change>";
        header('Content-type: text/xml');
        echo $xml;
    }
?>