<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|           GabCMS - Site Web et Content Management System               #|
#|         Copyright © 2012-2015 - Gabodd Tout droits réservés.           #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

	include("./config.php");
	$pagename = "Bienvenue !";
	$pageid = "disclaimer";
		
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
document.habboLoggedIn = false;
var habboName = "null";
var habboReqPath = "<?PHP echo $url;?>";
var habboStaticFilePath = "<?PHP echo $imagepath;?>";
var habboImagerUrl = "<?PHP echo $url;?>/habbo-imaging/";
var habboPartner = "";
var habboDefaultClientPopupUrl = "<?PHP echo $url;?>/client";
window.name = "habboMain";
if (typeof HabboClient!= "undefined") { HabboClient.windowName = "uberClientWnd"; }
</script> 



<link rel="shortcut icon" href="<?PHP echo $imagepath;?>favicon.ico" type="image/vnd.microsoft.icon" /> 


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

<script type="text/javascript"> 
var andSoItBegins = (new Date()).getTime();
</script> 

<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/process.css" type="text/css" />

<script src="<?PHP echo $imagepath;?>static/js/libs2.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath;?>static/js/visual.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath;?>static/js/libs.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath;?>static/js/common.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath;?>static/js/fullcontent.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath;?>js/tooltip.js" type="text/javascript"></script>

<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/style.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/buttons.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/boxes.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/tooltips.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/changepassword.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/process.css" type="text/css" />
 
<body id="intermediate" class="process-template"> 
<div id="tooltip"></div>
<div id="overlay"></div> 

<div id="container"> 
	<div class="cbb process-template-box clearfix"> 
		<div id="content" class="wide">

		  
					<div id="header" class="clearfix"> 
						<h1><a href="<?PHP echo $url;?>"></a></h1> 
<ul class="stats">

<li class="stats-online">&nbsp;</li>
<li class="stats-visited"><img src="<?PHP echo $imagepath;?>v2/images/online.gif"></li>


</ul>

					</div> 
			
	        	<div id="terms" class="box-content"> 
<div class="tos-header"><center><size="+1"><b></b></size></center></div> 
			<div id="process-content"> 
	        	<div id="terms" class="box-content"> 
<div class="tos-header"><center><size="+1"><b></b></size></center></div> 
 <div class="rounded rounded-blue"> 
    	
<BIG><center><b>Quelques petites règles</center></b></BIG>            
	 </div> 
<div class="tos-item">

<p><u><i><h3>Ce que tu ne peux pas faire:</h3></i></u>
<br />
<span style="color: rgb(255, 102, 0);"><b>*</b> Harceler, arnaquer ou insulter d'autres utilisateurs: évite les comportements racistes, violents ou aggressifs. </span><br />

<span style="color: rgb(128, 0, 128);"><b>*</b> Voler le mot de passe, l'argent ou les meubles d'autres utilisateurs. </span><br />

<span style="color: rgb(0, 255, 0);"><b>*</b> Donner ton mot de passe, adresse électronique ou toute autre information personnelle qui permettrait de te localiser toi ou d'autres utilisateurs dans la vie réelle ou demander ces informations aux autres joueurs. </span><br />

<span style="color: rgb(255, 0, 0);"><b>*</b> Donner, échanger, vendre tes mobiliers ou ton compte utilisateur contre de l'argent. </span><br />

<span style="color: rgb(102, 102, 153);"><b>*</b> Prendre part dans des activités sexuelles, faire des propostitions sexuelles ou y répondre. </span><br />

<span style="color: rgb(255, 204, 0);"><b>*</b> Faire la promotion ou utiliser des programmes de piratage, de scripting dans <?PHP echo $sitename;?>.</span><br />
<span style="color: rgb(255, 0, 255);"><span><b>*</b> Faire la publicité d'un autre serveur privé Habbo.</span><br />

</span><br />
<p style="text-align: center;"><br/><img src="<?PHP echo $imagepath; ?>v2/images/rules.gif" align="center"/><br/><br/><b><font color="black">Agit avec les autres utilisateurs comme tu voudrais qu'ils agissent avec toi.</b><br/> Et rappelle toi qu'un crime dans le monde virtuel est aussi sérieux qu'un crime dans le monde réel. <br/>Merci de contacter un modérateur en cas de besoin.<br/><br/><u>Rappel:</u> Les utilisateurs ne respectant pas ces r&egrave;gles se verront exclu du site.</b></font></p>
<a id="save-button" class="new-button green-button save-icon" href="<?PHP echo $url;?>/securite"><b><span></span>C'est parti</b><i></i></a> 
            	</div> 
 
<script type="text/javascript"> 
if (typeof HabboView!= "undefined") {
	HabboView.run();
}
</script> 
<!--[if lt IE 7]>
<script type="text/javascript">
Pngfix.doPngImageFix();
</script>
<![endif]--> 
 
 
 
<div style="clear: both;"></div> 
 
 
</div></div></div></div>
 
<script type="text/javascript"> 
HabboView.run();

</script>

</body> 
</html>