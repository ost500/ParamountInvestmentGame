<?
$connect = mysql_connect("127.0.0.1", "root", "apmsetup");
mysql_selectdb("mapproject");
mysql_query("set names utf8");

$id = $_REQUEST[id];
$password = $_REQUEST[password];

$qry = "update member set password='$password' where id='$id';";
$result = mysql_query($qry);

$xmlcode = "<?xml version = \"1.0\" encoding = \"utf-8\"?>\n";
$xmlcode .= "<node>\n";
$xmlcode .= "<id>$id</id>\n";
$xmlcode .= "<result>$result</result>\n";
$xmlcode .= "</node>\n";

$dir = "C:/APM_Setup/htdocs/MapProject";
$filename = $dir."/change.xml";

file_put_contents($filename, $xmlcode);
?>