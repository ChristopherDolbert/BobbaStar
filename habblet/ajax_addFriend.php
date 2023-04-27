<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");
$my_id = $user['id'];
$id = $_POST['accountId'];

$stmt = $bdd->prepare("SELECT * FROM messenger_friendships WHERE user_one_id = :id AND user_two_id = :my_id");
$stmt->bindParam(':id', $id);
$stmt->bindParam(':my_id', $my_id);
$stmt->execute();
$rows = $stmt->rowCount();
if ($rows !== 0) {
	$error = 1;
	$message = "This person is already your friend.";
}


$stmt = $bdd->prepare("SELECT * FROM messenger_friendships WHERE user_one_id = :my_id AND user_two_id = :id");
$stmt->bindParam(':my_id', $my_id);
$stmt->bindParam(':id', $id);
$stmt->execute();
$rows = $stmt->rowCount();
if ($rows !== 0) {
	$error = 1;
	$message = "This person is already your friend.";
}


$stmt = $bdd->prepare("SELECT * FROM messenger_friendrequests WHERE user_from_id = :my_id AND user_to_id = :id");
$stmt->bindParam(':my_id', $my_id);
$stmt->bindParam(':id', $id);
$stmt->execute();
$rows = $stmt->rowCount();
if ($rows !== 0) {
	$error = 1;
	$message = "You already requested a friendship from this person.";
}


$sql = $bdd->prepare("SELECT * FROM messenger_friendrequests WHERE user_to_id = :my_id AND user_from_id = :id");
$sql->bindParam(':my_id', $my_id);
$sql->bindParam(':id', $id);
$sql->execute();
$rows = $sql->rowCount();
if ($rows <> 0) {
	$error = 1;
	$message = "This person already requested you to be their friend.";
}


if ($id == $my_id) {
	$error = 1;
	$message = "You cannot friend request yourself.";
}

if ($error <> 1) {
	$sql = $bdd->query("SELECT MAX(requestid) FROM messenger_friendrequests WHERE user_to_id = '" . $id . "'");
	$requestid = $sql->fetchColumn();
	$requestid = $requestid + 1;
	$insert = $bdd->prepare("INSERT INTO messenger_friendrequests (user_from_id,user_to_id,requestid) VALUES (:my_id,:id,:requestid)");
	$insert->bindParam(':my_id', $my_id);
	$insert->bindParam(':id', $id);
	$insert->bindParam(':requestid', $requestid);
	if ($insert->execute()) {
		$message = "Friend request has been sent successfully.";
	} else {
		// Handle insert error
	}
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