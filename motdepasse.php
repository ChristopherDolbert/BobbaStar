<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("./config.php");
$pagename = "Modifier mon mot de passe";
$pageid = "option";

if (!isset($_SESSION['username'])) {
	Redirect("" . $url . "/index");
}

if (isset($_GET['tab'])) {

	$tab = Secu($_GET['tab']);
	if ($tab == "password") {
		$mdpactuel = Secu($_POST['mdp_ac']);
		$mdpnew = Secu($_POST['mdp_new']);
		$mdpnewre = Secu($_POST['remdp_new']);
		$date = date('d/m/Y à H:i:s');
		$md5 = password_hash($mdpnew, PASSWORD_BCRYPT);

		if (password_verify($mdpactuel, $user['password'])) {
			if ($mdpnew == $mdpnewre) {
				if (strlen($mdpnew) < 6) {
					$result = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\">Ton mot de passe est trop court!</div> 
        </div> 
</div>";
				} else {
					if (strlen($mdpnew) > 25) {
						$result = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\">Ton mot de passe est trop long!</div> 
        </div> 
</div>";
					} else {
						$sql = $bdd->prepare("UPDATE users SET password = ? WHERE username = ?");
                        $sql->execute([$md5, $user['username']]);
						$result = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-green\"> 
              Ton nouveau mot de passe à bien été modifié, reconnecte-toi!
            </div> 
        </div> 
</div>";
					}
					if (!empty($_POST['envoimail'])) {
						$fichier_message = '<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bonjour ' . $user['username'] . ',</div>
<div>&nbsp;</div>
<div>Tu as désiré(e) que l&#39;on t&#39;envoie tes informations pour ton changement de mot de passe, voici tes informations :</div>
<div>&nbsp;</div>
<div><strong>Pseudo :</strong> ' . $user['username'] . '</div>
<div><strong>Nouveau mot de passe :</strong> ' . $mdpnew . '</div>
<div>&nbsp;</div>
<div>&nbsp;</div>
<div style="text-align: center;"><sub>Action réalisée le <span style="color:#FF0000">' . $date . '</span> avec l&#39;IP suivante : <span style="color:#FF0000">' . $_SERVER['REMOTE_ADDR'] . '</span></sub></div>
<div>&nbsp;</div><div style="text-align: right;">Cordialement, l&#39;équipe de ' . $sitename . '</div>'; //On ajoute les infos au message
						// On définit la liste des inscrits.
						$liste = $user['mail'];

						$message = $fichier_message;
						$destinataire = $liste;

						$objet = "Changement de mot de passe"; // On définit l'objet qui contient la date.

						// On définit le reste des paramètres.
						$headers  = "MIME-Version: 1.0 \r\n";
						$headers .= "Content-type: text/html; charset=iso-8859-1 \r\n";
						$headers .= "From: " . $mail . " \r\n"; // On définit l'expéditeur.

						// On envoie l'e-mail.
						mail($destinataire, $objet, $fichier_message, $headers);
					}
				}
			} else {
				$result = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\">Les mots de passe ne correspondent pas.</div> 
        </div> 
</div>";
			}
		} else {
			$result = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\">Le mot de passe actuel n'est pas celui-ci.</div> 
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
										<li>
											<a href="<?PHP echo $url; ?>/profile">Modification Général</a>
										</li>
										<li class="selected">Change ton Mot de Passe</a>
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

							<h2 class="title">Mot de Passe</h2>
							<div class="box-content">

								<form action="?tab=password" method="post" id="profileForm">
									<?PHP if (isset($result)) {
										echo $result;
									} ?>
									<h3>Changement de Mot de Passe</h3>
									<p> Ton mot de passe sera changé tout de suite après.</p>
									<p> <label>Mot de passe actuel:<br />
											<input type="password" name="mdp_ac" size="32" maxlength="32" value="" id="avatarmotto" title="Ton mot de passe actuel" placeholder="Mot de passe actuel" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" /></label> </p>
									<p> <label>Nouveau mot de passe:<br />
											<input type="password" name="mdp_new" size="32" maxlength="32" value="" id="avatarmotto" title="Ecris ton nouveau mot de passe" placeholder="Nouveau mot de passe" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" /></label> </p>
									<p> <label>Confirme ton nouveau mot de passe:<br />
											<input type="password" name="remdp_new" size="32" maxlength="32" value="" id="avatarmotto" title="Ecris à nouveau ton nouveau mot de passe" placeholder="Nouveau mot de passe" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" /></label> </p>
									<p> <label>Souhaites-tu recevoir un mail avec le nouveau mot de passe ?<br />
											<input type="checkbox" name="envoimail" value="1" /> Oui, je souhaite recevoir un mail avec mes identifiants.</label> </p>
									<div class="settings-buttons">
										<input type='submit' name='submit' value='Enregistrer'>
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