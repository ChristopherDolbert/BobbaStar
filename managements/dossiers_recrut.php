<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");

if(!isset($_SESSION['username']))
	{
		Redirect("".$url."/index.php");
		exit();
	}
	
	if($user['rank'] < 8) {
	Redirect("".$url."/managements/acces_neg.php");
	exit();
	}
	if($user['rank'] > 8) {              
	Redirect("".$url."/managements/acces_neg.php");
	exit();
	}	

if(isset($_GET['id'])) {
$id = Secu($_GET['id']);
$info = $bdd->query("SELECT * FROM gabcms_recrutement_dossier WHERE id_recrut = '".$id."'");
$i = $info->fetch();
$infr = $bdd->query("SELECT * FROM gabcms_recrutement WHERE id = '".$id."'");
$r = $infr->fetch();
$date_but = date('d/m/Y', $r['date_butoire']);
    $correct = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '".$r['poste']."'");
    $c = $correct->fetch();
}

if(isset($_GET['do'])) {
$do = Secu($_GET['do']);
$tdo1 = $bdd->query("SELECT * FROM gabcms_recrutement_dossier WHERE id = '".$do."'");
$t1 = $tdo1->fetch();
	$sqlr = $bdd->query("SELECT id FROM users WHERE username = '".$t1['pseudo']."'");
	$rowr = $sqlr->rowCount();
	$assocr = $sqlr->fetch(PDO::FETCH_ASSOC);	
	if($do != "") {
        $bdd->query("UPDATE gabcms_recrutement_dossier SET retenu = '1', traite_par = '".$user['username']."', etat = '2' WHERE id = '".$do."'");
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a <b>refusé</b> la candidature de <b>'.$t1['pseudo'].'</b> au poste de <b>'.addslashes($c['nom_M']).'</b>');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute();
        $insertn2 = $bdd->prepare("INSERT INTO gabcms_management (user_id, message, auteur, date, look) VALUES (:userid, :message, :auteur, :date, :look)");
            $insertn2->bindValue(':userid', $assocr['id']);
            $insertn2->bindValue(':message', 'Je viens de traité ta candidature au poste de <b>'.addslashes($c['nom_M']).'</b>, va regarder tes alertes pour savoir si tu es pris ou non en <a href="'.$url.'/alerts">cliquant ici</a> !');
            $insertn2->bindValue(':auteur', $user['username']);
            $insertn2->bindValue(':date', FullDate('full'));
            $insertn2->bindValue(':look', $user['look']);
        $insertn2->execute();
        $insertn2 = $bdd->prepare("INSERT INTO gabcms_alertes (userid, sujet, alerte, par, date, look, action) VALUES (:id, :sujet, :alerte, :par, :date, :look, :act)");
            $insertn2->bindValue(':id', $assocr['id']);
            $insertn2->bindValue(':sujet', 'Candidature - '.addslashes($c['nom_M']).'');
            $insertn2->bindValue(':alerte', 'Je t\'informe que ta candidature a été <b>refusée</b> pour le poste de '.addslashes($c['nom_M']).', la direction de l\'hôtel n\'est pas dans l\'obligation de justifié ce refus.');
            $insertn2->bindValue(':par', $user['username']);
            $insertn2->bindValue(':date', FullDate('full'));
            $insertn2->bindValue(':look', $user['look']);
            $insertn2->bindValue(':act', '0');
        $insertn2->execute();
	  echo '<h4 class="alert_success">La candidature de <b>'.$t1['pseudo'].'</b> a été refusée.</h4>';
	  }	
}
?><link rel="stylesheet" href="css/contenu.css" type="text/css" media="screen" /><body>
<span id="titre">Refuses une candidature</span><br />
Vois ou refuses une candidature. Pour accepté une candidature tu devras attendre la fin de la session de recrutement (date butoire)<br/><br/>
<b>Voici les informations sur ce poste :</b><br/>
Poste à pourvoir : <b><?PHP echo $c['nom_M']; ?></b><br/>
Date de publication : <b><?PHP echo $r['date']; ?></b><br/>
Date butoire : <b><?PHP echo $date_but; ?></b><br/>
Nombre de postulant : <b><?php $req = "SELECT COUNT(*) AS id FROM gabcms_recrutement_dossier WHERE id_recrut = '".$id."'";
$query = $bdd->query($req);
$nb_inscrit = $query->fetch();
echo $nb_inscrit['id'];
?></b><br/>
<SCRIPT LANGUAGE="JavaScript">
function newPopup(url, name_page)
{
window.open (url, name_page, config='height=500, width=700, toolbar=no, menubar=no, scrollbars=yes, resizable=no, location=no, directories=no, status=no');
}
</SCRIPT>
Commentaires : <b><?PHP echo $r['comment'] ?></b><br/><br/>
<table>
    <tbody>
        <tr class="haut">
            <td class="haut">Pseudo</td>
            <td class="haut">Date</td>
            <td class="haut">Age</td>
            <td class="haut">CV</td>
            <td class="haut">Action</td>
        </tr>
<?php
$sql = $bdd->query("SELECT * FROM gabcms_recrutement_dossier WHERE id_recrut = '".$id."' && retenu = '0' ORDER BY id DESC");
while($a = $sql->fetch()) {
?>
        <tr class="bas">
            <td class="bas"><?PHP echo $a['pseudo'] ?></td>
            <td class="bas"><?PHP echo $a['date'] ?></td>
            <td class="bas"><?PHP echo $a['age'] ?></td>
            <td class="bas"><div class="quotetitle"><b>CV DE <?PHP echo $a['pseudo'] ?> :</b> <input type="button" value="Afficher" style="width:50px;font-size:10px;margin:0px;padding:0px;" onclick="if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = '';        this.innerText = ''; this.value = 'Cacher'; } else { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; this.innerText = ''; this.value = 'Afficher'; }" /></div><div class="quotecontent"><div style="display: none;"><?PHP echo $a['cv'] ?></div></div></td>
            <td class="bas"><a href="#" onclick="newPopup('<?PHP echo $url ?>/managements/aff_histo_recrut.php?pseudo=<?PHP echo $a['pseudo'] ?>', 'Historique des candidatures');return false;">Historique</a> - <a href="?id=<?PHP echo $a['id_recrut'] ?>&&do=<?PHP echo $a['id'] ?>">Refuser</a></td>
        </tr>
<?PHP } ?>
    </tbody>
</table>
<hr>
Candidatures traitées : <br/>
<table>
    <tbody>
        <tr class="haut">
            <td class="haut">Pseudo</td>
            <td class="haut">Date</td>
            <td class="haut">Age</td>
            <td class="haut">CV</td>
            <td class="haut">Retenu</td>
            <td class="haut">Traité par</td>
        </tr>
<?php
$sql = $bdd->query("SELECT * FROM gabcms_recrutement_dossier WHERE id_recrut = '".$id."' && retenu != '0' ORDER BY id DESC");
while($a = $sql->fetch()) {
if($a['retenu'] == 2) {
$modif_traite = "<span style=\"color:#008000;\">Accepté</span>";
}
if($a['retenu'] == 1) {
$modif_traite = "<span style=\"color:#FF0000;\">Refusé</span>";
}
?>
        <tr class="bas">
            <td class="bas"><?PHP echo $a['pseudo'] ?></td>
            <td class="bas"><?PHP echo $a['date'] ?></td>
            <td class="bas"><?PHP echo $a['age'] ?></td>
            <td class="bas"><div class="quotetitle"><b>CV DE <?PHP echo $a['pseudo'] ?> :</b> <input type="button" value="Afficher" style="width:50px;font-size:10px;margin:0px;padding:0px;" onclick="if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = '';        this.innerText = ''; this.value = 'Cacher'; } else { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; this.innerText = ''; this.value = 'Afficher'; }" /></div><div class="quotecontent"><div style="display: none;"><?PHP echo $a['cv'] ?></div></div></td>
            <td class="bas"><?PHP echo $modif_traite ?></td>
            <td class="bas"><?PHP echo $a['traite_par'] ?></td>
        </tr>
<?PHP } ?>
    </tbody>
</table>
</body>
</html>