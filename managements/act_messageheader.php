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
	
	if($user['rank'] < 7) {
	Redirect("".$url."/managements/acces_neg");
	exit();
	}
	if($user['rank'] > 8) {              
	Redirect("".$url."/managements/acces_neg");
	exit();
	}	
	
	if(isset($_POST['afficher']) || isset($_POST['couleur']) || isset($_POST['message'])) {
   $afficher = Secu($_POST['afficher']);
   $couleur = Secu($_POST['couleur']);
   $message = addslashes($_POST['message']);
      if($message != "") {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a modifié l\'affichage de l\'header');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
        $bdd->query("UPDATE gabcms_header SET afficher = '".$afficher."', couleur = '".$couleur."', message = '".$message."' WHERE id = '1'");
	  echo '<h4 class="alert_success">Le message a été mis à jour</h4>';
	  } else {
	  echo '<h4 class="alert_error">Merci de remplir les champs vides</h4>';
	  }
  }
$sql = $bdd->query("SELECT * FROM gabcms_header WHERE id = '1'");
$c = $sql->fetch(PDO::FETCH_ASSOC);
?>
<link rel="stylesheet" href="css/contenu.css" type="text/css" media="screen" /><body>
<span id="titre">Message de l'header</span><br/>
Modifies le message de l'header, la couleur de fond...
 <br/><br/>
 <script type="text/javascript" src="editeur_html/jscripts/tiny_mce/tiny_mce.js"></script>
<b>Actuellement</b> 
<br/> - Message : <span style="background-color:#<?PHP echo $c['couleur']; ?>; color:#FFFFFF;"><?PHP echo stripslashes($c['message']); ?></span>
<br/> - Activé ? <b><?PHP echo $c['afficher']; ?></b><br/><br/>  

 <form name='editor' method='post' action="?do=modif">
<td width='100' class='tbl'><b>Message a afficher :</b><br/></td>
<td width='80%' class='tbl'><textarea name="message" rows=1 cols=75 maxlength="300"><?PHP echo nl2br($c['message']);?></textarea><br/></td>
<br/>
<td width='100' class='tbl'><b>Couleur de fond</b><br/></td>
<label><input type="radio" name="couleur" value="008000" <?PHP if($c['couleur'] == "008000") { ?> checked="checked" <?PHP } ?> /><span style="color:#008000;">Vert</span></label> 
<label><input type="radio" name="couleur" value="FF0000" <?PHP if($c['couleur'] == "FF0000") { ?> checked="checked" <?PHP } ?> /><span style="color:#FF0000;">Rouge</span></label> 
<label><input type="radio" name="couleur" value="0000FF" <?PHP if($c['couleur'] == "0000FF") { ?> checked="checked" <?PHP } ?> /><span style="color:#0000FF;">Bleu</span></label> 
<label><input type="radio" name="couleur" value="FF8000" <?PHP if($c['couleur'] == "FF8000") { ?> checked="checked" <?PHP } ?> /><span style="color:#FF8000;">Orange</span></label> 
<label><input type="radio" name="couleur" value="000000" <?PHP if($c['couleur'] == "000000") { ?> checked="checked" <?PHP } ?> /><span style="color:#000000;">Noir</span></label> 
<br/><br/>
<td width='100' class='tbl'><b>Affichage :</b><br/></td>
<label><input type="radio" name="afficher" value="Non" <?PHP if($c['afficher'] == "Non") { ?> checked="checked" <?PHP } ?> /><span style="color:#FF0000;">Non afficher</span></label> 
<label><input type="radio" name="afficher" value="Oui" <?PHP if($c['afficher'] == "Oui") { ?> checked="checked" <?PHP } ?> /><span style="color:#008800;">Afficher</span></label> 
<br/><br/>
<td align='center' colspan='2' class='tbl'>
<input type='submit' name='submit' value='Exécuter' class='submit'></form>
<br/>
</body>
</html>