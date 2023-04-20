<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("./config.php");
$pagename = "Accueil";
$pageid = "accueil";

if (!isset($_SESSION['username'])) {
    Redirect("" . $url . "/index");
    exit;
}
$sql = $bdd->query("SELECT * FROM gabcms_config WHERE id = '1'");
$cof = $sql->fetch(PDO::FETCH_ASSOC);
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
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>static/styles/lightweightmepage.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
    <script src="<?PHP echo $imagepath; ?>static/js/lightweightmepage.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/fullcontent.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/style.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/buttons.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/boxes.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/tooltips.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/personal.css<?php echo '?'.mt_rand(); ?>" type="text/css" />

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
        <div id="content" style="position: relative" class="clearfix">
            <div id="column1" class="column">
                <div id="wide-personal-info">

                    <div id="habbo-plate">
                        <a href="<?PHP echo $url; ?>/profile">
                            <img src="<?php echo $avatarimage; ?><?php echo $user['look']; ?>">
                        </a>
                    </div>

                    <div id="name-box" class="info-box">
                        <div class="label">Pseudo :</div>
                        <div class="content"><?PHP echo $user['username']; ?></div>
                    </div>
                    <div id="motto-box" class="info-box">
                        <div class="label">Mission :</div>
                        <div class="content"><?PHP echo $user['motto']; ?></div>
                    </div>
                    <div id="last-logged-in-box" class="info-box">
                        <div class="label">Dernière connexion:</div>
                        <div class="content"><?PHP $connexion = date('d/m/Y H:i:s', $user['last_online']);
                                                echo $connexion; ?></div>
                    </div>

                    <?PHP if ($cof['etat_client'] == '1' || $cof['etat_client'] == '3' && $cof['si3_debut'] < $nowtime && $cof['si3_fin'] < $nowtime) { ?>
                        <div class="enter-hotel-btn">
                            <div class="open enter-btn">
                                <a href="<?PHP echo $url ?>/client" onclick="openOrFocusHabbo(this); return false;" target="client">ENTRER DANS L'H&Ocirc;TEL<i></i></a>
                                <b></b>
                            </div>
                        </div>
                    <?PHP } elseif ($cof['etat_client'] == '2') { ?>
                        <div class="enter-hotel-btn">
                            <div class="closed enter-btn">
                                <span>L'H&Ocirc;TEL EST FERM&Eacute;</span>
                                <b></b>
                            </div>
                        </div>
                    <?PHP } elseif ($cof['etat_client'] == '3' && $cof['si3_debut'] <= $nowtime && $cof['si3_fin'] >= $nowtime) { ?>
                        <div class="enter-hotel-btn">
                            <div class="closed enter-btn">
                                <span>L'H&Ocirc;TEL EST FERM&Eacute;</span>
                                <b></b>
                            </div>
                        </div>
                    <?PHP } ?>
                </div>

                <div style="clear:both;"></div>
                <div id="promo-box">
                    <div id="promo-bullets"></div>
                    <?PHP
                    $sql = $bdd->query("SELECT * FROM gabcms_news ORDER BY -id LIMIT 0," . $cof['nb_news'] . "");
                    $c = 0;
                    while ($news = $sql->fetch()) {
                        $c++;
                    ?>
                        <div class="promo-container" style="<?php if ($c != 1) {
                                                                echo "display: none; ";
                                                            } ?> background-image: url(<?PHP echo $news['topstory_image']; ?>);">
                            <div class="promo-content">
                                <div class="title"><?PHP echo stripslashes($news['title']); ?></div>
                                <div class="body"><?PHP echo stripslashes($news['snippet']); ?></div>

                                <?PHP if ($news['event'] == 1) { ?><div class="promo-link-container">
                                        <div class="enter-hotel-btn">
                                            <div class="open enter-btn">
                                                <a style="padding: 0 8px 0 19px;" href="<?PHP echo $url ?>/articles?id=<?PHP echo $news['id']; ?>"><?PHP echo $news['info']; ?></a><b></b>

                                            </div>
                                        </div>
                                    </div><?PHP } ?>
                                <?PHP if ($news['event'] == 2) { ?><div class="promo-link-container">
                                        <div class="enter-hotel-btn">
                                            <div class="open enter-btn">
                                                <a style="padding: 0 8px 0 19px;" href="<?PHP echo $news['lien_event']; ?>"><?PHP echo $news['info']; ?></a><b></b>

                                            </div>
                                        </div>
                                    </div><?PHP } ?>
                            </div>
                        </div>
                    <?PHP } ?>
                    <script type="text/javascript">
                        document.observe("dom:loaded", function() {
                            PromoSlideShow.init();
                        });
                    </script>
                </div>
            </div>

        </div>
        <div id="content" style="position: relative" class="clearfix">
            <div id="column1" class="column">
                <div class="habblet-container ">
                    <div class="cbb clearfix green">
                        <h2 class="title">Flux</h2>

                        <div class="box-content">
                            <style>
                                table {
                                    background-color: #fff;
                                    font-size: 11px;
                                    padding: 4px;
                                    margin-left: -14px;
                                    width: 107%;
                                }

                                table:nth-child(2n+1) {
                                    background-color: #fffcaf;
                                    font-size: 11px;
                                    padding: 4px;
                                    margin-left: -14px;
                                    width: 107%;
                                }
                            </style>
                            <?php
                            $sql = $bdd->prepare("SELECT * FROM gabcms_management WHERE user_id = :userid ORDER BY id DESC LIMIT 0," . $cof['nb_flux'] . "");
                            $sql->bindValue(':userid', $user['id']);
                            $sql->execute();
                            $i = 1;
                            while ($a = $sql->fetch()) {
                            ?>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td valign="middle" width="10" height="60">
                                                <?PHP if ($a['auteur'] != 'Système') { ?><a href="<?PHP echo $url ?>/info?pseudo=<?PHP echo $a['auteur'] ?>" title="Aller sur son profil &raquo;" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)"><?PHP } ?><div style="width: 64px; height: 65px; margin-bottom:-15px; margin-top:-5px; margin-left: -5px; float: right; background: url(<?php echo $avatarimage; ?><?PHP echo $a['look'] ?>&action=wav&direction=2&head_direction=2&gesture=sml&size=big&img_format=gif);"></div></a>
                                            </td>
                                            <td valign="top">
                                                <span style="color:#333333;"><b style="font-size: 110%;"><?PHP echo $a['auteur'] ?></span></b><span style="float: right; color:#000000;"><?PHP echo $a['date'] ?></span><br />
                                                <span style="color:#000000"><?PHP echo $a['message'] ?></span><br />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            <?PHP } ?>
                            <br />Tu peux voir tous tes autres flux en <a href="<?PHP echo $url; ?>/flux">cliquant ici</a>
                        </div>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                if (!$(document.body).hasClassName('process-template')) {
                    Rounder.init();
                }
            </script>
            <div id="column2" class="column">
                <div class="habblet-container ">
                    <div class="cbb clearfix red">
                        <h2 class="title">Radio</h2>

                        <div class="box-content">
                            <iframe width="100%" height="405" src="https://www.youtube.com/watch?v=QvLVvTqpv0A" frameborder="0" allowfullscreen>
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
        <!--[if lt IE 7]>
<script type="text/javascript">
Pngfix.doPngImageFix();
</script>
<![endif]-->
        <!-- FOOTER -->
        <?PHP include("./template/footer.php"); ?>
        <!-- FIN FOOTER -->