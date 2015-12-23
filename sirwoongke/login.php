<?
$connect = mysql_connect("127.0.0.1", "root", "apmsetup");
mysql_selectdb("mapproject");
mysql_query("set names utf8");

$id = $_REQUEST[id];
$password = $_REQUEST[password];

$qry = "select * from member where id='$id';";
$result = mysql_query($qry);

$xmlcode = "<?xml version = \"1.0\" encoding = \"utf-8\"?>\n";

while($obj = mysql_fetch_object($result))
{
	$id = $obj->id;
	$searchpassword = $obj->password;

	if( strcmp($password, $searchpassword) )
	{
		$loginresult = 0;
	}
	else
	{
		$loginresult = 1;
	}

	$xmlcode .= "<node>\n";
	$xmlcode .= "<id>$id</id>\n";
	$xmlcode .= "<loginresult>$loginresult</loginresult>\n";
	$xmlcode .= "</node>\n";
}

$dir = "C:/APM_Setup/htdocs/MapProject";
$filename = $dir."/login.xml";

file_put_contents($filename, $xmlcode);
?>