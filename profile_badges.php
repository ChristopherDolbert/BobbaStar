<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("./config.php");
$pagename = "Mes Préférences";
$pageid = "option";

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
        var habboStaticFilePath = "<?PHP echo $avatarimage; ?>";
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
    <script src="<?PHP echo $imagepath; ?>js/tooltip.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/visual.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/libs.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/common.js" type="text/javascript"></script>

    <script src="<?PHP echo $imagepath; ?>static/js/fullcontent.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/style.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/buttons.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/boxes.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/tooltips.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/personal.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
    <script src="<?PHP echo $imagepath; ?>static/js/habboclub.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/minimail.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/myhabbo/control.textarea.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
    <script src="<?PHP echo $imagepath; ?>static/js/minimail.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/settings.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/settings.css<?php echo '?'.mt_rand(); ?>" type="text/css" />


    <meta name="description" content="<?PHP echo $description; ?>" />
    <meta name="keywords" content="<?PHP echo $keyword; ?>" />
    <!--[if IE 8]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/ie8.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<![endif]-->
    <!--[if lt IE 8]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/ie.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<![endif]-->
    <!--[if lt IE 7]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/ie6.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
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

<body id="home" class=" ">
    <div id="tooltip"></div>
    <div id="overlay"></div>
    <!-- MENU -->
    <?PHP include("./template/header.php"); ?>
    <!-- FIN MENU -->

    <div id="container">
        <div id="content" style="position: relative" class="clearfix">
            <div>

                <div class="content">
                    <div class="habblet-container" style="float:left; width:210px;">
                        <div class="cbb settings">

                            <h2 class="title">Mes Préférences</h2>
                            <div class="box-content">
                                <div id="settingsNavigation">
                                    <ul>
                                        <li>
                                            <a href="<?PHP echo $url; ?>/profile">Modification Général</a>
                                        </li>
                                        <li>
                                            <a href="<?PHP echo $url; ?>/motdepasse">Change ton Mot de passe</a>
                                        </li>
                                        <li class="selected">
                                            Gestion des badges
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="habblet-container " style="float:left; width: 560px;">
                    <div class="cbb clearfix settings">

                        <h2 class="title">Gestion des badges</h2>
                        <div class="box-content">



                            <?php
                            if (!empty($result)) {
                                if ($error == "1") {
                                    echo "<div class='rounded rounded-red'>";
                                } else {
                                    echo "<div class='rounded rounded-green'>";
                                }
                                echo "" . $result . "<br />
    </div><br />";
                            }
                            ?>
                            Hey <b><?PHP echo $user['username']; ?></b>, ça va?<br /><br />

                            Tu ne connais pas trop tes badges? Pas de problème, je suis là pour t'aider! Regarde les images ci-dessous, tu as les badges qui t'appartiennent.
                            <br /><br />

                            </i>
                            <center>
                                <h2>Voici tes badges:</h2>
                                <table>
                                    <tbody>
                                        <tr class="haut">
                                            <td class="haut">Image</td>
                                            <td class="haut">Code</td>
                                        </tr>
                                        <?PHP $userbadges = $bdd->query("SELECT DISTINCT * FROM users_badges WHERE user_id = '" . $user['id'] . "'");
                                        while ($userbadge = $userbadges->fetch()) {
                                        ?>
                                            <tr class="bas">
                                                <td class="bas"><img src="<?PHP echo $swf_badge;
                                                                            echo $userbadge['badge_code']; ?>.gif" border="0" /></td>
                                                <td class="bas"><?php echo $userbadge['badge_code']; ?></td>
                                            </tr>
                                        <?PHP } ?>
                                    </tbody>
                                </table>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div style="clear: both;"></div>


    </div>
    </div>
    </div>
    </div>

    <!--[if lt IE 7]>
<script type="text/javascript">
Pngfix.doPngImageFix();
</script>
<![endif]-->
    <!-- FOOTER -->
    <?PHP include("./template/footer.php"); ?>
    <!-- FIN FOOTER -->
    <script type="text/javascript">
        HabboView.run();
    </script>
</body>

</html>