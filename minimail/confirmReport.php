<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include('../config.php');

$id = $_POST['messageId'];

$stmt = $bdd->prepare("SELECT * FROM cms_minimail WHERE id = :id LIMIT 1");
$stmt->execute(array('id' => $id));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$error = 0;

if ($row['senderid'] == $user['id']) {
	$error = 1;
	$message = "You can't report your own messages.";
}

if ($error == 1) {
?>
	<ul class="error">
		<li><?php echo $message; ?></li>
	</ul>

	<p>
		<a href="#" class="new-button cancel-report"><b>Cancel</b><i></i></a>
	</p>
<?php
} else {
	$stmt = $bdd->prepare("SELECT * FROM users WHERE id = :senderid LIMIT 1");
	$stmt->execute(array('senderid' => $row['senderid']));
	$senderrow = $stmt->fetch(PDO::FETCH_ASSOC);
?>
	<p>
		Are you sure you want to report the message <b><?php echo $row['subject']; ?></b> to the moderators and remove <b><?php echo $senderrow['name']; ?></b> from your friend list? You cant undo this.
	</p>

	<p>
		<a href="#" class="new-button cancel-report"><b>Cancel</b><i></i></a>
		<a href="#" class="new-button send-report"><b>Send report</b><i></i></a>
	</p>
<?php } ?>