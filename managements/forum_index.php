<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");
$pagename = "Dépôt &raquo; Topics ou commentaires signalés";
$pageid = "forum_index";

if (!isset($_SESSION['username']) || $user['rank'] < 8 || $user['rank'] > 11) {
	Redirect("" . $url . "/managements/acces_interdit");
	exit();
}

$rank_modif = "";
switch ($user['rank']) {
	case 11:
	case 10:
	case 9:
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
						<h2 class="title" style="background-color:#00C100">Topics signalés</h2>
						<div class="box-content">
							<table>
								<tbody>
									<tr class="haut">
										<td class="haut">ID #</td>
										<td class="haut">Pseudo</td>
										<td class="haut">Catégorie</td>
										<td class="haut">Sujet</td>
										<td class="haut">Date</td>
										<td class="haut">Etat</td>
										<td class="haut">Dernière action</td>
										<td class="haut">Action</td>
									</tr>
									<?php
									$i = 0;
									$sql = $bdd->query("SELECT * FROM gabcms_forum_signalement WHERE value = 'topic' ORDER BY etat ASC, id DESC");
									$row = $sql->rowCount();
									while ($a = $sql->fetch()) {

										if ($a['etat'] == 0) {
											$etat_modif = "<span style=\"color:#FF4500\"><b>Signalé</b></span>";
										}
										if ($a['etat'] == 1) {
											$etat_modif = "<span style=\"color:#0000FF\"><b>Pris en charge</b></span>";
										}
										if ($a['etat'] == 2) {
											$etat_modif = "<span style=\"color:#008000\"><b>Traité</b></span>";
										}
										$topic = $bdd->query("SELECT * FROM gabcms_forum_topic WHERE id = '" . $a['id_topic'] . "'");
										$t = $topic->fetch();
										$categorie = $bdd->query("SELECT * FROM gabcms_forum_sous_categorie WHERE id = '" . $a['id_categorie'] . "'");
										$c = $categorie->fetch(PDO::FETCH_ASSOC);
									?>
										<tr class="bas">
											<td class="bas"><?PHP echo $a['id']; ?></td>
											<td class="bas"><?PHP echo Secu($a['signaler_par']); ?></td>
											<td class="bas"><?PHP echo Secu($c['nom']); ?></td>
											<td class="bas"><?PHP echo Secu($t['titre']); ?></td>
											<td class="bas"><?PHP echo Secu($a['signaler_le']); ?></td>
											<td class="bas"><?PHP echo $etat_modif; ?></td>
											<td class="bas"><?PHP echo Secu($a['action']); ?></td>
											<td class="bas"><?PHP if ($a['etat'] != '2') { ?><a href="<?PHP echo $url ?>/managements/forum_action?id=<?PHP echo $a['id'] ?>"><img src="<?PHP echo $url ?>/service_client/img/notes.png" style="height:35px;width:35px;" /></a><?PHP } ?></td>
										</tr><?PHP
											}
												?>
								</tbody>
							</table>
						</div>

					</div>
				</div>
				<script type="text/javascript">
					if (!$(document.body).hasClassName('process-template')) {
						Rounder.init();
					}
				</script>

				<div class="habblet-container" id="okt" style="float:left; width: 770px;">
					<div class="cbb clearfix darkred">
						<h2 class="title" style="background-color:#FF3E3E">Commentaires signalés</h2>
						<div class="box-content">
							<table>
								<tbody>
									<tr class="haut">
										<td class="haut">ID #</td>
										<td class="haut">Pseudo</td>
										<td class="haut">Commentaire de</td>
										<td class="haut">Date</td>
										<td class="haut">Etat</td>
										<td class="haut">Dernière action</td>
										<td class="haut">Action</td>
									</tr>
									<?php
									$i = 0;
									$sql = $bdd->query("SELECT * FROM gabcms_forum_signalement WHERE value = 'commentaire' ORDER BY etat ASC, id DESC");
									while ($a = $sql->fetch()) {
										if ($a['etat'] == 0) {
											$etat_modif = "<span style=\"color:#FF4500\"><b>Signalé</b></span>";
										}
										if ($a['etat'] == 1) {
											$etat_modif = "<span style=\"color:#0000FF\"><b>Pris en charge</b></span>";
										}
										if ($a['etat'] == 2) {
											$etat_modif = "<span style=\"color:#008000\"><b>Traité</b></span>";
										}

										$commentaires = $bdd->query("SELECT * FROM gabcms_forum_commentaires WHERE id = '" . $a['id_commentaire'] . "'");
										$com = $commentaires->fetch();
										$sqrl = $bdd->query("SELECT * FROM users WHERE id = '" . $com['user_id'] . "'");
										$assocr = $sqrl->fetch(PDO::FETCH_ASSOC);
									?>
										<tr class="bas">
											<td class="bas"><?PHP echo Secu($a['id']); ?></td>
											<td class="bas"><?PHP echo Secu($a['signaler_par']); ?></td>
											<td class="bas"><?PHP echo Secu($assocr['username']); ?></td>
											<td class="bas"><?PHP echo Secu($a['signaler_le']); ?></td>
											<td class="bas"><?PHP echo $etat_modif; ?></td>
											<td class="bas"><?PHP echo Secu($a['action']); ?></td>
											<td class="bas"><?PHP if ($a['etat'] != '2') { ?><a href="<?PHP echo $url ?>/managements/forum_action?id=<?PHP echo $a['id'] ?>"><img src="<?PHP echo $url ?>/service_client/img/notes.png" style="height:35px;width:35px;" /></a><?PHP } ?></td>
										</tr><?PHP
											}
												?>
								</tbody>
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