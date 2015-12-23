<?php

	$connect = mysqli_connect("localhost", "root", "soft2015","dbstock");

    if(mysqli_connect_errno()){
        printf("Connect failed : %s\n", mysqli_connect_errno());
        exit();
    }
    else
    {

    	$ID = $_GET["id"];	

		$query = "SELECT league.league_id AS leagueId, league.league_name AS leagueName, league_stat.rank AS rank, league_stat.total_money AS total_money, league_stat.cash AS cash FROM league_stat INNER JOIN league ON league_stat.league_id=league.league_id where id='$ID';";
		$result= mysqli_query($connect, $query);


		$xml = "<?xml version='1.0' encoding='UTF-8'?>";
		$xml .= "<eachleaguelog>";
		
		while($row=$result->fetch_assoc())
		{
			$xml .= "<league_id>".$row['leagueId']."</league_id>";
	        $xml .= "<rank>".$row['rank']."</rank>";
	        $xml .= "<league_name>".$row['leagueName']."</league_name>";
       		$xml .= "<total_money>".$row['total_money']."</total_money>";
       		$xml .= "<cash>".$row['cash']."</cash>";
		}
		$xml .= "</eachleaguelog>";
		header('Content-type: text/xml');
		echo $xml;
		  
		
    }
?>