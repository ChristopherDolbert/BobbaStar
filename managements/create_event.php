<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         GabCMS - Site Web et Content Management System                 #|
#|         Copyright © 2013 Gabodd Tout droits réservés.                  #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");

if (!isset($_SESSION['username']) || $user['rank'] < 9 || $user['rank'] > 11) {
	Redirect("" . $url . "/managements/access_neg");
	exit();
}

if (isset($_GET['do']) && $_GET['do'] === 'create') {
	if (isset($_POST['titre'], $_POST['desc'], $_POST['image'])) {
		$titre = Secu($_POST['titre']);
		$desc = Secu($_POST['desc']);
		$image = Secu($_POST['image']);
		if ($titre !== '') {
			$sql = "INSERT INTO gabcms_news (`topstory_image`,`title`,`snippet`,`info`,`body`,`auteur`,`date`,`sign`,`category_id`,`look`,`event`)";
			$sql .= " VALUES ('$image', '" . addslashes($titre) . "', '" . addslashes($desc) . "', '-', 'Ceci n\'est pas un article !', '" . $user['username'] . "', '$nowtime', '-', 'Événement', '" . $user['look'] . "', '0')";
			$bdd->query($sql);
			$insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
			$insertn1->execute(['pseudo' => $user['username'], 'action' => 'a créé un événement sans lien <b>(' . addslashes($titre) . ')</b>', 'date' => FullDate('full')]);
			echo '<h4 class="alert_success">L\'article vient d\'être ajouté.</h4>';
		} else {
			echo '<h4 class="alert_error">Merci de remplir les champs vides.</h4>';
		}
	} elseif (isset($_POST['titre'], $_POST['desc'], $_POST['image'], $_POST['url'])) {
		$titre = Secu($_POST['titre']);
		$desc = Secu($_POST['desc']);
		$image = Secu($_POST['image']);
		$url_article = Secu($_POST['url']);
		if ($titre !== '') {
			$sql = "INSERT INTO gabcms_news (`topstory_image`,`title`,`snippet`,`info`,`body`,`auteur`,`date`,`sign`,`category_id`,`look`,`event`,`lien_event`)";
			$sql .= " VALUES ('$image', '" . addslashes($titre) . "', '" . addslashes($desc) . "', '$url_article', 'Ceci n\'est pas un article !', '" . $user['username'] . "', '$nowtime', '-', 'Événement', '" . $user['look'] . "', '2', 'http://$url_article')";
			$bdd->query($sql);
			$insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
			$insertn1->execute(['pseudo' => $user['username'], 'action' => 'a créé un événement avec lien <b>(' . addslashes($titre) . ')</b>', 'date' => FullDate('full')]);
			echo '<h4 class="alert_success">L\'événement vient d\'être ajouté.</h4>';
		} else {
			echo '<h4 class="alert_error">Merci de remplir les champs vides.</h4>';
		}
	}
}

?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />

<body></body>
<span id="titre">Crée un événement</span><br />
Crées un événement sans lien afin que tout l'hôtel puisse le voir. Penses à bien compléter tous les champs.
<br /><br />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<form name='editor' method='post' action="?do=create">
	<td width='100' class='tbl'><b>Titre de ton événement :</b><br /></td>
	<td width='80%' class='tbl'><input type="text" name="titre" value="<?php if (!empty($_POST["titre"])) {
																			echo htmlspecialchars($_POST["titre"], ENT_QUOTES);
																		} ?>" class="text" style="width: 320px"><br /></td>
	<br />
	<td width='100' class='tbl'><b>Description :</b><br /></td>
	<td width='80%' class='tbl'><textarea name="desc" rows="5" cols="50"><?php
																			if (isset($_POST["desc"])) {
																				echo htmlspecialchars($_POST["desc"], ENT_QUOTES);
																			}
																			?></textarea><br /></td>
	<br />
	<td width='100' class='tbl'><b>Image que tu afficheras : <a href="<?PHP echo $url; ?>/articles_topstory" target="_blank">Images pour les news</a> </b><br /></td>
	<td width='80%' class='tbl'><input type="text" name="image" value="<?php if (!empty($_POST["image"])) {
																			echo htmlspecialchars($_POST["image"], ENT_QUOTES);
																		} ?>" class="text" style="width: 360px"><br /></td>
	<br />
	<td align='center' colspan='2' class='tbl'>
		<input type='submit' name='submit' value='Exécuter' class='submit'>
</form>
</tr>
<br />
</body>

</html>

</tr>