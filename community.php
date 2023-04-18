<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|

#|         Copyright © 2012-2015 - Gabodd Tout droits réservés.           #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("./config.php");
$pagename = "Communaut&eacute;";
$pageid = "communaute";

if (!isset($_SESSION['username'])) {
	Redirect("" . $url . "/index");
}

$sql = $bdd->query("SELECT * FROM gabcms_config WHERE id = '1'");
$cof = $sql->fetch(PDO::FETCH_ASSOC);
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

	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>static/styles/lightweightmepage.css" type="text/css" />
	<script src="<?PHP echo $imagepath; ?>static/js/lightweightmepage.js" type="text/javascript"></script>
	<script src="<?PHP echo $imagepath; ?>static/js/fullcontent.js" type="text/javascript"></script>
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/style.css" type="text/css" />
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/buttons.css" type="text/css" />
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/boxes.css" type="text/css" />
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/tooltips.css" type="text/css" />
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/personal.css" type="text/css" />

	<meta name="description" content="<?PHP echo $description; ?>" />
	<meta name="keywords" content="<?PHP echo $keyword; ?>" />
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
			<div id="column1" class="column">
				<div id="promo-box">
					<div id="promo-bullets"></div>
					<?PHP
					$sql = $bdd->query("SELECT * FROM gabcms_news ORDER BY -id LIMIT 0," . $cof['nb_news'] . "");
					$c = 0;
					while ($news = $sql->fetch()) {
						$c++;
					?>
						<div class="promo-container" style="<?php if ($c != 1) {
																echo "display: none; ";
															} ?> background-image: url(<?PHP echo $news['topstory_image']; ?>);">
							<div class="promo-content">
								<div class="title"><?PHP echo stripslashes($news['title']); ?></div>
								<div class="body"><?PHP echo stripslashes($news['snippet']); ?></div>

								<?PHP if ($news['event'] == 1) { ?><div class="promo-link-container">
										<div class="enter-hotel-btn">
											<div class="open enter-btn">
												<a style="padding: 0 8px 0 19px;" href="<?PHP echo $url ?>/articles?id=<?PHP echo $news['id']; ?>"><?PHP echo $news['info']; ?></a><b></b>

											</div>
										</div>
									</div><?PHP } ?>
								<?PHP if ($news['event'] == 2) { ?><div class="promo-link-container">
										<div class="enter-hotel-btn">
											<div class="open enter-btn">
												<a style="padding: 0 8px 0 19px;" href="<?PHP echo $news['lien_event']; ?>"><?PHP echo $news['info']; ?></a><b></b>

											</div>
										</div>
									</div><?PHP } ?>
							</div>
						</div>
					<?PHP } ?>
					<script type="text/javascript">
						document.observe("dom:loaded", function() {
							PromoSlideShow.init();
						});
					</script>
				</div>
				<script type="text/javascript">
					if (!$(document.body).hasClassName('process-template')) {
						Rounder.init();
					}
				</script>
			</div>
		</div>
		<div id="content" style="position: relative" class="clearfix">
			<div id="column1" class="column">
				<div class="habblet-container ">
					<div class="cbb clearfix blue">
						<h2 class="title">Le dernier inscrit</h2>

						<div class="box-content">
							<?PHP
							$sql = $bdd->query("SELECT * FROM users ORDER BY id DESC LIMIT 0,1");
							while ($s = $sql->fetch()) {

							?>
								<table width="111%" style="font-size: 11px;padding: 5px; margin-left: -15px; ?>">
									<tbody>
										<tr>
											<td valign="middle" width="10" height="60">
												<a href="<?PHP echo $url ?>/info?pseudo=<?PHP echo $s['username'] ?>" title="Aller sur son profil &raquo;" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)">
													<div style="width: 64px; height: 70px; margin-bottom:-10px; margin-top:-15px; margin-left: -15px; float: right; background: url(http://www.habbo.co.uk/habbo-imaging/avatarimage?figure=<?PHP echo Secu($s['look']); ?>&action=sit&direction=2&head_direction=3&gesture=sml&size=b&img_format=gif);"></div>
												</a>
											</td>
											<td valign="top">
												<span style="color:#2767A7;"><b style="font-size: 110%;"><?PHP echo Secu($s['username']) ?></b></span>
												<br />
												<span style="color:#888"><b>Mission :</b> <?PHP echo stripslashes(Secu($s['motto'])) ?></span><br />
												<span style="color:#888"><b>Dernière connexion :</b> <?PHP $connexion = date('d/m/Y H:i:s', $s['last_online']);
																										echo $connexion; ?></span><br />
												<?PHP echo (($s['online'] == "1") ? '<img src="' . $imagepath . 'v2/images/online.gif"></td>' : '<img src="' . $imagepath . 'v2/images/offline.gif"></td>') ?>
											</td>
										</tr>
									</tbody>
								</table>
							<?PHP } ?>
						</div>
					</div>
				</div>
			</div>
			<div id="column2" class="column">
				<div class="habblet-container ">
					<div class="cbb clearfix green ">
						<div class="box-content">
							<div style="float:left; margin: 3px 3px;display:block;"><img src="<?PHP echo $imagepath; ?>v2/images/logo_stats.png"></div>
							Nombre d&#39;inscrits:&nbsp;<strong><?php

																$req = "SELECT COUNT(*) AS id FROM users";
																$query = $bdd->query($req);

																$nb_inscrit = $query->fetch();
																echo $nb_inscrit['id'];

																?></strong><br />
							Nombre d'apparts:&nbsp;<strong><?php

															$req = "SELECT COUNT(*) AS id FROM rooms";
															$query = $bdd->query($req);

															$nb_inscrit = $query->fetch();
															echo $nb_inscrit['id'];

															?></strong><br />

							Nombre de bannis:&nbsp;<strong><?php

															$req = "SELECT COUNT(*) AS id FROM bans";
															$query = $bdd->query($req);

															$nb_inscrit = $query->fetch();
															echo $nb_inscrit['id'];

															?></strong>

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


	<div style="clear: both;"></div>
	<script type="text/javascript">
		HabboView.run();
	</script>
</body>

</html>