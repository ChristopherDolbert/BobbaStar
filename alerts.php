<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

	include("./config.php");
	$pagename = "Mes alertes";
	$pageid = "alert";
	
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
var habboImagerUrl = "http://www.habbo.co.uk/habbo-imaging/";
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
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/newcredits.css" type="text/css" />
<script src="<?PHP echo $imagepath;?>static/js/minimail.js" type="text/javascript"></script>

 

<meta name="description" content="<?PHP echo $description;?>" /> 
<meta name="keywords" content="<?PHP echo $keyword;?>" />  
<!--[if IE 8]>
<link rel="stylesheet" href="<?PHP echo $imagepath;?>///v2/styles/ie8.css" type="text/css" />
<![endif]--> 
<!--[if lt IE 8]>
<link rel="stylesheet" href="<?PHP echo $imagepath;?>///v2/styles/ie.css" type="text/css" />
<![endif]--> 
<!--[if lt IE 7]>
<link rel="stylesheet" href="<?PHP echo $imagepath;?>///v2/styles/ie6.css" type="text/css" />
<script src="<?PHP echo $imagepath;?>///static/js/pngfix.js" type="text/javascript"></script>
<script type="text/javascript">
try { document.execCommand('BackgroundImageCache', false, true); } catch(e) {}
</script>
 
<style type="text/css">
body { behavior: url(http://www.habbo.com/js/csshover.htc); }
</style>
<![endif]--> 
<meta name="build" content="<?PHP echo $build;?> >> <?PHP echo $version;?>" /> 
</head>


	 
<body id="home"> 
<div id="tooltip"></div>
<div id="overlay"></div> 
<!-- MENU -->
<?PHP include("./template/header.php");?>
<!-- FIN MENU -->
<div id="container">
	<div id="content" style="position: relative" class="clearfix">
<div id="column2" class="column">
				<div class="habblet-container ">
						<div class="cbb clearfix green">

							<h2 class="title">Informations
							</h2>
						<div id="notfound-looking-for" class="box-content">
Salut <b><?PHP echo $user['username'];?></b>! Cette page te permet de percevoir les alertes de comportement, de contact, des réponses à tes candidatures ou à des événements que les staffs t'envoient.
</div>


					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

</div>

<div id="column1" class="column">
				<div class="habblet-container ">
						<div class="cbb clearfix blue">

							<h2 class="title">Tes alertes
							</h2>
						<div id="notfound-looking-for" class="box-content">
						<?php
        $gabcms_alertes = $bdd->query("SELECT * FROM gabcms_alertes WHERE userid = '".$user['id']. "' ORDER BY id DESC LIMIT 0,10");
        if($gabcms_alertes->rowCount() == 0) {
            echo "<p><img style=\"float: left;padding-right:2px;\" src=\"./web-gallery/v2/images/hotel.png\" alt=\"\" width=\"67\" height=\"118\" /></p>
Tu n'as pas encore d'alerte. Tu peux recevoir des alertes pour les cas suivants:<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Un administrateur veut te parler en privé.<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Tu as contacté le service client et ils te répondent via cet outil.<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Tu t'es mal comporté sur l'hôtel, un administrateur te prévient.<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Tu as postulé à un poste, les résultats te seront communiqués.</strong>";
        }

        while($alert = $gabcms_alertes->fetch()) {
?>
            <table width="107%" style="font-size: 11px;padding: 4px; margin-left: -14px;">

            <tbody><tr> 
                    <td valign="middle" width="10" height="60">
			<?PHP if($alert['par'] != 'Système') { ?><a href="<?PHP echo $url ?>/info.php?pseudo=<?PHP echo $alert['par'] ?>" title="Aller sur son profil &raquo;" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)"><?PHP } ?><div alt="<?PHP echo Secu($alert['par']);?>" style="width: 64px; height: 70px; margin-top:-10px; margin-left:-10px; float: right; background: url(https://avatar.myhabbo.fr/?figure=<?PHP echo $alert['look'];?>&action=&direction=2&head_direction=2&gesture=<?PHP echo $alert['action'];?>&size=1&img_format=gif);"></div></a>
			</td> 
                    <td valign="top"><span style="color:#778899;">Alerte envoyée le <u><?php echo Secu(stripslashes($alert['date']));?></u> par <b><?php echo Secu($alert['par']);?></b>.</span><br/>
					<span style="font-family: tahoma,arial,helvetica,sans-serif; color: #333333;">Sujet </span>: <b><?PHP echo stripslashes($alert['sujet']);?></b><br/><br/>
			<div id="cta_01"></div><div id="cta_02"><span style="font-family: tahoma,arial,helvetica,sans-serif; color: #333333;"><b><?php echo Secu(stripslashes($alert['par']));?></b>:</span> <?php echo $alert['alerte'];?></div><div id="cta_03"></div>
			<br/><br/><center>__________________________________</center><br/>
</td></tr></tbody> 

</table>
	<?PHP }?>		

</div>


					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
</div>
		</div>
				</div>
<!-- FOOTER -->
<?PHP include("./template/footer.php");?>
<!-- FIN FOOTER -->
</body>
</html>