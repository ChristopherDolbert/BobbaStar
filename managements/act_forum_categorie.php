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

if(isset($_GET['modif'])) { $modif = Secu($_GET['modif']); }

if(isset($_GET['do'])) {
$do = Secu($_GET['do']);
    if($do == "create") {
        if(isset($_POST['nom_categorie'])) {
            $nom_categorie = addslashes($_POST['nom_categorie']);
            $couleur = addslashes($_POST['couleur']);
                if($nom_categorie != "" && $couleur != "") {
            $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
                $insertn1->bindValue(':pseudo', $user['username']);
                $insertn1->bindValue(':action', 'a créé une catégorie de forum <b>('.$nom_categorie.')</b>');
                $insertn1->bindValue(':date', FullDate('full'));
            $insertn1->execute(); 
            $insertn2 = $bdd->prepare("INSERT INTO gabcms_forum_categorie (nom, create_par, date, couleur) VALUES (:nom, :user, :date, :color)");
                $insertn2->bindValue(':nom', $nom_categorie);
                $insertn2->bindValue(':user', $user['username']);
                $insertn2->bindValue(':date', time());
                $insertn2->bindValue(':color', $couleur);
            $insertn2->execute();
            echo '<h4 class="alert_success">La catégorie a été enregistrée</h4>';
            } else {
            echo '<h4 class="alert_error">Une erreur est survenue</h4>';
            }
        }
    }
}
if(isset($_GET['sup'])) {
$sup = Secu($_GET['sup']);
    $sql_modif = $bdd->query("SELECT * FROM gabcms_forum_categorie WHERE id = '".$sup."'");
    $modif_e = $sql_modif->fetch();
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a supprimé une catégorie de forum <b>('.addslashes($modif_e['nom']).')</b>');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
        $bdd->query("DELETE FROM gabcms_forum_categorie WHERE id = '".$sup."'");
echo '<h4 class="alert_success">La catégorie a bien été supprimée</h4>';
}
if(isset($_GET['modifierrecrut'])) {
    $modifierrecrut = Secu($_GET['modifierrecrut']);
		if(isset($_POST['nom_modif'])) {
			$nom_modif = addslashes($_POST['nom_modif']);
			$couleur_modif = addslashes($_POST['couleur_modif']);
					$sql_modif = $bdd->query("SELECT * FROM gabcms_forum_categorie WHERE id = '".$modifierrecrut."'");
					$modif_a = $sql_modif->fetch();
		if($nom_modif != "" && $couleur_modif != "") {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a modifié la catégorie de forum <b>'.addslashes($modif_a['nom']).'</b> en <b>'.$nom_modif.'</b>');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
        $bdd->query("UPDATE gabcms_forum_categorie SET nom = '".$nom_modif."', couleur = '".$couleur_modif."' WHERE id = '".$modifierrecrut."'");
	  echo '<h4 class="alert_success">La modification a bien eu lieu</h4>';
	  } else {
	  echo '<h4 class="alert_error">Une erreur est survenue</h4>';
	  }
  } 
}
?>
<link rel="stylesheet" href="css/contenu.css" type="text/css" media="screen" /><body></body>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<?php if(!isset($_GET['modif'])) { ?>
<span id="titre">Créer une catégorie</span><br/>
Ajoutes une catégorie pour le forum.<br/><br/>
<form name='editor' method='post' action="?do=create">
<td width='100' class='tbl'><b>Nom de la catégorie :</b><br/></td>
<td width='80%' class='tbl'><input type="text" name="nom_categorie" value="<?php  if (!empty($_POST["nom_categorie"])) {  echo htmlspecialchars($_POST["nom_categorie"],ENT_QUOTES);  } ?>" class="text" style="width: 360px" /><br/></td>
<td width='100' class='tbl'><b>Couleur de la catégorie :</b><br/></td>
<td width='80%' class='tbl'><select name="couleur" style="width:150px;">
<option value="black" style="background-color:#000000; color:#FFFFFF;">Noir</option>
<option value="gray" style="background-color:#333">Gris</option>
<option value="settings" style="background-color:#595959">Gris clair</option>
<option value="hcred" style="background-color:#676767">Gris très clair</option>
<option value="promogray" style="background-color:#9c350f">Marron foncé</option>
<option value="brown" style="background-color:#a67a3e">Marron</option>
<option value="lightbrown" style="background-color:#cf9c44">Marron clair</option>
<option value="red" style="background-color:#d64242">Rouge</option>
<option value="darkred" style="background-color:#c73c3c">Rouge foncé</option>
<option value="blue" style="background-color:#2767a7">Bleu</option>
<option value="activehomes" style="background-color:#51a5d5">Bleu clair</option>
<option value="orange" style="background-color:#f66200">Orange</option>
<option value="green" style="background-color:#4ab501">Vert</option>
<option value="yellow" style="background-color:#C1B31C">Jaune</option>
<option value="white" style="background-color:#ffffff">Blanc</option>
</select>
</td>
	<br/><br/><input type="submit" value="Ajouter" /></form><hr/>
<span id="titre">Action sur une catégorie</span><br/>
Modifies ou supprimes une catégorie du forum.<br/><br/>
<table>
    <tbody>
        <tr class="haut">
            <td class="haut">Nom de la catégorie</td>
            <td class="haut">Créé par</td>
            <td class="haut">Créé le</td>
            <td class="haut">Actions</td>
        </tr>
<?PHP
 $sql = $bdd->query("SELECT * FROM gabcms_forum_categorie ORDER BY id ASC");
 while($a = $sql->fetch()) {
     $vraie_date = date('d/m/Y à H:i', $a['date']);
?>
        <tr class="bas">
            <td class="bas"><?PHP echo $a['nom']; ?></td>
            <td class="bas"><?PHP echo $a['create_par']; ?></td>
            <td class="bas"><?PHP echo $vraie_date; ?></td>
            <td class="bas"><a href="?modif=<?PHP echo $a['id']; ?>">Modifier</a> - <a href="?sup=<?PHP echo $a['id']; ?>" onclick="return confirm('Es-tu certain de supprimer cette catégorie ? Si oui, toutes les sous catégories de cette catégorie n'auront aucune affectation.')">Supprimer</a></td>
        </tr>
<?PHP } ?>
    </tbody>
</table>
<?PHP } if(isset($_GET['modif'])) {
$sql_modif = $bdd->query("SELECT * FROM gabcms_forum_categorie WHERE id = '".$modif."'");
$modif_a = $sql_modif->fetch();
?>
<p><span id="titre">Modifies une catégorie du forum</span><br/>
Tu peux modifier dans cette page le nom d'une catégorie du forum<br/><br/>
<form name='editor' method='post' action="?modifierrecrut=<?php echo $modif; ?>">
<td width='100' class='tbl'><b>Nom de la catégorie :</b><br/></td>
<td width='80%' class='tbl'><input type="text" name="nom_modif" value="<?php echo $modif_a['nom'] ?>" class="text" style="width: 360px" /><br/></td>
<td width='100' class='tbl'><b>Couleur de la catégorie :</b><br/></td>
<td width='80%' class='tbl'><select name="couleur_modif">
<option value="black" <?php if (isset($modif_a['couleur']) && $modif_a['couleur']=="black") echo 'selected="selected"';?> style="background-color:#000000; color:#FFFFFF;">Noir</option>
<option value="gray" <?php if (isset($modif_a['couleur']) && $modif_a['couleur']=="gray") echo 'selected="selected"';?> style="background-color:#333">Gris</option>
<option value="settings" <?php if (isset($modif_a['couleur']) && $modif_a['couleur']=="settings") echo 'selected="selected"';?> style="background-color:#595959">Gris clair</option>
<option value="hcred" <?php if (isset($modif_a['couleur']) && $modif_a['couleur']=="hcred") echo 'selected="selected"';?> style="background-color:#676767">Gris très clair</option>
<option value="promogray" <?php if (isset($modif_a['couleur']) && $modif_a['couleur']=="promogray") echo 'selected="selected"';?> style="background-color:#9c350f">Marron foncé</option>
<option value="brown" <?php if (isset($modif_a['couleur']) && $modif_a['couleur']=="brown") echo 'selected="selected"';?> style="background-color:#a67a3e">Marron</option>
<option value="lightbrown" <?php if (isset($modif_a['couleur']) && $modif_a['couleur']=="lightbrown") echo 'selected="selected"';?> style="background-color:#cf9c44">Marron clair</option>
<option value="red" <?php if (isset($modif_a['couleur']) && $modif_a['couleur']=="red") echo 'selected="selected"';?> style="background-color:#d64242">Rouge</option>
<option value="darkred" <?php if (isset($modif_a['couleur']) && $modif_a['couleur']=="darkred") echo 'selected="selected"';?> style="background-color:#c73c3c">Rouge foncé</option>
<option value="blue" <?php if (isset($modif_a['couleur']) && $modif_a['couleur']=="blue") echo 'selected="selected"';?> style="background-color:#2767a7">Bleu</option>
<option value="activehomes" <?php if (isset($modif_a['couleur']) && $modif_a['couleur']=="activehomes") echo 'selected="selected"';?> style="background-color:#51a5d5">Bleu clair</option>
<option value="orange" <?php if (isset($modif_a['couleur']) && $modif_a['couleur']=="orange") echo 'selected="selected"';?> style="background-color:#f66200">Orange</option>
<option value="green" <?php if (isset($modif_a['couleur']) && $modif_a['couleur']=="green") echo 'selected="selected"';?> style="background-color:#4ab501">Vert</option>
<option value="yellow" <?php if (isset($modif_a['couleur']) && $modif_a['couleur']=="yellow") echo 'selected="selected"';?> style="background-color:#C1B31C">Jaune</option>
<option value="white" <?php if (isset($modif_a['couleur']) && $modif_a['couleur']=="white") echo 'selected="selected"';?> style="background-color:#ffffff">Blanc</option>
</select>
</td>
	<br/><input type="submit" value="Modifier" /></form><br/>

</form>
<?php
}
?>
	
	</body>

</html>