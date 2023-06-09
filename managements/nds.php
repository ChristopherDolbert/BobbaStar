<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");
$pagename = "Notes de Service";
$pageid = "nds";

if (!isset($_SESSION['username']) || $user['rank'] < 7 || $user['rank'] > 11) {
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

if (isset($_GET['id'])) {
	$id = Secu($_GET['id']);
	$infr = $bdd->query("SELECT * FROM gabcms_nds WHERE id = '{$id}'");
	$r = $infr->fetch();

	if (isset($_POST['message']) && $message = Secu($_POST['message'])) {
		if ($r['edit'] == 1) {
			$insertn4 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
			$insertn4->execute(array(':pseudo' => $user['username'], ':action' => 'a lu et approuve à nouveau la Note de Service <b>"' . addslashes($r['objet']) . '"</b>', ':date' => FullDate('full')));
		} else {
			$affichage = "<div id=\"purse-redeem-result\"> 
				<div class=\"redeem-error\">
					<div class=\"rounded rounded-red\">
						Une erreur est survenue
					</div>
				</div>
			</div>";
		}
		$insertn2 = $bdd->prepare("INSERT INTO gabcms_nds_lu (id_nds,pseudo,texte,date) VALUES (:id, :pseudo, :texte, :date)");
		$insertn2->execute(array(':id' => $r['id'], ':pseudo' => $user['username'], ':texte' => $message, ':date' => FullDate('full')));
		$insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
		$insertn1->execute(array(':pseudo' => $user['username'], ':action' => 'a lu et approuve la Note de Service <b>"' . addslashes($r['objet']) . '"</b>', ':date' => FullDate('full')));
		$affichage = "<div id=\"purse-redeem-result\">
            <div class=\"redeem-error\">
                <div class=\"rounded rounded-green\">
                    Ta lecture a été prise en compte
                </div>
            </div>
        </div>";
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<title><?PHP echo $sitename; ?> &raquo; <?PHP echo $pagename; ?></title>

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
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/myhabbo/control.textarea.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
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

<body id="news">
	<div id="tooltip"></div>
	<div id="overlay"></div>
	<!-- MENU -->
	<?PHP include("../template/header.php"); ?>
	<!-- FIN MENU -->

	<div id="container">
		<div id="content" style="position: relative" class="clearfix">
			<div id="column1" class="column">
				<div class="habblet-container ">
					<div class="cbb clearfix green">
						<h2 class="title">Notes de service
						</h2>
						<div id="article-archive">
							<h2>Les notes de service actives</h2>
							<ul>
								<?PHP
								$sql = $bdd->query("SELECT * FROM gabcms_nds WHERE annuler='0' ORDER BY id DESC ");
								while ($news = $sql->fetch()) { ?>
									<li>
										<?php if (isset($_GET['id']) && $news['id'] == $id) {
											echo $news['objet']; ?>&nbsp;&raquo;
									<?php
										} else {
									?>
										<a href="<?PHP echo $url; ?>/managements/nds?id=<?PHP echo $news['id']; ?>"><?PHP echo $news['objet']; ?>&nbsp;&raquo;</a>
									</li>
							<?PHP }
									} ?>
							</ul>
							<?PHP if (isset($affichage)) {
								echo "<br/>" . $affichage . "";
							} ?>
						</div>
					</div>
				</div>
				<div class="habblet-container ">
					<div class="cbb clearfix red">
						<h2 class="title">Notes de service
						</h2>
						<div id="article-archive">
							<h2>Les notes de service annulées</h2>
							<ul>
								<?PHP
								$sql = $bdd->query("SELECT * FROM gabcms_nds WHERE annuler='1' ORDER BY id DESC ");
								while ($news = $sql->fetch()) { ?>
									<li>
										<?php if (isset($_GET['id']) && $news['id'] == $id) {
											echo $news['objet']; ?>&nbsp;&raquo;
									<?php
										} else {
									?>
										<a href="<?PHP echo $url; ?>/managements/nds?id=<?PHP echo $news['id']; ?>"><?PHP echo $news['objet']; ?>&nbsp;&raquo;</a>
									</li>
							<?PHP }
									} ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div id="column2" class="column">
				<div class="habblet-container ">
					<div class="cbb clearfix notitle ">
						<?PHP
						if (isset($_GET['id'])) {
							$id = Secu($_GET['id']);
							$sql = $bdd->query("SELECT * FROM gabcms_nds WHERE id = '" . $id . "'");
							$row = $sql->rowCount();
							$n = $sql->fetch(PDO::FETCH_ASSOC);
							if (empty($id)) { ?>
								<div id="article-wrapper">
									<h2>Aucune note de service</h2>
									<div class="article-meta"><?PHP echo FullDate('full'); ?>
										<a href="<?PHP echo $url; ?>/managements/nds">Introuvable</a>
									</div>
									<p class="summary">Notes de service introuvable.</p>
									<div class="article-body">
										Il est probable que la note de service que tu recherches est inéxistante.<br />
										Merci d'en sélectionner une autre dans la liste des notes de service &agrave; ta gauche.
										<div class="article-author"><?php echo $owner; ?></div>
										<div class="article-images clearfix">
										</div>
									</div>
								</div>
							<?PHP } elseif ($row < 1) {
							?>
								<div id="article-wrapper">
									<h2>Aucune note de service</h2>
									<div class="article-meta"><?PHP echo FullDate('full'); ?>
										<a href="<?PHP echo $url; ?>/managements/nds">Introuvable</a>
									</div>
									<p class="summary">Notes de service introuvable.</p>
									<div class="article-body">
										Il est probable que la note de service que tu recherches est inéxistante.<br />
										Merci d'en sélectionner une autre dans la liste des notes de service &agrave; ta gauche.

										<div class="article-author"><?php echo $owner; ?></div>
										<div class="article-images clearfix">
										</div>
									</div>
								</div>
							<?PHP } else { ?>
								<div id="article-wrapper">
									<h2>
										<center>Note de service - #<?PHP echo $n['id']; ?></center>
									</h2>
									<div class="article-meta">
										<p class="summary"></p>
										<div class="article-body">
											<p><span><u>Objet :</u> <?PHP echo htmlspecialchars($n['objet']) ?></span></p>
										</div><br /><br />

										<?php echo stripslashes($n['texte']); ?>
										<div style="display: flex; justify-content: space-between;">
											<div style="color: red;">Cette note est applicable aux <strong><?php echo $n['applicable']; ?></strong></div>
											<div class="article-author" style="color:green;text-align: right;">Lue et approuvée :
												<?php
												$recrut = $bdd->query("SELECT DISTINCT pseudo FROM gabcms_nds_lu WHERE id_nds = '" . $n['id'] . "'");
												while ($rt = $recrut->fetch(PDO::FETCH_ASSOC)) {
													echo $rt['pseudo'] . " ";
												}
												?>
											</div>
										</div>

									</div><br /><br />
									<?php
									$search = $bdd->query("SELECT pseudo FROM gabcms_nds_lu WHERE id_nds = '" . $n['id'] . "' AND pseudo = '" . $user['username'] . "'");
									$ok = $search->fetch();

									if (empty($ok) && $n['annuler'] == '0') {
									?>
										<form method="post" action="<?php echo $url; ?>/managements/nds?id=<?php echo $n['id']; ?>#">
											<div id="article_haut">
												<span style="width: 64px; height: 83px; margin-top:-5px; margin-left:-5px; float: left; background: url(<?php echo $avatarimage . Secu($n['look']); ?>&action=wav&direction=2&head_direction=2&gesture=sml&size=big&img_format=gif);"></span>
												<span style="color: #000000; font-size: 11px;"><br /><b>Posté par :</b> <?php echo Secu($n['par']); ?><br /><b>Date :</b> <?php echo Secu($n['date']); ?><br /><input type="text" value="" name="message"> <input type='submit' name='submit' value='Lire et approuver' class='submit'>
												</span>
											</div>
										<?php
									} elseif (!empty($ok) && $n['annuler'] == '0') {
										?>
											<div id="article_haut">
												<span style="width: 64px; height: 83px; margin-top:-5px; margin-left:-5px; float: left; background: url(<?php echo $avatarimage . $n['look']; ?>&action=wav&direction=2&head_direction=2&gesture=sml&size=big&img_format=gif);"></span>
												<span style="color: #000000; font-size: 11px;"><br /><b>Posté par :</b> <?php echo Secu($n['par']); ?><br /><b>Date :</b> <?php echo Secu($n['date']); ?><br /></span>
											</div>
										<?php
									} elseif ($n['annuler'] == '1') {
										?>
											<div id="article_haut">
												<span style="width: 64px; height: 83px; margin-top:-5px; margin-left:-5px; float: left; background: url(<?php echo $avatarimage . $n['look']; ?>&action=wav&direction=2&head_direction=2&gesture=sml&size=big&img_format=gif);"></span>
												<span style="color: #000000; font-size: 11px;"><br /><b>Posté par :</b> <?php echo Secu($n['par']); ?><br /><b>Date :</b> <?php echo Secu($n['date']); ?><br /><br />Note de service annulée le <?php echo Secu($n['date_annuler']); ?> par <b><?php echo Secu($n['user_annuler']); ?></b></span>
											</div>
										<?php
									}
										?>

								</div>
					</div>
				</div>
			</div>
		<?PHP }
						} else { ?>
		<div id="article-wrapper">
			<h2>Aucune news</h2>
			<div class="article-meta"><?PHP echo FullDate('full'); ?>
				<a href="<?PHP echo $url; ?>/articles">Introuvable</a>
			</div>
			<p class="summary">Aucun article choisi</p>
			<div class="article-body">
				Merci de sélectionner un article dans la liste des articles à votre gauche.
				<div class="article-author"><?php echo $owner; ?></div>
				<div class="article-images clearfix">
				</div>
			</div>
		</div>
	<?PHP } ?>
		</div>
		<script type="text/javascript">
			if (!$(document.body).hasClassName('process-template')) {
				Rounder.init();
			}
		</script>
	</div>
	</div>
	<!-- FOOTER -->
	<?PHP include("../template/footer.php"); ?>
	<!-- FIN FOOTER -->
	</div>
	</div>
	</div>
	</div>
	<script type="text/javascript">
		HabboView.run();
	</script>
</body>

</html>