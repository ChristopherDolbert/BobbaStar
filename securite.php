<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

	include("./config.php");
	$pagename = "Sécurité";
	$pageid = "secu";
	
if(!isset($_SESSION['username']))
	{
		Redirect("".$url."/index.php");
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head> 
<meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
<title><?PHP echo $sitename;?> &raquo; <?PHP echo $pagename;?></title>
<link rel="shortcut icon" href="<?PHP echo $imagepath;?>favicon.ico" type="image/vnd.microsoft.icon" />
<script src="<?PHP echo $imagepath;?>js/tooltip.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/style.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
	<style>
		.img {
			width:500px;
			height:540px;
			margin-left:auto;
			margin-right:auto;
			display:none;
		}
		.prec {
			cursor:pointer;position:absolute;width:82px;height:35px;border:0px solid #fff;margin-top:480px;margin-left:40px;
		}
		.next {
			cursor:pointer;position:absolute;width:82px;height:35px;border:0px solid #fff;margin-top:480px;margin-left:390px;
		}
	</style>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script>
		function image(id) {
			$('.img').hide();
			$('#img'+id).show();
		}
	</script>
</head>
<body>
<div id="tooltip"></div>
	<div class="img" id="img1" style="background:url(web-gallery/v2/images/securite_img/1.png);display:block;">
		<div onclick="image(2);" style="cursor:pointer;position:absolute;width:82px;height:35px;border:0px solid #fff;margin-top:480px;margin-left:390px;"></div>
	</div>
	<div class="img" id="img2" style="background:url(web-gallery/v2/images/securite_img/2.png);">
		<div onclick="image(1);" class="prec"></div>
		<div onclick="image(3);" class="next"></div>
	</div>
	<div class="img" id="img3" style="background:url(web-gallery/v2/images/securite_img/3.png);">
		<div onclick="image(2);" class="prec"></div>
		<div onclick="image(4);" class="next"></div>
	</div>
	<div class="img" id="img4" style="background:url(web-gallery/v2/images/securite_img/4.png);">
		<div onclick="image(3);" class="prec"></div>
		<div onclick="image(5);" class="next"></div>
	</div>
	<div class="img" id="img5" style="background:url(web-gallery/v2/images/securite_img/5.png);">
		<div onclick="image(4);" class="prec"></div>
		<div onclick="image(6);" class="next"></div>
	</div>
	<div class="img" id="img6" style="background:url(web-gallery/v2/images/securite_img/6.png);">
		<div onclick="image(5);" class="prec"></div>
		<div onclick="image(7);" class="next"></div>
	</div>
	<div class="img" id="img7" style="background:url(web-gallery/v2/images/securite_img/7.png);">
		<div onclick="image(6);" class="prec"></div>
		<div onclick="image(8);" class="next"></div>
	</div>
	<div class="img" id="img8" style="background:url(web-gallery/v2/images/securite_img/8.png);">
		<div onclick="image(7);" class="prec"></div>
		<div onclick="window.location='<?PHP echo $url;?>/starter_room';" class="next"></div>
	</div>
	<!-- FOOTER -->
<?PHP include("./template/footer.php");?>
<!-- FIN FOOTER -->
</body>
</html>