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
$my_id = $user['id'];

if (!$user['username']) {
	echo "<p>\nPlease log in first.\n</p>\n\n<p>\n<a href=\"#\" class=\"new-button\" onclick=\"habboclub.closeSubscriptionWindow(); return false;\"><b>Done</b><i></i></a>\n</p>";
	exit;
}

echo "<p>
Vous";

if (!IsHCMember($my_id)) {
	echo " n'êtes";
}

echo " pas un membre du " . $sitename . " Club
</p>
<p>";
if (IsHCMember($my_id)) {
	echo "Vous avez " . HCDaysLeft($my_id) . " Jour(s) restants";
} else {
	echo "&nbsp;";
}
echo "</p>";
