<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

	include("../config.php");
	$pagename = "Help Tool &raquo; Contact nous";
	
if(!isset($_SESSION['username']))
	{
		Redirect("".$url."/index");
	}
$id = Secu($_GET['id']);
$infr = $bdd->query("SELECT * FROM gabcms_contact WHERE id = '".$id."'");
$r = $infr->fetch();

if(isset($_POST['message'])) {
   $message = Secu($_POST['message']);	
      if($message != "" && $id != "" && $user['username'] == $r['pseudo'] && $r['resul'] < 6) {
        $insertn2 = $bdd->prepare("INSERT INTO gabcms_contact_info (contact_id,message,date,ip) VALUES (:id, :message, :date, :ip)");
            $insertn2->bindValue(':id', $r['id']);
            $insertn2->bindValue(':message', '<b>Message de '.$user['username'].' :</b> '.$message.'');
            $insertn2->bindValue(':date', FullDate('full').' :');
            $insertn2->bindValue(':ip', $user['ip_current']);
        $insertn2->execute();
        $bdd->query("UPDATE gabcms_contact SET resul_par='".$user['username']."' WHERE id = '".$id."'");	
	if($r['resul'] == 3) {
	$bdd->query("UPDATE gabcms_contact SET resul='4', resul_par='".$user['username']."' WHERE id = '".$id."'");		    
	}
	  $affichage = "<div id=\"ok\">
			Un commentaire a été émis avec succès
		</div>";
			} else {
				$affichage = "<div id=\"pasok\">
            Une erreur est surevenue, peut-être commentez-vous un ticket d'une autre personne...
		</div>";
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
</script>

<link rel="shortcut icon" href="<?PHP echo $imagepath; ?>favicon.ico" type="image/vnd.microsoft.icon" /> 
<script src="<?PHP echo $imagepath; ?>static/js/libs2.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath; ?>static/js/visual.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath; ?>static/js/libs.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath; ?>static/js/common.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath; ?>js/tooltip.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/tooltips.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<script src="<?PHP echo $imagepath; ?>static/js/fullcontent.js" type="text/javascript"></script>
<script type="text/javascript" src="<?PHP echo $imagepath; ?>editor/ckeditor.js"></script>
<script type="text/javascript" src="<?PHP echo $imagepath; ?>editor/config.js"></script>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/style.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/buttons.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/boxes.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/tooltips.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/personal.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
 <script language="javascript" type="text/javascript">
   function insert_texte(texte)
   {
       var ou = document.getElementsByName("message")[0];
       var phrase = texte +" ";
       ou.value += phrase;
       ou.focus();
   }
</script>
<script src="<?PHP echo $imagepath; ?>static/js/habboclub.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/minimail.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/myhabbo/control.textarea.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/newcredits.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<script src="<?PHP echo $imagepath; ?>static/js/minimail.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?PHP echo $url; ?>/service_client/css/index.css<?php echo '?'.mt_rand(); ?>" type="text/css" />


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
<div id="haut">Commentes ton sujet</div>
	<div id="mil"><center><?PHP if(isset($affichage)) { echo "<br>".$affichage.""; } ?></center><br><br>
Commentes une réponse de ton ticket.<br><br>
<a href="#" onclick="insert_texte(';)')"><img src="<?PHP echo $imagepath; ?>smileys/clindoeil.gif"/></a>
<a href="#" onclick="insert_texte(':$')"><img src="<?PHP echo $imagepath; ?>smileys/embarrase.gif"/></a>
<a href="#" onclick="insert_texte(':o')"><img src="<?PHP echo $imagepath; ?>smileys/etonne.gif"/></a>
<a href="#" onclick="insert_texte(':)')"><img src="<?PHP echo $imagepath; ?>smileys/happy.gif"/></a>
<a href="#" onclick="insert_texte(':x')"><img src="<?PHP echo $imagepath; ?>smileys/icon_silent.png"/></a>
<a href="#" onclick="insert_texte(':p')"><img src="<?PHP echo $imagepath; ?>smileys/langue.gif"/></a>
<a href="#" onclick="insert_texte(':\'(')"><img src="<?PHP echo $imagepath; ?>smileys/sad.gif"/></a>
<a href="#" onclick="insert_texte(':D')"><img src="<?PHP echo $imagepath; ?>smileys/veryhappy.gif"/></a>
<a href="#" onclick="insert_texte(':jap:')"><img src="<?PHP echo $imagepath; ?>smileys/jap.png"/></a>
<a href="#" onclick="insert_texte('8)')"><img src="<?PHP echo $imagepath; ?>smileys/cool.gif"/></a>
<a href="#" onclick="insert_texte(':rire:')"><img src="<?PHP echo $imagepath; ?>smileys/rire.gif"/></a>
<a href="#" onclick="insert_texte(':evil:')"><img src="<?PHP echo $imagepath; ?>smileys/icon_evil.gif"/></a>
<a href="#" onclick="insert_texte(':twisted:')"><img src="<?PHP echo $imagepath; ?>smileys/icon_twisted.gif"/></a>
<a href="#" onclick="insert_texte(':rool:')"><img src="<?PHP echo $imagepath; ?>smileys/roll.gif"/></a>
<a href="#" onclick="insert_texte(':|')"><img src="<?PHP echo $imagepath; ?>smileys/neutre.gif"/></a>
<a href="#" onclick="insert_texte(':suspect:')"><img src="<?PHP echo $imagepath; ?>smileys/suspect.gif"/></a>
<a href="#" onclick="insert_texte(':no:')"><img src="<?PHP echo $imagepath; ?>smileys/no.gif"/></a>
<a href="#" onclick="insert_texte(':coeur:')"><img src="<?PHP echo $imagepath; ?>smileys/coeur.gif"/></a>
<a href="#" onclick="insert_texte(':hap:')"><img src="<?PHP echo $imagepath; ?>smileys/hap.gif"/></a>
<a href="#" onclick="insert_texte(':bave:')"><img src="<?PHP echo $imagepath; ?>smileys/bave.gif"/></a>
<a href="#" onclick="insert_texte(':areuh:')"><img src="<?PHP echo $imagepath; ?>smileys/areuh.gif"/></a>
<a href="#" onclick="insert_texte(':bandit:')"><img src="<?PHP echo $imagepath; ?>smileys/bandit.gif"/></a>
<a href="#" onclick="insert_texte(':help:')"><img src="<?PHP echo $imagepath; ?>smileys/help.gif"/></a>
<a href="#" onclick="insert_texte(':buzz:')"><img src="<?PHP echo $imagepath; ?>smileys/buzz.gif"/></a>
<a href="#" onclick="insert_texte(':contrat:')"><img src="<?PHP echo $imagepath; ?>smileys/contrat.gif"/></a>
<a href="#" onclick="insert_texte(':favo:')"><img src="<?PHP echo $imagepath; ?>smileys/pour.gif"/></a>
<a href="#" onclick="insert_texte(':contre:')"><img src="<?PHP echo $imagepath; ?>smileys/contre.gif"/></a>
<form name='editor' method='post' action="#">
<input type='text' name='message' value='' placeholder='Ecris ton message...' class='text' style='width: 240px'>
<input type='submit' name='submit' value='Commenter' class='submit'></form></div>


		<div id="bas"><a href="<?PHP echo $url ?>/service_client/tickets">Revenir sur mes tickets</a></div></div>

</body>
</html>