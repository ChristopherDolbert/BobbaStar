<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("./config.php");
$pagename = "Mobis";
$pageid = "shopfurnis";

if (!isset($_SESSION['username'])) {
	Redirect("" . $url . "/index");
}

$search = $_POST['search'];
$category = Secu($_GET['category']);
if ($category == "") {
	$category = 1;
}
$page = Secu($_GET['page']);
if ($page == "" || $page < 1) {
	$page = 1;
}
$page = $page - 1;

$userrow = $bdd->prepare("SELECT rank FROM users WHERE id = :id LIMIT 1");
$userrow->bindValue(':id', $_SESSION['id']);
$userrow->execute();
$rank = $userrow['rank'];

if (isset($_POST['quantity']) == true) {
	$quantity = Secu($_POST['quantity']);
	if (is_numeric($quantity) == false) {
		$quantity = 1;
	}
	$boughtid = Secu($_POST['furniID']);

	$furnirow = $bdd->prepare("SELECT * FROM catalog_items WHERE id = :id LIMIT 1");
	$furnirow->bindValue(':id', $boughtid);
	$price = $furnirow['cost_credits'] * $quantity;

	$furnicat = $bdd->prepare("SELECT min_rank FROM catalog_pages WHERE parent_id = :parent_id LIMIT 1");
	$furnicat->bindValue(':parent_id', $furnirow['id']);

	if ($furnicat['minrank'] <= $user_rank) {
		if ($price <= $myrow['credits']) {
			$reqCredits = $bdd->prepare("UPDATE users SET credits = credits - " . $price . " WHERE id='" . $my_id . "' LIMIT 1");
			$reqCredits->execute([$price, $_SESSION['id']]);
			$i = 0;
			while ($i < $quantity) {
				$i++;
				$insertn2 = $bdd->prepare("INSERT INTO items (user_id, room_id, prix, gain, date) VALUES (:userid, :room_id, :item_id)");
				$insertn2->bindValue(':userid', $_SESSION['id']);
				$insertn2->bindValue(':room_id', 0);
				$insertn2->bindValue(':item_id', $boughtid);
				$insertn2->execute();
			}

			$insertn1 = $bdd->prepare("INSERT INTO gabcms_transaction (user_id, produit, prix, gain, date) VALUES (:userid, :produit, :prix, :gain, :date)");
			$insertn1->bindValue(':userid', $_SESSION['id']);
			$insertn1->bindValue(':produit', 'Achat de' . $quantity . $furnirow['catalogue_name']);
			$insertn1->bindValue(':prix', $price);
			$insertn1->bindValue(':gain', '-');
			$insertn1->bindValue(':date', FullDate('full'));
			$insertn1->execute();

			// katsjing sound
			@SendMUSData('UPRC' . $_SESSION['id']);
			// reload hand
			@SendMUSData('UPRH' . $_SESSION['id']);
			// Now we say in a message he has the furniture!
			$text = "Tu as bien achet&eacute; " . $quantity . " " . $furnirow['catalogue_name'] . ".";
			$color = "green";
		} else {
			$text = "Tu n'as pas assez de cr&eacute;dits pour acheter ceci.";
			$color = "red";
		}
	} else {
		$text = "Tu n'as pas assez de cr&eacute;dits pour acheter ceci.";
		$color = "red";
	}
}

?><script src="web-gallery/static/js/shop_furni.js" type="text/javascript"></script><?php
																					$pagessql = $bdd->prepare("SELECT * FROM catalog_pages WHERE min_rank <= :minrank ORDER BY parent_id ASC");
																					$pagessql->bindValue(':minrank', $rank);
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

	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>static/styles/lightweightmepage.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
	<script src="<?PHP echo $imagepath; ?>static/js/lightweightmepage.js" type="text/javascript"></script>
	<script src="<?PHP echo $imagepath; ?>static/js/fullcontent.js" type="text/javascript"></script>
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/style.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/buttons.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/boxes.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/tooltips.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>styles/local/com.css<?php echo '?' . mt_rand(); ?>" type="text/css" />

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
		<div id="content" style="position: relative; left: 0px; top: 0px;" class="clearfix">

			<div class="column" style="width: 212px">
				<div class="habblet-container ">
					<div class="cbb clearfix blue ">
						<h2 class="title">Chercher</h2>
						<div id="credits-safety" class="box-content credits-info">
							<div style="text-align: center">
								<form action="./shopfurnis.php" method="post">
									<input type="text" name="search" value="" />
									<input type="submit" value="Chercher" class="submit" id="submit-button" />
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="habblet-container ">

					<div class="cbb clearfix blue ">

						<h2 class="title">Cat&eacute;gories</h2>
						<div id="credits-safety" class="box-content credits-info">
							<div class="credit-info-text clearfix">
								<?php
								while ($row = $pagessql->fetch()) {
									if ($category == $row['indexid']) {
										echo "<strong>" . $row['displayname'] . "</strong><br />\n";
									} else {
										echo "<a href=\"./shopfurnis.php?category=" . $row['indexid'] . "\">" . $row['displayname'] . "</a><br />\n";
									}
								}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="column" style="width: 527px">
				<?php if (isset($text)) { ?>
					<div class="rounded rounded-<?php echo $color; ?>">
						<?php echo $text; ?>
					</div>
				<?php } ?>
				<div class="habblet-container ">
					<div class="cbb clearfix notitle ">

						<?php if ($search == "") { ?>
							<?php if ($category == 1) { ?>
								<div id="credits-safety" class="box-content credits-info">
									<div class="credit-info-text clearfix">
										<center>
											<br /><img src="./web-gallery/images/catalogue/headers/Frontpage.gif" />
											<br />S&eacute;l&eacute;ctionne une cat&eacute;gorie &agrave; gauche pour acheter des mobis!
										</center>
									</div>
								</div>
							<?php } else { ?>
								<div id="credits-safety" class="box-content credits-info">
									<div class="credit-info-text clearfix">
										<center>
											<?php
											$currentcat = $bdd->prepare("SELECT caption FROM catalog_pages WHERE parent_id = :parentid LIMIT 1");
											$currentcat->bindValue(':parentid', $category);
											$catname = $currentcat['caption'];
											?>
											<img src="./web-gallery/images/catalogue/headers/<?php echo $catname; ?>.gif" />
										</center>
										<?php
										$sql = $bdd->prepare("SELECT * FROM catalog_items WHERE page_id = :pageid ORDER BY catalogue_name ASC LIMIT 20 OFFSET " . $page * 20);
										$sql->bindValue(':pageid', $category);
										$i = 0;
										while ($row = $sql->fetch()) {
											$i++;
											if (IsEven($i)) {
												$even = "even";
											} else {
												$even = "odd";
											}		?>
											<li class="<?php echo $even; ?>">
												<table style="width: 100%">
													<tr align="center">
														<td style="width: 25%"><img src="./web-gallery/images/catalogue/<?php echo $row['picture']; ?>" /></td>
														<td style="width: 35%"><b><?php echo $row['catalogue_name']; ?></b><br /><?php echo $row['catalogue_description']; ?></td>
														<td style="width: 15%"><?php echo $row['catalogue_cost']; ?></td>
														<td style="width: 25%">
															<a class="new-button fill" onclick="habboclub.buttonClick(<?php echo $row['tid']; ?>,'Confirm Purchase'); return false;" href="#"><b>Acheter</b><i></i></a>
														</td>
													</tr>
												</table>
											</li>
										<?php }

										$sql = $bdd->prepare("SELECT * FROM catalog_items WHERE page_id = :pageid");
										$sql->bindValue(':pageid', $category);
										$numofitems = mysql_num_rows($sql);
										$pages = ceil($numofitems / 20);
										$i = 1;
										?><center><?php
													while ($i <= $pages) {
														if ($i == $pages) {
															if ($page + 1 == $i) {
																echo "<strong>" . $i . "</strong>";
															} else {
																echo "<a href=\"./shopfurnis.php?category=" . $category . "&page=" . $i . "\">" . $i . "</a>";
															}
														} else {
															if ($page + 1 == $i) {
																echo "<strong>" . $i . "</strong> | ";
															} else {
																echo "<a href=\"./shopfurnis.php?category=" . $category . "&page=" . $i . "\">" . $i . "</a> | ";
															}
														}
														$i++;
													} ?></center>
									</div>
								<?php } ?>
							<?php } else { #Search 
							?>
								<div id="credits-safety" class="box-content credits-info">
									<div class="credit-info-text clearfix">
										<?php
										$sql = $bdd->query("SELECT * FROM catalog_items,catalog_pages WHERE catalog_items.catalog_id_page = catalog_pages.id AND (catalogue_name LIKE '%" . $search . "%') AND min_rank <= '" . $rank . "' LIMIT 2");
										$i = 0;
										while ($row = $sql->fetch()) {
											$i++;
											if (IsEven($i)) {
												$even = "even";
											} else {
												$even = "odd";
											}		?>
											<li class="<?php echo $even; ?>">
												<table style="width: 100%">
													<tr align="center">
														<td style="width: 25%"><img src="./web-gallery/images/catalogue/<?php echo $row['picture']; ?>" /></td>
														<td style="width: 35%"><b><?php echo $row['catalogue_name']; ?></b><br /><?php echo $row['catalogue_description']; ?></td>
														<td style="width: 15%"><?php echo $row['catalogue_cost']; ?></td>
														<td style="width: 25%">
															<a class="new-button fill" onclick="habboclub.buttonClick(<?php echo $row['tid']; ?>,'Confirm Purchase'); return false;" href="#"><b>Acheter</b><i></i></a>
														</td>
													</tr>
												</table>
											</li>
										<?php } ?>
										<center>Voici ta recherche.</center>
									</div>
								<?php
							}
								?>

								</div>
								</div>
					</div>

					<script type="text/javascript">
						HabboView.run();
					</script>
					<script type="text/javascript">
						if (!$(document.body).hasClassName('process-template')) {
							Rounder.init();
						}
					</script>


				</div>
				<?php

				include('templates/community/footer.php');

				?>