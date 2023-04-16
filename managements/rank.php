<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|           GabCMS - Site Web et Content Management System               #|
#|         Copyright © 2012-2014 - Gabodd Tout droits réservés.           #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");

if(!isset($_SESSION['username']))
	{
		Redirect("".$url."/index");
		exit();
	}
	
	if($user['rank'] < 8) {
	Redirect("".$url."/managements/acces_neg");
	exit();
	}
	if($user['rank'] > 8) {              
	Redirect("".$url."/managements/acces_neg");
	exit();
	}	
	
if(isset($_GET['do'])) {
$pseudo = Secu($_POST['name']);
$poste = Secu($_POST['poste']);
$name = explode(";", $pseudo);
$nbr = count($name);
$rang = Secu($_POST['rang']);

$do = Secu($_GET['do']);
			$correct = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '".$poste."'");
			$c = $correct->fetch();
if($do == "rank") {
	if(isset($pseudo)) {
		if(!empty($pseudo)) {
	for($n = 0; $n < $nbr; $n++):
		$sql = $bdd->query("SELECT id FROM users WHERE username = '".$name[$n]."'");
		$row = $sql->rowCount();
		$assoc = $sql->fetch(PDO::FETCH_ASSOC);
		if($row > 0) {
				
				if($rang == "modo") {
				$id = $sql->fetch(PDO::FETCH_ASSOC);
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $name[$n]);
            $insertn1->bindValue(':action', 'a été promu au rang de modérateur par <b>'.$user['username'].'</b>');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
		$bdd->query("UPDATE users SET rank = '5' WHERE username = '".$name[$n]."'");
		$bdd->query("INSERT INTO user_badges (user_id,badge_id) VALUES ('".$assoc['id']."','ADM')");
		$bdd->query("INSERT INTO user_badges (user_id,badge_id) VALUES ('".$assoc['id']."','HS1')");
        $insertn4 = $bdd->prepare("INSERT INTO gabcms_dossier (userid, commentaire, par, date, look, avis, ip, poste) VALUES (:id, :com, :par, :date, :look, :avis, :ip, :poste)");
            $insertn4->bindValue(':id', $assoc['id']);
            $insertn4->bindValue(':com', 'Promu ce jour, au poste de <b>modérateur</b>');
            $insertn4->bindValue(':par', $user['username']);
            $insertn4->bindValue(':date', FullDate('hc'));
            $insertn4->bindValue(':look', $user['look']);
            $insertn4->bindValue(':avis', '4');
            $insertn4->bindValue(':ip', $user['ip_last']);
            if($user['gender'] == 'M') { $insertn4->bindValue(':poste', addslashes($c['nom_M'])); } 
            elseif($user['gender'] == 'F') { $insertn4->bindValue(':poste', addslashes($c['nom_F'])); }
        $insertn4->execute();
        $insertn2 = $bdd->prepare("INSERT INTO gabcms_alertes (userid, sujet, alerte, par, date, look, action) VALUES (:id, :sujet, :alerte, :par, :date, :look, :act)");
            $insertn2->bindValue(':id', $assoc['id']);
            $insertn2->bindValue(':sujet', 'Promotion à un poste');
            $insertn2->bindValue(':alerte', 'Bonjour,<br/><br/>Tu viens d\'être promu au poste de <b>modérateur</b>. Pour bien commencer en notre compagnie, voici les principales choses à faire :<br/>- Visiter souvent le stafftchat<br/>- Approuver les notes de service<br/>- Respecter ses supérieurs<br/>- Bien faire son travail<br/><br/>Si tu as des questions, je reste à ta disposition. Bienvenue !');
            $insertn2->bindValue(':par', $user['username']);
            $insertn2->bindValue(':date', FullDate('full'));
            $insertn2->bindValue(':look', $user['look']);
            $insertn2->bindValue(':act', 'sml');
        $insertn2->execute();
        $insertn3 = $bdd->prepare("INSERT INTO gabcms_management (user_id, message, auteur, date, look) VALUES (:userid, :message, :auteur, :date, :look)");
            $insertn3->bindValue(':userid', $assoc['id']);
            $insertn3->bindValue(':message', 'Nous venons de t\'envoyer une alerte ! Merci d\'aller la lire au <b>PLUS VITE</b> en <a href="'.$url.'/alerts">cliquant ici</a> !');
            $insertn3->bindValue(':auteur', $user['username']);
            $insertn3->bindValue(':date', FullDate('full'));
            $insertn3->bindValue(':look', $user['look']);
        $insertn3->execute();
        $insertn5 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn5->bindValue(':pseudo', $name[$n]);
            $insertn5->bindValue(':action', 'a reçu automatiquement un commentaire sur son dossier');
            $insertn5->bindValue(':date', FullDate('full'));
        $insertn5->execute(); 
				} elseif($rang == "fondateurs") {
				$id = $sql->fetch(PDO::FETCH_ASSOC);
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $name[$n]);
            $insertn1->bindValue(':action', 'a été promu au rang de fondateur par <b>'.$user['username'].'</b>');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
		$bdd->query("UPDATE users SET rank = '8' WHERE username = '".$name[$n]."'");
		$bdd->query("INSERT INTO user_badges (user_id,badge_id) VALUES ('".$assoc['id']."','ADM')");
		$bdd->query("INSERT INTO user_badges (user_id,badge_id) VALUES ('".$assoc['id']."','HS1')");
        $insertn4 = $bdd->prepare("INSERT INTO gabcms_dossier (userid, commentaire, par, date, look, avis, ip, poste) VALUES (:id, :com, :par, :date, :look, :avis, :ip, :poste)");
            $insertn4->bindValue(':id', $assoc['id']);
            $insertn4->bindValue(':com', 'Promu ce jour, au poste de <b>fondateur</b>');
            $insertn4->bindValue(':par', $user['username']);
            $insertn4->bindValue(':date', FullDate('hc'));
            $insertn4->bindValue(':look', $user['look']);
            $insertn4->bindValue(':avis', '4');
            $insertn4->bindValue(':ip', $user['ip_last']);
            if($user['gender'] == 'M') { $insertn4->bindValue(':poste', addslashes($c['nom_M'])); } 
            elseif($user['gender'] == 'F') { $insertn4->bindValue(':poste', addslashes($c['nom_F'])); }
        $insertn4->execute();
        $insertn2 = $bdd->prepare("INSERT INTO gabcms_alertes (userid, sujet, alerte, par, date, look, action) VALUES (:id, :sujet, :alerte, :par, :date, :look, :act)");
            $insertn2->bindValue(':id', $assoc['id']);
            $insertn2->bindValue(':sujet', 'Promotion à un poste');
            $insertn2->bindValue(':alerte', 'Bonjour,<br/><br/>Tu viens d\'être promu au poste de <b>fondateur</b>. Pour bien commencer en notre compagnie, voici les principales choses à faire :<br/>- Visiter souvent le stafftchat<br/>- Approuver les notes de service<br/>- Respecter ses supérieurs<br/>- Bien faire son travail<br/><br/>Si tu as des questions, je reste à ta disposition. Bienvenue !');
            $insertn2->bindValue(':par', $user['username']);
            $insertn2->bindValue(':date', FullDate('full'));
            $insertn2->bindValue(':look', $user['look']);
            $insertn2->bindValue(':act', 'sml');
        $insertn2->execute();
        $insertn3 = $bdd->prepare("INSERT INTO gabcms_management (user_id, message, auteur, date, look) VALUES (:userid, :message, :auteur, :date, :look)");
            $insertn3->bindValue(':userid', $assoc['id']);
            $insertn3->bindValue(':message', 'Nous venons de t\'envoyer une alerte ! Merci d\'aller la lire au <b>PLUS VITE</b> en <a href="'.$url.'/alerts">cliquant ici</a> !');
            $insertn3->bindValue(':auteur', $user['username']);
            $insertn3->bindValue(':date', FullDate('full'));
            $insertn3->bindValue(':look', $user['look']);
        $insertn3->execute();
        $insertn5 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn5->bindValue(':pseudo', $name[$n]);
            $insertn5->bindValue(':action', 'a reçu automatiquement un commentaire sur son dossier');
            $insertn5->bindValue(':date', FullDate('full'));
        $insertn5->execute(); 
                } elseif($rang == "adm") {
				$id = $sql->fetch(PDO::FETCH_ASSOC);
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $name[$n]);
            $insertn1->bindValue(':action', 'a été promu au rang d\'administateur par <b>'.$user['username'].'</b>');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
		$bdd->query("UPDATE users SET rank = '6' WHERE username = '".$name[$n]."'");
		$bdd->query("INSERT INTO user_badges (user_id,badge_id) VALUES ('".$assoc['id']."','ADM')");
		$bdd->query("INSERT INTO user_badges (user_id,badge_id) VALUES ('".$assoc['id']."','HS1')");
        $insertn4 = $bdd->prepare("INSERT INTO gabcms_dossier (userid, commentaire, par, date, look, avis, ip, poste) VALUES (:id, :com, :par, :date, :look, :avis, :ip, :poste)");
            $insertn4->bindValue(':id', $assoc['id']);
            $insertn4->bindValue(':com', 'Promu ce jour, au poste d\'<b>administrateur</b>');
            $insertn4->bindValue(':par', $user['username']);
            $insertn4->bindValue(':date', FullDate('hc'));
            $insertn4->bindValue(':look', $user['look']);
            $insertn4->bindValue(':avis', '4');
            $insertn4->bindValue(':ip', $user['ip_last']);
            if($user['gender'] == 'M') { $insertn4->bindValue(':poste', addslashes($c['nom_M'])); } 
            elseif($user['gender'] == 'F') { $insertn4->bindValue(':poste', addslashes($c['nom_F'])); }
        $insertn4->execute();
        $insertn2 = $bdd->prepare("INSERT INTO gabcms_alertes (userid, sujet, alerte, par, date, look, action) VALUES (:id, :sujet, :alerte, :par, :date, :look, :act)");
            $insertn2->bindValue(':id', $assoc['id']);
            $insertn2->bindValue(':sujet', 'Promotion à un poste');
            $insertn2->bindValue(':alerte', 'Bonjour,<br/><br/>Tu viens d\'être promu au poste d\'<b>administrateur</b>. Pour bien commencer en notre compagnie, voici les principales choses à faire :<br/>- Visiter souvent le stafftchat<br/>- Approuver les notes de service<br/>- Respecter ses supérieurs<br/>- Bien faire son travail<br/><br/>Si tu as des questions, je reste à ta disposition. Bienvenue !');
            $insertn2->bindValue(':par', $user['username']);
            $insertn2->bindValue(':date', FullDate('full'));
            $insertn2->bindValue(':look', $user['look']);
            $insertn2->bindValue(':act', 'sml');
        $insertn2->execute();
        $insertn3 = $bdd->prepare("INSERT INTO gabcms_management (user_id, message, auteur, date, look) VALUES (:userid, :message, :auteur, :date, :look)");
            $insertn3->bindValue(':userid', $assoc['id']);
            $insertn3->bindValue(':message', 'Nous venons de t\'envoyer une alerte ! Merci d\'aller la lire au <b>PLUS VITE</b> en <a href="'.$url.'/alerts">cliquant ici</a> !');
            $insertn3->bindValue(':auteur', $user['username']);
            $insertn3->bindValue(':date', FullDate('full'));
            $insertn3->bindValue(':look', $user['look']);
        $insertn3->execute();
        $insertn5 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn5->bindValue(':pseudo', $name[$n]);
            $insertn5->bindValue(':action', 'a reçu automatiquement un commentaire sur son dossier');
            $insertn5->bindValue(':date', FullDate('full'));
        $insertn5->execute(); 
                } elseif($rang == "manager") {
				$id = $sql->fetch(PDO::FETCH_ASSOC);
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $name[$n]);
            $insertn1->bindValue(':action', 'a été promu au rang de manager par <b>'.$user['username'].'</b>');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
		$bdd->query("UPDATE users SET rank = '7' WHERE username = '".$name[$n]."'");
		$bdd->query("INSERT INTO user_badges (user_id,badge_id) VALUES ('".$assoc['id']."','ADM')");
		$bdd->query("INSERT INTO user_badges (user_id,badge_id) VALUES ('".$assoc['id']."','HS1')");
        $insertn4 = $bdd->prepare("INSERT INTO gabcms_dossier (userid, commentaire, par, date, look, avis, ip, poste) VALUES (:id, :com, :par, :date, :look, :avis, :ip, :poste)");
            $insertn4->bindValue(':id', $assoc['id']);
            $insertn4->bindValue(':com', 'Promu ce jour, au poste de <b>manager</b>');
            $insertn4->bindValue(':par', $user['username']);
            $insertn4->bindValue(':date', FullDate('hc'));
            $insertn4->bindValue(':look', $user['look']);
            $insertn4->bindValue(':avis', '4');
            $insertn4->bindValue(':ip', $user['ip_last']);
            if($user['gender'] == 'M') { $insertn4->bindValue(':poste', addslashes($c['nom_M'])); } 
            elseif($user['gender'] == 'F') { $insertn4->bindValue(':poste', addslashes($c['nom_F'])); }
        $insertn4->execute();
        $insertn2 = $bdd->prepare("INSERT INTO gabcms_alertes (userid, sujet, alerte, par, date, look, action) VALUES (:id, :sujet, :alerte, :par, :date, :look, :act)");
            $insertn2->bindValue(':id', $assoc['id']);
            $insertn2->bindValue(':sujet', 'Promotion à un poste');
            $insertn2->bindValue(':alerte', 'Bonjour,<br/><br/>Tu viens d\'être promu au poste de <b>manager</b>. Pour bien commencer en notre compagnie, voici les principales choses à faire :<br/>- Visiter souvent le stafftchat<br/>- Approuver les notes de service<br/>- Respecter ses supérieurs<br/>- Bien faire son travail<br/><br/>Si tu as des questions, je reste à ta disposition. Bienvenue !');
            $insertn2->bindValue(':par', $user['username']);
            $insertn2->bindValue(':date', FullDate('full'));
            $insertn2->bindValue(':look', $user['look']);
            $insertn2->bindValue(':act', 'sml');
        $insertn2->execute();
        $insertn3 = $bdd->prepare("INSERT INTO gabcms_management (user_id, message, auteur, date, look) VALUES (:userid, :message, :auteur, :date, :look)");
            $insertn3->bindValue(':userid', $assoc['id']);
            $insertn3->bindValue(':message', 'Nous venons de t\'envoyer une alerte ! Merci d\'aller la lire au <b>PLUS VITE</b> en <a href="'.$url.'/alerts">cliquant ici</a> !');
            $insertn3->bindValue(':auteur', $user['username']);
            $insertn3->bindValue(':date', FullDate('full'));
            $insertn3->bindValue(':look', $user['look']);
        $insertn3->execute();
        $insertn5 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn5->bindValue(':pseudo', $name[$n]);
            $insertn5->bindValue(':action', 'a reçu automatiquement un commentaire sur son dossier');
            $insertn5->bindValue(':date', FullDate('full'));
        $insertn5->execute(); 
                } echo '<h4 class="alert_success">Le compte <b>'.$name[$n].'</b> a reçu son rank.</h4>';
					} else {
					echo '<h4 class="alert_error">Le compte <b>'.$name[$n].'</b> n\'existe pas.</h4>';
					}	
	endfor;
									 } else {
					echo '<h4 class="alert_error">Les champs ne sont pas tous remplis.</h4>';
					}
			} 
	}
}
?><link rel="stylesheet" href="css/contenu.css" type="text/css" media="screen" /><body> 
<span id="titre">Attribues un rank.</span><br />
Attribues un rang &agrave; un utilisateur.<br/><br/>
<form name='editor' method='post' action="?do=rank">
<td width='100' class='tbl'><b>Pseudo :</b><br/></td>
<td width='80%' class='tbl'><textarea name='name' wrap=discuss rows=3 cols=34 ></textarea><br/></td>
<td width='100' class='tbl'><b>Rang :</b><br/></td>
<td width='80%' class='tbl'>
 <select name="rang" id="pays">
			<option value="modo">Modérateur</option>
			<option value="adm">Administrateur</option>
			<option value="manager">Manager</option>
			<option value="fondateurs">Fondateur</option>
       </select></td><br/>
<td width='100' class='tbl'><b>Mon poste :</b> (pour afficher dans le dossier)<br/></td>
<td width='80%' class='tbl'>
	<select name="poste" id="pays">
        <option value="">-- Choisis ton poste --</option>
<?PHP
if($user['gender'] == M) {
$sql_a = $bdd->query("SELECT * FROM gabcms_postes WHERE user_id = '".$user['id']. "' ORDER BY id DESC");
while($a = $sql_a->fetch()) {
			$correct = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '".$a['poste']."'");
			$c = $correct->fetch();
?>
			<option value="<?PHP echo $a['poste']; ?>"><?PHP echo $c['nom_M']; ?></option>
<?PHP } } if($user['gender'] == F) {
$sql_a = $bdd->query("SELECT * FROM gabcms_postes WHERE user_id = '".$user['id']. "' ORDER BY id DESC");
while($a = $sql_a->fetch()) {
			$correct = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '".$a['poste']."'");
			$c = $correct->fetch();
?>
			<option value="<?PHP echo $a['poste']; ?>"><?PHP echo $c['nom_F']; ?></option>
<?PHP } } ?>
	</select>
</td>
<tr><br/><br/>
<td align='center' colspan='2' class='tbl'>
<input type='submit' name='submit' value='Ex&eacute;cuter' class='submit'></form>
</tr>
</body>
</html>