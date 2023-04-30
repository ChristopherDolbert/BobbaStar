<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include('../core.php');
include('../includes/session.php');

$id = $_POST['messageId'];
$start = $_POST['start'];
$label = $_POST['label'];

$stmt = $bdd->prepare("UPDATE cms_minimail SET deleted = '0' WHERE id = ?");
$stmt->execute([$id]);

$bypass = "true";
$page = "inbox";
$message = "Message undeleted.";
include('loadMessage.php');
