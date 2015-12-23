<?php
    include '../Server_UI/GetRecentLeagueIdphp.php';
    $xmlstr = new SimpleXMLElement($League_id_xml);
    $League_id = $xmlstr->League_id; //개최되고 있는 리그 아이디를 받는다.

   $connect = mysqli_connect("localhost", "root", "soft2015","dbstock");

    if(mysqli_connect_errno())
    {
        printf("Connect failed : %s\n", mysqli_connect_errno());
        exit();
    }
    else
    {
        $player_id = $_GET["p_id"]; //플래이어 아이디
        $finace_name = $_GET["f_name"] ; //주식 이름
        $sell_count = $_GET["s_count"] ; //판 갯수
        $Ddate = date("Ymd"); // 날짜

	//CurStock 에서 amount 값만 내려주고 (id , stockname , amount )

	$query = " UPDATE CurStock set amount=amount-$sell_count where id='$player_id' AND stockname='$finace_name'; ";
	mysqli_query($connect, $query);


       
	//Log에 amount 를 -값으로 넣어주면 된다 ( insert into , delete)
	//Log(id, stockname, amount, price, date)
	$query = " INSERT INTO  Log (id , stockname, amount, price , date , league_id) 
 	VALUES ('$player_id' , '$finace_name' , -$sell_count ,(SELECT open FROM finace where name='$finace_name')  , '$Ddate' , '$League_id');";
	mysqli_query($connect, $query);


    $query = "UPDATE league_stat set cash = cash + $sell_count*(SELECT open from finace where name='$finace_name') 
                where id='$player_id' and league_id=$League_id;";
    mysqli_query($connect, $query); 
	
        //cash값 update해주면 된다.
    }
?>
