<?php
include('../config.php');

$id = $_POST['widgetId'];

$selectQuery = "SELECT * FROM cms_homes_stickers WHERE id = :id LIMIT 1";
$selectStmt = $bdd->prepare($selectQuery);
$selectStmt->bindParam(':id', $id);
$selectStmt->execute();
$row = $selectStmt->fetch(PDO::FETCH_ASSOC);

if ($row['var'] == "0") {
	$var = "1";
} else {
	$var = "0";
}

$updateQuery = "UPDATE cms_homes_stickers SET var = :var WHERE id = :id LIMIT 1";
$updateStmt = $bdd->prepare($updateQuery);
$updateStmt->bindParam(':var', $var);
$updateStmt->bindParam(':id', $id);
$updateStmt->execute();

?>
var el = $("guestbook-type");
if (el) {
if (el.hasClassName("public")) {
el.className = "private";
new Effect.Pulsate(el,
{ duration: 1.0, afterFinish : function() { Element.setOpacity(el, 1); } }
);
} else {
new Effect.Pulsate(el,
{ duration: 1.0, afterFinish : function() { Element.setOpacity(el, 0); el.className = "public"; } }
);
}
}