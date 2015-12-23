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

        $query = "SELECT * FROM player WHERE id = '$id';";
        $result = mysqli_query($connect, $query);
        $Return = $result->fetch_array();

        $xml = "<?xml version='1.0' encoding='UTF-8'?>";

        $xml .= "<login>";
        $xml .= "<id>".$Return['id']."</id>";

        if( strcmp($password, $Return['password']))
        {
            $loginresult = 0;
        }
        else
        {
            $loginresult = 1;
        }

        $xml .= "<loginresult>".$loginresult."</loginresult>";
        $xml .= "</login>";

        header('Content-type: text/xml');
        echo $xml;
    }
?>