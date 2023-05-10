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

/**
 * AJAX Tool to remove Feed Item Alerts
 * Will be called upon by the means of a JavaScript request where needed.
 */

$allow_guests = false;

require_once('../config.php');

$feedItemIndex = $_POST['feedItemIndex'];
if (!is_numeric($feedItemIndex)) { 
    exit; 
}

$delete_alert = $bdd->prepare("DELETE FROM cms_alerts WHERE userid = :my_id ORDER BY id ASC LIMIT 1");
$delete_alert->execute(array(':my_id' => $user['id']));

echo "SUCCESS";
