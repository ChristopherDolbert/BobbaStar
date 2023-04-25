<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("./config.php");
$pagename = "Infos";
$pageid = "infos";

if (!isset($_SESSION['username'])) {
	Redirect("" . $url . "/index");
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
		var habboImagerUrl = "<?php echo $avatarimage ?>";
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
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/newcredits.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
	<script src="<?PHP echo $imagepath; ?>static/js/minimail.js" type="text/javascript"></script>



	<meta name="description" content="<?PHP echo $description; ?>" />
	<meta name="keywords" content="<?PHP echo $keyword; ?>" />
	<!--[if IE 8]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>///v2/styles/ie8.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
<![endif]-->
	<!--[if lt IE 8]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>///v2/styles/ie.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
<![endif]-->
	<!--[if lt IE 7]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>///v2/styles/ie6.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
<script src="<?PHP echo $imagepath; ?>///static/js/pngfix.js" type="text/javascript"></script>
<script type="text/javascript">
try { document.execCommand('BackgroundImageCache', false, true); } catch(e) {}
</script>
 
<style type="text/css">
body { behavior: url(http://www.habbo.com/js/csshover.htc); }
</style>
<![endif]-->
	<meta name="build" content="<?PHP echo $build; ?> >> <?PHP echo $version; ?>" />
</head>



<body id="home">
	<div id="tooltip"></div>
	<div id="overlay"></div>
	<!-- MENU -->
	<?PHP include("./template/header.php"); ?>
	<!-- FIN MENU -->
	<div id="container">
		<div id="content" style="position: relative" class="clearfix">

			<div id="column2" class="column">
				<div class="habblet-container ">
					<div class="cbb clearfix green">
						<h2 class="title">Informations sur le CMS
						</h2>
						<div id="notfound-looking-for" class="box-content">
							<p><?php echo $sitename; ?> a repris <b>HoloCMS</b> et <b>GabCMS</b>, de manière à ne garder que le meilleur.</p>
							<table>
								<td width="10%"><img style="vertical-align:middle" src="./web-gallery/v2/images/place_2.gif" /></td>
								<td><b>Version PHP</b> : <?php echo phpversion(); ?></td>
							</table>
							<table>
								<td width="10%"><img style="vertical-align:middle" src="./web-gallery/v2/images/favourite_group_icon2.gif" /></td>
								<td><b>Version MariaDB</b> : 10.5.15</td>
							</table>
							<table>
								<td width="10%"><img style="vertical-align:middle" src="./web-gallery/v2/images/navi_gotohotelview_inactive.gif" /></td>
								<td><b>Version CMS</b> : <?php echo $version; ?></td>
							</table>
						</div>
					</div>
					<div class="cbb clearfix red">
						<h2 class="title">Special thanks to...</h2>
						<div id="notfound-looking-for" class="box-content">
							<table style="text-align:center">
								<td style="padding-left:15px;text-align:justify">
									<p><a target="_blank" href="https://github.com/brenoepics">BrenoEpic</a>, for the creation of our "Client UI" that blends entirely with the CMS while keeping the "modern" side.</p>
									<p><a style="text-decoration:underline">Meth0d (Roy)</a>, for its commitment, and especially for HoloCMS, one of the bases of MyHabbo which allowed us to start again, this good old design and its functionalities.</p>
									<p><a target="_blank" href="https://git.krews.org/explore">Arcturus Krews</a>, for their emulator that has always won us over since its launch.</p>
								</td>
							</table>
						</div>
					</div>
				</div>
				<script type="text/javascript">
					if (!$(document.body).hasClassName('process-template')) {
						Rounder.init();
					}
				</script>

			</div>

			<div id="column1" class="column">

				<div class="habblet-container ">
					<div class="cbb clearfix blue">
						<h2 class="title">Remerciements</h2>
						<div id="notfound-looking-for" class="box-content">
							<table style="text-align:center">
								<td><img src="./web-gallery/v2/images/hotel.png" alt="\" width="67\" height="118" /></td>
								<td style="padding-left:15px;text-align:justify">
									<p>Nous remercions du fond du <span style="color:red">❤</span> :</p>
									<p><a target="_blank" href="https://www.facebook.com/Gabcms">L'équipe de GabCMS</a> pour la création de toutes ces fonctionnalités uniques.</p>
									<p><a target="_blank" href="https://github.com/ayrtonbardiot">Ayrton</a> et <a target="_blank" href="https://inshare.fr/membre/10677-sailoreudes/">Chris</a> pour la refonte des requêtes en base de données et l'adaptation du CMS à la nextgen.</p>
									<p><a target="_blank" href="https://github.com/maximehery">Maxime</a> pour l'oeil neuf sur les versions "OldSchool" d'Habbo.</p>
									<p><a target="_blank" href="https://github.com/Chahine-tech">Chahine</a> pour la participation à l'élaboration du plan de relancement de MyHabbo.</p>
									<p><a target="_blank" href="https://inshare.fr/membre/9773-supra/">Erwan</a> et <a target="_blank" href="https://github.com/ayrtonbardiot">Ayrton</a> pour l'analyse des failles et la correction.</p>
								</td>
							</table>
						</div>
					</div>
				</div>

				<script type="text/javascript">
					if (!$(document.body).hasClassName('process-template')) {
						Rounder.init();
					}
				</script>
			</div>

		</div>
	</div>
	<!-- FOOTER -->
	<?PHP include("./template/footer.php"); ?>
	<!-- FIN FOOTER -->
</body>

</html>