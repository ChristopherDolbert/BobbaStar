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
|| # HoloShop 1.0 Coded By Yifan Lu
|+===================================================*/

$id = filter_var($_POST['optionNumber'], FILTER_SANITIZE_NUMBER_INT);

// Récupérer la ligne correspondant à l'ID
$stmt = $bdd->prepare("SELECT * FROM cms_badge_shop WHERE id = :id LIMIT 1");
$stmt->execute(['id' => $id]);
$row = $stmt->fetch();

if ($myrow['credits'] < $row['cost']) {
	$msg = "You don't have enough credits to complete this purchase.";
} else {
	if ($row['minrank'] <= $userrow['rank']) {
		$checkStmt = $bdd->prepare("SELECT * FROM user_badges WHERE userid = :userid AND badgeid = :badgeid");
		$checkStmt->execute(['userid' => $user['id'], 'badgeid' => $row['image']]);
		if ($checkStmt->rowCount() == 0) {
			$insertBadgeStmt = $bdd->prepare("INSERT INTO user_badges (userid, badgeid, iscurrent) VALUES (:userid, :badgeid, '0')");
			$insertBadgeStmt->execute(['userid' => $user['id'], 'badgeid' => $row['image']]);
			$insertTransactionStmt = $bdd->prepare("INSERT INTO cms_transactions (userid, amount, date, descr) VALUES (:userid, :amount, :date_full, 'Purchased the badge " . $row['name'] . "')");
			$insertTransactionStmt->execute(['userid' => $user['id'], 'amount' => $row['cost'], 'date_full' => $date_full]);
			$msg = "You have successfully purchased the badge " . $row['image'];
		} else {
			$msg = "You already own this badge!";
		}
	} else {
		$msg = "You do not have permission to buy this badge!";
	}
}


?>

<div id="hc_confirm_box">

	<img src="<?php echo $cimagesurl . $badgesurl . $row['image'] . ".gif"; ?>" alt="" align="left" style="margin:10px;" />
	<p><b><?php echo $row['name']; ?></b></p>
	<p><?php echo $msg; ?></p>

	<p>
		<a href="#" class="new-button" onclick="habboclub.closeSubscriptionWindow(); return false;">
			<b>Done</b><i></i></a>
	</p>

</div>

<div class="clear"></div>