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
if(isset($_GET['deplace'])) { $deplace = Secu($_GET['deplace']); }


if(isset($_GET['do'])) {
$do = Secu($_GET['do']);
    if($do == "create") {
		$nom = addslashes($_POST['nom']);
		$description = addslashes($_POST['description']);
		$staff = addslashes($_POST['staff']);
		$categorie = addslashes($_POST['categorie']);
			if($nom != "" && $description != "" && $staff != "" && $categorie != "") {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a créé une sous catégorie pour le forum <b>('.$nom.')</b>');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
        $insertn2 = $bdd->prepare("INSERT INTO gabcms_forum_sous_categorie (categorie_id, nom, description, staff, create_par, date) VALUES (:id, :nom, :desc, :staff, :par, :date)");
            $insertn2->bindValue(':id', $categorie);
            $insertn2->bindValue(':nom', $nom);
            $insertn2->bindValue(':desc', $description);
            $insertn2->bindValue(':staff', $staff);
            $insertn2->bindValue(':par', $user['username']);
            $insertn2->bindValue(':date', time());
        $insertn2->execute();
		echo '<h4 class="alert_success">La sous catégorie a bien été enregistré</h4>';
		} else {
		echo '<h4 class="alert_error">Une erreur est survenue</h4>';
		}
	}
}
if(isset($_GET['sup'])) {
    $sup = Secu($_GET['sup']);
    $sql_moder = $bdd->query("SELECT * FROM gabcms_forum_sous_categorie WHERE id = '".$sup."'");
    $moder_e = $sql_moder->fetch();
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a supprimé la sous catégorie <b>'.addslashes($moder_e['nom']).'</b> du forum');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
        $bdd->query("DELETE FROM gabcms_forum_sous_categorie WHERE id = '".$sup."'");
        $bdd->query("DELETE FROM gabcms_forum_topic WHERE categorie_forum = '".$sup."'");
echo '<h4 class="alert_success">La sous catégorie a bien été supprimée</h4>';
}
if(isset($_GET['modifierrecrut'])) {
$modifierrecrut = Secu($_GET['modifierrecrut']);
        $nom_modif = addslashes($_POST['nom_modif']);
        $description_modif = addslashes($_POST['description_modif']);
        $staff_modif = addslashes($_POST['staff_modif']);
                $sql_modif = $bdd->query("SELECT * FROM gabcms_forum_sous_categorie WHERE id = '".$modifierrecrut."'");
                $modif_a = $sql_modif->fetch();
    if($description_modif != "" && $nom_modif != "" && $staff_modif != "") {
    $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
        $insertn1->bindValue(':pseudo', $user['username']);
        $insertn1->bindValue(':action', 'a modifié la sous catégorie <b>'.addslashes($modif_a['nom']).'</b> en <b>'.$nom_modif.'</b>');
        $insertn1->bindValue(':date', FullDate('full'));
    $insertn1->execute(); 
    $bdd->query("UPDATE gabcms_forum_sous_categorie SET nom = '".$nom_modif."', description = '".$description_modif."', staff = '".$staff_modif."' WHERE id = '".$modifierrecrut."'");
  echo '<h4 class="alert_success">La modification a bien eu lieu</h4>';
  } else {
  echo '<h4 class="alert_error">Une erreur est survenue</h4>';
  }
}
if(isset($_GET['deplacement'])) {
$deplacement = Secu($_GET['deplacement']);
        $new_categorie = $_POST['new_categorie'];
            $sql_deplace = $bdd->query("SELECT * FROM gabcms_forum_sous_categorie WHERE id = '".$deplacement."'");
            $deplace_a = $sql_deplace->fetch();
            $sql_deplacez = $bdd->query("SELECT * FROM gabcms_forum_categorie WHERE id = '".$deplace_a['categorie_id']."'");
            $deplace_b = $sql_deplacez->fetch();
                    $sql = $bdd->query("SELECT * FROM gabcms_forum_categorie WHERE id = '".$new_categorie."'");
                    $assoc = $sql->fetch(PDO::FETCH_ASSOC);
    if($new_categorie != "") {
    $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
        $insertn1->bindValue(':pseudo', $user['username']);
        $insertn1->bindValue(':action', 'a déplacé la sous catégorie <b>'.addslashes($deplace_a['nom']).'</b> de la catégorie <b>'.addslashes($deplace_b['nom']).'</b> à <b>'.$assoc['nom'].'</b>');
        $insertn1->bindValue(':date', FullDate('full'));
    $insertn1->execute(); 
    $bdd->query("UPDATE gabcms_forum_sous_categorie SET categorie_id = '".$new_categorie."' WHERE id = '".$deplacement."'");
    echo '<h4 class="alert_success">La modification a bien eu lieu</h4>';
    } else {
    echo '<h4 class="alert_error">Une erreur est survenue</h4>';
    }
}
?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?'.mt_rand(); ?>" type="text/css" media="screen" /><body>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<?php if(!isset($_GET['modif']) && !isset($_GET['deplace'])) { ?>
<span id="titre">Créer des sous-catégories</span><br/>
Ajoutes des sous-catégories pour le forum.
<br/><br
<form name='editor' method='post' action="?do=create">
<td width='100' class='tbl'><b>Nom :</b><br/></td>
<td width='80%' class='tbl'><input type="text" name="nom" value="<?php  if (!empty($_POST["nom"])) {  echo htmlspecialchars($_POST["nom"],ENT_QUOTES);  } ?>" class="text" style="width: 360px" /><br/></td>
<td width='100' class='tbl'><b>Description :</b><br/></td>
<td width='80%' class='tbl'><textarea name="description" rows="3" cols="75" id="editor1"><?php
 if (isset($_POST["description"])) {
 echo htmlspecialchars($_POST["description"],ENT_QUOTES);
 }
?></textarea></td><br/>
<td width='100' class='tbl'><b>Catégorie :</b><br/></td>
<select name="categorie" id="pays">
<?PHP
$sql_b = $bdd->query("SELECT * FROM gabcms_forum_categorie ORDER BY id ASC");
while($b = $sql_b->fetch()) {
?>
			<option value="<?PHP echo $b['id'] ?>"><?PHP echo $b['nom'] ?></option>
<?PHP } ?>			
</select><br/>
<td width='100' class='tbl'><b>Qui peut poster des topics ?</b><br/></td>
<label><input type="radio" name="staff" value="0" <?php if (isset($_POST['staff']) && $_POST['staff']=="0") echo 'checked="checked"';?> />Tout le monde peut poster un topic</label> 
<label><input type="radio" name="staff" value="1" <?php if (isset($_POST['staff']) && $_POST['staff']=="1") echo 'checked="checked"';?> />Seulement les staffs peuvent poster un topic</label> 
<br/><br/>
<input type="submit" value="Ajouter" /></form><hr/>
<span id="titre">Action sur des sous catégories</span><br/>
Modifies, déplaces, supprimes des sous catégories du forum.
<br/><br/>
<table>
    <tbody>
        <tr class="haut">
            <td class="haut">Nom de la catégorie</td>
            <td class="haut">Nom</td>
            <td class="haut">Description</td>
            <td class="haut">Créé par</td>
            <td class="haut">Créé le</td>
            <td class="haut">Actions</td>
        </tr>
<?php
$sql = $bdd->query("SELECT * FROM gabcms_forum_sous_categorie ORDER BY categorie_id ASC");
while($a = $sql->fetch()) {
    $vraie_date = date('d/m/Y à H:i', $a['date']);
    $correct = $bdd->query("SELECT * FROM gabcms_forum_categorie WHERE id = '".$a['categorie_id']."'");
    $c = $correct->fetch();
?>
        <tr class="bas">
            <td class="bas"><?PHP echo stripslashes($c['nom']); ?></td>
            <td class="bas"><?PHP echo stripslashes($a['nom']); ?></td>
            <td style="padding:5px; text-align: left; vertical-align: middle;font-size:11px;"><?PHP echo nl2br(stripslashes($a['description'])); ?></td>
            <td class="bas"><?PHP echo $a['create_par']; ?></td>
            <td class="bas"><?PHP echo $vraie_date; ?></td>
            <td class="bas"><a href="?modif=<?PHP echo $a['id']; ?>">Modifier</a> - <a href="?deplace=<?PHP echo $a['id']; ?>">Déplacer</a> - <a href="?sup=<?PHP echo $a['id']; ?>" onclick="return confirm('Es-tu certain de supprimer cette sous catégorie ? Si oui, tous les topics y étant inscrit seront supprimés')">Supprimer</a></td>
        </tr>
<?PHP } ?>
    </tbody>
</table>
<?php } if(isset($_GET['modif']) && !isset($_GET['deplace'])) {
$sql_modif = $bdd->query("SELECT * FROM gabcms_forum_sous_categorie WHERE id = '".$modif."'");
$modif_a = $sql_modif->fetch();
?>
<p><span id="titre">Modifies une sous catégorie</span><br/>
Tu peux modifier dans cette page le nom, la description, la catégorie, et qui peut poster des topics dans cette sous catégorie.<br/><br/>
<form name='editor' method='post' action="?modifierrecrut=<?php echo $modif; ?>">
<td width='100' class='tbl'><b>Nom :</b><br/></td>
<td width='80%' class='tbl'><input type="text" name="nom_modif" value="<?php  if (!empty($modif_a["nom"])) {  echo htmlspecialchars($modif_a["nom"],ENT_QUOTES);  } ?>" class="text" style="width: 360px" /><br/></td>
<td width='100' class='tbl'><b>Description :</b><br/></td>
<td width='80%' class='tbl'><textarea name="description_modif" rows="3" cols="75" id="editor1"><?php
 if (isset($modif_a["description"])) {
 echo htmlspecialchars($modif_a["description"],ENT_QUOTES);
 }
?></textarea></td><br/>
<td width='100' class='tbl'><b>Qui peut poster des topics ?</b><br/></td>
<label><input type="radio" name="staff_modif" value="0" <?php if (isset($modif_a['staff']) && $modif_a['staff']=="0") echo 'checked="checked"';?> />Tout le monde peut poster un topic</label> 
<label><input type="radio" name="staff_modif" value="1" <?php if (isset($modif_a['staff']) && $modif_a['staff']=="1") echo 'checked="checked"';?> />Seulement les staffs peuvent poster un topic</label> 
<br/><br/>
<input type="submit" value="Modifier" /></form>
<?php } if(isset($_GET['deplace']) && !isset($_GET['modif'])) {
$sql_deplace = $bdd->query("SELECT * FROM gabcms_forum_sous_categorie WHERE id = '".$deplace."'");
$deplace_a = $sql_deplace->fetch();
$sql_deplacez = $bdd->query("SELECT * FROM gabcms_forum_categorie WHERE id = '".$deplace_a['categorie_id']."'");
$deplace_b = $sql_deplacez->fetch();
?>
<p><span id="titre">Deplaces une sous categorie</span><br/>
Déplaces une sous catégorie dans la catégorie de ton choix.<br/><br/>
Actuellement, la sous catégorie <b><?PHP echo $deplace_a['nom']; ?></b> se trouve dans la catégorie <b><?PHP echo $deplace_b['nom']; ?></b>.<br/><br/>
<form name='editor' method='post' action="?deplacement=<?php echo $deplace; ?>">
<td width='100' class='tbl'><b>Nouvelle catégorie :</b><br/></td>
<select name="new_categorie" id="pays">
<?PHP
$sql_b = $bdd->query("SELECT * FROM gabcms_forum_categorie WHERE id != ".$deplace_a['categorie_id']." ORDER BY id ASC");
while($b = $sql_b->fetch()) {
?>
			<option value="<?PHP echo $b['id'] ?>"><?PHP echo $b['nom'] ?></option>
<?PHP } ?>			
</select>
	<br/><br/><input type="submit" value="Déplacer" /></form>
<?PHP } ?>
</body>
</html>