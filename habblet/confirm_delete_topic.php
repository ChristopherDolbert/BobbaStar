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

if (getContent('forum-enabled') !== "1") {
    header("Location: index.php");
    exit;
}
if (!isset($_SESSION['username'])) {
    exit;
}


if ($user['rank'] < 6) {
    exit;
}

?>

<p>You are about to delete a compelete topic. Are you sure?</p>

<p>
    <a href="#" class="new-button" id="discussion-action-cancel"><b>Cancel</b><i></i></a>
    <a href="#" class="new-button" id="discussion-action-ok"><b>Proceed</b><i></i></a>
</p>

<div class="clear"></div>