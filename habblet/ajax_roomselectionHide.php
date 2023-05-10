<?php
include('../core.php');
$stmt = $bdd->prepare("UPDATE users SET noob = '0' WHERE id = :id");
$stmt->bindParam(':id', $user['id']);
$stmt->execute();
