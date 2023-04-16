<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|           GabCMS - Site Web et Content Management System               #|
#|         Copyright © 2012-2014 - Gabodd Tout droits réservés.           #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

	include("../config.php");
	$pagename = "Dépôt &raquo; Service client";
	$pageid = "sc_index";
	
if(!isset($_SESSION['username']))
	{
		Redirect("".$url."/index");
	}
	
	if($user['rank'] < 5) {
	Redirect("".$url."/managements/acces_interdit");	
	exit();
	}
	if($user['rank'] > 8) {              
	Redirect("".$url."/managements/acces_interdit");
	exit();
	}	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head> 
<meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
<title><?PHP echo $sitename; ?> &raquo; <?PHP echo $pagename; ?></title> 

<link rel="shortcut icon" href="<?PHP echo $imagepath; ?>favicon.ico" type="image/vnd.microsoft.icon" /> 
<script src="<?PHP echo $imagepath; ?>static/js/libs2.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath; ?>static/js/visual.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath; ?>static/js/libs.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath; ?>static/js/common.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath; ?>js/tooltip.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath; ?>static/js/fullcontent.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/style.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/buttons.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/boxes.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/tooltips.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/personal.css" type="text/css" />
<script src="<?PHP echo $imagepath; ?>static/js/habboclub.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/minimail.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/myhabbo/control.textarea.css" type="text/css" />
<script src="<?PHP echo $imagepath; ?>static/js/minimail.js" type="text/javascript"></script>
<meta name="description" content="<?PHP echo $description; ?>" /> 
<meta name="keywords" content="<?PHP echo $keyword; ?>" />  
<meta name="build" content="<?PHP echo $build; ?> >> <?PHP echo $version; ?>" /> 
</head>

<body id="home"> 
<div id="tooltip"></div>
<div id="overlay"></div> 
<div id="container"> 
<div id="content" style="position: relative" class="clearfix"> 
<div id="column1" class="column"> 
<div class="habblet-container" id="okt" style="float:left; width: 770px;">        
<div class="cbb clearfix green"><h2 class="title">Tickets résolus</h2> 
<div class="box-content"> 
<?php
$messagesParPage=10; 
$retour_total=$bdd->query("SELECT COUNT(*) AS total FROM gabcms_contact WHERE resul >= '6' AND resul <= '8' ORDER BY id DESC");
$donnees_total=$retour_total->fetch(PDO::FETCH_ASSOC);
$total=$donnees_total['total'];
$nombreDePages=ceil($total/$messagesParPage);
if(isset($_GET['page']))
{
     $pageActuelle=intval($_GET['page']);
 
     if($pageActuelle>$nombreDePages)
     {
          $pageActuelle=$nombreDePages;
     }
}
else
{
     $pageActuelle=1; 
}
$premiereEntree=($pageActuelle-1)*$messagesParPage;
$retour_messages=$bdd->query("SELECT * FROM gabcms_contact WHERE resul >= '6' AND resul <= '8' ORDER BY id DESC LIMIT ".$premiereEntree.", ".$messagesParPage."");
   $row = $retour_messages->rowCount();
 if($row < 1) {
	echo "Il n'y a aucun sujet d'aide.";
	} elseif($row > 0) {  ?>
<table>
    <tbody>
        <tr class="haut">
            <td class="haut">Ticket #</td>
            <td class="haut">Pseudo</td>
            <td class="haut">Catégorie</td>
            <td class="haut">Date</td>
            <td class="haut">Sujet</td>
            <td class="haut">Etat</td>
            <td class="haut">Dernière réponse</td>
            <td class="haut">Action</td>
        </tr>
<?PHP while($a = $retour_messages->fetch()) {
if($a['resul'] == 0) { $etat_modif = "<span style=\"color:#FF4500\"><b>Signalé</b></span>"; }
if($a['resul'] == 1) { $etat_modif = "<span style=\"color:#4B0082\"><b>En étude</b></span>"; }
if($a['resul'] == 2) { $etat_modif = "<span style=\"color:#FF0000\"><b>Correction à faire</b></span>"; }
if($a['resul'] == 3) { $etat_modif = "<span style=\"color:#0000FF\"><b>Attente réponse du joueur</b></span>"; }
if($a['resul'] == 4) { $etat_modif = "<span style=\"color:#8B4513\"><b>Réponse donnée par le joueur</b></span>"; }
if($a['resul'] == 5) { $etat_modif = "<span style=\"color:#2E8B57\"><b>En test</b></span>"; }
if($a['resul'] == 6) { $etat_modif = "<span style=\"color:#008000\"><b>Fermé - Résolu</b></span>"; }
if($a['resul'] == 7) { $etat_modif = "<span style=\"color:#8bda20\"><b>Fermé - déjà signalé/résolu</b></span>"; }
if($a['resul'] == 8) { $etat_modif = "<span style=\"color:#DAA520\"><b>Fermé - sans suite</b></span>"; }
?>
        <tr class="bas">
            <td class="bas"><?PHP echo Secu($a['id']); ?></td>
            <td class="bas"><?PHP echo Secu($a['pseudo']); ?></td>
            <td class="bas"><?PHP echo Secu($a['categorie']); ?></td>
            <td class="bas"><?PHP echo Secu($a['date']); ?></td>
            <td class="bas"><?PHP echo stripslashes($a['sujet']); ?></td>
            <td class="bas"><?PHP echo $etat_modif; ?></td>
            <td class="bas"><?PHP echo Secu($a['resul_par']); ?></td>
            <td class="bas"><a href="<?PHP echo $url; ?>/managements/sc_traiter?id=<?PHP echo Secu($a['id']); ?>" target="_blank">Actions</a> - <a href="<?PHP echo $url; ?>/managements/sc_historique?id=<?PHP echo $a['id']; ?>" target="_blank">Historique</a></td>
            </tr>
<?PHP } } 

echo '<p align="center">Page : ';
for($i=1; $i<=$nombreDePages; $i++) 
{
     if($i==$pageActuelle) 
     {
         echo ' [ '.$i.' ] '; 
     }	
     else 
     {
          echo ' <a href="sc_ticket_resolu?page='.$i.'">'.$i.'</a> ';
     }
}
echo '</p>';
?>
</tbody>
</table>
 </div>
					</div></div></div><script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script> 
</div></div></body></html>