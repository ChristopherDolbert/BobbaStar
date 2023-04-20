<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

	include("./config.php");
	$pagename = "Recrutement";
	$pageid = "recrut";
	
if(!isset($_SESSION['username']))
	{
		Redirect("".$url."/index");
	}

?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head> 
<meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
<title><?PHP echo $sitename;?> &raquo; <?PHP echo $pagename;?></title> 
 
<script type="text/javascript"> 
var andSoItBegins = (new Date()).getTime();
var ad_keywords = "";
document.habboLoggedIn = true;
var habboName = "<?PHP echo $user['username'];?>";
var habboReqPath = "<?PHP echo $url;?>";
var habboStaticFilePath = "<?PHP echo $imagepath;?>";
var habboImagerUrl = "http://www.habbo.com/habbo-imaging/";
var habboPartner = "";
var habboDefaultClientPopupUrl = "<?PHP echo $url;?>/client";
window.name = "habboMain";
if (typeof HabboClient!= "undefined") { HabboClient.windowName = "uberClientWnd"; }
</script> 



<link rel="shortcut icon" href="<?PHP echo $imagepath;?>favicon.ico" type="image/vnd.microsoft.icon" /> 
<script src="<?PHP echo $imagepath;?>static/js/libs2.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath;?>static/js/visual.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath;?>static/js/libs.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath;?>static/js/common.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath;?>js/tooltip.js" type="text/javascript"></script>

<script src="<?PHP echo $imagepath;?>static/js/fullcontent.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/style.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/buttons.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/boxes.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/tooltips.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/personal.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<script src="<?PHP echo $imagepath;?>static/js/habboclub.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/minimail.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/myhabbo/control.textarea.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<script src="<?PHP echo $imagepath;?>static/js/minimail.js" type="text/javascript"></script>

 

<meta name="description" content="<?PHP echo $description;?>" /> 
<meta name="keywords" content="<?PHP echo $keyword;?>" />  
<!--[if IE 8]>
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/ie8.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<![endif]--> 
<!--[if lt IE 8]>
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/ie.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<![endif]--> 
<!--[if lt IE 7]>
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/ie6.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<script src="<?PHP echo $imagepath;?>static/js/pngfix.js" type="text/javascript"></script>
<script type="text/javascript">
try { document.execCommand('BackgroundImageCache', false, true); } catch(e) {}
</script>
 
<style type="text/css">
body { behavior: url(http://www.habbo.com/js/csshover.htc); }
</style>
<![endif]--> 
<meta name="build" content="<?PHP echo $build;?> >> <?PHP echo $version;?>" /> 
</head>
<body id="home" class=" "> 
<div id="tooltip"></div>
<div id="overlay"></div> 
<!-- MENU -->
<?PHP include("./template/header.php");?>
<!-- FIN MENU -->
<div id="container"> 
	<div id="content" style="position: relative" class="clearfix"> 
		<div id="column2" class="column"> 
			<div class="habblet-container ">		
				<div class="cbb clearfix white ">
					<div class="box-content"> 
Les recrutements sont ouverts par la <b>direction de l'hôtel</b>.<br/>Ces postes sont tous importants, car chacun de ces postes ont des responsabilités, des commandes et doivent avoir un minimum de sérieux dans leurs différents travaux !
			</div>
		</div> 
	</div>
</div>
<div id="column1" class="column"> 
	<div class="habblet-container ">		
		<div class="cbb clearfix green"> 
			<h2 class="title">
				<span style="float: left;">Ton historique</span> <span style="float: right; font-weight: normal; font-size: 75%;">Vois tes refus, le nombre de participations...</span>
			</h2>
		<div class="box-content"> 
<?php $req = "SELECT COUNT(*) AS id FROM gabcms_recrutement_dossier WHERE pseudo = '".$user['username']."'";
$query = $bdd->query($req);
$nb_inscrit = $query->fetch();
$reqa = "SELECT COUNT(*) AS id FROM gabcms_recrutement_dossier WHERE pseudo = '".$user['username']."' AND retenu = '2'";
$querya = $bdd->query($reqa);
$nb_inscrita = $querya->fetch();
$reqb = "SELECT COUNT(*) AS id FROM gabcms_recrutement_dossier WHERE pseudo = '".$user['username']."' AND retenu = '1'";
$queryb = $bdd->query($reqb);
$nb_inscritb = $queryb->fetch();

if($nb_inscrit['id'] < '2') {
$modif_sessions = "session de recrutements";
}
if($nb_inscrit['id'] >= '2') {
$modif_sessions = "sessions de recrutements";
}
if($nb_inscrita['id'] < '2') {
$modif_accept = "candidature acceptée";
}
if($nb_inscrita['id'] >= '2') {
$modif_accept = "candidatures acceptées";
}
if($nb_inscritb['id'] < '2') {
$modif_refus = "candidature refusée";
}
if($nb_inscritb['id'] >= '2') {
$modif_refus = "candidatures refusées";
}
?>
Bonjour <b><?PHP echo $user['username'];?></b>, tu as déjà postulé à <b><?PHP echo $nb_inscrit['id'];?> <?PHP echo $modif_sessions; ?></b>.
<br/><br/>Parmis ces <b><?PHP echo $nb_inscrit['id']; ?> <?PHP echo $modif_sessions; ?></b>, tu as eu:<br/><ul>
	<li>- <b><?PHP echo $nb_inscrita['id'];?> <?PHP echo $modif_accept; ?></b></li>
	<li>- <b><?PHP echo $nb_inscritb['id'];?> <?PHP echo $modif_refus; ?></b></li>
</ul>
		</div>
	</div>
</div> 
<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script> 		 
</div>
<div id="column11" class="column"> 
	<div class="habblet-container" id="okt" style="float:left; width: 770px;">		
		<div class="cbb clearfix blue"> 
			<h2 class="title">
				<span style="float: left;">Postes vacants</span> <span style="float: right; font-weight: normal; font-size: 75%;">Les postes ouverts</span>
			</h2>
		<div class="box-content"> 
<table>
    <tbody>
        <tr class="haut">
            <td class="haut">Poste</td>
            <td class="haut">Date de publication</td>
            <td class="haut">Date butoire</td>
            <td class="haut">Action</td>
        </tr>
<?php
 $i = 0;
 $sql = $bdd->query("SELECT * FROM gabcms_recrutement WHERE date_butoire >= ".$nowtime." ORDER BY date_butoire ASC");
 while($a = $sql->fetch()) {

			$date_but = date('d/m/Y', $a['date_butoire']);

	$search = $bdd->query("SELECT pseudo FROM gabcms_recrutement_dossier WHERE id_recrut = '".$a['id']."' AND pseudo = '".$user['username']."'");
	$ok = $search->fetch();
			if($ok['pseudo']!= $user['username']) {
			$modif = '<a href="'.$url.'/dossier_recrutement?id='.$a['id'].'">Postuler</a>';
			} if($ok['pseudo'] == $user['username']) {
			$modif = '<img src="'.$url.'/managements/img/images/valide.gif" /> Vous avez postulé';
			}
				$correct = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '".$a['poste']."'");
				$c = $correct->fetch();
?>
        <tr class="bas">
            <td class="bas"><?PHP echo Secu($c['nom_M']); ?></td>
            <td class="bas"><?PHP echo Secu($a['date']); ?></td>
            <td class="bas"><?PHP echo Secu($date_but); ?></td>
            <td class="bas"><?PHP echo $modif; ?></td>
        </tr>
<?PHP } ?>
    </tbody>
</table>
		</div>
	</div>
</div> 
<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script> 		 
</div>
</div></div></div>
<!--[if lt IE 7]>
<script type="text/javascript">
Pngfix.doPngImageFix();
</script>
<![endif]--> 
<!-- FOOTER -->
<?PHP include("./template/footer.php");?>
<!-- FIN FOOTER -->
<div style="clear: both;"></div>
<script type="text/javascript"> 
HabboView.run();

</script>
</body> 
</html> 