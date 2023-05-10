<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include '../config.php';

$label = $_POST['label'];
$id = $_POST['messageId'];
$start = $_POST['start'];
$conversation = $_POST['conversationId'];

$sql = $bdd->prepare("SELECT * FROM cms_minimail WHERE id = :id LIMIT 1");
$sql->bindParam(':id', $id);
$sql->execute();
$row = $sql->fetch(PDO::FETCH_ASSOC);

if ($row['deleted'] == "1") {
    $sql = $bdd->prepare("DELETE FROM cms_minimail WHERE id = :id LIMIT 1");
    $sql->bindParam(':id', $id);
    $sql->execute();
    $bypass = "true";
    $page = "trash";
    $message = "The message has been deleted successfully";
    include 'loadMessage.php';
} else {
    $sql = $bdd->prepare("UPDATE cms_minimail SET deleted = '1' WHERE id = :id LIMIT 1");
    $sql->bindParam(':id', $id);
    $sql->execute();
    $bypass = "true";
    $page = "inbox";
    $message = "The message has been moved to the trash. You can undelete it, if you wish";
    include 'loadMessage.php';
}
