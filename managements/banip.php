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
	$ip = Secu($_POST['ip']);
	$raison = Secu($_POST['reason']);
	$date = Secu($_POST['date']);
	$do = Secu($_GET['do']);

	if ($do == "ban") {
		$ip = explode(";", $ip);
		$nbr = count($ip);
		$date_ac = time();
		$date_calcul = $date * 3600;
		$date_ban = $date_ac + $date_calcul;

		if (isset($ip) && isset($raison) && isset($date) && !empty($ip) && !empty($raison) && !empty($date)) {
			foreach ($ip as $current_ip) {
				$sql = $bdd->query("SELECT id FROM users WHERE ip_current = '" . $current_ip . "'");
				$row = $sql->rowCount();
				if ($row > 0) {
					$insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
					$insertn1->execute(array(
						':pseudo' => $user['username'],
						':action' => 'a banni l\'adresse IP <b>' . $current_ip . '</b> pour la raison suivante : <i>' . $raison . '</i>',
						':date' => FullDate('full')
					));
					$bdd->query("INSERT INTO bans (type,value,ban_reason,ban_expire,user_staff_id,timestamp) VALUES ('ip','" . $current_ip . "','" . $raison . "','" . $date_ban . "','" . $user['username'] . "','" . time() . "')");
					echo '<h4 class="alert_success">L\'adresse IP <b>' . $current_ip . '</b> a été bannie pour la raison suivante : <b>' . $raison . '</b></h4>';
				} else {
					echo '<h4 class="alert_error">L\'adresse IP <b>' . $current_ip . '</b> n\'existe pas.</h4>';
				}
			}
		} else {
			echo '<h4 class="alert_error">Les champs ne sont pas tous remplis.</h4>';
		}
	}
}

?>

<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />

<body>
	<span id="titre">Bannir des adresses IP</span><br />
	Bannis plusieurs adresses IP en m&ecirc;me temps pour cela apr&egrave;s chaque IP mettez un point virgule (;). <a href="look_up" target="main">Trouver une adresse IP</a><br /><br />
	<form name='editor' method='post' action="?do=ban">
		<td width='100' class='tbl'><b>Adresse IP:</b><br /></td>
		<td width='80%' class='tbl'><textarea name='ip' wrap=discuss rows=3 cols=34></textarea><br /></td>
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