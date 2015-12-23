<?
$connect = mysql_connect("127.0.0.1", "root", "apmsetup");
mysql_selectdb("mapproject");
mysql_query("set names utf8");

$name = $_REQUEST[name];
$address = $_REQUEST[address];

$qry = "select * from store where name='$name' and address='$address';";
$result = mysql_query($qry);

$xmlcode = "<?xml version = \"1.0\" encoding = \"utf-8\"?>\n";

while($obj = mysql_fetch_object($result))
{
	$number = $obj->number;
	$time = $obj->time;

	$xmlcode .= "<node>\n";
	$xmlcode .= "<number>$number</number>\n";
	$xmlcode .= "<time>$time</time>\n";
	$xmlcode .= "</node>\n";
}

$dir = "C:/APM_Setup/htdocs/MapProject";
$filename = $dir."/getStoreInfo.xml";

file_put_contents($filename, $xmlcode);
?>