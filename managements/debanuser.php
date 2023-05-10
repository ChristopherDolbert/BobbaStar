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
	$do = Secu($_GET['do']);
	if ($do == "ban") {
		if (isset($_POST['name'])) {
			$names = explode(";", Secu($_POST['name']));
			$bans = array();
			foreach ($names as $name) {
				$sql = $bdd->query("SELECT id FROM users WHERE username = '" . $name . "'");
				$row = $sql->rowCount();
				if ($row < 1) {
					echo '<h4 class="alert_error">Le compte <b>' . $name . '</b> n\'existe pas.</h4>';
				} else {
					$check = $bdd->query("SELECT * FROM bans WHERE value = '" . $name . "'");
					$row_c = $check->rowCount();
					if ($row_c > 0) {
						$insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
						$insertn1->bindValue(':pseudo', $user['username']);
						$insertn1->bindValue(':action', 'a procédé au débanissement de <b>' . $name . '</b>');
						$insertn1->bindValue(':date', FullDate('full'));
						$insertn1->execute();
						$bdd->query("DELETE FROM bans WHERE value = '" . $name . "'");
						$bans[] = $name;
					} else {
						echo '<h4 class="alert_error">Le compte <b>' . $name . '</b> n\'est pas bannis.</h4>';
					}
				}
			}
			if (!empty($bans)) {
				$bans_text = implode(', ', $bans);
				echo '<h4 class="alert_success">Les comptes suivants ont été débannis : <b>' . $bans_text . '</b></h4>';
			}
		} else {
			echo '<h4 class="alert_error">Les champs ne sont pas tous remplis.</h4>';
		}
	}
}

?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />

<body></body>
<span id="titre">Débannir des utilisateurs</span><br />
Débannis plusieurs utilisateurs en m&ecirc;me temps pour cela apr&egrave;s chaque pseudo mettez un point virgule (;).<br /><br />
<form name='editor' method='post' action="?do=ban">
	<td width='100' class='tbl'><b>Pseudo:</b><br /></td>
	<td width='80%' class='tbl'><textarea name='name' wrap=discuss rows=3 cols=34></textarea><br /></td>
	<br />
	<tr>
		<td align='center' colspan='2' class='tbl'>
			<input type='submit' name='submit' value='Exécuter' class='submit'>
</form>
</tr><br />
Voici la liste des bannis actuel.<br />
<table>
	<tbody>
		<tr class="haut">
			<td class="haut">Pseudo</td>
			<td class="haut">Raison</td>
			<td class="haut">Banni par</td>
			<td class="haut">Jusqu'au</td>
		</tr>
		<?PHP
		$sql = $bdd->query("SELECT * FROM bans WHERE type='user' ORDER BY id DESC");
		while ($a = $sql->fetch()) {
			$expire = date('d/m/Y H:i', $a['ban_expire']);
		?>
			<tr class="bas">
				<td class="bas"><?PHP echo $a['value']; ?></td>
				<td class="bas"><?PHP echo $a['reason']; ?></td>
				<td class="bas"><?PHP echo $a['added_by']; ?></td>
				<td class="bas"><?PHP echo $expire; ?></td>
			</tr>
		<?PHP } ?>
	</tbody>
</table>
</body>

</html>