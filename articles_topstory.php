<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|

#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

	include("./config.php");
	$pagename = "Images pour articles";
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head> 
<meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
<title><?PHP echo $sitename;?> &raquo; <?PHP echo $pagename;?></title>

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
<link rel="shortcut icon" href="<?PHP echo $imagepath;?>favicon.ico" type="image/vnd.microsoft.icon" /> 
<div id="container"> 
<div id="tooltip"></div>
<br/><br/><br/>
<div class="cbb process-template-box clearfix"> 
<center>
Bienvenue sur la page spécialement conçu pour les news de <b><?php echo $sitename;?></b>.
<br/>Pour copier l'adresse d'une des images ci-dessous, suffit de cliquer sur l'image.
<br/><a href="<?PHP echo $url;?>/moi">Revenir sur GabCMS</a>
</center>

<br/>

<?php
$dir = './web-gallery/v2/news/';
$image_largeur = 770;
$valide_extensions = array('jpg', 'jpeg', 'gif', 'png', 'bmp');
if(!file_exists($dir))
{ echo '<center><b>Le dossier n\'existe pas.</b></center>'; } else {
$Ressource = opendir($dir);
while($fichier = readdir($Ressource))
{
    $berk = array('.', '..');

    $test_Fichier = $dir.$fichier;

    if(!in_array($fichier, $berk) &&!is_dir($test_Fichier))
    {
$ext = strtolower(pathinfo($fichier, PATHINFO_EXTENSION));

        if(in_array($ext, $valide_extensions))
        {
            echo '
                <div style="float:left; width:'.$image_largeur.'px; margin-left:10px">
                   <br \> <a href="'.$test_Fichier.'" target="_blank"><img src="'.$test_Fichier.'" style="'.$image_largeur.'px" /><br/><img src="./web-gallery/v2/images/save.png" align="middle" /></a> Clique sur l\'image pour prendre son lien!
                </div>';
        }
    }
}
}
?>
</div></div>
<!-- FOOTER -->
<?PHP include("./template/footer.php");?>
<!-- FIN FOOTER -->
<script type="text/javascript"> 
HabboView.run();
</script>
</body> 
</html>