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

$query = $_GET['query'];
$scope = $_GET['scope'];
?>
<ul>
	<li>Click on link below to insert it into the document</li>
	<?php
	if ($scope == 1) {
		$i = 0;
		$query = '%' . $query . '%';
		$stmt = $bdd->prepare("SELECT * FROM users WHERE username LIKE :query LIMIT 10");
		$stmt->execute(['query' => $query]);

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$i++;
			printf("<li><a href=\"#\" class=\"linktool-result\" type=\"habbo\" value=\"%s\" title=\"%s\">%s</a></li>", $row['id'], $row['username'], $row['username']);
		}
	} elseif ($scope == 2) {
		$i = 0;
		$query = '%' . $query . '%';
		$stmt = $bdd->prepare("SELECT * FROM rooms WHERE name LIKE :query LIMIT 10");
		$stmt->execute(['query' => $query]);

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$i++;
			printf("<li><a href=\"#\" class=\"linktool-result\" type=\"room\" value=\"%s\" title=\"%s\">%s</a></li>", $row['id'], $row['name'], $row['name']);
		}
	} elseif ($scope == 3) {
		$i = 0;
		$query = '%' . $query . '%';
		$stmt = $bdd->prepare("SELECT * FROM groups_details WHERE name LIKE :query LIMIT 10");
		$stmt->execute(['query' => $query]);

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$i++;
			printf("<li><a href=\"#\" class=\"linktool-result\" type=\"group\" value=\"%s\" title=\"%s\">%s</a></li>", $row['id'], $row['name'], $row['name']);
		}
	}
	?>

</ul>