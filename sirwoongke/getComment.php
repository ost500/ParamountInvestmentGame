<?
$connect = mysql_connect("127.0.0.1", "root", "apmsetup"); 
mysql_selectdb("mapproject");
mysql_query("set names utf8");

$name = $_REQUEST[name];
$address = $_REQUEST[address];

/*
$qry = "SELECT comment, score FROM comment where name='$name' and address='$address';";
*/

$qry = "SELECT comment, score FROM store JOIN comment ON store.name=comment.name AND store.address=comment.address where comment.name='$name' and comment.address='$address';";

$result = mysql_query($qry);
 
$xmlcode = "<?xml version = \"1.0\" encoding = \"utf-8\" ?>\n";

while($obj = mysql_fetch_object($result))
{
	$comment = $obj->comment;
	$score = $obj->score;
 
	$xmlcode .= "<node>\n";
	$xmlcode .= "<comment>$comment</comment>\n";
	$xmlcode .= "<score>$score</score>\n";
	$xmlcode .= "</node>\n"; 
}

$dir = "C:/APM_Setup/htdocs/MapProject";
$filename = $dir."/comment.xml";

file_put_contents($filename, $xmlcode);
?>