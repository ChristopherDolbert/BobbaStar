<?php
include('../config.php');
$id = $_GET['songId'];

$selectQuery = "SELECT * FROM soundmachine_songs WHERE id = :id LIMIT 1";
$selectStmt = $bdd->prepare($selectQuery);
$selectStmt->bindParam(':id', $id);
$selectStmt->execute();
$mysql = $selectStmt->fetch(PDO::FETCH_ASSOC);

$song = $mysql['data'];
$song = substr($song, 0, -1);
$song = str_replace(":4:", "&track4=", $song);
$song = str_replace(":3:", "&track3=", $song);
$song = str_replace(":2:", "&track2=", $song);
$song = str_replace("1:", "&track1=", $song);

$selectUserQuery = "SELECT * FROM users WHERE id = :userid LIMIT 1";
$selectUserStmt = $bdd->prepare($selectUserQuery);
$selectUserStmt->bindParam(':userid', $mysql['userid']);
$selectUserStmt->execute();
$userrow = $selectUserStmt->fetch(PDO::FETCH_ASSOC);

$output = "status=0&name=".trim(nl2br(HoloText($mysql['title'])))."&author=".$userrow['name'].$song;
echo $output;
