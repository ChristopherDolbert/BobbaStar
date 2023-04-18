<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|

#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
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
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>styles/local/com.css" type="text/css" />

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
				<script type="text/javascript">
					if (!$(document.body).hasClassName('process-template')) {
						Rounder.init();
					}
				</script>

				<div class="habblet-container ">
					<div class="cbb clearfix activehomes ">

						<h2 class="title">Quelques utilisateurs aléatoires...
						</h2>
						<div id="homes-habblet-list-container" class="habblet-list-container">
							<img class="active-habbo-imagemap" src="<?php echo $url; ?>/web-gallery/v2/images/activehomes/transparent_area.gif" width="435px" height="230px" usemap="#habbomap" />

							<?php
							$i = 0;
							$sql = $bdd->query("SELECT * FROM users ORDER BY RAND() LIMIT 18");
							while ($row = $sql->fetch()) {
								$i++;
								$list_id = $i - 1;

								if ($row["online"] == 1) {
									$status = "online";
								} else {
									$status = "offline";
								}

								$lang = "Créé le";

								printf("        <div id=\"active-habbo-data-%s\" class=\"active-habbo-data\">
                    <div class=\"active-habbo-data-container\">
                        <div class=\"active-name %s\">%s</div>
                        " . $lang . ": %s
                            <p class=\"moto\">%s</p>
                    </div>
                </div>
                <input type=\"hidden\" id=\"active-habbo-url-%s\" value=\"" . $url . "/home/%s\"/>
                <input type=\"hidden\" id=\"active-habbo-image-%s\" class=\"active-habbo-image\" value=\"" . "https://avatar.myhabbo.fr/?figure=" . $row["look"] . "\n\" />", $list_id, $status, $row[1], date('d/m/Y', $row['last_online']), "test", $list_id, $row[1], $list_id);
							}
							?>



							<div id="placeholder-container">
								<div id="active-habbo-image-placeholder-0" class="active-habbo-image-placeholder"></div>
								<div id="active-habbo-image-placeholder-1" class="active-habbo-image-placeholder"></div>
								<div id="active-habbo-image-placeholder-2" class="active-habbo-image-placeholder"></div>
								<div id="active-habbo-image-placeholder-3" class="active-habbo-image-placeholder"></div>
								<div id="active-habbo-image-placeholder-4" class="active-habbo-image-placeholder"></div>
								<div id="active-habbo-image-placeholder-5" class="active-habbo-image-placeholder"></div>
								<div id="active-habbo-image-placeholder-6" class="active-habbo-image-placeholder"></div>
								<div id="active-habbo-image-placeholder-7" class="active-habbo-image-placeholder"></div>
								<div id="active-habbo-image-placeholder-8" class="active-habbo-image-placeholder"></div>
								<div id="active-habbo-image-placeholder-9" class="active-habbo-image-placeholder"></div>
								<div id="active-habbo-image-placeholder-10" class="active-habbo-image-placeholder"></div>
								<div id="active-habbo-image-placeholder-11" class="active-habbo-image-placeholder"></div>
								<div id="active-habbo-image-placeholder-12" class="active-habbo-image-placeholder"></div>
								<div id="active-habbo-image-placeholder-13" class="active-habbo-image-placeholder"></div>
								<div id="active-habbo-image-placeholder-14" class="active-habbo-image-placeholder"></div>
								<div id="active-habbo-image-placeholder-15" class="active-habbo-image-placeholder"></div>
								<div id="active-habbo-image-placeholder-16" class="active-habbo-image-placeholder"></div>
								<div id="active-habbo-image-placeholder-17" class="active-habbo-image-placeholder"></div>
							</div>
						</div>

						<map id="habbomap" name="habbomap">
							<area id="imagemap-area-0" shape="rect" coords="55,53,95,103" href="#" alt="" />
							<area id="imagemap-area-1" shape="rect" coords="120,53,160,103" href="#" alt="" />
							<area id="imagemap-area-2" shape="rect" coords="185,53,225,103" href="#" alt="" />
							<area id="imagemap-area-3" shape="rect" coords="250,53,290,103" href="#" alt="" />
							<area id="imagemap-area-4" shape="rect" coords="315,53,355,103" href="#" alt="" />
							<area id="imagemap-area-5" shape="rect" coords="380,53,420,103" href="#" alt="" />
							<area id="imagemap-area-6" shape="rect" coords="28,103,68,153" href="#" alt="" />
							<area id="imagemap-area-7" shape="rect" coords="93,103,133,153" href="#" alt="" />
							<area id="imagemap-area-8" shape="rect" coords="158,103,198,153" href="#" alt="" />
							<area id="imagemap-area-9" shape="rect" coords="223,103,263,153" href="#" alt="" />
							<area id="imagemap-area-10" shape="rect" coords="288,103,328,153" href="#" alt="" />
							<area id="imagemap-area-11" shape="rect" coords="353,103,393,153" href="#" alt="" />
							<area id="imagemap-area-12" shape="rect" coords="55,153,95,203" href="#" alt="" />
							<area id="imagemap-area-13" shape="rect" coords="120,153,160,203" href="#" alt="" />
							<area id="imagemap-area-14" shape="rect" coords="185,153,225,203" href="#" alt="" />
							<area id="imagemap-area-15" shape="rect" coords="250,153,290,203" href="#" alt="" />
							<area id="imagemap-area-16" shape="rect" coords="315,153,355,203" href="#" alt="" />
							<area id="imagemap-area-17" shape="rect" coords="380,153,420,203" href="#" alt="" />
						</map>
						<script type="text/javascript">
							var activeHabbosHabblet = new ActiveHabbosHabblet();
							document.observe("dom:loaded", function() {
								activeHabbosHabblet.generateRandomImages();
							});
						</script>


					</div>
				</div>
				<script type="text/javascript">
					if (!$(document.body).hasClassName('process-template')) {
						Rounder.init();
					}
				</script>
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
		<script type="text/javascript">
			HabboView.run();
		</script>
</body>

</html>