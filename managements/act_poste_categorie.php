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

if(isset($_GET['do'])) {
$do = Secu($_GET['do']);
    if ($do == "create") {
        if(isset($_POST['nom_categorie'])) {
            $nom_categorie = addslashes($_POST['nom_categorie']);
                if($nom_categorie != "") {
            $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
                $insertn1->bindValue(':pseudo', $user['username']);
                $insertn1->bindValue(':action', 'a créé une catégorie de postes <b>('.$nom_categorie.')</b>');
                $insertn1->bindValue(':date', FullDate('full'));
            $insertn1->execute(); 
            $insertn2 = $bdd->prepare("INSERT INTO gabcms_postes_categorie (nom, par, le) VALUES (:nom, :par, :le)");
                $insertn2->bindValue(':nom', $nom_categorie);
                $insertn2->bindValue(':par', $user['username']);
                $insertn2->bindValue(':le', FullDate('full'));
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
    $sql_modif = $bdd->query("SELECT * FROM gabcms_postes_categorie WHERE id = '".$sup."'");
    $modif_e = $sql_modif->fetch();
 $deplacer = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id_categorie = '".$sup."'");
 while($d = $deplacer->fetch()) {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a déplacé automatiquement un poste <b>('.addslashes($d['nom_M']).')</b> dans la catégorie <b>Sans catégorie</b>');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
}
        $bdd->query("UPDATE gabcms_postes_noms SET id_categorie = '0' WHERE id_categorie = '".$sup."'");
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a supprimé une catégorie de postes <b>('.addslashes($modif_e['nom']).')</b>');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
        $bdd->query("DELETE FROM gabcms_postes_categorie WHERE id = '".$sup."'");
echo '<h4 class="alert_success">La catégorie a bien été supprimée</h4>';
}
if(isset($_GET['modifierrecrut'])) {
$modifierrecrut = Secu($_GET['modifierrecrut']);
    if(isset($_POST['nom_modif'])) {
    $nom_modif = addslashes($_POST['nom_modif']);
    $sql_modif = $bdd->query("SELECT * FROM gabcms_postes_categorie WHERE id = '".$modifierrecrut."'");
    $modif_a = $sql_modif->fetch();
		if($nom_modif != "") {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a modifié la catégorie de postes <b>'.addslashes($modif_a['nom']).'</b> en <b>'.$nom_modif.'</b>');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
        $bdd->query("UPDATE gabcms_postes_categorie SET nom = '".$nom_modif."' WHERE id = '".$modifierrecrut."'");
        echo '<h4 class="alert_success">La modification a bien eu lieu</h4>';
        } else {
        echo '<h4 class="alert_error">Une erreur est survenue</h4>';
        }
    } 
}
?><link rel="stylesheet" href="css/contenu.css" type="text/css" media="screen" /><body>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<?php if(!isset($_GET['modif'])) { ?>
<span id="titre">Créer une catégorie</span><br/>
Ajoutes une catégorie de postes.<br/><br/>
<form name='editor' method='post' action="?do=create">
<td width='100' class='tbl'><b>Nom de la catégorie :</b><br/></td>
<td width='80%' class='tbl'><input type="text" name="nom_categorie" value="<?php  if (!empty($_POST["nom_categorie"])) {  echo htmlspecialchars($_POST["nom_categorie"],ENT_QUOTES);  } ?>" class="text" style="width: 360px" /><br/></td>
	<br/><input type="submit" value="Ajouter" /></form><hr/>
<span id="titre">Action sur une catégorie</span><br/>
Modifies ou supprimes une catégorie de postes.<br/><br/>
<table>
    <tbody>
        <tr class="haut">
            <td class="haut">Nom de la catégorie</td>
            <td class="haut">Créé par</td>
            <td class="haut">Créé le</td>
            <td class="haut">Actions</td>
        </tr>
<?php
 $sql = $bdd->query("SELECT * FROM gabcms_postes_categorie WHERE id != '0' ORDER BY id ASC");
 while($a = $sql->fetch()) {
?>
        <tr class="bas">
            <td class="bas"><?PHP echo Secu($a['nom']); ?></td>
            <td class="bas"><?PHP echo Secu($a['par']); ?></td>
            <td class="bas"><?PHP echo Secu($a['le']); ?></td>
            <td class="bas"><a href="?modif=<?PHP echo Secu($a['id']); ?>">Modifier</a> - <a href="?sup=<?PHP echo Secu($a['id']); ?>" onclick="return confirm('Es-tu certain de supprimer cette catégorie ? Si oui, tous les postes y étant affectés seront affectés à la catégorie : Sans catégorie.')">Supprimer</a></td>
        </tr>
<?PHP } ?>
</tbody>
</table>
<?PHP } if(isset($_GET['modif'])) {
$sql_modif = $bdd->query("SELECT * FROM gabcms_postes_categorie WHERE id = '".$modif."'");
$modif_a = $sql_modif->fetch();
?>
<p><span id="titre">Modifies une catégorie de postes</span><br/>
Tu peux modifier dans cette page le nom d'une catégorie de postes.<br/><br/>
<form name='editor' method='post' action="?modifierrecrut=<?php echo $modif; ?>">
<td width='100' class='tbl'><b>Nom de la catégorie :</b><br/></td>
<td width='80%' class='tbl'><input type="text" name="nom_modif" value="<?php echo $modif_a['nom'] ?>" class="text" style="width: 360px" /><br/></td>
	<br/><input type="submit" value="Modifier" /></form><br/>
</form>
<?php } ?>
</body>
</html>