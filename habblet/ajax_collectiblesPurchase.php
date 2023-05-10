<?php
include('../config.php');
if (!function_exists('SendMUSData')) {
	include('../includes/mus.php');
}

$stmt = $bdd->prepare("SELECT credits FROM users WHERE id = :my_id LIMIT 1");
$stmt->execute(['my_id' => $user['id']]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Has the user enough credits?
$credits = ($row['credits'] - 25);

if ($credits < 0) {
	// user hasn't enough credits 
?>
	<p>
		Purchasing the collectable failed.
	</p>

	<p>
		You don't have enough credits.<br />
	</p>

	<p>
		<a href="#" class="new-button" id="collectibles-close"><b>Cancel</b><i></i></a>
	</p>
<?php
} else {
	// It seems like the user has enough credits, we're now going to 'buy' the collectable
	$stmt = $bdd->prepare("SELECT * FROM cms_collectables WHERE month = :month AND year = :year LIMIT 1");
	$stmt->execute(['month' => date('n'), 'year' => date('Y')]);
	$row = $stmt->fetch(PDO::FETCH_ASSOC);

	$stmt = $bdd->prepare("UPDATE users SET credits = credits - 25 WHERE id = :my_id LIMIT 1");
	$stmt->execute(['my_id' => $user['id']]);

	$stmt = $bdd->prepare("INSERT INTO furniture (ownerid, roomid, tid) VALUES (:my_id, 0, :tid)");
	$stmt->execute(['my_id' => $user['id'], 'tid' => $row['tid']]);

	$stmt = $bdd->prepare("INSERT INTO cms_transactions (userid, amount, date, descr) VALUES (:my_id, 25, :date_full, 'Bought a collectable')");
	$stmt->execute(['my_id' => $user['id'], 'date_full' => $date_full]);

	// katsjing sound
	SendMUSData('UPRC' . $user['id']);
	// reload hand
	SendMUSData('UPRH' . $user['id']);
	// Now we say in a message he has the furniture! 
?>
	<p>
		You've succesfully bought a <?php echo HoloText($row['title']); ?>.
	</p>


	<p>
		<a href="#" class="new-button" id="collectibles-close"><b>OK</b><i></i></a>
	</p>
<?php
}
// finished 
?>