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
?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?'.mt_rand(); ?>" type="text/css" media="screen" /><body>
<span id="titre">Affiches les images uploadés</span><br/>
Toutes les images hébergés sur le site sont inscrites ici.<br/><br/>
<table>
    <tbody>
        <tr class="haut">
            <td class="haut">Image (et lien)</td>
            <td class="haut">Hébergé par</td>
            <td class="haut">Date</td>
            <td class="haut">IP</td>
        </tr>
<?php
$messagesParPage = 8;
$retour_total = $bdd->query('SELECT COUNT(*) AS total FROM gabcms_upload');
$donnees_total = $retour_total->fetch(PDO::FETCH_ASSOC);
$total = $donnees_total['total'];
$nombreDePages = ceil($total/$messagesParPage);
if(isset($_GET['page'])) {
     $pageActuelle = intval($_GET['page']);
     if($pageActuelle > $nombreDePages) {
          $pageActuelle = $nombreDePages;
     }
} else {
     $pageActuelle = 1; 
}
$premiereEntree = ($pageActuelle-1)*$messagesParPage;
$retour_messages = $bdd->query('SELECT * FROM gabcms_upload ORDER BY id DESC LIMIT '.$premiereEntree.', '.$messagesParPage.'');
while($a = $retour_messages->fetch(PDO::FETCH_ASSOC))
{
?>
        <tr class="bas">
            <td class="bas"><a href="<?PHP echo $a['lien'] ?>" target="_blank"><img src="<?PHP echo $a['lien'] ?>" style="height:50px;width:50px;" /></a></td>
            <td class="bas"><?PHP echo $a['par'] ?></td>
            <td class="bas"><?PHP echo $a['date'] ?></td>
            <td class="bas"><?PHP echo $a['ip'] ?></td>
        </tr>
<?PHP
	}

echo '<p align="center">Page : ';
for($i = 1; $i <= $nombreDePages; $i++) 
{
     if($i == $pageActuelle) 
     {
         echo ' [ '.$i.' ] '; 
     }	
     else
     {
          echo ' <a href="aff_upload?page='.$i.'">'.$i.'</a> ';
     }
}
echo '</p>';
	?>
</tbody>
</table>
</body>
</html>