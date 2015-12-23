<?
$connect = mysql_connect("127.0.0.1", "root", "apmsetup");
echo $connect;
$db = mysql_selectdb("mapproject");
echo $db;
mysql_query("set names utf8");

$qry = "select * from store;";
$result = mysql_query($qry);

$xmlcode = "<?xml version = \"1.0\" encoding = \"utf-8\"?>\n";

while($obj = mysql_fetch_object($result))
{
	$content = $obj->content;
	$name = $obj->name;
	$address = $obj->address;
	$number = $obj->number;
	$time = $obj->time;
	$latitude = $obj->latitude;
	$longitude = $obj->longitude;
	$addId = $obj->addId;

	$xmlcode .= "<node>\n";
	$xmlcode .= "<content>$content</content>\n";
	$xmlcode .= "<name>$name</name>\n";
	$xmlcode .= "<address>$address</address>\n";
	$xmlcode .= "<number>$number</number>\n";
	$xmlcode .= "<time>$time</time>\n";
	$xmlcode .= "<latitude>$latitude</latitude>\n";
	$xmlcode .= "<longitude>$longitude</longitude>\n";
	$xmlcode .= "<addId>$addId</addId>\n";
	$xmlcode .= "</node>\n";
}

$dir = "C:/APM_Setup/htdocs/MapProject";
$filename = $dir."/getStore.xml";

file_put_contents($filename, $xmlcode);
?>