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
	
if(isset($_POST['username'])) {
	if(empty($_POST['username'])) {
	$message = 'Remplie les champs vide!';
	} else {
	$username = Secu($_POST['username']);
	$sql = $bdd->query("SELECT * FROM users WHERE username = '".$username."'");
	$row = $sql->rowCount();
	$assoc = $sql->fetch(PDO::FETCH_ASSOC);
  }
  }
if(isset($_GET['sup'])) {
    $sup = Secu($_GET['sup']);
    $sql = $bdd->query("SELECT * FROM gabcms_postes WHERE id = '".$sup."'");
    $a = $sql->fetch();
    $sql2 = $bdd->query("SELECT * FROM users WHERE id = '".$a['user_id']."'");
    $row2 = $sql2->rowCount();
    $assoc2 = $sql2->fetch(PDO::FETCH_ASSOC);
    $correct = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '".$a['poste']."'");
    $c = $correct->fetch();
        if($sup != "") {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
        $insertn1->bindValue(':pseudo', $user['username']);
        if($assoc2['gender'] == 'M') { $insertn1->bindValue(':action', 'a déstitué <b>'.$assoc2['username'].'</b> de son poste de <b>'.addslashes($c['nom_M']).'</b>'); }
        elseif($assoc2['gender'] == 'F') { $insertn1->bindValue(':action', 'a déstitué <b>'.$assoc2['username'].'</b> de son poste de <b>'.addslashes($c['nom_F']).'</b>'); }
        $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute();
        $bdd->query("DELETE FROM gabcms_postes WHERE id = '".$sup."'");
        if($assoc2['gender'] == 'M') { echo '<h4 class="alert_success"><b>'.$assoc2['username'].'</b> a bien été destitué de son poste <b>('.$c['nom_M'].')</b></h4>'; }
        elseif($assoc2['gender'] == 'F') { echo '<h4 class="alert_success"><b>'.$assoc2['username'].'</b> a bien été destitué de son poste <b>('.$c['nom_F'].')</b></h4>';    }
        }
}
?><link rel="stylesheet" href="css/contenu.css" type="text/css" media="screen" /><body>
<span id="titre">Déstitue une personne de son poste</span><br/>
Déstitues un staff de son ou ses postes.<br/><br/> 
<form method="post" action="?do=recherche">
<td width='100' class='tbl'><b>Pseudo :</b></td>
<td width='80%' class='tbl'><select name="username" id="pays">
<?PHP
$sql_a = $bdd->query("SELECT * FROM users WHERE rank >= '4' ORDER BY rank DESC");
while($a = $sql_a->fetch()) {
?>
			<option value="<?PHP echo $a['username']; ?>" <?php if (isset($_POST['username']) && $_POST['username'] == $a['username']) echo 'selected="selected"';?>><?PHP echo $a['username']; ?></option>
<?PHP } ?>
	</select></td>&nbsp;&nbsp;<input type="submit" value="Rechercher" />
</form>
<table>
    <tbody>
        <tr class="haut">
            <td class="haut">Poste</td>
            <td class="haut">Attribué par</td>
            <td class="haut">Attribué le</td>
            <td class="haut">Action</td>
        </tr>
<?php
if(isset($_POST['username'])) {
$sql = $bdd->query("SELECT * FROM gabcms_postes WHERE user_id = '".$assoc['id']."'");
while($a = $sql->fetch()) {
        $correct = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '".$a['poste']."'");
        $c = $correct->fetch();
    if($assoc['gender'] == 'M') { 
    $modif_poste = "".$c['nom_M']."";
    } elseif($assoc['gender'] == 'F') {
    $modif_poste = "".$c['nom_F']."";
    }
?>
        <tr class="bas">
            <td class="bas"><?PHP echo $modif_poste; ?></td>
            <td class="bas"><?PHP echo $a['par']; ?></td>
            <td class="bas"><?PHP echo $a['date']; ?></td>
            <td class="bas"><a href="?sup=<?PHP echo $a['id']; ?>">Destitué</a></td>
        </tr>
        <?PHP } } ?>
    </tbody>
</table>
</body>
</html>