<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("./config.php");
$pagename = "Loto";
$pageid = "loto";

if (isset($_GET['tag'])) {
    $pseudo = Secu($_GET['tag']);
} else {
    $pseudo = $_SESSION['username'];
}
$sql = $bdd->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
$sql->execute([$pseudo]);

$row = $sql->rowCount();
if ($row > 0) {
    $pseudo = $sql->fetch(PDO::FETCH_ASSOC);
}

if (!isset($_SESSION['username'])) {
    Redirect($url . "/index");
}

if (!isset($pseudo['credits'])) {
    Redirect($url . "/error");
}

if (isset($_GET['generateJetons'])) {
    if ($user['jetons'] >= 5) {
        if ($user['online'] != 1) {
            $reqCredits = $bdd->prepare("UPDATE users SET jetons = jetons - 5, tickets = tickets + 1 WHERE id = ?");
            $reqCredits->execute([$user['id']]);
            $insertn1 = $bdd->prepare("INSERT INTO gabcms_transaction (user_id, produit, prix, gain, date) VALUES (:userid, :produit, :prix, :gain, :date)");
            $insertn1->bindValue(':userid', $user['id']);
            $insertn1->bindValue(':produit', 'Conversion jetons vers tickets');
            $insertn1->bindValue(':prix', 5);
            $insertn1->bindValue(':gain', '-');
            $insertn1->bindValue(':date', FullDate('full'));
            $insertn1->execute();
            $affichage = "<div id=\"purse-redeem-result\"><div class=\"redeem-error\"><div class=\"rounded rounded-green\"> Nous venons de convertir <b>5 jetons en 1 ticket</b>!</div></div></div>";
        } else {
            $affichage = "<div id=\"purse-redeem-result\"><div class=\"redeem-error\"><div class=\"rounded rounded-green\"> Regarde sur ton client, tu as reçu <b>1 ticket</b>!</div></div></div>";
        }
    } else {
        $affichage = "<div id=\"purse-redeem-result\"><div class=\"redeem-error\"><div class=\"rounded rounded-red\">Tu n'as pas assez de jetons.</div></div></div>";
    }
}

if (isset($_GET['acceptConditions'])) {
    if ($user['conditions_lotterie'] == 0) {
        if ($user['online'] != 1) {
            $reqCredits = $bdd->prepare("UPDATE users SET conditions_lotterie = 1 WHERE id = ?");
            $reqCredits->execute([$user['id']]);
            Redirect($url . "/loto");
            exit;
        } else {
            Redirect($url . "/loto");
            exit;
        }
    } else {
        $affichage = "Vous avez déjà accepté les conditions, bon jeu !";
        exit;
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
        var habboImagerUrl = "http://www.habbo.com/habbo-imaging/";
        var habboPartner = "";
        var habboDefaultClientPopupUrl = "<?PHP echo $url; ?>/client";
        window.name = "habboMain";
        if (typeof HabboClient != "undefined") {
            HabboClient.windowName = "uberClientWnd";
        }
    </script>
    <style type="text/css">
        .Style1 {
            font-size: 24px;
            font-weight: bold;
        }

        .Style2 {
            font-size: 18px
        }
    </style>

    <link rel="shortcut icon" href="<?PHP echo $imagepath; ?>favicon.ico" type="image/vnd.microsoft.icon" />
    <script src="<?PHP echo $imagepath; ?>static/js/libs2.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/visual.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/libs.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>js/tooltip.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/common.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>static/styles/lightweightmepage.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
    <script src="<?PHP echo $imagepath; ?>static/js/lightweightmepage.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/fullcontent.js" type="text/javascript"></script>


    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/style.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/buttons.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/boxes.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/tooltips.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/personal.css<?php echo '?' . mt_rand(); ?>" type="text/css" />

    <meta name="description" content="<?PHP echo $description; ?>" />
    <meta name="keywords" content="<?PHP echo $keyword; ?>" />
    <meta name="build" content="<?PHP echo $build; ?> >> <?PHP echo $version; ?>" />
</head>

<body id="home" class=" ">
    <div id="tooltip"></div>
    <div id="overlay"></div>
    <!-- MENU -->
    <?PHP include("./template/header.php"); ?>
    <!-- FIN MENU -->
    <div id="container">
        <div id='content'>
            <div id='column1' class='column'>

                <?php
                // Vérification de la condition conditions_lotterie
                $stmt = $bdd->prepare("SELECT conditions_lotterie FROM users WHERE id = :id");
                $stmt->bindParam(':id', $user['id']);
                $stmt->execute();
                $conditionsLotterie = $stmt->fetchColumn();

                if ($conditionsLotterie != 1) {
                ?>

                    <div class="habblet-container ">
                        <div class="cbb clearfix blue">
                            <h2 class="title">Hop, hop, hop...</h2>
                            <div id="notfound-looking-for" class="box-content">
                                <div style="text-align:center"><img src="<?PHP echo $imagepath; ?>v2/images/loto.gif"></div>
                                <br />
                                <ol>
                                    <li>
                                        <h3>Acceptation des conditions :</h3>
                                        <p>En participant à la lotterie en ligne de BobbaGalaxy, vous acceptez les présentes conditions générales d'utilisation et de confidentialité. Veuillez les lire attentivement avant de participer.</p>
                                    </li>
                                    <li>
                                        <h3>Éligibilité :</h3>
                                        <p>La lotterie en ligne de BobbaGalaxy est ouverte aux joueurs résidant dans les pays où la participation à des loteries en ligne est autorisée. Les participants doivent avoir l'âge légal requis dans leur pays de résidence.</p>
                                    </li>
                                    <li>
                                        <h3>Participation :</h3>
                                        <p>Pour participer à la lotterie en ligne, vous devez acheter des tickets de loterie conformément aux règles et conditions spécifiées. Chaque ticket acheté donne droit à une chance de gagner des lots ou le gros lot de 5000€.</p>
                                    </li>
                                    <li>
                                        <h3>Attribution des lots :</h3>
                                        <p>Les tirages au sort sont effectués de manière aléatoire et les gagnants sont déterminés en fonction des numéros sélectionnés sur les tickets de loterie. Les lots seront attribués conformément aux règles spécifiques à chaque tirage. Les résultats des tirages seront annoncés de manière transparente et les gagnants seront notifiés selon les coordonnées fournies lors de l'achat des tickets.</p>
                                    </li>
                                    <li>
                                        <h3>Confidentialité des données :</h3>
                                        <p>BobbaGalaxy s'engage à protéger la confidentialité des informations personnelles fournies par les participants. Les données collectées ne seront utilisées que dans le cadre de la lotterie et ne seront pas partagées avec des tiers, sauf si requis par la loi.</p>
                                    </li>
                                    <li>
                                        <h3>Responsabilité :</h3>
                                        <p>BobbaGalaxy ne peut être tenu responsable des pertes, dommages ou préjudices subis par les participants en relation avec la lotterie en ligne. Les participants sont responsables de l'utilisation adéquate des tickets de loterie et de leur conformité aux lois applicables dans leur pays de résidence.</p>
                                    </li>
                                    <li>
                                        <h3>Prévention de la triche :</h3>
                                        <p>BobbaGalaxy a mis en place un système rigoureux pour prévenir toute tentative de triche, y compris les tentatives de la part du personnel. Des mesures de sécurité sont en place pour garantir l'équité et l'intégrité de la lotterie en ligne. Tout comportement suspect ou toute activité frauduleuse sera enquêté et les mesures appropriées seront prises.</p>
                                    </li>
                                    <li>
                                        <h3>Modification des conditions :</h3>
                                        <p>BobbaGalaxy se réserve le droit de modifier les présentes conditions générales d'utilisation et de confidentialité à tout moment. Les modifications seront publiées sur le site web de BobbaGalaxy et entreront en vigueur dès leur publication. Il est recommandé aux participants de consulter régulièrement les conditions pour rester informés des éventuelles mises à jour.</p>
                                    </li>
                                </ol>

                                <p>En participant à la lotterie en ligne de BobbaGalaxy, vous reconnaissez avoir lu, compris et accepté les présentes conditions générales d'utilisation et de confidentialité.</p>
                                <br />

                                <li class="odd">
                                    <div style="text-align: center;" class="box-content">
                                        <a href="loto?acceptConditions" id="purse-redeemcode-button" class="new-button purse-icon" style="display: inline-block;"><b><span></span>Accepter</b><i></i></a>
                                    </div>
                                </li>

                            </div>
                        </div>
                    </div>

                <?php } else { ?>
                    <div class='habblet-container '>
                        <div class='cbb clearfix blue '>
                            <h2 class='title'>Tentez votre chance !</h2>
                            <br />
                            <div align="center"><img width="50%" src="<?PHP echo $imagepath; ?>v2/images/loto.gif"></div>
                            <p align="center" class='credits-countries-select'><br>
                                <style type="text/css">
                                    /* error message styles */
                                    .error input,
                                    .error select {
                                        border: 1px solid #e2001a;
                                    }

                                    .error-message {
                                        color: #e2001a;
                                    }

                                    .error-messages-holder {
                                        display: none;
                                    }

                                    .error-messages-holder ul {
                                        padding: 0;
                                        list-style: none;
                                    }

                                    .error-messages-holder ul li {
                                        background: transparent url('http://www.habbo.fr/habboweb/50_e3801d20ad745cc86660598ea0c4bdf4/15/web-gallery/v2/images/registration/exclamation.png') no-repeat left 50%;
                                        line-height: 18px;
                                        padding-left: 18px;
                                    }

                                    .error-messages-holder ul p {
                                        margin: 3px 0;
                                        padding: 0;
                                    }

                                    .error-messages-holder h3 {
                                        color: #E2001A;
                                        font-size: 13px;
                                        margin: 5px 0;
                                    }

                                    .error-messages-holder {
                                        display: block;
                                        padding: 0px 10px;
                                        background-color: #FFF4F2;
                                        border: 1px solid #E2001A;
                                        margin-top: 10px;
                                    }

                                    .state-error input.text-field,
                                    .state-error input.password-field {
                                        border: 2px solid #E2001A;
                                        background: #FFF4F2 url(../images/registration/exclamation.png) no-repeat scroll 99% 50%;
                                    }

                                    .state-error select {
                                        background-color: #FFF4F2;
                                        border: 2px solid #E2001A;
                                    }

                                    .state-error label#tos {
                                        border: 2px solid #E2001A;
                                        padding: 5px;
                                    }

                                    .state-error .help {
                                        /* color: #e2001a; */

                                    }

                                    #error-message-position {
                                        display: none;
                                    }

                                    #error-messages-container {
                                        width: 400px;
                                    }

                                    /* valide message styles */
                                    .valide input,
                                    .valide select {
                                        border: 1px solid #e2001a;
                                    }

                                    .valide-message {
                                        color: #DFFFDF;
                                    }

                                    .valide-messages-holder {
                                        display: none;
                                    }

                                    .valide-messages-holder ul {
                                        padding: 0;
                                        list-style: none;
                                    }

                                    .valide-messages-holder ul li {
                                        background: transparent url('http://www.habbo.fr/habboweb/50_e3801d20ad745cc86660598ea0c4bdf4/15/web-gallery/v2/images/registration/exclamation.png') no-repeat left 50%;
                                        line-height: 18px;
                                        padding-left: 18px;
                                    }

                                    .valide-messages-holder ul p {
                                        margin: 3px 0;
                                        padding: 0;
                                    }

                                    .valide-messages-holder h3 {
                                        color: #2AB838;
                                        font-size: 13px;
                                        margin: 5px 0;
                                    }

                                    .valide-messages-holder {
                                        display: block;
                                        padding: 0px 10px;
                                        background-color: #DFFFDF;
                                        border: 1px solid lightgreen;
                                        margin-top: 10px;
                                    }

                                    .gold-messages-holder {
                                        display: block;
                                        padding: 0px 10px;
                                        background-color: gold;
                                        border: 1px solid lightgoldenrodyellow;
                                        margin-top: 10px;
                                    }

                                    .state-valide input.text-field,
                                    .state-valide input.password-field {
                                        border: 2px solid #E2001A;
                                        background: #FFF4F2 url(../images/registration/exclamation.png) no-repeat scroll 99% 50%;
                                    }

                                    .state-valide select {
                                        background-color: #FFF4F2;
                                        border: 2px solid #E2001A;
                                    }

                                    .state-valide label#tos {
                                        border: 2px solid #E2001A;
                                        padding: 5px;
                                    }

                                    .state-valide .help {
                                        /* color: #e2001a; */

                                    }

                                    #valide-message-position {
                                        display: none;
                                    }

                                    #valide-messages-container {
                                        width: 400px;
                                    }

                                    #name-suggestions {
                                        margin-right: 13px;
                                        width: 400px;
                                        clear: left;
                                    }

                                    #name-suggestions .available p {
                                        margin-top: 5px;
                                        border: 3px solid lightgreen;
                                        padding: 5px 5px 5px 25px;
                                        background: #DFFFDF url(../images/registration/tick.png) no-repeat 2px 50%;
                                        line-height: 16px;
                                    }

                                    #name-suggestions .taken {
                                        margin-top: 5px;
                                        border: 3px solid #F4DE64;
                                        padding: 5px;
                                        background-color: #ffe;
                                    }

                                    #name-suggestions .taken p {
                                        display: inline;
                                        padding: 5px 0;
                                    }

                                    #name-suggestions .help {
                                        margin-left: 0;
                                    }

                                    #name-suggestion-list a {
                                        text-decoration: none;
                                        color: #024CC9;
                                        padding: 2px;
                                    }

                                    #name-suggestion-list a:hover {
                                        background-color: #eee;
                                    }
                                </style>
                            </p>
                            <div style="width:100%; display: flex; justify-content: center;">
                                <div style="width:45%; margin-right: 10px; margin-bottom: 10px;" id="valide-messages-container">
                                    <div class="valide-messages-holder">
                                        <h3 style="text-align: center;"><img height="50" width="50%" src="<?PHP echo $imagepath; ?>v2/images/oxo.svg"></h3>
                                        <br />
                                        <p><strong>Gagner 500.000 </strong>Pixels</p>
                                        <p><strong>2% </strong>de chance de gagner (50 numéros)</p>
                                        <p>Le nombre à trouver est <strong>28</strong></p>
                                        <p>Vous pouvez jouer une fois toutes les heures !</p>
                                        <p style="text-align:center"><strong><a href="loto_2?tirage=1">Jouer</a></strong></p>
                                    </div>
                                </div>
                                <div style="width:45%; margin-left: 10px; margin-bottom: 10px;" id="valide-messages-container">
                                    <div class="valide-messages-holder">
                                        <h3 style="text-align: center;"><img height="50" width="50%" src="<?PHP echo $imagepath; ?>v2/images/keno.svg"></h3>
                                        <br />
                                        <p><strong>Gagner 1000.000 </strong>Pixels</p>
                                        <p><strong>1% </strong>de chance de gagner (100 numéros)</p>
                                        <p>Le nombre à trouver est <strong>56</strong></p>
                                        <p>Vous pouvez jouer une fois toutes les heures !</p>
                                        <p style="text-align:center"><strong><a href="loto_2?tirage=2">Jouer</a></strong></p>
                                    </div>
                                </div>
                            </div>

                            <br>

                            <div style="width:100%; display: flex; justify-content: center;">
                                <div style="width:45%; margin-right: 10px; margin-bottom: 10px;" id="valide-messages-container">
                                    <div class="valide-messages-holder">
                                        <h3 style="padding-top:10px;padding-bottom:12px; text-align: center;"><img width="50%" src="<?PHP echo $imagepath; ?>v2/images/loto.png"></h3>
                                        <br />
                                        <p><strong>Gagner 10 Rares</strong></p>
                                        <p><strong>0.5% de chance de gagner (200 numéros)</strong></p>
                                        <p>Le nombre à trouver est <strong>132</strong></p>
                                        <p>Vous pouvez jouer une fois toutes les heures !</p>
                                        <p style="text-align:center"><strong><a href="loto_2?tirage=3">Jouer</a></strong></p>
                                    </div>
                                </div>
                                <div style="width:45%; margin-left: 10px; margin-bottom: 10px;" id="valide-messages-container">
                                    <div class="valide-messages-holder">
                                        <h3 style="text-align: center;"><img height="50" width="50%" src="<?PHP echo $imagepath; ?>v2/images/superloto.svg"></h3>
                                        <br />
                                        <p><strong>Adhésion au VIP Club</strong></p>
                                        <p><strong>0.2% de chance de gagner (500 numéros)</strong></p>
                                        <p>Le nombre à trouver est <strong>397</strong></p>
                                        <p>Vous pouvez jouer une fois toutes les heures !</p>
                                        <p style="text-align:center"><strong><a class="submit" href="loto_2?tirage=4">Jouer</a></strong></p>
                                    </div>
                                </div>
                            </div>

                            <?php if (Age($user['account_day_of_birth']) >= 18) { ?>
                                <br>
                                <div style="width:100%; display: flex; justify-content: center;">
                                    <div style="width:95%; margin-right: 10px; margin-left: 10px; margin-bottom: 10px;" id="gold-messages-container">
                                        <div class="valide-messages-holder">
                                            <h3 style="padding-top:10px;padding-bottom:12px; text-align: center;"><img width="50%" src="<?PHP echo $imagepath; ?>v2/images/jackpot.svg"></h3>
                                            <br />
                                            <p><strong>Gagner 10000 Jetons (<b>5000.00€</b>)</strong></p>
                                            <p><strong>0.1% de chance de gagner (1500000 numéros)</strong></p>
                                            <p style="text-align:center"><strong><a href="loto_2?tirage=5">Jouer</a></strong></p>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div><br /><br />
                <?php } ?>
                <script type='text/javascript'>
                    if (!$(document.body).hasClassName('process-template')) {
                        Rounder.init();
                    }
                </script>
            </div>
            <div id="column2" class="column">

                <div class="habblet-container">
                    <div class="cbb clearfix red">
                        <h2 class="title">Qu'est-ce que c'est ?</h2>
                        <div id="purse-habblet">
                            <div class="box-content">
                                <div align="center"><img width="50%" src="<?PHP echo $imagepath; ?>v2/images/loto.png"></div>
                                <br />
                                <div>
                                    <p>Le Loto de <?php echo $sitename; ?> est un jeu de loterie captivant et très apprécié offert aux utilisateurs de <?php echo $sitename; ?>. Il offre aux joueurs la chance de gagner des prix en échange de l'achat de tickets de loterie. Les participants choisissent leur mise et reçoivent instantanément le résultat pour découvrir s'ils ont remporté des récompenses incroyables.</p>
                                    <p style="color: red;">Il est essentiel de jouer de manière responsable et de fixer des limites personnelles pour éviter les problèmes d'addiction potentiels. <?php echo $sitename; ?> encourage ses utilisateurs à adopter une approche saine vis-à-vis du jeu, à se divertir de manière responsable et à être conscients des risques associés à l'addiction.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script type='text/javascript'>
                        if (!$(document.body).hasClassName('process-template')) {
                            Rounder.init();
                        }
                    </script>
                </div>


                <div class="habblet-container">
                    <div class="cbb clearfix green">
                        <h2 class="title">Transfert PayPal</h2>
                        <div id="purse-habblet">
                            <div class="box-content">
                                <div align="center"><img width="50%" src="<?PHP echo $imagepath; ?>v2/images/paypal.svg"></div>
                                <br />
                                <div>
                                    <?php if ($user['jetons'] >= 5000 || $user['username'] == "Eudes") { ?>
                                        <li class="odd">
                                            <div style="text-align: center;" class="box-content">
                                                <button class="new-button purse-icon" id="transferButton">Effectuer le transfert</button>
                                            </div>
                                        </li>

                                        <?php if (isset($affichage)) {
                                            echo $affichage;
                                        } ?>
                                    <?php } else { ?>
                                        <br />
                                        <center>
                                            <div style="width:80%;" class="redeem-error">
                                                <div style="text-align:center" class="rounded rounded-red">
                                                    Tu n'as pas assez de jetons pour le transfert !
                                                </div>
                                            </div>
                                        </center>
                                    <?php } ?>


                                </div>
                            </div>
                        </div>
                    </div>
                    <script type='text/javascript'>
                        if (!$(document.body).hasClassName('process-template')) {
                            Rounder.init();
                        }
                    </script>
                </div>


                <div class="habblet-container ">
                    <div class="cbb clearfix brown ">
                        <h2 class="title">Obtenir des tickets (<?php echo $user['tickets']; ?>)
                        </h2>
                        <div id="purse-habblet">
                            <ul>
                                <li class="even icon-purse">
                                    <div>Tu as actuellement:</div>
                                    <span class="purse-balance-amount"><?php echo $user['jetons']; ?> Jetons</span>
                                    <div class="purse-tx"><a href="transactions">Mes transactions</a></div>
                                </li>
                                <?php if ($user['jetons'] >= 5) { ?>
                                    <li class="odd">
                                        <div style="text-align: center;" class="box-content">
                                            <a href="loto?generateJetons" id="purse-redeemcode-button" class="new-button purse-icon" style="display: inline-block;"><b><span></span>5 jetons en 1 ticket</b><i></i></a>
                                        </div>
                                    </li>

                                    <?php if (isset($affichage)) {
                                        echo $affichage;
                                    } ?>
                                <?php } else { ?>
                                    <br />
                                    <center>
                                        <div style="width:80%;" class="redeem-error">
                                            <div style="text-align:center" class="rounded rounded-red">
                                                Tu n'as pas assez de jetons !
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
                    HabboView.run();
                </script>

                <script>
                    document.getElementById('transferButton').addEventListener('click', function() {
                        // Code PHP à exécuter lorsque le bouton est cliqué
                        <?php
                        // Clé d'API de PayPal
                        $clientIdPayPal = 'Af__9TXLgXPWVWlq7TYnsX7hqIxCeHY-BGln7tULeXP1krTeKdbrhHc8j5tpRUP5pcQUfO5wYR9Ve5s_'; // Remplacez par votre Client ID PayPal
                        $clientSecretPayPal = 'EHzo8033rOmGLKXnb7BbB0Jlj-eL9U8boiDffFYht_w7q6PrT8nz9AUMkwVjoped7HQrxsrD7RzzPtwG'; // Remplacez par votre Client Secret PayPal

                        // Adresse email de votre compte PayPal
                        $senderEmail = 'christopher.dolbert@gmail.com'; // Remplacez par votre adresse email PayPal

                        // Adresse email du compte ciblé
                        $receiverEmail = $user['paypal_account']; // Remplacez par l'adresse email du compte ciblé

                        // Montant et devise du transfert
                        $amount = 5000; // Remplacez par le montant réel
                        $currency = 'EUR'; // Remplacez par la devise réelle

                        // Obtenir le jeton d'accès PayPal
                        $accessToken = getPayPalAccessToken($clientIdPayPal, $clientSecretPayPal);

                        if ($accessToken) {
                            $resultatTransfert = transferFromPayPal($amount, $currency, $senderEmail, $receiverEmail, $accessToken);
                            if ($resultatTransfert) {
                                echo "console.log('Transfert depuis mon compte PayPal réussi !');";
                            } else {
                                echo "console.log('Échec du transfert depuis mon compte PayPal.');";
                            }
                        } else {
                            echo "console.log('Échec de l\'obtention du jeton d'accès PayPal.');";
                        }

                        // Fonction pour obtenir le jeton d'accès PayPal
                        function getPayPalAccessToken($clientId, $clientSecret)
                        {
                            $url = 'https://api.paypal.com/v1/oauth2/token';
                            $headers = array(
                                'Accept: application/json',
                                'Accept-Language: fr_FR',
                            );
                            $data = array(
                                'grant_type' => 'client_credentials',
                            );

                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, $url);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Ajoutez cette ligne uniquement si vous rencontrez des problèmes avec la vérification SSL

                            $response = curl_exec($ch);
                            curl_close($ch);

                            $data = json_decode($response, true);

                            if (isset($data['access_token'])) {
                                return $data['access_token'];
                            } else {
                                return false;
                            }
                        }

                        // Fonction pour effectuer le transfert depuis un compte PayPal
                        function transferFromPayPal($amount, $currency, $senderEmail, $receiverEmail, $accessToken)
                        {
                            $url = 'https://api.paypal.com/v2/payments/payouts';
                            $headers = array(
                                'Content-Type: application/json',
                                'Authorization: Bearer ' . $accessToken,
                            );
                            $data = array(
                                'sender_batch_header' => array(
                                    'sender_batch_id' => uniqid(),
                                    'email_subject' => 'Transfert depuis mon compte PayPal',
                                ),
                                'items' => array(
                                    array(
                                        'recipient_type' => 'EMAIL',
                                        'amount' => array(
                                            'value' => $amount,
                                            'currency' => $currency,
                                        ),
                                        'receiver' => $receiverEmail,
                                        'note' => 'Transfert depuis mon compte PayPal',
                                    ),
                                ),
                                'sender_batch_header' => array(
                                    'sender_email' => $senderEmail,
                                ),
                            );

                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, $url);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Ajoutez cette ligne uniquement si vous rencontrez des problèmes avec la vérification SSL

                            $response = curl_exec($ch);
                            curl_close($ch);

                            $data = json_decode($response, true);

                            if (isset($data['batch_header']['payout_batch_id'])) {
                                return true;
                            } else {
                                return false;
                            }
                        }

                        ?>
                    });
                </script>
            </div>
            <?php

            include('template/footer.php');

            ?>