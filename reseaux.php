	<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|           GabCMS - Site Web et Content Management System               #|
#|         Copyright © 2012-2014 - Gabodd Tout droits réservés.           #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

	include("./config.php");
	$pagename = "Réseaux sociaux";
	$pageid = "rs";
	
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
<div id="content"> 
    <div id="column2" class="column"> 
		<div class="habblet-container" style="float:left; width: 385px;">		
			<div class="cbb clearfix blue"> 
				<h2 class="title"><span style="float: left;">Facebook</span> <span style="float: right; font-weight: normal; font-size: 75%;">Like-nous !</span></h2>
 <div class="box-content"> 
<img src="<?PHP echo $imagepath;?>v2/images/infos_facebook.png" align="left" style="padding-right:5px;">
<b>Facebook</b><br/>
Continue à discuter sur notre page Facebook. "AIME"-nous pour rester informé(e) des mises à jour, des nouveautés, des offres. Tu pourras aussi jouer, participer à des sondages et aller jeter un oeil à notre section Nostalgie et voir d'autres créations incroyables d'utilisateurs !<br/><br/>
<a href="https://www.facebook.com/<?PHP echo $compte_facebook;?>" target="_blank">https://facebook.com/<?PHP echo $compte_facebook;?></a>
<br/><br/><iframe src="http://www.facebook.com/plugins/like.php?href=https://facebook.com/<?PHP echo $compte_facebook;?>&layout=box_count&show_faces=true&width=65&action=like&font=arial&colorscheme=light&height=65" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:65px; height:65px; margin-top:3px;" allowTransparency="true"></iframe>
</div></div></div> 
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script> </div>
    <div id="column1" class="column"> 
		<div class="habblet-container" style="float:right; width: 385px;">		
			<div class="cbb clearfix blue" > 
				<h2 class="title" style="background-color:#51a5d5"><span style="float: left;">Twitter</span> <span style="float: right; font-weight: normal; font-size: 75%;">Follow-nous</span></h2>
 <div class="box-content"> 
<img src="<?PHP echo $imagepath;?>v2/images/infos_twitter.png" align="left" style="padding-right:5px;">
<b>Twitter</b><br/>
Joue les prolongations sur notre page Twitter. "SUIS"-nous pour tout savoir en temps réel des nouveautés, des offres et de tout autre contenu à ne pas manquer !<br/><br/>
<a href="https://twitter.com/<?PHP echo $compte_twitter;?>" target="_blank">https://twitter.com/<?PHP echo $compte_twitter;?></a>
<br/><br/><a href="https://twitter.com/<?PHP echo $compte_twitter;?>" class="twitter-follow-button" data-show-count="false" data-lang="fr" data-dnt="true">Suivre @<?PHP echo $compte_twitter;?></a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
</div></div></div> 
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script> </div>
<div id="column11" class="column">
<div class="habblet-container" id="okt" style="float:left; width: 770px;">        
<div class="cbb clearfix green">
<h2 class="title">Mail</h2>
<div class="habblet box-content">
Si tu n'as pas de compte, contact nous à cette adresse : <b><span style="color:#0000FF;"><?PHP echo $mail;?></span></b>
</div></div>
</div></div>
</div></div>

                <script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>            
<script type="text/javascript">
HabboView.run();
</script>  
  
</div>
<!-- FOOTER -->
<?PHP include("./template/footer.php");?>
<!-- FIN FOOTER -->
</body>
</html>