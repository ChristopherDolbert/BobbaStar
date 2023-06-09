<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");

if (!isset($_SESSION['username']) || $user['rank'] < 8 || $user['rank'] > 11) {
	Redirect("" . $url . "/managements/access_neg");
	exit();
}

$ip = '';
?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />

<body></body>

<?PHP
if (isset($_POST['ip'])) {
	$ip = Secu($_POST['ip']);
}

echo '<div id="contentcolumn"><div id="solution_suggestion">
<div class="content content_green"><div class="green_box_top"><div class="box box_top"></div></div><p><span id="titre">Traque de multi-comptes</span><br/>
 Vous pouvez utiliser cette outil pour retrouver des multi-comptes d\'une personne.
 </p></span>';

if (isset($_POST['user'])) {
	$info = Secu($_POST['user']);
	$get =  $bdd->query("SELECT ip_current FROM users WHERE username = '" . $info . "' LIMIT 1");
	$bdd->query("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES ('" . $user['username'] . "','a recherché si <b>" . $info . "</b> a de multi-comptes.','" . FullDate('full') . "')");
	if ($get->rowCount() > 0) {
		$ip = $get->fetchColumn(0);
	}

	echo '<br/><div class="frameV columns"><br/><div id="flash_messages"><div id="flash" style="background-image: none; background-color: rgb(255, 255, 255); ">
      <div id="error">';
}

if (isset($ip) && strlen($ip) > 0) {
	echo '<br/><h2 style="background-color: #CEE3F6; padding: 2px; border: 2px dotted black; text-align: center;">Utilisateurs sur l\'adresse IP :  <span style="background-color: #CEE3F6; padding: 2px;">' . $ip . '</span></h2>';
	$get = $bdd->query("SELECT * FROM users WHERE ip_current = '" . $ip . "' LIMIT 50");

	while ($info = $get->fetch(PDO::FETCH_ASSOC)) {
		$status = ($info['online'] == "1") ? '<img src="' . $imagepath . 'v2/images/online.gif" />' : '<img src="' . $imagepath . 'v2/images/offline.gif" />';
		echo '<div style="width: 50%;"><b>' . $info['username'] . '</b> <Small>(ID: ' . $info['id'] . ')</small><br /><span style="font-weight: normal;">Derni&egrave;re connexion: </>' . $connexion = date('d/m/Y H:i:s', $info['last_online']) . '</i><br />E-mail: <b>' . $info['mail'] . '</b><br />Cet utilisateur est <b>' . $status . '</b></span></div></div><br/><br/>

<div class="green_box_bottom"><div class="box box_bottom"></div></div></div></div>';
	}
}

echo '
      <div id="topic_search_loading"></div>
<div id="topic_search" style="display:none;">
  <div class="frame" style="margin-top: 15px; padding-bottom: 20px;">

    <div style="clear:both;"></div></div></div></div></div>
  </div>
</div>';
?>

</div>
</body>

</html>

</tr>