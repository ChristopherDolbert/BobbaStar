<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("./config.php");

$groupid = $_POST['groupId'];
$badge = $_POST['code'];
$appkey = $_POST['__app_key'];

if (!is_numeric($groupid)) {
    exit;
}
if ($appkey !== "Meth0d.org") {
    exit;
}

$badge = str_replace("NaN", "", $badge); // NaN = invalid stuff

$stmt = $bdd->prepare("SELECT member_rank FROM guilds_members WHERE user_id = ? AND guild_id = ? AND member_rank > 1 AND is_pending = '0' LIMIT 1");
$stmt->bind_param('ii', $my_id, $groupid);
$stmt->execute();
$result = $stmt->get_result();
$is_member = mysqli_num_rows($result);

if ($is_member > 0) {
    $my_membership = mysqli_fetch_assoc($result);
    $member_rank = $my_membership['member_rank'];
    if ($member_rank < 2) {
        exit;
    }
} else {
    exit;
}

$stmt = $bdd->prepare("SELECT * FROM guilds WHERE id = ? LIMIT 1");
$stmt->bind_param('i', $groupid);
$stmt->execute();
$result = $stmt->get_result();
$valid = mysqli_num_rows($result);
$row = mysqli_fetch_assoc($result);
if ($valid > 0) {
    $groupdata = mysqli_fetch_assoc($result);
} else {
    exit;
}
if ($badge != $row['badge']) {
    if ($row['badge'] != 'b0503Xs09114s05013s05015') {
        $image = "habbo-imaging/badge-fill/".$row['badge'].".gif";
        if (file_exists($image)) {
            unlink($image);
        }
    } else {
        $stmt = $bdd->prepare("UPDATE guilds SET badge = ? WHERE id = ? LIMIT 1");
        $stmt->bind_param('si', FilterText($badge), $groupid);
        $stmt->execute();
        header("Location: group_profile.php?id=".$groupid."&x=BadgeUpdated");
        exit;
    }
}
$stmt = $bdd->prepare("UPDATE guilds SET badge = ? WHERE id = ? LIMIT 1");
$stmt->bind_param('si', FilterText($badge), $groupid);
$stmt->execute();
header("Location: group_profile.php?id=".$groupid."&x=BadgeUpdated");
exit;
