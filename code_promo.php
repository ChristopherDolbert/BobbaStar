	<?PHP
	#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
	#|                                                                        #|
	#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
	#|																		  #|
	#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

	include("./config.php");
	$pagename = "Codes promos !";
	$pageid = "codepromo";

	if (!isset($_SESSION['username'])) {
		Redirect("" . $url . "/index");
	}

	if (isset($_GET['do'])) {
		$do = Secu($_GET['do']);
		if ($do == "code") {
			if (isset($_POST['code'])) {
				$code = Secu($_POST['code']);
				$sql = $bdd->prepare("SELECT * FROM gabcms_jetons WHERE code = :code AND nombremax != '0'");
				$sql->execute(array(':code' => $code));
				$row = $sql->rowCount();
				$c = $sql->fetch(PDO::FETCH_ASSOC);
				if ($row > 0) {
					if ($c['valid'] == '1') {
						$verif = $bdd->prepare("SELECT COUNT(*) AS nb FROM gabcms_jetons_logs WHERE code_id = :id AND user_id = :uid");
						$verif->execute(array(':id' => $c['id'], ':uid' => $user['id']));
						$sec_ver = $verif->fetch();
						if ($sec_ver['nb'] != "0") {
							$affichage = "<div id=\"purse-redeem-result\">
			<div class=\"redeem-error\">
				<div class=\"rounded rounded-red\">
					Ce code est utilisable une seule fois par personne.
				</div>
			</div>
	</div>";
						} else {
							$bdd->beginTransaction();
							try {
								$bdd->query("UPDATE users SET jetons = jetons + :value WHERE username = :username");
								$bdd->query("UPDATE gabcms_jetons SET nombremax = nombremax - 1 WHERE code = :code");
								$insertn1 = $bdd->prepare("INSERT INTO gabcms_transaction (user_id, produit, prix, gain, date) VALUES (:userid, :produit, :prix, :gain, :date)");
								$insertn1->execute(array(':userid' => $user['id'], ':produit' => 'Code jetons offert (' . $code . ')', ':prix' => $c['value'], ':gain' => '+', ':date' => FullDate('full')));
								$insertn2 = $bdd->prepare("INSERT INTO gabcms_jetons_logs (user_id, code_id, date) VALUES (:userid, :codeid, :date)");
								$insertn2->execute(array(':userid' => $user['id'], ':codeid' => $c['id'], ':date' => $nowtime));
								$bdd->commit();
								$affichage = "<div id=\"purse-redeem-result\">
			<div class=\"redeem-error\">
				<div class=\"rounded rounded-green\">
					Ton code jetons &agrave; été validé ! Tu as reçu <b>" . Secu($c['value']) . "</b> jetons.
				</div>
			</div>
	</div>";
							} catch (PDOException $e) {
								$bdd->rollback();
								throw $e;
							}
						}
					} elseif ($c['valid'] == "0") {
						$bdd->beginTransaction();
						try {
							$bdd->query("UPDATE users SET jetons = jetons + :value WHERE username = :username");
							$bdd->query("UPDATE gabcms_jetons SET nombremax = nombremax - 1 WHERE code = :code");
							$insertn1 = $bdd->prepare("INSERT INTO gabcms_transaction (user_id, produit, prix, gain, date) VALUES (:userid, :produit, :prix, :gain, :date)");
							$insertn1->execute(array(':userid' => $user['id'], ':produit' => 'Code jetons offert (' . $code . ')', ':prix' => $c['value'], ':gain' => '+', ':date' => FullDate('full')));
							$insertn2 = $bdd->prepare("INSERT INTO gabcms_jetons_logs (user_id, code_id, date) VALUES (:userid, :codeid, :date)");
							$insertn2->execute(array(':userid' => $user['id'], ':codeid' => $c['id'], ':date' => $nowtime));
							$bdd->commit();
							$affichage = "<div id=\"purse-redeem-result\">
			<div class=\"redeem-error\">
				<div class=\"rounded rounded-green\">
					Ton code jetons &agrave; été validé ! Tu as reçu <b>" . Secu($c['value']) . "</b> jetons.
				</div>
			</div>
	</div>";
						} catch (PDOException $e) {
							$bdd->rollback();
							throw $e;
						}
					}
				} else {
					$affichage = "<div id=\"purse-redeem-result\">
			<div class=\"redeem-error\">
				<div class=\"rounded rounded-red\">
					Ton code jetons est incorrect ou est déjà totalement épuisé.
				</div>
			</div>
	</div>";
				}
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
			<div id="content">
				<div id="column2" class="column">
					<div class="habblet-container">
						<div class="cbb clearfix blue">
							<h2 class="title">Informations</h2>
							<div class="box-content">
								<img src="<?PHP echo $imagepath; ?>v2/images/help.png" align="right" />
								Les codes promos sont des codes qui ne coûtent de l'argent à personne. Ils sont <b>offerts</b> par les <b>staffs de <?PHP echo $sitename; ?></b>. Ils peuvent être affichés de plusieurs manières (news, alerte sur l'hôtel, réseaux sociaux...).<br />
								Les <b>montants des codes peuvent variés</b> ainsi que le nombre d'utilisation, au désir du créateur du code.<br /><br />
								<img src="<?PHP echo $imagepath; ?>v2/images/attention.gif" /> Cependant attention, certains codes ne sont utilisables qu'une seule fois !
							</div>
						</div>
					</div>
					<script type="text/javascript">
						if (!$(document.body).hasClassName('process-template')) {
							Rounder.init();
						}
					</script>
					<div class="habblet-container">

						<div class="cbb clearfix green ">
							<h2 class='title'>Votre porte monnaie
							</h2>
							<div id="purse-habblet">
								<ul>
									<li class="even icon-purse">
										<div>Tu as actuellement:</div>
										<span class="purse-balance-amount"><?php echo $user['jetons']; ?> Jetons</span>
										<div class="purse-tx"><a href="jetons">Acheter des jetons</a></div>
									</li>
								</ul>
								<div id="purse-redeem-result">
								</div>
							</div>
						</div>
						<script type="text/javascript">
							new PurseHabblet();
						</script>
					</div>
					<script type="text/javascript">
						if (!$(document.body).hasClassName('process-template')) {
							Rounder.init();
						}
					</script>
				</div>
				<div id="column1" class="column">
					<div class="habblet-container">
						<div class="cbb clearfix yellow">
							<h2 class="title">Code promo</h2>
							<div class="box-content">
								<?PHP if (isset($affichage)) {
									echo "" . $affichage . "<br/>";
								} ?>
								<img src="<?PHP echo $imagepath; ?>v2/images/newcredits/fr_strike_best_value.png" align="left" />
								Tu as un code promo ? Tu souhaites savoir combien de jetons tu gagnes avec ce code ? N'attends pas plus ! Rempli la case ci-dessous :<br /><br />
								<form method="post" action="?do=code" id="vxoucher-form">
									Entre ton code jetons :
									<input type="text" name="code" value="" placeholder="XXXX-XXXX-XXXX-XXXX" id="purse-habblet-redeemcode-string" class="redeemcode" /><br /><br />
									<input type="image" src="<?PHP echo $imagepath; ?>v2/images/valider.png">
								</form>
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

		<script type="text/javascript">
			HabboView.run();
		</script>

	</body>

	</html>