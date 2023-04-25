<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("./config.php");
include("./locale/$language/login.php");
$pagename = "Déconnexion";
$pageid = "logout";

if (!isset($_SESSION['username'])) {
    Redirect("" . $url . "/index");
} else {
    session_destroy();
}

$sql = $bdd->query("SELECT * FROM gabcms_config WHERE id = '1'");
$cof = $sql->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title><?PHP echo $sitename; ?> &raquo; Deconnexion</title>

    <script type="text/javascript">
        var andSoItBegins = (new Date()).getTime();
    </script>
    <link rel="shortcut icon" href="<?PHP echo $imagepath; ?>v2/favicon.ico" type="image/vnd.microsoft.icon" />
    <script src="<?PHP echo $imagepath; ?>static/js/libs2.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/landing.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/style.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/buttons.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/boxes.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/tooltips.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>styles/local/com.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
    <script src="<?PHP echo $imagepath; ?>js/local/com.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/process.css<?php echo '?' . mt_rand(); ?>" type="text/css" />


    <meta name="description" content="Join the world's largest virtual hangout where you can meet and make friends. Design your own rooms, collect cool furniture, throw parties and so much more! Create your FREE Retro today!" />
    <meta name="keywords" content="Retro, virtual, world, join, groups, forums, play, games, online, friends, teens, collecting, social network, create, collect, connect, furniture, virtual, goods, sharing, badges, social, networking, hangout, safe, music, celebrity, celebrity visits, cele" />

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
body { behavior: url(<?PHP echo $imagepath; ?>js/csshover.htc); }
</style>
<![endif]-->
    <meta name="build" content="PHPRetro 4.0.10 BETA" />
</head>

<body id="landing" class="process-template">

    <div id="overlay"></div>

    <div id="container">
        <div class="cbb process-template-box clearfix">
            <div id="content">

                <div id="header" class="clearfix">
                    <h1><a href="https://phpretro.bobbastar.fr/"></a></h1>
                    <ul class="stats">
                        <li class="stats-online"><?PHP echo Connected(); ?></li>


                        <?PHP if ($cof['etat_client'] == '1' || $cof['etat_client'] == '3' && $cof['si3_debut'] < $nowtime && $cof['si3_fin'] < $nowtime) { ?>
                            <li class="stats-visited"><img src="<?PHP echo $imagepath; ?>v2/images/online.gif" alt="online"></li>
                        <?PHP } elseif ($cof['etat_client'] == '2') { ?>
                            <li class="stats-visited"><img src="<?PHP echo $imagepath; ?>v2/images/offline.gif" alt="offline"></li>
                        <?PHP } elseif ($cof['etat_client'] == '3' && $cof['si3_debut'] <= $nowtime && $cof['si3_fin'] >= $nowtime) { ?>
                            <li class="stats-visited"><img src="<?PHP echo $imagepath; ?>v2/images/offline.gif" alt="offline"></li>
                        <?PHP } ?>



                    </ul>

                </div>
                <div id="process-content">

                    <div id="process-content">
                        <div class="action-confirmation flash-message">
                            <div class="rounded">
                                <div class="rounded-done">Vous avez été déconnecté avec succès</div>
                            </div>

                        </div>

                        <div style="text-align: center">

                            <div style="width:100px; margin: 10px auto"><a href="<?PHP echo $url; ?>" id="logout-ok" class="new-button fill"><b>OK</b><i></i></a></div>

                            <div id="column1" class="column">
                            </div>
                            <div id="column2" class="column">
                            </div>

                            <!-- FOOTER -->
                            <?PHP include("./template/footer.php"); ?>
                            <!-- FIN FOOTER -->

                        </div>


                        <!--[if lt IE 7]>
<script type="text/javascript">
Pngfix.doPngImageFix();
</script>
<![endif]-->

                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            HabboView.run();
        </script>


</body>

</html>