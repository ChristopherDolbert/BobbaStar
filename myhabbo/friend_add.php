<?php
/*===================================================+
|| # HoloCMS - Website and Content Management System
|+===================================================+
|| # Copyright � 2008 Meth0d. All rights reserved.
|| # http://www.meth0d.org
|+===================================================+
|| # HoloCMS is provided "as is" and comes without
|| # warrenty of any kind. HoloCMS is free software!
|+===================================================+
|| # Parts by Yifan Lu
|| # www.obbahhotel.com
|+===================================================*/

include('../config.php');

$id = $_POST['accountId'];

// Check if the person is already a friend
$checkFriendshipStmt = $bdd->prepare("SELECT * FROM messenger_friendships WHERE userid = :id AND friendid = :my_id");
$checkFriendshipStmt->bindParam(':id', $id);
$checkFriendshipStmt->bindParam(':my_id', $my_id);
$checkFriendshipStmt->execute();
$friendshipRows = $checkFriendshipStmt->rowCount();

if ($friendshipRows != 0) {
	$error = 1;
	$message = "This person is already your friend.";
}

// Check if a friend request has already been sent by the user
$checkRequestStmt = $bdd->prepare("SELECT * FROM messenger_friendrequests WHERE userid_from = :my_id AND userid_to = :id");
$checkRequestStmt->bindParam(':my_id', $my_id);
$checkRequestStmt->bindParam(':id', $id);
$checkRequestStmt->execute();
$requestRows = $checkRequestStmt->rowCount();

if ($requestRows != 0) {
	$error = 1;
	$message = "You already requested a friendship from this person.";
}

// Check if a friend request has already been received from the user
$checkReceivedRequestStmt = $bdd->prepare("SELECT * FROM messenger_friendrequests WHERE userid_to = :my_id AND userid_from = :id");
$checkReceivedRequestStmt->bindParam(':my_id', $my_id);
$checkReceivedRequestStmt->bindParam(':id', $id);
$checkReceivedRequestStmt->execute();
$receivedRequestRows = $checkReceivedRequestStmt->rowCount();

if ($receivedRequestRows != 0) {
	$error = 1;
	$message = "This person already requested you to be their friend.";
}

// Check if the user is trying to friend request themselves
if ($id == $my_id) {
	$error = 1;
	$message = "You cannot friend request yourself.";
}

if ($error != 1) {
	$getRequestIdStmt = $bdd->prepare("SELECT MAX(requestid) FROM messenger_friendrequests WHERE userid_to = :id");
	$getRequestIdStmt->bindParam(':id', $id);
	$getRequestIdStmt->execute();
	$requestid = $getRequestIdStmt->fetchColumn();
	$requestid = $requestid + 1;

	$insertRequestStmt = $bdd->prepare("INSERT INTO messenger_friendrequests (userid_from, userid_to, requestid) VALUES (:my_id, :id, :requestid)");
	$insertRequestStmt->bindParam(':my_id', $my_id);
	$insertRequestStmt->bindParam(':id', $id);
	$insertRequestStmt->bindParam(':requestid', $requestid);
	$insertRequestStmt->execute();

	$message = "Friend request has been sent successfully.";
}
?>
Dialog.showInfoDialog("add-friend-messages",
"<?php echo $message; ?>",
"OK");