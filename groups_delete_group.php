<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("./config.php");

// simple check to avoid most direct access
$refer = $_SERVER['HTTP_REFERER'];
$pos = strrpos($refer, "group_profile.php");
if ($pos === false) {
    exit;
}

$groupid = $_POST['groupId'];
if (!is_numeric($groupid)) {
    exit;
}

$check = $bdd->prepare("SELECT member_rank FROM guilds_members WHERE user_id = ? AND guild_id = ? AND member_rank > 1 AND is_pending = '0' LIMIT 1");
$check->execute([$my_id, $groupid]);
$is_member = $check->rowCount();

if ($is_member > 0) {
    $my_membership = $check->fetch(PDO::FETCH_ASSOC);
    $member_rank = $my_membership['member_rank'];
} else {
    exit;
}

$check = $bdd->prepare("SELECT * FROM guilds WHERE id = ? LIMIT 1");
$check->execute([$groupid]);
$valid = $check->rowCount();

if ($valid > 0) {
    $groupdata = $check->fetch(PDO::FETCH_ASSOC);
    $ownerid = $groupdata['ownerid'];
} else {
    exit;
}

if ($ownerid !== $my_id) {
    exit;
} elseif ($ownerid == $my_id) {

    error_reporting(0);
    $image = "habbo-imaging/badge-fill/{$groupdata['badge']}.gif";
    if (file_exists($image)) {
        unlink($image);
    }
    error_reporting(1);
    $bdd->prepare("DELETE FROM guilds WHERE id = ? LIMIT 1")->execute([$groupid]);
    $bdd->prepare("DELETE FROM guilds_members WHERE guild_id = ?")->execute([$groupid]);
    $bdd->prepare("DELETE FROM cms_homes_group_linker WHERE groupid = ?")->execute([$groupid]);
    $bdd->prepare("DELETE FROM cms_homes_stickers WHERE groupid = ?")->execute([$groupid]);
    echo "<p>\nThe group has been deleted successfully.\n</p>\n\n<p>\n<a href=\"me.php\" class=\"new-button\"><b>OK</b><i></i></a>\n</p>\n\n<div class=\"clear\"></div>";
}
