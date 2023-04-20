<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|

#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

	include("./config.php");
	$pagename = "Habbo Attitude";
	$pageid = "habbo_way";
	
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
<link rel="stylesheet" href="<?PHP echo $imagepath;?>static/styles/safety.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<script src="<?PHP echo $imagepath;?>static/js/minimail.js" type="text/javascript"></script>

 

<meta name="description" content="<?PHP echo $description;?>" /> 
<meta name="keywords" content="<?PHP echo $keyword;?>" />  
<!--[if IE 8]>
<link rel="stylesheet" href="http://images.habbo.com/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/1367/web-gallery/static/styles/ie8.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<![endif]-->
<!--[if lt IE 8]>
<link rel="stylesheet" href="http://images.habbo.com/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/1367/web-gallery/static/styles/ie.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<![endif]-->
<!--[if lt IE 7]>
<link rel="stylesheet" href="http://images.habbo.com/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/1367/web-gallery/static/styles/ie6.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<script src="http://images.habbo.com/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/1367/web-gallery/static/js/pngfix.js" type="text/javascript"></script>
<script type="text/javascript">
try { document.execCommand('BackgroundImageCache', false, true); } catch(e) {}
</script>

<style type="text/css">
body { behavior: url(/js/csshover.htc); }
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
                <div id="content" style="font-size:11px;position: relative" class="clearfix">
                    <div id="column1" class="column">

                        <div class="habblet-container ">		

                            <div id="habbo-way-content">
                                <table>
                                    <tr>
        <td><h4 class="right">Jouer </h4>
        Joue avec tes amis, crée tes jeux, déchire tout et fais plein de rencontres!
        </td>
            <td><img src="<?PHP echo $imagepath;?>images/habboway/page_0.png" alt="" /> <br /> </td>
            <td><h4 class="wrong">Tricher</h4>
            Les tricheurs ne font jamais long feu. Ils gâchent juste le plaisir des autres.
            </td>
        </tr>
        <tr>
        <td><h4 class="right">Chater </h4>
        Parle à tes amis, rencontre des nouveaux Habbos et fais-toi une tonne de nouveaux potes...et plus!
        </td>
            <td><img src="<?PHP echo $imagepath;?>images/habboway/page_1.png" alt="" /> <br /> </td>
            <td><h4 class="wrong">Troller</h4>
            Personne n'aime les trolls, même pas leur mère, et personne ne tolère les agressions.
            </td>
        </tr>
        <tr>
        <td><h4 class="right">Trouver ton âme s&oelig;ur</h4>
        Flirte, sors, tombe amoureux et rencontre peut-être ton âme s&oelig;ur... ou frère...
        </td>
            <td><img src="<?PHP echo $imagepath;?>images/habboway/page_2.png" alt="" /> <br /> </td>
            <td><h4 class="wrong">Cyber</h4>
            Le cybersexe est strictement interdit, les demandes de webcam entraîneront une sanction.
            </td>
        </tr>
        <tr>
			<td><h4 class="right">Aider </h4>
			Aide un inconnu, gagne un ami! Ou deux, ou trois. Tu ne sais jamais qui tu vas rencontrer!
			</td>
            <td><img src="<?PHP echo $imagepath;?>images/habboway/page_3.png" alt="" /> <br /> </td>
            <td><h4 class="wrong">Piéger</h4>
            Profiter des autres Habbos crée généralement un mauvais karma... Et des émeutes.
            </td>
        </tr>
        <tr>
        <td><h4 class="right">Créer </h4>
        Lâche ta créativité, plus fort qu'Andy Warhol sous caféine! Dépasse les limites du style et de la création! Sois le meilleur!
        </td>
            <td><img src="<?PHP echo $imagepath;?>images/habboway/page_4.png" alt="" /> <br /> </td>
            <td><h4 class="wrong">Coder</h4>
            Crée, ne copie pas! Prends exemple sur Ashlee Simpson.
            </td>
        </tr>
		<tr>
            <td><h4 class="right">Troquer</h4>
            Construis ton propre empire mobi en troquant comme un pro!
            </td>
            <td><img src="<?PHP echo $imagepath;?>images/habboway/page_5.png" alt="" /> <br /></td>
            <td><h4 class="wrong">Arnaquer</h4>
            Voler ne te rends pas riche, ça fait de toi un criminel. Et tu ne montres pas du tout le bon exemple.
            </td>
        </tr>
        <tr>
            <td><h4 class="right">Utilise le marché</h4>
            Si tu as du flaire pour les affaires, utilise le marché pour vendre tes Mobis et accumuler des Crédits. Plus tu en sais sur le monde de la finance, et plus tu réussiras sur Habbo.
            </td>
            <td><img src="<?PHP echo $imagepath;?>images/habboway/page_6.png" alt="" /> <br /></td>
            <td><h4 class="wrong">Vendre en échange d’argent réel</h4>
            Ne vend pas tes Mobis contre de l’argent réel. Il est très probable que tu perdes le tout dans un endroit pas très sûr. De plus, tu jetteras à la poubelle tous les efforts et le temps que tu as investi pour arriver là où tu es.
            </td>
        </tr>
   </table>
</div>
</div><script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
</div>
<script type="text/javascript">
HabboView.run();
</script>
<div id="column2" class="column">
</div>
<!-- FOOTER -->
<?PHP include("./template/footer.php");?>
<!-- FIN FOOTER -->
            </div>
        </div>
    </body>
</html>	