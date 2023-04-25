 <?PHP
    #|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
    #|                                                                        #|
    #|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
    #|																		  #|
    #|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

    include("./config.php");
    $pagename = "Achat de Jetons";
    $pageid = "jetons";

    if (!isset($_SESSION['username'])) {
        Redirect("" . $url . "/index");
    }
    $cof_prix = $bdd->query("SELECT * FROM gabcms_config_prix WHERE id = '1'");
    $cp = $cof_prix->fetch();
    ?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
 <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

 <head>
     <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
     <title><?PHP echo $sitename; ?> &raquo; <?PHP echo $pagename; ?></title>

     <link rel="shortcut icon" href="<?PHP echo $imagepath; ?>favicon.ico" type="image/vnd.microsoft.icon" />
     <script src="<?PHP echo $imagepath; ?>static/js/libs2.js" type="text/javascript"></script>
     <script src="<?PHP echo $imagepath; ?>static/js/visual.js" type="text/javascript"></script>
     <script src="<?PHP echo $imagepath; ?>static/js/libs.js" type="text/javascript"></script>
     <script src="<?PHP echo $imagepath; ?>static/js/common.js" type="text/javascript"></script>

     <script src="<?PHP echo $imagepath; ?>static/js/fullcontent.js" type="text/javascript"></script>
     <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/buttons.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
     <link rel="stylesheet" href="<?PHP echo $imagepath; ?>static/styles/cbs2creditsflow.css<?php echo '?' . mt_rand(); ?>" type="text/css" />

     <meta name="description" content="<?PHP echo $description; ?>" />
     <meta name="keywords" content="<?PHP echo $keyword; ?>" />
     <!--[if IE 8]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/ie8.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
<![endif]-->
     <!--[if lt IE 8]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/ie.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
<![endif]-->
     <!--[if lt IE 7]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/ie6.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
<script src="<?PHP echo $imagepath; ?>static/js/pngfix.js" type="text/javascript"></script>
<script type="text/javascript">
try { document.execCommand('BackgroundImageCache', false, true); } catch(e) {}
</script>
 
<style type="text/css">
body { behavior: url(https://www.habbo.com/js/csshover.htc); }
</style>
<![endif]-->
     <meta name="build" content="<?PHP echo $build; ?> >> <?PHP echo $version; ?>" />
 </head>

 <body id="home" class=" ">

     <div id="container">
         <div id="payment-details-container">

             <div id="payment-details-header">
                 <div class="rounded">
                     <h1>Confirmation de l'achat de jetons <?PHP echo $sitename; ?></h1>
                 </div>
             </div>
             <form id="proceedForm" method="post">
                 <input type="hidden" name="confirm" value="true" />
                 <div id="payment-details">
                     <h2>Tu es sur le point d'acheter <b><?PHP echo $cp['achat_jetons'] ?> jetons</b> en tant que <b><?PHP echo $user['username'] ?></b></h2>
                     <br />
                     <div id="email-address-container">
                         <h3>
                             <label for="confirmField"><span class="username"><?PHP echo $user['username'] ?></span>, voici l'email associé à ton compte:</label>
                         </h3>
                         <div class="email-address-field">
                             <input type="text" disabled id="emailAddress" class="text-field" size="35" name="confirmField" value="<?PHP echo $user['mail'] ?>" />
                         </div>
                     </div>
                 </div>
                 <div id="starpass_<?php echo $id_document; ?>"></div>
                 <script type="text/javascript" src="https://script.starpass.fr/script.php?idd=<?php echo $id_document; ?>&amp;verif_en_php=1&amp;datas=">
                 </script>
                 <noscript>Veuillez activer le Javascript de votre navigateur s'il vous pla&icirc;t.<br />
                     <a href="http://www.starpass.fr/">Micro Paiement StarPass</a>
                 </noscript>
                 <div id="payment-details">
                     <div id="disclaimer">
                         <div style="color: red; font-size: 8pt; margin: 10px;" class="method idx1">
                             <div class="method-content">
                                 <div>En commandant des jetons sur <?PHP echo $sitename ?> tu acceptes nos <a href="<?PHP echo $url ?>/disclaimer" target="_blank" class="terms">Conditions Générales d'Utilisations</a></div>
                             </div>
                         </div>
                         <div style="color:black; font-size: 8pt;">
                             <a href="<?PHP echo $url; ?>/jetons"> <span>Retour</span></a>
                         </div>
                     </div>
                 </div>

                 <div class="disclaimer">
                     <h3><span>Demande toujours la permission</span></h3>
                     Si tu ne respectes pas cette règle, tu seras définitivement exclu de <?PHP echo $sitename ?> !<br />Si tu rencontres des problèmes, contacte-nous grâce au <a onclick="openOrFocusHelp(this); return false" target="habbohelp" href="<?PHP echo $url ?>/service_client/">Centre d'aide <?PHP echo $sitename; ?></a>. <br />Le contenu numérique est fourni immédiatement&nbsp;; en achetant, vous acceptez qu'il n'existe pas de droit de rétractation.
                 </div>
                 <script type="text/javascript">
                     if (!$(document.body).hasClassName('process-template')) {
                         Rounder.init();
                     }
                 </script>
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
     </div>
     </div>
     </div>
     </div>
     <script type="text/javascript">
         HabboView.run();
     </script>
 </body>

 </html>