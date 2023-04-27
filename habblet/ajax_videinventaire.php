<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");
$pagename = "Vider l'inventaire";
$pageid = "videinventaire";
$nowtime = time();

if (!isset($_SESSION['username'])) {
	Redirect("" . $url . "/index");
}

$sql = "SELECT count(*) FROM items WHERE user_id = ? AND room_id = ?";
$result = $bdd->prepare($sql);
$result->execute([$user['id'], 0]);
$number_of_rows = $result->fetchColumn();
$couleur = "";
$affichage = "";
$titre = "";

if ($number_of_rows != 0) {
	$idroom = 0;
	$loeschen = "DELETE FROM items WHERE room_id = :roomid AND user_id = :id";
	$loesch = $bdd->prepare($loeschen);
	$loesch->bindParam(':roomid', $idroom, PDO::PARAM_INT);
	$loesch->bindParam(':id', $user['id'], PDO::PARAM_INT);
	$loesch->execute();
	$titre = "Inventaire vidé";
	$couleur = "green";
	$affichage = "Ton inventaire a été vidé! Recharge l'h&ocirc;tel si les mobis sont toujours dans ton inventaire.";
} else {
	$titre = "Inventaire déjà vidé";
	$couleur = "red";
	$affichage = "Ton inventaire est déjà vide ! Reconnecte-toi au client si tu vois toujours tes mobis.";
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

<body id="home" class=" ">
	<div id="tooltip"></div>
	<div id="overlay"></div>

	<!-- MENU -->
	<?PHP include("../template/header.php"); ?>
	<!-- FIN MENU -->

	<div id="container">

		<div id="content" style="position: relative" class="clearfix">

			<div id="column1" class="column">
				<div class="habblet-container">
					<div class="cbb clearfix <?php echo htmlentities($couleur); ?> ">
						<h2 class="title"><?php echo htmlentities($titre); ?></h2>
						<div class="habblet box-content">
							<p id="collectibles-purchase">
								<?php echo htmlentities($affichage); ?>
							<div class="habblet-button-row clearfix"><a class="new-button" id="delete_hand" href="../videinventaire"><b>Retourner &agrave; l'inventaire</b><i></i></a></div>
							</p>
						</div>
					</div>
				</div>
				<script type="text/javascript">
					if (!$(document.body).hasClassName('process-template')) {
						Rounder.init();
					}
				</script>
			</div>

			<div id="column2" class="column">
				<div class="habblet-container ">
					<div class="cbb clearfix red ">
						<h2 class="title">Attention
						</h2>
						<div id="notfound-looking-for" class="box-content">
							Attention, si tu cliques sur "Vider l'inventaire" tout mobi sera effac&eacute;! Si tu aura cliqu&eacute; par erreur, o&ugrave; qu'il te restait un mobi dans ta main, nous ne pourrons pas le r&eacute;cup&eacute;rer et nous ne sommes pas responsable de votre perte.</b><br />
							<br /><img src="../web-gallery/images/frank/sorry.gif" alt="" width="57" height="88" />
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

</body>

</html>