<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|


include("../config.php");

$refer = $_SERVER['HTTP_REFERER'];
$pos = strrpos($refer, "group_profile.php");
if ($pos === false) {
    exit;
}

$groupid = $_POST['groupId'];

$targets = $_POST['targetIds'];
$targets = explode(",", $targets);

if(!is_numeric($groupid)) {
    exit;
}

$stmt = $bdd->prepare("SELECT member_rank FROM guilds_members WHERE user_id = ? AND guild_id = ? AND member_rank > 1 AND is_pending = '0' LIMIT 1");
$stmt->bind_param("ii", $user['id'], $groupid);
$stmt->execute();
$result = $stmt->get_result();
$my_membership = $result->fetch_assoc();
$is_member = $result->num_rows;

if($is_member > 0) {
	$member_rank = $my_membership['member_rank'];
	if($member_rank < 2){
	    exit;
    }
} else {
	exit;
}

$stmt = $bdd->prepare("SELECT * FROM guilds WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $groupid);
$stmt->execute();
$result = $stmt->get_result();
$valid = $result->num_rows;
if($valid < 1) {
    exit;
}

// Loop through all the members
foreach($targets as $member) {
    if(is_numeric($member)) {
        $stmt = $bdd->prepare("UPDATE guilds_members SET member_rank = '2' WHERE user_id = ? AND guild_id = ? LIMIT 1");
        $stmt->bind_param("ii", $member, $groupid);
        $stmt->execute();
    }
}

echo "OK";
exit;
