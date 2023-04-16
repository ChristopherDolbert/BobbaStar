<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|           GabCMS - Site Web et Content Management System               #|
#|         Copyright © 2012-2014 - Gabodd Tout droits réservés.           #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

	include("../config.php");
	$pagename = "Mon dossier personnel";
	$pageid = "dossier";
	
if(!isset($_SESSION['username']))
	{
		Redirect("".$url."/index");
	}
	if($user['rank'] < 4) {
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
var habboImagerUrl = "http://www.habbo.co.uk/habbo-imaging/";
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

 

<meta name="description" content="<?PHP echo $description; ?>" /> 
<meta name="keywords" content="<?PHP echo $keyword; ?>" />  
<!--[if IE 8]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>///v2/styles/ie8.css" type="text/css" />
<![endif]--> 
<!--[if lt IE 8]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>///v2/styles/ie.css" type="text/css" />
<![endif]--> 
<!--[if lt IE 7]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>///v2/styles/ie6.css" type="text/css" />
<script src="<?PHP echo $imagepath; ?>///static/js/pngfix.js" type="text/javascript"></script>
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
	<div id="content" style="position: relative" class="clearfix">
<div id="column2" class="column">
				<div class="habblet-container ">
						<div class="cbb clearfix green">

							<h2 class="title">Informations
							</h2>
						<div id="notfound-looking-for" class="box-content">
Salut <b><?PHP echo $user['username']; ?></b> ! Cette page te permet de percevoir les commentaires que tes supérieurs renseignent.
</div>


					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

</div>

<div id="column1" class="column">
				<div class="habblet-container ">
						<div class="cbb clearfix blue">

							<h2 class="title">Ton dossier
							</h2>
						<div id="notfound-looking-for" class="box-content">
						<?php
$messagesParPage=5; 
$retour_total=$bdd->query('SELECT COUNT(*) AS total FROM gabcms_dossier WHERE userid = '.$user['id'].'');
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
$retour_messages = $bdd->query("SELECT * FROM gabcms_dossier WHERE userid = '".$user['id']. "' ORDER BY id DESC");
        if($retour_messages->rowCount() == 0)
        {
            echo "<table width=\"107%\" style=\"font-size: 11px; padding: 4px; margin-left: -14px;\">

            <tbody><tr> 
                    <td valign=\"middle\" width=\"10\" height=\"60\">
			</td> 
                    <td valign=\"top\"><span style=\"color:#778899;\"><i>Aucun commentaire...</i></span><br/><br/>
			<div id=\"cta_01\"></div><div id=\"cta_02\"><span style=\"font-family: tahoma,arial,helvetica,sans-serif; color: #333333;\"><i>Tu n'as aucun commentaire pour le moment...</i></div><div id=\"cta_03\"></div>
</td></tr></tbody> 

</table>";
        }
        while($alert = $retour_messages->fetch()) {
?>
            <table width="107%" style="font-size: 11px;padding: 4px; margin-left: -14px;">

            <tbody><tr> 
                    <td valign="middle" width="10" height="60">
			<a href="<?PHP echo $url ?>/info.php?pseudo=<?PHP echo $alert['par'] ?>" title="Aller sur son profil &raquo;" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)"><div alt="<?PHP echo $alert['par']; ?>" style="width: 64px; height: 70px; margin-top:-10px; margin-left:-10px; float: right; background: url(https://avatar.myhabbo.fr/?figure=<?PHP echo $alert['look']; ?>&action=&direction=2&head_direction=2&gesture=0&size=1&img_format=gif);"></div></a>
			</td> 
                    <td valign="top"><span style="color:#008000; font-size:9px;"><?php echo $alert['date']; ?></span> par <span style="color:blue;"><b><?php echo stripslashes($alert['par']); ?> (<?php echo stripslashes($alert['poste']); ?>)</b></span> <img src="<?PHP echo $url; ?>/managements/img/dossier/<?PHP echo $alert['avis']; ?>.png" /><br/>
			<div id="cta_01"></div><div id="cta_02"><?php echo $alert['commentaire']; ?></div><div id="cta_03"></div>
			<br/><center>__________________________________</center><br/>
</td></tr></tbody> 

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
          echo ' <a href="mondossier?page='.$i.'">'.$i.'</a> ';
     }
}
echo '</p>';
	?>
</div>


					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
</div>
		</div>
				</div>
<!-- FOOTER -->
<?PHP include("../template/footer.php"); ?>
<!-- FIN FOOTER -->
</body>
</html>