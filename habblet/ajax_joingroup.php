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

include('../core.php');
include('../includes/session.php');

$groupid = $_POST['groupId'];

if (is_numeric($groupid) && $groupid > 0) {
    $check = $bdd->prepare("SELECT type FROM groups_details WHERE id = :groupid");
    $check->execute(['groupid' => $groupid]);
    $exists = $check->rowCount();

    if ($exists > 0) {
        $check2 = $bdd->prepare("SELECT groupid FROM groups_memberships WHERE userid = :my_id AND groupid = :groupid");
        $check2->execute(['my_id' => $user['id'], 'groupid' => $groupid]);
        $already_member = $check2->rowCount();

        $memberships = $bdd->prepare("SELECT COUNT(*) FROM groups_memberships WHERE userid = :my_id");
        $memberships->execute(['my_id' => $user['id']]);
        $memberships = $memberships->fetchColumn();

        if ($memberships > 9) {
            echo "<p>You are already a member of 10 or more groups or have pending requests to join them.</p>\n";
            echo "<p><a href=\"#\" class=\"new-button\" id=\"group-action-ok\"><b>OK</b><i></i></a></p>\n";
            echo "<div class=\"clear\"></div>";
            exit;
        }

        if ($already_member > 0) {
            echo "<p>You are already a member of this group or have already requested to join it.</p>\n";
            echo "<p><a href=\"#\" class=\"new-button\" id=\"group-action-ok\"><b>OK</b><i></i></a></p>\n";
            echo "<div class=\"clear\"></div>";
            exit;
        } else {
            $groupdata = $check->fetch();
            $type = $groupdata['type'];
            $members = $bdd->prepare("SELECT COUNT(*) FROM groups_memberships WHERE groupid = :groupid AND is_pending = '0'");
            $members->execute(['groupid' => $groupid]);
            $members = $members->fetchColumn();

            if ($type == "0" || $type == "3") {
                if ($type == "0" && $members < 500 || $type == "3") {
                    echo "<p>You have now joined this group.</p>\n";
                    echo "<p><a href=\"#\" class=\"new-button\" id=\"group-action-ok\"><b>OK</b><i></i></a></p>\n";
                    echo "<div class=\"clear\"></div>";
                    $insert = $bdd->prepare("INSERT INTO groups_memberships (userid,groupid,member_rank,is_current,is_pending) VALUES (:my_id,:groupid,'1','0','0')");
                    $insert->execute(['my_id' => $user['id'], 'groupid' => $groupid]);
                    exit;
                } else {
                    echo "<p>This group is full.</p>\n";
                    echo "<p><a href=\"#\" class=\"new-button\" id=\"group-action-ok\"><b>OK</b><i></i></a></p>\n";
                    echo "<div class=\"clear\"></div>";
                    exit;
                }
			} elseif ($type == "1") {
				echo "<p>A request to join this group has been made. The group owner will have to accept you before you can join.</p>\n";
				echo "<p><a href=\"#\" class=\"new-button\" id=\"group-action-ok\"><b>OK</b><i></i></a></p>\n";
				echo "<div class=\"clear\"></div>";
				echo "<p>\nAn request to join this group has been made. The group owner will have to accept you before you join this group.\n</p>\n\n<p>\n<a href=\"#\" class=\"new-button\" id=\"group-action-ok\"><b>OK</b><i></i></a>\n</p>\n\n\n<div class=\"clear\"></div>";
				
				$query = "INSERT INTO groups_memberships (userid,groupid,member_rank,is_current,is_pending) VALUES (:my_id,:groupid,'1','0','1')";
				$stmt = $bdd->prepare($query);
				$stmt->execute(array(':my_id' => $user['id'], ':groupid' => $groupid));
				exit;
			} elseif ($type == "2") { // no one can join
				echo "<p>\nSorry, but this group is closed. No one can join this group!\n</p>\n\n<p>\n<a href=\"#\" class=\"new-button\" id=\"group-action-ok\"><b>OK</b><i></i></a>\n</p>\n\n\n<div class=\"clear\"></div>";
				exit;
			}
		}}}
