<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("./config.php");
$pagename = "Conseils de Sécurité";
$pageid = "safety";

if (!isset($_SESSION['username'])) {
    Redirect("" . $url . "/index");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
        if (typeof HabboClient != "undefined") {
            HabboClient.windowName = "uberClientWnd";
        }
    </script>

    <link rel="shortcut icon" href="<?PHP echo $imagepath; ?>favicon.ico" type="image/vnd.microsoft.icon" />
    <script src="<?PHP echo $imagepath; ?>static/js/libs2.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/visual.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/libs.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/common.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>js/tooltip.js" type="text/javascript"></script>

    <script src="<?PHP echo $imagepath; ?>static/js/fullcontent.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/style.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/buttons.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/boxes.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/tooltips.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/personal.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
    <script src="<?PHP echo $imagepath; ?>static/js/habboclub.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/minimail.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/myhabbo/control.textarea.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>static/styles/safety.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
    <script src="<?PHP echo $imagepath; ?>static/js/minimail.js" type="text/javascript"></script>



    <meta name="description" content="<?PHP echo $description; ?>" />
    <meta name="keywords" content="<?PHP echo $keyword; ?>" />
    <!--[if IE 8]>
<link rel="stylesheet" href="http://images.habbo.com/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/1367/web-gallery/static/styles/ie8.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
<![endif]-->
    <!--[if lt IE 8]>
<link rel="stylesheet" href="http://images.habbo.com/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/1367/web-gallery/static/styles/ie.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
<![endif]-->
    <!--[if lt IE 7]>
<link rel="stylesheet" href="http://images.habbo.com/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/1367/web-gallery/static/styles/ie6.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
<script src="http://images.habbo.com/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/1367/web-gallery/static/js/pngfix.js" type="text/javascript"></script>
<script type="text/javascript">
try { document.execCommand('BackgroundImageCache', false, true); } catch(e) {}
</script>

<style type="text/css">
body { behavior: url(/js/csshover.htc); }
</style>
<![endif]-->
    <meta name="build" content="<?PHP echo $build; ?> >> <?PHP echo $version; ?>" />
</head>

<body id="home" class=" ">
    <div id="tooltip"></div>
    <div id="overlay"></div>
    <!-- MENU -->
    <?PHP include("./template/header.php"); ?>
    <!-- FIN MENU -->

    <div id="container">
        <div id="content" style="position: relative" class="clearfix">
            <div id="column1" class="column">

                <div class="habblet-container ">

                    <div id="habbo-way-content">
                        <table>
                            <tr>
                                <td><img src="<?PHP echo $imagepath; ?>images/safety/page_0.png" alt="" /> <br /></td>
                                <td>
                                    <h4>Protège tes informations personnelles </h4>
                                    Tu ne sais jamais avec qui tu es vraiment en train de parler en ligne, donc ne donne jamais ton vrai nom, adresse, numéro de téléphone, photos ou nom de ton école. Partager ces informations personnelles peut te conduire à être victime d'une arnaque, d'intimidation ou de te mettre en danger.
                                </td>
                                <td><img src="<?PHP echo $imagepath; ?>images/safety/page_1.png" alt="" /> <br /></td>
                                <td>
                                    <h4>Protège ta vie privée </h4>
                                    Garde les coordonnées de ton Skype, MSN, Facebook pour toi. Tu ne sais jamais où cela peut te conduire.
                                </td>
                            </tr>
                            <tr>
                                <td><img src="<?PHP echo $imagepath; ?>images/safety/page_2.png" alt="" /> <br /></td>
                                <td>
                                    <h4>Ne cède pas à la pression des autres </h4>
                                    Que tout le monde fasse quelque chose n'est pas une raison pour toi de le faire si tu n'es pas à l'aise avec cette idée.
                                </td>
                                <td><img src="<?PHP echo $imagepath; ?>images/safety/page_3.png" alt="" /> <br /></td>
                                <td>
                                    <h4>Garde tes copains en pixels! </h4>
                                    Ne jamais rencontrer des personnes que tu connais uniquement via internet, les gens ne sont pas toujours ceux qu'ils prétendent être! Si quelqu'un te demande de le/la rencontrer dans la vraie vie, il vaut mieux dire &quot;Non merci!&quot; et prévenir un modérateur, tes parents ou un autre adulte de confiance.
                                </td>
                            </tr>
                            <tr>
                                <td><img src="<?PHP echo $imagepath; ?>images/safety/page_4.png" alt="" /> <br /></td>
                                <td>
                                    <h4>N'aies pas peur de dire les choses! </h4>
                                    Si quelqu'un te met mal à l'aise ou te fait peur avec des menaces dans <?PHP echo $sitename; ?>, signale-le immédiatement à un modérateur en utilisant le bouton d'alerte.
                                </td>
                                <td><img src="<?PHP echo $imagepath; ?>images/safety/page_5.png" alt="" /> <br /></td>
                                <td>
                                    <h4>Exclus la Webcam </h4>
                                    Tu n'as aucun contrôle sur tes photos et images webcam une fois que tu les as partagées sur Internet, tu ne peux plus les récupérer. Elles peuvent être partagées avec n'importe qui, n'importe où et être utilisées pour t'intimider, te faire du chantage ou te menacer. Avant de publier une photo, demande-toi si tu es à l'aise pour que des gens que tu ne connais pas la voient.
                                </td>
                            </tr>
                            <tr>
                                <td><img src="<?PHP echo $imagepath; ?>images/safety/page_6.png" alt="" /> <br /></td>
                                <td>
                                    <h4>Sois un surfeur intelligent </h4>
                                    <?PHP echo $sitename; ?> est totalement sécurisé! Mais les utilisateurs ne le sont pas, donc ses "amis" doivent rester dans le virtuel.
                                </td>
                            </tr>
                        </table>
                    </div>




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
            <!-- FOOTER -->
            <?PHP include("./template/footer.php"); ?>
            <!-- FIN FOOTER -->
        </div>
    </div>
</body>

</html>