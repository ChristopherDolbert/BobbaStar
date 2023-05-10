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

if (isset($_GET['do']) && isset($_POST['name']) && !empty($_POST['name'])) {
	$pseudos = explode(";", Secu($_POST['name']));
	$do = Secu($_GET['do']);
	if ($do == "ban") {
		foreach ($pseudos as $pseudo) {
			$sql = $bdd->query("SELECT id, disabled FROM users WHERE username = '" . $pseudo . "'");
			$row = $sql->rowCount();
			if ($row < 1) {
				echo '<h4 class="alert_error">Le compte <b>' . $pseudo . '</b> n\'existe pas.</h4>';
			} else {
				$assoc = $sql->fetch();
				if ($assoc['disabled'] == '1') {
					echo '<h4 class="alert_error">Le compte <b>' . $pseudo . '</b> est déjà désactivé.</h4>';
				} else {
					$insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
					$insertn1->bindValue(':pseudo', $user['username']);
					$insertn1->bindValue(':action', 'a désactivé le compte de <b>' . $pseudo . '</b>');
					$insertn1->bindValue(':date', FullDate('full'));
					$insertn1->execute();
					$bdd->query("UPDATE users SET disabled = '1' WHERE username = '" . $pseudo . "'");
					echo '<h4 class="alert_success">Le compte <b>' . $pseudo . '</b> a été désactivé.</h4>';
				}
			}
		}
	} else {
		echo '<h4 class="alert_error">Action non valide.</h4>';
	}
}

?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />

<body></body>
<span id="titre">Désactives des comptes</span><br />
Désactives plusieurs comptes en m&ecirc;me temps pour cela apr&egrave;s chaque pseudo mettez un point virgule (;).<br /><br />
<form name='editor' method='post' action="?do=ban">
	<td width='100' class='tbl'><b>Pseudo:</b><br /></td>
	<td width='80%' class='tbl'><textarea name='name' wrap=discuss rows=3 cols=34 maxlength="50"></textarea><br /></td>
	<br />
	<tr>
		<td align='center' colspan='2' class='tbl'>
			<input type='submit' name='submit' value='Exécuter' class='submit'>
</form>
</tr>
</body>

</html>

</tr>