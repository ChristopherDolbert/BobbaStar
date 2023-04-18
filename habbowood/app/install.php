<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Install Habbowood!</title>
<? require ('config.php'); ?>
</head>

<body>
<? mysql_query("CREATE TABLE movies (
  id int(5) NOT NULL auto_increment,
  director varchar(25) NOT NULL,
  title varchar(50) NOT NULL,
  votes varchar(3) NOT NULL default '0',
  xml text NOT NULL,
  email varchar(50) NOT NULL,
  UNIQUE KEY id (id),
  UNIQUE KEY title (title)
)") or die(mysql_error());
?>
Installation complete. <a href="../index.html">Click here</a> to access your very own version of Habbowood!
</body>
</html>
