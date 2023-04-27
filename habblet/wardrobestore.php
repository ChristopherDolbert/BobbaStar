<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");

$slot = $_POST['slot'];
$figure = Secu($_POST['figure']);
$gender = $_POST['gender'];

if (!empty($figure) && !empty($gender) && !empty($slot)) {

	if ($gender !== "M" && $gender !== "F") {
		$gender = "M";
	}

	if ($slot !== "1" && $slot !== "2" && $slot !== "3" && $slot !== "4" && $slot !== "5") {
		$slot = "1";
	}

	$stmt = $bdd->prepare("SELECT gender FROM users_wardrobe WHERE user_id = :my_id AND slot_id = :slot LIMIT 1");
	$stmt->execute(array(':my_id' => $user['id'], ':slot' => $slot));
	$exists = $stmt->rowCount();

	if ($exists > 0) {
		$stmt = $bdd->prepare("UPDATE users_wardrobe SET look = :figure, gender = :gender WHERE user_id = :my_id AND slot_id = :slot LIMIT 1");
		$stmt->execute(array(':figure' => $figure, ':gender' => $gender, ':my_id' => $user['id'], ':slot' => $slot));
	} else {
		$stmt = $bdd->prepare("INSERT INTO users_wardrobe (user_id, slot_id, look, gender) VALUES (:userid, :slotid, :figure, :gender)");
		$stmt->bindParam(':userid', $user['id']);
		$stmt->bindParam(':slotid', $slot);
		$stmt->bindParam(':figure', $figure);
		$stmt->bindParam(':gender', $gender);

		if ($stmt->execute()) {
		} else {
			print_r($stmt->errorInfo());
		}
	}

	// Now we need to attach this weird header so it updates the figure.
	// Took me a while to figure out and I still don't understand but meh.
	header("X-JSON: {\"u\":\"$avatarimage" . $figure . "&size=s&direction=4&head_direction=4&gesture=sml\",\"f\":\"" . $figure . "\",\"g\":77}");
}
