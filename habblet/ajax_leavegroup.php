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

$groupid = $_POST['groupId'];

if(is_numeric($groupid) && $groupid > 0){

	$check = $bdd->prepare("SELECT type FROM guilds WHERE id = :groupid LIMIT 1");
	$check->execute(array(':groupid' => $groupid));
	$exists = $check->rowCount();

	if($exists > 0){

		$check2 = $bdd->prepare("SELECT groupid FROM guilds_members WHERE user_id = :my_id AND group_id = :groupid LIMIT 1");
		$check2->execute(array(':my_id' => $user['id'], ':groupid' => $groupid));
		$already_member = $check2->rowCount();

		if($already_member > 0){

			$delete = $bdd->prepare("DELETE FROM guilds_members WHERE user_id = :my_id AND group_id = :groupid LIMIT 1");
			$delete->execute(array(':my_id' => $user['id'], ':groupid' => $groupid));
			echo "<script type=\"text/javascript\">\nlocation.href = habboReqPath + \"group_profile.php?id=".$groupid."\";\n</script>";
			echo "<p>You have successfully left this group.</p>";
			echo "<p>Please wait, you are being redirected..</p>";

		} else {

			exit;

		}

	} else {

		exit;

	}

}
