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
        $ID = $_GET["id"];
        $P_NAME = $_GET["p_name"];
        $P_AMOUNT = $_GET["p_amount"];
        //$A_LEAGUE_IDD = $_GET["p_league_id"];

        echo $League_id;

        $querySelect = "SELECT open FROM finace WHERE name = '$P_NAME';";
        $resultSelect = mysqli_query($connect, $querySelect);
        $Return = $resultSelect->fetch_array();
        $priceValue = $Return['open'];
        //echo $priceValue;

        $queryThereis = "SELECT count(id) AS cnt FROM CurStock 
                            WHERE id = '$ID' 
                            AND stockname = '$P_NAME'
                            AND league_id ='$League_id';";
        $resultThereis = mysqli_query($connect, $queryThereis);
        $ReturnThereis = $resultThereis->fetch_array();
        $ThereisValue = $ReturnThereis['cnt'];
        //echo $ThereisValue;

        if($ThereisValue > 0)//있으면 UPDATE
        {
            $query = "UPDATE CurStock 
                        SET amount = amount + '$P_AMOUNT'
                        WHERE id = '$ID' 
                        AND stockname = '$P_NAME'
                        AND league_id ='$League_id';";
            $result = mysqli_query($connect, $query);
        }
        else //없으면 insert
        {
            $query = "INSERT INTO CurStock (id, stockname, amount,league_id) 
                        VALUES ('$ID', '$P_NAME', '$P_AMOUNT','$League_id');";
            $result = mysqli_query($connect, $query);
        }

        $RealValue = $priceValue * $P_AMOUNT;

        $queryUp = "UPDATE league_stat SET cash = cash-'$RealValue' 
                    WHERE id = '$ID'
                    AND league_id = '$League_id';";
        $resultUp = mysqli_query($connect, $queryUp);
        //Log
        $Ddate = date("Ymd");
        $queryLog = "INSERT INTO Log (id, stockname, amount, price, date,league_id)
                        VALUES ('$ID', '$P_NAME', '$P_AMOUNT', 
                            (SELECT open FROM finace WHERE name='$P_NAME'), '$Ddate','$League_id');";
        mysqli_query($connect, $queryLog);

    }
?>