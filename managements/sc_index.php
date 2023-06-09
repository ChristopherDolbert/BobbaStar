<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");
$pagename = "Dépôt - Service client";
$pageid = "sc_index";

if (!isset($_SESSION['username']) || $user['rank'] < 5 || $user['rank'] > 11) {
    Redirect("" . $url . "/managements/acces_interdit");
    exit();
}

$rank_modif = "";
switch ($user['rank']) {
    case 11:
        $rank_modif = "fondateur";
        break;
    case 10:
        $rank_modif = "fondateur";
        break;
    case 9:
        $rank_modif = "fondateur";
        break;
    case 8:
        $rank_modif = "fondateur";
        break;
    case 7:
        $rank_modif = "manager";
        break;
    case 6:
        $rank_modif = "administratrice";
        if ($user['gender'] == 'M') {
            $rank_modif = "administrateur";
        }
        break;
    case 5:
        $rank_modif = "modératrice";
        if ($user['gender'] == 'M') {
            $rank_modif = "modérateur";
        }
        break;
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
</head>

<body id="home">
    <div id="tooltip"></div>
    <div id="overlay"></div>
    <!-- MENU -->
    <?PHP include("../template/header.php"); ?>
    <!-- FIN MENU -->
    <div id="container">
        <div id="content" style="position: relative" class="clearfix">
            <div id="column1" class="column">
                <div class="habblet-container" id="okt" style="float:left; width: 770px;">
                    <div class="cbb clearfix red">
                        <h2 class="title">Tickets non résolus</h2>
                        <div class="box-content">
                            <?php
                            $sql = $bdd->query("SELECT * FROM gabcms_contact WHERE resul NOT IN ('6', '7', '8') ORDER BY id DESC");
                            $row = $sql->rowCount();
                            if ($row < 1) {
                                echo "Il n'y a aucun sujet d'aide.";
                            } else {
                            ?>
                                <table>
                                    <thead>
                                        <tr class="haut">
                                            <td class="haut">Ticket #</td>
                                            <td class="haut">Pseudo</td>
                                            <td class="haut">Catégorie</td>
                                            <td class="haut">Date</td>
                                            <td class="haut">Sujet</td>
                                            <td class="haut">Etat</td>
                                            <td class="haut">Dernière réponse</td>
                                            <td class="haut">Action</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($a = $sql->fetch()) {
                                            $resul = intval($a['resul']);
                                            $etats = array(
                                                "<span style=\"color:#FF4500\"><b>Signalé</b></span>",
                                                "<span style=\"color:#4B0082\"><b>En étude</b></span>",
                                                "<span style=\"color:#FF0000\"><b>Correction à faire</b></span>",
                                                "<span style=\"color:#0000FF\"><b>Attente réponse du joueur</b></span>",
                                                "<span style=\"color:#8B4513\"><b>Réponse donnée par le joueur</b></span>",
                                                "<span style=\"color:#2E8B57\"><b>En test</b></span>",
                                                "<span style=\"color:#008000\"><b>Fermé - Résolu</b></span>",
                                                "<span style=\"color:#8bda20\"><b>Fermé - déjà signalé/résolu</b></span>",
                                                "<span style=\"color:#DAA520\"><b>Fermé - sans suite</b></span>"
                                            );
                                            $etat_modif = isset($etats[$resul]) ? $etats[$resul] : '';
                                        ?>
                                            <tr class="bas">
                                                <td class="bas"><?php echo Secu($a['id']); ?></td>
                                                <td class="bas"><?php echo Secu($a['pseudo']); ?></td>
                                                <td class="bas"><?php echo Secu($a['categorie']); ?></td>
                                                <td class="bas"><?php echo Secu($a['date']); ?></td>
                                                <td class="bas"><?php echo stripslashes($a['sujet']); ?></td>
                                                <td class="bas"><?php echo $etat_modif; ?></td>
                                                <td class="bas"><?php echo Secu($a['resul_par']); ?></td>
                                                <td class="bas"><a href="<?php echo $url; ?>/managements/sc_traiter?id=<?php echo Secu($a['id']); ?>" target="_blank"><img src="<?php echo $url; ?>/service_client/img/notes.png" /></a></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            <?php } ?>

                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    if (!$(document.body).hasClassName('process-template')) {
                        Rounder.init();
                    }
                </script>

                <iframe src="<?PHP echo $url; ?>/managements/sc_ticket_resolu" height="670px" width="930px" frameborder="0"></iframe>
            </div>
            <!--[if lt IE 7]>
<![endif]-->
            <!-- FOOTER -->
            <?PHP include("../template/footer.php"); ?>
            <!-- FIN FOOTER -->
            <div style="clear: both;"></div>
        </div>
    </div>
    <script type="text/javascript">
        HabboView.run();
    </script>
</body>

</html>