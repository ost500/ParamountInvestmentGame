<?php
	$connect = mysqli_connect("localhost", "root", "soft2015","dbstock");

    if(mysqli_connect_errno()){
        printf("Connect failed : %s\n", mysqli_connect_errno());
        exit();
    }
    else
    {
		$queryLeaguedate = "SELECT league_start_date, league_end_date, league_id
							FROM league 
							WHERE league_id = (SELECT MAX(league_id) FROM league)";
		$resultLeaguedate = mysqli_query($connect, $queryLeaguedate);
		$returnLeaguedate = $resultLeaguedate->fetch_assoc();
		//echo $returnLeaguedate['league_start_date'], $returnLeaguedate['league_end_date'];


		$today = strtotime(date("Ymd"));
		$startDay = strtotime($returnLeaguedate['league_start_date']) - $today;
		$endDay = strtotime($returnLeaguedate['league_end_date']) - $today;

		//echo $today."\n".strtotime($returnLeaguedate['league_start_date'])."\n".strtotime($returnLeaguedate['league_end_date']);

		$isLeaguein = 0;
		if($startDay <= 0 && $endDay >= 0) 
		{
			//echo "리그 참여 중";
			$isLeaguein = 1;
		}
		$League_id_xml = "<?xml version='1.0' encoding='UTF-8'?>";
       	$League_id_xml .= "<isLeaguein>";
       	
		if($isLeaguein == 1)
		{
			$League_id_xml .= "<League_id>".$returnLeaguedate['league_id']."</League_id>";
		}
		else
		{
			$League_id_xml .= "<League_id>"."0"."</League_id>";
		}
		$League_id_xml .= "</isLeaguein>\n";

        header('Content-type: text/League_id_xml');
        echo $League_id_xml;

	}
?>