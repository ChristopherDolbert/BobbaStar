<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|

#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

	include("./config.php");
	$pagename = "L'équipe";
	$pageid = "staff";
	$nowtime = time();
	
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
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/style.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/buttons.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/boxes.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/tooltips.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/personal.css" type="text/css" />
<script src="<?PHP echo $imagepath;?>static/js/habboclub.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/minimail.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/myhabbo/control.textarea.css" type="text/css" />
<script src="<?PHP echo $imagepath;?>static/js/minimail.js" type="text/javascript"></script>

 

<meta name="description" content="<?PHP echo $description;?>" /> 
<meta name="keywords" content="<?PHP echo $keyword;?>" />  
<!--[if IE 8]>
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/ie8.css" type="text/css" />
<![endif]--> 
<!--[if lt IE 8]>
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/ie.css" type="text/css" />
<![endif]--> 
<!--[if lt IE 7]>
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/ie6.css" type="text/css" />
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
						<div class="cbb clearfix blue"> 
							<h2 class="title"><span style="float: left;">Fondateurs</span> <span style="float: right; font-weight: normal; font-size: 75%;">Ils dirigent l'hôtel</span></h2>
 <div class="box-content"> 
<style>
table.fondateur {
    background-color: #fff;
    font-size: 11px;
    padding: 5px; 
    margin-left: -15px;
    width: 111%;
}
table.fondateur:nth-child(2n+1) {
    background-color: #CCDFF2;
    font-size: 11px;
    padding: 5px; 
    margin-left: -15px;
    width: 111%;
}
</style> 
<?PHP
$sql = $bdd->query("SELECT * FROM users WHERE rank = '8'");

while($s = $sql->fetch()) {

	$infe = $bdd->query("SELECT * FROM gabcms_postes WHERE user_id = '".$s['id']."'");
	$rt = $infe->fetch();
	
	$tera = $bdd->query("SELECT * FROM gabcms_absence_staff WHERE pseudo = '".$s['username']."' AND jusqua >= '".$nowtime."'");
	$t = $tera->fetch();

if($s['staff_test'] == 0) {
$etat_modif = '';
}
if($s['staff_test'] == 1) {
$etat_modif = '<span style="color:#FF0000">(staff en test)</span>';
}

$date_jusqua = date('d/m/Y', $t['jusqua']);

if($t['depuis'] <= $nowtime && $t['jusqua'] >= $nowtime && $t['etat'] == 1) {
$etat8 = '<span style="color:#2767A7;">est absent(e) jusqu\'au '.$date_jusqua.'</span>';
} else {
$etat8 = '';
}
?>
<table class="fondateur">
    <tbody>
        <tr> 
            <td valign="middle" width="10" height="60"> 
                <a href="<?PHP echo $url ?>/info?pseudo=<?PHP echo $s['username'] ?>" title="Aller sur son profil &raquo;" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)"><div style="width: 64px; height: 70px; margin-bottom:-10px; margin-top:-15px; margin-left: -15px; float: right; background: url(https://avatar.myhabbo.fr/?figure=<?PHP echo Secu($s['look']);?>&action=sit&direction=2&head_direction=3&gesture=sml&size=b&img_format=gif);"></div></a>
            </td> 
            <td valign="top"> 
                <span style="color:#2767A7;"><b style="font-size: 110%;" title="Poste(s) occupé(s): <?PHP $infe = $bdd->query("SELECT * FROM gabcms_postes WHERE user_id = '".$s['id']."'");
while($rt = $infe->fetch()) { 
			$correct = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '".$rt['poste']."'");
			$caz = $correct->fetch(); 
			if($s['gender'] == "M") { ?> <?PHP echo stripslashes(Secu($caz['nom_M']))?>, <?PHP } if($s['gender'] == "F") { ?><?PHP echo stripslashes(Secu($caz['nom_F']))?>, <?PHP } }?>" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)"><?PHP echo Secu($s['username'])?></span></b> <?PHP echo $etat8; ?> <?PHP echo $etat_modif; ?> <br />
                <span style="color:#888"><b>Mission:</b> <?PHP echo stripslashes(Secu($s['motto']))?></span><br/> 
                <span style="color:#888"><b>Fonction:</b> <?PHP echo stripslashes(Secu($s['fonction']))?></span><br/>
				<?PHP echo (($s['online'] == "1")? '<img src="'.$imagepath.'v2/images/online.gif"></td>': '<img src="'.$imagepath.'v2/images/offline.gif"></td>')?>
            </td>
        </tr>
    </tbody>
</table>
<?PHP }?>
</div></div></div> 
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script> 
<div class="habblet-container ">		
<div class="cbb clearfix white ">
 <div class="box-content"> 
<img style="float: right" src="http://images-eussl.habbo.com/c_images/album1584/ADM.gif">
"Qui sont ces personnes?"<br/>
<b>Les staffs sont des joueurs qui modèrent et animent l'hôtel.</b> Ils sont là pour faire respecter la Habbo Attitude et proposent aux utilisateurs des moments de plaisir.<br/>
<b>La sécurité</b> est le point le plus important pour eux.<br/> 
Afin de repérer les staffs, ils portent un badge "Habbo Staff" sans lequel ce n'en est pas un.<br/>
"Comment puis-je devenir un staff?" <br/>
Être staff sur <?PHP echo $sitename;?> est un <b>emploi virtu/réel.</b> Les staffs sont soumis à des tests et sont choisis pour leurs compétences! De plus, tous les membres du personnel sont extérieurs à l'hôtel. Et non, on ne paye pas pour devenir staff!:/<br/><br/>
Pour devenir staff, la direction de l'hôtel ouvre des postes que tu peux consulter <a href="<?PHP echo $url;?>/recrutement">ici</a>.
</div> </div> </div> </div>
<div id="column1" class="column"> 
		     						<div class="habblet-container ">		
						<div class="cbb clearfix yellow"> 
							<h2 class="title"><span style="float: left;">Managers</span> <span style="float: right; font-weight: normal; font-size: 75%;">Ils gèrent l'hôtel</span>

							</h2>
 <div class="box-content"> 
<style>
table.manager {
    background-color: #fff;
    font-size: 11px;
    padding: 5px; 
    margin-left: -15px;
    width: 107%;
}
table.manager:nth-child(2n+1) {
    background-color: #F7F2C4;
    font-size: 11px;
    padding: 5px; 
    margin-left: -15px;
    width: 107%;
}
</style> 
<?PHP
$sql = $bdd->query("SELECT * FROM users WHERE rank = '7'");
while($s = $sql->fetch()) {

	$infe = $bdd->query("SELECT * FROM gabcms_postes WHERE user_id = '".$s['id']."'");
	$rt = $infe->fetch();
	
	$tera = $bdd->query("SELECT * FROM gabcms_absence_staff WHERE pseudo = '".$s['username']."' AND jusqua >= '".$nowtime."'");
	$t = $tera->fetch();
if($s['staff_test'] == 0) {
$etat_modif = '';
}
if($s['staff_test'] == 1) {
$etat_modif = '<span style="color:#FF0000">(staff en test)</span>'; 
}

$date_jusqua = date('d/m/Y', $t['jusqua']);

if($t['depuis'] <= $nowtime && $t['jusqua'] >= $nowtime && $t['etat'] == 1) {
$etat7 = '<span style="color:#C1B31C;">est absent(e) jusqu\'au '.$date_jusqua.'</span>';
} else {
$etat7 = '';
}
?>
<table class="manager">
    <tbody>
        <tr> 
            <td valign="middle" width="10" height="60"> 
            <a href="<?PHP echo $url ?>/info?pseudo=<?PHP echo $s['username'] ?>" title="Aller sur son profil &raquo;" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)"><div style="width: 64px; height: 70px; margin-bottom:-10px; margin-top:-15px; margin-left: -15px; float: right; background: url(https://avatar.myhabbo.fr/?figure=<?PHP echo Secu($s['look']);?>&action=sit&direction=2&head_direction=3&gesture=sml&size=b&img_format=gif);"></div></a>
            </td> 
            <td valign="top"> 
                <span style="color:#C1B31C;"><b style="font-size: 110%;" title="Poste(s) occupé(s): <?PHP $infe = $bdd->query("SELECT * FROM gabcms_postes WHERE user_id = '".$s['id']."'");
while($rt = $infe->fetch()) { 
			$correct = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '".$rt['poste']."'");
			$caz = $correct->fetch(); 
			if($s['gender'] == "M") { ?> <?PHP echo stripslashes(Secu($caz['nom_M'])); ?>, <?PHP } if($s['gender'] == "F") { ?><?PHP echo stripslashes(Secu($caz['nom_F'])); ?>, <?PHP } }?>" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)"><?PHP echo Secu($s['username']); ?>              </span></b> <?PHP echo $etat7; ?> <?PHP echo $etat_modif; ?><br />
                <span style="color:#888"><b>Mission:</b> <?PHP echo stripslashes(Secu($s['motto']))?></span><br/> 
						<span style="color:#888"><b>Fonction:</b> <?PHP echo stripslashes(Secu($s['fonction']))?></span><br/>
				        <?PHP echo (($s['online'] == "1")? '<img src="'.$imagepath.'v2/images/online.gif"></td>': '<img src="'.$imagepath.'v2/images/offline.gif"></td>')?>
            </td>
        </tr>
    </tbody>
</table>
<?PHP }?>
</div></div></div> 
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script> 
					<div class="habblet-container ">		
						<div class="cbb clearfix green"> 
							<h2 class="title"><span style="float: left;">Administrateurs</span> <span style="float: right; font-weight: normal; font-size: 75%;">Ils animent l'hôtel</span>

							</h2>
 <div class="box-content">
<style>
table.admin {
    background-color: #fff;
    font-size: 11px;
    padding: 5px; 
    margin-left: -15px;
    width: 107%;
}
table.admin:nth-child(2n+1) {
    background-color: #E4FFD2;
    font-size: 11px;
    padding: 5px; 
    margin-left: -15px;
    width: 107%;
}
</style> 
<?PHP
$sql = $bdd->query("SELECT * FROM users WHERE rank = '6'");
while($s = $sql->fetch()) {
	$infe = $bdd->query("SELECT * FROM gabcms_postes WHERE user_id = '".$s['id']."'");
	$rt = $infe->fetch();
	$tera = $bdd->query("SELECT * FROM gabcms_absence_staff WHERE pseudo = '".$s['username']."' AND jusqua >= '".$nowtime."'");
	$t = $tera->fetch();

if($s['staff_test'] == 0) {
$etat_modif = '';
}
if($s['staff_test'] == 1) {
$etat_modif = '<span style="color:#FF0000">(staff en test)</span>';
}

$date_jusqua = date('d/m/Y', $t['jusqua']);

if($t['depuis'] <= $nowtime && $t['jusqua'] >= $nowtime && $t['etat'] == 1) {
$etat6 = '<span style="color:#4AB501;">est absent(e) jusqu\'au '.$date_jusqua.'</span>';
} else {
$etat6 = '';
}
?>
<table class="admin">
    <tbody>
        <tr> 
            <td valign="middle" width="10" height="60"> 
            <a href="<?PHP echo $url ?>/info?pseudo=<?PHP echo $s['username'] ?>" title="Aller sur son profil &raquo;" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)"><div style="width: 64px; height: 70px; margin-bottom:-10px; margin-top:-15px; margin-left: -15px; float: right; background: url(https://avatar.myhabbo.fr/?figure=<?PHP echo Secu($s['look']);?>&action=sit&direction=2&head_direction=3&gesture=sml&size=b&img_format=gif);"></div></a>
            </td> 
            <td valign="top"> 
                <span style="color:#4AB501;"><b style="font-size: 110%;" title="Poste(s) occupé(s): <?PHP $infe = $bdd->query("SELECT * FROM gabcms_postes WHERE user_id = '".$s['id']."'");
while($rt = $infe->fetch()) { 
			$correct = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '".$rt['poste']."'");
			$caz = $correct->fetch(); 
			if($s['gender'] == "M") { ?> <?PHP echo stripslashes(Secu($caz['nom_M']))?>, <?PHP } if($s['gender'] == "F") { ?><?PHP echo stripslashes(Secu($caz['nom_F']))?>, <?PHP } }?>" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)"><?PHP echo Secu($s['username'])?></span></b> <?PHP echo $etat6; ?> <?PHP echo $etat_modif; ?> <br />
                <span style="color:#888"><b>Mission:</b> <?PHP echo stripslashes(Secu($s['motto']))?></span><br/> 
                <span style="color:#888"><b>Fonction:</b> <?PHP echo stripslashes(Secu($s['fonction']))?></span><br/>
                <?PHP echo (($s['online'] == "1")? '<img src="'.$imagepath.'v2/images/online.gif"></td>': '<img src="'.$imagepath.'v2/images/offline.gif"></td>')?>
            </td>
        </tr>
    </tbody>
</table>
<?PHP }?>
</div></div></div> 
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script> 

<div class="habblet-container ">		
						<div class="cbb clearfix red"> 
							<h2 class="title"><span style="float: left;">Modérateurs</span> <span style="float: right; font-weight: normal; font-size: 75%;">Ils modèrent l'hôtel</span>

							</h2>
 <div class="box-content"> 
<style>
table.modo {
    background-color: #fff;
    font-size: 11px;
    padding: 5px; 
    margin-left: -15px;
    width: 107%;
}
table.modo:nth-child(2n+1) {
    background-color: #FCDCDC;
    font-size: 11px;
    padding: 5px; 
    margin-left: -15px;
    width: 107%;
}
</style> 
<?PHP
$sql = $bdd->query("SELECT * FROM users WHERE rank = '5'");
while($s = $sql->fetch()) {
	$infe = $bdd->query("SELECT * FROM gabcms_postes WHERE user_id = '".$s['id']."'");
	$rt = $infe->fetch();
	$tera = $bdd->query("SELECT * FROM gabcms_absence_staff WHERE pseudo = '".$s['username']."' AND jusqua >= '".$nowtime."'");
	$t = $tera->fetch();

if($s['staff_test'] == 0) {
$etat_modif = '';
}
if($s['staff_test'] == 1) {
$etat_modif = '<span style="color:#FF0000">(staff en test)</span>';
}

$date_jusqua = date('d/m/Y', $t['jusqua']);

if($t['depuis'] <= $nowtime && $t['jusqua'] >= $nowtime && $t['etat'] == 1) {
$etat5 = '<span style="color:#D64242;">est absent(e) jusqu\'au '.$date_jusqua.'</span>';
} else {
$etat5 = '';
}
?>
<table class="modo">
    <tbody>
        <tr> 
            <td valign="middle" width="10" height="60"> 
            <a href="<?PHP echo $url ?>/info?pseudo=<?PHP echo $s['username'] ?>" title="Aller sur son profil &raquo;" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)"><div style="width: 64px; height: 70px; margin-bottom:-10px; margin-top:-15px; margin-left: -15px; float: right; background: url(https://avatar.myhabbo.fr/?figure=<?PHP echo Secu($s['look']);?>&action=sit&direction=2&head_direction=3&gesture=sml&size=b&img_format=gif);"></div></a>
            </td> 
            <td valign="top"> 
			 <span style="color:#D64242;"><b style="font-size: 110%;" title="Poste(s) occupé(s): <?PHP $infe = $bdd->query("SELECT * FROM gabcms_postes WHERE user_id = '".$s['id']."'");
while($rt = $infe->fetch()) { 
			$correct = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '".$rt['poste']."'");
			$caz = $correct->fetch(); 
			if($s['gender'] == "M") { ?> <?PHP echo stripslashes(Secu($caz['nom_M']))?>, <?PHP } if($s['gender'] == "F") { ?><?PHP echo stripslashes(Secu($caz['nom_F']))?>, <?PHP } }?>" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)"><?PHP echo Secu($s['username'])?></span></b> <?PHP echo $etat5; ?> <?PHP echo $etat_modif; ?> <br />
                         <span style="color:#888"><b>Mission:</b> <?PHP echo stripslashes(Secu($s['motto']))?></span><br/> 
						<span style="color:#888"><b>Fonction:</b> <?PHP echo stripslashes(Secu($s['fonction']))?></span><br/>
				        <?PHP echo (($s['online'] == "1")? '<img src="'.$imagepath.'v2/images/online.gif"></td>': '<img src="'.$imagepath.'v2/images/offline.gif"></td>')?>
            </td>
        </tr>
    </tbody>
</table>
<?PHP }?>
</div></div></div> 

				
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