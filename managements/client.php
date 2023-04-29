<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");

if (!isset($_SESSION['username']) || $user['rank'] > 11) {
	Redirect("" . $url . "/managements/access_neg");
	exit();
}

if (isset($_POST['ip'], $_POST['port'], $_POST['mus_port'], $_POST['variable'], $_POST['texte'], $_POST['swf'], $_POST['version'], $_POST['loading_texte'])) {
	$ip = Secu($_POST['ip']);
	$port = Secu($_POST['port']);
	$mus_port = Secu($_POST['mus_port']);
	$variable = Secu($_POST['variable']);
	$texte = Secu($_POST['texte']);
	$swf = Secu($_POST['swf']);
	$version = Secu($_POST['version']);
	$loading = Secu($_POST['loading_texte']);
	if ($ip && is_numeric($mus_port) && is_numeric($port) && $variable && $texte && $swf && $version && $loading) {
		$insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
		$insertn1->execute(array(':pseudo' => $user['username'], ':action' => 'a modifié le client', ':date' => FullDate('full')));
		$bdd->query("UPDATE gabcms_client SET ip = '$ip', port = '$port', mus_port = '$mus_port', variable = '$variable', texte = '$texte', swf = '$swf', version = '$version', loading_texte = '$loading' WHERE id = '1'");
		echo '<h4 class="alert_success">Le client a été mis à jour.</h4>';
	} elseif (!is_numeric($mus_port)) {
		echo '<h4 class="alert_error">Merci de mettre exclusivement des chiffres dans "Mus Port"</h4>';
	} elseif (!is_numeric($port)) {
		echo '<h4 class="alert_error">Merci de mettre exclusivement des chiffres dans "Port"</h4>';
	} else {
		echo '<h4 class="alert_error">Merci de remplir tous les champs.</h4>';
	}
}


$sql = $bdd->query("SELECT * FROM gabcms_client WHERE id = '1'");
$c = $sql->fetch(PDO::FETCH_ASSOC);
?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />

<body>
	<span id="titre">Modification du client</span><br />
	Modifie les différentes informations du client.<br /><br />
	<script type="text/javascript" src="editeur_html/jscripts/tiny_mce/tiny_mce.js"></script>
	<form name='editor' method='post' action="#">
		<td width='100' class='tbl'><b>Adresse IP de votre serveur :</b><br /></td>
		<td width='80%' class='tbl'><input type='text' name='ip' value='<?PHP echo $c['ip']; ?>' class='text' style='width: 240px'><br /></td>
		<br />
		<td width='100' class='tbl'><b>Port :</b><br /></td>
		<td width='80%' class='tbl'><input type='text' name='port' value='<?PHP echo $c['port']; ?>' class='text' size='5' maxlength="5"><br /></td>
		<br />
		<td width='100' class='tbl'><b>Mus Port :</b><br /></td>
		<td width='80%' class='tbl'><input type='text' name='mus_port' value='<?PHP echo $c['mus_port']; ?>' class='text' size='5' maxlength="5"><br /></td>
		<br />
		<td width='100' class='tbl'><b>Variable :</b><br /></td>
		<td width='80%' class='tbl'><input type='text' name='variable' value='<?PHP echo $c['variable']; ?>' class='text' style='width: 440px'><br /></td>
		<br />
		<td width='100' class='tbl'><b>Texte :</b><br /></td>
		<td width='80%' class='tbl'><input type='text' name='texte' value='<?PHP echo $c['texte']; ?>' class='text' style='width: 440px'><br /></td>
		<br />
		<td width='100' class='tbl'><b>SWF :</b><br /></td>
		<td width='80%' class='tbl'><input type='text' name='swf' value='<?PHP echo $c['swf']; ?>' class='text' style='width: 440px'><br /></td>
		<br />
		<td width='100' class='tbl'><b>Version :</b><br /></td>
		<td width='80%' class='tbl'><input type='text' name='version' value='<?PHP echo $c['version']; ?>' class='text' style='width: 440px'><br /></td>
		<br />
		<td width='100' class='tbl'><b>Texte de Chargement :</b><br /></td>
		<td width='80%' class='tbl'><input type='text' name='loading_texte' value='<?PHP echo $c['loading_texte']; ?>' class='text' style='width: 240px'><br /></td>
		<br />
		<td align='center' colspan='2' class='tbl'>
			<input type='submit' name='submit' value='Exécuter' class='submit'>
	</form>
</body>

</html>