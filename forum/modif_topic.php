<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|           GabCMS - Site Web et Content Management System               #|
#|         Copyright © 2012-2014 - Gabodd Tout droits réservés.           #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");

if (!isset($_SESSION['username'])) {
	Redirect("" . $url . "/index");
	exit();
}

if ($user['rank'] < 5) {
	Redirect("" . $url . "/forum/");
	exit();
}
if ($user['rank'] > 8) {
	Redirect("" . $url . "/forum/");
	exit();
}
if (isset($_GET['modifiertopic'])) {
	$modifiertopic = Secu($_GET['modifiertopic']);
}
if (isset($_GET['modif'])) {
	$modif = Secu($_GET['modif']);
	$sqlalpha = $bdd->query("SELECT * FROM gabcms_forum_topic WHERE id = '" . $modif . "'");
	$mod = $sqlalpha->fetch();
}
if ($user['rank'] >= 5) {
	if (isset($_GET['modifiertopic'])) {
		if ($modifiertopic != "") {
			if (isset($_POST['topic']) || isset($_POST['titre'])) {
				$topic = addslashes($_POST['topic']);
				$titre = addslashes($_POST['titre']);
				$sql_mo = $bdd->query("SELECT * FROM gabcms_forum_topic WHERE id = '" . $modifiertopic . "'");
				$mod_t = $sql_mo->fetch();
				$sqla = $bdd->query("SELECT * FROM users WHERE id = '" . $mod_t['user_id'] . "'");
				$assoc = $sqla->fetch(PDO::FETCH_ASSOC);
				if ($topic != "" && $titre != "") {
					$insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :message, :date)");
					$insertn1->bindValue(':pseudo', $user['username']);
					$insertn1->bindValue(':message', 'a modifié un topic de <b>' . $assoc['username'] . '</b> (' . $mod_t['titre'] . ')');
					$insertn1->bindValue(':date', FullDate('full'));
					$insertn1->execute();
					$bdd->query("UPDATE gabcms_forum_topic SET titre='" . $titre . "', texte='" . $topic . "', modif='1', modif_le='" . FullDate('full') . "',modif_par='" . $user['id'] . "' WHERE id = '" . $modifiertopic . "'");
					echo '<h4 class="alert_success">Le topic vient d\'être modifié.</h4>';
				} else {
					echo '<h4 class="alert_error">Merci de remplir les champs vide</h4>';
				}
			}
		}
	}
} else {
	echo '<h4 class="alert_error">Tu n\'as pas l\'autorisation de modifier ce topic.</h4>';
}
?>
<link href="<?PHP echo $url ?>/managements/css/contenu.css" rel="stylesheet" type="text/css">
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

<body>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script src="https://cdn.ckeditor.com/ckeditor5/37.0.1/classic/ckeditor.js"></script>
	<title>Modifie un topic (<?PHP echo $mod['titre'] ?>)</title>
	<?php if (!isset($_GET['modif'])) { ?>
		<p><span id="titre">Selectionnes un topic</span><br \>
			Merci de sélectionner un topic
		<?php
	}
		?>
		<?php if (isset($_GET['modif'])) { ?>
			<?PHP
			$sql_modif = $bdd->query("SELECT * FROM gabcms_forum_topic WHERE id = '" . $modif . "'");
			$modif_a = $sql_modif->fetch();
			?>
		<p><span id="titre">Modification d'un topic.</span><br \>
			Tu peux modifié le titre et le texte du topic.
			<br /><br />
		<form name="editor" method="post" action="?modifiertopic=<?php echo $modif; ?>">
			<td width="100" class="tbl"><b>Titre :</b><br /></td>
			<td width="80%" class="tbl"><input type="text" name="titre" value="<?php echo stripslashes($modif_a['titre']); ?>" class="text" style="width: 240px"><br /></td>
			<br />
			<td width="100" class="tbl"><b>Le corps du topic : <a href="<?PHP echo $url; ?>/managements/upload.php" target="_blank">Upload tes images !</a> </b><br /></td>
			<td width="80%" class="tbl"><textarea name="topic" wrap="discuss rows=12 cols=142" id="editor"><?php echo $modif_a['texte']; ?></textarea>
				<script>
					ClassicEditor
						.create(document.querySelector('#editor'))
						.catch(error => {
							console.error(error);
						});
				</script>
			</td>
			<input type='submit' name='submit' value='Modifier'>
		</form>
	<?php
		}
	?>
</body>

</html>