<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|


include("../config.php");

$refer = $_SERVER['HTTP_REFERER'];
$pos = strrpos($refer, "group_profile.php");
if ($pos === false) { exit; }

$groupid = $_POST['groupId'];

$targets = $_POST['targetIds'];
$targets = explode(",", $targets);

if(!is_numeric($groupid)){ exit; }

$stmt = $bdd->prepare("SELECT member_rank FROM guilds_members WHERE user_id = ? AND guild_id = ? AND member_rank > 1 AND is_pending = '0' LIMIT 1");
$stmt->bind_param("ii", $my_id, $groupid);
$stmt->execute();
$check = $stmt->get_result();
$is_member = mysqli_num_rows($check);

if($is_member > 0){
	$my_membership = mysqli_fetch_assoc($check);
	$member_rank = $my_membership['member_rank'];
	if($member_rank < 2){ exit; }
} else {
	exit;
}

$stmt = $bdd->prepare("SELECT * FROM guilds WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $groupid);
$stmt->execute();
$check = $stmt->get_result();
$valid = mysqli_num_rows($check);
if($valid < 1){ exit; }

// Loop through all the members
foreach($targets as $member){
	header("X-Whatever: \"Fuck you ".$member."\"");
	if(is_numeric($member)){
		$stmt = $bdd->prepare("SELECT COUNT(*) FROM users WHERE id = ? LIMIT 1");
		$stmt->bind_param("i", $member);
		$stmt->execute();
		$valid = $stmt->get_result();
		$valid = mysqli_fetch_array($valid)[0];
		if($valid > 0){
			$stmt = $bdd->prepare("DELETE FROM guilds_members WHERE user_id = ? AND guild_id = ? LIMIT 1");
			$stmt->bind_param("ii", $member, $groupid);
			$stmt->execute();
		}
	}
}

echo "OK";
exit;
