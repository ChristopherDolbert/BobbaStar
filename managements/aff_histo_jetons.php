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
	
	$id = Secu($_GET['id']);
?>
<title>Historique utilisation de codes jetons - Code #<?PHP echo $id; ?></title>
<link rel="stylesheet" href="css/contenu.css<?php echo '?'.mt_rand(); ?>" type="text/css" media="screen" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8" /><body>
<span id="titre">Historique utilisation de codes jetons</span><br />
Ici est affiché l'historique des utilisations de codes jetons, ainsi vous pouvez voir, qui à utiliser le plus de codes.<br/><br/>
<table>
    <tbody>
        <tr class="haut">
            <td class="haut">Pseudo</td>
            <td class="haut">Code utilisé</td>
            <td class="haut">Date</td>
        </tr>
<?php
$sql = $bdd->query("SELECT * FROM gabcms_jetons_logs WHERE code_id = '".$id."' ORDER BY date DESC");
while($a = $sql->fetch()) {	
    $sql1 = $bdd->query("SELECT * FROM users WHERE id = '".$a['user_id']."'");
    $row1 = $sql1->rowCount();
    $assoc1 = $sql1->fetch(PDO::FETCH_ASSOC);
    $sql2 = $bdd->query("SELECT * FROM gabcms_jetons WHERE id = '".$a['code_id']."'");
    $row2 = $sql2->rowCount();
    $assoc2 = $sql2->fetch(PDO::FETCH_ASSOC);
    $date = date('d/m/Y H:i:s', $a['date']);
?>
        <tr class="bas">
            <td class="bas"><?PHP echo Secu($assoc1['username']); ?></td>
            <td class="bas"><?PHP echo Secu($assoc2['code']); ?></td>
            <td class="bas"><?PHP echo Secu($date); ?></td>
        </tr>  
<?PHP } ?>
    </tbody>
</table>
</body>
</html>