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
	
	if($user['rank'] < 8) {
	Redirect("".$url."/managements/acces_neg");
	exit();
	}
	if($user['rank'] > 8) {              
	Redirect("".$url."/managements/acces_neg");
	exit();
	}	
	
	if(isset($_POST['pseudo']) || isset($_POST['poste'])) {
   $pseudo = Secu($_POST['pseudo']);
   $poste = Secu($_POST['poste']);
  	$sql = $bdd->query("SELECT * FROM users WHERE username = '".$pseudo."'");
	$row = $sql->rowCount();
	$assoc = $sql->fetch(PDO::FETCH_ASSOC);
		$search = $bdd->query("SELECT user_id FROM gabcms_postes WHERE poste = '".$poste."' AND user_id = '".$assoc['id']."'");
		$ok = $search->fetch();
			$correct = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '".$poste."'");
			$c = $correct->fetch();
      if($pseudo != "" && $ok['user_id'] != $assoc['id'] && $poste != "") {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            if($assoc['gender'] == 'M') { $insertn1->bindValue(':action', 'a attribué le poste de <b>'.addslashes($c['nom_M']).'</b> à <b>'.$pseudo.'</b>'); } 
            elseif($assoc['gender'] == 'F') { $insertn1->bindValue(':action', 'a attribué le poste de <b>'.addslashes($c['nom_F']).'</b> à <b>'.$pseudo.'</b>'); }
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
        $insertn2 = $bdd->prepare("INSERT INTO gabcms_postes (user_id, poste, par, date) VALUES (:id, :poste, :par, :date)");
            $insertn2->bindValue(':id', $assoc['id']);
            $insertn2->bindValue(':poste', $poste);
            $insertn2->bindValue(':par', $user['username']);
            $insertn2->bindValue(':date', FullDate('full'));
        $insertn2->execute();
        if($assoc['gender'] == 'M') { echo '<h4 class="alert_success">Le poste de <b>'.$c['nom_M'].'</b> a bien été attribué à <b>'.$pseudo.'</b></h4>'; }
        if($assoc['gender'] == 'F') { echo '<h4 class="alert_success">Le poste de <b>'.$c['nom_F'].'</b> a bien été attribué à <b>'.$pseudo.'</b></h4>'; }
	  } else if($ok['user_id'] == $assoc['id']) {
	  echo '<h4 class="alert_error"><b>'.$pseudo.'</b> a déjà le poste de <b>'.$c['nom_M'].'</b></h4>';
	  } else {
	  echo '<h4 class="alert_error">Merci de remplir les champs vides.</h4>';
	} 
}
?><link rel="stylesheet" href="css/contenu.css<?php echo '?'.mt_rand(); ?>" type="text/css" media="screen" /><body>
<span id="titre">Donnes des fonctions précises</span><br/>
Ces fonctions ne jouent en rien dans l'accès aux pages, mais affiche sur la page staff le poste au survole du pseudo.<br/><br/>
 <script type="text/javascript" src="editeur_html/jscripts/tiny_mce/tiny_mce.js"></script>
 <form name='editor' method='post' action="#">
<td width='100' class='tbl'><b>Pseudo :</b><br/></td>
<td width='80%' class='tbl'><select name="pseudo" id="pays">
<?PHP
$sql_a = $bdd->query("SELECT * FROM users WHERE rank >= '4' ORDER BY rank DESC");
while($a = $sql_a->fetch()) {
?>
			<option value="<?PHP echo $a['username']; ?>"><?PHP echo $a['username']; ?></option>
<?PHP } ?>
	</select><br/></td>
<td width='100' class='tbl'><b>Poste :</b><br/></td>
<td width='80%' class='tbl'>
	<select name="poste" id="pays" size="15">
<?PHP
$sql_a = $bdd->query("SELECT * FROM gabcms_postes_categorie ORDER BY id ASC");
while($a = $sql_a->fetch()) {
?>
				<optgroup label="<?PHP echo $a['nom'] ?>">
<?PHP
$sql_b = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id_categorie = '".$a['id']."' ORDER BY id ASC");
while($b = $sql_b->fetch()) {
?>
			<option value="<?PHP echo $b['id'] ?>"><?PHP echo $b['nom_M'] ?></option>
<?PHP } ?>
				</optgroup>
<?PHP } ?>
</select>
</td><br/><br/>
<tr><td align='center' colspan='2' class='tbl'>
<input type='submit' name='submit' value='Exécuter' class='submit'></form>
</tr>
<br/>
</body>
</html>