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

if (isset($_GET['do']) && $_GET['do'] === 'ban') {
	$type = '';
	$value = '';
	$field = '';
	if (isset($_POST['ip'])) {
		$type = 'ip';
		$value = $_POST['ip'];
		$field = 'ip_current';
	} elseif (isset($_POST['username'])) {
		$type = 'account';
		$value = $_POST['username'];
		$field = 'username';
	}
	$reason = Secu($_POST['reason']);
	$duration = Secu($_POST['date']);
	$values = explode(';', $value);
	$count = count($values);
	$time = time();
	$durationInSeconds = $duration * 3600;
	$expirationTime = $time + $durationInSeconds;
	if (!empty($values) && !empty($reason) && !empty($duration) && !empty($type)) {
		foreach ($values as $val) {
			$sql = $bdd->query("SELECT id FROM users WHERE {$field} = '{$val}'");
			$row = $sql->rowCount();
			if ($row > 0) {
				$insert = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
				$insert->execute(array(':pseudo' => $user['username'], ':action' => 'a banni ' . (($type === 'ip') ? 'l\'adresse IP ' : '') . "<b>{$val}</b> pour la raison suivante : {$reason}", ':date' => FullDate('full')));
				$bdd->query("INSERT INTO bans (type,value,ban_reason,ban_expire,user_staff_id,timestamp) VALUES ('{$type}','{$val}','{$reason}','{$expirationTime}','{$user['username']}','{$time}')");
				echo "<h4 class=\"alert_success\">Le " . (($type === 'ip') ? 'adresse IP ' : 'compte ') . "<b>{$val}</b> a été banni pour la raison suivante: <b>{$reason}</b></h4>";
			} else {
				echo "<h4 class=\"alert_error\">Le " . (($type === 'ip') ? 'adresse IP ' : 'compte ') . "<b>{$val}</b> n'existe pas.</h4>";
			}
		}
	} else {
		echo '<h4 class="alert_error">Les champs ne sont pas tous remplis.</h4>';
	}
}

?>

<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />

<body></body>
<span id="titre">Bannir des utilisateurs</span><br />
Bannis plusieurs utilisateurs en m&ecirc;me temps pour cela apr&egrave;s chaque utilisateur mettez un point virgule (;).<br /><br />
<form name='editor' method='post' action="?do=ban">
	<td width='100' class='tbl'><b>Pseudo :</b><br /></td>
	<td width='80%' class='tbl'><textarea name='username' wrap=discuss rows=3 cols=34 maxlength="50"></textarea><br /></td>
	<br />
	<td width='100' class='tbl'><b>Raison:</b><br /></td>
	<td width='80%' class='tbl'><textarea name='reason' wrap=discuss rows=3 cols=34></textarea><br /></td><br />
	<td width='80%' class='tbl'><select name="date" id="lenght" class="select">
			<option value="1">1 heures</option>
			<option value="2">2 heures</option>
			<option value="3">3 heures</option>
			<option value="4">4 heures</option>
			<option value="10">10 heures</option>
			<option value="12">12 heures</option>
			<option value="24">1 jour</option>
			<option value="48">2 jours</option>
			<option value="72">3 jours</option>
			<option value="96">4 jours</option>
			<option value="168">1 semaine</option>
			<option value="336">2 semaines</option>
			<option value="672">1 mois</option>
			<option value="1344">2 mois</option>
			<option value="4032">6 mois</option>
			<option value="8064">1 an</option>
			<option value="16128">2 ans</option>
			<option value="525420">Permanent</option>
		</select>
		<tr>
			<td align='center' colspan='2' class='tbl'>
				<input type='submit' name='submit' value='Exécuter' class='submit'>
</form>
</tr>
</body>

</html>

</tr>