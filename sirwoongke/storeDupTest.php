<?
$connect = mysql_connect("127.0.0.1", "root", "apmsetup");
mysql_selectdb("mapproject");
mysql_query("set names utf8");

$name = $_REQUEST[name];
$address = $_REQUEST[address];

$qry = "select count(name) as countName from store where name='$name' and address='$address';";

$result = mysql_query($qry);

$xmlcode = "<?xml version = \"1.0\" encoding = \"utf-8\"?>\n";

while($obj = mysql_fetch_object($result))
{
	$dupresult = $obj->countName;

	$xmlcode .= "<node>\n";
	$xmlcode .= "<name>$name</name>\n";
	$xmlcode .= "<dupresult>$dupresult</dupresult>\n";
	$xmlcode .= "</node>\n";
}

$dir = "C:/APM_Setup/htdocs/MapProject";
$filename = $dir."/storeDupTest.xml";

file_put_contents($filename, $xmlcode);
?>