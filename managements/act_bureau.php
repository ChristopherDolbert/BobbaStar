<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");

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

if (isset($_POST['texte'])) {
	$texte = $_POST['texte'];
	if (!empty($texte)) {
		$insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo, action, date) VALUES (:pseudo, :action, :date)");
		$insertn1->execute([':pseudo' => $user['username'], ':action' => 'a modifié le message du bloc-notes <b>(Bureau des staffs)</b>', ':date' => FullDate('full')]);
		$update = $bdd->prepare("UPDATE gabcms_bureau_notes SET texte = ?, date = ?, par = ? WHERE id = '1'");
        $update->execute([addslashes($texte), FullDate('full'), $user['username']]);
		echo '<h4 class="alert_success">Le message dans le bloc-notes a été mis à jour !</h4>';
	} else {
		echo '<h4 class="alert_error">Merci d\'écrire quelque chose</h4>';
	}
}

$c = $bdd->query("SELECT * FROM gabcms_bureau_notes WHERE id = '1'")->fetch(PDO::FETCH_ASSOC);

?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/37.0.1/classic/ckeditor.js"></script>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />

<body>
	<span id="titre">Message du bloc-notes</span><br />
	Modifies le message du bloc-notes dans le bureau des staffs<br /><br />
	<form name='editor' method='post' action="?do=modif">
		<td width='100' class='tbl'><b>Message du bloc-notes : <a href="<?PHP echo $url; ?>/managements/upload" target="_blank">Upload tes images !</a> </b><br /></td>
		<td width='80%' class='tbl'><textarea name='texte' wrap="discuss rows=12 cols=154" id="editor"><?php echo $c['texte']; ?></textarea>
			<script>
				ClassicEditor
					.create(document.querySelector('#editor'))
					.catch(error => {
						console.error(error);
					});
			</script>
			<br />
		</td>
		<td align='center' colspan='2' class='tbl'>
			<input type='submit' name='submit' value='Exécuter' class='submit'>
	</form>
	<br />
</body>

</html>