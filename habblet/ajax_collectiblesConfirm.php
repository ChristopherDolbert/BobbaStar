<?php
include('../config.php');
$stmt = $bdd->prepare("SELECT title FROM cms_collectables WHERE month = :month LIMIT 1");
$stmt->execute(['month' => date('n')]);

$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>


<p>
    Are you sure you want to purchase <?php echo HoloText($row['title']); ?>? It will cost 25 credits.
</p>

<p>
    <a href="#" class="new-button" id="collectibles-purchase"><b>Purchase</b><i></i></a>
    <a href="#" class="new-button" id="collectibles-close"><b>Cancel</b><i></i></a>
</p>