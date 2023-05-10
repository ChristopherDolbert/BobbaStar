<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("./config.php");
$pageid = "forum";
$pagename = "Forum";

?>

<div id="groups-habblet-list-container" class="habblet-list-container groups-list">

	<?php
	$stmt = $bdd->query("SELECT * FROM guilds ORDER BY rand() LIMIT 12");
	$groups = $stmt->rowCount();

	echo "\n    <ul class=\"habblet-list two-cols clearfix\">";

	$num = 0;
	$lefts = 0;
	$rights = 0;

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$num++;

		if (IsEven($num)) {
			$pos = "right";
			$rights++;
		} else {
			$pos = "left";
			$lefts++;
		}

		if (IsEven($lefts)) {
			$oddeven = "odd";
		} else {
			$oddeven = "even";
		}

		$group_id = $row['id'];
		$groupdata = $row;

		echo "            <li class=\"" . $oddeven . " " . $pos . "\" style=\"background-image: url(./habbo-imaging/badge.php?badge=" . $groupdata['badge'] . ")\">\n		<a class=\"item\" href=\"group_profile.php?id=" . $group_id . "\">" . HoloText($groupdata['name']) . "</a>\n            </li>\n\n";
	}

	$rights_should_be = $lefts;
	if ($rights !== $rights_should_be) {
		echo "<li class=\"" . $oddeven . " right\"><div class=\"item\">&nbsp;</div></li>";
	}

	echo "\n    </ul>";

	?>

	<div class="habblet-button-row clearfix"><a class="new-button" id="purchase-group-button" href="#"><b>Create/buy a Group</b><i></i></a></div>
</div>

<div id="groups-habblet-group-purchase-button" class="habblet-list-container"></div>

<script type="text/javascript">
	$("purchase-group-button").observe("click", function(e) {
		Event.stop(e);
		GroupPurchase.open();
	});
</script>

</div>