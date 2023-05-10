<?php
/*===================================================+
|| # HoloCMS - Website and Content Management System
|+===================================================+
|| # Copyright � 2008 Meth0d. All rights reserved.
|| # http://www.meth0d.org
|+===================================================+
|| # HoloCMS is provided "as is" and comes without
|| # warrenty of any kind. HoloCMS is free software!
|+===================================================*/

include('../config.php');

$i = 0;
$output = "[";
$getem = $bdd->query("SELECT * FROM messenger_friendships WHERE user_one_id = '" . $user['id'] . "' OR user_two_id = '" . $user['id'] . "'");

while ($row = $getem->fetch()) {
	$i++;

	if ($row['user_two_id'] == $user['id']) {
		$friendsql = $bdd->prepare("SELECT * FROM users WHERE id = :user_one_id");
		$friendsql->execute(['user_one_id' => $row['user_one_id']]);
	} else {
		$friendsql = $bdd->prepare("SELECT * FROM users WHERE id = :user_two_id");
		$friendsql->execute(['user_two_id' => $row['user_two_id']]);
	}

	if ($friendsql->rowCount() > 0) {
		$friendrow = $friendsql->fetch();

		$name = $friendrow['username'];
		$id = $friendrow['id'];

		$output .= "{\"id\":" . $id . ",\"name\":\"" . $name . "\"},";
	}
}
$output = substr_replace($output, "", -1);
$output .= "]";
?>
/*-secure-
<?php echo $output; ?>
*/