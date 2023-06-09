<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

require_once('./config.php');

$pageid = "credits";
$pagename = "Crédits";

if (!isset($_SESSION['username'])) {
    Redirect("" . $url . "/index");
    exit;
}

if (isset($_GET['generateCredits'])) {
    if ($user['credits'] <= 1000) {
        if ($user['online'] != 1) {
            $reqCredits = $bdd->prepare("UPDATE users SET credits = credits + 5000  WHERE id = ?");
            $reqCredits->execute([$user['id']]);
            $insertn1 = $bdd->prepare("INSERT INTO gabcms_transaction (user_id, produit, prix, gain, date) VALUES (:userid, :produit, :prix, :gain, :date)");
            $insertn1->bindValue(':userid', $user['id']);
            $insertn1->bindValue(':produit', 'Offre SCF (Sans crédit fixe) +5000');
            $insertn1->bindValue(':prix', 0);
            $insertn1->bindValue(':gain', '+');
            $insertn1->bindValue(':date', FullDate('full'));
            $insertn1->execute();
            $affichage = "<div id=\"purse-redeem-result\"><div class=\"redeem-error\"><div class=\"rounded rounded-green\"> Nous venons de t'envoyer <b>5000 crédits</b>!</div></div></div>";
        } else {
            @SendMUSData('givecredits', ['user_id' => $user['id'], 'credits' => 5000]);
            $affichage = "<div id=\"purse-redeem-result\"><div class=\"redeem-error\"><div class=\"rounded rounded-green\"> Regarde sur ton client, tu as reçu <b>5000 crédits</b>!</div></div></div>";
        }
    } else {
        $affichage = "<div id=\"purse-redeem-result\"><div class=\"redeem-error\"><div class=\"rounded rounded-red\">Tu as assez de crédits.</div></div></div>";
    }
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
        var habboImagerUrl = "<?PHP echo $avatarimage; ?>";
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
        <div id='content'>
            <div id='column1' class='column'>
                <div class='habblet-container '>
                    <div class='cbb clearfix green '>
                        <h2 class='title'>Obtenir des crédits !</h2>
                        <p class='credits-countries-select'><img class='credits-image' src='./web-gallery/album1/palmchair.gif' align='left' />Pour acheter des mobis ou jouer à des jeux, il faut des <b>crédits</b>. </p>
                        <p>Nous vous fournissons des crédits gratuits lors de votre inscription et, si vous n'en avez plus, vous pouvez gagner des crédits de différentes manières:</p>
                        <ul>
                            <li>&nbsp;&nbsp;&nbsp;* En cliquant sur "<b>Générer 5000 crédits</b>".</li><br />
                            <li>&nbsp;&nbsp;&nbsp;* En restant connecté sur le client.</li>
                        </ul>
                        <br />
                        <p style="color:red">Aucun autre moyen de gagner des crédits pour le moment.</p>
                    </div>
                </div>
                <script type='text/javascript'>
                    if (!$(document.body).hasClassName('process-template')) {
                        Rounder.init();
                    }
                </script>

            </div>
            <div id="column2" class="column">
                <div class="habblet-container ">
                    <div class="cbb clearfix brown ">

                        <h2 class="title">Ton porte monnaie
                        </h2>
                        <div id="purse-habblet">

                            <ul>
                                <li class="even icon-purse">
                                    <div>Tu as actuellement:</div>
                                    <span class="purse-balance-amount"><?php echo $user['credits']; ?> Cr&eacute;dits</span>
                                    <div class="purse-tx"><a href="transactions">Mes transactions</a></div>
                                </li>
                                <?php if ($user['credits'] <= 1000) { ?>
                                    <li class="odd">
                                        <div style="text-align:center" class="box-content">
                                            <a href="credits?generateCredits" id="purse-redeemcode-button" class="new-button purse-icon"><b><span></span>Générer 5000 crédits</b><i></i></a>
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
                                                Génial, tu as assez de crédits !
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





                </div>
                <script type="text/javascript">
                    if (!$(document.body).hasClassName('process-template')) {
                        Rounder.init();
                    }
                </script>


                <div class='habblet-container '>
                    <div class='cbb clearfix blue '>

                        <h2 class='title'>Que sont les crédits ?</h2>
                        <div id='credits-promo' class='box-content credits-info'>
                            <div class='credit-info-text clearfix'>
                                <p><img class="credits-image" src="./web-gallery/v2/images/credits_permission.png" align="left" width="114" height="136" />Les crédits sont la monnaie de <?php echo $sitename; ?>.</p>
                                <p>Vous pouvez les utiliser pour acheter toutes sortes de choses, des canards en caoutchouc aux canapés, en passant par l'adhésion au <?php echo $shortname; ?> Club, les juke-boxes et les téléports.</p>
                            </div>


                        </div>
                    </div>

                    <script type='text/javascript'>
                        if (!$(document.body).hasClassName('process-template')) {
                            Rounder.init();
                        }
                    </script>


                </div>

                <script type="text/javascript">
                    HabboView.run();
                </script>
            </div>
            <script type="text/javascript">
                if (!$(document.body).hasClassName('process-template')) {
                    Rounder.init();
                }
            </script>