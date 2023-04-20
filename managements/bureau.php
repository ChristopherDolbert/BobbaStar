<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

	include("../config.php");
	$pagename = "Bureau des staffs";
	$pageid = "bureau";
	$jourj = date('w');
	
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
<script src="<?PHP echo $imagepath; ?>static/js/fullcontent.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/style.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/buttons.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/boxes.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/tooltips.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/personal.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<script src="<?PHP echo $imagepath; ?>static/js/habboclub.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/minimail.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/myhabbo/control.textarea.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<script src="<?PHP echo $imagepath; ?>static/js/minimail.js" type="text/javascript"></script>

 

<meta name="description" content="<?PHP echo $description; ?>" /> 
<meta name="keywords" content="<?PHP echo $keyword; ?>" />  
<!--[if IE 8]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/ie8.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<![endif]--> 
<!--[if lt IE 8]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/ie.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<![endif]--> 
<!--[if lt IE 7]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/ie6.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<script src="<?PHP echo $imagepath; ?>static/js/pngfix.js" type="text/javascript"></script>
<script type="text/javascript">
try { document.execCommand('BackgroundImageCache', false, true); } catch(e) {}
</script>
 
<style type="text/css">
body { behavior: url(http://www.habbo.com/js/csshover.htc); }
</style>
<![endif]--> 
<meta name="build" content="<?PHP echo $build; ?> >> <?PHP echo $version; ?>" /> 
</head>

<body id="home"> 
<div id="tooltip"></div>
<div id="overlay"></div> 
<!-- MENU -->
<?PHP include("../template/header.php"); ?>
<!-- FIN MENU -->
<div id="container">
<div id="content"> 
<div id="column11" class="column">
<div class="habblet-container" id="ok" style="float:left; width: 770px;">        
<div class="cbb clearfix pixellightblue">
<h2 class="title">Bloc-notes</h2>
 <div class="box-content"> 
<?PHP
	$sql = $bdd->query("SELECT * FROM gabcms_bureau_notes WHERE id = '1'");
	$n = $sql->fetch(PDO::FETCH_ASSOC);
	$trf = $bdd->query("SELECT look FROM users WHERE username = '".$n['par']."'");
	$r = $trf->fetch(PDO::FETCH_ASSOC);
?>
<?php echo stripslashes($n['texte']); ?><br/>
<div id="article_haut"><span style="width: 64px; height: 83px; margin-top:-5px; margin-left:-5px; float: left; background: url(<?php echo $avatarimage; ?><?PHP echo Secu($r['look']); ?>&action=wav&direction=2&head_direction=2&gesture=sml&size=big&img_format=gif);"></span><br/><span style="color: #000000; font-size: 11px;"><br/><b>Dernière modification effectuée par :</b> <?PHP echo Secu($n['par']); ?><br/><b>Date :</b> <?PHP echo Secu($n['date']); ?><br/><br/></div>  
</div> 
</div></div></div></div></div>
<div id="container"> 
<div id="content" style="position: relative" class="clearfix"> 
<div id="column2" class="column"> 
<div class="habblet-container">		
<div class="cbb clearfix red"><h2 class="title" style="background-color:#FF0000;">Rappels</h2>
<div class="box-content">
<?php
 $sql = $bdd->query("SELECT * FROM gabcms_bureau_rappels WHERE affichage = 2 ORDER BY id DESC");
        if($sql->rowCount() == 0)
        {
            echo "<i>Aucun rappel</i>";
        }
		if($sql->rowCount() >= 1)
        {
            echo 'La direction de l\'hôtel vous rappel qu\'il faut :<br/>';
        }
		
 while($a = $sql->fetch()) {
	echo '- <b>'.($a['rappel']).'</b><br/>';
}
?>
</div></div></div></div>
<div id="column1" class="column"> 
<div class="habblet-container ">		
						<div class="cbb clearfix green"><h2 class="title">Planning des animations</h2> 
 <div class="box-content"> 
<?PHP
 				if($jourj == "0") {
				$modif_jour = "Dimanche";
				}	
				if($jourj == "1") {
				$modif_jour = "Lundi";
				}	
				if($jourj == "2") {
				$modif_jour = "Mardi";
				}	
				if($jourj == "3") {
				$modif_jour = "Mercredi";
				}	
				if($jourj == "4") {
				$modif_jour = "Jeudi";
				}	
				if($jourj == "5") {
				$modif_jour = "Vendredi";
				}	
				if($jourj == "6") {
				$modif_jour = "Samedi";
				}
	$sql = $bdd->query("SELECT * FROM gabcms_bureau_anim WHERE jour = '".$jourj."'");
	if($sql->rowCount() == 0)
        {
            echo "<i>Aucune animation de prévue ! Faites-vous plaisir.</i>";
        }
	if($sql->rowCount() >= 1)
        {
?><center>Planning du <b><?PHP echo $modif_jour; ?></b></center><br/>
<table>
    <tbody>
        <tr class="haut">
            <td class="haut">Nom du jeu</td>
            <td class="haut">Heure de début</td>
            <td class="haut">Heure de fin</td>
            <td class="haut">Animé par</td>
        </tr>
<?PHP } while($n = $sql->fetch(PDO::FETCH_ASSOC)) {	
?>
            <tr class="bas">
                <td class="bas"><?PHP echo stripslashes($n['nomjeu']); ?></td>
                <td class="bas"><?PHP echo Secu($n['date_debut']); ?></td>
                <td class="bas"><?PHP echo Secu($n['date_fin']); ?></td>
                <td class="bas"><?PHP echo Secu($n['par']); ?></td>
            </tr>
<?PHP } ?>
</tbody>
</table>
</div> 

					</div></div></div><script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script> 
<!--[if lt IE 7]>
<![endif]--> 
<!-- FOOTER -->
<?PHP include("../template/footer.php"); ?>
<!-- FIN FOOTER -->
<div style="clear: both;"></div>
</div></div>
<script type="text/javascript"> 
HabboView.run();
</script>
</body> 
</html> 