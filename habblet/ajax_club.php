<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include('../config.php');


if (!$user['username']) {
	echo "<p>\nPlease log in first.\n</p>\n\n<p>\n<a href=\"#\" class=\"new-button\" onclick=\"habboclub.closeSubscriptionWindow(); return false;\"><b>Done</b><i></i></a>\n</p>";
	exit;
}

echo "<p>
Vous";

if (!IsHCMember($user['id'])) {
	echo " n'êtes";
}

echo " pas un membre du " . $sitename . " Club
</p>
<p>";
if (IsHCMember($user['id'])) {
	echo "Vous avez " . HCDaysLeft($user['id']) . " Jour(s) restants";
} else {
	echo "&nbsp;";
}
echo "</p>";
