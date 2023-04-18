<?
//Database connection info
$db_server = "sql.myhabbo.org";
$db_name = "bbstrnt";
$db_username = "bbstrnt";
$db_password = "Ae!71o79e";

// DO NOT EDIT BELOW THIS LINE
mysql_connect($db_server, $db_username, $db_password) or die(mysql_error());
mysql_select_db($db_name) or die ("Database not found.");
?>