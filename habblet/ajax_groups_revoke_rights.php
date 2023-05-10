<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|


include("../config.php");
// assuming $bdd is a PDO instance already created

$referer = $_SERVER['HTTP_REFERER'];
$pos = strrpos($referer, "group_profile.php");
if ($pos === false) {
        exit;
}

$groupid = $_POST['groupId'];
$targets = $_POST['targetIds'];
$targets = explode(",", $targets);

if (!is_numeric($groupid)) {
        exit;
}

// Check if the user is a member and has permission
$check_member = $bdd->prepare("SELECT member_rank FROM guilds_members WHERE user_id = :user_id AND guild_id = :guild_id AND member_rank > 1 AND is_pending = 0 LIMIT 1");
$check_member->execute(array(':user_id' => $user['id'], ':guild_id' => $groupid));
$is_member = $check_member->rowCount();

if ($is_member > 0) {
        $my_membership = $check_member->fetch(PDO::FETCH_ASSOC);
        $member_rank = $my_membership['member_rank'];
        if ($member_rank < 2) {
                exit;
        }
} else {
        exit;
}

// Check if the group exists
$check_group = $bdd->prepare("SELECT * FROM guilds WHERE id = :guild_id LIMIT 1");
$check_group->execute(array(':guild_id' => $groupid));
$valid = $check_group->rowCount();

if ($valid < 1) {
        exit;
}

// Loop through all the members
foreach ($targets as $member) {
        if (is_numeric($member)) {
                $check_user = $bdd->prepare("SELECT COUNT(*) FROM users WHERE id = :user_id LIMIT 1");
                $check_user->execute(array(':user_id' => $member));
                $valid = $check_user->fetchColumn();
                if ($valid > 0) {
                        $update_member = $bdd->prepare("UPDATE guilds_members SET member_rank = 1 WHERE user_id = :user_id AND guild_id = :guild_id LIMIT 1");
                        $update_member->execute(array(':user_id' => $member, ':guild_id' => $groupid));
                }
        }
}

echo "OK";
exit;
