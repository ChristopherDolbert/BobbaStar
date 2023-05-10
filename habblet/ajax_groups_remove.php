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

foreach ($_POST as $key => $value) {
        if ($key == "targetIds") {
                if (empty($targets)) {
                        $targets = $value;
                } else {
                        $targets = $targets . "," . $value;
                }
        }
}

$targets = explode(",", $targets);

if (!is_numeric($groupid)) {
        exit;
}

// Vérification de l'appartenance de l'utilisateur à la guilde
$stmt = $bdd->prepare("SELECT member_rank FROM guilds_members WHERE user_id = :my_id AND guild_id = :groupid AND member_rank > 1 AND is_pending = '0' LIMIT 1");
$stmt->bindParam(':my_id', $user['id'], PDO::PARAM_INT);
$stmt->bindParam(':groupid', $groupid, PDO::PARAM_INT);
$stmt->execute();
$is_member = $stmt->rowCount();

if ($is_member > 0) {
        $my_membership = $stmt->fetch(PDO::FETCH_ASSOC);
        $member_rank = $my_membership['member_rank'];
        if ($member_rank < 2) {
                exit;
        }
} else {
        exit;
}

// Vérification de l'existence de la guilde
$stmt = $bdd->prepare("SELECT * FROM guilds WHERE id = :groupid LIMIT 1");
$stmt->bindParam(':groupid', $groupid, PDO::PARAM_INT);
$stmt->execute();
$valid = $stmt->rowCount();
if ($valid < 1) {
        exit;
}

// Suppression de chaque membre
foreach ($targets as $member) {
        if (is_numeric($member)) {
                $stmt = $bdd->prepare("DELETE FROM guilds_members WHERE user_id = :member AND guild_id = :groupid LIMIT 1");
                $stmt->bindParam(':member', $member, PDO::PARAM_INT);
                $stmt->bindParam(':groupid', $groupid, PDO::PARAM_INT);
                $stmt->execute();
        }
}

echo "OK";
exit;
