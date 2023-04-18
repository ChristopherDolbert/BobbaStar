<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|

#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

	include("./config.php");
	$pagename = "Flux";
	$pageid = "flux";
	
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
<body id="home"> 
<div id="tooltip"></div>
<div id="overlay"></div> 
<!-- MENU -->
<?PHP include("./template/header.php");?>
<!-- FIN MENU -->
<div id="container"> 
<div id="content" style="position: relative" class="clearfix"> 
<div id="column2" class="column"> 
<div class="habblet-container">		
<div class="cbb clearfix blue"><h2 class="title">Quelques infos</h2> 
<div class="box-content">
Les flux t'affichent des informations diverses. Quand tu reçois une alerte, un code jetons ou encore une réponse à un poste vacant. Ici sont affichés tes 15 derniers flux.
</div>
</div></div></div>
<div id="column1" class="column"> 
<div class="habblet-container ">		
						<div class="cbb clearfix green"><h2 class="title">Flux</h2> 

 <div class="box-content"> 
<style>
table {
    background-color: #fff;
    font-size: 11px;
    padding: 4px; 
    margin-left: -14px;
    width: 107%;
}
table:nth-child(2n+1) {
    background-color: #fffcaf;
    font-size: 11px;
    padding: 4px; 
    margin-left: -14px;
    width: 107%;
}
</style> 
<?php
$messagesParPage=15; 
$retour_total=$bdd->query('SELECT COUNT(*) AS total FROM gabcms_contact WHERE user_id = '.$user['id'].'');
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
$retour_messages=$bdd->query('SELECT * FROM gabcms_management WHERE user_id = '.$user['id'].' ORDER BY id DESC LIMIT '.$premiereEntree.', '.$messagesParPage.'');
        while($t = $retour_messages->fetch()) {
?>
<table>
    <tbody>
        <tr> 
            <td valign="middle" width="10" height="60"> 
            <?PHP if($t['auteur'] != 'Système') { ?><a href="<?PHP echo $url ?>/info.php?pseudo=<?PHP echo $t['auteur'] ?>" title="Aller sur son profil &raquo;" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)"><?PHP } ?><div style="width: 64px; height: 65px; margin-bottom:-15px; margin-top:-5px; margin-left: -5px; float: right; background: url(https://avatar.myhabbo.fr/?figure=<?PHP echo $t['look'] ?>&action=wav&direction=2&head_direction=2&gesture=sml&size=big&img_format=gif);"></div></a>
            </td> 
            <td valign="top">
                <span style="color:#333333;"><b style="font-size: 110%;"><?PHP echo $t['auteur'] ?></span></b><span style="float: right; color:#000000;"><?PHP echo $t['date'] ?></span><br/>
                <span style="color:#000000"><?PHP echo $t['message'] ?></span><br/>
            </td>
        </tr>
    </tbody> 
</table>
<?PHP } 

echo '<p align="center">Page: ';
for($i=1; $i<=$nombreDePages; $i++) 
{
     if($i==$pageActuelle) 
     {
         echo ' [ '.$i.' ] '; 
     }	
     else 
     {
          echo ' <a href="flux?page='.$i.'">'.$i.'</a> ';
     }
}
echo '</p>';
	?>
</div> 

					</div></div></div><script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script> 
<!--[if lt IE 7]>
<![endif]--> 
<!-- FOOTER -->
<?PHP include("./template/footer.php");?>
<!-- FIN FOOTER -->
<div style="clear: both;"></div>
</div></div>
<script type="text/javascript"> 
HabboView.run();
</script>
</body> 
</html> 