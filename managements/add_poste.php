<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");

if (!isset($_SESSION['username']) || $user['rank'] > 11) {
	Redirect("" . $url . "/managements/access_neg");
	exit();
}

if (isset($_POST['pseudo'], $_POST['poste'])) {
	$pseudo = Secu($_POST['pseudo']);
	$poste = Secu($_POST['poste']);
	$sql = $bdd->prepare("SELECT * FROM users WHERE username = ?");
	$sql->execute([$pseudo]);
	$assoc = $sql->fetch(PDO::FETCH_ASSOC);
	$search = $bdd->prepare("SELECT user_id FROM gabcms_postes WHERE poste = ? AND user_id = ?");
	$search->execute([$poste, $assoc['id']]);
	$ok = $search->fetch();
	$correct = $bdd->prepare("SELECT nom_" . $assoc['gender'] . " FROM gabcms_postes_noms WHERE id = ?");
	$correct->execute([$poste]);
	$c = $correct->fetch();
	if ($pseudo !== "" && !$ok && $poste !== "") {
		$insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo, action, date) VALUES (:pseudo, :action, :date)");
		$insertn1->execute([
			':pseudo' => $user['username'],
			':action' => 'a attribué le poste de <b>' . addslashes($c["nom_{$assoc['gender']}"]) . '</b> à <b>' . $pseudo . '</b>',
			':date' => FullDate('full')
		]);
		$insertn2 = $bdd->prepare("INSERT INTO gabcms_postes (user_id, poste, par, date) VALUES (:id, :poste, :par, :date)");
		$insertn2->execute([
			':id' => $assoc['id'],
			':poste' => $poste,
			':par' => $user['username'],
			':date' => FullDate('full')
		]);
		echo '<h4 class="alert_success">Le poste de <b>' . $c["nom_{$assoc['gender']}"] . '</b> a bien été attribué à <b>' . $pseudo . '</b></h4>';
	} elseif ($ok) {
		echo '<h4 class="alert_error"><b>' . $pseudo . '</b> a déjà le poste de <b>' . $c["nom_{$assoc['gender']}"] . '</b></h4>';
	} else {
		echo '<h4 class="alert_error">Merci de remplir les champs vides.</h4>';
	}
}

?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />

<body>
	<span id="titre">Donnes des fonctions précises</span><br />
	Ces fonctions ne jouent en rien dans l'accès aux pages, mais affiche sur la page staff le poste au survole du pseudo.<br /><br />
	<script type="text/javascript" src="editeur_html/jscripts/tiny_mce/tiny_mce.js"></script>
	<form name='editor' method='post' action="#">
		<td width='100' class='tbl'><b>Pseudo :</b><br /></td>
		<td width='80%' class='tbl'><select name="pseudo" id="pays">
				<?PHP
				$sql_a = $bdd->query("SELECT * FROM users WHERE rank >= '4' ORDER BY rank DESC");
				while ($a = $sql_a->fetch()) {
				?>
					<option value="<?PHP echo $a['username']; ?>"><?PHP echo $a['username']; ?></option>
				<?PHP } ?>
			</select><br /></td>
		<td width='100' class='tbl'><b>Poste :</b><br /></td>
		<td width='80%' class='tbl'>
			<select name="poste" id="pays" size="15">
				<?PHP
				$sql_a = $bdd->query("SELECT * FROM gabcms_postes_categorie ORDER BY id ASC");
				while ($a = $sql_a->fetch()) {
				?>
					<optgroup label="<?PHP echo $a['nom'] ?>">
						<?PHP
						$sql_b = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id_categorie = '" . $a['id'] . "' ORDER BY id ASC");
						while ($b = $sql_b->fetch()) {
						?>
							<option value="<?PHP echo $b['id'] ?>"><?PHP echo $b['nom_M'] ?></option>
						<?PHP } ?>
					</optgroup>
				<?PHP } ?>
			</select>
		</td><br /><br />
		<tr>
			<td align='center' colspan='2' class='tbl'>
				<input type='submit' name='submit' value='Exécuter' class='submit'>
	</form>
	</tr>
	<br />
</body>

</html>