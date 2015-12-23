<?php
 
    include '/var/www/html/Server_UI/GetRecentLeagueIdphp.php';
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
        
        $name = $_GET["name"];
        $query = "INSERT INTO league_stat (league_id, id, rank,total_money,cash) 
                  VALUES ('$League_id', '$name', '0','0','10000');";
        $result = mysqli_query($connect, $query);
        echo $League_id;
 
    }
?>
