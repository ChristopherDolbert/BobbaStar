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

if(isset($_GET['modifiernews'])) {
$modifiernews = Secu($_GET['modifiernews']);
	if(isset($_POST['sign']) || isset($_POST['texte'])) {
   $sign = Secu($_POST['sign']);
   $bureau = Secu($_POST['bureau']);
   $applicable = Secu($_POST['applicable']);
   $texte = $_POST['texte'];
$sqle = $bdd->query("SELECT * FROM gabcms_nds WHERE id = '".$modifiernews."'");
$a = $sqle->fetch();
			$correct = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '".$applicable."'");
			$c = $correct->fetch();   
      if($texte != "") {
        $bdd->query("UPDATE gabcms_nds SET texte = '".addslashes($texte)."', sign = '".addslashes($sign)."', applicable = '".addslashes($c['nom_nds'])."', bureau = '".addslashes($bureau)."', edit = '1', date_edit = '".FullDate('hc')."' WHERE id = '".$modifiernews."'");
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a modifié une note de service <b>('.addslashes($a['objet']).')</b>');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
        $insertn3 = $bdd->prepare("INSERT INTO gabcms_tchat_staff (message, ip, date, look, rank) VALUES (:message, :ip, :date, :look, :rank)");
            $insertn3->bindValue(':message', 'La note de service <b>('.addslashes($a['objet']).')</b> a été modifiée et vos approbations effacées. <a href="'.$url.'/managements/nds?id='.$modifiernews.'\">Cliquez ici</a> pour aller voir les modifications et à nouveau l\'approuvée !');
            $insertn3->bindValue(':ip', '0.0.0.0');
            $insertn3->bindValue(':date', FullDate('full'));
            $insertn3->bindValue(':look', 'hr-828-45.lg-285-64.ch-215-110.hd-180-2.sh-290-62.he-1607-');
            $insertn3->bindValue(':rank', '0');
        $insertn3->execute();
        $bdd->query("DELETE FROM gabcms_nds_lu WHERE id_nds = '".$modifiernews."'");
	  $staff_info = $bdd->query("SELECT id FROM users WHERE rank >= '4'");
	   while($ra = $staff_info->fetch()) {
        $insertn2 = $bdd->prepare("INSERT INTO gabcms_management (user_id, message, auteur, date, look) VALUES (:userid, :message, :auteur, :date, :look)");
            $insertn2->bindValue(':userid', $ra['id']);
            $insertn2->bindValue(':message', 'La note de service <b>('.addslashes($a['objet']).')</b> a été modifiée. Quand une note de service est modifiée, il faut que tu l\'approuves à nouveau, je te demanderai donc de <a href="'.$url.'/managements/nds?id='.$modifiernews.'">cliquer ici</a> pour à nouveau la lire.');
            $insertn2->bindValue(':auteur', 'Système');
            $insertn2->bindValue(':date', FullDate('full'));
            $insertn2->bindValue(':look', 'hr-828-45.lg-285-64.ch-215-110.hd-180-2.sh-290-62.he-1607-');
        $insertn2->execute();
	}
	  echo '<h4 class="alert_success">La note de service vient d\'être modifiée.</h4>';
	  } else {
	  echo '<h4 class="alert_error">Merci de remplir les champs vide</h4>';
	  }
  }
		}	
 
if(isset($_GET['do'])) {
$do = Secu($_GET['do']);
$sqa = $bdd->query("SELECT * FROM gabcms_nds WHERE id = '".$do."'");
$d = $sqa->fetch();  
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a annulé une note de service <b>('.addslashes($d['objet']).')</b>');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
        $bdd->query("UPDATE gabcms_nds SET annuler = '1', objet = '[ANNULÉE] ".addslashes($d['objet'])."', user_annuler = '".$user['username']."', date_annuler = '".FullDate('full')."' WHERE id = '".$do."'");
        $insertn2 = $bdd->prepare("INSERT INTO gabcms_tchat_staff (message, ip, date, look, rank) VALUES (:message, :ip, :date, :look, :rank)");
            $insertn2->bindValue(':message', 'La note de service <a href="'.$url.'/managements/nds?id='.$do.'"><b>('.$d['objet'].')</b></a> a été annulée.');
            $insertn2->bindValue(':ip', '0.0.0.0');
            $insertn2->bindValue(':date', FullDate('full'));
            $insertn2->bindValue(':look', 'hr-828-45.lg-285-64.ch-215-110.hd-180-2.sh-290-62.he-1607-');
            $insertn2->bindValue(':rank', '0');
        $insertn2->execute();
	echo '<h4 class="alert_success">La note de service vient d\'être annulée.</h4>';
	}
?>
<link rel="stylesheet" href="css/contenu.css" type="text/css" media="screen" /><body></body>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script type="text/javascript" src="<?PHP echo $imagepath; ?>editor/ckeditor.js"></script>
<script type="text/javascript" src="<?PHP echo $imagepath; ?>editor/config.js"></script>
	<?php if(!isset($_GET['modif'])) { ?>
<span id="titre">Actions sur des notes de service</span><br \>
Choisis la note de service que tu désires modifier ou supprimer.
<div class="content">
<br/><br/>
<table>
    <tbody>
        <tr class="haut">
            <td class="haut">Objet</td>
            <td class="haut">Applicable aux...</td>
            <td class="haut">Écrite dans le...</td>
            <td class="haut">Créer par</td>
            <td class="haut">Date</td>
            <td class="haut">Actions</td>
        </tr>
<?php
 $sql = $bdd->query("SELECT * FROM gabcms_nds WHERE annuler != 1 ORDER BY id DESC LIMIT 0,100");
 while($a = $sql->fetch()) {
?>
        <tr class="bas">
            <td class="bas"><?PHP echo stripslashes($a['objet']) ?></td>
            <td class="bas">... <?PHP echo stripslashes($a['applicable']) ?></td>
            <td class="bas">... <?PHP echo stripslashes($a['bureau']) ?></td>
            <td class="bas"><?PHP echo $a['par'] ?></td>
            <td class="bas"><?PHP echo $a['date'] ?></td>
            <td class="bas"><?PHP if($a['par'] == $user['username'] || $user['rank'] >= '7') { ?><a href="?modif=<?PHP echo $a['id'] ?>">Modifier</a> - <a href="?do=<?PHP echo $a['id'] ?>" onclick="return confirm('Êtes-vous certain d`annuler cette note de service ?')">Annuler </a><?PHP } ?></td>
        </tr>
<?PHP } ?>
</tbody>
</table>
</div>
<?PHP }
if(isset($_GET['modif'])) {
$sql_modif = $bdd->query("SELECT * FROM gabcms_nds WHERE id = '".$modif."'");
$modif_a = $sql_modif->fetch();
?>
 <span id="titre">Modification de la NDS.</span><br/>
Modifie le corps de ta NDS, la signature et les différentes informations disponibles.<br/><br/>
<form name='editor' method='post' action="?modifiernews=<?php echo $modif; ?>">
<td width='100' class='tbl'><b>Cette note est applicable aux...</b><br/></td>
<td width='80%' class='tbl'>
	<select name="applicable" id="pays">
<?PHP
$sql_a = $bdd->query("SELECT * FROM gabcms_postes_categorie ORDER BY id ASC");
while($a = $sql_a->fetch()) {
?>
				<optgroup label="<?PHP echo $a['nom'] ?>">
<?PHP
$sql_b = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id_categorie = '".$a['id']."' ORDER BY id ASC");
while($b = $sql_b->fetch()) {
?>
			<option value="<?PHP echo $b['id'] ?>" <?php if ($modif_a['applicable'] == $b['nom_nds']) echo 'selected="selected"';?>>... <?PHP echo $b['nom_nds'] ?></option>
<?PHP } ?>
				</optgroup>
<?PHP } ?>
	</select>
</td><br/><br/>
<td width='100' class='tbl'><b>Écrite dans le bureau...</b><br/></td>
<td width='80%' class='tbl'>
	<select name="bureau" id="pays">
		<optgroup label="Général">
			<option value="Bureau des staffs" <?php if ($modif_a['bureau'] =="Bureau des staffs") echo 'selected="selected"';?> >... des staffs</option>
			<option value="Bureau des animations" <?php if ($modif_a['bureau'] =="Bureau des animations") echo 'selected="selected"';?> >... des animations</option>
			<option value="Bureau de la modération" <?php if ($modif_a['bureau'] =="Bureau de la modération") echo 'selected="selected"';?> >... de la modération</option>
			<option value="Bureau des techniciens" <?php if ($modif_a['bureau'] =="Bureau des techniciens") echo 'selected="selected"';?> >... des techniciens</option>
			<option value="Bureau des fondateurs" <?php if ($modif_a['bureau'] =="Bureau des fondateurs") echo 'selected="selected"';?> >... des fondateurs</option>
			<option value="Bureau des gérants" <?php if ($modif_a['bureau'] =="Bureau des gérants") echo 'selected="selected"';?> >... des gérants</option>
		</optgroup>
		<optgroup label="Responsables">
			<option value="Bureau des responsables" <?php if ($modif_a['bureau'] =="Bureau des responsables") echo 'selected="selected"';?> >... des responsables</option>
			<option value="Bureau des responsables modération" <?php if ($modif_a['bureau'] =="Bureau des responsables modération") echo 'selected="selected"';?> >... des responsables modération</option>
			<option value="Bureau des responsables animations" <?php if ($modif_a['bureau'] =="Bureau des responsables animations") echo 'selected="selected"';?> >... des responsables animations</option>
			<option value="Bureau des responsables marketing" <?php if ($modif_a['bureau'] =="Bureau des responsables marketing") echo 'selected="selected"';?> >... des responsables marketing</option>
			<option value="Bureau des responsables ressources humaines" <?php if ($modif_a['bureau'] =="Bureau des responsables ressources huamines") echo 'selected="selected"';?> >... des ressources humaines</option>
			<option value="Bureau du Centre de Traitement des Aides" <?php if ($modif_a['bureau'] =="Bureau du Centre de Traitement des Aides") echo 'selected="selected"';?> >... du Centre de Traitement des Aides</option>
		</optgroup>
	</select></td><br/><br/>
<td width='100' class='tbl'><b>Objet de ta NDS :</b><br/></td>
<td width='80%' class='tbl'><input type="text" name="objet" value="<?php echo nl2br($modif_a['objet']); ?>" class="text" style="width: 240px" readonly="readonly" /><br/></td>
<br/>
<td width='100' class='tbl'><b>Le corps de l'article : <a href="<?PHP echo $url; ?>/managements/upload" target="_blank">Upload tes images !</a> </b><br/></td>
<td width='80%' class='tbl'><textarea name="texte" wrap="discuss rows=12 cols=154" id="editor1"><?php echo $modif_a['texte']; ?></textarea>
<script>CKEDITOR.replace( 'editor1', { toolbar : 'Journalisme' });</script>
<br/></td>
<td width='100' class='tbl'><b>Signature :</b><br/></td>
<td width='80%' class='tbl'><input type="text" name="sign" value="<?php echo $modif_a['sign']; ?>" class="text" style="width: 240px" /><br/></td>
<br/>
<br/>
<input type='submit' name='submit' value='Modifier'>
</form>
<?php } ?>
</div>
</div>
</body>
</html>