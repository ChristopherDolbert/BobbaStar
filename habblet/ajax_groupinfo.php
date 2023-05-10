<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|


include("../config.php");

$groupid = $_POST['groupId'];

if (!empty($groupid) && is_numeric($groupid)) {
	$stmt = $bdd->prepare("SELECT * FROM guilds WHERE id = :id LIMIT 1");
	$stmt->bindParam(':id', $groupid, PDO::PARAM_INT);
	$stmt->execute();
	$exists = $stmt->rowCount();
} else {
	echo "<div class=\"groups-info-basic\">
	<div class=\"groups-info-close-container\"><a href=\"#\" class=\"groups-info-close\"></a></div>
        Invalid group or no group supplied.
          </div>";
	exit;
}

if ($exists < 1) {
	exit;
}

$data = $stmt->fetch(PDO::FETCH_ASSOC);

echo "<div class=\"groups-info-basic\">
	<div class=\"groups-info-close-container\"><a href=\"#\" class=\"groups-info-close\"></a></div>
	
	<div class=\"groups-info-icon\"><a href=\"group_profile.php?id=" . $groupid . "\"><img src=\"./habbo-imaging/badge-fill/" . $data['badge'] . ".gif\" /></a></div>
	<h4><a href=\"group_profile.php?id=" . $groupid . "\">" . HoloText($data['name']) . "</a></h4>
	
	<p>
Group created:<br />
<b>" . $data['created'] . "</b>
	</p>
	
	<div class=\"groups-info-description\">" . HoloText(nl2br($data['description'])) . "</div>

</div>";
