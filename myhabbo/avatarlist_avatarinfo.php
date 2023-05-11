<?php
include('../config.php');
$id = $_POST['anAccountId'];
$ownerid = $_POST['ownerAccountId'];

$stmt = $bdd->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
$stmt->bindParam(':id', $id);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $bdd->prepare("SELECT * FROM users_badges WHERE user_id = :id LIMIT 1");
$stmt->bindParam(':id', $id);
$stmt->execute();
$count = $stmt->rowCount();

if ($count != 0) {
	$badgerow = $stmt->fetch(PDO::FETCH_ASSOC);
	$badge = $badgerow['badge_code'];
} else {
	$badge = "";
}

if (IsUserOnline($id) == true) {
	$online = "habbo_online_anim_big.gif";
} else {
	$online = "habbo_offline_big.gif";
}

?>
<div class="avatar-list-info-container">
	<div class="avatar-info-basic clearfix">
		<div class="avatar-list-info-close-container"><a href="#" class="avatar-list-info-close" id="avatar-list-info-close-<?php echo $row['id']; ?>"></a></div>
		<div class="avatar-info-image">
			<?php
			if ($badge != "") {
				echo "<img src=\"" . $cimagesurl . $badgesurl . $badge . "\">";
			}
			?>
			<img src="http://www.habbo.co.uk/habbo-imaging/avatarimage?figure=<?php echo $row['figure']; ?>&size=l&direction=4&head_direction=4" alt="<?php echo $row['name']; ?>" />
		</div>
		<h4><a href="./user_profile.php?name=<?php echo $row['name']; ?>"><?php echo $row['name']; ?></a></h4>
		<p>
			<img src="./web-gallery/images/myhabbo/<?php echo $online; ?>" />
		</p>
		<p><?php echo $shortname; ?> created on: <b><?php echo $row['hbirth']; ?></b></p>
		<p><a href="./user_profile.php?name=<?php echo $row['name']; ?>" class="arrow">View <?php echo $shortname; ?>s page</a></p>
		<p class="avatar-info-motto"><?php echo $row['mission']; ?></p>
	</div>
</div>