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
	$infe = $bdd->query("SELECT * FROM gabcms_tchat WHERE id = '".$do."'");
	$e = $infe->fetch();
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a modéré un <b>tchat</b> de <b>'.$e['pseudo'].'</b>');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
        $bdd->query("UPDATE gabcms_tchat SET message='<span style=\"color:#B5B5B5;\"><i>Ce message a été modéré par un modérateur.</i></span>' WHERE id = '".$do."'");
	echo '<h4 class="alert_success">Un tchat a été modéré avec succès !</h4>';
}
if(isset($_GET['sup'])) {
	$sup = Secu($_GET['sup']);
	$infr = $bdd->query("SELECT * FROM gabcms_tchat WHERE id = '".$sup."'");
	$r = $infr->fetch();
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a supprimé un <b>tchat</b> de <b>'.$r['pseudo'].'</b>');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
        $bdd->query("DELETE FROM gabcms_tchat WHERE id = '".$sup."'");
	echo '<h4 class="alert_success">Un tchat a été supprimé avec succès !</h4>';
}
?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?'.mt_rand(); ?>" type="text/css" media="screen" /><body></body>
<span id="titre">Modères ou supprimes un tchat</span><br/>
Modères ou supprimes un tchat qui a été posté sur la page tchat du rétro.<br/><br/>
<table>
    <tbody>
        <tr class="haut">
            <td class="haut">Pseudo</td>
            <td class="haut">Date</td>
            <td class="haut">Message</td>
            <td class="haut">IP</td>
            <td class="haut">Action</td>
        </tr>
<?php
 $sql = $bdd->query("SELECT * FROM gabcms_tchat WHERE pseudo != '' AND message != '<span style=\"color:#B5B5B5;\"><i>Ce message a été modéré par un modérateur.</i></span>' ORDER BY id DESC");
 while($a = $sql->fetch()) {
?>
        <tr class="bas">
            <td class="bas"><?PHP echo $a['pseudo']; ?></td>
            <td class="bas"><?PHP echo $a['date']; ?></td>
            <td class="bas"><?PHP echo $a['message']; ?></td>
            <td class="bas"><?PHP echo $a['ip']; ?></td>
            <td class="bas"><a href="?do=<?PHP echo $a['id']; ?>">Modérer</a> - <a href="?sup=<?PHP echo $a['id']; ?>">Supprimer</a></td>
        </tr>
<?PHP } ?>
    </tbody>
</table>
</body>
</html>