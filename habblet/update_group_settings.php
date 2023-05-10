<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|


include("../config.php");

$groupid = $_POST['groupId'];
if(!is_numeric($groupid)){ exit; }

$check = $bdd->prepare("SELECT member_rank FROM guilds_members WHERE user_id = :my_id AND guild_id = :groupid AND member_rank > 1 AND is_pending = '0' LIMIT 1");
$check->bindParam(':my_id', $user['id']);
$check->bindParam(':groupid', $groupid);
$check->execute();

$is_member = $check->rowCount();

if($is_member > 0){
	$my_membership = $check->fetch(PDO::FETCH_ASSOC);
	$member_rank = $my_membership['member_rank'];
} else {
	echo "Editing group settings unsuccessful\n\n<p>\n<a href=\"group_profile.php?id=".$groupid."\" class=\"new-button\"><b>Done</b><i></i></a>\n</p>\n\n<div class=\"clear\"></div>";
	exit;
}

$check = $bdd->prepare("SELECT * FROM guilds WHERE id = :groupid LIMIT 1");
$check->bindParam(':groupid', $groupid);
$check->execute();

$valid = $check->rowCount();

if($valid > 0){
	$groupdata = $check->fetch(PDO::FETCH_ASSOC);
	$ownerid = $groupdata['ownerid'];
} else {
	echo "Editing group settings unsuccessful\n\n<p>\n<a href=\"group_profile.php?id=".$groupid."\" class=\"new-button\"><b>Done</b><i></i></a>\n</p>\n\n<div class=\"clear\"></div>";
	exit;
}


if($ownerid !== $user['id']){ exit; }

$name = trim(FilterText($_POST['name']));
$description = trim(FilterText($_POST['description']));
$type = $_POST['type'];

if($groupdata['type'] == "3" && $_POST['type'] !== "3"){ echo "You may not change the group type if it is set to 3."; exit; } // you can't change the group type once you set it to 4, fool
if($type < 0 || $type > 3){ echo "Invalid group type."; exit; } // this naughty user doesn't even deserve an settings update

if(strlen(FilterText($name)) > 25){
	echo "Name too long\n\n<p>\n<a href=\"group_profile.php?id=".$groupid."\" class=\"new-button\"><b>Done</b><i></i></a>\n</p>\n\n<div class=\"clear\"></div>";
} elseif(strlen(FilterText($description)) > 200){
	echo "Description too long\n\n<p>\n<a href=\"group_profile.php?id=".$groupid."\" class=\"new-button\"><b>Done</b><i></i></a>\n</p>\n\n<div class=\"clear\"></div>";
} elseif(strlen(FilterText($name)) < 1){
	echo "Please give a name\n\n<p>\n<a href=\"group_profile.php?id=".$groupid."\" class=\"new-button\"><b>Done</b><i></i></a>\n</p>\n\n<div class=\"clear\"></div>";	
} else {
	$update = $bdd->prepare("UPDATE guilds SET name = :name, description = :description, state = :type WHERE id = :groupid AND user_id = :my_id LIMIT 1");
	$update->bindParam(':name', $name);
	$update->bindParam(':description', $description);
	$update->bindParam(':type', $type);
	$update->bindParam(':groupid', $groupid);
	$update->bindParam(':my_id', $user['id']);
	$update->execute();

	echo "Editing group settings successful\n\n<p>\n<a href=\"group_profile.php?id=".$groupid."\" class=\"new-button\"><b>Done</b><i></i></a>\n</p>\n\n<div class=\"clear\"></div>";
}
