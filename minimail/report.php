<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include('../config.php');

$id = $_POST['messageId'];
$start = $_POST['start'];
$label = $_POST['label'];

$stmt = $bdd->prepare("SELECT NOW()");
$stmt->execute();
$date = $stmt->fetchColumn();

$stmt = $bdd->prepare("SELECT * FROM cms_minimail WHERE id = ? LIMIT 1");
$stmt->execute([$id]);
$row = $stmt->fetch();

$stmt = $bdd->prepare("INSERT INTO cms_help (username,ip,message,date,picked_up,subject,roomid) VALUES (?, ?, ?, ?, '0', ?, '0')");
$stmt->execute([$name, $remote_ip, 'Minimail Message: ' . $row['message'], $date, 'Reported Minimail Message: ' . $row['subject']]);

$stmt = $bdd->prepare("DELETE FROM messenger_friendships WHERE user_one_id = ? AND user_two_id = ? LIMIT 1");
$stmt->execute([$my_id, $row['senderid']]);

$stmt = $bdd->prepare("DELETE FROM messenger_friendships WHERE user_one_id = ? AND user_two_id = ? LIMIT 1");
$stmt->execute([$row['senderid'], $my_id]);

$stmt = $bdd->prepare("DELETE FROM cms_minimail WHERE id = ? LIMIT 1");
$stmt->execute([$id]);

$bypass = "true";
$page = $label;
$startpage = $start;
$message = "Message reported sucessfully, and friend removed.";
include('loadMessage.php');
