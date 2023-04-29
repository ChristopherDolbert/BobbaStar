<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");

if (!isset($_SESSION['username']) || $user['rank'] < 87 || $user['rank'] > 11) {
	Redirect("" . $url . "/managements/access_neg");
	exit();
}

if (isset($_POST['message'], $_POST['pseudo'])) {
	$message = Secu($_POST['message']);
	$pseudo = Secu($_POST['pseudo']);
	$sql = $bdd->query("SELECT id, message FROM users WHERE username = '" . $pseudo . "'");
	$row = $sql->fetch(PDO::FETCH_ASSOC);
	if ($row) {
		$nombre_message = $row['message'] - $message;
		if ($nombre_message >= 0) {
			$bdd->query("UPDATE users SET message = message - '" . $message . "' WHERE id = '" . $row['id'] . "'");
			$insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
			$insertn1->execute(array(':pseudo' => $user['username'], ':action' => 'a enlevé <b>' . $message . '</b> messages à <b>' . $pseudo . '</b>', ':date' => FullDate('full')));
			$insertn2 = $bdd->prepare("INSERT INTO gabcms_management (user_id, message, auteur, date, look) VALUES (:userid, :message, :auteur, :date, :look)");
			$insertn2->execute(array(':userid' => $row['id'], ':message' => 'Nous venons de t\'enlever ' . Secu($message) . ' messages.', ':auteur' => $user['username'], ':date' => FullDate('full'), ':look' => $user['look']));
			echo '<h4 class="alert_success">Le nombre de messages à été modifié</h4>';
		} else {
			echo '<h4 class="alert_error">Impossible d\'enlever plus de messages que l\'utilisateur n\'en a. (il en a ' . $row['message'] . ')</h4>';
		}
	} else {
		echo '<h4 class="alert_error">L\'utilisateur n\'existe pas</h4>';
	}
} else {
	echo '<h4 class="alert_error">Merci de remplir les champs vides</h4>';
}

?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />

<body></body>
<span id="titre">Enlèves des messages</span><br />
Enlèves un certain nombre de messages à des utilisateurs.<br /><br />
<form name='editor' method='post' action="">
	<td width='100' class='tbl'><b>Pseudo : </b><br /></td>
	<td width='80%' class='tbl'><input type='text' name='pseudo' class='text' style='width: 240px' maxlength="50"><br /></td>
	<td width='100' class='tbl'><b>Nombre de messages :</b><br /></td>
	<select name="message" id="pays">
		<option value="10">10 messages</option>
		<option value="20">20 messages</option>
		<option value="30">30 messages</option>
		<option value="40">40 messages</option>
		<option value="50">50 messages</option>
		<option value="60">60 messages</option>
		<option value="70">70 messages</option>
		<option value="80">80 messages</option>
		<option value="90">90 messages</option>
		<option value="100">100 messages</option>
	</select>
	<br />
	<tr>
		<td align='center' colspan='2' class='tbl'>
			<input type='submit' name='submit' value='Exécuter' class='submit'>
</form>
</td>
</tr>
</body>

</html>