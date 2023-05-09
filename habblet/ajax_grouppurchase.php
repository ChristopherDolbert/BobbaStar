<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|


include("../config.php");

// Make sure the user meets the requirements to buy a group. If not, this part
// should cut off the script.

if (getContent('allow-group-purchase') !== "1") {

	echo "<p id=\"purchase-result-error\">Purchasing the group failed. Please try again later.</p>\n<div id=\"purchase-group-errors\">\n<p>\nPurchashing groups has been disabled by the Hotel Managment. Please try again later.<br />\n</p>\n</div>\n<p>\n<a href=\"#\" class=\"new-button\" onclick=\"GroupPurchase.close(); return false;\"><b>Done</b><i></i></a>\n</p>\n<div class=\"clear\"></div>";
	exit;
} elseif ($myrow['credits'] < 20) {

	echo "<p id=\"purchase-result-error\">Purchasing the group failed. Please try again later.</p>\n<div id=\"purchase-group-errors\">\n<p>\nYou don't have enough Credits. <a href=\"credits.php\">Get more here!</a><br />\n</p>\n</div>\n<p>\n<a href=\"#\" class=\"new-button\" onclick=\"GroupPurchase.close(); return false;\"><b>Done</b><i></i></a>\n</p>\n<div class=\"clear\"></div>";
	exit;
} else {

	$stmt = $con->prepare("SELECT COUNT(*) FROM guilds WHERE user_id = ? LIMIT 10");
	$stmt->bind_param("i", $my_id);
	$stmt->execute();
	$stmt->bind_result($groups_owned);
	$stmt->fetch();
	$stmt->close();


	if ($groups_owned > 10) {
		echo "<p id=\"purchase-result-error\">Purchasing the group failed. Please try again later.</p>\n<div id=\"purchase-group-errors\">\n<p>\nYou have reached the maximum amount of <i>owned</i> groups per user (3).<br />\n</p>\n</div>\n<p>\n<a href=\"#\" class=\"new-button\" onclick=\"GroupPurchase.close(); return false;\"><b>Done</b><i></i></a>\n</p>\n<div class=\"clear\"></div>";
		exit;
	}
}


// The buy part. If the script has not been cut off yet, we should be ready to go.

if (empty($do) || $do !== "purchase_confirmation") {

	echo "<p>\n<img src='./habbo-imaging/badge-fill/b0503Xs09114s05013s05015.gif' border='0' align='left'>C'est ici que tu vas pouvoir te cr&eacute;er un clan. Les clans ne c&ocirc;utent que <b>20</b> cr&eacute;dits.\n</p>\n\n<p>\n<b>Nom du clan</b><br /><input type='text' name='name' id='group_name' value='' length='10' maxlength='25'>\n</p>\n\n<p>\n<b>Description du clan</b><br />\n<textarea name='description' id='group_description' maxlength='200'></textarea>\n</p>\n\n<p>\nTu pourras modifier ces indications quand tu auras cr&eacute;e ce clan!\n</p>\n\n<p>\n<a href=\"#\" class=\"new-button\" onclick=\"GroupPurchase.confirm(); return false;\"><b>Acheter</b><i></i></a>\n<a href=\"#\" class=\"new-button\" onclick=\"GroupPurchase.close(); return false;\"><b>Retour</b><i></i></a>\n</p>";
	exit;
} elseif ($do == "purchase_confirmation") {

	$group_name = trim($_POST['name']);
	$group_desc = trim($_POST['description']);

	if (empty($group_name) || empty($group_desc)) {

		echo "<p>\nMerci de ne pas laisser de cases vide.\n</p>\n\n<p>\n<a href=\"#\" class=\"new-button\" onclick=\"GroupPurchase.close(); GroupPurchase.open(); return false;\"><b>Retour</b><i></i></a>\n</p>";
		exit;
	} else {

		if (strlen($group_name > 25) && !is_numeric($group_name)) {

			echo "<p>\nLe nom de ton clan est trop long!\n</p>\n\n<p>\n<a href=\"#\" class=\"new-button\" onclick=\"GroupPurchase.close(); GroupPurchase.open(); return false;\"><b>Retour</b><i></i></a>\n</p>";
			exit;
		} elseif (strlen($group_desc > 200) && !is_numeric($group_desc)) {

			echo "<p>\nLa description de ton clan est trop longue!\n</p>\n\n<p>\n<a href=\"#\" class=\"new-button\" onclick=\"GroupPurchase.close(); GroupPurchase.open(); return false;\"><b>Retour</b><i></i></a>\n</p>";
			exit;
		} else {

			$stmt = $bdd->prepare("SELECT id FROM guilds WHERE name = :group_name LIMIT 1");
			$stmt->bindParam(':group_name', $group_name);
			$stmt->execute();
			$already_exists = $stmt->rowCount();


			if ($already_exists > 0) {

				echo "<p>\nCe clan existe d&eacute;ja\n</p>\n\n<p>\n<a href=\"#\" class=\"new-button\" onclick=\"GroupPurchase.close(); GroupPurchase.open(); return false;\"><b>Retour</b><i></i></a>\n</p>";
			} else {

				$orname = $group_name;
				$group_name = filter_var($orname, FILTER_SANITIZE_STRING);
				$group_desc = filter_var($group_desc, FILTER_SANITIZE_STRING);

				mysqli_query($con, "INSERT INTO guilds (name, description, user_id, date_created, badge, state) VALUES ('$group_name', '$group_desc', '$my_id', '$date_full', 'b0503Xs09114s05013s05015', '0')");

				$check = mysqli_query($con, "SELECT id FROM guilds WHERE user_id = '$my_id' ORDER BY id DESC LIMIT 1");
				$row = mysqli_fetch_assoc($check);
				$group_id = $row['id'];

				mysqli_query($con, "INSERT INTO guilds_members (user_id, group_id, member_rank, is_current) VALUES ('$my_id', '$group_id', '2', '0')");
				mysqli_query($con, "UPDATE users SET credits = credits - 20 WHERE id = '$my_id' LIMIT 1");
				mysqli_query($con, "INSERT INTO cms_transactions (userid, descr, date, amount) VALUES ('$my_id', 'Group purchase', '$date_full', '-20')");

				@SendMUSData('UPRC' . $my_id);

				echo "<p>\n<b>Clan achet&eacute;!</b><br /><br /><img src='./habbo-imaging/badge-fill/b0503Xs09114s05013s05015.gif' border='0' align='left'>Bravo! Tu es bien le cr&eacute;ateur de <b>" . HoloText($orname) . "</b>.<br /><br />Cliques <a href='group_profile.php?id=" . $group_id . "'>ici</a> pour aller sur la home de ton clan! Ou pars en cliquant sur le bouton Quitter.\n</p>\n\n<p>\n<a href=\"#\" class=\"new-button\" onclick=\"GroupPurchase.close(); return false;\"><b>Quitter</b><i></i></a>\n</p>";
			}
		}
	}
} else {

	echo "<p>\nAn unknown error occured. Please try again in a couple of minutes.\n</p>\n\n<p>\n<a href=\"#\" class=\"new-button\" onclick=\"GroupPurchase.close(); return false;\"><b>OK</b><i></i></a>\n</p>";
}
