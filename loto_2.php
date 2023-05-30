<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("./config.php");
$pagename = "Loto";
$pageid = "loto";
$my_id = $user['id'];

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

if (!isset($pseudo['jetons'])) {
    Redirect($url . "/error");
}

$resultat1 = random_int(1, 50);
$resultat2 = random_int(1, 100);
$resultat3 = random_int(1, 200);
$resultat4 = random_int(1, 500);
$resultat5 = random_int(1, 1500000);
$tirage = $_GET["tirage"] ?? '';
$temps_interdit1 = "1H";
$temps_interdit2 = 3600;
$resultat = '';
$gain = '';
$numero_a_trouver = '';

if ($tirage === "1") {
    $resultat = $resultat1;
    $gain = "500.000 crédits";
    $numero_a_trouver = rand(1, 50);
} elseif ($tirage === "2") {
    $resultat = $resultat2;
    $gain = "1000.000 crédits";
    $numero_a_trouver = rand(1, 100);
} elseif ($tirage === "3") {
    $resultat = $resultat3;
    $gain = "10 rares";
    $numero_a_trouver = rand(1, 200);
} elseif ($tirage === "4") {
    $resultat = $resultat4;
    $gain = "une adhésion au VIP Club";
    $numero_a_trouver = rand(1, 500);
} elseif ($tirage === "5") {
    $resultat = $resultat5;
    $gain = "10000 jetons";
    $numero_a_trouver = rand(1, 1500000);
} else {
    $resultat = "ERREUR";
}

$temps_actuelle = time();
$temps_interdit3 = $temps_actuelle + $temps_interdit2;

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
                <div class='habblet-container '>
                    <div class='cbb clearfix green '>
                        <h2 class='title'>Loto: Tirage</h2>
                        <p class='credits-countries-select'>
                            <?php
                            // Vérifier si l'utilisateur a suffisamment de tickets pour jouer
                            if ($user['tickets'] < 1) {
                                echo "Désolé, vous n'avez pas assez de tickets pour jouer.";
                            } else {
                                $stmt = $bdd->prepare("SELECT * FROM loto WHERE user_id = :my_id AND tirage = :tirage AND temps > :temps_actuelle");
                                $stmt->bindParam(':my_id', $user['id']);
                                $stmt->bindParam(':tirage', $tirage);
                                $stmt->bindParam(':temps_actuelle', $temps_actuelle);
                                $stmt->execute();
                                $acces = $stmt->fetchAll();

                                if ($resultat == "ERREUR") {
                                    echo "Il semble que le tirage sélectionné ne soit pas disponible.";
                                } else {
                                    if (count($acces) > 0) {
                                        echo "Désolé, mais vous avez déjà participé au tirage $tirage il y a moins de $temps_interdit1.<br>Ressayez plus tard!";
                                    } else {
                                        $stmt = $bdd->prepare("UPDATE users SET tickets = tickets - 1 WHERE id = :my_id");
                                        $stmt->bindParam(':my_id', $user['id']);
                                        $stmt->execute();
                                        echo "Vous venez de participer au tirage $tirage pour gagner <b>$gain</b>.<br>";
                                        echo "Le numéro à trouver est: <b>$numero_a_trouver</b>.<br>";
                                        echo "Le numéro tiré est: <b><u>$resultat</u></b>.<br><br>";
                                        if ($numero_a_trouver == $resultat) {
                                            switch ($resultat) {
                                                case $resultat1:
                                                    $stmt = $bdd->prepare("UPDATE users SET pixels = pixels + 500.000 WHERE id = :my_id");
                                                    break;
                                                case $resultat2:
                                                    $stmt = $bdd->prepare("UPDATE users SET pixels = pixels + 1000.000 WHERE id = :my_id");
                                                    break;
                                                case $resultat3:
                                                    $stmt = $bdd->prepare("SELECT id, username FROM users WHERE username = :username");
                                                    $stmt->bindParam(':username', $_SESSION['username']);
                                                    $stmt->execute();
                                                    $donnees_du_habbo = $stmt->fetch();
                                                    $id_habbo = $donnees_du_habbo['id'];

                                                    // Ajouter les autres requêtes pour insérer les données de furniture

                                                    break;
                                                case $resultat4:
                                                    if ($user_rank < "3") {
                                                        $stmt = $bdd->prepare("UPDATE users SET rank = '3' WHERE id = :my_id");
                                                        $stmt->bindParam(':my_id', $my_id);
                                                        $stmt->execute();

                                                        $stmt = $bdd->prepare("SELECT * FROM users_badges WHERE userid = :my_id AND badgeid = 'VIP'");
                                                        $stmt->bindParam(':my_id', $my_id);
                                                        $stmt->execute();
                                                        $nombre_badge_vip = $stmt->rowCount();

                                                        if ($nombre_badge_vip == 0) {
                                                            $stmt = $bdd->prepare("INSERT INTO users_badges (user_id, badge_code, slot_id) VALUES (:my_id, 'VIP', '0')");
                                                            $stmt->bindParam(':my_id', $my_id);
                                                            $stmt->execute();

                                                            $stmt = $bdd->prepare("UPDATE users SET pixels = pixels + 100000 WHERE id = :my_id");
                                                            $stmt->bindParam(':my_id', $my_id);
                                                            $stmt->execute();

                                                            // Ajouter les autres requêtes pour insérer les badges et les meubles
                                                        }
                                                    } else {
                                                        $stmt = $bdd->prepare("SELECT id, name FROM users WHERE username = :username");
                                                        $stmt->bindParam(':username', $_SESSION['username']);
                                                        $stmt->execute();
                                                        $donnees_du_habbo = $stmt->fetch();
                                                        $id_habbo = $donnees_du_habbo['id'];

                                                        // Ajouter les autres requêtes pour insérer les données de furniture

                                                        $erreur = "1";
                                                        $gain = "10 rares";
                                                    }
                                                    break;

                                                case $resultat5:
                                                    if ($user_rank <= 2) {
                                                        $stmt = $bdd->prepare("UPDATE users SET jetons = 10000 WHERE id = :my_id");
                                                        $stmt->bindParam(':my_id', $my_id);
                                                        $stmt->execute();
                                                    } else {
                                                        echo "Les staffs sont interdits de jouer au gros lot";
                                                    }
                                                    break;
                                            }

                                            if (isset($stmt)) {
                                                $stmt->bindParam(':my_id', $my_id);
                                                $stmt->execute();
                                            }

                                            echo "Félicitations, tu as tiré le bon numéro!";
                                            if ($erreur == "1") {
                                                echo " Toutefois, tu es déjà VIP.";
                                            }
                                            echo " Tu as" . ($erreur == "1" ? " donc" : "") . " gagné <b>$gain</b>!";
                                            $stmt = $bdd->prepare("INSERT INTO loto (user_id, tirage, temps, gagne) VALUES (:my_id, :tirage, :temps_interdit3, '1')");
                                            $stmt->bindParam(':my_id', $user['id']);
                                            $stmt->bindParam(':tirage', $tirage);
                                            $stmt->bindParam(':temps_interdit3', $temps_interdit3);
                                            $stmt->execute();
                                        } else {
                                            echo "Désolé, mais tu as perdu. Retente ta chance dans $temps_interdit1.";
                                            $stmt = $bdd->prepare("INSERT INTO loto (user_id, tirage, temps, gagne) VALUES (:my_id, :tirage, :temps_interdit3, '0')");
                                            $stmt->bindParam(':my_id', $user['id']);
                                            $stmt->bindParam(':tirage', $tirage);
                                            $stmt->bindParam(':temps_interdit3', $temps_interdit3);
                                            $stmt->execute();
                                        }
                                    }
                                }
                            }
                            ?>

                        </p>
                    </div>
                </div>
                <script type='text/javascript'>
                    if (!$(document.body).hasClassName('process-template')) {
                        Rounder.init();
                    }
                </script>
            </div>
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
    <?php

    include('template/footer.php');

    ?>