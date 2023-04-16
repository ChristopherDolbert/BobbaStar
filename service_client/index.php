<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|           GabCMS - Site Web et Content Management System               #|
#|         Copyright © 2012-2014 - Gabodd Tout droits réservés.           #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

	include("../config.php");
	$pagename = "Help Tool";
	
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
	<title><?PHP echo $sitename; ?> &raquo; <?PHP echo $pagename; ?></title>

<script type="text/javascript">
var andSoItBegins = (new Date()).getTime();
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
<div id="haut">Bienvenue sur l'espace d'aide de <?PHP echo $sitename; ?> !</div>
	<div id="mil">Ici tu peux contacter les staffs de <?PHP echo $sitename; ?> pour des problèmes quelconque. Ses problèmes sont classés par catégorie : les voicis :<br><br>
	<span style="color : #FF0000;"><b>ATTENTION :</b> Tout fait et geste sur ce site est enregistré dans une base de données ! Si jamais tu abuses de cet outil, tu pourras être banni temporairement ou définitivement du site !</span><br/>
	<center>
          <a href="<?PHP echo $url; ?>/service_client/contact"><div id="contenu4">
          <hr/>
          Contacter l'équipe
          </div></a>
          <a href="<?PHP echo $url; ?>/service_client/sb"><div id="contenu5">
          <hr/>
          Signaler un bug
          </div></a> 
          <a href="<?PHP echo $url; ?>/service_client/autre"><div id="contenu6">
          <hr/>
           Autres Problèmes
          </div></a>
	</center>	
<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>Cet outil est gratuit et peut vous servir à communiquer avec les staffs de l'hôtel. Les staffs ont plusieurs solutions pour vous répondre :<br>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Via votre Email<br>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Via le ticket directement<br>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Via le système d'alerte.<br><br>
		<a id="save-button" class="new-button green-button save-icon" href="<?PHP echo $url ?>/service_client/tickets"><b><span></span>Voir mes tickets</b><i></i></a></div>
		<div id="bas"></div>
</body>
</html>