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
	
	if($user['rank'] < 5) {
	Redirect("".$url."/managements/acces_neg");
	exit();
	}
	if($user['rank'] > 8) {              
	Redirect("".$url."/managements/acces_neg");
	exit();
	}	
	
if(isset($_GET['do'])) {
$do = Secu($_GET['do']);
$tdo1 = $bdd->query("SELECT * FROM gabcms_alertes WHERE id = '".$do."'");
$t1 = $tdo1->fetch();
$rdo1 = $bdd->query("SELECT * FROM gabcms_demande WHERE number_alert = '".$do."'");
$r1 = $rdo1->fetch();
	$zer = $bdd->query("SELECT username FROM users WHERE id = '".$t1['userid']."'");
	$row = $zer->rowCount();
	$assoc = $zer->fetch(PDO::FETCH_ASSOC);
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a validé la demande de suppression émise par <b>'.$r1['pseudo'].'</b> et a supprimé une alerte de <b>'.$assoc['username'].'</b> (ID : '.$do.')');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
        $insertn2 = $bdd->prepare("INSERT INTO gabcms_management (user_id, message, auteur, date, look) VALUES (:userid, :message, :auteur, :date, :look)");
            $insertn2->bindValue(':userid', $t1['userid']);
            $insertn2->bindValue(':message', 'Je viens de traiter la suppression d\'une de tes alertes émise par <b>'.$r1['pseudo'].'</b>. Ton alerte a été supprimé, elle ne figure plus sur le site et la base de données. (n° de l\'alerte : '.$do.')');
            $insertn2->bindValue(':auteur', $user['username']);
            $insertn2->bindValue(':date', FullDate('full'));
            $insertn2->bindValue(':look', $user['look']);
        $insertn2->execute();
        $bdd->query("DELETE FROM gabcms_alertes WHERE id = '".$do."'");
        $bdd->query("DELETE FROM gabcms_demande WHERE number_alert = '".$do."'");
	echo '<h4 class="alert_success">Une alerte a été supprimée avec succès !</h4>';
 } elseif(isset($_GET['do2'])) {
    $do2 = Secu($_GET['do2']);
$tdo2 = $bdd->query("SELECT * FROM gabcms_alertes WHERE id = '".$do2."'");
$t2 = $tdo2->fetch();
$rdo2 = $bdd->query("SELECT * FROM gabcms_demande WHERE number_alert = '".$do2."'");
$r2 = $rdo2->fetch();
	$zer2 = $bdd->query("SELECT username FROM users WHERE id = '".$t2['userid']."'");
	$row2 = $zer2->rowCount();
	$assoc2 = $zer2->fetch(PDO::FETCH_ASSOC);
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a refusé une demande de suppresion émise par <b>'.$r2['pseudo'].'</b> d\'une alerte de <b>'.$assoc2['username'].'</b> (ID : '.$do2.')');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
        $insertn2 = $bdd->prepare("INSERT INTO gabcms_management (user_id, message, auteur, date, look) VALUES (:userid, :message, :auteur, :date, :look)");
            $insertn2->bindValue(':userid', $t2['userid']);
            $insertn2->bindValue(':message', 'Je viens de traiter la suppression d\'une de tes alertes émise par <b>'.$r2['pseudo'].'</b>. La demande a été refusée, l\'alerte reste dans ton compte. (n° de l\'alerte : '.$do2.')');
            $insertn2->bindValue(':auteur', $user['username']);
            $insertn2->bindValue(':date', FullDate('full'));
            $insertn2->bindValue(':look', $user['look']);
        $insertn2->execute();
        $bdd->query("DELETE FROM gabcms_demande WHERE number_alert = '".$do2."'");     
	  echo '<h4 class="alert_success">La demande a bien été refusée.</h4>';
	  }	
?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?'.mt_rand(); ?>" type="text/css" media="screen" /><body>
<span id="titre">Supprimes une alerte</span><br/>
Supprimes une alerte sur une demande d'un(e) modérateur(trice) au minimum.<br/><br/>
<table>
    <tbody>
        <tr class="haut">
            <td class="haut">Pseudo</td>
            <td class="haut">Sujet</td>
            <td class="haut">Alerte</td>
            <td class="haut">Demandeur</td>
            <td class="haut">Action</td>
        </tr>
<?PHP
 $sql = $bdd->query("SELECT * FROM gabcms_demande ORDER BY id DESC LIMIT 0,100");
 while($a = $sql->fetch()) {
$t = $bdd->query("SELECT * FROM gabcms_alertes WHERE id = '".$a['number_alert']."'");
$ta = $t->fetch();
	$zer2 = $bdd->query("SELECT username FROM users WHERE id = '".$ta['userid']."'");
	$row2 = $zer2->rowCount();
	$assoc2 = $zer2->fetch(PDO::FETCH_ASSOC);
?>
        <tr class="bas">
            <td class="bas"><?PHP echo $assoc2['username']; ?></td>
            <td class="bas"><?PHP echo $ta['sujet']; ?></td>
            <td class="bas"><?PHP echo stripslashes($ta['alerte']); ?></td>
            <td class="bas"><?PHP echo $a['pseudo']; ?></td>
            <td class="bas"><a href="?do2=<?PHP echo $a['number_alert']; ?>">Refusé la suppression</a> - <a href="?do=<?PHP echo $a['number_alert']; ?>">Supprimé</a></td>
        </tr>
<?PHP } ?>
    </tbody>
</table>
</body>
</html>