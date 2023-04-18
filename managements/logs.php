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
?><link rel="stylesheet" href="css/contenu.css" type="text/css" media="screen" /><body>
<span id="titre">Logs des staffs</span><br/>
Toutes les actions des staffs sont marquées ici.<br/><br/>
<?php
$messagesParPage = 35;
$retour_total = $bdd->query('SELECT COUNT(*) AS total FROM gabcms_stafflog');
$donnees_total = $retour_total->fetch(PDO::FETCH_ASSOC);
$total=$donnees_total['total'];
$nombreDePages = ceil($total/$messagesParPage);
if(isset($_GET['page']))
{
     $pageActuelle = intval($_GET['page']);
 
     if($pageActuelle > $nombreDePages)
     {
          $pageActuelle = $nombreDePages;
     }
}
else
{
     $pageActuelle = 1; 
}
$premiereEntree = ($pageActuelle-1)*$messagesParPage;
$retour_messages = $bdd->query('SELECT * FROM gabcms_stafflog ORDER BY id DESC LIMIT '.$premiereEntree.', '.$messagesParPage.'');
while($donnees_messages = $retour_messages->fetch(PDO::FETCH_ASSOC))
{

?>
<td><span style="color:#008000;"><?PHP echo Secu($donnees_messages['date']); ?></span> <b><?PHP echo Secu($donnees_messages['pseudo']); ?></b> <?PHP echo stripslashes($donnees_messages['action']); ?></td><br/>
<?PHP
	}

echo '<p align="center">Page : ';
for($i=1; $i<=$nombreDePages; $i++) 
{
     if($i==$pageActuelle) 
     {
         echo ' [ '.$i.' ] '; 
     }	
     else
     {
          echo ' <a href="logs?page='.$i.'">'.$i.'</a> ';
     }
}
echo '</p>';
	?>

</body>
</html>