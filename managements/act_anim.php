<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");

// Vérification de la session utilisateur
if (!isset($_SESSION['username'])) {
	Redirect("{$url}/index");
	exit();
}

// Vérification des droits d'accès
if ($user['rank'] < 6 || $user['rank'] > 11) {
	Redirect("{$url}/managements/acces_neg");
	exit();
}

if (isset($_GET['do']) && $_GET['do'] === 'anim') {
	$jour = Secu($_POST['jour'] ?? '');
	$debuth = Secu($_POST['heuresd'] ?? '');
	$debutm = Secu($_POST['minutesd'] ?? '');
	$finh = Secu($_POST['heuresf'] ?? '');
	$finm = Secu($_POST['minutesf'] ?? '');
	$jeu = Secu($_POST['jeu'] ?? '');

	if ($jour !== '' && $debuth !== '' && $debutm !== '' && $finh !== '' && $finm !== '' && $jeu !== '') {
		// Conversion de la valeur jour en un nom de jour de la semaine
		$jour_semaine = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'][$jour];

		// Insertion des données dans la base de données
		$insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo, action, date) VALUES (:pseudo, :action, :date)");
		$insertn1->execute([':pseudo' => $user['username'], ':action' => "animera son jeu <b>({$jeu})</b> de <b>{$debuth}h{$debutm} à {$finh}h{$finm}</b> le <b>{$jour_semaine}</b>", ':date' => FullDate('full')]);

		$insertn2 = $bdd->prepare("INSERT INTO gabcms_bureau_anim (jour, date_debut, date_fin, nomjeu, par) VALUES (:jour, :debut, :fin, :nom, :par)");
		$insertn2->execute([':jour' => $jour, ':debut' => "{$debuth}h{$debutm}", ':fin' => "{$finh}h{$finm}", ':nom' => $jeu, ':par' => $user['username']]);

		echo '<div id="ok">Ton jeu a été posté pour le <b>' . $jour_semaine . '</b> de <b>' . $debuth . 'h' . $debutm . ' à ' . $finh . 'h' . $finm . '</b></div>';
	} else {
		echo '<div id="pasok">Merci de remplir les champs vides.</div>';
	}
}

if (isset($_GET['sup']) && !empty($_GET['sup'])) {
	$sup = Secu($_GET['sup']);
	$sql = $bdd->prepare("SELECT * FROM gabcms_bureau_anim WHERE id = :sup");
	$sql->bindValue(':sup', $sup);
	$sql->execute();
	$a = $sql->fetch();
	if ($a) {
		$jours = array("Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi");
		$modif_jour = $jours[$a['jour']];
		$insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
		$insertn1->bindValue(':pseudo', $user['username']);
		$insertn1->bindValue(':action', 'a supprimé une animation de <b>' . $a['par'] . ' (' . $a['nomjeu'] . ')</b> du <b>' . $modif_jour . '</b>');
		$insertn1->bindValue(':date', FullDate('full'));
		$insertn1->execute();
		$bdd->prepare("DELETE FROM gabcms_bureau_anim WHERE id = :sup")->execute(array(':sup' => $sup));
		echo '<h4 class="alert_success">L\'animation de <b>' . $a['par'] . ' (' . $a['nomjeu'] . ')</b> vient d\'être supprimée !</h4>';
	}
}

?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />

<body>
	<span id="titre">Crées une session d'animation</span><br />
	Ouvres une session d'animation, qui sera visible que par les staffs de l'hôtel.
	<br /><br />
	<script type="text/javascript" src="editeur_html/jscripts/tiny_mce/tiny_mce.js"></script>

	<form name='editor' method='post' action="?do=anim">
		<td width='100' class='tbl'><b>Jour de l'animation :</b><br /></td>
		<td width='80%' class='tbl'>
			<select name="jour" id="pays">
				<option value="1">Lundi</option>
				<option value="2">Mardi</option>
				<option value="3">Mercredi</option>
				<option value="4">Jeudi</option>
				<option value="5">Vendredi</option>
				<option value="6">Samedi</option>
				<option value="0">Dimanche</option>
			</select>
		</td>
		<br />
		<td width='100' class='tbl'><b>Heure de début :</b><br /></td>
		<td width='80%' class='tbl'>
			<select name="heuresd" id="lenght" class="select">
				<option value="00">Minuit</option>
				<option value="01">01</option>
				<option value="02">02</option>
				<option value="03">03</option>
				<option value="04">04</option>
				<option value="05">05</option>
				<option value="06">06</option>
				<option value="07">07</option>
				<option value="08">08</option>
				<option value="09">09</option>
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
				<option value="13">13</option>
				<option value="14">14</option>
				<option value="15">15</option>
				<option value="16">16</option>
				<option value="17">17</option>
				<option value="18">18</option>
				<option value="19">19</option>
				<option value="20">20</option>
				<option value="21">21</option>
				<option value="22">22</option>
				<option value="23">23</option>
			</select>h<select name="minutesd" id="lenght" class="select">
				<option value="00">00</option>
				<option value="05">05</option>
				<option value="10">10</option>
				<option value="15">15</option>
				<option value="20">20</option>
				<option value="25">25</option>
				<option value="30">30</option>
				<option value="35">35</option>
				<option value="40">40</option>
				<option value="45">45</option>
				<option value="50">50</option>
				<option value="55">55</option>
			</select>
			<br />
		<td width='100' class='tbl'><b>Heure de fin :</b><br /></td>
		<td width='80%' class='tbl'>
			<select name="heuresf" id="lenght" class="select">
				<option value="00">Minuit</option>
				<option value="01">01</option>
				<option value="02">02</option>
				<option value="03">03</option>
				<option value="04">04</option>
				<option value="05">05</option>
				<option value="06">06</option>
				<option value="07">07</option>
				<option value="08">08</option>
				<option value="09">09</option>
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
				<option value="13">13</option>
				<option value="14">14</option>
				<option value="15">15</option>
				<option value="16">16</option>
				<option value="17">17</option>
				<option value="18">18</option>
				<option value="19">19</option>
				<option value="20">20</option>
				<option value="21">21</option>
				<option value="22">22</option>
				<option value="23">23</option>
			</select>h<select name="minutesf" id="lenght" class="select">
				<option value="00">00</option>
				<option value="05">05</option>
				<option value="10">10</option>
				<option value="15">15</option>
				<option value="20">20</option>
				<option value="25">25</option>
				<option value="30">30</option>
				<option value="35">35</option>
				<option value="40">40</option>
				<option value="45">45</option>
				<option value="50">50</option>
				<option value="55">55</option>
			</select><br />
		<td width='100' class='tbl'><b>Nom du jeu :</b><br /></td>
		<td width='80%' class='tbl'><input type='text' name='jeu' value='' placeholder='Nom de ton jeu' class='text' style='width: 240px' maxlength="250"><br /></td>
		<br />
		<tr>
			<td align='center' colspan='2' class='tbl'>
				<input type='submit' name='submit' value='Exécuter' class='submit'>
	</form>
	</tr>
	<hr />
	<span id="titre">Action sur une animation</span><br />
	Choisis l'animation que tu désires supprimer !<br /><br />
	<table>
		<tbody>
			<tr class="haut">
				<td class="haut">Nom du jeu</td>
				<td class="haut">Jour de l'animation</td>
				<td class="haut">Heure de début</td>
				<td class="haut">Heure de fin</td>
				<td class="haut">Animé par</td>
				<td class="haut">Actions</td>
			</tr>
			<?PHP
			$sql = $bdd->query("SELECT * FROM gabcms_bureau_anim ORDER BY jour ASC");
			while ($a = $sql->fetch()) {
				if ($a['jour'] == "0") {
					$modif_jour = "Dimanche";
				}
				if ($a['jour'] == "1") {
					$modif_jour = "Lundi";
				}
				if ($a['jour'] == "2") {
					$modif_jour = "Mardi";
				}
				if ($a['jour'] == "3") {
					$modif_jour = "Mercredi";
				}
				if ($a['jour'] == "4") {
					$modif_jour = "Jeudi";
				}
				if ($a['jour'] == "5") {
					$modif_jour = "Vendredi";
				}
				if ($a['jour'] == "6") {
					$modif_jour = "Samedi";
				}
			?>
				<tr class="bas">
					<td class="bas"><?PHP echo stripslashes($a['nomjeu']) ?></td>
					<td class="bas"><?PHP echo $modif_jour ?></td>
					<td class="bas"><?PHP echo Secu($a['date_debut']); ?></td>
					<td class="bas"><?PHP echo Secu($a['date_fin']); ?></td>
					<td class="bas"><?PHP echo Secu($a['par']); ?></td>
					<td class="bas"><a href="?sup=<?PHP echo $a['id'] ?>" onclick="return confirm('Es-tu certain d\'annuler cette animation ?')">Annuler</a></td>
				</tr>
			<?PHP } ?>
		</tbody>
	</table>
</body>

</html>