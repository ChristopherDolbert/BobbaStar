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

if (isset($_GET['do'])) {
	$pseudo = Secu($_POST['name']);
	$name = explode(";", $pseudo);
	$nbr = count($name);
	if ($do == "ban" && isset($pseudo) && !empty($pseudo)) {
		for ($n = 0; $n < $nbr; $n++) {
			$sql = $bdd->query("SELECT id, disabled FROM users WHERE username = '" . $name[$n] . "'");
			$row = $sql->fetch(PDO::FETCH_ASSOC);
			if (!$row) {
				echo '<h4 class="alert_error">Le compte <b>' . $name[$n] . '</b> n\'existe pas.</h4>';
			} else {
				if ($row['disabled'] == 1) {
					$bdd->query("UPDATE users SET disabled = '0' WHERE username = '" . $name[$n] . "'");
					$insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
					$insertn1->execute(array(':pseudo' => $user['username'], ':action' => 'a re-activé le compte de <b>' . $name[$n] . '</b>', ':date' => FullDate('full')));
					echo '<h4 class="alert_success">Le compte <b>' . $name[$n] . '</b> a été réactivé.</h4>';
				} else {
					echo '<h4 class="alert_error">Le compte <b>' . $name[$n] . '</b> est déjà activé.</h4>';
				}
			}
		}
	} else {
		echo '<h4 class="alert_error">Les champs ne sont pas tous remplis.</h4>';
	}
}

?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />

<body></body>
<span id="titre">Re-actives des comptes</span><br />
Re-actives plusieurs comptes en m&ecirc;me temps pour cela apr&egrave;s chaque pseudo mettez un point virgule (;).<br /><br />
<form name='editor' method='post' action="?do=ban">
	<td width='100' class='tbl'><b>Pseudo:</b><br /></td>
	<td width='80%' class='tbl'><textarea name='name' wrap=discuss rows=3 cols=34 maxlength="50"></textarea><br /></td>
	<br />
	<tr>
		<td align='center' colspan='2' class='tbl'>
			<input type='submit' name='submit' value='Exécuter' class='submit'>
</form>
</tr>
<br /><br />
Comptes désactivés : <?php
						$recrut = $bdd->query("SELECT * FROM users WHERE disabled = '1'");
						while ($rt = $recrut->fetch()) {
						?>
	<span style="color:#FF0000;"><?PHP echo $rt['username']; ?> - </span>
<?PHP } ?>
</body>

</html>

</tr>