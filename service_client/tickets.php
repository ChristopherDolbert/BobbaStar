<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|           GabCMS - Site Web et Content Management System               #|
#|         Copyright © 2012-2014 - Gabodd Tout droits réservés.           #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

	include("../config.php");
	$pagename = "Tickets envoyés";
	
if(!isset($_SESSION['username']))
	{
		Redirect("".$url."/index");
	}

$resul = '';
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head> 
<meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
<title><?PHP echo $sitename; ?> &raquo; <?PHP echo $pagename; ?></title> 
 
<script type="text/javascript"> 
var andSoItBegins = (new Date()).getTime();
var ad_keywords = "";
document.habboLoggedIn = true;
var habboName = "<?PHP echo $user['username']; ?>";
var habboReqPath = "<?PHP echo $url; ?>";
var habboStaticFilePath = "<?PHP echo $imagepath; ?>";
var habboImagerUrl = "http://www.habbo.com/habbo-imaging/";
var habboPartner = "";
var habboDefaultClientPopupUrl = "<?PHP echo $url; ?>/client";
window.name = "habboMain";
if (typeof HabboClient != "undefined") { HabboClient.windowName = "uberClientWnd"; }
</script> 

<link rel="shortcut icon" href="<?PHP echo $imagepath; ?>favicon.ico" type="image/vnd.microsoft.icon" /> 
<script src="<?PHP echo $imagepath; ?>static/js/libs2.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath; ?>static/js/visual.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath; ?>static/js/libs.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath; ?>static/js/common.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath; ?>js/tooltip.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/tooltips.css" type="text/css" />
<script src="<?PHP echo $imagepath; ?>static/js/fullcontent.js" type="text/javascript"></script>
<script type="text/javascript" src="<?PHP echo $imagepath; ?>editor/ckeditor.js"></script>
<script type="text/javascript" src="<?PHP echo $imagepath; ?>editor/config.js"></script>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/style.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/buttons.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/boxes.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/tooltips.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/personal.css" type="text/css" />
<script src="<?PHP echo $imagepath; ?>static/js/habboclub.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/minimail.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/myhabbo/control.textarea.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/newcredits.css" type="text/css" />
<script src="<?PHP echo $imagepath; ?>static/js/minimail.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?PHP echo $url; ?>/service_client/css/index.css" type="text/css" />
<style>
#raison{
background-color:#cecece;
-webkit-box-shadow:0 0 20px rgba(0, 0, 0, 0.5);
box-shadow:0 1px 0 #fff, 0 2px 3px rgba(0, 0, 0, 0.5) inset;
-webkit-border-radius:5px;
-moz-border-radius:5px;
border-radius:5px;
padding:7px;
text-shadow:rgba(255, 255, 255, 0.5) 0 1px 0;
}
</style>

<script type="text/javascript">
document.habboLoggedIn = false;
var habboName = null;
var habboReqPath = "";
var habboStaticFilePath = "./web-gallery";
var habboImagerUrl = "/habbo-imaging/";
var habboPartner = "";
window.name = "habboMain";

</script>

</head>
<body>
<div id="tooltip"></div>
<div style="display:block; position:fixed;" title="Quitter le service client" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)">
<a href="<?PHP echo $url; ?>/moi"><img src="<?PHP echo $url; ?>/service_client/img/retour.gif" style="margin-left:10px;"/></a></div>
<div id="container">
<div id="haut">Tes tickets</div>
						
						<div id="mil">Bienvenue <?PHP echo $user['username']; ?> !<br> Sur cette page, tu pourras savoir si tes <b>5 dernières demandes d'aides</b> ont été traités ou non ! A toi de voir <img src="<?PHP echo $imagepath; ?>smileys/clindoeil.gif" alt=";)" title=";)"/> !<br><br>
<form method="post" action="#">
<td width='80%' class='tbl'><select name="resul" id="pays">
			<option value="">Tous</option>
			<option value="AND resul <= '5'" <?php if (isset($_POST['resul']) && $_POST['resul'] == "AND resul <= '5'") echo 'selected="selected"';?> >Tickets ouverts</option>
			<option value="AND resul >= '6'" <?php if (isset($_POST['resul']) && $_POST['resul'] == "AND resul >= '6'") echo 'selected="selected"';?> >Tickets fermés</option>
			<option value="AND resul = '0'" <?php if (isset($_POST['resul']) && $_POST['resul'] == "AND resul = '0'") echo 'selected="selected"';?> >Signalé</option>
			<option value="AND resul = '1'" <?php if (isset($_POST['resul']) && $_POST['resul'] == "AND resul = '1'") echo 'selected="selected"';?> >En étude</option>
			<option value="AND resul = '2'" <?php if (isset($_POST['resul']) && $_POST['resul'] == "AND resul = '2'") echo 'selected="selected"';?> >Correction à faire</option>
			<option value="AND resul = '3'" <?php if (isset($_POST['resul']) && $_POST['resul'] == "AND resul = '3'") echo 'selected="selected"';?> >Attente réponse du joueur</option>
			<option value="AND resul = '4'" <?php if (isset($_POST['resul']) && $_POST['resul'] == "AND resul = '4'") echo 'selected="selected"';?> >Réponse donnée par le joueur</option>
			<option value="AND resul = '5'" <?php if (isset($_POST['resul']) && $_POST['resul'] == "AND resul = '5'") echo 'selected="selected"';?> >En test</option>
			<option value="AND resul = '6'" <?php if (isset($_POST['resul']) && $_POST['resul'] == "AND resul = '6'") echo 'selected="selected"';?> >Fermé - Résolu</option>
			<option value="AND resul = '7'" <?php if (isset($_POST['resul']) && $_POST['resul'] == "AND resul = '7'") echo 'selected="selected"';?> >Fermé - déjà signalé/résolu</option>
			<option value="AND resul = '8'" <?php if (isset($_POST['resul']) && $_POST['resul'] == "AND resul = '8'") echo 'selected="selected"';?> >Fermé - sans suite</option>
	<input type="submit" value="Rechercher" /><br/><br/>
</form>
<?php
if(isset($_POST['resul'])) { $resul = $_POST['resul']; }
$messagesParPage=5; 
$retour_total=$bdd->query("SELECT COUNT(*) AS total FROM gabcms_contact WHERE user_id = ".$user['id']." ".$resul."");
$donnees_total=$retour_total->fetch();
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
$retour_messages=$bdd->query("SELECT * FROM gabcms_contact WHERE user_id = ".$user['id']." ".$resul." ORDER BY id DESC LIMIT ".$premiereEntree.", ".$messagesParPage."");
        while($t = $retour_messages->fetch()) {
if($t['resul'] == 0) {
$modif = "<span style=\"color:#FF4500\"><b>Signalé</b></span>";
}
if($t['resul'] == 1) {
$modif = "<span style=\"color:#4B0082\"><b>En étude</b></span>";
}
if($t['resul'] == 2) {
$modif = "<span style=\"color:#FF0000\"><b>Correction à faire</b></span>";
}
if($t['resul'] == 3) {
$modif = "<span style=\"color:#0000FF\"><b>Attente réponse du joueur</b></span>";
}
if($t['resul'] == 4) {
$modif = "<span style=\"color:#8B4513\"><b>Réponse donnée par le joueur</b></span>";
}
if($t['resul'] == 5) {
$modif = "<span style=\"color:#2E8B57\"><b>En test</b></span>";
}
if($t['resul'] == 6) {
$modif = "<span style=\"color:#008000\"><b>Fermé - Résolu</b></span>";
}
if($t['resul'] == 7) {
$modif = "<span style=\"color:#DAA520\"><b>Fermé - déjà signalé/résolu</b></span>";
}
if($t['resul'] == 8) {
$modif = "<span style=\"color:#DAA520\"><b>Fermé - sans suite</b></span>";
}
?>
<table width="103%" style="margin-left: -14px; background-color:<?PHP echo (($oe == 2) ? '#fff' : '#DFDFDF') ?>;">
	<tbody>
		<tr><td valign="middle" width="10" height="60"><div style="width: 64px; height: 65px; margin-bottom:-9px; margin-top:-5px; margin-left: -5px; float: left; background: url(https://avatar.myhabbo.fr/?figure=<?PHP echo $user['look'] ?>);"></div></td>
	<td valign="top">Sujet : <b><?PHP echo stripslashes($t['sujet']); ?></b> - Le : <b><?PHP echo Secu($t['date']); ?></b> dans la catégorie <b><i><?PHP echo Secu($t['categorie']); ?></i></b> - Ticket <b>#<?PHP echo Secu($t['id']); ?></b><br>
	<div id="cta_01"></div><div id="cta_02"><?PHP echo smileyforum(stripslashes($t['texte'])); ?></div><div id="cta_03"></div><br>
	Historique :<br>
	<div id="raison"><?PHP $infe = $bdd->query("SELECT * FROM gabcms_contact_info WHERE contact_id = '".$t['id']."'");
if($infe->rowCount() == 0) {
echo "<i>Aucun historique, en attente d'affectation à un opérateur..</i>";  }
		while($rt = $infe->fetch()) { ?><span style="color:#008000;"><?PHP echo Secu($rt['date']); ?></span> <?PHP echo smileyforum($rt['message']); ?><br><?PHP } ?></div>
<?PHP if($t['resul'] < 6) { ?>Toi aussi commentes ton statut, en <a href="<?PHP echo $url ?>/service_client/comment?id=<?PHP echo $t['id'] ?>">cliquant ici</a><?PHP } else { ?>Le sujet est fermé, tu ne peux plus le commenter<?PHP } ?><br><br><?PHP echo $modif; ?><br></td></tr></tbody><br>
	</table>
	<?PHP }

echo '<p align="center">Page : ';
for($i=1; $i<=$nombreDePages; $i++) 
{
     if($i==$pageActuelle) 
     {
         echo ' [ '.$i.' ] '; 
     }	
     else 
     {
          echo ' <a href="tickets?page='.$i.'">'.$i.'</a> ';
     }
}
echo '</p>';
	?>
</div>
<div id="bas"><a href="<?PHP echo $url; ?>/service_client/">Revenir à l'accueil</a></div></div>
</body>
</html>