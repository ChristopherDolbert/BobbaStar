<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");

if (!isset($_SESSION['username']) || $user['rank'] < 9 || $user['rank'] > 11) {
	Redirect("" . $url . "/managements/access_neg");
	exit();
}

if (isset($_GET['do']) && $_GET['do'] == "create" && isset($_POST['titre'], $_POST['article'], $_POST['catart'])) {
	$titre = Secu($_POST['titre']);
	$desc = Secu($_POST['desc']);
	$image = Secu($_POST['image']);
	$article = $_POST['article'];
	$sign = Secu($_POST['sign']);
	$ca = Secu($_POST['catart']);
	$info = Secu($_POST['info']);

	if (!empty($titre) && !empty($article) && !empty($ca)) {
		$bdd->query("INSERT INTO gabcms_news (topstory_image,title,snippet,info,body,auteur,date,sign,category_id,look,event) VALUES ('" . $image . "', '" . addslashes($titre) . "', '" . addslashes($desc) . "', '" . $info . "', '" . addslashes($article) . "', '" . $user['username'] . "', '" . time() . "', '" . $sign . "', '" . $ca . "', '" . $user['look'] . "', '1')");

		$insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
		$insertn1->execute([':pseudo' => $user['username'], ':action' => 'a créé un article <b>(' . addslashes($titre) . ')</b>', ':date' => FullDate('full')]);

		echo '<h4 class="alert_success">L\'événement vient d\'être ajouté.</h4>';
	} else {
		echo '<h4 class="alert_error">Merci de remplir les champs vides.</h4>';
	}
}

?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />

<body></body>
<span id="titre">Crée un article</span><br />
Crées un article afin que tout l'hôtel puisse le voir. Penses à bien compléter tous les champs.
<br /><br />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/37.0.1/classic/ckeditor.js"></script>

<form name='editor' method='post' action="?do=create">
	<td width='100' class='tbl'><b>Catégorie de l'article :</b><br /></td>
	<label><input type="radio" name="catart" value="articles" <?php if (isset($_POST['catart']) && $_POST['catart'] == "articles") echo 'checked="checked"'; ?> />Article</label>
	<label><input type="radio" name="catart" value="événements" <?php if (isset($_POST['catart']) && $_POST['catart'] == "événements") echo 'checked="checked"'; ?> />Événement</label>
	<label><input type="radio" name="catart" value="informations" <?php if (isset($_POST['catart']) && $_POST['catart'] == "informations") echo 'checked="checked"'; ?> />Information</label>
	<label><input type="radio" name="catart" value="communiqués" <?php if (isset($_POST['catart']) && $_POST['catart'] == "communiqués") echo 'checked="checked"'; ?> />Communiqué</label>
	<br /><br />
	<td width='100' class='tbl'><b>Titre de ton article :</b><br /></td>
	<td width='80%' class='tbl'><input type="text" name="titre" value="<?php if (!empty($_POST["titre"])) {
																			echo htmlspecialchars($_POST["titre"], ENT_QUOTES);
																		} ?>" class="text" style="width: 320px"><br /></td>
	<br />
	<td width='100' class='tbl'><b>Description :</b><br /></td>
	<td width='80%' class='tbl'><input type="text" name="desc" value="<?php if (!empty($_POST["desc"])) {
																			echo htmlspecialchars($_POST["desc"], ENT_QUOTES);
																		} ?>" class="text" style="width: 480px"><br /></td>
	<br />
	<td width='100' class='tbl'><b>Image que tu afficheras : <a href="<?PHP echo $url; ?>/articles_topstory" target="_blank">Images pour les news</a> </b><br /></td>
	<td width='80%' class='tbl'><input type="text" name="image" value="<?php if (!empty($_POST["image"])) {
																			echo htmlspecialchars($_POST["image"], ENT_QUOTES);
																		} ?>" class="text" style="width: 360px"><br /></td>
	<br />
	<td width='100' class='tbl'><b>Le corps de l'article : <a href="<?PHP echo $url; ?>/managements/upload" target="_blank">Upload tes images !</a> </b><br /></td>
	<td width='80%' class='tbl'><textarea name='article' wrap="discuss rows=12 cols=154" id="editor"><?php
																										if (isset($_POST["article"])) {
																											echo htmlspecialchars($_POST["article"], ENT_QUOTES);
																										}
																										?></textarea>
		<script>
			ClassicEditor
				.create(document.querySelector('#editor'))
				.catch(error => {
					console.error(error);
				});
		</script>
	</td>
	<td width='100' class='tbl'><b>Message du bouton :</b><br /></td>
	<td width='80%' class='tbl'><input type="text" name="info" style="background-image: url('images/text_news.png'); height: 54px; width: 147px; border: none; padding-left: 10px; margin-top: 6px; color: white; font-size:14px;" value="En savoir plus »" class="text" maxlength="34"><br /></td>
	<br />
	<td width='100' class='tbl'><b>Signature :</b><br /></td>
	<td width='80%' class='tbl'><input type="text" name="sign" value="<?php if (!empty($_POST["sign"])) {
																			echo htmlspecialchars($_POST["sign"], ENT_QUOTES);
																		} ?>" class="text" style="width: 240px" maxlength="50"><br /></td>
	<br />
	<td align='center' colspan='2' class='tbl'>
		<input type='submit' name='submit' value='Exécuter' class='submit'>
</form>
</tr>
<br />
</body>

</html>

</tr>