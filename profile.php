<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("./config.php");
$pagename = "Mes préférences";
$pageid = "option";

if (!isset($_SESSION['username'])) {
	Redirect($url . "/index");
}

$id = $user['id'];
$users_settings = $bdd->prepare("SELECT block_friendrequests, old_chat, block_roominvites, block_following FROM users_settings WHERE user_id = ? LIMIT 1");
$users_settings->execute([$id]);
$user_settings = $users_settings->fetch();

if (isset($_GET['tab'])) {
	$tab = Secu($_GET['tab']);
	if ($tab == "general") {

		$textamigo = Secu($_POST['textamigo']);
		$old_chat = Secu($_POST['old_chat']);
		$block_roominvites = Secu($_POST['block_roominvites']);
		$join = Secu($_POST['join']);

		// Personnalisation
		$topbg = Secu($_POST['topbg']);
		$bg = Secu($_POST['bg']);

		if ($textamigo != "" && $old_chat != "" && $block_roominvites != "" && $join != "") {

			if (is_numeric($textamigo) && is_numeric($block_roominvites) && is_numeric($join)) {
				if (!empty($_POST['envoimail'])) {
					$sql = $bdd->prepare("UPDATE users_settings SET block_friendrequests = ?, old_chat = ?, block_roominvites = ?, block_following = ? WHERE user_id = ? LIMIT 1");
                    $sql->execute([$textamigo, $old_chat, $block_roominvites, $join, $id]);

					$sql2 = $bdd->prepare("UPDATE users SET topbg = ?, bg = ? WHERE id = ? LIMIT 1");
                    $sql2->execute([$topbg, $bg, $id]);
				} else {
                    $sql = $bdd->prepare("UPDATE users_settings SET block_friendrequests = ?, old_chat = ?, block_roominvites = ?, block_following = ? WHERE user_id = ? LIMIT 1");
                    $sql->execute([$textamigo, $old_chat, $block_roominvites, $join, $id]);

					$sql2 = $bdd->prepare("UPDATE users SET topbg = ?, bg = ? WHERE id = ? LIMIT 1");
                    $sql2->execute([$topbg, $bg, $id]);
				}
				$affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-green\"> 
               Modification réussie avec succ&egrave;s
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
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/style.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/buttons.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/boxes.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/tooltips.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/personal.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
	<script src="<?PHP echo $imagepath; ?>static/js/habboclub.js" type="text/javascript"></script>
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/minimail.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/myhabbo/control.textarea.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
	<script src="<?PHP echo $imagepath; ?>static/js/minimail.js" type="text/javascript"></script>
	<script src="<?PHP echo $imagepath; ?>static/js/settings.js" type="text/javascript"></script>
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/settings.css<?php echo '?'.mt_rand(); ?>" type="text/css" />


	<meta name="description" content="<?PHP echo $description; ?>" />
	<meta name="keywords" content="<?PHP echo $keyword; ?>" />
	<!--[if IE 8]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/ie8.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<![endif]-->
	<!--[if lt IE 8]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/ie.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<![endif]-->
	<!--[if lt IE 7]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/ie6.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
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
									<h3>Ancien chat</h3>
									<p>
										Choisis entre l'ancien et le nouveau chat:<br />
										<label><input type="radio" name="old_chat" value="1" <?PHP if ($user_settings['old_chat'] == "1") { ?> checked="checked" <?PHP } ?> />Ancien</label>
										<label><input type="radio" name="old_chat" value="0" <?PHP if ($user_settings['old_chat'] == "0") { ?> checked="checked" <?PHP } ?> />Nouveau</label>
									</p>

									<h3>Textamigo</h3>
									<p>
										<label><input type="radio" name="textamigo" value="0" <?PHP if ($user_settings['block_friendrequests'] == "0") { ?> checked="checked" <?PHP } ?> />Accepter</label>
										<label><input type="radio" name="textamigo" value="1" <?PHP if ($user_settings['block_friendrequests'] == "1") { ?> checked="checked" <?PHP } ?> />Refuser</label>
									</p>

									<h3>Invitation d'appart</h3>
									<p>
										Choisis qui peut t'inviter dans un appart:<br />
										<label><input type="radio" name="block_roominvites" value="1" <?PHP if ($user_settings['block_roominvites'] == "1") { ?> checked="checked" <?PHP } ?> />Personne</label>
										<label><input type="radio" name="block_roominvites" value="0" <?PHP if ($user_settings['block_roominvites'] == "0") { ?> checked="checked" <?PHP } ?> />Tout le monde</label>
									</p>


									<h3>Préférences &quot;rejoindre&quot;</h3>
									<p>
										Choisis qui peut te suivre où que tu ailles:<br />
										<label><input type="radio" name="join" value="1" <?PHP if ($user_settings['block_following'] == "1") { ?> checked="checked" <?PHP } ?> />Personne</label>
										<label><input type="radio" name="join" value="0" <?PHP if ($user_settings['block_following'] == "0") { ?> checked="checked" <?PHP } ?> />Mes amis</label>
									</p>


									<h3>Personnalisations</h3>
									<p> <label>En-tête:<br /><input type="text" name="topbg" value="<?php echo $user['topbg']; ?>" id="topbg" title="URL de l'en-tête" placeholder="URL de l'en-tête" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" /></label> </p>
									<p> <label>Fond:<br /><input type="text" name="bg" value="<?php echo $user['bg']; ?>" id="topbg" title="URL du fond" placeholder="URL du fond" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" /></label> </p>
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