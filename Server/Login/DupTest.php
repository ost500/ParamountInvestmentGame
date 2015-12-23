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
        $query = "SELECT count(id) as countid FROM player WHERE id='$id';";
        $result = mysqli_query($connect, $query);
        $Return = $result->fetch_array();
        
        $dupresult = $Return['countid'];

        $xml = "<?xml version='1.0' encoding='UTF-8'?>";
        $xml .= "<dup>";
        $xml .= "<id>".$id."</id>";
        $xml .= "<dupresult>".$dupresult."</dupresult>";
        $xml .= "</dup>";
        
        header('Content-type: text/xml');
        echo $xml;
    }
?>