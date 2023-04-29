<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");
include("./locale/$language/login.php");
$pagename = "Informations sur le CMS";


if (!isset($_SESSION['username']) || $user['rank'] > 11) {
    Redirect("" . $url . "/managements/acces_interdit");
    exit();
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu:400,700,400italic,700italic">
    <link rel="stylesheet" type="text/css" href="<?PHP echo $imagepath; ?>v2/styles/maj.css<?php echo '?' . mt_rand(); ?>">
</head>

<body>
    <div id="page">
        <div id="page_header">
            <div id="logo">
                <a href="<?PHP echo $url ?>/managements/bureau"><img src="http://gabcms.org/info/export/logo_gabcms.gif"></a>
            </div>
            <div id="right">
                Page d'information sur les mises à jour de <b>GabCMS</b>
                <br />
                Version actuellement utilisée : <b>1.1</b>
                <br />
                <iframe src="http://gabcms.org/info/export/derniere_version.php" height="30px" width="450px" frameborder="0"></iframe>
            </div>
        </div>
        <div id="page_head"></div>
        <div id="page_content">
            <iframe src="http://gabcms.org/info/export/etat_v1.1.php" height="40px" width="780px" frameborder="0"></iframe>
            <div id="big_box">
                <div class="title">
                    Dernières informations sur la <b>v1.1</b>
                </div>
                <iframe src="http://gabcms.org/info/export/infos_v1.1.php" height="350px" width="435px" frameborder="0"></iframe>
            </div>
            <div id="little_box">
                <div class="title">
                    Rentrer en contact avec la team de GabCMS
                </div>
                Plusieurs moyens s'offrent à vous :<br /><br />
                - Par skype : contact.gabcms <sub>(service client ouvert de 15h à 21h hors jours fériés)</sub><br />
                - Par mail : <b>contact@gabcms.org</b> <sub>(réponses sous 72h)</sub><br />
                - Par <a href="http://facebook.com/Gabcms/" target="_blank">facebook</a> ou <a href="http://twitter.com/GabCMS/" target="_blank">twitter</a><br />
                - Par le <a href="http://gabcms.org/support/" target="_blank">service client online</a> <sub>(service client ouvert de 15h à 21h hors jours fériés)</sub>
            </div>
            <span style="float:right; margin-right:7px;margin-top:7px;">
                <a href="http://gabcms.org/support/index?site=<?PHP echo $sitename; ?>&nom=<?PHP echo $user['username']; ?>" target="_blank"><img src="http://gabcms.org/support/img/info_support.png" /></a>
            </span>
            <div id="big_box">
                <div class="title">
                    Derniers tweets
                </div>
                <a class="twitter-timeline" href="https://twitter.com/GabCMS" data-widget-id="325726367729717249">Tweets de @GabCMS</a>
                <script>
                    ! function(d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0],
                            p = /^http:/.test(d.location) ? 'http' : 'https';
                        if (!d.getElementById(id)) {
                            js = d.createElement(s);
                            js.id = id;
                            js.src = p + "://platform.twitter.com/widgets.js";
                            fjs.parentNode.insertBefore(js, fjs);
                        }
                    }(document, "script", "twitter-wjs");
                </script>
            </div>

        </div>
        <div id="page_footer"></div>
    </div>
    <!-- FOOTER -->
    <?PHP include("./template/footer.php"); ?>
    <!-- FIN FOOTER -->
</body>

</html>