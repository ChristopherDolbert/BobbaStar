<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("./template/global_ip.php");
$pagename = "Tu es banni";
$pageid = "banned";

$query = $bdd->prepare("SELECT * FROM bans WHERE value = :username");
$query->bindValue(':username', $username);
$query->execute();
$data = $query->fetch(PDO::FETCH_ASSOC);
$expire = date('d/m/Y H:i', $data['ban_expire']);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<title><?PHP echo $sitename; ?> &raquo; <?PHP echo $pagename; ?></title>

	<script type="text/javascript">
		var andSoItBegins = (new Date()).getTime();
		var ad_keywords = "";
		document.habboLoggedIn = false;
		var habboName = "null";
		var habboReqPath = "<?PHP echo $url; ?>";
		var habboStaticFilePath = "<?PHP echo $imagepath; ?>";
		var habboImagerUrl = "<?PHP echo $url; ?>/habbo-imaging/";
		var habboPartner = "";
		var habboDefaultClientPopupUrl = "<?PHP echo $url; ?>/client";
		window.name = "habboMain";
		if (typeof HabboClient != "undefined") {
			HabboClient.windowName = "uberClientWnd";
		}
	</script>



	<link rel="shortcut icon" href="<?PHP echo $imagepath; ?>favicon.ico" type="image/vnd.microsoft.icon" />


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

<script type="text/javascript">
	var andSoItBegins = (new Date()).getTime();
</script>

<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/process.css<?php echo '?' . mt_rand(); ?>" type="text/css" />

<script src="<?PHP echo $imagepath; ?>static/js/libs2.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath; ?>static/js/visual.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath; ?>static/js/libs.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath; ?>static/js/common.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath; ?>static/js/fullcontent.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath; ?>js/tooltip.js" type="text/javascript"></script>

<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/style.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/buttons.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/boxes.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/tooltips.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/changepassword.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/process.css<?php echo '?' . mt_rand(); ?>" type="text/css" />

<body id="intermediate" class="process-template">
	<div id="tooltip"></div>
	<div id="overlay"></div>

	<div id="container">
		<div class="cbb process-template-box clearfix">
			<div id="content" class="wide">


				<div id="header" class="clearfix">
					<h1><a href="<?PHP echo $url; ?>"></a></h1>
					<ul class="stats">

						<li class="stats-online">&nbsp;</li>
						<li class="stats-visited"><img src="<?PHP echo $imagepath; ?>v2/images/online.gif"></li>


					</ul>

				</div>
				<div id="process-content">
					<div id="terms" class="box-content">
						<div class="tos-header">
							<center>
								<size="+1"><b>Tu es exclu(e) de <?PHP echo $sitename; ?></b></size>
							</center>
						</div>
						<div class="tos-item"><br /><br />
							<p>

								Un <b>administrateur</b> (<?PHP echo $data['added_by']; ?>) a banni ton compte pour la raison suivante &laquo; <b><?PHP echo $data['reason']; ?></b> &raquo;.<br />
								Ton exclusion prendra fin le <b style="color: red"><?PHP echo $expire; ?></b>.<br />
								Si tu souhaites contester ton exclusion, envoie un email à l'adresse <b><?PHP echo $mail; ?></b>.
							</p>
						</div>
						<script type="text/javascript">
							if (typeof HabboView != "undefined") {
								HabboView.run();
							}
						</script>
						<!--[if lt IE 7]>
<script type="text/javascript">
Pngfix.doPngImageFix();
</script>
<![endif]-->


						<div style="clear: both;"></div>

					</div>
				</div>
			</div>



			<script type="text/javascript">
				HabboView.run();
			</script>
			<!-- FOOTER -->
			<?PHP include("./template/footer.php"); ?>
			<!-- FIN FOOTER -->
</body>

</html>