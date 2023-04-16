<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|           GabCMS - Site Web et Content Management System               #|
#|         Copyright © 2012-2014 - Gabodd Tout droits réservés.           #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

	include("./config.php");
	$pagename = "Hôtel"; 
	
if(!isset($_SESSION['username']))
	{
		Redirect("".$url."/index");
	}
	
$sql = $bdd->query("SELECT * FROM gabcms_client WHERE id = '1'");
$client = $sql->fetch(PDO::FETCH_ASSOC);
$sql2 = $bdd->query("SELECT * FROM gabcms_config WHERE id = '1'");
$cof = $sql2->fetch(PDO::FETCH_ASSOC);

if($client['emulateur'] == 'phoenix') { $ticket = TicketRefresh($user['id']); }
elseif($client['emulateur'] == 'butterfly') { $ticket = UpdateSSO($user['id']); }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
<head> 
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

<title><?PHP echo $sitename;?> &raquo; <?PHP echo $pagename;?></title> 
  <script src="https://unpkg.com/@ruffle-rs/ruffle"></script>
 
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

<script src="<?PHP echo $imagepath; ?>static/js/fullcontent.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/style.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/buttons.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/boxes.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/tooltips.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/habboclient.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/habboflashclient.css" type="text/css" />
<script src="<?PHP echo $imagepath; ?>static/js/habboflashclient.js" type="text/javascript"></script>

<meta name="description" content="<?PHP echo $description; ?>" /> 
<meta name="keywords" content="<?PHP echo $keyword; ?>" /> 
 
<!--[if IE 8]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/ie8.css" type="text/css" />
<![endif]--> 
<!--[if lt IE 8]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/ie.css" type="text/css" />
<![endif]--> 
<!--[if lt IE 7]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/ie6.css" type="text/css" />
<script src="<?PHP echo $imagepath; ?>static/js/pngfix.js" type="text/javascript"></script>
<script type="text/javascript">
try { document.execCommand('BackgroundImageCache', false, true); } catch(e) {}
</script>
 
<style type="text/css">
body { behavior: url(http://www.habbo.co.uk/js/csshover.htc); }
</style>
<![endif]--> 
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>static/styles/news.css" type="text/css" />
<script src="<?PHP echo $imagepath; ?>static/js/news.js" type="text/javascript"></script>
<meta name="build" content="<?PHP echo $build; ?> >> <?PHP echo $version ; ?>" /> 

</head> 
<?PHP if($cof['etat_client'] == '1' || $cof['etat_client'] == '3' && $cof['si3_debut'] < $nowtime && $cof['si3_fin'] < $nowtime) { ?>
<body id="client" class="flashclient"> 
<script type="text/javascript"> 
var habboDefaultClientPopupUrl = "<?PHP echo $url; ?>/client";
</script> 
 
<script type="text/javascript"> 

 <?php
function hexparse($int){
return "3".$int;
}
$ipbit = explode(".", $client['ip']);
$cd = chr(92).chr(120);
$crypt0 = "";
$bit0 = str_split($ipbit[0]);
foreach($bit0 as $number0){
$crypt0.= $cd.hexparse($number0);
}
$crypt1 = "";
$bit1 = str_split($ipbit[1]);
foreach($bit1 as $number1){
$crypt1.= $cd.hexparse($number1);
}
$crypt2 = "";
$bit2 = str_split($ipbit[2]);
foreach($bit2 as $number2){
$crypt2.= $cd.hexparse($number2);
}
$crypt3 = "";
$bit3 = str_split($ipbit[3]);
foreach($bit3 as $number3){
$crypt3.= $cd.hexparse($number3);
}
$point = $cd."2E";
$ipfinale = $crypt0.$point.$crypt1.$point.$crypt2.$point.$crypt3;
?>
var _CALLINFOS=["<?php echo $ipfinale; ?>"];

FlashExternalInterface.loginLogEnabled = true;
 
FlashExternalInterface.logLoginStep("web.view.start");
 
if (top == self) {
FlashHabboClient.cacheCheck();
}
var flashvars = {
"client.allow.cross.domain" : "1", 
"client.notify.cross.domain" : "0", 
"connection.info.host" : _CALLINFOS[0], 
"connection.info.port" : "<?PHP echo $client['port']; ?>", 
"site.url" : "<?PHP echo $url; ?>", 
"url.prefix" : "<?PHP echo $url; ?>", 
"client.reload.url" : "<?PHP echo $url; ?>/client_error", 
"client.fatal.error.url" : "<?PHP echo $url; ?>/client_error", 
"client.connection.failed.url" : "<?PHP echo $url; ?>/client_error", 
"external.hash" : "", 
"external.variables.txt" : "<?PHP echo $client['variable']; ?><?php echo '?'.mt_rand(); ?>", 
"external.texts.txt" : "<?PHP echo $client['texte']; ?><?php echo '?'.mt_rand(); ?>",
"external.override.texts.txt" : "https://swfs.bobbastar.fr/gamedata/external_flash_override_texts.txt<?php echo '?'.mt_rand(); ?>", 
"external.override.variables.txt" : "https://swfs.bobbastar.fr/gamedata/external_override_variables.txt<?php echo '?'.mt_rand(); ?>", 
"productdata.load.url" : "https://swfs.bobbastar.fr/gamedata/productdata.txt<?php echo '?'.mt_rand(); ?>", 
"furnidata.load.url" : "https://swfs.bobbastar.fr/gamedata/furnidata.txt<?php echo '?'.mt_rand(); ?>",
"hotelview.banner.url" : "https://swfs.bobbastar.fr/gamedata/banner.png",
"use.sso.ticket" : "1",
"sso.ticket" : "<?PHP echo $ticket; ?>", 
"processlog.enabled" : "0", 
"account_id" : "<?PHP echo $user['id']; ?>", 
"client.starting" : "<?PHP echo $client['loading_texte']; ?>", 
"flash.client.url" : "<?PHP echo $client['version']; ?>", 
"user.hash" : "", 
"has.identity" : "0", 
"flash.client.origin" : "popup" 
 };
    var params = {
        "base": "<?PHP echo $client['version']; ?>",
        "allowScriptAccess": "always",
        "menu": "false"                
    };
 
        if (!(HabbletLoader.needsFlashKbWorkaround())) {
            params["wmode"] = "opaque";
        }
 
    FlashExternalInterface.signoutUrl = "<?PHP echo $url; ?>/logout";
 
    var clientUrl = "<?PHP echo $client['swf']; ?>";
    swfobject.embedSWF(clientUrl, "flash-container", "100%", "100%", "10.0.0", "http://images.habbo.com/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/126/web-gallery/flash/expressInstall.swf", flashvars, params);
 
    window.onbeforeunload = unloading;
    function unloading() {
        var clientObject;
        if (navigator.appName.indexOf("Microsoft")!= -1) {
            clientObject = window["flash-container"];
        } else {
            clientObject = document["flash-container"];
        }
        try {
            clientObject.unloading();
        } catch (e) {}
    }
</script>  
 
<div id="overlay"></div>
<div id="client-ui" > 
<div id="flash-wrapper"> 
<div id="flash-container"> 
<div id="content" style="width: 400px; margin: 20px auto 0 auto; display: none"> 
<div class="cbb clearfix red"> 
<h2 class="title">Installer Adode Flash Player</h2> 
<div class="box-content"> 
<p>Pour installer Flash Player : <a href="http://get.adobe.com/flashplayer/">Clique ICI</a>. More instructions for installation can be found here: <a href="http://www.adobe.com/products/flashplayer/productinfo/instructions/">More information</a></p> 

<p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://images.habbo.com/habboweb/45_0061af58e257a7c6b931c91f771b4483/2/web-gallery/images/client/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p> 
</div> 
</div> 
</div> 
<script type="text/javascript"> 
$('content').show();
</script> 
<noscript> 
<div style="width: 400px; margin: 20px auto 0 auto; text-align: center"> 
<p>If you are not automatically redirected, please <a href="/client/nojs">click here</a></p> 
</div> 
</noscript> 
</div> 
</div> 
<div id="content" class="client-content"></div> 
</div> 
<div style="display: none"> 

<script language="JavaScript" type="text/javascript"> 
setTimeout(function(){
HabboCounter.init(600);
}, 20000);

</script> 
</div> 
<script type="text/javascript"> 
RightClick.init("flash-wrapper", "flash-container");
</script> 
<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>


</body> 
<?PHP } elseif($cof['etat_client'] == '2' || $cof['etat_client'] == '3' && $cof['si3_debut'] <= $nowtime && $cof['si3_fin'] >= $nowtime) { ?>
<body id="popup" class="process-template client_error">
<div id="tooltip"></div>
<div id="container">
    <div id="content">
	    <div id="process-content" class="centered-client-error">
	       	<div id="column1" class="column">
			     		
				<div class="habblet-container ">		
						<div class="cbb clearfix v3_darkblue_glow ">
	
							<h2 class="title">Fermé
							</h2>
						<script type="text/javascript">
    if (typeof HabboClient!= "undefined") {
        HabboClient.forceReload = true;
    }
</script>

<div class="box-content">
    <div class="info-client_error-text">
       <p>Oops, l'hôtel a été fermé par un fondateur de <?PHP echo $sitename; ?>. Actuellement, tu peux disposer du service client pour être au courant des nouveautés ou alors de voir si un article a été poster.</p>
       <p>Clique <a onclick="openOrFocusHabbo(this); return false;" target="client" href="<?PHP echo $url;?>/service_client/">ici</a> pour continuer. Nous sommes désolés de ce désagrément.</p>
    </div>
    <div class="retry-enter-hotel">
    <div class="hotel-open">
        <a id="enter-hotel-open-image" class="open" href="<?PHP echo $url;?>/service_client/" target="client" onclick="HabboClient.openOrFocus(this); return false;">
        <div class="hotel-open-image-splash"></div>
        <div class="hotel-image hotel-open-image"></div>
        </a>
        <div class="hotel-open-button-content">
          <a class="open" href="<?PHP echo $url;?>/moi" target="_blank" onclick="HabboClient.openOrFocus(this); return false;">REVENIR SUR LE SITE</a>
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
<?PHP } ?>
</html>