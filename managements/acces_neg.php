<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|           GabCMS - Site Web et Content Management System               #|
#|         Copyright © 2012-2014 - Gabodd Tout droits réservés.           #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");

if(!isset($_SESSION['username']))
	{ 
		Redirect("".$url."/index");
		exit();
	}
?>
<link href="./template/style.css" rel="stylesheet" type="text/css">
<meta http-equiv="content-type" content="text/html; charset=UTF-8" /><body>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<div class="content">
<img src="<?PHP echo $url; ?>/managements/img/images/attention.png" height="150px;" width="250px;" align="left" /><br/><br/><center><span style="color:#FF0000;"><b>Accès refusé</b></span></center>
<br/><br/>Bonjour,<br/><br/>Vous n'êtes pas autorisé à accéder à cette page, merci donc de charger une autre page.<br/><br/>Cordialement, la direction.
</div>
</body>
</html>