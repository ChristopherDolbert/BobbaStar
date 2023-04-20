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

if(isset($_GET['id'])) {
$id = Secu($_GET['id']);
$bdd->query("UPDATE gabcms_recrutement SET etat = '1' WHERE id = '".$id."'");
$info = $bdd->query("SELECT * FROM gabcms_recrutement_dossier WHERE id_recrut = '".$id."'");
$i = $info->fetch();
$infr = $bdd->query("SELECT * FROM gabcms_recrutement WHERE id = '".$id."'");
$r = $infr->fetch();
$date_but = date('d/m/Y', $r['date_butoire']);
    $correct = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '".$r['poste']."'");
    $c = $correct->fetch();
}
				
if(isset($_GET['do2'])) {
$do2 = Secu($_GET['do2']);
$tdo2 = $bdd->query("SELECT * FROM gabcms_recrutement_dossier WHERE id = '".$do2."'");
$t2 = $tdo2->fetch();
$sql = $bdd->query("SELECT id FROM users WHERE username = '".$t2['pseudo']."'");
$row = $sql->rowCount();
$assoc = $sql->fetch(PDO::FETCH_ASSOC);
        $bdd->query("UPDATE gabcms_recrutement_dossier SET retenu = '2', traite_par = '".$user['username']."', etat = '2' WHERE id = '".$do2."'");
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a <b>accepté</b> la candidature de <b>'.$t2['pseudo'].'</b> au poste de <b>'.addslashes($c['nom_M']).'</b>');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute();
        $insertn2 = $bdd->prepare("INSERT INTO gabcms_management (user_id, message, auteur, date, look) VALUES (:userid, :message, :auteur, :date, :look)");
            $insertn2->bindValue(':userid', $assoc['id']);
            $insertn2->bindValue(':message', 'Je viens de traité ta candidature au poste de <b>'.addslashes($c['nom_M']).'</b>, va regarder tes alertes pour savoir si tu es pris ou non en <a href="'.$url.'/alerts">cliquant ici</a> !');
            $insertn2->bindValue(':auteur', $user['username']);
            $insertn2->bindValue(':date', FullDate('full'));
            $insertn2->bindValue(':look', $user['look']);
        $insertn2->execute();
        $insertn3 = $bdd->prepare("INSERT INTO gabcms_alertes (userid, sujet, alerte, par, date, look, action) VALUES (:id, :sujet, :alerte, :par, :date, :look, :act)");
            $insertn3->bindValue(':id', $assoc['id']);
            $insertn3->bindValue(':sujet', 'Candidature - '.addslashes($c['nom_M']).'');
            $insertn3->bindValue(':alerte', 'Je t\'informe que ta candidature a été <b>acceptée</b> pour le poste de '.addslashes($c['nom_M']).', tes fonctions devraient être bientôt mises. Bienvenue dans l\'équipe !');
            $insertn3->bindValue(':par', $user['username']);
            $insertn3->bindValue(':date', FullDate('full'));
            $insertn3->bindValue(':look', $user['look']);
            $insertn3->bindValue(':act', '0');
        $insertn3->execute();
	  $bdd->query("INSERT INTO gabcms_tchat (pseudo,message,ip,date,look,rank) VALUES ('','La direction de l\'hôtel a accepté la candidature de <b>".$t2['pseudo']."</b> qui occupera le poste de <b>".addslashes($c['nom_M'])."</b> au sein de ".$sitename.".','0.0.0.0','".FullDate('full')."','hr-828-45.lg-285-64.ch-215-110.hd-180-2.sh-290-62.he-1607-','0')");
        $insertn4 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn4->bindValue(':pseudo', $t2['pseudo']);
            $insertn4->bindValue(':action', 's\'est vu attribué le poste de <b>'.addslashes($c['nom_M']).'</b> automatiquement');
            $insertn4->bindValue(':date', FullDate('full'));
        $insertn4->execute(); 
        $bdd->query("INSERT INTO gabcms_postes (user_id,poste,par,date) VALUES ('".$assoc['id']."','".$r['poste']."','".$user['username']."','".FullDate('full')."')");
        $bdd->query("INSERT INTO gabcms_tchat_staff (pseudo,message,ip,date,look,rank) VALUES ('','La direction de l\'hôtel a accepté la candidature de <b>".$t2['pseudo']."</b> qui occupera le poste de <b>".addslashes($c['nom_M'])."</b> au sein de ".$sitename.". Nous te souhaitons la bienvenue ".$t2['pseudo']." ! :D','0.0.0.0','".FullDate('full')."','hr-828-45.lg-285-64.ch-215-110.hd-180-2.sh-290-62.he-1607-','0')");
	 echo '<h4 class="alert_success">La candidature de '.$t2['pseudo'].' a été acceptée. Le poste a été attribué, manque plus qu\'a le ranker.</h4>';
}	
if(isset($_GET['do'])) {
$do = Secu($_GET['do']);
$tdo1 = $bdd->query("SELECT * FROM gabcms_recrutement_dossier WHERE id = '".$do."'");
$t1 = $tdo1->fetch();
$sqlr = $bdd->query("SELECT id FROM users WHERE username = '".$t1['pseudo']."'");
$rowr = $sqlr->rowCount();
$assocr = $sqlr->fetch(PDO::FETCH_ASSOC);
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
        $insertn3 = $bdd->prepare("INSERT INTO gabcms_alertes (userid, sujet, alerte, par, date, look, action) VALUES (:id, :sujet, :alerte, :par, :date, :look, :act)");
            $insertn3->bindValue(':id', $assocr['id']);
            $insertn3->bindValue(':sujet', 'Candidature - '.addslashes($c['nom_M']).'');
            $insertn3->bindValue(':alerte', 'Je t\'informe que ta candidature a été <b>refusée</b> pour le poste de '.addslashes($c['nom_M']).', la direction de l\'hôtel n\'est pas dans l\'obligation de justifié ce refus.');
            $insertn3->bindValue(':par', $user['username']);
            $insertn3->bindValue(':date', FullDate('full'));
            $insertn3->bindValue(':look', $user['look']);
            $insertn3->bindValue(':act', '0');
        $insertn3->execute();
	  echo '<h4 class="alert_success">La candidature de <b>'.$t1['pseudo'].'</b> a été refusée.</h4>';
	  }	

if(isset($_GET['traite'])) { 
$traite = Secu($_GET['traite']);
$refuserr = $bdd->query("SELECT * FROM gabcms_recrutement_dossier WHERE retenu = '0' AND id_recrut = '".$traite."'");
$iefuse = $bdd->query("SELECT * FROM gabcms_recrutement WHERE id = '".$traite."'");
$re = $iefuse->fetch();
    $correcet = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '".$r['poste']."'");
    $ce = $correcet->fetch();
 while($ra = $refuserr->fetch()) {
				$srl = $bdd->query("SELECT id FROM users WHERE username = '".$ra['pseudo']."'");
				$assoc = $srl->fetch(PDO::FETCH_ASSOC);
        $bdd->query("UPDATE gabcms_recrutement_dossier SET retenu = '1', traite_par = '".$user['username']."', etat = '2' WHERE id = '".$ra['id']."'");
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a <b>refusé automatiquement</b> la candidature de <b>'.$ra['pseudo'].'</b> au poste de <b>'.addslashes($ce['nom_M']).'</b>');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
        $insertn2 = $bdd->prepare("INSERT INTO gabcms_management (user_id, message, auteur, date, look) VALUES (:userid, :message, :auteur, :date, :look)");
            $insertn2->bindValue(':userid', $assoc['id']);
            $insertn2->bindValue(':message', 'Je viens de traité ta candidature au poste de <b>'.addslashes($ce['nom_M']).'</b>, va regarder tes alertes pour savoir si tu es pris ou non en <a href="'.$url.'/alerts">cliquant ici</a> !');
            $insertn2->bindValue(':auteur', $user['username']);
            $insertn2->bindValue(':date', FullDate('full'));
            $insertn2->bindValue(':look', $user['look']);
        $insertn2->execute();
        $insertn3 = $bdd->prepare("INSERT INTO gabcms_alertes (userid, sujet, alerte, par, date, look, action) VALUES (:id, :sujet, :alerte, :par, :date, :look, :act)");
            $insertn3->bindValue(':id', $assoc['id']);
            $insertn3->bindValue(':sujet', 'Candidature - '.addslashes($ce['nom_M']).'');
            $insertn3->bindValue(':alerte', 'Je t\'informe que ta candidature a été <b>refusée</b> pour le poste de '.addslashes($ce['nom_M']).', la direction de l\'hôtel n\'est pas dans l\'obligation de justifié ce refus.');
            $insertn3->bindValue(':par', $user['username']);
            $insertn3->bindValue(':date', FullDate('full'));
            $insertn3->bindValue(':look', $user['look']);
            $insertn3->bindValue(':act', '0');
        $insertn3->execute();
}
        $bdd->query("UPDATE gabcms_recrutement SET etat = '2' WHERE id = '".$id."'");
        $insertn4 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn4->bindValue(':pseudo', $user['username']);
            $insertn4->bindValue(':action', 'a clotûré la vacance de poste <b>('.addslashes($ce['nom_M']).')</b>');
            $insertn4->bindValue(':date', FullDate('full'));
        $insertn4->execute(); 
	  echo '<h4 class="alert_success">La vacance de poste au poste de <b>'.addslashes($ce['nom_M']).'</b> est cloturée.</h4>';
}	
if(isset($_GET['datep'])) {
    $datep = Secu($_GET['datep']);
    $date_ac = $r['date_butoire'];
    $date_calcul = 3 * 86400;
    $newsdate_butoire = $date_ac + $date_calcul;
	if($datep != "") {
        $bdd->query("UPDATE gabcms_recrutement SET date_butoire='".$newsdate_butoire."', etat = '0' WHERE id = '".$id."'");
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a prolongé la vacance de poste de <b>3 jours</b> ('.addslashes($c['nom_M']).')');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
        $bdd->query("INSERT INTO gabcms_tchat (pseudo,message,ip,date,look,rank) VALUES ('".$user['username']."','Je vous demanderai de bien vouloir postuler à la vacance de poste suivante : <b>".addslashes($c['nom_M'])."</b>. Je l\'ai prolongé pour des raisons de satisfactions, pas assez de candidatures.<br/> <b>Je compte sur vous ! :contrat:</b>','0.0.0.0','".FullDate('full')."','".$user['look']."','".$user['rank']."')");
	  echo '<h4 class="alert_success">La vacance de poste a été prolongée de 3 jours !</h4>';
	  }
}
?><link rel="stylesheet" href="css/contenu.css<?php echo '?'.mt_rand(); ?>" type="text/css" media="screen" /><body>
<span id="titre">Traites une vacance de poste</span><br />
Vois toutes les candidatures pour un poste.<br/><br/>
Voici les informations sur ce poste :<br/>
Poste à pourvoir : <b><?PHP echo $c['nom_M']; ?></b><br/>
Date de publication : <b><?PHP echo $r['date']; ?></b><br/>
Date butoire : <b><?PHP echo $date_but; ?></b><br/>
Nombre de postulant : <b><?php $req = "SELECT COUNT(*) AS id FROM gabcms_recrutement_dossier WHERE id_recrut = '".$id."'";
$query = $bdd->query($req);
$nb_inscrit = $query->fetch();
echo $nb_inscrit['id'];
?></b><br/>
Commentaires : <b><?PHP echo $r['comment'] ?></b><br/>
<a href="?id=<?PHP echo $r['id']; ?>&&traite=<?PHP echo $r['id']; ?>" onclick="return confirm('Es-tu certain de fermer cette session de recrutement ? Si oui, toutes les candidatures non traitées seront refusées automatiquement.')">Fermer la vacance de poste (une fois toutes les candidatures traîtées)</a><br/>
<a href="?id=<?PHP echo $r['id']; ?>&&datep=<?PHP echo $r['id']; ?>">Prolonger la vacance de poste de <b>3 jours</b></a><br/><br/>
<SCRIPT LANGUAGE="JavaScript">
function newPopup(url, name_page)
{
window.open (url, name_page, config='height=500, width=700, toolbar=no, menubar=no, scrollbars=yes, resizable=no, location=no, directories=no, status=no');
}
</SCRIPT>
<span style="color:#FF0000;">/!\ Sachez que c'est à vous de ranker les personnes acceptées ! /!\</span><br/><br/>
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
            <td class="bas"><?PHP echo $a['pseudo'] ?></center></td>
            <td class="bas"><?PHP echo $a['date'] ?></center></td>
            <td class="bas"><?PHP echo $a['age'] ?></center></td>
            <td class="bas"><div class="quotetitle"><b>CV DE <?PHP echo $a['pseudo'] ?> :</b> <input type="button" value="Afficher" style="width:50px;font-size:10px;margin:0px;padding:0px;" onclick="if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = '';        this.innerText = ''; this.value = 'Cacher'; } else { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; this.innerText = ''; this.value = 'Afficher'; }" /></div><div class="quotecontent"><div style="display: none;"><?PHP echo $a['cv'] ?></div></div></td>
            <td class="bas"><a href="#" onclick="newPopup('<?PHP echo $url ?>/managements/aff_histo_recrut?pseudo=<?PHP echo $a['pseudo'] ?>', 'Historique des candidatures');return false;">Historique</a> - <a href="?id=<?PHP echo $a['id_recrut'] ?>&&do2=<?PHP echo $a['id'] ?>">Accepté</a> - <a href="?id=<?PHP echo $a['id_recrut'] ?>&&do=<?PHP echo $a['id'] ?>">Refuser</a></center></td>
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
            <td class="bas"><?PHP echo $a['pseudo'] ?></center></td>
            <td class="bas"><?PHP echo $a['date'] ?></center></td>
            <td class="bas"><?PHP echo $a['age'] ?></center></td>
            <td class="bas"><div class="quotetitle"><b>CV DE <?PHP echo $a['pseudo'] ?> :</b> <input type="button" value="Afficher" style="width:50px;font-size:10px;margin:0px;padding:0px;" onclick="if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = '';        this.innerText = ''; this.value = 'Cacher'; } else { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; this.innerText = ''; this.value = 'Afficher'; }" /></div><div class="quotecontent"><div style="display: none;"><?PHP echo $a['cv'] ?></div></div></td>
            <td class="bas"><?PHP echo $modif_traite ?></center></td>
            <td class="bas"><?PHP echo $a['traite_par'] ?></center></td>
        </tr>
<?PHP } ?>
    </tbody>
</table>
</body>
</html>