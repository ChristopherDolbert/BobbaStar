<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

if ($bypass1 != "true") {
	include('../config.php');

	$messageid = Secu($_POST['messageId']);
	$recipientids = $_POST['recipientIds'];
	$subject = Secu($_POST['subject']);
	$body = addslashes(htmlspecialchars(($_POST["body"])));
}

$body = Secu($body);

$ids = explode(",", $recipientids);
$numofids = count($ids);

$stmt = $bdd->prepare("SELECT NOW()");
$stmt->execute();
$date = $stmt->fetchColumn();

if (isset($_POST['messageId'])) {
	$stmt = $bdd->prepare("SELECT * FROM cms_minimail WHERE id = ?");
	$stmt->execute([$messageid]);
	$row = $stmt->fetch(PDO::FETCH_ASSOC);

	if ($row['conversationid'] == "0") {
		$stmt = $bdd->prepare("SELECT MAX(conversationid) FROM cms_minimail");
		$stmt->execute();
		$conid = $stmt->fetchColumn();
		$conid = $conid + 1;

		$stmt = $bdd->prepare("UPDATE cms_minimail SET conversationid = ? WHERE id = ?");
		$stmt->execute([$conid, $row['id']]);
	} else {
		$conid = $row['conversationid'];
	}

	$subject = "Re: " . $row['subject'];
	$ids[0] = $row['senderid'];
} else {
	$conid = "0";
}

$elements = count($ids);
$elements = $elements - 1;
$i = -1;
while ($elements !== $i) {
	$i++;
	$stmt = $bdd->prepare("INSERT INTO cms_minimail (senderid,to_id,subject,date,message,conversationid) VALUES (?,?,?,?,?,?)");
	$stmt->execute([$user['id'], $ids[$i], $subject, $date, $body, $conid]);
}

$bypass = "true";
$page = "inbox";
$message = "Message sent sucessfully.";

if ($bypass1 != "true") {
	include('loadMessage.php');
}
