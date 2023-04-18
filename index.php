<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         GabCMS - Site Web et Content Management System                 #|
#|         Copyright © 2013-2015 Gabodd Tout droits réservés.             #|
#|			    INDEX BY EKLOPSIS - IBUILD.FR 							  #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("./config.php");

$pagename = "Accueil";
$pageid = "index";

$sql = $bdd->query("SELECT * FROM gabcms_config WHERE id = '1'");
$cof = $sql->fetch(PDO::FETCH_ASSOC);

if (isset($_SESSION['username'])) {
    Redirect($url . "/moi");
}
if (isset($_GET['do'])) {
    $do = Secu($_GET['do']);
    if ($do == "se_connecter") {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = Secu($_POST['username']);
            $password = Secu($_POST['password']);
            if (empty($username) || empty($password)) {
                $erreur = "Merci de remplir les champs vides.";
            } else {
                $sql = $bdd->prepare("SELECT id,disabled,password FROM users WHERE username = ? LIMIT 1");
                $sql->execute([$username]);
                $row = $sql->rowCount();
                $assoc = $sql->fetch(PDO::FETCH_ASSOC);
                $pass = $assoc['password'];
                $userId = $assoc['id'];

                if ($row < 1 || !password_verify($password, $pass)) {
                    $erreur = "Ton <b>pseudo</b> et/ou <b>ton mot de passe</b> est incorrect.";
                } else {

                    if ($assoc['disabled'] == 1) {
                        $erreur = "Ton compte a été désactivé par l'administration! En cas d'erreur merci de nous contacter.";
                    } else {
                        $sql = $bdd->prepare("SELECT * FROM bans WHERE user_id = ? OR ip = ?");
                        $sql->execute([$userId, $_SERVER['REMOTE_ADDR']]);
                        $b = $sql->fetch(PDO::FETCH_ASSOC);
                        $row_ban = $sql->rowCount();


                        $stamp_now = time();
                        $stamp_expire = $b['ban_expire'];
                        $expire = date('d/m/Y H:i:s', $stamp_expire);

                        if ($stamp_now < $stamp_expire) {

                            $erreur = "Ton compte a été bannis pour la raison suivante :<br/> <b>" . $b['reason'] . "</b>. Il expira le: <b>" . $expire . "</b>";
                        } else {
                            if ($row_ban > 0) {
                                $sql = $bdd->prepare("DELETE FROM bans WHERE user_id = ? OR ip = ?");
                                $sql->execute([$userId, $_SERVER['REMOTE_ADDR']]);
                            }
                            $sql = $bdd->prepare("UPDATE users SET last_login = ?, ip_current = ? WHERE username = ?");
                            $sql->execute([time(), $_SERVER['REMOTE_ADDR'], $username]);
                            $_SESSION['username'] = $username;
                            $_SESSION['password'] = $password;
                            Redirect($url . "/moi");
                        }
                    }
                }
            }
        }
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title><?PHP echo $sitename; ?><?PHP echo $description; ?></title>

    <script type="text/javascript">
        var andSoItBegins = (new Date()).getTime();
    </script>
    <link rel="shortcut icon" href="<?PHP echo $imagepath; ?>v2/favicon.ico" type="image/vnd.microsoft.icon" />
    <script src="https://unpkg.com/@ruffle-rs/ruffle"></script>

    <script>
        window.RufflePlayer = window.RufflePlayer || {};
        window.RufflePlayer.config = {
            // Start playing the content automatically, without audio if the browser in use does not allow audio to autoplay
            "autoplay": "on",
            // Do not show an overlay to unmute the content while it plays; when the content area receives its first interaction, it will unmute
            "unmuteOverlay": "hidden",
            // Do not show a splash screen before the content loads; the content area will remain blank until Ruffle fully loads the content
            "splashScreen": false,
        }
    </script>

    <script src="<?PHP echo $imagepath; ?>static/js/libs2.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/landing.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/style.css" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/buttons.css" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/boxes.css" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/tooltips.css" type="text/css" />

    <script src="<?PHP echo $imagepath; ?>js/local/com.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/process.css" type="text/css" />



    <meta name="description" content="Join the world's largest virtual hangout where you can meet and make friends. Design your own rooms, collect cool furniture, throw parties and so much more! Create your FREE Retro today!" />
    <meta name="keywords" content="Retro, virtual, world, join, groups, forums, play, games, online, friends, teens, collecting, social network, create, collect, connect, furniture, virtual, goods, sharing, badges, social, networking, hangout, safe, music, celebrity, celebrity visits, cele" />

    <!--[if IE 8]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/ie8.css" type="text/css" />
<![endif]-->
    <!--[if lt IE 8]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/ie.css" type="text/css" />
<![endif]-->
    <!--[if lt IE 7]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/ie6.css" type="text/css" />
<script src="<?PHP echo $imagepath; ?>static/js/pngfix.js" type="text/javascript"></script>
<script type="text/javascript">
try { document.execCommand('BackgroundImageCache', false, true); } catch(e) {}
</script>

<style type="text/css">
body { behavior: url(<?PHP echo $imagepath; ?>js/csshover.htc); }
</style>
<![endif]-->
    <meta name="build" content="<?PHP echo $sitename; ?> <?PHP echo $version; ?>" />
</head>

<body id="landing" class="process-template">

    <div id="overlay"></div>

    <div id="container">
        <div class="cbb process-template-box clearfix">
            <div id="content">

                <div id="header" class="clearfix">
                    <h1><a href="<?php echo $url; ?>/"></a></h1>
                    <ul class="stats">
                        <li class="stats-online"><span class="stats-fig"><?PHP $tmp = $bdd->query("SELECT count(id) FROM users WHERE online = '1'");
                                                                            $tma = $tmp->fetch(PDO::FETCH_ASSOC);
                                                                            echo $tma['count(id)']; ?></span> Connectés</li>

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

                    <div id="column1" class="column">
                        <div class="habblet-container " id="create-habbo">

                            <div id="create-habbo-flash">
                                <div id="create-habbo-nonflash" style="background-image: url(<?PHP echo $imagepath; ?>v2/images/landing/landing_group.png)">
                                    <div id="landing-register-text"><a href="<?php echo $url; ?>/register"><span>Join now, it's free &raquo;</span></a></div>
                                    <div id="landing-promotional-text"><span>Retro is a virtual world where you can meet and make friends.</span></div>
                                </div>
                                <div class="cbb clearfix green" id="habbo-intro-nonflash">
                                    <h2 class="title">To get most out of Retro, do this:</h2>
                                    <div class="box-content">
                                        <ul>
                                            <li id="habbo-intro-install" style="display:none"><a href="http://www.adobe.com/go/getflashplayer">Install Flash Player 8 or higher</a></li>
                                            <noscript>
                                                <li>Enable JavaScript</li>
                                            </noscript>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <script type="text/javascript" language="JavaScript">
                                var swfobj = new SWFObject("<?php echo $url; ?>/flash/intro/habbos.swf", "ch", "396", "378", "8");
                                swfobj.addParam("AllowScriptAccess", "always");
                                swfobj.addParam("wmode", "transparent");
                                swfobj.addVariable("base_url", "<?php echo $url; ?>/flash/intro");
                                swfobj.addVariable("habbos_url", "<?php echo $url; ?>/xml/promo_habbos_v2.xml");
                                swfobj.addVariable("create_button_text", "Join now, it's free &raquo;");
                                swfobj.addVariable("in_hotel_text", "Online now!");
                                swfobj.addVariable("slogan", "Retro is a virtual world where you can meet and make friends.");
                                swfobj.addVariable("video_start", "PLAY VIDEO");
                                swfobj.addVariable("video_stop", "STOP VIDEO");
                                swfobj.addVariable("button_link", "<?php echo $url; ?>/register");
                                swfobj.addVariable("localization_url", "<?php echo $url; ?>/xml/landing_intro.xml");
                                swfobj.addVariable("video_link", "<?php echo $url; ?>/flash/intro/Habbo_intro.swf");
                                swfobj.addVariable("select_button_text", "Join now, it's free &raquo;");
                                swfobj.addVariable("header_text", "Create your Retro...");
                                swfobj.write("create-habbo-flash");
                                HabboView.add(function() {
                                    if (deconcept.SWFObjectUtil.getPlayerVersion()["major"] >= 8) {
                                        try {
                                            $("habbo-intro-nonflash").hide();
                                        } catch (e) {}
                                    } else {
                                        $("habbo-intro-install").show();
                                    }
                                });
                            </script>



                        </div>
                        <script type="text/javascript">
                            if (!$(document.body).hasClassName('process-template')) {
                                Rounder.init();
                            }
                        </script>

                    </div>
                    <div id="column2" class="column">
                        <div class="habblet-container ">

                            <div class="cbb loginbox clearfix">
                                <h2 class="title">Sign in</h2>

                                <div class="box-content clearfix" id="login-habblet">
                                    <form action='?do=se_connecter' method='post' class='login-habblet'>
                                        <ul>
                                            <li>
                                                <label for="login-username" class="login-text">Pseudo</label>
                                                <input tabindex="1" type="text" class="login-field" name="username" id="login-username" value="" required />
                                            </li>
                                            <li>
                                                <label for="login-password" class="login-text">Mot de passe</label>
                                                <input tabindex="2" type="password" class="login-field" name="password" id="login-password" required />
                                                <input type="submit" value="Sign in" class="submit" id="login-submit-button" />
                                                <a href="#" id="login-submit-new-button" class="new-button" style="float: left; margin-left: 0;display:none"><b style="padding-left: 10px; padding-right: 7px; width: 55px">Sign in</b><i></i></a>
                                            </li>
                                            <li class="no-label">
                                                <input tabindex="3" type="checkbox" value="true" name="_login_remember_me" id="login-remember-me" checked="unchecked" />
                                                <label for="login-remember-me">Remember me</label>
                                            </li>
                                            <li class="no-label">
                                                <a href="<?php echo $url; ?>/register" class="login-register-link"><span>Inscrivez-vous</span></a>
                                            </li>
                                            <li class="no-label">
                                                <a href="<?PHP echo $url; ?>/oubliemotdepasse" id="forgot-password"><span>Mot de passe oublié ?</span></a>
                                            </li>
                                        </ul>
                                    </form>

                                </div>
                            </div>
                            <div id="remember-me-notification" class="bottom-bubble" style="display:none;">
                                <div class="bottom-bubble-t">
                                    <div></div>
                                </div>
                                <div class="bottom-bubble-c">
                                    En cochant "M&eacute;moriser ces infos" cet ordinateur se souviendra automatiquement de tes nom et mot de passe. Si cet ordinateur est accessible &agrave; partir d'un lieu public ne coche pas cette option !
                                </div>
                                <div class="bottom-bubble-b">
                                    <div></div>
                                </div>
                            </div>
                            <script type="text/javascript">
                                HabboView.add(LoginFormUI.init);
                                HabboView.add(RememberMeUI.init);
                            </script>



                        </div>
                        <script type="text/javascript">
                            if (!$(document.body).hasClassName('process-template')) {
                                Rounder.init();
                            }
                        </script>

                        <div class="habblet-container ">

                            <div class="ad-container">
                                <div id="geoip-ad" style="display:none"></div>
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

                        <div class="habblet-container ">

                            <a href="register.php"><img src="./web-gallery/v2/images/landing/uk_party_frontpage_image.gif" alt="" /></a>



                        </div>
                        <script type="text/javascript">
                            if (!$(document.body).hasClassName('process-template')) {
                                Rounder.init();
                            }
                        </script>
                    </div>


                    <!--[if lt IE 7]>
<script type="text/javascript">
Pngfix.doPngImageFix();
</script>
<![endif]-->

                    <!--[if lt IE 7]>
<script type="text/javascript">
Pngfix.doPngImageFix();
</script>
<![endif]-->

                    <div id="footer">
                        <p><a href='<?PHP echo $url; ?>' target="_self">Accueil</a> | <a href='<?PHP echo $url; ?>/register' target="_self">Inscription</a> | <a href="<?PHP echo $url; ?>/disclaimer" target="_blank">Conditions Générales d'Utilisations</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        HabboView.run();
    </script>


</body>

</html>