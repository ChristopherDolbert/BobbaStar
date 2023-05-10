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
|| # Parts by Yifan Lu
|| # www.obbahhotel.com
|+===================================================*/

include('../config.php');

$id = $_POST['accountId'];
$stmt = $bdd->prepare("SELECT username FROM users WHERE id = :id LIMIT 1");
$stmt->execute(['id' => $id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$name = $row['username'];

?>
<p>
    Are you sure you want to add <?php echo $name; ?> to your friend list?
</p>

<p>
    <a href="#" class="new-button done"><b>Cancel</b><i></i></a>
    <a href="#" class="new-button add-continue"><b>Continue</b><i></i></a>
</p>