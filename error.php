<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("./config.php");
$pagename = "Erreur";
$pageid = "error";

if (!isset($_SESSION['username'])) {
	Redirect("./index");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<title><?PHP echo $sitename; ?> &raquo; <?PHP echo $pagename; ?></title>

	<script type="text/javascript">
		var andSoItBegins = (new Date()).getTime();
		var ad_keywords = "";
		document.habboLoggedIn = true;
		var habboName = "<?PHP echo $user['username']; ?>";
		var habboReqPath = "<?PHP echo $url; ?>";
		var habboStaticFilePath = "<?PHP echo $imagepath; ?>";
		var habboImagerUrl = "http://www.habbo.co.uk/habbo-imaging/";
		var habboPartner = "";
		var habboDefaultClientPopupUrl = "<?PHP echo $url; ?>/client";
		window.name = "habboMain";
		if (typeof HabboClient != "undefined") {
			HabboClient.windowName = "uberClientWnd";
		}
	</script>



	<link rel="shortcut icon" href="<?PHP echo $imagepath; ?>favicon.ico" type="image/vnd.microsoft.icon" />
	<script src="<?PHP echo $imagepath; ?>static/js/libs2.js" type="text/javascript"></script>
	<script src="<?PHP echo $imagepath; ?>static/js/visual.js" type="text/javascript"></script>
	<script src="<?PHP echo $imagepath; ?>static/js/libs.js" type="text/javascript"></script>
	<script src="<?PHP echo $imagepath; ?>static/js/common.js" type="text/javascript"></script>
	<script src="<?PHP echo $imagepath; ?>js/tooltip.js" type="text/javascript"></script>

	<script src="<?PHP echo $imagepath; ?>static/js/fullcontent.js" type="text/javascript"></script>
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/style.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/buttons.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/boxes.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/tooltips.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/personal.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
	<script src="<?PHP echo $imagepath; ?>static/js/habboclub.js" type="text/javascript"></script>
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/minimail.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/myhabbo/control.textarea.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
	<script src="<?PHP echo $imagepath; ?>static/js/minimail.js" type="text/javascript"></script>



	<meta name="description" content="<?PHP echo $description; ?>" />
	<meta name="keywords" content="<?PHP echo $keyword; ?>" />
	<!--[if IE 8]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/ie8.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
<![endif]-->
	<!--[if lt IE 8]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/ie.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
<![endif]-->
	<!--[if lt IE 7]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/ie6.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
<script src="<?PHP echo $imagepath; ?>static/js/pngfix.js" type="text/javascript"></script>
<script type="text/javascript">
try { document.execCommand('BackgroundImageCache', false, true); } catch(e) {}
</script>
 
<style type="text/css">
body { behavior: url(http://www.habbo.com/js/csshover.htc); }
</style>
<![endif]-->
	<meta name="build" content="<?PHP echo $build; ?> >> <?PHP echo $version; ?>" />
</head>

<body id="news" class=" ">
	<div id="tooltip"></div>
	<div id="overlay"></div>
	<!-- MENU -->
	<?PHP include("./template/header.php"); ?>
	<!-- FIN MENU -->


	<div id="container">
		<div id="content" style="position: relative" class="clearfix">
			<div id="column2" class="column">
				<div class="habblet-container ">
					<div class="cbb clearfix red ">

						<h2 class="title">Page introuvable!
						</h2>
						<div id="notfound-looking-for" class="box-content">
							<div style="float:left;"><img src="<?PHP echo $imagepath; ?>v2/images/error.gif" /></div>
							La page que tu recherche est inexistante. Si tu crois que c'est une erreur, contact imédiatement le service client de <b><?PHP echo $sitename; ?></b>: <span style="color: #0000ff;"><?PHP echo $mail; ?></span>.
							<br /><br />Bonne visite sur <?PHP echo $sitename; ?>!
							<br />
							<p style="float:right;">Cordialement, <?PHP echo $owner; ?></span>
						</div>


					</div>
				</div>
				<script type="text/javascript">
					if (!$(document.body).hasClassName('process-template')) {
						Rounder.init();
					}
				</script>

			</div>


			<!--[if lt IE 7]>
<script type="text/javascript">
Pngfix.doPngImageFix();
</script>
<![endif]-->
			<!-- FOOTER -->
			<?PHP include("./template/footer.php"); ?>
			<!-- FIN FOOTER -->