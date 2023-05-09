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
if (!is_numeric($groupid)) {
        exit;
}

$check = $bdd->prepare("SELECT * FROM guilds WHERE id = ? LIMIT 1");
$check->bind_param("i", $groupid);
$check->execute();
$valid = $check->get_result();

if (mysqli_num_rows($valid) < 1) {
        exit;
}

// Loop through all the members
foreach ($targets as $member) {
        if (is_numeric($member)) {
                $valid = $bdd->prepare("SELECT COUNT(*) FROM users WHERE id = ? LIMIT 1");
                $valid->bind_param("i", $member);
                $valid->execute();
                $count = $valid->get_result();

                if (mysqli_fetch_assoc($count)['COUNT(*)'] > 0) {
                        $update = $bdd->prepare("UPDATE guilds_members SET is_pending = '0' WHERE user_id = ? AND guild_id = ? LIMIT 1");
                        $update->bind_param("ii", $member, $groupid);
                        $update->execute();
                }
        }
}

echo "OK";
exit;
