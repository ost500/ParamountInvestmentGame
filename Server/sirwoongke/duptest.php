<?
$connect = mysql_connect("127.0.0.1", "root", "apmsetup");
mysql_selectdb("mapproject");
mysql_query("set names utf8");

$id = $_REQUEST[id];

$qry = "select count(id) as countid from member where id='$id';";
$result = mysql_query($qry);

$xmlcode = "<?xml version = \"1.0\" encoding = \"utf-8\"?>\n";

while($obj = mysql_fetch_object($result))
{
	$dupresult = $obj->countid;

	$xmlcode .= "<node>\n";
	$xmlcode .= "<id>$id</id>\n";
	$xmlcode .= "<dupresult>$dupresult</dupresult>\n";
	$xmlcode .= "</node>\n";
}

$dir = "C:/APM_Setup/htdocs/MapProject";
$filename = $dir."/dupTest.xml";

file_put_contents($filename, $xmlcode);
?>