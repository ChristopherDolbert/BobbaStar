<?php
include('../core.php');

$entryid = $_POST['entryId'];
$widgetid = $_POST['widgetId'];

$deleteQuery = "DELETE FROM cms_guestbook WHERE id = :entryid LIMIT 1";
$deleteStmt = $bdd->prepare($deleteQuery);
$deleteStmt->bindParam(':entryid', $entryid);
$deleteStmt->execute();
