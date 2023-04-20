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
if(isset($_GET['modif'])) { $modif = Secu($_GET['modif']); }

if(isset($_GET['do'])) {
$do = Secu($_GET['do']);
    if($do == "create") {
        if(isset($_POST['avis'])) {
            $avis = addslashes($_POST['avis']);
                if($avis != "") {
            $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
                $insertn1->bindValue(':pseudo', $user['username']);
                $insertn1->bindValue(':action', 'demande que les <b>logs des staffs soient vidés</b>');
                $insertn1->bindValue(':date', FullDate('full'));
            $insertn1->execute(); 
            $insertn2 = $bdd->prepare("INSERT INTO gabcms_stafflog_delete (date, staff1, avisstaff1, ipstaff1, etat) VALUES (:date, :staff, :avis, :ip, :etat)");
                $insertn2->bindValue(':date', $nowtime);
                $insertn2->bindValue(':staff', $user['id']);
                $insertn2->bindValue(':avis', $avis);
                $insertn2->bindValue(':ip', $user['ip_current']);
                $insertn2->bindValue(':etat', '1');
            $insertn2->execute();
            echo '<h4 class="alert_success">La demande a été enregistrée</h4>';
            } else {
            echo '<h4 class="alert_error">Une erreur est survenue</h4>';
            }
        }
    }
}
if(isset($_GET['modifierrecrut'])) {
$modifierrecrut = Secu($_GET['modifierrecrut']);
    if(isset($_POST['avis2'])) {
        $avis2 = addslashes($_POST['avis2']);
        $avisdef = Secu($_POST['avisdef']);
             $sql = $bdd->query("SELECT * FROM gabcms_stafflog_delete WHERE etat = 1 AND id = '".$modifierrecrut."'");
             $a = $sql->fetch();
                    $sql1 = $bdd->query("SELECT username FROM users WHERE id = '".$a['staff1']."'");
                    $row1 = $sql1->rowCount();
                    $assoc1 = $sql1->fetch(PDO::FETCH_ASSOC);
        if($avis2 != "" && $avisdef == "1" && $user['id'] != $a['staff1']) {
        $bdd->query("TRUNCATE TABLE gabcms_stafflog");
        $bdd->query("UPDATE gabcms_stafflog_delete SET etat = '2', staff2 = '".$user['id']."', avisstaff2 = '".$avis2."', avis = '".$avisdef."', ipstaff2 = '".$user['ip_current']."' WHERE id = '".$modifierrecrut."'");
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'en accord avec <b>'.$assoc1['username'].'</b> a vidé les <b>logs des staffs</b>');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute();
        $insertn2 = $bdd->prepare("INSERT INTO gabcms_tchat_staff (message, ip, date, look, rank) VALUES (:message, :ip, :date, :look, :rank)");
            $insertn2->bindValue(':message', 'La direction a décidé de vider les <b>logs des staffs</b>.');
            $insertn2->bindValue(':ip', '0.0.0.0');
            $insertn2->bindValue(':date', FullDate('full'));
            $insertn2->bindValue(':look', 'hr-828-45.lg-285-64.ch-215-110.hd-180-2.sh-290-62.he-1607-');
            $insertn2->bindValue(':rank', '0');
        $insertn2->execute();
        echo '<div id="ok">Les logs ont été vidés.</div>';
        } else if($avis2 != "" && $avisdef == "2" && $user['id'] != $a['staff1']) {
        $bdd->query("UPDATE gabcms_stafflog_delete SET etat = '3', staff2 = '".$user['id']."', avisstaff2 = '".$avis2."', avis = '".$avisdef."', ipstaff2 = '".$user['ip_current']."' WHERE id = '".$modifierrecrut."'");
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a refusé la demande de <b>'.$assoc1['username'].'</b> pour vider les <b>logs des staffs</b>');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
        echo '<h4 class="alert_success">Ton avis a été émis, les logs ne sont pas supprimés.</h4>';
        } else {
        echo '<h4 class="alert_error">Une erreur est survenue</h4>';
        }
    } 
}
?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?'.mt_rand(); ?>" type="text/css" media="screen" /><body>
<style>
#raison{
background-color:#cecece;
-webkit-box-shadow:0 0 20px rgba(0, 0, 0, 0.5);
box-shadow:0 1px 0 #fff, 0 2px 3px rgba(0, 0, 0, 0.5) inset;
-webkit-border-radius:5px;
-moz-border-radius:5px;
border-radius:5px;
padding:7px;
text-shadow:rgba(255, 255, 255, 0.5) 0 1px 0;
}
</style>
<SCRIPT LANGUAGE="JavaScript">
function newPopup(url, name_page)
{
window.open (url, name_page, config='height=300, width=700, toolbar=no, menubar=no, scrollbars=yes, resizable=no, location=no, directories=no, status=no');
}
</SCRIPT>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<?PHP if(!isset($_GET['modif'])) { ?>
<span id="titre">Vider le logs des staffs</span><br/>
Créer une demande pour vider le logs des staffs ou donnes ton avis pour qu'on le vide.
<div class="content">
<br/><br/>
<?PHP 
 $sql = $bdd->query("SELECT * FROM gabcms_stafflog_delete WHERE etat < 2 ORDER BY id DESC");
 $a = $sql->fetch();
 $row = $sql->rowCount();
 if($a['id'] < 1) {
?>
<form name='editor' method='post' action="?do=create">
    <td width='100' class='tbl'><b>Explique pourquoi tu voudrais vider le logs des staffs</b><br/></td>
    <td width='80%' class='tbl'><textarea name='avis' wrap=discuss rows=3 cols=34 ></textarea><br/></td><br/>
    <input type="submit" value="Envoyer" />
</form><hr/>
<table>
    <tbody>
        <tr class="haut">
            <td class="haut">Date de publication</td>
            <td class="haut">Avis staff n°1</td>
            <td class="haut">Avis staff n°2</td>
            <td class="haut">Etat</td>
            <td class="haut">Avis définitif</td>
            <td class="haut">Actions</td>
        </tr>
<?php
 $sql = $bdd->query("SELECT * FROM gabcms_stafflog_delete WHERE etat >= 2 ORDER BY id DESC");
 while($a = $sql->fetch()) {
        $sql1 = $bdd->query("SELECT username FROM users WHERE id = '".$a['staff1']."'");
        $row1 = $sql1->rowCount();
        $assoc1 = $sql1->fetch(PDO::FETCH_ASSOC);
        $sql2 = $bdd->query("SELECT username FROM users WHERE id = '".$a['staff2']."'");
        $row2 = $sql2->rowCount();
        $assoc2 = $sql2->fetch(PDO::FETCH_ASSOC);
        $date = date('d/m/Y H:i', $a['date']);
if($a['etat'] == 1) {
$etat_modif = "<span style=\"color:#0000FF;\"><b>Attente avis<br/>2ème fondateur</b></span>";
}
if($a['etat'] == 2 || $a['etat'] == 3) {
$etat_modif = "<span style=\"color:#008800;\"><b>Demande traitée</b></span>";
}
if($a['avis'] == 0) {
$avis_modif = "<span style=\"color:#0000FF;\"><b>En attente</span>";
}
if($a['avis'] == 1) {
$avis_modif = "<span style=\"color:#008800;\"><b>Accepté</span>";
}
if($a['avis'] == 2) {
$avis_modif = "<span style=\"color:#FF0000;\"><b>Refusé</b></span>";
}
?>
        <tr class="bas">
            <td class="bas"><?PHP echo $date; ?></td>
            <td class="bas"><?PHP echo $assoc1['username']; ?></td>
            <td class="bas"><?PHP echo $assoc2['username']; ?></td>
            <td class="bas"><?PHP echo $etat_modif; ?></td>
            <td class="bas"><?PHP echo $avis_modif; ?></td>
            <td class="bas"><a href="#" onclick="newPopup('<?PHP echo $url ?>/managements/aff_histo_stafflog?id=<?PHP echo $a['id'] ?>', 'Historique stafflogs');return false;">Historique</a></td>
        </tr>
<?PHP } ?>
    </tbody>
</table>
<?PHP } else { ?>
<table>
    <tbody>
        <tr class="haut">
            <td class="haut">Date de publication</td>
            <td class="haut">Avis staff n°1</td>
            <td class="haut">Avis staff n°2</td>
            <td class="haut">Etat</td>
            <td class="haut">Avis définitif</td>
            <td class="haut">Actions</td>
        </tr>
<?php
 $sql = $bdd->query("SELECT * FROM gabcms_stafflog_delete WHERE etat < 2 ORDER BY id DESC");
 while($a = $sql->fetch()) {
    $sql1 = $bdd->query("SELECT username FROM users WHERE id = '".$a['staff1']."'");
    $row1 = $sql1->rowCount();
    $assoc1 = $sql1->fetch(PDO::FETCH_ASSOC);
    $sql2 = $bdd->query("SELECT username FROM users WHERE id = '".$a['staff2']."'");
    $row2 = $sql2->rowCount();
    $assoc2 = $sql2->fetch(PDO::FETCH_ASSOC);
    $date = date('d/m/Y H:i', $a['date']);
if($a['etat'] == 1) {
$etat_modif = "<span style=\"color:#0000FF;\"><b>Attente avis<br/>2ème fondateur</b></span>";
}
if($a['etat'] == 2 || $a['etat'] == 3) {
$etat_modif = "<span style=\"color:#008800;\"><b>Demande traitée</b></span>";
}
if($a['avis'] == 0) {
$avis_modif = "<span style=\"color:#0000FF;\"><b>En attente</span>";
}
if($a['avis'] == 1) {
$avis_modif = "<span style=\"color:#008800;\"><b>Accepté</span>";
}
if($a['avis'] == 2) {
$avis_modif = "<span style=\"color:#FF0000;\"><b>Refusé</b></span>";
}
?>
        <tr class="bas">
            <td class="bas"><?PHP echo $date; ?></td>
            <td class="bas"><?PHP echo $assoc1['username']; ?></td>
            <td class="bas"><?PHP echo $assoc2['username']; ?></td>
            <td class="bas"><?PHP echo $etat_modif; ?></td>
            <td class="bas"><?PHP echo $avis_modif; ?></td>
            <td class="bas"><?PHP if($user['id'] != $a['staff1']) { ?><a href="?modif=<?PHP echo $a['id']; ?>">Donner son avis</a><?PHP } ?></td>
        </tr>
<?PHP } ?>
    </tbody>
</table>
<?php } }
if(isset($_GET['modif'])) {
$sql_modif = $bdd->query("SELECT * FROM gabcms_stafflog_delete WHERE id = '".$modif."'");
$modif_a = $sql_modif->fetch();
        $sql1 = $bdd->query("SELECT username FROM users WHERE id = '".$modif_a['staff1']."'");
        $row1 = $sql1->rowCount();
        $assoc1 = $sql1->fetch(PDO::FETCH_ASSOC);
?>
<span id="titre">Donnes ton avis</span><br/>
Donnes ton avis sur le vidage ou pas du logs des staffs<br/><br/>
A l'initiative de <b><?PHP echo $assoc1['username']; ?></b>, qui a demander à ce que les logs soient vidés, tu peux donner ton avis.<br/><br/>
Voici les raisons pour la quelle il faudrait vider le logs des staffs selon lui :<br/>
<div id="raison"><?PHP echo nl2br(stripslashes(addslashes($modif_a['avisstaff1']))); ?></div><br/>
<form name='editor' method='post' action="?modifierrecrut=<?php echo $modif; ?>">
<td width='100' class='tbl'><b>Avis au vidage :</b><br/></td>
<td width='80%' class='tbl'><select name="avisdef" id="lenght" class="select"><option value="">-- Choisis une décision --</option><option value="1">Je suis d'accord pour que le vidage est lieu</option><option value="2">Je ne suis pas d'accord</option></select><br/></td>																																			<br/>
<td width='100' class='tbl'><b>Explique pourquoi cette décision.. :</b><br/></td>
<td width='80%' class='tbl'><textarea name='avis2' wrap=discuss rows=3 cols=34 ></textarea><br/></td>
	<input type="submit" value="Envoyer mon avis" />
</form>
<?php } ?>
</div>
</body>
</html>