<?php
/*===================================================+
|| # HoloCMS - Website and Content Management System
|+===================================================+
|| # Copyright � 2008 Meth0d. All rights reserved.
|| # http://www.meth0d.org
|+===================================================+
|| # HoloCMS is provided "as is" and comes without
|| # warrenty of any kind. HoloCMS is free software!
|+===================================================*/

include('../config.php');

$ownerid = $_POST['ownerId'];
$widgetid = $_POST['widgetId'];
$message = FilterText($_POST["message"]);

$dateStmt = $bdd->query("SELECT NOW()");
$date = $dateStmt->fetchColumn();

$insertGuestbookStmt = $bdd->prepare("INSERT INTO cms_guestbook (message, time, widget_id, userid) VALUES (:message, :date, :widgetid, :my_id)");
$insertGuestbookStmt->bindParam(':message', $message);
$insertGuestbookStmt->bindParam(':date', $date);
$insertGuestbookStmt->bindParam(':widgetid', $widgetid);
$insertGuestbookStmt->bindParam(':my_id', $my_id);
$insertGuestbookStmt->execute();

$lastGuestbookId = $bdd->lastInsertId();

$getGuestbookStmt = $bdd->prepare("SELECT * FROM cms_guestbook WHERE userid = :my_id AND id = :lastGuestbookId ORDER BY id DESC LIMIT 1");
$getGuestbookStmt->bindParam(':my_id', $my_id);
$getGuestbookStmt->bindParam(':lastGuestbookId', $lastGuestbookId);
$getGuestbookStmt->execute();
$row = $getGuestbookStmt->fetch(PDO::FETCH_ASSOC);

$getUsersStmt = $bdd->prepare("SELECT * FROM users WHERE id = :userid");
$getUsersStmt->bindParam(':userid', $row['userid']);
$getUsersStmt->execute();
$userrow = $getUsersStmt->fetch(PDO::FETCH_ASSOC);


?>

<li id="guestbook-entry-<?php echo $row['id']; ?>" class="guestbook-entry">
	<div class="guestbook-author">
		<img src="http://www.habbo.co.uk/habbo-imaging/avatarimage?figure=<?php echo $userrow['figure']; ?>&direction=2&head_direction=2&gesture=sml&size=s" alt="<?php echo $userrow['name'] ?>" title="<?php echo $userrow['name'] ?>" />
	</div>
	<div class="guestbook-actions">
		<img src="./web-gallery/images/myhabbo/buttons/delete_entry_button.gif" id="gbentry-delete-<?php echo $row['id']; ?>" class="gbentry-delete" style="cursor:pointer" alt="" />
		<br />
	</div>
	<div class="guestbook-message">
		<div class="online">
			<a href="./user_profile.php?id=<?php echo $userrow['id']; ?>"><?php echo $userrow['name']; ?></a>
		</div>
		<p><?php echo HoloText($row["message"], false, true); ?></p>
	</div>
	<div class="guestbook-cleaner">&nbsp;</div>
	<div class="guestbook-entry-footer metadata"><?php echo $row['date']; ?></div>
</li>