<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("./config.php");
$pagename = "Déconnexion";
$pageid = "logout";

if (!isset($_SESSION['username'])) {
    Redirect("" . $url . "/index");
} else {
    session_destroy();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title><?PHP echo $sitename; ?> &raquo; Deconnexion</title>

    <script type="text/javascript">
        var andSoItBegins = (new Date()).getTime();
    </script>

    <script>
        var andSoItBegins = (new Date()).getTime();
        var habboPageInitQueue = [];
        var habboStaticFilePath = "./web-gallery";
    </script>
    <link rel="shortcut icon" href="<?PHP echo $imagepath; ?>favicon.ico" type="image/vnd.microsoft.icon" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu:400,700,400italic,700italic">
    <script src="<?PHP echo $imagepath; ?>static/js/13389159.js"></script>
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>static/styles/v3_default.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>static/styles/v3_logout.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
    <script src="<?PHP echo $imagepath; ?>static/js/v3_default_top.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>js/tooltip.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/visual.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>v2/styles/styles.css<?php echo '?'.mt_rand(); ?>" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/libs.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/common.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/fullcontent.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/libs2.js" type="text/javascript"></script>
    <script type="text/javascript">
        document.habboLoggedIn = false;
        var habboName = null;
        var habboReqPath = "";
        var habboStaticFilePath = "./web-gallery";
        var habboImagerUrl = "/habbo-imaging/";
        var habboPartner = "";
        window.name = "habboMain";
    </script>



    <meta name="description" content="<?PHP echo $description; ?>" />
    <meta name="keywords" content="<?PHP echo $keyword; ?>" />

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
body { behavior: url(<?PHP echo $imagepath; ?>csshover.htc); }
</style>
<![endif]-->
    <meta name="build" content="<?PHP echo $build; ?> >> <?PHP echo $version; ?>" />

</head>

<body>
    <div id="tooltip"></div>
    <div id="overlay"></div>
    <header>
        <div id="border-left"></div>
        <div id="border-right"></div>
        <div id="header-content">
            <a href="#home" id="habbo-logo"></a>
        </div>
        <div id="top-bar-triangle"></div>
        <div id="top-bar-triangle-border"></div>
    </header>

    <div id="content">
        <div id="page-content">
            <img src="<?PHP echo $imagepath; ?>images/v3/sail.out.png" alt="placeholder" />

            <div id="column1" class="column">

                <div class="habblet-container ">

                    <div class="ad-container">

                    </div>
                </div>
            </div>
            <div id="column2" class="column">
            </div>
            <div id="logout-container">
                <div id="logout-content">
                    <div class="action-confirmation flash-message">
                        <p>
                            Tu t'es déconnecté
                        </p>
                    </div>
                    <div id="logout-message">
                    </div>
                    <a href="<?PHP echo $url; ?>" id="logout-ok" class="new-button fill ok"><b>OK</b><i></i></a>
                </div>
            </div><br />
        </div>
        <footer>
            <div id="partner-logo"><a href="" style="background-image: url('./web-gallery/v2/images/publishing.png')"></a></div>
            <div id="footer-content">
                <div id="footer"></div>
                <div id="copyright"><?PHP include("./template/footer.php"); ?></div>
            </div>
        </footer>
        <script src="./web-gallery/static/js/v3_landing_bottom.js" type="text/javascript"></script><!--[if IE]><script src="./web-gallery/static/js/v3_ie_fixes.js" type="text/javascript"></script><![endif]-->

</body>

</html>