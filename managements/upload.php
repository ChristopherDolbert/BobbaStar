<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|           GabCMS - Site Web et Content Management System               #|
#|         Copyright © 2012-2014 - Gabodd Tout droits réservés.           #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

    include("../config.php");
    $pagename = "Uploadeur d'image";

if(!isset($_SESSION['username']))
	{
		Redirect("".$url."/index");
		exit();
	}
	
	if($user['rank'] < 5) {
	Redirect("".$url."/managements/acces_neg");
	exit();
	}
	if($user['rank'] > 8) {              
	Redirect("".$url."/managements/acces_neg");
	exit();
	}		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head> 
<meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
<title><?PHP echo $sitename; ?> &raquo; <?PHP echo $pagename; ?></title> 
 
<link rel="shortcut icon" href="<?PHP echo $imagepath; ?>favicon.ico" type="image/vnd.microsoft.icon" /> 
<script src="<?PHP echo $imagepath; ?>static/js/libs2.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath; ?>static/js/visual.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath; ?>static/js/libs.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath; ?>static/js/common.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath; ?>js/tooltip.js" type="text/javascript"></script>

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
<meta name="build" content="<?PHP echo $build; ?> >> <?PHP echo $version; ?>" /> 
</head>

<body id="home" class=" "> 
<div id="tooltip"></div>
<div id="overlay"></div> 
<div id="container">
<div id="content"> <br/><br/><br/>
<div id="column11" class="column">
<div class="habblet-container" id="okt" style="float:left; width: 770px;">        
<div class="cbb clearfix green">
<h2 class="title">Uploader vos images</h2>
<div class="habblet box-content">
Grâce à cet outil, vous pouvez uploader des images sur le serveur de <?PHP echo $sitename; ?>.<br/><br/><center>
<?php 
$poids_max = 512000; // Poids max de l'image en octets (1Ko = 1024 octets) 
$repertoire = 'upload/'; // Repertoire d'upload 
if (isset($_FILES['fichier'])) 
{ 
// On vérifit le type du fichier 
if ($_FILES['fichier']['type'] != 'image/png' && $_FILES['fichier']['type'] != 'image/jpeg' && $_FILES['fichier']['type'] != 'image/jpg' && $_FILES['fichier']['type'] != 'image/gif' && $_FILES['fichier']['type'] != 'image/bmp' && $_FILES['fichier']['type'] != 'image/jpg' && $_FILES['fichier']['type'] != 'image/ico') 
{ 
$erreur = '<div id="purse-redeem-result"> 
        <div class="redeem-error"> 
            <div class="rounded rounded-red">Le fichier doit être au format *.jpeg, *.bmp, *.jpg, *.ico, *.gif ou *.png .
			</div>
		</div>
	</div>'; 
} 

// On vérifit le poids de l'image 
elseif ($_FILES['fichier']['size'] > $poids_max) 
{ 
$erreur = '<div id="purse-redeem-result"> 
        <div class="redeem-error"> 
            <div class="rounded rounded-red"> L\'image doit être inférieur à ' . $poids_max/1024 . 'Ko.
		</div>
	</div>
</div>'; 
} 

// On vérifit si le répertoire d'upload existe 
elseif (!file_exists($repertoire)) 
{ 
$erreur = '<div id="purse-redeem-result"> 
        <div class="redeem-error"> 
            <div class="rounded rounded-red"> Erreur, le dossier d\'upload n\'existe pas.
		</div>
	</div>
</div>'; 
} 

// Si il y a une erreur on l'affiche sinon on peut uploader 
if(isset($erreur)) 
{ 
echo '' . $erreur . '<br/><a href="javascript:history.back(1)">Retour</a>'; 
} 
else 
{ 
// On définit l'extention du fichier puis on le nomme par le timestamp actuel 
if ($_FILES['fichier']['type'] == 'image/jpeg') { $extention = '.jpeg'; } 
if ($_FILES['fichier']['type'] == 'image/jpg') { $extention = '.jpg'; } 
if ($_FILES['fichier']['type'] == 'image/png') { $extention = '.png'; } 
if ($_FILES['fichier']['type'] == 'image/gif') { $extention = '.gif'; } 
if ($_FILES['fichier']['type'] == 'image/bmp') { $extention = '.bmp'; } 
if ($_FILES['fichier']['type'] == 'image/ico') { $extention = '.ico'; }
$nom_fichier = $nowtime.$extention; 
// On upload le fichier sur le serveur. 
if(move_uploaded_file($_FILES['fichier']['tmp_name'], $repertoire.$nom_fichier)) { 
$urlt = ''.$url.'/managements/'.$repertoire.''.$nom_fichier.'';
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'upload une image sur le serveur <b>(<a target="_blank" href="'.$urlt.'">'.$nom_fichier.'</a>)</b>');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute();
        $bdd->query("INSERT INTO gabcms_upload (lien, par, date, ip) VALUES ('".$urlt."', '".$user['username']."', '".FullDate('full')."', '".$user['ip_last']."')");
echo '<div id="purse-redeem-result"> 
        <div class="redeem-error"> 
            <div class="rounded rounded-green"> 
<a href="'.$urlt.'" target="_blank"><img src="'.$urlt.'" style="float:left; height:70px; width: 70px;"/></a>Votre image a été uploadée sur le serveur avec succès!<br/><br/><br/>Voici le lien: <input type="text" value="'.$urlt.'" size="60">
		</div> 
	</div> 
</div>
<br/><a href="javascript:history.back(1)">Retour</a>';
} 
else 
{ 
echo '<div id="purse-redeem-result"> 
        <div class="redeem-error"> 
            <div class="rounded rounded-red"> L\'image n\'a pas pu être uploadée sur le serveur.
		</div>
	</div>	
</div>'; 
} 

} 

} 
else 
{ 
?> 
<form method="post" enctype="multipart/form-data"> 
<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $poids_max; ?>">
<input type="file" name="fichier"> 
<button value="Envoyer">Envoyer</button>
</form>
</center>
<?PHP 
} 
?>
</div></div>
</div></div>
</div></div>
                <script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>            
</div>
<!-- FOOTER -->
<?PHP include("../template/footer.php"); ?>
<!-- FIN FOOTER -->
</body>
</html>