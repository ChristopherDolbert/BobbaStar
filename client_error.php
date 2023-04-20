<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

	include("./config.php");
	$pagename = "Oops!!";
	
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
</script>
<link rel="shortcut icon" href="<?PHP echo $imagepath;?>favicon.ico" type="image/vnd.microsoft.icon" /> 
<script src="<?PHP echo $imagepath;?>static/js/libs2.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath;?>static/js/prototype.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath;?>static/js/libs.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath;?>static/js/common.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath;?>js/tooltip.js" type="text/javascript"></script>

<link rel="stylesheet" href="<?PHP echo $imagepath;?>static/styles/process.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath;?>static/styles/habboflashclient.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath;?>static/styles/v3_habblet.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<script src="<?PHP echo $imagepath;?>static/js/habboflashclient.js" type="text/javascript"></script>
<link href='//fonts.googleapis.com/css?family=Ubuntu:400,700,400italic,700italic|Ubuntu+Medium' rel='stylesheet' type='text/css'>

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

<meta name="description" content="<?PHP echo $description;?>" /> 
<meta name="keywords" content="<?PHP echo $keyword;?>" />  
 
<meta name="build" content="<?PHP echo $build;?> >> <?PHP echo $version;?>" /> 
</head>

<body id="popup" class="process-template client_error">
<div id="tooltip"></div>
<div id="container">
    <div id="content">
	    <div id="process-content" class="centered-client-error">
	       	<div id="column1" class="column">
			     		
				<div class="habblet-container ">		
						<div class="cbb clearfix v3_darkblue_glow ">
	
							<h2 class="title">Oops!!
							</h2>
						<script type="text/javascript">
    if (typeof HabboClient!= "undefined") {
        HabboClient.forceReload = true;
    }
</script>

<div class="box-content">
    <div class="info-client_error-text">
       <p>Oops, l'hôtel a rencontré un problème. Pas de panique, nos techniciens vont résoudrent ça au plus vite.</p>
       <p>Merci de relancer <a onclick="openOrFocusHabbo(this); return false;" target="client" href="<?PHP echo $url;?>/client">l'hôtel</a> pour continuer. Nous sommes désolés de ce désagrément.</p>
    </div>
    <div class="retry-enter-hotel">
    <div class="hotel-open">
        <a id="enter-hotel-open-image" class="open" href="<?PHP echo $url;?>/client" target="client" onclick="HabboClient.openOrFocus(this); return false;">
        <div class="hotel-open-image-splash"></div>
        <div class="hotel-image hotel-open-image"></div>
        </a>
        <div class="hotel-open-button-content">
          <a class="open" href="<?PHP echo $url;?>/client" target="client" onclick="HabboClient.openOrFocus(this); return false;">ENTRER</a>
            <span class="open"></span>
        </div>
    </div>
    </div>
</div>	
					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
			 

</div>
<script type="text/javascript">
HabboView.run();
</script>
<div id="column2" class="column">
</div>
<!--[if lt IE 7]>
<script type="text/javascript">
Pngfix.doPngImageFix();
</script>
<![endif]-->
		</div>
    </div>
</div>

</body>
</html>