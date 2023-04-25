<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("./config.php");
$pagename = "Tes informations";
$pageid = "info";

if (isset($_GET['pseudo'])) {
	$pseudo = Secu($_GET['pseudo']);
} else {
	$pseudo = $_SESSION['username'];
}
$sql = $bdd->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
$sql->execute([$pseudo]);

$row = $sql->rowCount();
if ($row > 0) {
	$pseudo = $sql->fetch(PDO::FETCH_ASSOC);
}

if (!isset($_SESSION['username'])) {
	Redirect($url . "/index");
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
	<script src="<?PHP echo $imagepath; ?>js/tooltip.js" type="text/javascript"></script>
	<script src="<?PHP echo $imagepath; ?>static/js/common.js" type="text/javascript"></script>
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>static/styles/lightweightmepage.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
	<script src="<?PHP echo $imagepath; ?>static/js/lightweightmepage.js" type="text/javascript"></script>
	<script src="<?PHP echo $imagepath; ?>static/js/fullcontent.js" type="text/javascript"></script>
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/style.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/buttons.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/boxes.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/tooltips.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/personal.css<?php echo '?' . mt_rand(); ?>" type="text/css" />

	<meta name="description" content="<?PHP echo $description; ?>" />
	<meta name="keywords" content="<?PHP echo $keyword; ?>" />
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
			<div id="column2" class="column">
				<div class="habblet-container ">
					<div class="cbb clearfix blue">

						<h2 class="title">Son porte-feuille
						</h2>
						<div id="notfound-looking-for" class="box-content">
							<div style="float:right; margin: -5px -5px;display:block;"><img src="<?PHP echo $imagepath; ?>v2/images/stats_icon.gif"></div>
							Nombre de credits :&nbsp;<strong><?php echo Secu($pseudo['credits']); ?></strong><br />
							Nombre de pixels :&nbsp;<strong><?php echo Secu($pseudo['pixels']); ?></strong><br />
							Nombre de jetons :&nbsp;<strong><?php echo Secu($pseudo['jetons']); ?></strong><br />
							<br /><br />
							Ces monnaies serviront à acheter des mobis, badges ou encore des bots.
						</div>


					</div>
				</div>
				<script type="text/javascript">
					if (!$(document.body).hasClassName('process-template')) {
						Rounder.init();
					}
				</script>
				<div id="column2" class="column">
					<div class="habblet-container ">
						<div class="cbb clearfix green">

							<h2 class="title">Recherche...
							</h2>
							<div id="notfound-looking-for" class="box-content">
								<form method="post" action="#">
									<td class='tbl'>
										<input style='width:97%' type="text" placeholder="Pseudo..." name="recherche_pseudo" value="<?php if (!empty($_POST["recherche_pseudo"])) {
																																		echo htmlspecialchars($_POST["recherche_pseudo"], ENT_QUOTES);
																																	} ?>" class="text" style="width: 240px" required><br /><br />
										<input style='width:100%' type="submit" value="Rechercher" />
								</form><br />
								<table>
									<tbody>
										<tr class="haut">
											<td class="haut">Résultats de recherche</td>
										</tr>
										<?php
										if (isset($_POST['recherche_pseudo'])) {
											$sql2 = $bdd->prepare("SELECT * FROM users WHERE username LIKE ? ORDER BY username ASC LIMIT 0,10");
											$sql2->execute(['%' . $_POST['recherche_pseudo'] . '%']);
											if ($sql2->rowCount() > 0) {
												while ($a = $sql2->fetch()) {
										?>
													<tr class="bas">
														<td class="bas">
															<div style="width: 30px; margin-top: -15px; margin-bottom: -15px; height: 30px; background: url(<?php echo $avatarimage; ?>&action=crr=667&direction=2&head_direction=3&gesture=sml&size=s&img_format=gif);"></div><a href="<?PHP echo $url; ?>/info?pseudo=<?PHP echo Secu($a['username']); ?>"><?PHP echo Secu($a['username']); ?></a>
							</div>
							</td>
							</tr>
										<?PHP  
										}
										} else { 
											echo "<tr class=\"bas\"><td class=\"bas\"><div style=\"width: 30px; margin-top: -15px; margin-bottom: -15px; height: 30px; background: url($avatarimage&action=crr=667&direction=2&head_direction=3&gesture=sml&size=s&img_format=gif);\"></div><a>Aucun utilisateur en base.</a></div></td></tr>"; 
										}
										} 
										?>
				</tbody>
				</table>
						</div>


					</div>
				</div>
			</div>
			<script type="text/javascript">
				if (!$(document.body).hasClassName('process-template')) {
					Rounder.init();
				}
			</script>

		</div>
		<?php
		if ($pseudo['rank'] == 1 && $pseudo['gender'] == "M") {
			$modif_info = "est un <b>utilisateur</b>";
		}
		if ($pseudo['rank'] == 2 && $pseudo['gender'] == "M") {
			$modif_info = "est <b>VIP</b>";
		}
		if ($pseudo['rank'] == 5 && $pseudo['gender'] == "M") {
			$modif_info = "est <b>modérateur</b>";
		}
		if ($pseudo['rank'] == 6 && $pseudo['gender'] == "M") {
			$modif_info = "est <b>administrateur</b>";
		}
		if ($pseudo['rank'] == 7 && $pseudo['gender'] == "M") {
			$modif_info = "est <b>manager</b>";
		}
		if ($pseudo['rank'] == 8 && $pseudo['gender'] == "M") {
			$modif_info = "est <b>fondateur</b>";
		}
		if ($pseudo['rank'] == 3 && $pseudo['gender'] == "M") {
			$modif_info = "est membre du <b>STAFF CLUB</b>";
		}
		if ($pseudo['rank'] == 1 && $pseudo['gender'] == "F") {
			$modif_info = "est une <b>utilisatrice</b>";
		}
		if ($pseudo['rank'] == 2 && $pseudo['gender'] == "F") {
			$modif_info = "est <b>VIP</b>";
		}
		if ($pseudo['rank'] == 3 && $pseudo['gender'] == "F") {
			$modif_info = "est membre du <b>STAFF CLUB</b>";
		}
		if ($pseudo['rank'] == 5 && $pseudo['gender'] == "F") {
			$modif_info = "est <b>modératrice</b>";
		}
		if ($pseudo['rank'] == 6 && $pseudo['gender'] == "F") {
			$modif_info = "est <b>administratrice</b>";
		}
		if ($pseudo['rank'] == 7 && $pseudo['gender'] == "F") {
			$modif_info = "est <b>manageuse</b>";
		}
		if ($pseudo['rank'] == 8 && $pseudo['gender'] == "F") {
			$modif_info = "est <b>fondatrice</b>";
		}
		$search = $bdd->prepare("SELECT * FROM bans WHERE user_id = ? OR ip = ?");
		$search->execute([$pseudo['id'], $pseudo['ip_current']]);
		$ok = $search->fetch();
		$stamp_now = time();
		$stamp_expire = $ok['ban_expire'];
		$expire = date('d/m/Y H:i', $ok['ban_expire']);
		?>
		<div id="column1" class="column">
			<div class="habblet-container ">
				<div class="cbb clearfix red ">

					<h2 class="title">Quelques infos sur son compte
					</h2>
					<div id="notfound-looking-for" class="box-content">
						<img style="float: left;" alt="<?PHP echo Secu($pseudo['username']); ?>" src="<?php echo $avatarimage; ?><?PHP echo Secu($pseudo['look']); ?>&action=crr=667&direction=2&head_direction=3&gesture=sml&size=big&img_format=gif" />
						<?PHP if ($pseudo['disabled'] == '1') { ?><b><span style="color:#FF0000;">
									<center>COMPTE DéSACTIVé</center>
								</span></b><?PHP } ?>
						<?PHP if ($stamp_now < $stamp_expire && $ok['value'] == $pseudo['username']) { ?><b><span style="color:#FF0000;">
									<center>COMPTE BANNI JUSQU'AU <?PHP echo $expire ?></center>
								</span></b><?PHP } ?>
						<b><span style="color: #0000ff;"><?PHP echo Secu($pseudo['username']); ?></span></b> est <?php if ($user['online'] == 1) {
																														echo '<span style="color: #008000;">connecté</span>';
																													} else {
																														echo '<span style="color: #ff0000;">déconnecté</span>';
																													} ?><br />

						Sa phrase perso : <b><span style="color: #0000ff;">
								<?PHP
								if (empty($pseudo['motto'])) {
									echo "Pas de mission";
								} else {
									echo Secu($pseudo['motto']);
								}
								?></b></span><br />
						<?PHP echo $pseudo['username']; ?> a crée son compte le <b><span style="color: #0000ff;"><?PHP $inscription = date('d/m/Y', $pseudo['account_created']);
																													echo $inscription; ?></b></span><br />
						Sa dernière connexion remonte au <b><span style="color: #0000ff;"><?PHP $connexion = date('d/m/Y', $pseudo['last_online']);
																							echo $connexion; ?></b></span><br /><br />

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

					<h2 class="title">Tous ses badges
					</h2>
					<div id="notfound-looking-for" class="box-content">
						<?php
						$userbadges = $bdd->prepare("SELECT DISTINCT * FROM users_badges WHERE user_id = ?");
						$userbadges->execute([$pseudo['id']]);
						if ($userbadges->rowCount() == 0) {
							echo "<center>Aucun badge</center>";
						}
						while ($userbadge = $userbadges->fetch()) {
						?>
							<tr>
								<td>
									<img title="<?php echo Secu($userbadge['badge_code']); ?>" src="<?PHP echo $swf_badge;
																									echo Secu($userbadge['badge_code']); ?>.gif" border="0" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
								</td>
							</tr>
						<?php
						}
						?>
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