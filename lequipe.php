<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("./config.php");
$pagename = "L'équipe";
$pageid = "staff";
$nowtime = time();

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
    <script src="<?PHP echo $imagepath; ?>static/js/minimail.js" type="text/javascript"></script>



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
body { behavior: url(http://www.habbo.com/js/csshover.htc); }
</style>
<![endif]-->
    <meta name="build" content="<?PHP echo $build; ?> >> <?PHP echo $version; ?>" />

    <style>
        table.fondateur {
            background-color: #fff;
            font-size: 11px;
            padding: 5px;
            margin-left: -15px;
            width: 111%;
        }

        table.fondateur:nth-child(2n+1) {
            background-color: #CCDFF2;
            font-size: 11px;
            padding: 5px;
            margin-left: -15px;
            width: 111%;
        }

        table.manager {
            background-color: #fff;
            font-size: 11px;
            padding: 5px;
            margin-left: -15px;
            width: 107%;
        }

        table.manager:nth-child(2n+1) {
            background-color: #F7F2C4;
            font-size: 11px;
            padding: 5px;
            margin-left: -15px;
            width: 107%;
        }

        table.admin {
            background-color: #fff;
            font-size: 11px;
            padding: 5px;
            margin-left: -15px;
            width: 107%;
        }

        table.admin:nth-child(2n+1) {
            background-color: #E4FFD2;
            font-size: 11px;
            padding: 5px;
            margin-left: -15px;
            width: 107%;
        }

        table.modo {
            background-color: #fff;
            font-size: 11px;
            padding: 5px;
            margin-left: -15px;
            width: 107%;
        }

        table.modo:nth-child(2n+1) {
            background-color: #FCDCDC;
            font-size: 11px;
            padding: 5px;
            margin-left: -15px;
            width: 107%;
        }
    </style>
</head>

<body id="home" class=" ">
    <div id="tooltip"></div>
    <div id="overlay"></div>

    <!-- MENU -->
    <?PHP include("./template/header.php"); ?>
    <!-- FIN MENU -->

    <div id="container">
        <div id="content" style="position: relative" class="clearfix">
            <div id="column2" class="column">
                <?php
                // Requête pour récupérer les informations des utilisateurs triées par grade
                $req = $bdd->prepare("SELECT u.id, u.username, u.motto, u.rank, u.online, u.look, p.rank_name AS rank_name, p.box_color AS box_color, p.description AS description FROM users u LEFT JOIN permissions p ON u.rank = p.id WHERE u.rank = 11 ORDER BY u.rank DESC");
                $req->execute();

                // Initialisation des variables
                $current_rank = null;
                $current_container = null;

                // Parcours des résultats de la requête
                while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                    $user_id = $row['id'];
                    $user_name = $row['username'];
                    $user_mission = $row['motto'];
                    $online = $row['online'];
                    $user_figure = $row['look'];
                    $rank_name = $row['rank_name'];
                    $box_color = $row['box_color'];
                    $description = $row['description'];

                    // Si le grade de l'utilisateur est différent du grade courant
                    if ($rank_name !== $current_rank) {
                        // Fermeture du container précédent (s'il existe)
                        if ($current_container !== null) {
                            echo '</div></div>';
                        }
                        // Création d'un nouveau container pour le nouveau grade
                        $current_rank = $rank_name;
                        echo '<div class="habblet-container"><div class="cbb clearfix ' . $box_color . '">';
                        echo '<h2 class="title"><span style="float: left;">' . $rank_name . '</span> <span style="float: right; font-weight: normal; font-size: 75%;">' . $description . '</span></h2><div class="box-content">';
                        $current_container = true;
                    }

                    // Affichage de l'utilisateur dans le container courant
                    echo '<table class="fondateur"><tbody><tr>';
                    echo '<td valign="middle" width="10" height="60">';
                    echo '<a href="' . $url . '/info?tag=' . $user_name . '" title="Aller sur son profil &raquo;" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)">';
                    echo '<div style="width: 64px; height: 70px; margin-bottom:-10px; margin-top:-15px; margin-left: -15px; float: right; background: url(' . $avatarimage . '' . Secu($user_figure) . '&action=sit&direction=2&head_direction=3&gesture=sml&size=b&img_format=gif);"></div>';
                    echo '</a>';
                    echo '</td>';
                    echo '<td valign="top">';
                    echo '<span style="color:#2767A7;"><b style="font-size: 110%;" title="Poste occupé: ' . substr($rank_name, 0, -1) . '" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)">' . $user_name . ' </b></span><br />';
                    echo '<span style="color:#888"><b>Mission :</b> ' . substr($user_mission, 0, 15) . '<br>' . '</span>';
                    echo '<span style="color:#888"><b>Fonction :</b> ' . $rank_name . '<br>' . '</span>';
                    echo (($online == "1") ? '<img src="' . $imagepath . 'v2/images/online.gif"></td>' : '<img src="' . $imagepath . 'v2/images/offline.gif">');
                    echo '</td>';
                    echo '</tr></tbody></table>';
                }

                // Fermeture du dernier container (s'il existe)
                if ($current_container !== null) {
                    echo '</div></div></div>';
                }

                // Fermeture de la requête et de la connexion à la base de données
                $req->closeCursor();
                ?>

                <script type="text/javascript">
                    if (!$(document.body).hasClassName('process-template')) {
                        Rounder.init();
                    }
                </script>

                <div class="habblet-container ">
                    <div class="cbb clearfix white ">
                        <div class="box-content">
                            <img style="float: right" src="http://images-eussl.habbo.com/c_images/album1584/ADM.gif">
                            "Qui sont ces personnes?"<br />
                            <b>Les staffs sont des joueurs qui modèrent et animent l'hôtel.</b> Ils sont là pour faire respecter la Habbo Attitude et proposent aux utilisateurs des moments de plaisir.<br />
                            <b>La sécurité</b> est le point le plus important pour eux.<br />
                            Afin de repérer les staffs, ils portent un badge "Habbo Staff" sans lequel ce n'en est pas un.<br />
                            "Comment puis-je devenir un staff?" <br />
                            Être staff sur <?PHP echo $sitename; ?> est un <b>emploi virtu/réel.</b> Les staffs sont soumis à des tests et sont choisis pour leurs compétences! De plus, tous les membres du personnel sont extérieurs à l'hôtel. Et non, on ne paye pas pour devenir staff!:/<br /><br />
                            Pour devenir staff, la direction de l'hôtel ouvre des postes que tu peux consulter <a href="<?PHP echo $url; ?>/recrutement">ici</a>.
                        </div>
                    </div>
                </div>

            </div>


            <div id="column1" class="column">
                <?php
                // Requête pour récupérer les informations des utilisateurs triées par grade
                $req2 = $bdd->prepare("SELECT u.id, u.username, u.motto, u.rank, u.online, u.look, p.rank_name AS rank_name, p.box_color AS box_color, p.description AS description FROM users u LEFT JOIN permissions p ON u.rank = p.id WHERE u.rank >= 7 AND u.rank <= 9 ORDER BY u.rank DESC");
                $req2->execute();

                // Initialisation des variables
                $current_rank = null;
                $current_container = null;
                $compteur = 0;

                // Parcours des résultats de la requête
                while ($row2 = $req2->fetch(PDO::FETCH_ASSOC)) {
                    $user_id = $row2['id'];
                    $user_name = $row2['username'];
                    $user_mission = $row2['motto'];
                    $online = $row2['online'];
                    $user_figure = $row2['look'];
                    $rank_name = $row2['rank_name'];
                    $box_color = $row2['box_color'];
                    $description = $row2['description'];

                    // Si le grade de l'utilisateur est différent du grade courant
                    if ($rank_name !== $current_rank) {
                        // Fermeture du container précédent (s'il existe)
                        if ($current_container !== null) {
                            echo '</div></div>';
                        }
                        // Création d'un nouveau container pour le nouveau grade
                        $current_rank = $rank_name;
                        echo '<div class="habblet-container"><div class="cbb clearfix ' . $box_color . '">';
                        echo '<h2 class="title"><span style="float: left;">' . $rank_name . '</span> <span style="float: right; font-weight: normal; font-size: 75%;">' . $description . '</span></h2><div class="box-content">';
                        $current_container = true;
                    }

                    // Affichage de l'utilisateur dans le container courant
                    $class = "";
                    if ($rank_name == "Fondateurs") {
                        $class = "fondateur";
                    } elseif ($rank_name == "Administrateurs") {
                        $class = "manager";
                    } elseif ($rank_name == "Modérateurs") {
                        $class = "modo";
                    } elseif ($rank_name == "Animateurs") {
                        $class = "manager";
                    } else {
                        $class = "";
                    }
                    echo '<table class="' . $class . '">';
                    echo '<tbody><tr>';
                    echo '<td valign="middle" width="10" height="60">';
                    echo '<a href="' . $url . '/info?tag=' . $user_name . '" title="Aller sur son profil &raquo;" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)">';
                    echo '<div style="width: 64px; height: 70px; margin-bottom:-10px; margin-top:-15px; margin-left: -15px; float: right; background: url(' . $avatarimage . '' . Secu($user_figure) . '&action=sit&direction=2&head_direction=3&gesture=sml&size=b&img_format=gif);"></div>';
                    echo '</a>';
                    echo '</td>';
                    echo '<td valign="top">';
                    echo '<span style="color:' . $box_color . '"><b style="font-size: 110%;" title="Poste occupé: ' . substr($rank_name, 0, -1) . '" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)">' . $user_name . ' </span></b><br />';
                    echo '<span style="color:#888"><b>Mission:</b> ' . $user_mission . "<br>" . '</span>';
                    echo '<span style="color:#888"><b>Fonction :</b> ' . $rank_name . '<br>' . '</span>';
                    echo (($online == "1") ? '<img src="' . $imagepath . 'v2/images/online.gif"></td>' : '<img src="' . $imagepath . 'v2/images/offline.gif">');
                    echo '</td>';
                    echo '</tr></tbody>';
                    echo '</table>';
                }

                // Fermeture du dernier container (s'il existe)
                if ($current_container !== null) {
                    echo '</div></div></div>';
                }

                // Fermeture de la requête et de la connexion à la base de données
                $req2->closeCursor();
                $bdd = null;
                ?>
                <script type="text/javascript">
                    if (!$(document.body).hasClassName('process-template')) {
                        Rounder.init();
                    }
                </script>


            </div>