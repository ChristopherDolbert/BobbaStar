<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");

if (!isset($_SESSION['username']) || $user['rank'] < 10 || $user['rank'] > 11) {
	Redirect("" . $url . "/managements/access_neg");
	exit();
}

if (isset($_POST['objet'], $_POST['texte'], $_POST['applicable'])) {
	$objet = Secu($_POST['objet']);
	$texte = $_POST['texte'];
	$applicable = Secu($_POST['applicable']);
	$sign = Secu($_POST['sign']);
	$bureau = Secu($_POST['bureau']);
	$correct = $bdd->query("SELECT nom_nds FROM gabcms_postes_noms WHERE id = '" . $applicable . "'");
	$c = $correct->fetch(PDO::FETCH_ASSOC);
	if ($objet && $texte && $sign && $bureau) {
		$staff_info = $bdd->query("SELECT id FROM users WHERE rank >= '4'");
		while ($ra = $staff_info->fetch()) {
			$bdd->prepare("INSERT INTO gabcms_management (user_id, message, auteur, date, look) VALUES (:userid, :message, :auteur, :date, :look)")
				->execute(['userid' => $ra['id'], 'message' => 'Une nouvelle <b>note de service</b> applicable aux <b>' . addslashes($c['nom_nds']) . '</b> a été postée. Pour aller la lire et l\'approuvé, je te demanderai de <a href="' . $url . '/managements/nds">cliquer ici</a>.', 'auteur' => 'Système', 'date' => FullDate('full'), 'look' => 'hr-828-45.lg-285-64.ch-215-110.hd-180-2.sh-290-62.he-1607-']);
		}
		$bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)")
			->execute(['pseudo' => $user['username'], 'action' => 'a publié une <b>note de service</b> (' . addslashes($objet) . ')', 'date' => FullDate('full')]);
		$bdd->query("INSERT INTO gabcms_nds (par,date,applicable,objet,texte,sign,look,ip,bureau) VALUES ('" . $user['username'] . "','" . FullDate('datehc') . "','" . addslashes($c['nom_nds']) . "','" . $objet . "','" . addslashes($texte) . "','" . $sign . "','" . $user['look'] . "','" . $ip . "','" . $bureau . "')");
		$bdd->query("INSERT INTO gabcms_tchat_staff (pseudo,message,ip,date,look,rank) VALUES ('','" . $user['username'] . " a publié une Note de Service <b>(" . addslashes($objet) . ")</b>. <a href=\"" . $url . "/managements/nds\">Cliquez ici</a> pour aller lire cette Note de Service applicable aux <b>" . addslashes($c['nom_nds']) . "</b>.','0.0.0.0','" . FullDate('full') . "','hr-828-45.lg-285-64.ch-215-110.hd-180-2.sh-290-62.he-1607-','0')");
		echo '<h4 class="alert_success">La note de service a bien été crée.</h4>';
	} else {
		echo '<h4 class="alert_error">Merci de remplir les champs vides.</h4>';
	}
}

?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />

<body></body>
<span id="titre">Publies une note de service</span><br />
Les notes de service permettent une cohésion optimal au sein du rétro. Ces notes de service sont un peu le réglement intérieur du rétro pour les staffs.
<br /><br />
<script type="text/javascript" src="editeur_html/jscripts/tiny_mce/tiny_mce.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/37.0.1/classic/ckeditor.js"></script>

<form name='editor' method='post' action="#">
	<td width='100' class='tbl'><b>Cette note est applicable aux...</b><br /></td>
	<td width='80%' class='tbl'>
		<select name="applicable" id="pays">
			<?PHP
			$sql_a = $bdd->query("SELECT * FROM gabcms_postes_categorie ORDER BY id ASC");
			while ($a = $sql_a->fetch()) {
			?>
				<optgroup label="<?PHP echo $a['nom'] ?>">
					<?PHP
					$sql_b = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id_categorie = '" . $a['id'] . "' ORDER BY id ASC");
					while ($b = $sql_b->fetch()) {
					?>
						<option value="<?PHP echo $b['id'] ?>">... <?PHP echo $b['nom_nds'] ?></option>
					<?PHP } ?>
				</optgroup>
			<?PHP } ?>
		</select>
	</td><br /><br />
	<td width='100' class='tbl'><b>Écrite dans le bureau...</b><br /></td>
	<td width='80%' class='tbl'>
		<select name="bureau" id="pays">
			<optgroup label="Général">
				<option value="Bureau des staffs" <?php if (isset($_POST['bureau']) && $_POST['bureau'] == "Bureau des staffs") echo 'selected="selected"'; ?>>... des staffs</option>
				<option value="Bureau des animations" <?php if (isset($_POST['bureau']) && $_POST['bureau'] == "Bureau des animations") echo 'selected="selected"'; ?>>... des animations</option>
				<option value="Bureau de la modération" <?php if (isset($_POST['bureau']) && $_POST['bureau'] == "Bureau de la modération") echo 'selected="selected"'; ?>>... de la modération</option>
				<option value="Bureau des techniciens" <?php if (isset($_POST['bureau']) && $_POST['bureau'] == "Bureau des techniciens") echo 'selected="selected"'; ?>>... des techniciens</option>
				<option value="Bureau des fondateurs" <?php if (isset($_POST['bureau']) && $_POST['bureau'] == "Bureau des fondateurs") echo 'selected="selected"'; ?>>... des fondateurs</option>
				<option value="Bureau des gérants" <?php if (isset($_POST['bureau']) && $_POST['bureau'] == "Bureau des gérants") echo 'selected="selected"'; ?>>... des gérants</option>
			</optgroup>
			<optgroup label="Responsables">
				<option value="Bureau des responsables" <?php if (isset($_POST['bureau']) && $_POST['bureau'] == "Bureau des responsables") echo 'selected="selected"'; ?>>... des responsables</option>
				<option value="Bureau des responsables modération" <?php if (isset($_POST['bureau']) && $_POST['bureau'] == "Bureau des responsables modération") echo 'selected="selected"'; ?>>... des responsables modération</option>
				<option value="Bureau des responsables animations" <?php if (isset($_POST['bureau']) && $_POST['bureau'] == "Bureau des responsables animations") echo 'selected="selected"'; ?>>... des responsables animations</option>
				<option value="Bureau des responsables marketing" <?php if (isset($_POST['bureau']) && $_POST['bureau'] == "Bureau des responsables marketing") echo 'selected="selected"'; ?>>... des responsables marketing</option>
				<option value="Bureau des responsables ressources humaines" <?php if (isset($_POST['bureau']) && $_POST['bureau'] == "Bureau des responsables ressources huamines") echo 'selected="selected"'; ?>>... des ressources humaines</option>
				<option value="Bureau du Centre de Traitement des Aides" <?php if (isset($_POST['bureau']) && $_POST['bureau'] == "Bureau du Centre de Traitement des Aides") echo 'selected="selected"'; ?>>... du Centre de Traitement des Aides</option>
			</optgroup>
		</select>
	</td><br /><br />
	<td width='100' class='tbl'><b>Objet :</b><br /></td>
	<td width='80%' class='tbl'><input type="text" name="objet" value="<?php if (!empty($_POST["objet"])) {
																			echo htmlspecialchars($_POST["objet"], ENT_QUOTES);
																		} ?>" placeholder="Expliques en quelques mots la NDS" class="text" style="width: 240px"><br /></td>
	<br />
	<td width='100' class='tbl'><b>Le corps de la note de service : <a href="<?PHP echo $url; ?>/managements/upload" target="_blank">Upload tes images ! (si tu en mets)</a> </b><br /></td>
	<td width='80%' class='tbl'><textarea name="texte" wrap="discuss rows=12 cols=154" id="editor"><?php
																									if (isset($_POST["texte"])) {
																										echo htmlspecialchars($_POST["texte"], ENT_QUOTES);
																									}
																									?></textarea>
		<script>
			ClassicEditor
				.create(document.querySelector('#editor'))
				.catch(error => {
					console.error(error);
				});
		</script>
		<br />
	</td>
	<td width='100' class='tbl'><b>Signature :</b><br /></td>
	<td width='80%' class='tbl'><input type="text" name="sign" placeholder="(ex:Co-gérant) n'écris pas ton pseudo" value="<?php if (!empty($_POST["sign"])) {
																																echo htmlspecialchars($_POST["sign"], ENT_QUOTES);
																															} ?>" class="text" style="width: 240px" maxlength="500"><br /></td>
	<br />
	<tr>
		<td align='center' colspan='2' class='tbl'>
			<input type="submit" name="submit" value="Exécuter" class="submit">
</form>
</tr>
<br />
</body>

</html>