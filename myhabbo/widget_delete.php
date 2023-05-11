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

$check = $bdd->query("SELECT groupid, active FROM cms_homes_group_linker WHERE userid = '".$my_id."' AND active = '1' LIMIT 1");
$linked = $check->rowCount();

if ($linked > 0) {
    $linkdata = $check->fetch(PDO::FETCH_ASSOC);
    $groupid = $linkdata['groupid'];
}

// Collect variables
$widget = $_POST['widgetId'];

if (is_numeric($widget)) {
    if ($linked > 0) {
        $sql = $bdd->query("SELECT * FROM cms_homes_stickers WHERE groupid = '".$groupid."' AND type = '2' AND id = '".$widget."' LIMIT 1");
    } else {
        $sql = $bdd->query("SELECT * FROM cms_homes_stickers WHERE userid = '".$my_id."' AND groupid = '-1' AND type = '2' AND id = '".$widget."' LIMIT 1");
    }
} else {
    exit;
}

$num = $sql->rowCount();

if ($num > 0) {
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    if ($linked > 0) {
        $bdd->query("DELETE FROM cms_guestbook WHERE widget_id = '".$widget."'");
        $bdd->query("DELETE FROM cms_homes_stickers WHERE groupid = '".$groupid."' AND type = '2' AND id = '".$widget."' LIMIT 1");
    } else {
        $bdd->query("DELETE FROM cms_guestbook WHERE widget_id = '".$widget."'");
        $bdd->query("DELETE FROM cms_homes_stickers WHERE userid = '".$my_id."' AND groupid = '-1' AND type = '2' AND id = '".$widget."' LIMIT 1");
    }
    echo "SUCCESS";
} else {
    echo "ERROR";
}
