<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|           GabCMS - Site Web et Content Management System               #|
#|         Copyright © 2012-2014 - Gabodd Tout droits réservés.           #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

	include("./config.php");
	$pagename = "Conditions Générales d'Utilisations";
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
			<div id="process-content"> 
	        	<div id="terms" class="box-content"> 
<div class="tos-header"><center><size="+1"><b>CONDITIONS GÉNÉRALES D'UTILISATIONS</b></size></center></div> 
<div class="tos-item"><br /><br />
Bienvenue sur le site Internet <a href="<?PHP echo $url;?>"><?PHP echo $sitename;?></a> (ci-apr&egrave;s d&eacute;sign&eacute; le «Site» ou «Nous»).
<br /> <br />
<b>L’accès au Site et aux services proposés sont réservés aux personnes âgées de plus de 10 ans.<br/><br/>
Si vous avez moins de 18 ans, vous devez demander à vos parents ou tuteurs légaux de vous expliquer tous les termes ou expressions utilisés ci-dessous que vous ne comprenez pas et valider avec eux votre décision d'accepter l'ensemble des Conditions Générales d'Utilisations. <br/><br/>
1. Charges et résponsabilités de <?PHP echo $sitename;?><br/><br/>
1.1</b> <?PHP echo $sitename;?> n'est pas responsable de votre inscription sur ce site sâchant que <?PHP echo $sitename;?> n'est en aucun cas légal, celui-ci disponsant de ressources liées à Habbo Hotel©, marque déposée du groupe Sulake®. Nous ne sommes par ailleurs en aucun cas liés à ces différents groupes.
<br/><br/>
<b>1.2</b> Nous ne sommes pas tenus responsables de tout problème de paiement ou de transaction avec le service "VIP Club" ou tout autre service de la "Boutique <?PHP echo $sitename;?>". Aucun remboursement ne peut être effectué en cas de problème technique. Si jamais ça venait à arriver, demander comme même au créateur de l'hôtel.
<br/><br/>
<b>1.3</b> Toute arnaque de crédits, rares ou divers mobis n'est pas de notre responsabilité. En cas de ce genre ce problème nous ne sommes donc pas responsables. Si vous êtes victime de cette arnaque, rapportez l'individu en question afin que nos modérateurs étudient son cas.
<br/><br/>
<b>1.4</b> Ce CMS (l'interface des pages du site) est founi par GabCMS© qui n'est pas responsable des actes délibérés sur ce site ni nous. Chacun est maître de son personnage et donc responsable.
<br/><br/>
<b>2. Réglement de <?PHP echo $sitename;?><br/><br/>
2.1</b>  Ce que tu ne peux pas faire par exemple, insulter des joueurs quelconques ou bien leur demander leur identifiants de compte. Si les auteurs de ces faits sont retrouvés (ce qui est facile pour notre équipe de modération), une exclusion définitive sera prononcée sans avis préalable.
<br/><br/>
<b>2.2</b> Le flood dans un appart, publicité opportuniste envers un autre serveur est réprimé d'un "Bloque" ou d'un kick (Exclure) si un administrateur ou modérateur n'est pas présent sur les lieux. Si un administrateur ou un modérateur est présent, concernant la publicité elle est réprimée d'une exclusion définitive sans avis préalable et ip.
<br/><br/>
<b>2.3</b>  Les appels à l'aide inutiles à l'aide du "?" Jaune vers des modérateurs. Entre autre comme exemple, une demande d'aide à construire un poste de police... les Staffs ont des choses plus importantes à faire! Pensez à la priorité de votre demande d'aide avant d'envoyer. Ceci est donc pénalisé au départ d'un simple avertissement puis à la longue si cela se reproduit d'une exclusion temporaire du serveur.
<br/><br/>
<b>2.4</b> Les abus de commande des VIP ou staffs sont punis d'un dérank (ce qui signifie qu'on vous enlève vos droits) et d'un bannissement temporaire du serveur.
<br/><br/>
<b>2.5</b> Les utilisateurs nuisant au bon fonctionnement de l'hôtel, se verront bannis du site temporairement.
<br/><br/>
<b>2.6</b> Les utilisateurs pratiquant des activités sexuelles ou pornographiques sur le serveur se verront bannis du site définitivement. Le cyber-sexe n'est pas autorisé et peut être signalé aux autoritées compétentes.
<br/><br/>
Dernière mise à jour le: <b>29 mars 2014</b>
</div>
</div></div></div></div>
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
<!-- FOOTER -->
<?PHP include("./template/footer.php");?>
<!-- FIN FOOTER -->
<div style="clear: both;"></div>
</div>

 
<script type="text/javascript"> 
HabboView.run();

</script>
</body> 
</html>