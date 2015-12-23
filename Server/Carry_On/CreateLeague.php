<?php

	include '/var/www/html/Server_UI/GetRecentLeagueIdphp.php';
    $xmlstr = new SimpleXMLElement($League_id_xml);
    $League_id = $xmlstr->League_id;


	$connect = mysqli_connect("localhost", "root", "soft2015","dbstock");

    if(mysqli_connect_errno()){
        printf("Connect failed : %s\n", mysqli_connect_errno());
        exit();
    }
    else
    {
		echo $League_id."YHOOOOOO";
		if($League_id==0)
		{


			$queryLeaguedate = "SELECT league_start_date, league_end_date, league_id
								FROM league 
								WHERE league_id = (SELECT MAX(league_id) FROM league)";
			$resultLeaguedate = mysqli_query($connect, $queryLeaguedate);
			$returnLeaguedate = $resultLeaguedate->fetch_assoc();


	    	$LEAGUE_ID =$returnLeaguedate['league_id'] +1;
	    	$LEAGUE_NAME =date("Y-m-d",strtotime("+0 days"))." "."league";
	    	$LEAGUE_START_DATE =date("Y-m-d",strtotime("+0 days"));
	    	$LEAGUE_END_DATE=date("Y-m-d",strtotime("+7 days"));

			// echo $LEAGUE_ID."\n";
			// echo $LEAGUE_NAME."\n";
			// echo $LEAGUE_START_DATE."\n";
			// echo $LEAGUE_END_DATE."\n";    	

			$queryLeagueCreate = "INSERT INTO league (league_id, league_name, league_start_date , league_end_date)
	    			VALUES ('$LEAGUE_ID' , '$LEAGUE_NAME', '$LEAGUE_START_DATE' , '$LEAGUE_END_DATE');";
	    	mysqli_query($connect , $queryLeagueCreate);

		}

    
    }

 ?>