<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|

#|         Copyright © 2012-2015 - Gabodd Tout droits réservés.           #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

	include("./config.php");
	$pagename = "Mot de passe oublié ?";
	$pageid = "index";
	
# Formulaire pour demander un nouveau mot de passe #
if(isset($_GET['demande'])) {
    $demande = Secu($_GET['demande']);
    if($demande == "rempli") {
        if(isset($_POST['email'])) {
        $email = Secu($_POST['email']);
        if(isset($_POST['pseudo'])) {
        $pseudo = Secu($_POST['pseudo']);
        $verif_user = $bdd->query("SELECT * FROM users WHERE username = '".$pseudo."' LIMIT 1");
        $row = $verif_user->rowCount();
        if($row > 0) {
        $user = $verif_user->fetch(PDO::FETCH_ASSOC); 
            $verif_mail = $bdd->query("SELECT * FROM users WHERE id = '".$user['id']."' AND mail = '".$email."' LIMIT 1");
            $row_mail = $verif_mail->rowCount();
            if($row_mail > 0) {
                $code = "".Genere_code(8)."-".Genere_code(8)."-".Genere_code(8)."-".Genere_code(8)."";
                $lien = "&u=".$user['username']."&e=".$email."&c=".Genere_code(8)."";
                $insertusera = $bdd->prepare("INSERT INTO gabcms_motdepasse_oublier (user_id, email, code, lien, ip, utilise) VALUES (:user_id, :email, :code, :lien, :ip, :utilise)");
                    $insertusera->bindValue(':user_id', $user['id']);
                    $insertusera->bindValue(':email', $email);
                    $insertusera->bindValue(':code', $code);
                    $insertusera->bindValue(':lien', $lien);
                    $insertusera->bindValue(':ip', $_SERVER["REMOTE_ADDR"]);
                    $insertusera->bindValue(':utilise', '1');
                $insertusera->execute();
$fichier_message = '<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bonjour <b>'.$user['username'].'</b>,</div>
<div>&nbsp;</div>
<div>Tu as demandé que ton mot de passe soit changé. Ta demande a été accepté, pour cela, voici les étapes :</div>
<ol>
	<li>Clique sur le lien ci-contre : <a href="'.$url.'/oubliemotdepasse?changement=nok'.$lien.'">ici</a></li>
	<li>Copie dans l&#39;emplacement prévu le code qui te sera fourni en bas de ce MP.</li>
	<li>Recopie un nouveau mot de passe, et hop, &ccedil;a sera bon !</li>
</ol>
<div>Voici le code : <b>'.$code.'</b></div>
<div>&nbsp;</div>
<div><span style="color:#FF0000"><strong>Attention, le code est utilisable qu&#39;une fois.</strong></span></div>
<div>&nbsp;</div>
<div style="text-align: right;">Cordialement, l&#39;équipe de '.$sitename.'</div>
<div>&nbsp;</div>
<div>&nbsp;</div>
<div><sub>Demande effectuée le '.FullDate('full').' &agrave; l&#39;adresse IP suivante : <i>'.$_SERVER["REMOTE_ADDR"].'</i></sub></div>'; //On ajoute les infos au message
// On définit la liste des inscrits.
$message = $fichier_message;
$destinataire = $email; 
 
$objet = "Changement de mot de passe (oublie) - ".$sitename.""; // On définit l'objet qui contient la date.
 
// On définit le reste des paramètres.
$headers  = "MIME-Version: 1.0 \r\n";
$headers .= "Content-type: text/html; charset=utf-8 \r\n";
$headers .= "From: Contact - ".$sitename." <".$mail."> \r\n"; // On définit l'expéditeur.
 
    // On envoie l'e-mail.
    mail($destinataire, $objet, $fichier_message, $headers);
            $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-green\"> 
              Ta demande a été enregistrée avec succès. Tu as reçu un mail dans lequel tout te sera expliqué. Penses à vérifier dans ta boite spam.
            </div> 
        </div> 
</div>";
            } else {
            $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
              L'email et l'utilisateur ne correspondent pas
            </div> 
        </div> 
</div>";   
            } } else {
        $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
              L'utilisateur n'existe pas
            </div> 
        </div> 
</div>";
        } } else {
    $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
              Le pseudo n'a pas été renseigné
            </div> 
        </div> 
</div>";
    } } else {
    $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
              L'email n'a pas été renseigné
            </div> 
        </div> 
</div>";    
    } } else {
    $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
              Le lien du formulaire n'est pas le bon
            </div> 
        </div> 
</div>";    
    }
}

# Formulaire pour modifier son mot de passe #
if(isset($_GET['changement'])) {
    $changement = Secu($_GET['changement']);
    if($changement == 'ok') {
        if(isset($_GET['u']) && isset($_GET['e']) && isset($_GET['c'])) {
            $u = Secu($_GET['u']);
            $e = Secu($_GET['e']);
            $c = Secu($_GET['c']);
            $lien_concret = "&u=".$u."&e=".$e."&c=".$c."";
            if(isset($_POST['code']) && isset($_POST['bean_repassword']) && isset($_POST['bean_password'])) {
                $code = Secu($_POST['code']);
                $motdepasse = GabCMSHash($_POST['bean_password']);
                $remotdepasse = GabCMSHash($_POST['bean_repassword']);
                if($motdepasse == $remotdepasse) {
                    if(strlen($motdepasse) >= 6) {
                $verif_mdp = $bdd->query("SELECT * FROM gabcms_motdepasse_oublier WHERE code = '".$code."' && lien = '".$lien_concret."' LIMIT 1");
                $row_mdp = $verif_mdp->rowCount();
                    if($row_mdp > 0) {
                    $mdpo = $verif_mdp->fetch(PDO::FETCH_ASSOC);
                        if($mdpo['utilise'] == '1') {
                            if($mdpo['ip'] == $_SERVER['REMOTE_ADDR']) {
                                if($mdpo['lien'] == $lien_concret) {
                                    if($mdpo['code'] == $code) {
                                        $bdd->query("UPDATE users SET password = '".$motdepasse."' WHERE username = '".$u."' AND mail = '".$e."' LIMIT 1");
                                        $bdd->query("UPDATE gabcms_motdepasse_oublier SET utilise = '2' WHERE id = '".$mdpo['id']."' LIMIT 1");
                                        $affichage = "<div id=\"purse-redeem-result\"> 
                                        <div class=\"redeem-error\"> 
                                        <div class=\"rounded rounded-green\"> 
                                        Ton nouveau mot de passe à bien été modifié, reconnecte-toi!
                                        </div> 
                                        </div> 
                                        </div>";
                                    } else {
                                    $affichage = "<div id=\"purse-redeem-result\"> 
                                    <div class=\"redeem-error\"> 
                                    <div class=\"rounded rounded-red\"> 
                                    Le code ne correspond pas au code fourni dans le mail. Votre demande a été clôturé, merci d'en recréer une autre.
                                    </div> 
                                    </div> 
                                    </div>"; 
                                    $bdd->query("UPDATE gabcms_motdepasse_oublier SET utilise = '2' WHERE id = '".$mdpo['id']."'");
                                } } else {
                                $affichage = "<div id=\"purse-redeem-result\"> 
                                <div class=\"redeem-error\"> 
                                <div class=\"rounded rounded-red\"> 
                                Le lien ne correspond pas au lien fourni dans le mail. Votre demande a été clôturé, merci d'en recréer une autre.
                                </div> 
                                </div> 
                                </div>"; 
                                $bdd->query("UPDATE gabcms_motdepasse_oublier SET utilise = '2' WHERE id = '".$mdpo['id']."'");
                            } } else {
                            $affichage = "<div id=\"purse-redeem-result\"> 
                            <div class=\"redeem-error\"> 
                            <div class=\"rounded rounded-red\"> 
                            L'ip ne correspond pas à l'adresse IP du demandeur de base. Votre demande a été clôturé, merci d'en recréer une autre.
                            </div> 
                            </div> 
                            </div>"; 
                            $bdd->query("UPDATE gabcms_motdepasse_oublier SET utilise = '2' WHERE id = '".$mdpo['id']."'");
                        } } else {
                        $affichage = "<div id=\"purse-redeem-result\"> 
                        <div class=\"redeem-error\"> 
                        <div class=\"rounded rounded-red\"> 
                        Cette demande est clotûrée. Merci d'en recréer une autre.
                        </div> 
                        </div> 
                        </div>";   
                    } } else {
                    $affichage = "<div id=\"purse-redeem-result\"> 
                    <div class=\"redeem-error\"> 
                    <div class=\"rounded rounded-red\"> 
                    Cette demande n'existe pas.
                    </div> 
                    </div> 
                    </div>"; 
                    } } else { 
                        $affichage = "<div id=\"purse-redeem-result\"> 
                    <div class=\"redeem-error\"> 
                    <div class=\"rounded rounded-red\"> 
                    Ton mot de passe est trop court
                    </div> 
                    </div> 
                    </div>"; 
                } } else { $affichage = "<div id=\"purse-redeem-result\"> 
                <div class=\"redeem-error\"> 
                <div class=\"rounded rounded-red\"> 
                Les mots de passe ne correspondent pas
                </div> 
                </div> 
                </div>"; 
            } } else {
            $affichage = "<div id=\"purse-redeem-result\"> 
            <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
            Tous les champs requis ne sont pas remplis.
            </div> 
            </div> 
            </div>"; 
        } } else {
        $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
        <div class=\"rounded rounded-red\"> 
        Le lien n'est pas complet.
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
	<title><?PHP echo $sitename;?> &raquo; <?PHP echo $pagename; ?></title>

<script type="text/javascript">
var andSoItBegins = (new Date()).getTime();
</script>

    <script>
        var andSoItBegins = (new Date()).getTime();
        var habboPageInitQueue = [];
        var habboStaticFilePath = "./web-gallery";
    </script>
<style>
/* Tooltip */

#tooltip {
position:absolute;
visibility:hidden;
z-index:999999999;
color:#fff;
background:rgba(0, 0, 0, 0.8);
-moz-border-radius:6px;
-webkit-border-radius:6px;
-o-border-radius:6px;
-khtml-border-radius:6px;
border-radius:6px;
padding:5px;
text-shadow:rgba(0, 0, 0, 0.8) 0 1px 0;
}    
#purse-redeem-result {
    text-align: center;
    padding: 8px 0 0 15px;
    clear: both;
}   
div.rounded-red {
	color: #FFFFFF;
	background-color: #e2001a;
}
div.rounded-green {
	color: #FFFFFF;
	background-color: #3ba800;
}
</style>
<link rel="shortcut icon" href="<?PHP echo $imagepath;?>favicon.ico" type="image/vnd.microsoft.icon" /> 
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu:400,700,400italic,700italic">
<script src="<?PHP echo $imagepath;?>static/js/13389159.js"></script>
<link rel="stylesheet" href="<?PHP echo $imagepath;?>static/styles/v3_default.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath;?>static/styles/v3_logout.css" type="text/css" />
<script src="<?PHP echo $imagepath;?>static/js/v3_default_top.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath;?>js/tooltip.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath;?>static/js/visual.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath;?>v2/styles/styles.css" type="text/javascript"></script>
<script src="<?PHP echo $imagepath;?>static/js/libs.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/tooltips.css" type="text/css" />
<script src="<?PHP echo $imagepath;?>static/js/common.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath;?>static/js/fullcontent.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath;?>static/js/libs2.js" type="text/javascript"></script>
<script type="text/javascript">
document.habboLoggedIn = false;
var habboName = null;
var habboReqPath = "";
var habboStaticFilePath = "./web-gallery";
var habboImagerUrl = "/habbo-imaging/";
var habboPartner = "";
window.name = "habboMain";

</script>



<meta name="description" content="<?PHP echo $description;?>" />
<meta name="keywords" content="<?PHP echo $keyword;?>" />

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
body { behavior: url(<?PHP echo $imagepath;?>csshover.htc); }
</style>
<![endif]-->
<meta name="build" content="<?PHP echo $build;?> >> <?PHP echo $version;?>" />
    
</head>
<body>
<div id="tooltip"></div>
<div id="overlay"></div>
<header>
    <div id="border-left"></div>
    <div id="border-right"></div>
    <div id="header-content">
		<a href="#home" id="habbo-logo"></a>    
		</div>
    <div id="top-bar-triangle"></div>
    <div id="top-bar-triangle-border"></div>
</header>

<div id="content"><div id="page-content">
<?PHP if(isset($affichage)) { echo "".$affichage."<br/>"; } ?>
<img src="<?PHP echo $imagepath;?>v2/images/mdp.gif" alt="placeholder"/>

<div id="column1" class="column">
			     		
				<div class="habblet-container ">		
	
						<div class="ad-container">

</div>		
				</div>
</div>
<div id="column2" class="column">
<?PHP if(!isset($_GET['changement']) && !isset($_GET['u']) && !isset($_GET['e']) && !isset($_GET['c'])) { ?>
    <b><i>Etape 1/2 - Renseignements divers</i></b><br/>
    Il semblerait que tu ne trouves plus ton mot de passe ?<br/><br/>
    Ne t'inquiètes pas, <?PHP echo $sitename; ?> gère tout, il suffit que tu fournisses ton pseudo et ton adresse email. Si ils correspondent, tu recevras un mail, avec un lien et un code a entré. Ce code est utilisable une fois, ne te trompe pas.<br/>
    <i>NB : Si ton IP lors de cette demande ne correspond pas à l'IP que tu fournis dans le formulaire du mail, ta requête sera refusée d'office.</i> 
    <form class="form" action="?demande=rempli" method="post">
    <b>Email :</b><br/>
    <input id="email" name="email" title="Entre ton email" type="text" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)"><br/>
    <b>Pseudo :</b><br/>
    <input id="email" name="pseudo" title="Entre ton pseudo" type="text" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)"><br/><br/>
    <input type="submit" id="envoyer" class="new-button fill" value="Enregistrer ma requête">
    </form>
</div>
<br/>
</div>
<footer>
        <div id="partner-logo"><a href="" style="background-image: url('./web-gallery/v2/images/publishing.png')"></a></div>
    <div id="footer-content">
        <div id="footer"></div>
		<div id="copyright"><?PHP include("./template/footer.php");?></div>
    </div> 
</footer>
<script src="./web-gallery/static/js/v3_landing_bottom.js" type="text/javascript"></script><!--[if IE]><script src="./web-gallery/static/js/v3_ie_fixes.js" type="text/javascript"></script><![endif]-->
<?PHP } elseif(isset($_GET['changement']) && isset($_GET['u']) && isset($_GET['e']) && isset($_GET['c'])) { ?>
    <b><i>Etape 2/2 - Changement de mot de passe</i></b><br/>
    Si tu es arrivé ici, c'est que tu as reçu le mail. Dans le formulaire ci-contre, merci de renseigner ton code ainsi que ton nouveau mot de passe.<br/><br/>
    <form class="form" action="?changement=ok&u=<?PHP echo $_GET['u']; ?>&e=<?PHP echo $_GET['e']; ?>&c=<?PHP echo $_GET['c']; ?>" method="post">
    <b>Code :</b><br/>
    <input id="code" name="code" title="Entre ton code unique" type="text" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)"><br/>
    <b>Nouveau mot de passe :</b><br/>
    <input id="password" name="bean_password" title="Mot de passe" type="password" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)"><br/>
    <b>Confirmation :</b><br/>
    <input id="password" name="bean_repassword" title="Mot de passe" type="password" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)"><br/><br/>
    <input type="submit" id="envoyer" class="new-button fill" value="Conclure ma requête">
    </form>
</div>
<br/>
</div>
<footer>
        <div id="partner-logo"><a href="" style="background-image: url('./web-gallery/v2/images/publishing.png')"></a></div>
    <div id="footer-content">
        <div id="footer"></div>
		<div id="copyright"><?PHP include("./template/footer.php");?></div>
    </div> 
</footer>
<script src="./web-gallery/static/js/v3_landing_bottom.js" type="text/javascript"></script><!--[if IE]><script src="./web-gallery/static/js/v3_ie_fixes.js" type="text/javascript"></script><![endif]-->
<?PHP } ?>
</body>
</html> 