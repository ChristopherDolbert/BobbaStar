<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");
$pagename = "Historique - Service client";
$pageid = "sc_index";

if (!isset($_SESSION['username']) || $user['rank'] < 5 || $user['rank'] > 11) {
	Redirect("" . $url . "/managements/acces_interdit");
	exit();
}

$rank_modif = "";
switch ($user['rank']) {
	case 11:
		$rank_modif = "fondateur";
		break;
	case 10:
		$rank_modif = "fondateur";
		break;
	case 9:
		$rank_modif = "fondateur";
		break;
	case 8:
		$rank_modif = "fondateur";
		break;
	case 7:
		$rank_modif = "manager";
		break;
	case 6:
		$rank_modif = "administratrice";
		if ($user['gender'] == 'M') {
			$rank_modif = "administrateur";
		}
		break;
	case 5:
		$rank_modif = "modératrice";
		if ($user['gender'] == 'M') {
			$rank_modif = "modérateur";
		}
		break;
}

$id = Secu($_GET['id']);
$infr = $bdd->query("SELECT * FROM gabcms_contact WHERE id = '" . $id . "'");
$r = $infr->fetch();
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
	<style>
		#raison {
			background-color: #cecece;
			-webkit-box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
			box-shadow: 0 1px 0 #fff, 0 2px 3px rgba(0, 0, 0, 0.5) inset;
			-webkit-border-radius: 5px;
			-moz-border-radius: 5px;
			border-radius: 5px;
			padding: 7px;
			text-shadow: rgba(255, 255, 255, 0.5) 0 1px 0;
		}

		#ticket {
			background-color: #FFFFFF;
			-webkit-box-shadow: 0 0 20px rgba(176, 196, 222, 0.5);
			box-shadow: 0 1px 0 #fff, 0 2px 3px rgba(176, 196, 222, 0.5) inset;
			-webkit-border-radius: 5px;
			-moz-border-radius: 5px;
			border-radius: 5px;
			padding: 7px;
			text-shadow: rgba(255, 255, 255, 0.5) 0 1px 0;
		}
	</style>
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

<body id="home">
	<div id="tooltip"></div>
	<div id="overlay"></div>
	<!-- MENU -->
	<?PHP include("../template/header.php"); ?>
	<!-- FIN MENU -->
	<div id="container">
		<div id="content" style="position: relative" class="clearfix">
			<div id="column1" class="column">
				<div class="habblet-container" id="okt" style="float:left; width: 770px;">
					<div class="cbb clearfix brown">
						<h2 class="title">Ticket #<?PHP echo $r['id']; ?></h2>
						<div class="box-content">
							<b>Voici les informations sur ce ticket :</b><br />
							Date de demande : <b><?PHP echo Secu($r['date']); ?></b><br />
							Pseudo du demandeur : <b><?PHP echo Secu($r['pseudo']); ?></b><br />
							Catégorie : <b><?PHP echo Secu($r['categorie']); ?></b><br />
							Email : <b><?PHP echo Secu($r['email']); ?></b><br />
							IP : <b><?PHP echo Secu($r['ip']); ?></b><br />
							Résolu par : <b><?PHP echo Secu($r['resul_par']); ?></b><br /><br />
							<?php
							$retour_messages = $bdd->query('SELECT * FROM gabcms_contact WHERE id = ' . $id . '');
							$etat_messages = array(
								0 => '<span style="color:#FF4500"><b>Signalé</b></span>',
								1 => '<span style="color:#4B0082"><b>En étude</b></span>',
								2 => '<span style="color:#FF0000"><b>Correction à faire</b></span>',
								3 => '<span style="color:#0000FF"><b>Attente réponse du joueur</b></span>',
								4 => '<span style="color:#8B4513"><b>Réponse donnée par le joueur</b></span>',
								5 => '<span style="color:#2E8B57"><b>En test</b></span>',
								6 => '<span style="color:#008000"><b>Fermé - Résolu</b></span>',
								7 => '<span style="color:#8bda20"><b>Fermé - déjà signalé/résolu</b></span>',
								8 => '<span style="color:#DAA520"><b>Fermé - sans suite</b></span>',
							);

							while ($t = $retour_messages->fetch()) {
								$etat_modif = isset($etat_messages[$t['resul']]) ? $etat_messages[$t['resul']] : '';
							?>
								<table width="100%">
									<tbody>
										<tr>
											<td valign="top">Sujet : <b><?= $t['sujet'] ?></b><br />
												<div id="ticket"><?= smileyforum(stripslashes($t['texte'])) ?></div><br />
												Historique :<br />
												<div id="raison">
													<?php
													$infe = $bdd->query("SELECT * FROM gabcms_contact_info WHERE contact_id = '" . $id . "'");
													if ($infe->rowCount() == 0) {
														echo "<i>Aucun historique, en attente d'affectation à un opérateur..</i>";
													}
													while ($rt = $infe->fetch()) {
														echo '<span style="color:#008000;">' . Secu($rt['date']) . '</span>' . smileyforum($rt['message']) . '<br />';
													}
													?>
												</div>
												<br />
												<?= $etat_modif ?>
											</td>
										</tr>
									</tbody>
								</table>
							<?php } ?>
							<br /><br /><br /><a href="<?PHP echo $url; ?>/managements/sc_traiter?id=<?PHP echo $id; ?>">Actions</a> - <a href="<?PHP echo $url; ?>/managements/sc_index">Revenir à l'accueil</a>
						</div>

					</div>
				</div>
			</div>
			<script type="text/javascript">
				if (!$(document.body).hasClassName('process-template')) {
					Rounder.init();
				}
			</script>
			<!--[if lt IE 7]>
<![endif]-->
			<!-- FOOTER -->
			<?PHP include("../template/footer.php"); ?>
			<!-- FIN FOOTER -->
			<div style="clear: both;"></div>
		</div>
	</div>
	<script type="text/javascript">
		HabboView.run();
	</script>
</body>

</html>