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

if(isset($_GET['modif'])) { $modif = Secu($_GET['modif']); }
if(isset($_GET['do'])) { $do = Secu($_GET['do']);
 $sqz = $bdd->query("SELECT * FROM gabcms_absence_staff WHERE id = '".$do."'");
 $z = $sqz->fetch();
}
if(isset($_GET['modifierrecrut'])) { 
$modifierrecrut = Secu($_GET['modifierrecrut']); 
 $sql = $bdd->query("SELECT * FROM gabcms_absence_staff WHERE id = '".$modifierrecrut."'");
 $a = $sql->fetch();
if($modifierrecrut != "") {
	if(isset($_POST['message'])) {
	$sujet = Secu($_POST['sujet']);
	$message = addslashes($_POST['message']);
	$act = Secu($_POST['act']);
	$sql = $bdd->query("SELECT id FROM users WHERE username = '".$a['pseudo']."'");
	$row = $sql->rowCount();
	$assoc = $sql->fetch(PDO::FETCH_ASSOC);
      if($message != "" && $user['username'] != $a['pseudo']) {
        $bdd->query("UPDATE gabcms_absence_staff SET etat = '2' WHERE id = '".$modifierrecrut."'");
        $insertn2 = $bdd->prepare("INSERT INTO gabcms_management (user_id, message, auteur, date, look) VALUES (:userid, :message, :auteur, :date, :look)");
            $insertn2->bindValue(':userid', $assoc['id']);
            $insertn2->bindValue(':message', 'Nous venons de traiter ta demande d\'absence ! Merci d\'aller lire la raison de ton refus en <a href="'.$url.'/alerts">cliquant ici</a> !');
            $insertn2->bindValue(':auteur', $user['username']);
            $insertn2->bindValue(':date', FullDate('full'));
            $insertn2->bindValue(':look', $user['look']);
        $insertn2->execute();
        $insertn3 = $bdd->prepare("INSERT INTO gabcms_alertes (userid, sujet, alerte, par, date, look, action) VALUES (:id, :sujet, :alerte, :par, :date, :look, :act)");
            $insertn3->bindValue(':id', $assoc['id']);
            $insertn3->bindValue(':sujet', 'Refus de ton absence');
            $insertn3->bindValue(':alerte', 'Ton absence a été refusée pour la raison suivante : <b>'.$message.'</b>');
            $insertn3->bindValue(':par', $user['username']);
            $insertn3->bindValue(':date', FullDate('full'));
            $insertn3->bindValue(':look', $user['look']);
            $insertn3->bindValue(':act', $act);
        $insertn3->execute();
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a traité l\'absence de <b>'.$a['pseudo'].'</b> et a refusé son absence');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
	  echo '<h4 class="alert_success">L\'absence a été refusée.</h4>';
	  } else if($user['username'] == $a['pseudo']) {
	  echo '<h4 class="alert_error">Vous ne pouvez pas refuser une absence émise par vous même.</h4>';
	  } else {
	  echo '<h4 class="alert_error">Vous ne pouvez pas supprimer cette absence</h4>';
	  }
  }
		}
}
if(isset($_GET['do'])) {
	  if($do != "" && $user['username'] != $z['pseudo']) {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a traité l\'absence de <b>'.$z['pseudo'].'</b> et a accepté son absence');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
        $bdd->query("UPDATE gabcms_absence_staff SET etat = '1' WHERE id = '".$do."'");
   	  echo '<h4 class="alert_success">L\'absence a été validée.</h4>';
 	} else if($user['username'] == $z['pseudo']) {
	  echo '<h4 class="alert_error">Vous ne pouvez pas valider une absence émise par vous même.</h4>';
	  }
}
?><link rel="stylesheet" href="css/contenu.css" type="text/css" media="screen" /><body>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<?php if(!isset($_GET['modif'])) { ?>
<span id="titre">Actions sur les absences</span><br/>
Refuse ou accepte une absence émise par les staffs.
<br/><br/>
<table>
    <tbody>
        <tr class="haut">
            <td class="haut">Pseudo</td>
            <td class="haut">Date de départ</td>
            <td class="haut">Date de retour</td>
            <td class="haut">Raison</td>
            <td class="haut">Traité</td>
        </tr>
<?php
 $sql = $bdd->query("SELECT * FROM gabcms_absence_staff WHERE etat = 0 ORDER BY id DESC");
 while($a = $sql->fetch()) {
$date_depuis = date('d/m/Y', $a['depuis']);
$date_jusqua = date('d/m/Y', $a['jusqua']);
?>
        <tr class="bas">
            <td class="bas"><?PHP echo $a['pseudo']; ?></td>
            <td class="bas"><?PHP echo $date_depuis; ?></td>
            <td class="bas"><?PHP echo $date_jusqua; ?></td>
            <td class="bas"><?PHP echo $a['raison']; ?></td>
            <td class="bas"><a href="?modif=<?PHP echo $a['id']; ?>"><img src="<?PHP echo $url; ?>/managements/img/images/invalide.gif" /></a> - <a href="?do=<?PHP echo $a['id']; ?>"><img src="<?PHP echo $url; ?>/managements/img/images/valide.gif" /></a></center></td>
        </tr>
<?PHP } ?>
    </tbody>
</table><hr/>
<span id="titre">Absences en cours</span><br/>
Voici les absences en cours, ainsi que les raisons.
<br/><br/>
<?PHP 
$req_sql = $bdd->query("SELECT * FROM gabcms_absence_staff WHERE depuis <= '".$nowtime."' AND jusqua > '".$nowtime."' AND etat = '1'");
$compte = $req_sql->rowCount();
          if($compte == '0') {
?>
<i>Aucune absence en cours</i>
<?PHP
          } else {
?>
<table>
    <tbody>
        <tr class="haut">
            <td class="haut">Pseudo</td>
            <td class="haut">Date de départ</td>
            <td class="haut">Date de retour</td>
            <td class="haut">Raison</td>
        </tr>
<?php
 $sql = $bdd->query("SELECT * FROM gabcms_absence_staff WHERE depuis <= '".$nowtime."' AND jusqua > '".$nowtime."' AND etat = '1'");
 while($a = $sql->fetch()) {
$date_depuis = date('d/m/Y', Secu($a['depuis']));
$date_jusqua = date('d/m/Y', Secu($a['jusqua']));
?>
        <tr class="bas">
            <td class="bas"><?PHP echo Secu($a['pseudo']); ?></td>
            <td class="bas"><?PHP echo $date_depuis; ?></td>
            <td class="bas"><?PHP echo $date_jusqua; ?></td>
            <td class="bas"><?PHP echo Secu($a['raison']); ?></td>
        </tr>
<?PHP } ?>
    </tbody>
</table>
<?PHP } } if(isset($_GET['modif'])) {
$sql_modif = $bdd->query("SELECT * FROM gabcms_absence_staff WHERE id = '".$modif."'");
$modif_a = $sql_modif->fetch();
?>
<span id="titre">Actions sur les absences</span><br/>
Annule une absence et explique la raison de ton refus
<form name='editor' method='post' action="?modifierrecrut=<?php echo $modif; ?>">
 <script language="javascript" type="text/javascript">
   function insert_texte(texte)
   {
       var ou = document.getElementsByName("alerte")[0];
       var phrase = texte +" ";
       ou.value += phrase;
       ou.focus();
   }
</script>
<td width='100' class='tbl'><b>Pseudo :</b><br/></td>
<td width='80%' class='tbl'><input type='text' name='username' value='<?PHP echo $modif_a['pseudo']; ?>' class='text' style='width: 240px' disabled='disabled'><br/></td><br/>
<td width='100' class='tbl'><b>Sujet :</b><br/></td>
<td width='80%' class='tbl'><input type='text' name='sujet' value='Refus de votre absence' class='text' style='width: 240px' disabled='disabled'><br/></td>																																			<br/>
<td width='100' class='tbl'><b>Raison :</b><br/></td>
<a href="#" onclick="insert_texte('<b> </b>')"><img src="<?PHP echo $imagepath; ?>smileys/gras.png"/></a>
<a href="#" onclick="insert_texte('<i> </i>')"><img src="<?PHP echo $imagepath; ?>smileys/italique.png"/></a>
<a href="#" onclick="insert_texte('<u> </u>')"><img src="<?PHP echo $imagepath; ?>smileys/souligne.png"/></a><br/>
<td width='80%' class='tbl'><textarea name='message' wrap=discuss rows=3 cols=34 ></textarea><br/></td>
<td width='100' class='tbl'><b>Trait du visage :</b><br/></td>
<select name="act" id="pays">
			<option value="0">Normal</option>
			<option value="sml">Heureux</option>
			<option value="agr">Énervé</option>
			<option value="srp">Étonné</option>			
</select>
<br/><br/>
	<input type="submit" value="Refuser son absence" />

</form>
<?PHP } ?>
</body>
</html>