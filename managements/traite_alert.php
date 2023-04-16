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
	$zer = $bdd->query("SELECT username FROM users WHERE id = '".$t1['userid']."'");
	$row = $zer->rowCount();
	$assoc = $zer->fetch(PDO::FETCH_ASSOC);
	if($do != "") {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a demandé la suppresion d\'une alerte de <b>'.$assoc['username'].'</b> (ID : '.$do.')');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute();
        $insertn2 = $bdd->prepare("INSERT INTO gabcms_management (user_id, message, auteur, date, look) VALUES (:userid, :message, :auteur, :date, :look)");
            $insertn2->bindValue(':userid', $t1['userid']);
            $insertn2->bindValue(':message', 'Je viens de demander la suppression d\'une de tes alertes. Une réponse de cette demande te sera transmise une fois traitée par un administrateur. (n° de l\'alerte : '.$do.')');
            $insertn2->bindValue(':auteur', $user['username']);
            $insertn2->bindValue(':date', FullDate('full'));
            $insertn2->bindValue(':look', $user['look']);
        $insertn2->execute();
        $bdd->query("INSERT INTO gabcms_demande (number_alert,pseudo,date) VALUES ('".$do."','".$user['username']."','".FullDate('full')."')");
	echo '<h4 class="alert_success">Ta demande de suppression a été prise en compte !</h4>';
 }
}
?>
<link rel="stylesheet" href="css/contenu.css" type="text/css" media="screen" /><body>
<span id="titre">Demandes a effacer une alerte</span><br/>
Cette page te permet de demander une suppression d'une alerte.<br/><br/>
<table>
    <tbody>
        <tr class="haut">
            <td class="haut">ID</td>
            <td class="haut">Pseudo</td>
            <td class="haut">Sujet</td>
            <td class="haut">Message</td>
            <td class="haut">Action</td>
        </tr>
<?php
$sql = $bdd->query("SELECT * FROM gabcms_alertes ORDER BY id DESC LIMIT 0,100");
while($a = $sql->fetch()) {
    $zer = $bdd->query("SELECT username FROM users WHERE id = '".$a['userid']."'");
    $row = $zer->rowCount();
    $assoc = $zer->fetch(PDO::FETCH_ASSOC);
	$search = $bdd->query("SELECT * FROM gabcms_demande WHERE number_alert = '".$a['id']."'");
	$ok = $search->fetch();
			if($ok['number_alert'] != $a['id']) {
			$modif = '<a href="?do='.$a['id'].'">Demande de suppression</a>';
			} if($ok['number_alert'] == $a['id']) {
			$modif = '<img src="'.$url.'/managements/img/images/valide.gif" /> Demande déjà émise';
			}
?>
        <tr class="bas">
            <td class="bas"><?PHP echo $a['id']; ?></td>
            <td class="bas"><?PHP echo $assoc['username']; ?></td>
            <td class="bas"><?PHP echo $a['sujet']; ?></td>
            <td class="bas"><?PHP echo stripslashes($a['alerte']); ?></td>
            <td class="bas"><?PHP echo $modif; ?></td>
        </tr>
<?PHP } ?>
    </tbody>
</table>
</body>
</html>