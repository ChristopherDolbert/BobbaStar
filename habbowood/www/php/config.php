<?php
//ini_set("display_errors", 1);
error_reporting(0);

mysql_connect("sql.myhabbo.org","bbstrnt","Ae!71o79e");
mysql_select_db("bbstrnt");

$sql = mysql_query("SELECT * FROM users WHERE id = '".$_SESSION['id']."' ");
$userdata = mysql_fetch_assoc($sql);
?>