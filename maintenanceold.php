<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|

#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("./web-gallery/maintenance/config.php");

$pageid = "maintenance";

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
                $sql = $bdd->prepare("SELECT id,disabled,password,rank FROM users WHERE username = ? LIMIT 1");
                $sql->execute([$username]);
                $row = $sql->rowCount();
                $assoc = $sql->fetch(PDO::FETCH_ASSOC);
                $pass = $assoc['password'];
                $userId = $assoc['id'];
                $rank = $assoc['rank'];

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
                            if ($rank >= 9) {
                                $sql = $bdd->prepare("UPDATE users SET last_login = ?, ip_current = ? WHERE username = ?");
                                $sql->execute([time(), $_SERVER['REMOTE_ADDR'], $username]);
                                $_SESSION['username'] = $username;
                                $_SESSION['password'] = $password;
                                Redirect($url . "/moi");
                            } else {
                                $erreur = "Tu ne fais pas parti de l'équipe de maintenance.";
                            }
                        }
                    }
                }
            }
        }
    }
}

$maintenance = $bdd->query("SELECT * FROM gabcms_maintenance WHERE id = '1'");
$m = $maintenance->fetch(PDO::FETCH_ASSOC);

if ($m['activ'] == "Non") {
    Redirect($url);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title><?PHP echo $sitename; ?> &raquo; Maintenance</title>

    <script type="text/javascript">
        var andSoItBegins = (new Date()).getTime();
    </script>

    <script>
        var andSoItBegins = (new Date()).getTime();
        var habboPageInitQueue = [];
        var habboStaticFilePath = "./web-gallery";
    </script>
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/process.css" type="text/css"/>
    <link rel="shortcut icon" href="<?PHP echo $imagepath; ?>favicon.ico" type="image/vnd.microsoft.icon"/>
    <script src="<?PHP echo $imagepath; ?>static/js/libs2.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/visual.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/libs.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/common.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/fullcontent.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>js/tooltip.js" type="text/javascript"></script>


    <style>
        #raison {
            background-color: #cecece;
            -webkit-box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            box-shadow: 0 1px 0 #fff, 0 2px 3px rgba(0, 0, 0, 0.5) inset;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            margin-left: 235px;
            padding: 7px;
            text-shadow: rgba(255, 255, 255, 0.5) 0 1px 0;
        }
    </style>
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/style.css" type="text/css"/>
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/buttons.css" type="text/css"/>
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/boxes.css" type="text/css"/>
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/tooltips.css" type="text/css"/>
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/changepassword.css" type="text/css"/>
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/process.css" type="text/css"/>
    <script type="text/javascript">
        document.habboLoggedIn = false;
        var habboName = null;
        var habboReqPath = "";
        var habboStaticFilePath = "./web-gallery";
        var habboImagerUrl = "/habbo-imaging/";
        var habboPartner = "";
        window.name = "habboMain";

    </script>


    <meta name="description" content="<?PHP echo $description; ?>"/>
    <meta name="keywords" content="<?PHP echo $keyword; ?>"/>

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
body { behavior: url(<?PHP echo $imagepath; ?>csshover.htc); }
</style>
<![endif]-->
    <meta name="build" content="<?PHP echo $build; ?> >> <?PHP echo $version; ?>"/>

</head>
<body id="intermediate" class="process-template">
<div id="tooltip"></div>
<div id="overlay"></div>

<div id="container">
    <div class="cbb process-template-box clearfix">
        <div id="content" class="wide">


            <div id="header" class="clearfix">
                <h1><a href="<?PHP echo $url; ?>"></a></h1>
                <ul class="stats">

                    <li class="stats-online">&nbsp;</li>
                    <li class="stats-visited"><img src="<?PHP echo $imagepath; ?>v2/images/offline.gif"></li>

                </ul>

            </div>
            <div id="process-content">
                <img style="float:left;" src="<?PHP echo $imagepath; ?>maintenance/img/fireman.png"/>
                <?PHP echo $sitename; ?> est actuellement en maintenance! Nous sommes désolés, mais Frank a fait tomber
                son café dans le serveur, nos techniciens sont en cours d'opération, voici les informations donnés par
                les staffs:
                <br/><br/>
                <div id="raison">
                    <?php echo stripslashes($m['info']); ?><br/><br/><i>Message de
                        <b><?php echo stripslashes($m['auteur']); ?></b> le <?php echo stripslashes($m['datestr']); ?>.</i>
                </div>
                <br/><br/>
                <div style="text-align: center">
                    Tu es un staff? Alors connectes toi:<br/><br/>
                    <form action="<?PHP echo $url; ?>/maintenance?do=se_connecter" method="post">
                        <b><i>Pseudo:</i></b> <input id="email" name="username" title="Écris ici ton pseudo"
                                                     placeholder="Ton pseudo" onmouseover="tooltip.show(this)"
                                                     onmouseout="tooltip.hide(this)" type="text"><br/>
                        <b><i>Mot de passe:</i></b> <input id="password" name="password"
                                                           title="Écris ici ton mot de passe"
                                                           placeholder="Ton mot de passe"
                                                           onmouseover="tooltip.show(this)"
                                                           onmouseout="tooltip.hide(this)" type="Password">
                        <br/><br/><input type="submit" value="Login" style="margin: -10000px; position: absolute;">
                        <input type="image" src="<?PHP echo $imagepath; ?>maintenance/img/suivant.png"></td>
                    </form>
                    <center><span style="color:#FF0000"><?PHP if (isset($erreur)) {
                                echo "<br/>" . $erreur . "";
                            } ?></span></center>
                    <script type="text/javascript">
                        timedRedirect();
                    </script>
                    <script type="text/javascript">
                        if (typeof HabboView != "undefined") {
                            HabboView.run();
                        }
                    </script>
                    <div style="clear: both;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FOOTER -->
<?PHP include("./template/footer.php"); ?>
<!-- FIN FOOTER -->
<script type="text/javascript">
    HabboView.run();

</script>
</body>
</html> 