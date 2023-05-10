<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|


include("../config.php");

$groupid = $_POST['groupId'];

if (is_numeric($groupid) && $groupid > 0) {

	$check = $bdd->query("SELECT type FROM guilds WHERE id = '" . $groupid . "' LIMIT 1");
	$exists = $check->rowCount();

	if ($exists > 0) {

		$check2 = $bdd->query("SELECT guild_id FROM guilds_members WHERE user_id = '" . $my_id . "' AND guild_id = '" . $groupid . "' LIMIT 1");
		$already_member = $check2->rowCount();

		if ($already_member > 0) {

			$bdd->query("UPDATE guilds_members SET is_current = '0' WHERE user_id = '" . $my_id . "' AND guild_id = '" . $groupid . "' LIMIT 1");
		} else {
			exit;
		}
	} else {

		exit;
	}
}
