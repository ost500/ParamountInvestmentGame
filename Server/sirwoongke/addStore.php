<?
$connect = mysql_connect("127.0.0.1", "root", "apmsetup");
mysql_selectdb("mapproject");
mysql_query("set names utf8");

$content = $_REQUEST[content];
$name = $_REQUEST[name];
$address = $_REQUEST[address];
$number = $_REQUEST[number];
$time = $_REQUEST[time];
$latitude = $_REQUEST[latitude];
$longitude = $_REQUEST[longitude];
$addId = $_REQUEST[addId];

$qry = "insert into store(content, name, address, number, time, latitude, longitude, addId) values('$content', '$name', '$address', '$number', '$time', '$latitude', '$longitude', '$addId');";
$result = mysql_query($qry);

$xmlcode = "<?xml version = \"1.0\" encoding = \"utf-8\"?>\n";
$xmlcode .= "<node>\n";
$xmlcode .= "<result>$result</result>\n";
$xmlcode .= "</node>\n";

$dir = "C:/APM_Setup/htdocs/MapProject";
$filename = $dir."/addStore.xml";

file_put_contents($filename, $xmlcode);
?>