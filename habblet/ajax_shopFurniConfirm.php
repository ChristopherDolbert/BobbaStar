<?php
/*===================================================+
|| # HoloCMS - Website and Content Management System
|+===================================================+
|| # Copyright &copy; 2008 Meth0d. All rights reserved.
|| # http://www.meth0d.org
|+===================================================+
|| # HoloCMS is provided "as is" and comes without
|| # warrenty of any kind. HoloCMS is free software!
|+===================================================+
|| # HoloShop 1.0 Coded By Yifan Lu
|+===================================================*/

include('../core.php');

session_start();
if (!isset($_SESSION['username'])) {
	echo "<p>\nPlease log in first.\n</p>\n\n<p>\n<a href=\"#\" class=\"new-button\" onclick=\"habboclub.closeSubscriptionWindow(); return false;\"><b>Done</b><i></i></a>\n</p>";
	exit;
}

$id = filter_var($_POST['optionNumber'], FILTER_SANITIZE_NUMBER_INT);

$stmt = $bdd->prepare("SELECT * FROM catalogue_items WHERE tid = :id LIMIT 1");
$stmt->execute(['id' => $id]);
$row = $stmt->fetch();

?>

<div id="hc_confirm_box">

	<img src="./web-gallery/images/catalogue/<?php echo $row['picture']; ?>" alt="" align="left" style="margin:10px;" />
	<p><b><?php echo $row['catalogue_name']; ?></b></p>
	<p>Combien de <?php echo $row['catalogue_name']; ?> veux tu acheter?
	<form action="./shop_furni.php?category=<?php echo $row['catalogue_id_page']; ?>" method="post">
		<input type="text" name="quantity" value="" />
		<input type="hidden" name="furniID" value="<?php echo $row['tid']; ?>" />
		</p>
		<p>
			<a href="#" class="new-button" onclick="habboclub.closeSubscriptionWindow(); return false;">
				<b>Quitter</b><i></i></a>
			<input type="submit" value="C'est parti!" class="submit" id="submit-button" />
	</form>
	</p>

</div>

<div class="clear"></div>