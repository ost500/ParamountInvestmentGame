<?
$connect = mysql_connect("127.0.0.1", "root", "apmsetup");
mysql_selectdb("mapproject");
mysql_query("set names utf8");

$mail = $_REQUEST[mail];

$qry = "select * from member where mail='$mail';";
$result = mysql_query($qry);

$xmlcode = "<?xml version = \"1.0\" encoding = \"utf-8\"?>\n";

while($obj = mysql_fetch_object($result))
{
	$id = $obj->id;

	$xmlcode .= "<node>\n";
	$xmlcode .= "<id>$id</id>\n";
	$xmlcode .= "</node>\n";
}

$dir = "C:/APM_Setup/htdocs/MapProject";
$filename = $dir."/find.xml";

file_put_contents($filename, $xmlcode);
?>