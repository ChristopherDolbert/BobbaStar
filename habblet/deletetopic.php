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

if (getContent('forum-enabled') !== "1") {
	header("Location: index.php");
	exit;
}
if (!$user['id']) {
	exit;
}

$topicid = $_POST['topicId'];

if (is_numeric($topicid)) {
	if ($user_rank > 5) {
		$check = $bdd->prepare("SELECT id FROM cms_forum_threads WHERE id = ?");
		$check->execute(array($topicid));
		$exists = $check->rowCount();
		if ($exists > 0) {
			$bdd->prepare("DELETE FROM cms_forum_threads WHERE id = ?")->execute(array($topicid));
			$bdd->prepare("DELETE FROM cms_forum_posts WHERE threadid = ?")->execute(array($topicid));
			echo "SUCCESS";
			exit;
		} else {
			exit;
		}
	} else {
		exit;
	}
} else {
	exit;
}
