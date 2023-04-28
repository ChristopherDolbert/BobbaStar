<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include('../config.php');

if (!$user['username']) {
	echo "<p>\nPlease log in first.\n</p>\n\n<p>\n<a href=\"#\" class=\"new-button\" onclick=\"habboclub.closeSubscriptionWindow(); return false;\"><b>Done</b><i></i></a>\n</p>";
	exit;
}
$months = $_POST['optionNumber'];
$myrow = $user;
$my_id = $user['id'];

switch ($months) {
	case 1:
		$price = 20;
		$valid = 1;
		break;
	case 3:
		$price = 50;
		$valid = 1;
		break;
	case 6:
		$price = 80;
		$valid = 1;
		break;
	default:
		$valid = 0;
		break;
}

if ($valid !== 1) {
	$price = 20;
	$months = 1;
	$valid = 1;
}

if ($myrow['credits'] < $price) {
	$msg = "Tu n'as pas assez de cr&eacute;dits pour t'offrir des mois HC";
} else {
	$check = $bdd->prepare("SELECT months_left FROM users_club WHERE userid = ? LIMIT 1");
	$check->execute(array($my_id));
	$results = $check->rowCount();

	if ($results > 0) {
		$row = $check->fetch(PDO::FETCH_ASSOC);
		$months_left = $row['months_left'];
	} else {
		$months_left = 0;
	}

	$months_left = $months_left + $months - 1;
	$time = time();

	/*$check2 = $bdd->prepare("SELECT * FROM users_settings WHERE user_id = ? LIMIT 1");
	$check2->execute(array($my_id));
	$results2 = $check2->fetch();

	if ($results2['last_hc_payday'] != 0) {
		echo "<script>alert(\"la variable est nulle\")</script>";
		$msg = "Vous êtes déjà HC";
	} else*/if ($hc_maxmonths == "0" || $months_left < $hc_maxmonths) {
		$sql = "UPDATE users SET credits = credits - :price";
		if ($user['rank'] == 1) {
			$sql .= ", rank = 2";
		}
		$sql .= " WHERE id = :my_id LIMIT 1";

		$stmt = $bdd->prepare($sql);
		$stmt->bindParam(':price', $price, PDO::PARAM_INT);
		$stmt->bindParam(':my_id', $my_id, PDO::PARAM_INT);
		$stmt->execute();


		// Appeler la fonction giveHC
		giveHC($my_id, $months);
		

		// Insérer une transaction dans la table cms_transactions
		$date_full = FullDate('full');
		$sql = "INSERT INTO gabcms_transaction (user_id, prix, date, produit, gain) VALUES (:userid, :amount, :date_full, :descr, :gain)";
		$stmt = $bdd->prepare($sql);
		$stmt->bindParam(':userid', $my_id, PDO::PARAM_INT);
		$stmt->bindParam(':amount', $price, PDO::PARAM_INT);
		$stmt->bindParam(':date_full', $date_full, PDO::PARAM_STR);
		$descr = "Adhésion au MyHabbo Club (" . $months . " mois)";
		$stmt->bindParam(':descr', $descr, PDO::PARAM_STR);
		$gain = "-";
		$stmt->bindParam(':gain', $gain, PDO::PARAM_STR);
		$stmt->execute();

		$usstts = "UPDATE users_settings SET last_hc_payday = :last_hc_payday WHERE user_id = :my_id LIMIT 1";
		$stmt9 = $bdd->prepare($usstts);
		$stmt9->bindParam(':last_hc_payday', $time, PDO::PARAM_INT);
		$stmt9->bindParam(':my_id', $my_id, PDO::PARAM_INT);
		$stmt9->execute();

		/*@SendMUSData('UPRC' . $my_id);*/
		$msg = "SUPER! Tu fais maintenant partie du " . $shortname . " Club pendant " . $months . " mois.";
	} else {
		$msg = "Vous ne pouvez vous inscrire que pour un maximum de " . $hc_maxmonths . " mois. Si cet abonnement est terminé, vous aurez dépassé la limite.";
	}
}

?>

<div id="hc_confirm_box">

	<img src="./web-gallery/album1/piccolo_happy.gif" alt="" align="left" style="margin:10px;" />
	<p><b>Inscription</b></p>
	<p><?php echo $msg; ?></p>

	<p>
		<a href="#" class="new-button" onclick="habboclub.closeSubscriptionWindow(); return false;">
			<b>OK</b><i></i></a>
	</p>

</div>

<div class="clear"></div>