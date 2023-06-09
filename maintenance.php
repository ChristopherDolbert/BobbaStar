<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

$is_maintenance = true;

include("./config.php");
include("locale/" . $language . "/maintenance.php");

$pageid = "maintenance";

if (isset($_SESSION['username'])) {
    if ($_SESSION['rank'] >= 9) {
        Redirect("" . $url . "/moi");
    } else {
        session_destroy();
    }
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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title><?php echo $shortname; ?></title>

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>


    <link href="web-gallery/v2/styles/maintenance.css" rel="stylesheet" type="text/css" />


</head>

<body>

    <div id="container">
        <div id="content">
            <div id="header" class="clearfix">
                <h1><span></span></h1>
            </div>
            <div id="process-content">

                <div class="fireman">

                    <h1>Maintenance break!</h1>

                    <p>
                        Nous sommes d&eacute;sol&eacute;s mais tu ne peux pas te connecter &agrave; <?php echo $shortname; ?> pour l'instant.<br>
                        Nous sommes en train de mettre &agrave; jour <?php echo $shortname; ?>.
                    </p>

                </div>
                <div class="tweet-container">

                    <h2>Accès Staff</h2>

                    <?php
                    if (isset($erreur)) {
                        echo "\n<center><div style=\"padding:5px;text-align:center;color:white;background-color:red;width:90%\">\n <div class=\"rounded\">\n  <ul>\n   <li>" . $erreur . "</li>\n  </ul>\n </div>\n</div></center>\n";
                    }
                    ?>

                    <form style="text-align:center" action="<?PHP echo $url; ?>/maintenance?do=se_connecter" method="post">
                        <p><b><i>Pseudo<br /></i></b> <input id="email" name="username" title="Écris ici ton pseudo" placeholder="Ton pseudo" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" type="text"></p><br />
                        <p><b><i>Mot de passe<br /></i></b> <input id="password" name="password" title="Écris ici ton mot de passe" placeholder="Ton mot de passe" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" type="Password"></p>
                        <input type="submit" value="Login" style="margin: -10000px; position: absolute;">
                        <input type="image" src="<?PHP echo $imagepath; ?>maintenance/img/suivant.png"></td>
                    </form>

                </div>

                <!-- FOOTER -->
                <?PHP include("./template/footer.php"); ?>
                <!-- FIN FOOTER -->

            </div>
        </div>
    </div>
</body>

</html>