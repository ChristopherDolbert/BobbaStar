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

if(isset($_GET['modifierrecrut'])) {
    $modifierrecrut = Secu($_GET['modifierrecrut']);
    $infr = $bdd->query("SELECT * FROM gabcms_recrutement WHERE id = '".$modifierrecrut."'");
	$r = $infr->fetch();
            $stamp_now = mktime(date('H:i:s d-m-Y'));
			$date_but = date('d/m/Y H:i', $r['date_butoire']);
	if(isset($_POST['date_butoire']) || isset($_POST['poste'])) {
   $date_butoire = Secu($_POST['date_butoire']);
		$date_ac = $r['date_butoire'];
		$date_calcul = $date_butoire * 86400;
		$newsdate_butoire = $date_ac + $date_calcul;
			$correct = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '".$r['poste']."'");
			$c = $correct->fetch();
      if($date_butoire != "") {
        $bdd->query("UPDATE gabcms_recrutement SET date_butoire='".$newsdate_butoire."' WHERE id = '".$modifierrecrut."'");
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a prolongé la vacance de poste de <b>'.$date_butoire.' jour(s)</b> ('.addslashes($c['nom_M']).')');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute();
        $insertn2 = $bdd->prepare("INSERT INTO gabcms_tchat_staff (message, ip, date, look, rank) VALUES (:message, :ip, :date, :look, :rank)");
            $insertn2->bindValue(':message', 'Une vacance de poste ('.addslashes($c['nom_M']).') a été prolongé de <b>'.$date_butoire.' jour(s)</b>');
            $insertn2->bindValue(':ip', '0.0.0.0');
            $insertn2->bindValue(':date', FullDate('full'));
            $insertn2->bindValue(':look', 'hr-828-45.lg-285-64.ch-215-110.hd-180-2.sh-290-62.he-1607-');
            $insertn2->bindValue(':rank', '0');
        $insertn2->execute();
        $insertn3 = $bdd->prepare("INSERT INTO gabcms_tchat (message, ip, date, look, rank) VALUES (:message, :ip, :date, :look, :rank)");
            $insertn3->bindValue(':message', 'Une vacance de poste ('.addslashes($c['nom_M']).') a été prolongé de <b>'.$date_butoire.' jour(s)</b>');
            $insertn3->bindValue(':ip', '0.0.0.0');
            $insertn3->bindValue(':date', FullDate('full'));
            $insertn3->bindValue(':look', 'hr-828-45.lg-285-64.ch-215-110.hd-180-2.sh-290-62.he-1607-');
            $insertn3->bindValue(':rank', '0');
        $insertn3->execute();
	  echo '<h4 class="alert_success">La vacance de poste <b>'.$c['nom_M'].'</b> a été prolongée !</h4>';
	  } else {
	  echo '<h4 class="alert_error">Une erreur s\'est produite</h4>';
	  }
  }
		}	
if(isset($_GET['do'])) {
    $do = Secu($_GET['do']);
	$infe = $bdd->query("SELECT * FROM gabcms_recrutement WHERE id = '".$do."'");
	$e = $infe->fetch();
 $refuserr = $bdd->query("SELECT * FROM gabcms_recrutement_dossier WHERE etat = '0' AND retenu = '0' AND id_recrut = '".$do."'");
			$correct = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '".$e['poste']."'");
			$c = $correct->fetch();
 while($ra = $refuserr->fetch()) {
				$srl = $bdd->query("SELECT id FROM users WHERE username = '".$ra['pseudo']."'");
				$assoc = $srl->fetch(PDO::FETCH_ASSOC);

        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $ra['pseudo']);
            $insertn1->bindValue(':action', 's\'est vu <b>refusé automatiquement</b> sa candidature au poste de <b>'.addslashes($c['nom_M']).'</b>');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
        $insertn2 = $bdd->prepare("INSERT INTO gabcms_management (user_id, message, auteur, date, look) VALUES (:userid, :message, :auteur, :date, :look)");
            $insertn2->bindValue(':userid', $assoc['id']);
            $insertn2->bindValue(':message', 'Ta candidature au poste de <b>'.addslashes($c['nom_M']).'</b> a été traitée automatiquement, va regarder tes alertes en <a href="'.$url.'/alerts">cliquant ici</a> pour plus d\'infos !');
            $insertn2->bindValue(':auteur', 'Système');
            $insertn2->bindValue(':date', FullDate('full'));
            $insertn2->bindValue(':look', 'hr-828-45.lg-285-64.ch-215-110.hd-180-2.sh-290-62.he-1607-');
        $insertn2->execute();
        $insertn3 = $bdd->prepare("INSERT INTO gabcms_alertes (userid, sujet, alerte, par, date, look, action) VALUES (:userid, :sujet, :message, :pseudo, :date, :look, :act)");
            $insertn3->bindValue(':userid', $assoc['id']);
            $insertn3->bindValue(':sujet', 'Candidature - '.addslashes($c['nom_M']).'');
            $insertn3->bindValue(':message', 'Je t\'informe que la session de <b>recrutement a été annulée</b>, donc ta candidature a été automatiquement <b>refusée</b> pour le poste de '.addslashes($c['nom_M']).'. Désolé..');
            $insertn3->bindValue(':pseudo', 'Système');
            $insertn3->bindValue(':date', FullDate('full'));
            $insertn3->bindValue(':look', 'hr-828-45.lg-285-64.ch-215-110.hd-180-2.sh-290-62.he-1607-');
            $insertn3->bindValue(':act', '0');
        $insertn3->execute();
}
        $bdd->query("UPDATE gabcms_recrutement_dossier SET retenu = '1', traite_par = '".$user['username']."', etat = '2' WHERE id_recrut = '".$do."'");
        $insertn4 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn4->bindValue(':pseudo', $user['username']);
            $insertn4->bindValue(':action', 'a annulé une vacance de poste <b>('.addslashes($c['nom_M']).')</b>');
            $insertn4->bindValue(':date', FullDate('full'));
        $insertn4->execute();
        $bdd->query("DELETE FROM gabcms_recrutement WHERE id = '".$do."'");
        $insertn5 = $bdd->prepare("INSERT INTO gabcms_tchat (message, ip, date, look, rank) VALUES (:message, :ip, :date, :look, :rank)");
            $insertn5->bindValue(':message', 'La vacance de poste <b>('.addslashes($c['nom_M']).')</b> a été annulée par la direction de l\'hôtel, donc toutes vos candidatures ne seront pas regardées.');
            $insertn5->bindValue(':ip', '0.0.0.0');
            $insertn5->bindValue(':date', FullDate('full'));
            $insertn5->bindValue(':look', 'hr-828-45.lg-285-64.ch-215-110.hd-180-2.sh-290-62.he-1607-');
            $insertn5->bindValue(':rank', '0');
        $insertn5->execute();
	echo '<h4 class="alert_success">La vacance de poste <b>'.addslashes($c['nom_M']).'</b> a bien été annulée.</h4>';
	}
?><link rel="stylesheet" href="css/contenu.css<?php echo '?'.mt_rand(); ?>" type="text/css" media="screen" /><body>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<?php if(!isset($_GET['modif'])) { ?>

<span id="titre">Actions sur les sessions de recrutements</span><br/>
Choisis la vacance de poste que tu désires prolonger ou annuler.
<div class="content">
<br/><br/>
<table>
    <tbody>
        <tr class="haut">
            <td class="haut">Poste</td>
            <td class="haut">Date de publication</td>
            <td class="haut">Date butoire</td>
            <td class="haut">Nombre de candidature<br/>actuellement</td>
            <td class="haut">Commentaire</td>
            <td class="haut">Ouvert par</td>
            <td class="haut">Actions</td>
        </tr>
<?php
 $sql = $bdd->query("SELECT * FROM gabcms_recrutement WHERE date_butoire >= ".$nowtime." AND etat = 0 ORDER BY date_butoire ASC");
 while($a = $sql->fetch()) {
    $date_but = date('d/m/Y', $a['date_butoire']);
        $req = "SELECT COUNT(*) AS id FROM gabcms_recrutement_dossier WHERE id_recrut = '".$a['id']."' AND retenu = '0'";
        $query = $bdd->query($req);
        $nb_inscrit = $query->fetch();
    $correct = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '".$a['poste']."'");
    $c = $correct->fetch();
?>
        <tr class="bas">
            <td class="bas"><?PHP echo $c['nom_M']; ?></td> 
            <td class="bas"><?PHP echo $a['date']; ?></td> 
            <td class="bas"><?PHP echo $date_but; ?></td>
            <td class="bas"><?PHP echo $nb_inscrit['id']; ?></td>
            <td class="bas"><?PHP echo $a['comment']; ?></td>
            <td class="bas"><?PHP echo $a['ouvertpar']; ?></td>
            <td class="bas"><a href="?modif=<?PHP echo $a['id']; ?>">Prolonger</a> - <a href="<?PHP echo $url; ?>/managements/dossiers_recrut?id=<?PHP echo $a['id']; ?>">Regarder</a> - <a href="?do=<?PHP echo $a['id']; ?>" onclick="return confirm('Êtes-vous certain de supprimer cette session de recrutement ?')">Annuler</a></td>
        </tr>
<?PHP } ?>
    </tbody>
</table>
</div>
<?PHP } if(isset($_GET['modif'])) {
$sql_modif = $bdd->query("SELECT * FROM gabcms_recrutement WHERE id = '".$modif."'");
$modif_a = $sql_modif->fetch();
			$date_but = date('d/m/Y', $modif_a['date_butoire']);
?>
 <span id="titre">Prolonges une vacance de poste</span><br/>
 Prolonges la vacance de poste de 1 journée à 2 semaine.<br/><br/>
<form name='editor' method='post' action="?modifierrecrut=<?php echo $modif; ?>">
Poste : <b><?PHP echo $modif_a['poste']; ?></b><br/>
Date de publication : <b><?PHP echo $modif_a['date']; ?></b><br/>
Date butoire : <b><?PHP echo $date_but; ?></b><br/>
Nombre de postulant : <b><?php $req = "SELECT COUNT(*) AS id FROM gabcms_recrutement_dossier WHERE id_recrut = '".$modif."'";
$query = $bdd->query($req);
$nb_inscrit = $query->fetch();
echo $nb_inscrit['id'];
?></b><br/>
Commentaires : <b><?PHP echo $modif_a['comment'] ?></b><br/>
<br/><td width='100' class='tbl'><b>Prolongé de :</b><br/></td>
<td width='80%' class='tbl'><select name="date_butoire" id="lenght" class="select"><option value="1">1 jour</option><option value="2">2 jours</option><option value="3">3 jours</option><option value="5">5 jours</option><option value="7">1 semaine</option><option value="14">2 semaines</option></select>
<br/>
<input type='submit' name='submit' value='Modifier'>
</div>
</form>
<?PHP } ?>
</body>
</html>