<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         GabCMS - Site Web et Content Management System                 #|
#|         Copyright © 2013 Gabodd Tout droits réservés.                  #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

	include("../config.php");
	$pagename = "Forum";
	$pageid = "forum";
	
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
var ad_keywords = "";
document.habboLoggedIn = true;
var habboName = "<?PHP echo $user['username']; ?>";
var habboReqPath = "<?PHP echo $url; ?>";
var habboStaticFilePath = "<?PHP echo $imagepath; ?>";
var habboImagerUrl = "http://www.habbo.co.uk/habbo-imaging/";
var habboPartner = "";
var habboDefaultClientPopupUrl = "<?PHP echo $url; ?>/client";
window.name = "habboMain";
if (typeof HabboClient != "undefined") { HabboClient.windowName = "uberClientWnd"; }
</script> 

<link rel="shortcut icon" href="<?PHP echo $imagepath; ?>favicon.ico" type="image/vnd.microsoft.icon" /> 
<script src="<?PHP echo $imagepath; ?>static/js/libs2.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath; ?>static/js/visual.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath; ?>static/js/libs.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath;?>js/tooltip.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath; ?>static/js/common.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath; ?>static/js/fullcontent.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/style.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/buttons.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/boxes.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/tooltips.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/personal.css" type="text/css" />
<script src="<?PHP echo $imagepath; ?>static/js/habboclub.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/minimail.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/myhabbo/control.textarea.css" type="text/css" />
<script src="<?PHP echo $imagepath; ?>static/js/minimail.js" type="text/javascript"></script>


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
body { behavior: url(http://www.habbo.com/js/csshover.htc); }
</style>
<![endif]--> 
<meta name="build" content="<?PHP echo $build; ?> >> <?PHP echo $version; ?>" /> 
</head>
<div id="tooltip"></div>
<body id="home" class=" "> 
<div id="overlay"></div> 
<!-- MENU -->
<?PHP include("../template/header.php"); ?>
<!-- FIN MENU --> 
<div id="container">
<div id="content"> 
<div id="column1" class="column">     
<?PHP
$srl = $bdd->query("SELECT * FROM gabcms_forum_categorie ORDER BY id ASC");
while($s = $srl->fetch()) {
?>
<div class="habblet-container" id="okt" style="float:left; width: 770px;">       
<div class="cbb clearfix <?PHP echo Secu($s['couleur']); ?>">
<h2 class="title"><?PHP echo stripslashes($s['nom']); ?></h2>
<div class="habblet box-content">
<div>
<table>
<tbody>
<tr class="haut">
<td class="haut">Nom forum</td>
<td class="haut">Statistiques</td>
<td class="haut">Dernière activitée</td>
</tr>
<?php
 $donnes = $bdd->query("SELECT * FROM gabcms_forum_sous_categorie WHERE categorie_id = ".$s['id']." ORDER BY id ASC");
 while($a = $donnes->fetch()) {
			
	$select = $bdd->query("SELECT * FROM gabcms_forum_topic WHERE categorie_forum = '".$a['id']."' ORDER BY commentaire DESC LIMIT 0,1");
	$aok = $select->fetch();
	$queryjames = $bdd->query("SELECT COUNT(*) AS nombre FROM gabcms_forum_topic WHERE categorie_forum = ".$a['id']."");
	$nb_topic = $queryjames->fetch();
	$search = $bdd->query("SELECT * FROM gabcms_forum_lu WHERE id_topic = '".$aok['id']."' AND user_id = '".$user['id']."'");
	$ok = $search->fetch();
			if($ok['user_id'] != $user['id'] && $nb_topic['nombre'] != "0") {
			$modif = '<img src="'.$url.'/forum/img/message_anime.gif" />';
			} if($ok['user_id'] == $user['id'] || $nb_topic['nombre'] == "0") {
			$modif = '';
			}
?>
<tr class="bas">
<td class="bas"><span style="font-size:13px;"><b><a href="<?PHP echo $url; ?>/forum/topic?id=<?PHP echo Secu($a['id']); ?>"><?PHP echo stripslashes($a['nom']); ?> <?PHP echo $modif ?></a></b></span><br/>
<em><span style="color:#808080; font-size:10px;"><?PHP echo nl2br(stripslashes($a['description'])); ?></span></em></td>
<td class="bas"><?php $req = "SELECT COUNT(*) AS id FROM gabcms_forum_topic WHERE categorie_forum = ".$a['id']."";
$query = $bdd->query($req);
$nb_inscrit = $query->fetch();
if($nb_inscrit['id'] <= '1') {
echo $nb_inscrit['id'].' sujet';
} else {
echo $nb_inscrit['id'].' sujets';
}
?>, <?php 
$seelect = $bdd->query("SELECT * FROM gabcms_forum_topic WHERE categorie_forum = '".$a['id']."'");
$total = 0;
while($select = $seelect->fetch()){
$select_com = $bdd->query("SELECT * FROM gabcms_forum_commentaires WHERE id_topic = '".$select['id']."'");
$montotal = $select_com->rowCount();
$total += $montotal;
};
if($total <= '1') {
echo $total.' réponse';
} else {
echo $total.' réponses';
}
?></td>
<td class="bas"><?php
        $post = $bdd->query("SELECT * FROM gabcms_forum_topic WHERE categorie_forum = '".$a['id']."' ORDER BY commentaire DESC LIMIT 0,1");
        if($post->rowCount() == 0)
        {
            echo "<left><i>Aucun sujet.. Soit le premier!</i></left>";
        }
        while($p = $post->fetch()) {
?>
<a href="<?PHP echo $url; ?>/forum/topic?id=<?PHP echo Secu($p['categorie_forum']); ?>&topic=<?PHP echo Secu($p['id']); ?>"><b><?PHP echo stripslashes($p['titre']); ?></b></a><br/>
<?php
	$lastmsg = $bdd->query("SELECT * FROM gabcms_forum_commentaires WHERE id = '".$p['commentaire']."'");
	$lastmsgarray = $lastmsg->fetch();
	$lastcomment = $bdd->query("SELECT * FROM gabcms_forum_commentaires WHERE id_topic = '".$p['id']."'");
	$nbmsg = $lastcomment->rowCount();
	$vraie_date = date('d/m/Y à H:i', $p['date']);
	$sql = $bdd->query("SELECT * FROM users WHERE id = '".$p['user_id']."'");
	$assoc = $sql->fetch(PDO::FETCH_ASSOC);
	$vraie_date2 = date('d/m/Y à H:i', $lastmsgarray['date']);
	$sql2 = $bdd->query("SELECT * FROM users WHERE id = '".$lastmsgarray['user_id']."'");
	$assoc2 = $sql2->fetch(PDO::FETCH_ASSOC);
	if($nbmsg == 0){
	echo 'Par <b>'.$assoc['username'].'</b><br/>Le <i>'.$vraie_date.'</i>';
	} else {
	echo 'Par <b>'.$assoc2['username'].'</b><br/>Le <i>'.$vraie_date2.'</i>';
	};
?>
	<?PHP } ?></td>
		</tr>
<?PHP
}
?>
</tbody>
</table>
</div>

</div></div></div>
 <script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>     
 <?PHP } ?>
</div></div>     
<script type="text/javascript">
HabboView.run();
</script>  
  
</div>
<!-- FOOTER -->
<?PHP include("../template/footer.php"); ?>
<!-- FIN FOOTER -->
</body>
</html>