<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|           GabCMS - Site Web et Content Management System               #|
#|         Copyright © 2012-2014 - Gabodd Tout droits réservés.           #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("./config.php");
$pagename = "Mes pr&eacute;f&eacute;rences";
$pageid = "option";

if (!isset($_SESSION['username'])) {
	Redirect("" . $url . "/index");
}

if (isset($_GET['tab'])) {
	$tab = Secu($_GET['tab']);
	if ($tab == "general") {

		$textamigo = Secu($_POST['textamigo']);
		$online = Secu($_POST['online']);
		$following = Secu($_POST['block_following']);
		//$motto = Secu($_POST['motto']);

		if ($following != "" && $online != "" && $textamigo != "" && $motto != "") {

			if (is_numeric($textamigo) && is_numeric($online) && is_numeric($following)) {



				if (!empty($_POST['envoimail'])) {
					$bdd->query("UPDATE users_settings SET block_friendrequests = '" . $textamigo . "', hide_online = '" . $online . "', block_following = '" . $following . "', newsletter = '1' WHERE user_id = '" . $_SESSION['id'] . "'");
				} else {
					$bdd->query("UPDATE users_settings SET block_friendrequests = '" . $textamigo . "', hide_online = '" . $online . "', block_following = '" . $following . "', newsletter = '0' WHERE user_id = '" . $_SESSION['id'] . "'");
				}

				$affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-green\"> 
               Modification r&eacute;ussie avec succ&egrave;s
            </div> 
        </div> 
</div>";
			} else {
				$affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
                Une erreur s'est produite lors de la modification.
            </div> 
        </div> 
</div>";
			}
		} else {

			$affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
                Merci de remplir les champs vides.
            </div> 
        </div> 
</div>";
		}
	}
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
		var habboImagerUrl = "http://www.habbo.com/habbo-imaging/";
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
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/style.css" type="text/css" />
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/buttons.css" type="text/css" />
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/boxes.css" type="text/css" />
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/tooltips.css" type="text/css" />
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/personal.css" type="text/css" />
	<script src="<?PHP echo $imagepath; ?>static/js/habboclub.js" type="text/javascript"></script>
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/minimail.css" type="text/css" />
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/myhabbo/control.textarea.css" type="text/css" />
	<script src="<?PHP echo $imagepath; ?>static/js/minimail.js" type="text/javascript"></script>
	<script src="<?PHP echo $imagepath; ?>static/js/settings.js" type="text/javascript"></script>
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/settings.css" type="text/css" />


	<meta name="description" content="<?PHP echo $description; ?>" />
	<meta name="keywords" content="<?PHP echo $keyword; ?>" />
	<!--[if IE 8]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/ie8.css" type="text/css" />
<![endif]-->
	<!--[if lt IE 8]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/ie.css" type="text/css" />
<![endif]-->
	<!--[if lt IE 7]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/ie6.css" type="text/css" />
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

<body id="home" class=" ">
	<div id="tooltip"></div>
	<div id="overlay"></div>
	<!-- MENU -->
	<?PHP include("./template/header.php"); ?>
	<!-- FIN MENU -->

	<div id="container">
		<div id="content" style="position: relative" class="clearfix">
			<div>

				<div class="content">
					<div class="habblet-container" style="float:left; width:210px;">
						<div class="cbb settings">

							<h2 class="title">Mes Préférences</h2>
							<div class="box-content">
								<div id="settingsNavigation">
									<ul>
										<li class="selected">Modifications générales
										</li>
										<li>
											<a href="<?PHP echo $url; ?>/motdepasse">Change ton mot de passe</a>
										</li>
										<li>
											<a href="<?PHP echo $url; ?>/profile_badges">Gestion des badges</a>
										</li>




									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="habblet-container " style="float:left; width: 560px;">
						<div class="cbb clearfix settings">

							<h2 class="title">Modifications générales</h2>
							<div class="box-content">

								<?PHP if (isset($affichage)) {
									echo $affichage . "<br/>";
								} ?>
								<form action="?tab=general" method="post" id="profileForm">
									<h3>Phrase d'humeur</h3>
									<p>
										<label><input type="text" name="motto" value="Blabla" class="text" style="width: 240px" maxlength="50"></label>
									</p>
									<h3>Textamigo</h3>
									<p>
										<label><input type="radio" name="textamigo" value="0" <?PHP if ($user['block_newfriends'] == "0") { ?> checked="checked" <?PHP } ?> />Accepter</label>
										<label><input type="radio" name="textamigo" value="1" <?PHP if ($user['block_newfriends'] == "1") { ?> checked="checked" <?PHP } ?> />Refuser</label>
									</p>

									<h3>Connexion</h3>
									<p>
										Choisis qui peut voir si tu es ou non connecté:<br />
										<label><input type="radio" name="online" value="1" <?PHP if ($user['hide_online'] == "1") { ?> checked="checked" <?PHP } ?> />Personne</label>
										<label><input type="radio" name="online" value="0" <?PHP if ($user['hide_online'] == "0") { ?> checked="checked" <?PHP } ?> />Tout le monde</label>
									</p>


									<h3>Préférences &quot;rejoindre&quot;</h3>
									<p>
										Choisis qui peut te suivre où que tu ailles:<br />
										<label><input type="radio" name="join" value="1" <?PHP if ($user['hide_inroom'] == "1") { ?> checked="checked" <?PHP } ?> />Personne</label>
										<label><input type="radio" name="join" value="0" <?PHP if ($user['hide_inroom'] == "0") { ?> checked="checked" <?PHP } ?> />Mes amis</label>
									</p>

									<h3>Newsletter</h3>
									<p>
										Choisis si tu veux recevoir les newsletters envoyées par le staff de l'hôtel.<br />
										<label><input type="checkbox" name="envoimail" value="1" <?PHP if ($user['newsletter'] == "1") { ?> checked="checked" <?PHP } ?> /> Oui, je souhaite recevoir les newsletters envoyées par <b><?PHP echo $sitename; ?></b><br /></label>
									</p>
									<div class="settings-buttons">
										<a href="#" class="new-button" style="display: none" id="profileForm-submit"><b>Enregistrer</b><i></i></a>
										<noscript><input type="submit" value="Enregistrer" name="save" class="submit" /></noscript>
									</div>

								</form>

								<script type="text/javascript">
									$("profileForm-submit").observe("click", function(e) {
										e.stop();
										$("profileForm").submit();
									});
									$("profileForm-submit").show();
								</script>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!--[if lt IE 7]>
<script type="text/javascript">
Pngfix.doPngImageFix();
</script>
<![endif]-->
		<!-- FOOTER -->
		<?PHP include("./template/footer.php"); ?>
		<!-- FIN FOOTER -->


		<div style="clear: both;"></div>


	</div>
	</div>
	</div>
	</div>

	<script type="text/javascript">
		HabboView.run();
	</script>
</body>

</html>