<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

	include("./config.php");
	$pagename = "Tchat";
	$pageid = "tchat";
	
if(!isset($_SESSION['username']))
	{
		Redirect("".$url."/index");
	}
$captcha=rand(0,9999999);
if(isset($_POST['message'])) {
   $message = Secu($_POST['message']);
$captcha_verif = Secu($_POST['captcha_verif']);
$captcha_code = Secu($_POST['captcha_code']);
      if($message != "") {
		if($captcha_code == $captcha_verif) {
	        $insertn1 = $bdd->prepare("INSERT INTO gabcms_tchat (pseudo,message,ip,date,look,rank) VALUES (:pseudo,:message,:ip,:date,:look,:rank)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':message', Secu($_POST['message']));
            $insertn1->bindValue(':ip', $user['ip_current']);
            $insertn1->bindValue(':date', FullDate('full'));
            $insertn1->bindValue(':look', $user['look']);
            $insertn1->bindValue(':rank', $user['rank']);
            $insertn1->execute();
			$bdd->query("UPDATE users SET message = message - 1 WHERE id = '".$user['id']."'");
		    $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-green\"> 
              Ton message a été posté avec succès!
            </div> 
        </div> 
</div>";
			} else {
			$affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
               Merci de recopier le bon captcha
            </div> 
        </div> 
</div>";
			} } else {
			$affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
               Merci de marquer un message
            </div> 
        </div> 
</div>";
		} 
	}
$sql = $bdd->query("SELECT * FROM gabcms_config WHERE id = '1'") or die(mysql_error());;
$cof = $sql->fetch(PDO::FETCH_ASSOC);
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
 <script language="javascript" type="text/javascript">
   function insert_texte(texte)
   {
       var ou = document.getElementsByName("message")[0];
       var phrase = texte +" ";
       ou.value += phrase;
       ou.focus();
   }
</script>
<script src="<?PHP echo $imagepath;?>static/js/fullcontent.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/style.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/buttons.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/boxes.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/tooltips.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/personal.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<script src="<?PHP echo $imagepath;?>static/js/habboclub.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/minimail.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/myhabbo/control.textarea.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<script src="<?PHP echo $imagepath;?>static/js/minimail.js" type="text/javascript"></script>

 

<meta name="description" content="<?PHP echo $description;?>" /> 
<meta name="keywords" content="<?PHP echo $keyword;?>" />  
<!--[if IE 8]>
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/ie8.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<![endif]--> 
<!--[if lt IE 8]>
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/ie.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<![endif]--> 
<!--[if lt IE 7]>
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/ie6.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
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
<?php
if($user['message'] >= 2) {
$modifier_mes = "messages";
}
if($user['message'] == 1) {
$modifier_mes = "message, attention, tu ne pourras plus en poster après celui-ci";
}
if($user['message'] == 0) {
$modifier_mes = "message";
}
?>
Avant de poster un message, assure toi que:<br/>
&nbsp;&nbsp;&nbsp;- Tu ne pubs pas<br/>
&nbsp;&nbsp;&nbsp;- Tu ne flood pas<br/>
&nbsp;&nbsp;&nbsp;- Tu respectes la <?PHP echo $sitename;?> attitude<br/><br/>
Si tu respectes tout ça, tu peux poster ton message! En revanche, si tu ne respectes pas nos conditions, tes messages se verront supprimés et ton compte bannis.<br/><br/>
Tu peux encore poster <b><?php echo $user['message'];?></b> <?PHP echo $modifier_mes;?>.
<?PHP if(isset($affichage)) { echo "<br/>".$affichage.""; }?>
</div>
</div></div>
<div class="habblet-container">		
<div class="cbb clearfix red"><h2 class="title">Poster un message</h2> 
<div class="box-content">
<?php
if($user['message'] >= 1) {
$modifier_u = "<td width='100' class='tbl'><b>Message que tu souhaites poster:</b><br/></td><br/>
<a href=\"#\" onclick=\"insert_texte(';)')\"><img src=\"./web-gallery/smileys/clindoeil.gif\"/></a>
<a href=\"#\" onclick=\"insert_texte(':$')\"><img src=\"./web-gallery/smileys/embarrase.gif\"/></a>
<a href=\"#\" onclick=\"insert_texte(':o')\"><img src=\"./web-gallery/smileys/etonne.gif\"/></a>
<a href=\"#\" onclick=\"insert_texte(':)')\"><img src=\"./web-gallery/smileys/happy.gif\"/></a>
<a href=\"#\" onclick=\"insert_texte(':x')\"><img src=\"./web-gallery/smileys/icon_silent.png\"/></a>
<a href=\"#\" onclick=\"insert_texte(':p')\"><img src=\"./web-gallery/smileys/langue.gif\"/></a>
<a href=\"#\" onclick=\"insert_texte(':\'(')\"><img src=\"./web-gallery/smileys/sad.gif\"/></a>
<a href=\"#\" onclick=\"insert_texte(':D')\"><img src=\"./web-gallery/smileys/veryhappy.gif\"/></a>
<a href=\"#\" onclick=\"insert_texte(':jap:')\"><img src=\"./web-gallery/smileys/jap.png\"/></a>
<a href=\"#\" onclick=\"insert_texte('8)')\"><img src=\"./web-gallery/smileys/cool.gif\"/></a>
<a href=\"#\" onclick=\"insert_texte(':rire:')\"><img src=\"./web-gallery/smileys/rire.gif\"/></a>
<a href=\"#\" onclick=\"insert_texte(':evil:')\"><img src=\"./web-gallery/smileys/icon_evil.gif\"/></a>
<a href=\"#\" onclick=\"insert_texte(':twisted:')\"><img src=\"./web-gallery/smileys/icon_twisted.gif\"/></a>
<a href=\"#\" onclick=\"insert_texte(':rool:')\"><img src=\"./web-gallery/smileys/roll.gif\"/></a>
<a href=\"#\" onclick=\"insert_texte(':|')\"><img src=\"./web-gallery/smileys/neutre.gif\"/></a>
<a href=\"#\" onclick=\"insert_texte(':suspect:')\"><img src=\"./web-gallery/smileys/suspect.gif\"/></a>
<a href=\"#\" onclick=\"insert_texte(':no:')\"><img src=\"./web-gallery/smileys/no.gif\"/></a>
<a href=\"#\" onclick=\"insert_texte(':coeur:')\"><img src=\"./web-gallery/smileys/coeur.gif\"/></a>
<a href=\"#\" onclick=\"insert_texte(':hap:')\"><img src=\"./web-gallery/smileys/hap.gif\"/></a>
<a href=\"#\" onclick=\"insert_texte(':bave:')\"><img src=\"./web-gallery/smileys/bave.gif\"/></a>
<a href=\"#\" onclick=\"insert_texte(':areuh:')\"><img src=\"./web-gallery/smileys/areuh.gif\"/></a>
<a href=\"#\" onclick=\"insert_texte(':bandit:')\"><img src=\"./web-gallery/smileys/bandit.gif\"/></a>
<a href=\"#\" onclick=\"insert_texte(':help:')\"><img src=\"./web-gallery/smileys/help.gif\"/></a>
<a href=\"#\" onclick=\"insert_texte(':buzz:')\"><img src=\"./web-gallery/smileys/buzz.gif\"/></a>
<form name='editor' method='post' action=\"?do=ok\">
<td width='80%' class='tbl'><input type='text' name='message' id='message' class='text' style='width: 240px' title='Message que tu souhaites poster..' placeholder='Écris quelque chose..'  onmouseover='tooltip.show(this)' onmouseout='tooltip.hide(this)'><br/></td>
<br/>Recopie <b>".$captcha."</b> : <input type='text' name='captcha_code' id='message' class='text' size='7' title='Recopie le captcha exact' onmouseover='tooltip.show(this)' onmouseout='tooltip.hide(this)'><input type='hidden' name='captcha_verif' value='".$captcha."'><br/></td>
<tr>
<td align='center' colspan='2' class='tbl'>
<input type='submit' name='submit' value='Exécuter'></form>
</tr>";
}
if($user['message'] == 0) {
$modifier_u = "Tu ne peux pas poster de message, vu que tu n'as plus assez de \"Messages\". Pour en avoir plus, demande à un staff via le service client, ou achètes les via la boutique!";
}
?>
<?PHP echo $modifier_u;?>
</div></div></div> 
<div class="habblet-container">		
<div class="cbb clearfix orange"><h2 class="title">Légende</h2> 
<div class="box-content">
La légende pour la couleur des rank:<br/>
- Utilisateur: <b><span style="color:#FF8C00">Orange</span><br/></b>
- VIP: <b><span style="color:#B22222">Rouge foncé</span><br/></b>
- STAFF CLUB : <b><span style="color:#32CD32">Vert clair</span><br/></b>
- Membre de l'équipe: <b><span style="color:red">Rouge</span><br/></b>
</div></div></div></div>
<div id="column1" class="column"> 
<div class="habblet-container ">		
						<div class="cbb clearfix brown "><h2 class="title">Tchat</h2> 

 <div class="box-content">
<style>
table {
    background-color: #fff;
    font-size: 11px;
    padding: 4px; 
    margin-left: -15px;
    width: 105%;
}
table:nth-child(2n+1) {
    background-color: #fffcaf;
    font-size: 11px;
    padding: 4px; 
    margin-left: -15px;
    width: 105%;
}
</style> 
<?php
$messagesParPage=$cof['nb_tchat']; 
$retour_total=$bdd->query('SELECT COUNT(*) AS total FROM gabcms_tchat');
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
$retour_messages=$bdd->query('SELECT * FROM gabcms_tchat ORDER BY id DESC LIMIT '.$premiereEntree.', '.$messagesParPage.'');
while($donnees_messages=$retour_messages->fetch(PDO::FETCH_ASSOC))
{

if($donnees_messages['rank'] == 1) {
$modifier_r = "#FF8C00";
}
if($donnees_messages['rank'] == 2) {
$modifier_r = "#B22222";
}
if($donnees_messages['rank'] == 3) {
$modifier_r = "#32CD32";
}
if($donnees_messages['rank'] >= 5 && $donnees_messages['rank'] <= 8) {
$modifier_r = "red";
}
if($donnees_messages['alert'] == 0) {
$alert = "#000000";
}
if($donnees_messages['alert'] == 1) {
$alert = "red";
}
if($donnees_messages['alert'] == 1) {
$alert_3 = "</b>";
}
if($donnees_messages['alert'] == 1) {
$alert_2 = "<b>";
}
if($donnees_messages['alert'] == 0) {
$alert_3 = "";
}
if($donnees_messages['alert'] == 0) {
$alert_2 = "";
}
if($donnees_messages['alert'] == 1) {
$alert_4 = "<span style=\"color:#FF0000\">ALERTE DE </span>";
}
if($donnees_messages['alert'] == 0) {
$alert_4 = "";
}
?>
<table>

            <tbody><tr> 
                    <td valign="middle" width="10" height="60"> 
                    <?PHP if($donnees_messages['pseudo'] != "") { ?><a href="<?PHP echo $url ?>/info?pseudo=<?PHP echo $donnees_messages['pseudo'] ?>" title="Aller sur son profil &raquo;" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)"><?PHP } ?><div style="width: 64px; height: 65px; margin-bottom:-9px; margin-top:-5px; margin-left: -5px; float: left; background: url(<?php echo $avatarimage; ?><?PHP echo $donnees_messages['look'] ?>&action=wav&direction=2&head_direction=2&gesture=sml&size=big&img_format=gif);"></div></a>
					</td> 
                    <td valign="top">
                      <b style="font-size: 13px;"><?PHP echo $alert_4 ?><span style="color:<?PHP echo $modifier_r ?>;"><?PHP echo $donnees_messages['pseudo'] ?></span></b><span style="float: right; color:#000000;font-size: 11px;"><?PHP echo $donnees_messages['date'] ?></span><br/>
                         <div id="cta_01"></div><div id="cta_02"><span style="color:<?PHP echo $alert ?>;font-size: 11px;"><?PHP echo $alert_2 ?><?PHP echo smileys($donnees_messages['message']) ?><?PHP echo $alert_3 ?></span></div><div id="cta_03"></div>
                    </td></tr></tbody> 

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
          echo ' <a href="tchat?page='.$i.'">'.$i.'</a> ';
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