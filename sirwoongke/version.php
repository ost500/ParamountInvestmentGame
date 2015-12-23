<?
$connect = mysql_connect("127.0.0.1", "root", "apmsetup"); 
mysql_selectdb("mapproject");
mysql_query("set names utf8");

$qry = "select * from version;";
$result = mysql_query($qry);
 
$xmlcode = "<?xml version = \"1.0\" encoding = \"utf-8\" ?>\n";

while($obj = mysql_fetch_object($result))
{
	$api = $obj->api_name;
	$ver = $obj->ver;
 
	$xmlcode .= "<node>\n";
	$xmlcode .= "<api>$api</api>\n";
	$xmlcode .= "<ver>$ver</ver>\n";
	$xmlcode .= "</node>\n"; 
}
 
$dir = "C:/APM_Setup/htdocs/MapProject";
$filename = $dir."/version.xml";
file_put_contents($filename, $xmlcode);
?>
