<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");

if (!isset($_SESSION['username']) || $user['rank'] < 7 || $user['rank'] > 11) {
	Redirect("" . $url . "/managements/access_neg");
	exit();
}
?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />
<style>
	#cta_01 {
		background-image: url('../web-gallery/images/cta/cta_01.png');
		width: 373px;
		height: 9px;
	}

	#cta_02 {
		background-image: url('../web-gallery/images/cta/cta_02.png');
		width: 365px;
		height: auto;
		padding-left: 7px;
		padding-right: 1px;
	}

	#cta_03 {
		background-image: url('../web-gallery/images/cta/cta_03.png');
		width: 373px;
		height: 7px;
	}
</style>

<body>
	<span id="titre">Affiches les dossiers</span><br />
	Affiches le dossier du staff de ton choix.<br /><br />
	<form method="post" action="">
		<td width='100' class='tbl'><b>Pseudo :</b><br /></td>
		<td width='80%' class='tbl'><input type="text" name="pseudo" class="text" style="width: 240px"></td> <input type="submit" value="Rechercher" />
	</form>
	
	<?php
	if (isset($_POST['pseudo']) && !empty($_POST['pseudo'])) {
		$pseudo = Secu($_POST['pseudo']);
		$sql = $bdd->query("SELECT * FROM users WHERE username = '{$pseudo}'");
		if ($sql->rowCount() == 1) {
			$assoc = $sql->fetch(PDO::FETCH_ASSOC);
			$insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
			$insertn1->bindValue(':pseudo', $user['username']);
			$insertn1->bindValue(':action', 'a regardé le dossier de <b>' . $assoc['username'] . '</b>');
			$insertn1->bindValue(':date', FullDate('full'));
			$insertn1->execute();

			$sql = $bdd->query("SELECT * FROM gabcms_dossier WHERE userid = '{$assoc['id']}' ORDER BY id DESC");
			while ($a = $sql->fetch()) {
	?>
				<table width="100%" style="font-size: 11px; padding: 4px; margin-left: -14px;">
					<tbody>
						<tr>
							<td valign="middle" width="10" height="60">
								<div alt="<?PHP echo $a['par']; ?>" style="width: 64px; height: 70px; margin-top:-10px; margin-left:-10px; float: right; background: url(<?php echo $avatarimage; ?><?PHP echo $a['look']; ?>&action=&direction=2&head_direction=2&gesture=0&size=1&img_format=gif);"></div>
							</td>
							<td valign="top"><span style="color:#008000; font-size:9px;"><?PHP echo $a['date']; ?></span> par <span style="color:blue;"><b><?PHP echo stripslashes($a['par']); ?> (<?PHP echo stripslashes($a['poste']); ?>)</b></span> <img src="<?PHP echo $url; ?>/managements/img/dossier/<?PHP echo $a['avis']; ?>.png" /><br />
								<div id="cta_01"></div>
								<div id="cta_02"><?PHP echo stripslashes($a['commentaire']); ?></div>
								<div id="cta_03"></div>
								<br />__________________________________<br />
							</td>
						</tr>
					</tbody>
				</table>
	<?php
			}
		} else {
			echo '<h4 class="alert_error">Utilisateur introuvable</h4>';
		}
	} else {
		echo '<h4 class="alert_error">Merci d\'écrire quelque chose</h4>';
	}
	?>

</body>

</html>