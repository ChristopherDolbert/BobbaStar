<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");

if(!isset($_SESSION['username']))
	{
		Redirect("".$url."/index");
		exit();
	}
	
	if($user['rank'] < 7) {
	Redirect("".$url."/managements/acces_neg");
	exit();
	}
	if($user['rank'] > 8) {              
	Redirect("".$url."/managements/acces_neg");
	exit();
	}	
	
if(isset($_POST['pseudo']) && isset($_POST['commentaire'])) {
	if(empty($_POST['pseudo']) && empty($_POST['commentaire'])) {
	} else {
	$pseudo = Secu($_POST['pseudo']);
	$commentaire = addslashes($_POST['commentaire']);
	$avis = Secu($_POST['avis']);
	$poste = Secu($_POST['poste']);
	$sql = $bdd->query("SELECT id FROM users WHERE username = '".$pseudo."'");
	$row = $sql->rowCount();
	$assoc = $sql->fetch(PDO::FETCH_ASSOC);
			$correct = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '".$poste."'");
			$c = $correct->fetch();
	if($user['username'] != $pseudo && $commentaire != "") {
        if($poste != "") {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a émis un commentaire sur le dossier de <b>'.$pseudo.'</b>');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
        $insertn2 = $bdd->prepare("INSERT INTO gabcms_management (user_id, message, auteur, date, look) VALUES (:userid, :message, :auteur, :date, :look)");
            $insertn2->bindValue(':userid', $assoc['id']);
            $insertn2->bindValue(':message', 'Je viens de commenter ton dossier, merci d\'aller le lire au <b>PLUS VITE</b> en <a href="'.$url.'/managements/mondossier">cliquant ici</a> !');
            $insertn2->bindValue(':auteur', $user['username']);
            $insertn2->bindValue(':date', FullDate('full'));
            $insertn2->bindValue(':look', $user['look']);
        $insertn2->execute();
		$insertn4 = $bdd->prepare("INSERT INTO gabcms_dossier (userid, commentaire, par, date, look, avis, ip, poste) VALUES (:id, :com, :par, :date, :look, :avis, :ip, :poste)");
            $insertn4->bindValue(':id', $assoc['id']);
            $insertn4->bindValue(':com', $commentaire);
            $insertn4->bindValue(':par', $user['username']);
            $insertn4->bindValue(':date', FullDate('hc'));
            $insertn4->bindValue(':look', $user['look']);
            $insertn4->bindValue(':avis', $avis);
            $insertn4->bindValue(':ip', $user['ip_last']);
            if($user['gender'] == 'M') { $insertn4->bindValue(':poste', addslashes($c['nom_M'])); } 
            elseif($user['gender'] == 'F') { $insertn4->bindValue(':poste', addslashes($c['nom_F'])); }
        $insertn4->execute();
	echo '<h4 class="alert_success">Le commentaire a été ajouter avec succès !</h4>';
	  } else {
	  echo '<h4 class="alert_error">Veuillez sélectionner votre poste afin de l\'afficher dans le dossier du joueur</h4>';
	  } } else if($user['username'] == $pseudo) {
	  echo '<h4 class="alert_error">Vous ne pouvez pas commenter votre propre dossier</h4>';
	  } else {
	  echo '<h4 class="alert_error">Merci de renseigner les champs vides</h4>';
	  }
  }
  }
?>
<link rel="stylesheet" href="css/contenu.css" type="text/css" media="screen" /><body>
 <script language="javascript" type="text/javascript">
   function insert_texte(texte)
   {
       var ou = document.getElementsByName("commentaire")[0];
       var phrase = texte +" ";
       ou.value += phrase;
       ou.focus();
   }
</script>
<span id="titre">Ajoutes un commentaire</span><br/>
Ajoutes un commentaire, favorable, mitigé, ou défavorable sur le dossier du staff de ton choix.
 <br/>
 <br/> 
 <form method="post" action="?do=givebadge">
<td width='100' class='tbl'><b>Pseudo :</b><br/></td>
<td width='80%' class='tbl'><select name="pseudo" id="pays">
<?PHP
$sql_a = $bdd->query("SELECT * FROM users WHERE rank >= '4' ORDER BY rank DESC");
while($a = $sql_a->fetch()) {
?>
			<option value="<?PHP echo $a['username']; ?>"><?PHP echo $a['username']; ?></option>
<?PHP } ?>
	</select><br/></td><br/>
<td width='100' class='tbl'><b>Avis :</b><br/></td>
<label><input type="radio" name="avis" value="1" checked="checked" /><img alt="1" src="<?PHP echo $url; ?>/managements/img/dossier/1.png" /> <span style="color:#008000;">(Avis favorable)</span></label> 
<label><input type="radio" name="avis" value="2" /><img alt="2" src="<?PHP echo $url; ?>/managements/img/dossier/2.png" /> <span style="color:#FF4500;">(Avis mitigé)</span></label> 
<label><input type="radio" name="avis" value="3" /><img alt="3" src="<?PHP echo $url; ?>/managements/img/dossier/3.png" /> <span style="color:#FF0000;">(Avis défavorable)</span></label><br/><br/>
<a href="#" onclick="insert_texte('<b> </b>')"><img src="<?PHP echo $imagepath; ?>smileys/gras.png"/></a>
<a href="#" onclick="insert_texte('<i> </i>')"><img src="<?PHP echo $imagepath; ?>smileys/italique.png"/></a>
<a href="#" onclick="insert_texte('<u> </u>')"><img src="<?PHP echo $imagepath; ?>smileys/souligne.png"/></a><br/>
<td width='80%' class='tbl'><textarea name='commentaire' wrap=discuss rows=3 cols=34 ></textarea><br/></td><br/>
<td width='100' class='tbl'><b>Mon poste :</b> (pour afficher dans le dossier)<br/></td>
<td width='80%' class='tbl'>
	<select name="poste" id="pays">
            <option value="">-- Choisis ton poste --</option>
<?PHP
if($user['gender'] == 'M') {
$sql_a = $bdd->query("SELECT * FROM gabcms_postes WHERE user_id = '".$user['id']. "' ORDER BY id DESC");
while($a = $sql_a->fetch()) {
			$correct = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '".$a['poste']."'");
			$c = $correct->fetch();
?>
			<option value="<?PHP echo $a['poste']; ?>"><?PHP echo $c['nom_M']; ?></option>
<?PHP } } if($user['gender'] == 'F') {
$sql_a = $bdd->query("SELECT * FROM gabcms_postes WHERE user_id = '".$user['id']. "' ORDER BY id DESC");
while($a = $sql_a->fetch()) {
			$correct = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '".$a['poste']."'");
			$c = $correct->fetch();
?>
			<option value="<?PHP echo $a['poste']; ?>"><?PHP echo $c['nom_F']; ?></option>
<?PHP } } ?>
	</select>
</td><br/><br/>
	<input type="submit" value="Envoyer le commentaire" />

</form>
<br/>
</body>
</html>