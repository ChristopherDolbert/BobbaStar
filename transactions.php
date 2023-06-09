	<?PHP
	#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
	#|                                                                        #|
	#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
	#|																		  #|
	#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

	include("./config.php");
	$pageid = "transactions";
	$pagename = "Mes transactions";

	if (!isset($_SESSION['username'])) {
		Redirect("" . $url . "/index");
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
			var habboImagerUrl = "<?php echo $avatarimage ?>";
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
		<?PHP include("./template/header.php"); ?>
		<!-- FIN MENU -->
		<div id="container">
			<div id="content" style="position: relative" class="clearfix">
				<div id="column1" class="column">
					<div class="habblet-container" id="okt" style="float:left; width: 770px;">
						<div class="cbb clearfix brown ">

							<h2 class="title">Transactions de compte
							</h2>
							<div id="tx-log">
								<div class="box-content">
									<table class="tx-history">

										<thead>
											<tr>
												<th class="tx-description">Produit</th>
												<th class="tx-amount">Prix</th>
												<th class="tx-date">Date</th>
											</tr>
										</thead>

										<tbody>
											<?php
											$transac = $bdd->prepare("SELECT * FROM gabcms_transaction WHERE user_id = ? ORDER BY id DESC");
                                            $transac->execute([$user['id']]);
											while ($t = $transac->fetch()) {
												$modif_color = ($t['gain'] == '+') ? 'green' : (($t['gain'] == '-') ? 'red' : '');
											
											?>
												<tr class="bas">
													<td class="tx-description"><?PHP echo Secu($t['produit']); ?></td>
													<td class="tx-amount"><span style="color:<?PHP echo $modif_color; ?>"><b><?PHP echo Secu($t['gain']);
																																echo Secu($t['prix']); ?></b></span></td>
													<td class="tx-date"><?PHP echo Secu($t['date']); ?></td>
												</tr>
											<?PHP } ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<script type="text/javascript">
				if (!$(document.body).hasClassName('process-template')) {
					Rounder.init();
				}
			</script>
			<script type="text/javascript">
				HabboView.run();
			</script>

		</div>

	</body>

	</html>