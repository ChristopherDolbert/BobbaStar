 <?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|           GabCMS - Site Web et Content Management System               #|
#|         Copyright © 2012-2014 - Gabodd Tout droits réservés.           #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

	include("./config.php");
	$pagename = "Code bon";
	$pageid = "jetons";
	
if(!isset($_SESSION['username'])) 
	{
Redirect("".$url."/index");	
	}
$cof_prix = $bdd->query("SELECT * FROM gabcms_config_prix WHERE id = '1'");
$cp = $cof_prix->fetch();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
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
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/buttons.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/boxes.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/tooltips.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/personal.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath;?>static/styles/cbs2creditsflow.css" type="text/css" />

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
<body id="home" class=" "> 

    <div id="container">
        <div id="payment-details-container">
    
    <div id="payment-details-header">
        <div class="rounded"><h1>Confirmation de l'achat de jetons <?PHP echo $sitename; ?> - Code bon</h1></div>
    </div>
        
               
        <div id="payment-details">
            <h2>Merci de ta confiance</h2>
                        <br />
<div id="disclaimer">

                <p>
<?php
						// Déclaration des variables
                        $ident=$idp=$ids=$idd=$codes=$code1=$code2=$code3=$code4=$code5=$datas='';
                        $idp = $id_compte;
                        // $ids n'est plus utilisé, mais il faut conserver la variable pour une question de compatibilité
                        $idd = $id_document;
                        $ident=$idp.";".$ids.";".$idd;
                        // On récupère le(s) code(s) sous la forme 'xxxxxxxx;xxxxxxxx'
                        if(isset($_POST['code1'])) $code1 = $_POST['code1'];
                        if(isset($_POST['code2'])) $code2 = ";".$_POST['code2'];
                        if(isset($_POST['code3'])) $code3 = ";".$_POST['code3'];
                        if(isset($_POST['code4'])) $code4 = ";".$_POST['code4'];
                        if(isset($_POST['code5'])) $code5 = ";".$_POST['code5'];
                        $codes=$code1.$code2.$code3.$code4.$code5;
                        // On récupère le champ DATAS
                        if(isset($_POST['DATAS'])) $datas = $_POST['DATAS'];
                        // On encode les trois chaines en URL
                        $ident=urlencode($ident);
                        $codes=urlencode($codes);
                        $datas=urlencode($datas);
 
                        /* Envoi de la requête vers le serveur StarPass
                        Dans la variable tab[0] on récupère la réponse du serveur
                        Dans la variable tab[1] on récupère l'URL d'accès ou d'erreur suivant la réponse du serveur */
                        $get_f=@file("http://script.starpass.fr/check_php.php?ident=$ident&codes=$codes&DATAS=$datas");
                        if(!$get_f)
                        {
                            exit("Votre serveur n'a pas accès au serveur de Starpass, merci de contacter votre hébergeur.");
                        }
                        $tab = explode("|",$get_f[0]);
 
                        if(!$tab[1]) $url = "index.php";
                        else $url = $tab[1];
 
                        // dans $pays on a le pays de l'offre. exemple "fr"
                        $pays = $tab[2];
                        // dans $palier on a le palier de l'offre. exemple "Plus A"
                        $palier = urldecode($tab[3]);
                        // dans $id_palier on a l'identifiant de l'offre
                        $id_palier = urldecode($tab[4]);
                        // dans $type on a le type de l'offre. exemple "sms", "audiotel, "cb", etc.
                        $type = urldecode($tab[5]);
                        // vous pouvez à tout moment consulter la liste des paliers à l'adresse : http://script.starpass.fr/palier.php
 
                        // Si $tab[0] ne répond pas "OUI" l'accès est refusé
                        // On redirige sur l'URL d'erreur
                        if(substr($tab[0],0,3) != "OUI")
                        {
                            Redirect("./code_faux.php");	
                            exit;
                        }
                        else
                        {
                         	$bdd->query("UPDATE users SET jetons = jetons + ".$cp['achat_jetons']." WHERE id = '".$user['id']."'");
							$bdd->query("UPDATE users SET achat_jetons = achat_jetons + ".$cp['achat_jetons']." WHERE id = '".$user['id']."'");
							$bdd->query("INSERT INTO gabcms_transaction (user_id,produit,prix,gain,date) VALUES ('".$user['id']."','Achat ".$cp['achat_jetons']." jetons','".$cp['achat_jetons']."','+','".FullDate('full')."')");
                         }
                    ?>
                    <b><span style="color:green">Paiement accepté</span></b><br/><br/>Ton compte vient d'être crédité de <b><?PHP echo Secu($cp['achat_jetons']); ?> jetons</b> ! 
				</p>
                            
   <div style="color: red; font-size: 8pt; margin: 10px;" class="method idx1">
                <div class="method-content">
                    <div>En commandant des jetons sur <?PHP echo $sitename ?> tu as accepté nos <a href="<?PHP echo $url ?>/disclaimer" target="_blank" class="terms">Conditions Générales d'Utilisations</a></div>
                </div>
            </div>
  <div style="color:black; font-size: 8pt;">
                <a href="<?PHP echo $url; ?>/jetons"> <span>Retour</span></a>
            </div>


</div>

</div>

<div class="disclaimer">
        <h3><span>Demande toujours la permission</span></h3>
        Si tu ne respectes pas cette règle, tu seras définitivement exclu de <?PHP echo $sitename ?> !<br/>Si tu rencontres des problèmes, contacte-nous grâce au <a onclick="openOrFocusHelp(this); return false" target="habbohelp" href="<?PHP echo $url ?>/service_client/">Centre d'aide <?PHP echo $sitename; ?></a>. <br/>Le contenu numérique est fourni immédiatement&nbsp;; en achetant, vous acceptez qu'il n'existe pas de droit de rétractation.
    </div>
                <script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>     
</div>
<script type="text/javascript">
HabboView.run();
</script>    
                </div>
	<!--[if lt IE 7]>
<script type="text/javascript">
Pngfix.doPngImageFix();
</script>
<![endif]--> 
<!-- FOOTER -->
<div id="column3" class="column">
</div>
<div id="footer">
	</div><!-- FIN FOOTER -->
<div style="clear: both;"></div>
</div></div></div></div>
<script type="text/javascript"> 
HabboView.run();
</script>
</body> 
</html> 