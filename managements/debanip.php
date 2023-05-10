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

if (isset($_GET['do']) && $_GET['do'] == "ban" && isset($_POST['ip'])) {
	$ip = array_filter(explode(';', Secu($_POST['ip'])));
	$count = count($ip);

	if ($count > 0) {
		foreach ($ip as $value) {
			$check = $bdd->prepare("SELECT * FROM bans WHERE value = :value");
			$check->bindValue(':value', $value);
			$check->execute();

			if ($check->rowCount() > 0) {
				$insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
				$insertn1->bindValue(':pseudo', $user['username']);
				$insertn1->bindValue(':action', 'a procédé au débanissement de l\'ip <b>' . $value . '</b>');
				$insertn1->bindValue(':date', FullDate('full'));
				$insertn1->execute();

				$bdd->prepare("DELETE FROM bans WHERE value = :value")->bindValue(':value', $value)->execute();

				echo '<h4 class="alert_success">L\'adresse IP <b>' . $value . '</b> a été débannis.</h4>';
			} else {
				echo '<h4 class="alert_error">L\'adresse IP <b>' . $value . '</b> n\'est pas bannis.</h4>';
			}
		}
	} else {
		echo '<h4 class="alert_error">Les champs ne sont pas tous remplis.</h4>';
	}
}

?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />

<body></body>
<span id="titre">Débannir des adresses IP</span><br />
Débannis des IP que vous avez bannis précédemment.<br /><br />
<form name='editor' method='post' action="?do=ban">
	<td width='100' class='tbl'><b>Adresse IP:</b><br /></td>
	<td width='80%' class='tbl'><textarea name='ip' wrap=discuss rows=3 cols=34></textarea><br /></td>
	<br />
	<tr>
		<td align='center' colspan='2' class='tbl'>
			<input type='submit' name='submit' value='Exécuter' class='submit'>
</form>
</tr><br />
Voici la liste des bannis actuel.
<br />
<table>
	<tbody>
		<tr class="haut">
			<td class="haut">IP</td>
			<td class="haut">Raison</td>
			<td class="haut">Banni par</td>
			<td class="haut">Jusqu'au</td>
		</tr>
		<?php
		$sql = $bdd->query("SELECT * FROM bans WHERE type='ip' ORDER BY id DESC");
		while ($a = $sql->fetch()) {
			$stamp_expire = $a['ban_expire'];
			$expire = date('d/m/Y H:i', $a['ban_expire']);

			// Recherche de l'utilisateur qui a banni
			$user_staff_id = $a['user_staff_id'];
			$sql2 = $bdd->prepare("SELECT * FROM users WHERE id = :user_id");
			$sql2->bindParam(':user_id', $user_staff_id);
			$sql2->execute();
			$users = $sql2->fetch();

		?>
			<tr class="bas">
				<td class="bas"><?php echo $a['value']; ?></td>
				<td class="bas"><?php echo $a['ban_reason']; ?></td>
				<td class="bas"><?php echo $users['username']; ?></td>
				<td class="bas"><?php echo $expire; ?></td>
			</tr>
		<?php } ?>

	</tbody>
</table>
</body>

</html>