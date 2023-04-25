<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

require_once('./config.php');

$pageid = "pixels";
$pagename = "Pixels";
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

    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>static/styles/lightweightmepage.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
    <script src="<?PHP echo $imagepath; ?>static/js/lightweightmepage.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/fullcontent.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/style.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/buttons.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/boxes.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/tooltips.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>styles/local/com.css<?php echo '?' . mt_rand(); ?>" type="text/css" />

    <meta name="description" content="<?PHP echo $description; ?>" />
    <meta name="keywords" content="<?PHP echo $keyword; ?>" />
    <meta name="build" content="<?PHP echo $build; ?> >> <?PHP echo $version; ?>" />
</head>

<body id="home">
    <div id="tooltip"></div>
    <div id="overlay"></div>


    <!-- MENU -->
    <?PHP include("./template/header.php"); ?>
    <!-- FIN MENU -->

    <div id="container">
        <div id="content" style="position: relative" class="clearfix">
            <div id="column1" class="column">


                <div class="habblet-container ">
                    <div class="cbb clearfix pixelblue ">

                        <h2 class="title">Apprenez à obtenir vos pixels et profitez-en !</h2>
                        <div class="pixels-infobox-container">
                            <div class="pixels-infobox-text">
                                <h3>Vous pouvez gagner des pixels de différentes manières :</h3>
                                <ul>
                                    <li>
                                        <p>Il n'y a pas encore de moyen de gagner des pixels. Veuillez consulter cet espace à l'avenir pour obtenir des informations sur l'obtention de pixels.</p>
                                    </li>
                                </ul>
                                <p>Comment dépenser ? Consultez le catalogue et la boutique Pixel !</p>
                                <p><a href="<?php echo $url; ?>/service_client" target="_blank">Service Client</a></p>

                            </div>
                        </div>


                    </div>
                </div>
                <script type="text/javascript">
                    if (!$(document.body).hasClassName('process-template')) {
                        Rounder.init();
                    }
                </script>


            </div>
            <div id="column2" class="column">

                <div class="habblet-container ">
                    <div class="cbb clearfix pixelgreen ">

                        <h2 class="title">Louez des objets !</h2>

                        <div id="pixels-info" class="box-content pixels-info">
                            <div class="pixels-info-text clearfix">
                                <img class="pixels-image" src="<?php echo $url; ?>/web-gallery/v2/images/activitypoints/pixelpage_effectmachine.png" alt="" />
                                <p class="pixels-text">Créez un appart cool, avec ces effets d'appart à bascule, vous pouvez élargir l'expérience de vos amis..</p>
                            </div>
                        </div>


                    </div>
                </div>
                <script type="text/javascript">
                    if (!$(document.body).hasClassName('process-template')) {
                        Rounder.init();
                    }
                </script>




                <div class="habblet-container ">
                    <div class="cbb clearfix pixellightblue ">

                        <h2 class="title">Effets ?</h2>
                        <div id="pixels-info" class="box-content pixels-info">
                            <div class="pixels-info-text clearfix">
                                <img class="pixels-image" src="<?php echo $url; ?>/web-gallery/v2/images/activitypoints/pixelpage_personaleffect.png" alt="" />
                                <p class="pixels-text">Ajustez votre personnage à l'aide d'effets cool adaptés à l'occasion. Voulez-vous vous envoler avec le tapis rouge ou être sous les feux de la rampe ? C'est l'occasion ou jamais !</p>
                            </div>

                        </div>


                    </div>
                </div>
                <script type="text/javascript">
                    if (!$(document.body).hasClassName('process-template')) {
                        Rounder.init();
                    }
                </script>



                <div class="habblet-container ">
                    <div class="cbb clearfix pixeldarkblue ">

                        <h2 class="title">Des offres alléchantes ?</h2>
                        <div id="pixels-info" class="box-content pixels-info">
                            <div class="pixels-info-text clearfix">

                                <img class="pixels-image" src="<?php echo $url; ?>/web-gallery/v2/images/activitypoints/pixelpage_discounts.png" alt="" />
                                <p class="pixels-text">Les codes promo vous offre la possibilité d'obtenir des pixels sans devoir passer des heures en ligne !</p>
                            </div>
                        </div>


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
