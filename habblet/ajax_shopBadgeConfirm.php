<?php
/*===================================================+
|| # HoloCMS - Website and Content Management System
|+===================================================+
|| # Copyright � 2008 Meth0d. All rights reserved.
|| # http://www.meth0d.org
|+===================================================+
|| # HoloCMS is provided "as is" and comes without
|| # warrenty of any kind. HoloCMS is free software!
|+===================================================+
|| # HoloShop 1.0 Coded By Yifan Lu
|+===================================================*/

require '../config.php';

session_start();
if (!isset($_SESSION['username'])) {
    echo "<p>\nPlease log in first.\n</p>\n\n<p>\n<a href=\"#\" class=\"new-button\" onclick=\"habboclub.closeSubscriptionWindow(); return false;\"><b>Done</b><i></i></a>\n</p>";
    exit;
}

$id = filter_var($_POST['optionNumber'], FILTER_SANITIZE_NUMBER_INT);

$stmt = $bdd->prepare("SELECT * FROM cms_badge_shop WHERE id = :id LIMIT 1");
$stmt->execute(['id' => $id]);
$row = $stmt->fetch();

?>

<div id="hc_confirm_box">

    <img src="<?php echo $cimagesurl . $badgesurl . $row['image'] . ".gif"; ?>" alt="" align="left" style="margin:10px;" />
    <p><b><?php echo $row['name']; ?></b></p>
    <p>Are you sure you want to purchase this badge which costs <?php echo $row['cost']; ?> coins?</p>
    <p>
        <a href="#" class="new-button" onclick="habboclub.closeSubscriptionWindow(); return false;">
            <b>Cancel</b><i></i></a>
        <a href="#" ondblclick="habboclub.showSubscriptionResultWindow(<?php echo $id; ?>,'Purchase Badge'); return false;" onclick="habboclub.showSubscriptionResultWindow(<?php echo $months; ?>,'<?php echo strtoupper($shortname); ?> CLUB'); return false;" class="new-button">
            <b>Buy</b><i></i></a>
    </p>

</div>

<div class="clear"></div>