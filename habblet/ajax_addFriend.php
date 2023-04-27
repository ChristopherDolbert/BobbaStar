<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");
$my_id = $user['id'];
$id = $_POST['accountId'];

$sql = "SELECT COUNT(*) as count FROM messenger_friendships WHERE (user_one_id = :id AND user_two_id = :my_id) OR (user_one_id = :my_id AND user_two_id = :id)";
$stmt1 = $bdd->prepare($sql);
$stmt1->execute([':id' => $id, ':my_id' => $my_id]);
$rows1 = $stmt1->fetchColumn();
$message = ($rows1 > 0) ? "Cette personne est déjà votre amie." : null;
$error = (bool) $message;

$stmt2 = $bdd->prepare("SELECT COUNT(*) FROM messenger_friendships WHERE (user_one_id = :my_id AND user_two_id = :id) OR (user_one_id = :id AND user_two_id = :my_id)");
$stmt2->execute([':my_id' => $my_id, ':id' => $id]);
$rows2 = $stmt2->fetchColumn();
$message = $rows2 ? "Cette personne est déjà votre amie." : '';
$error = (bool) $rows2;

$stmt3 = $bdd->prepare("SELECT COUNT(*) FROM messenger_friendrequests WHERE (user_from_id = :my_id AND user_to_id = :id) OR (user_from_id = :id AND user_to_id = :my_id)");
$stmt3->execute([':my_id' => $my_id, ':id' => $id]);
$rows3 = $stmt3->fetchColumn();
$message = $rows3 ? "Vous avez déjà demandé l'amitié de cette personne." : '';
$error = (bool) $rows3;

$stmt4 = $bdd->prepare("SELECT COUNT(*) FROM messenger_friendrequests WHERE (user_to_id = :my_id AND user_from_id = :id) OR (user_to_id = :id AND user_from_id = :my_id)");
$stmt4->execute([':my_id' => $my_id, ':id' => $id]);
$rows4 = $stmt4->fetchColumn();
$message = $rows4 ? "Cette personne vous a déjà demandé d'être son ami." : '';
$error = (bool) $rows4;

$error = $id === $my_id;
$message = $error ? "Vous ne pouvez pas vous demander en ami." : '';

if (!$error) {
	$sql = $bdd->prepare("SELECT COALESCE(MAX(requestid), 0) + 1 FROM messenger_friendrequests WHERE user_to_id = :id");
	$sql->execute([':id' => $id]);
	$requestid = $sql->fetchColumn();
	$insert = $bdd->prepare("INSERT INTO messenger_friendrequests (user_from_id, user_to_id, requestid) VALUES (:my_id, :id, :requestid)");
	$insert->execute([':my_id' => $my_id, ':id' => $id, ':requestid' => $requestid]);
	$message = $insert->rowCount() ? "La demande d'ami a été envoyée avec succès." : '';
}

?>

<div id="avatar-habblet-dialog-body" class="topdialog-body">
	<ul>
		<li><?php echo $message; ?></li>
	</ul>
	<p>
		<a href="#" class="new-button done"><b>Done</b><i></i></a>
	</p>
</div>