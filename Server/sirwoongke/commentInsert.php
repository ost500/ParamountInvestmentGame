<?
$connect = mysql_connect("127.0.0.1", "root", "apmsetup");
mysql_selectdb("mapproject");
mysql_query("set names utf8");

$name = $_REQUEST[name];
$address = $_REQUEST[address];
$comment = $_REQUEST[comment];
$score = $_REQUEST[score];
$addId = $_REQUEST[addId];

$qry = "insert into comment(name, address, comment, score, addId) values('$name', '$address', '$comment', '$score', '$addId');";
$result = mysql_query($qry);

$xmlcode = "<?xml version = \"1.0\" encoding = \"utf-8\"?>\n";
$xmlcode .= "<node>\n";
$xmlcode .= "<result>$result</result>\n";
$xmlcode .= "</node>\n";

$dir = "C:/APM_Setup/htdocs/MapProject";
$filename = $dir."/insertComment.xml";

file_put_contents($filename, $xmlcode);
?>