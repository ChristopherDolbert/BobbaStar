<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");

if (!isset($_SESSION['username']) || $user['rank'] < 8 || $user['rank'] > 11) {
	Redirect("" . $url . "/managements/access_neg");
	exit();
}

if (isset($_POST['message'], $_POST['pseudo'])) {
	$message = Secu($_POST['message']);
	$pseudo = Secu($_POST['pseudo']);

	$sql = $bdd->prepare("SELECT * FROM users WHERE username = ?");
	$sql->execute([$pseudo]);
	$assoc = $sql->fetch(PDO::FETCH_ASSOC);

	if ($assoc && $message > 5 && $message < 200 && is_numeric($message)) {
		$bdd->query("UPDATE users SET message = message + ? WHERE id = ?", [$message, $assoc['id']]);

		$insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
		$insertn1->bindValue(':pseudo', $user['username']);
		$insertn1->bindValue(':action', 'a ajouté <b>' . $message . '</b> messages à <b>' . $assoc['username'] . '</b>');
		$insertn1->bindValue(':date', FullDate('full'));
		$insertn1->execute();

		$insertn2 = $bdd->prepare("INSERT INTO gabcms_management (user_id, message, auteur, date, look) VALUES (?, ?, ?, ?, ?)");
		$insertn2->execute([$assoc['id'], 'Je viens de t\'ajouter ' . $message . ' messages.', $user['username'], FullDate('full'), $user['look']]);

		echo '<h4 class="alert_success">Le nombre de messages de ' . $pseudo . ' a été modifié</h4>';
	} else {
		echo '<h4 class="alert_error">Merci de remplir les champs vides avec des informations valides</h4>';
	}
}

?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />

<body></body>
<span id="titre">Ajoutes des messages</span><br />
Donnes des messages à quelques utilisateurs. Tu peux donner par dons pas plus de 200 messages et pas moins de 5.<br /><br />
<form name='editor' method='post' action="">
	<td width='100' class='tbl'><b>Pseudo : </b><br /></td>
	<td width='80%' class='tbl'><input type="text" name="pseudo" class="text" size="50" maxlength="50"><br /></td>
	<td width='100' class='tbl'><b>Nombre de messages :</b><br /></td>
	<td width='80%' class='tbl'><input type="text" name="message" class="text" size="3" maxlength="3"><br /></td><br />
	<tr>
		<td align='center' colspan='2' class='tbl'>
			<input type='submit' name='submit' value='Ajouter' class='submit'>
</form>
</tr>
</body>

</html>