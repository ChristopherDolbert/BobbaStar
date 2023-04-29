<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

	include("../config.php");
	$pagename = "Help Tool &raquo; Signaler un bug";
	
if(!isset($_SESSION['username']))
	{
		Redirect("".$url."/index");
	}
if(isset($_POST['texte'])) {
   $texte = Secu($_POST['texte']);
   $sujet = Secu($_POST['sujet']);
      if($texte != "" && $sujet != "") {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (action,date) VALUES (:action, :date)");
            $insertn1->bindValue(':action', 'Une nouvelle demande d\'aide vient d\'arrivée au <b>Centre de Traitement des Aides</b>');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute();
		$insertn2 = $bdd->prepare("INSERT INTO gabcms_contact (sujet, pseudo, email, texte, date, categorie, ip, user_id) VALUES (:sujet, :pseudo, :email, :texte, :date, :categorie, :ip, :user_id)");
            $insertn2->bindValue(':sujet', $sujet);
            $insertn2->bindValue(':pseudo', $user['username']);
            $insertn2->bindValue(':email', $user['mail']);
            $insertn2->bindValue(':texte', addslashes($_POST['texte']));
            $insertn2->bindValue(':date', FullDate('full'));
            $insertn2->bindValue(':categorie', 'Bug');
            $insertn2->bindValue(':ip', $user['ip_current']);
            $insertn2->bindValue(':user_id', $user['id']);
        $insertn2->execute();
				$affichage = "<div id=\"ok\">
			Merci ! Ton signalement a été envoyé a un administrateur du site. Vérifie de temps en temps ton ticket.
		</div>";
			} else {
				$affichage = "<div id=\"pasok\">
            Remplie les champs libres.
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
<script src="https://cdn.ckeditor.com/ckeditor5/37.0.1/classic/ckeditor.js"></script>
<script type="text/javascript" src="<?PHP echo $imagepath; ?>editor/config.js"></script>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/style.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/buttons.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/boxes.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/tooltips.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/personal.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
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
<div id="haut">Signale nous un bug !</div>
	<div id="mil"><center><?PHP if(isset($affichage)) { echo "<br>".$affichage.""; } ?></center><br>
	Salut à toi <?PHP echo $user['username']; ?> ! Tu es sur la catégorie <span style="color: #0066CC"><b>Signaler un bug</b></span> du HelpTool de <?PHP echo $sitename; ?>. Si tu ne voulais pas aller là, clique sur le bouton "Revenir à l'accueil" en bas de la page.
<br>Tu as rencontré un bug ? Tu n'arrives pas à acceder à une page ? Pas de soucis, dis nous tout ici, avec la page à la quel tu n'arrives pas à acceder :<br><br>	
	
<p>
<form method="post" action="#">
<span style="color: #4169E1;">Votre pseudo sur <?PHP echo $sitename; ?> </span> <input type="text" value="<?PHP echo $user['username']; ?>" name="username" readonly="readonly" /><br /><br />
<span style="color: #4169E1;">Votre e-mail : </span><input type="text" value="<?PHP echo $user['mail']; ?>" name="mail" readonly="readonly" /><br /><br />	
<span style="color: #4169E1;">Qu'est-ce qui se passe ? </span><input type="text" name="sujet" style="width: 360px;" maxlength="250" value="<?php  if (!empty($_POST["sujet"])) {  echo htmlspecialchars($_POST["sujet"],ENT_QUOTES);  } ?>" /><br /><br />
<span style="color: #4169E1;">Raconte nous ce qui se passe.</span><br />
<textarea name='texte' rows="7" cols="50" id="editor1"><?php
 if (isset($_POST["texte"])) {
 echo htmlspecialchars($_POST["texte"],ENT_QUOTES);
 }
?></textarea>
<script>CKEDITOR.replace( 'editor1', { toolbar : 'Articles' });</script><br><br /><br />
<input type="submit" value="Envoyer">
</form></div>


		<div id="bas"><a href="<?PHP echo $url; ?>/service_client/">Revenir à l'accueil</a></div>

</body>
</html>