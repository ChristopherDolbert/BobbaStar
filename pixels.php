<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

require_once('./config.php');

$pageid = "pixels";
$pagename = "Pixels";

if (!isset($_SESSION['username'])) {
    Redirect("" . $url . "/index");
    exit;
}

if (isset($_GET['generatePixels']) && $user['pixels'] <= 10) {
    if ($user['online'] != 1) {
        $bdd->beginTransaction();
        $reqCredits = $bdd->prepare("UPDATE users SET pixels = pixels + 100  WHERE id = ?");
        $reqCredits->execute([$user['id']]);
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_transaction (user_id, produit, prix, gain, date) VALUES (?, ?, ?, ?, ?)");
        $insertn1->execute([$user['id'], 'Offre SPF (Sans pixel fixe) +100', 0, '+', FullDate('full')]);
        $bdd->commit();
        $affichage = "<div id=\"purse-redeem-result\"><div class=\"redeem-error\"><div class=\"rounded rounded-green\"> Nous venons de t'envoyer <b>100 pixels</b>!</div></div></div>";
    } else {
        @SendMUSData('givepixels', ['user_id' => $user['id'], 'pixels' => 100]);
        $affichage = "<div id=\"purse-redeem-result\"><div class=\"redeem-error\"><div class=\"rounded rounded-green\"> Regarde sur ton client, tu as reçu <b>100 pixels</b>!</div></div></div>";
    }
} elseif ($user['pixels'] >= 11) {
    $affichage = "<div id=\"purse-redeem-result\"><div class=\"redeem-error\"><div class=\"rounded rounded-red\">Tu as assez de pixels.</div></div></div>";
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

                        <h2 class="title">Obtenir des pixels !</h2>
                        <div class="pixels-infobox-container">
                            <div class="pixels-infobox-text">
                                <h3>Vous pouvez gagner des pixels de différentes manières :</h3>
                                <ul>
                                    <li>* En cliquant sur "<b>Générer 100 pixels</b>".</li><br />
                                    <li>* En restant connecté sur le client.</li><br />
                                </ul>
                                <p style="color:red">Aucun autre moyen de gagner des pixels pour le moment.</p>
                                <br />
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

                        <h2 class="title">Ton porte monnaie
                        </h2>
                        <div id="purse-habblet">

                            <ul>
                                <li class="even icon-pixels">
                                    <div>Tu as actuellement:</div>
                                    <span class="purse-balance-amount"><?php echo $user['pixels']; ?> Pixels</span>
                                    <div class="purse-tx"><a href="transactions">Mes transactions</a></div>
                                </li>
                                <?php if ($user['pixels'] <= 10) { ?>

                                    <li class="odd">
                                        <div style="text-align:center" class="box-content">
                                            <a href="pixels?generatePixels" id="purse-redeemcode-button" class="new-button purse-icon"><b><span></span>Générer 100 pixels</b><i></i></a>
                                        </div>
                                    </li>
                                    <?php if (isset($affichage)) {
                                        echo $affichage;
                                    } ?>
                                <?php } else { ?>
                                    <br />
                                    <center>
                                        <div style="width:80%;" class="redeem-error">
                                            <div style="text-align:center" class="rounded rounded-green">
                                                Génial, tu as assez de pixels !
                                            </div>
                                        </div>
                                    </center>
                                <?php } ?>
                            </ul>
                            <div id="purse-redeem-result">
                            </div>

                        </div>

                        <script type="text/javascript">
                            new PurseHabblet();
                        </script>


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
                                <p class="pixels-text">Grâce aux Pixels, vous pouvez sortir du lot grâce à des effets sensationnels, voiture, hoverbard...</p>
                                <p class="pixels-text"><b>Le choix te reviens !</b></p>
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

                        <h2 class="title">En manque de Pixels ?</h2>
                        <div id="pixels-info" class="box-content pixels-info">
                            <div class="pixels-info-text clearfix">

                                <img class="pixels-image" src="<?php echo $url; ?>/web-gallery/v2/images/activitypoints/pixelpage_discounts.png" alt="" />
                                <p class="pixels-text">Tu as moins de 10 Pixels, et tu souhaites refaire le plein ?</p>
                                <p class="pixels-text"><b>Génère dès maintenant 100 Pixels !</b></p>
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