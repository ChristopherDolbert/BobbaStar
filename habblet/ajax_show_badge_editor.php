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

// Vérifier que l'utilisateur vient bien de group_profile.php
$refer = $_SERVER['HTTP_REFERER'];
$pos = strrpos($refer, "group_profile.php");
if ($pos === false) {
    exit;
}

$groupid = filter_var($_POST['groupId'], FILTER_SANITIZE_NUMBER_INT);
if (!is_numeric($groupid)) {
    exit;
}

// Vérifier que l'utilisateur est membre du groupe et a un rang suffisant
$checkStmt = $bdd->prepare("SELECT member_rank FROM groups_memberships WHERE userid = :userid AND groupid = :groupid AND member_rank > 1 AND is_pending = '0' LIMIT 1");
$checkStmt->execute(['userid' => $user['id'], 'groupid' => $groupid]);
$is_member = $checkStmt->rowCount();

if ($is_member > 0) {
    $my_membership = $checkStmt->fetch();
    $member_rank = $my_membership['member_rank'];
    if ($member_rank < 2) {
        exit;
    }
} else {
    exit;
}

// Récupérer les détails du groupe
$detailsStmt = $bdd->prepare("SELECT * FROM groups_details WHERE id = :groupid LIMIT 1");
$detailsStmt->execute(['groupid' => $groupid]);
$valid = $detailsStmt->rowCount();

if ($valid > 0) {
    $groupdata = $detailsStmt->fetch();
} else {
    exit;
}


?>
<div id="badge-editor-flash" align="center">
    <strong>Flash is required to use this tool</strong>
</div>
<script type="text/javascript" language="JavaScript">
    var swfobj = new SWFObject("<?PHP echo $url; ?>flash/BadgeEditor.swf", "badgeEditor", "280", "366", "8");
    swfobj.addParam("base", "<?PHP echo $url; ?>web-gallery/flash/");
    swfobj.addParam("bgcolor", "#FFFFFF");
    swfobj.addVariable("post_url", "<?php echo $url; ?>save_group_badge.php");
    swfobj.addVariable("__app_key", "Meth0d.org");
    swfobj.addVariable("groupId", "<?php echo $groupid; ?>");
    swfobj.addVariable("badge_data", "<?php echo $groupdata['badge']; ?>");
    swfobj.addVariable("localization_url", "<?PHP echo $url; ?>xml/badge_editor.xml");
    swfobj.addVariable("xml_url", "<?PHP echo $url; ?>xml/badge_data_xml.xml");
    swfobj.addParam("allowScriptAccess", "always");
    swfobj.write("badge-editor-flash");
</script>