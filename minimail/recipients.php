<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include('../config.php');

$i = 0;
$output = "[";
$getem = $bdd->query("SELECT * FROM messenger_friendships WHERE user_one_id = '" . $my_id . "' OR user_two_id = '" . $my_id . "'");

while ($row = $getem->fetch(PDO::FETCH_ASSOC)) {
	$i++;

	if ($row['friendid'] == $my_id) {
		$friendsql = $bdd->prepare("SELECT * FROM users WHERE id = ?");
		$friendsql->execute([$row['userid']]);
	} else {
		$friendsql = $bdd->prepare("SELECT * FROM users WHERE id = ?");
		$friendsql->execute([$row['friendid']]);
	}

	$friendrow = $friendsql->fetch(PDO::FETCH_ASSOC);

	$name = $friendrow['username'];
	$id = $friendrow['id'];

	$output = $output . "{\"id\":" . $id . ",\"name\":\"" . $name . "\"},";
}
$output = substr_replace($output, "", -1);
$output = $output . "]";
?>
/*-secure-
<?php echo $output; ?>
*/