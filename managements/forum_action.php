<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

	include("../config.php");
	$pagename = "Actions &raquo; Topics ou commentaires signalés";
	$pageid = "forum_index";
	
if(!isset($_SESSION['username']))
	{
		Redirect("".$url."/index");
	}
	
	if($user['rank'] < 5) {
	Redirect("".$url."/managements/acces_interdit");	
	exit();
	}
	if($user['rank'] > 8) {              
	Redirect("".$url."/managements/acces_interdit");
	exit();
	}	

$id = Secu($_GET['id']);
if(isset($_GET['cloturer'])) {
$cloturer = Secu($_GET['cloturer']);
} if(isset($_GET['supprimer'])) {
$supprimer = Secu($_GET['supprimer']);
}

$infr = $bdd->query("SELECT * FROM gabcms_forum_signalement WHERE id = '".$id."'");
$r = $infr->fetch();
 $topic = $bdd->query("SELECT * FROM gabcms_forum_topic WHERE id = '".$r['id_topic']."'");
 $t = $topic->fetch();
 $categorie = $bdd->query("SELECT * FROM gabcms_forum_sous_categorie WHERE id = '".$r['id_categorie']."'");
 $c = $categorie->fetch();
   	$sql = $bdd->query("SELECT * FROM users WHERE id = '".$t['user_id']."'");
	$assoc = $sql->fetch(PDO::FETCH_ASSOC);
 $commentaire = $bdd->query("SELECT * FROM gabcms_forum_commentaires WHERE id = '".$r['id_commentaire']."'");
 $c = $commentaire->fetch();
   	$sqzel = $bdd->query("SELECT * FROM users WHERE id = '".$c['user_id']."'");
    $assoca = $sqzel->fetch(PDO::FETCH_ASSOC);
    if($r['etat'] != 1 && $r['dernier_etat'] != 2) {
        $bdd->query("UPDATE gabcms_forum_signalement SET etat = '1', dernier_etat = '1', action = '".$user['username']."' WHERE id = '".$id."'");	
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a pris en charge un signalement de '.$r['value'].' émis par <b>'.$r['signaler_par'].'</b> (ID : '.$id.')');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute();
}
if(isset($_GET['cloturer'])) {
     if($cloturer == "1") {
		$sqla = $bdd->query("SELECT * FROM users WHERE username = '".$r['signaler_par']."'");
		$assoc2 = $sqla->fetch(PDO::FETCH_ASSOC);
      if($cloturer == "1" && $r['etat'] == "1") {
		if($user['rank'] >= '5') {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a clôturé le signalement de '.$r['value'].' émis par <b>'.$r['signaler_par'].'</b> (ID : '.$id.')');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute();
			$bdd->query("UPDATE gabcms_forum_signalement SET etat = '2', dernier_etat = '2' WHERE id = '".$id."'");
        $insertn2 = $bdd->prepare("INSERT INTO gabcms_management (user_id, message, auteur, date, look) VALUES (:userid, :message, :user, :date, :look)");
            $insertn2->bindValue(':userid', $assoc2['id']);
            $insertn2->bindValue(':message', 'Je viens de traité ta demande concernant ton signalement de '.$r['value'].' sur un '.$r['value'].'. Des mesures ont été prises.');
            $insertn2->bindValue(':user', $user['username']);
            $insertn2->bindValue(':date', FullDate('full'));
            $insertn2->bindValue(':look', $user['look']);
        $insertn2->execute();
		    $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-green\"> 
              Le sujet a bien été clôturé
            </div> 
        </div> 
</div>";
		    } else {
			$affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
               Tu n'es pas administrateur pour clôturer le signalement.
            </div> 
        </div> 
</div>";
			} }  else {
			$affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
               Tu ne peux pas clôturer un sujet déjà clôturé.
            </div> 
        </div> 
</div>";
		}
	}
}
if(isset($_GET['supprimer'])) {
    if($supprimer == "1") {
      if($supprimer == "1" && $r['etat'] == "1" && $r['value'] == "topic") {
		if($user['rank'] >= '5') {
    $sqlb = $bdd->query("SELECT * FROM users WHERE username = '".$r['signaler_par']."'");
    $assoc3 = $sqlb->fetch(PDO::FETCH_ASSOC);
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a supprimé le topic de <b>'.$assoc['username'].'</b> ('.addslashes($t['titre']).')');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute();
        $insertn2 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn2->bindValue(':pseudo', $user['username']);
            $insertn2->bindValue(':action', 'a <b>clôturé automatiquement</b> le signalement de '.$r['value'].' émis par <b>'.$r['signaler_par'].'</b> (ID : '.$id.')');
            $insertn2->bindValue(':date', FullDate('full'));
        $insertn2->execute();
			$bdd->query("UPDATE gabcms_forum_signalement SET etat = '2', dernier_etat = '2' WHERE id = '".$id."'");
        $insertn3 = $bdd->prepare("INSERT INTO gabcms_management (user_id, message, auteur, date, look) VALUES (:userid, :message, :user, :date, :look)");
            $insertn3->bindValue(':userid', $assoc3['id']);
            $insertn3->bindValue(':message', 'Je viens de traité ta demande concernant ton signalement de '.$r['value'].' sur le topic de <b>'.$assoc['username'].'</b>. Des mesures ont été prises.');
            $insertn3->bindValue(':user', $user['username']);
            $insertn3->bindValue(':date', FullDate('full'));
            $insertn3->bindValue(':look', $user['look']);
        $insertn3->execute();    
        $insertn4 = $bdd->prepare("INSERT INTO gabcms_management (user_id, message, auteur, date, look) VALUES (:userid, :message, :user, :date, :look)");
            $insertn4->bindValue(':userid', $t['user_id']);
            $insertn4->bindValue(':message', 'Je viens de supprimé ton topic ('.addslashes($t['titre']).') car une personne nous l\'avait signalé.');
            $insertn4->bindValue(':user', $user['username']);
            $insertn4->bindValue(':date', FullDate('full'));
            $insertn4->bindValue(':look', $user['look']);
        $insertn4->execute();
			$bdd->query("DELETE FROM gabcms_forum_commentaires WHERE id_topic = ".$t['id']."");
			$bdd->query("DELETE FROM gabcms_forum_topic WHERE id = ".$t['id']."");
			$affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-green\"> 
              Le signalement a bien été clôturé et le topic supprimé
            </div> 
        </div> 
</div>";
		    } else {
			$affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
               Tu n'es pas administrateur pour clôturer le signalement.
            </div> 
        </div> 
</div>";
			} }  else {
			$affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
               Tu ne peux pas clôturer un signalement déjà clôturé.
            </div> 
        </div> 
</div>";
		}
	}
}
	
if(isset($_GET['supprimer'])) {
    if($supprimer == "2") {
      if($supprimer == "2" && $r['etat'] == "1" && $r['value'] == "commentaire") {
		if($user['rank'] >= '5') {
		$insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a supprimé le commentaire de <b>'.$assoca['username'].'</b>');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute();
        $insertn2 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn2->bindValue(':pseudo', $user['username']);
            $insertn2->bindValue(':action', 'a <b>clôturé automatiquement</b> le signalement de '.$r['value'].' émis par <b>'.$r['signaler_par'].'</b> (ID : '.$id.')');
            $insertn2->bindValue(':date', FullDate('full'));
        $insertn2->execute();
			$bdd->query("UPDATE gabcms_forum_signalement SET etat = '2', dernier_etat = '2' WHERE id = '".$id."'");
        $insertn3 = $bdd->prepare("INSERT INTO gabcms_management (user_id, message, auteur, date, look) VALUES (:userid, :message, :user, :date, :look)");
            $insertn3->bindValue(':userid', $assoc['id']);
            $insertn3->bindValue(':message', 'Je viens de traité ta demande concernant ton signalement de '.$r['value'].' sur le topic de <b>'.$assoc['username'].'</b>. Des mesures ont été prises.');
            $insertn3->bindValue(':user', $user['username']);
            $insertn3->bindValue(':date', FullDate('full'));
            $insertn3->bindValue(':look', $user['look']);
        $insertn3->execute();
			$bdd->query("UPDATE gabcms_forum_commentaires SET etat = '2' WHERE id = ".$c['id']."");
			$affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-green\"> 
              Le signalement a bien été clôturé et le commentaire supprimé.
            </div> 
        </div> 
</div>";
		    } else {
			$affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
               Tu n'es pas administrateur pour clôturer le signalement.
            </div> 
        </div> 
</div>";
			} }  else {
			$affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
               Tu ne peux pas clôturer un signalement déjà clôturé.
            </div> 
        </div> 
</div>";
		}
	}
}
if(isset($_GET['cloturer'])) {
    if($cloturer == "2") {
      if($cloturer == "2" && $r['etat'] == "1" && $r['value'] == "commentaire") {
		if($user['rank'] >= '5') {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a modéré le commentaire de <b>'.$assoca['username'].'</b> suite au signalement de <b>'.$r['signaler_par'].'</b> (ID : '.$id.')');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute();
        $insertn2 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn2->bindValue(':pseudo', $user['username']);
            $insertn2->bindValue(':action', 'a <b>clôturé automatiquement</b> le signalement de '.$r['value'].' émis par <b>'.$r['signaler_par'].'</b> (ID : '.$id.')');
            $insertn2->bindValue(':date', FullDate('full'));
        $insertn2->execute();
			$bdd->query("UPDATE gabcms_forum_signalement SET etat = '2', dernier_etat = '2' WHERE id = '".$id."'");
        $insertn3 = $bdd->prepare("INSERT INTO gabcms_management (user_id, message, auteur, date, look) VALUES (:userid, :message, :user, :date, :look)");
            $insertn3->bindValue(':userid', $assoc['id']);
            $insertn3->bindValue(':message', 'Je viens de traité ta demande concernant ton signalement de '.$r['value'].' sur le topic de <b>'.$assoc['username'].'</b>. Des mesures ont été prises.');
            $insertn3->bindValue(':user', $user['username']);
            $insertn3->bindValue(':date', FullDate('full'));
            $insertn3->bindValue(':look', $user['look']);
        $insertn3->execute();
			$bdd->query("UPDATE gabcms_forum_commentaires SET texte = '<span style=\"color:#B5B5B5;\"><i>Ce message a été modéré.</i></span>' WHERE id = '".$c['id']."'");
		    $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-green\"> 
              Le commentaire a bien été modéré.
            </div> 
        </div> 
</div>";
		    } else {
			$affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
               Tu n'es pas administrateur pour modérer le signalement.
            </div> 
        </div> 
</div>";
			} }  else {
			$affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
               Tu ne peux pas modérer un commentaire déjà modéré.
            </div> 
        </div> 
</div>";
		}
	}
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
<script src="<?PHP echo $imagepath; ?>js/tooltip.js" type="text/javascript"></script>
<style>
#raison{
background-color:#cecece;
-webkit-box-shadow:0 0 20px rgba(0, 0, 0, 0.5);
box-shadow:0 1px 0 #fff, 0 2px 3px rgba(0, 0, 0, 0.5) inset;
-webkit-border-radius:5px;
-moz-border-radius:5px;
border-radius:5px;
padding:7px;
text-shadow:rgba(255, 255, 255, 0.5) 0 1px 0;
}
#ticket{
background-color:#FFFFFF;
-webkit-box-shadow:0 0 20px rgba(176, 196, 222, 0.5);
box-shadow:0 1px 0 #fff, 0 2px 3px rgba(176, 196, 222, 0.5) inset;
-webkit-border-radius:5px;
-moz-border-radius:5px;
border-radius:5px;
padding:7px;
text-shadow:rgba(255, 255, 255, 0.5) 0 1px 0;
}
</style>
<script src="<?PHP echo $imagepath; ?>static/js/fullcontent.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/style.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/buttons.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/boxes.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/tooltips.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/personal.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<script src="<?PHP echo $imagepath; ?>static/js/habboclub.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/minimail.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/myhabbo/control.textarea.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<script src="<?PHP echo $imagepath; ?>static/js/minimail.js" type="text/javascript"></script> 
<script language="javascript">
function newPopup(url, name_page)
{
window.open (url, name_page, config='height=300, width=700, toolbar=no, menubar=no, scrollbars=yes, resizable=no, location=no, directories=no, status=no');
}
</script>
<meta name="description" content="<?PHP echo $description; ?>" /> 
<meta name="keywords" content="<?PHP echo $keyword; ?>" />  
<!--[if IE 8]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/ie8.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<![endif]--> 
<!--[if lt IE 8]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/ie.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<![endif]--> 
<!--[if lt IE 7]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/ie6.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
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

<body id="home"> 
<div id="tooltip"></div>
<div id="overlay"></div> 
<!-- MENU -->
<?PHP include("../template/header.php"); ?>
<!-- FIN MENU -->
<div id="container"> 
<div id="content" style="position: relative" class="clearfix">
<div id="column2" class="column"> 
<div class="habblet-container">        
<div class="cbb clearfix green"><h2 class="title">Informations</h2> 
 <div class="box-content"> 
Salut <b><?php echo $username; ?></b>,<br/>
Tu es sur le point d'effectuer une action sur un signalement émis depuis le forum par des utilisateurs.<br/><br/>
<a href="<?PHP echo $url; ?>/managements/forum_index">Revenir au dépôt</a>
</div></div></div><script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script> 
<div class="habblet-container">        
<div class="cbb clearfix hcred"><h2 class="title">Actions</h2> 
 <div class="box-content"> 
<?PHP if($r['value'] == 'topic') { ?>
Pour ce ticket, voici les actions possibles :<br/>
- <a href="<?PHP echo $url ?>/forum/topic?id=<?PHP echo $r['id_categorie'] ?>&topic=<?PHP echo $r['id_topic'] ?>" target="_blank">Aller sur le topic</a><br/>
- <a href="#" onclick="newPopup('<?PHP echo $url ?>/managements/forum_modif_topic?modif=<?PHP echo $t['id']; ?>&signalement=<?PHP echo $r['id'] ?>', 'Modifier un topic');return false;">Modifier</a><br/>
- <a href="#" onclick="newPopup('<?PHP echo $url ?>/managements/forum_banuser?pseudo=<?PHP echo $assoc['username']; ?>&signalement=<?PHP echo $r['id'] ?>', 'Bannir suite à un topic');return false;">Bannir</a><br/>
- <a href="#" onclick="newPopup('<?PHP echo $url ?>/managements/forum_useralert?pseudo=<?PHP echo $assoc['username']; ?>&signalement=<?PHP echo $r['id'] ?>', 'Envoyer une alerte suite à un topic');return false;">Envoyer une alerte</a><br/>
- <a href="<?PHP echo $url ?>/managements/forum_action?id=<?PHP echo $r['id'] ?>&supprimer=1" onclick="return confirm('Si tu supprimes ce topic, le signalement sera automatiquement traité. Es-tu certain de continuer ?')">Supprimer</a><br/>
- <a href="<?PHP echo $url ?>/managements/forum_action?id=<?PHP echo $r['id'] ?>&cloturer=1">Clôturer le signalement</a><br/>
<?PHP } ?>
<?PHP if($r['value'] == 'commentaire') { ?>
Pour ce commentaire, voici les actions possibles :<br/>
- <a href="<?PHP echo $url ?>/managements/forum_action?id=<?PHP echo $r['id'] ?>&cloturer=2" onclick="return confirm('Si tu modères ce commentaire, le signalement sera automatiquement traité. Es-tu certain de continuer ?')">Modérer</a><br/>
- <a href="#" onclick="newPopup('<?PHP echo $url ?>/managements/forum_banuser?pseudo=<?PHP echo $assoca['username']; ?>&signalement=<?PHP echo $r['id'] ?>', 'Bannir suite à un topic');return false;">Bannir</a><br/>
- <a href="#" onclick="newPopup('<?PHP echo $url ?>/managements/forum_useralert?pseudo=<?PHP echo $assoca['username']; ?>&signalement=<?PHP echo $r['id'] ?>', 'Envoyer une alerte suite à un topic');return false;">Envoyer une alerte</a><br/>
- <a href="<?PHP echo $url ?>/managements/forum_action?id=<?PHP echo $r['id'] ?>&supprimer=2" onclick="return confirm('Si tu supprimes ce commentaire, le signalement sera automatiquement traité. Es-tu certain de continuer ?')">Supprimer</a><br/>
- <a href="<?PHP echo $url ?>/managements/forum_action?id=<?PHP echo $r['id'] ?>&cloturer=1">Clôturer le signalement</a><br/>
<?PHP } ?>
<?PHP if(isset($affichage)) { echo $affichage; } ?>
</div></div></div></div><script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script> 
<div id="column1" class="column"> 
<div class="habblet-container">        
<div class="cbb clearfix brown"><h2 class="title">Signalement #<?PHP echo $r['id']; ?></h2> 
 <div class="box-content"> 
<?PHP
$retour_messages = $bdd->query('SELECT * FROM gabcms_forum_signalement WHERE id = '.$id.'');
$a = $retour_messages->fetch();

if($a['value'] == 'topic') {
if($a['etat'] == 0) { $etat_modif = "<span style=\"color:#FF4500\"><b>Signalé</b></span>"; }
if($a['etat'] == 1) { $etat_modif = "<span style=\"color:#0000FF\"><b>Pris en charge</b></span>"; }
if($a['etat'] == 2) { $etat_modif = "<span style=\"color:#008000\"><b>Traité</b></span>"; }
 $topic = $bdd->query("SELECT * FROM gabcms_forum_topic WHERE id = '".$a['id_topic']."'");
 $t = $topic->fetch();
 $categorie = $bdd->query("SELECT * FROM gabcms_forum_sous_categorie WHERE id = '".$a['id_categorie']."'");
 $c = $categorie->fetch();
 $vraie_date = date('d/m/Y à H:i', $c['date']);
  	$sql = $bdd->query("SELECT * FROM users WHERE id = '".$t['user_id']."'");
	$assoc = $sql->fetch(PDO::FETCH_ASSOC);
?>
<table width="100%">
	<tbody>
		<tr>
	<td valign="top"><b>Signalement :</b><br/><br/>
					 Pseudo du signaleur : <b><?PHP echo Secu($a['signaler_par']); ?></b><br/>
					 Date : <b><?PHP echo Secu($a['signaler_le']); ?></b><br/>
					 Arguments :<br/>
	<div id="raison"><?PHP echo smileystaff(stripslashes($a['signaler_texte'])); ?></div><br/><hr/>
	<b>Topic :</b><br/><br/>
	Sujet : <b><?PHP echo $t['titre']; ?></b><br/>
	Catégorie : <b><?PHP echo $c['nom']; ?></b><br/>
	Créateur du topic : <b><?PHP echo $assoc['username'] ?></b><br/>
	Date : <b><?PHP echo $vraie_date ?></b><br/>
	Texte du topic :<br/>
	<div id="ticket"><?PHP echo smileystaff(stripslashes($t['texte'])); ?></div>
<br/><?PHP echo $etat_modif; ?></td></tr></tbody>
	</table>
<?PHP } if($a['value'] == 'commentaire') { 
$retour_messages = $bdd->query('SELECT * FROM gabcms_forum_signalement WHERE id = '.$id.'');
$a = $retour_messages->fetch();
if($a['etat'] == 0) { $etat_modif = "<span style=\"color:#FF4500\"><b>Signalé</b></span>"; }
if($a['etat'] == 1) { $etat_modif = "<span style=\"color:#0000FF\"><b>Pris en charge</b></span>"; }
if($a['etat'] == 2) { $etat_modif = "<span style=\"color:#008000\"><b>Traité</b></span>"; }

 $topic = $bdd->query("SELECT * FROM gabcms_forum_commentaires WHERE id = '".$a['id_commentaire']."'");
 $t = $topic->fetch();
 $categorie = $bdd->query("SELECT * FROM gabcms_forum_topic WHERE id = '".$a['id_topic']."'");
 $c = $categorie->fetch();
 $vraie_date = date('d/m/Y à H:i', $t['date']);
  	$sql = $bdd->query("SELECT * FROM users WHERE id = '".$t['user_id']."'");
	$assoc = $sql->fetch(PDO::FETCH_ASSOC);
?>
<table width="100%">
	<tbody>
		<tr>
	<td valign="top"><b>Signalement :</b><br/><br/>
					 Pseudo du signaleur : <b><?PHP echo Secu($a['signaler_par']); ?></b><br/>
					 Date : <b><?PHP echo Secu($a['signaler_le']); ?></b><br/>
					 Arguments :<br/>
	<div id="raison"><?PHP echo smileystaff(stripslashes($a['signaler_texte'])); ?></div><br/><hr/>
	<b>Commentaire :</b><br/><br/>
	Topic du commentaire : <b><?PHP echo Secu($c['titre']); ?></b><br/>
	Créateur du commentaire : <b><?PHP echo Secu($assoc['username']); ?></b><br/>
	Date : <b><?PHP echo $vraie_date ?></b><br/>
	Texte du commentaire :<br/>
	<div id="ticket"><?PHP echo smileystaff(stripslashes($t['texte'])); ?></div>
<br/><?PHP echo $etat_modif; ?></td></tr></tbody>
	</table>
<?PHP } ?>
</div> 

					</div></div></div><script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script> 
<!--[if lt IE 7]>
<![endif]--> 
<!-- FOOTER -->
<?PHP include("../template/footer.php"); ?>
<!-- FIN FOOTER -->
<div style="clear: both;"></div>
</div></div>
<script type="text/javascript"> 
HabboView.run();
</script>
</body> 
</html> 