<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|


include("../config.php");

$groupid = $_POST['groupId'];

if (is_numeric($groupid) && $groupid > 0) {

	$check = $bdd->prepare("SELECT type FROM guilds WHERE id = :groupid LIMIT 1");
	$check->bindParam(':groupid', $groupid);
	$check->execute();
	$exists = $check->rowCount();

	if ($exists > 0) {

		$check2 = $bdd->prepare("SELECT guild_id FROM guilds_members WHERE user_id = :my_id AND guild_id = :groupid LIMIT 1");
		$check2->bindParam(':my_id', $user['id']);
		$check2->bindParam(':groupid', $groupid);
		$check2->execute();
		$already_member = $check2->rowCount();

		if ($already_member > 0) {

			$update1 = $bdd->prepare("UPDATE guilds_members SET is_current = '0' WHERE user_id = :my_id");
			$update1->bindParam(':my_id', $user['id']);
			$update1->execute();

			$update2 = $bdd->prepare("UPDATE guilds_members SET is_current = '1' WHERE user_id = :my_id AND guild_id = :groupid LIMIT 1");
			$update2->bindParam(':my_id', $user['id']);
			$update2->bindParam(':groupid', $groupid);
			$update2->execute();
		} else {
			exit;
		}
	} else {

		exit;
	}
}
