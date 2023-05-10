<?php
include('../config.php');

$stmt = $bdd->prepare("UPDATE users SET hc_before = '0' WHERE id = :my_id LIMIT 1");
$stmt->execute(['my_id' => $user['id']]);
