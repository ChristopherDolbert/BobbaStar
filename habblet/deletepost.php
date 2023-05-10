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

include '../config.php';

if (getContent('forum-enabled') !== "1") {
    header("Location: index.php");
    exit;
}

if (!isset($_SESSION['username'])) {
    exit;
}

$postid = $_POST['postId'];

if (is_numeric($postid)) {
    $stmt = $bdd->prepare("SELECT * FROM cms_forum_posts WHERE id = :postid LIMIT 1");
    $stmt->execute(['postid' => $postid]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $exists = $stmt->rowCount();
    if ($exists > 0) {
        if ($user_rank > 5 || $row['author'] == $_SESSION['username']) {
            $stmt = $bdd->prepare("DELETE FROM cms_forum_posts WHERE id = :id LIMIT 1");
            $stmt->execute(['id' => $row['id']]);

            // Recount the posts and update in DB
            $stmt = $bdd->prepare("SELECT COUNT(*) FROM cms_forum_posts WHERE threadid = :threadid");
            $stmt->execute(['threadid' => $row['threadid']]);
            $posts_left = $stmt->fetchColumn();

            // Get the real last post data
            if ($posts_left > 0) {
                $stmt = $bdd->prepare("SELECT author, date FROM cms_forum_posts WHERE threadid = :threadid ORDER BY id DESC LIMIT 1");
                $stmt->execute(['threadid' => $row['threadid']]);
                $lastpost = $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $lastpost['author'] = "Noone";
                $lastpost['date'] = "Never";
            }

            $posts_count = $posts_left - 1;

            $stmt = $bdd->prepare("UPDATE cms_forum_threads SET posts = :posts_count, lastpost_date = :lastpost_date, lastpost_author = :lastpost_author WHERE id = :threadid LIMIT 1");
            $stmt->execute(['posts_count' => $posts_count, 'lastpost_date' => $lastpost['date'], 'lastpost_author' => $lastpost['author'], 'threadid' => $row['threadid']]);

            if ($posts_left > 0) {
                echo "TOPIC_DELETED";
            } else { // If we found that there are no posts left [during recount], delete the thread as well
                $stmt = $bdd->prepare("DELETE FROM cms_forum_threads WHERE id = :threadid LIMIT 1");
                $stmt->execute(['threadid' => $row['threadid']]);
                echo "TOPIC_DELETED";
            }
        } else {
            exit;
        }
    } else {
        exit;
    }
} else {
    exit;
}
