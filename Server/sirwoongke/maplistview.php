<?
$connect = mysql_connect("127.0.0.1", "root", "apmsetup"); 
mysql_selectdb("mapproject");
mysql_query("set names utf8");

$qry = "select * from store;";
$result = mysql_query($qry);
 
$xmlcode = "<?xml version = \"1.0\" encoding = \"utf-8\" ?>\n";

while($obj = mysql_fetch_object($result))
{
	$name = $obj->name;
	$content = $obj->content;
	$latitude = $obj->latitude;
	$longitude = $obj->longitude;
	$score = $obj->score;
 
	$xmlcode .= "<node>\n";
	$xmlcode .= "<name>$name</name>\n";
	$xmlcode .= "<content>$content</content>\n";
	$xmlcode .= "<latitude>$latitude</latitude>\n";
	$xmlcode .= "<longitude>$longitude</longitude>\n";
	$xmlcode .= "<score>$score</score>\n";
	$xmlcode .= "</node>\n"; 
}
 
$dir = "C:/APM_Setup/htdocs/MapProject";
$filename = $dir."/maplist.xml";
file_put_contents($filename, $xmlcode);
?>
