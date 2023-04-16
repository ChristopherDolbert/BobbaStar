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

if (isset($_SESSION['username'])) {
    Redirect("" . $url . "/moi");
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
                        // TODO : BAN SYSTEM
                        $sql = $bdd->query("SELECT * FROM bans WHERE value = '" . $username . "'");
                        $b = $sql->fetch(PDO::FETCH_ASSOC);
                        $row_ban = $sql->rowCount();


                        $stamp_now = time();
                        $stamp_expire = $b['expire'];
                        $expire = date('d/m/Y H:i:s', $b['expire']);

                        if ($stamp_now < $stamp_expire) {
                            $erreur = "Ton compte a &eacute;t&eacute; bannis pour la raison suivante :<br/> <b>" . $b['reason'] . "</b>. Il expira le: <b>" . $expire . "</b>";
                        } else {
                            if ($row_ban > 0) {
                                $bdd->query("DELETE FROM bans WHERE value = '" . $username . "'");
                            }
                            $sql = $bdd->prepare("UPDATE users SET last_login = '" . time() . "' WHERE username = ?");
                            $sql->execute([$username]);
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title><?PHP echo $sitename; ?><?PHP echo $description; ?></title>

    <link rel="shortcut icon" href="<?PHP echo $imagepath; ?>favicon.ico" type="image/vnd.microsoft.icon"/>
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>index/css/index.css" type="text/css"/>
    <link rel='stylesheet' type='text/css'
          href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,600,700,800,400italic,700italic|Ubuntu+Condensed'>
</head>
<body>
<?PHP if (isset($erreur)) {
    echo "<div id='error'>" . $erreur . "</div>";
} ?>
<div id='header'>
    <div class='logo'>
        <img src='<?PHP echo $imagepath; ?>v2/images/logo_gabcms.gif' onclick='window.location.href="index"'>
    </div>
    <form class='form' action='?do=se_connecter' method='post'>
        <input type='hidden' name='hidden' value='1'>
        <div id='left'>
            <label for='username'>Pseudonyme</label>
            <input id='username' type='text' name='username' value='' placeholder='' maxlength='25' autocomplete='off'>
        </div>
        <div id='right'>
            <label for='password'>Mot de passe</label>
            <input id='password' type='password' name='password' value='' placeholder='' maxlength='20'
                   autocomplete='off'>
            <a href="<?PHP echo $url; ?>/oubliemotdepasse">Oublié ?</a>
        </div>
        <input type='submit' name='submit' id='submit' value='Connexion'>
    </form>
    <span>Rejoins-nous, il y a <?PHP $tmp = $bdd->query("SELECT count(id) FROM users WHERE online = '1'");
        $tma = $tmp->fetch(PDO::FETCH_ASSOC);
        echo $tma['count(id)']; ?> connectés</span>
    <div id='social'>
        <img src='<?PHP echo $imagepath; ?>index/img/fb.png'
             onclick='window.location.href="http://facebook.com/<?PHP echo $compte_facebook; ?>"'>
        <img src='<?PHP echo $imagepath; ?>index/img/twitter.png'
             onclick='window.location.href="https://twitter.com/<?PHP echo $compte_twitter; ?>"'>
    </div>
</div>

<div id='content'>
    <div id='nbre'></div>
    <div id='btn' onclick='window.location.href="register"'>
        <p>Inscris toi</p>
        <p>gratuitement</p>
    </div>
    <div id='sepa'></div>
    <div id='def' class='anim'>
        Animation 24/24h
    </div>
    <div id='def' class='free'>
        Un jeu totalement gratuit
    </div>
    <div id='def' class='secu'>
        Navigation sécurisée
    </div>
    <div id='def' class='team'>
        Une équipe de choc
    </div>
    <div id='def' class='pers'>
        Personalisation du site simple
    </div>
    <div id='def' class='supp'>
        Un support efficace
    </div>


</div>

<div id='footer'>
    <div id='liens'>
        <a href='<?PHP echo $url; ?>' target="_self">Accueil</a> |
        <a href='<?PHP echo $url; ?>/register' target="_self">Inscription</a> |
        <a href="<?PHP echo $url; ?>/disclaimer" target="_blank">Conditions Générales d'Utilisations</a>
    </div>
    Index basé sur une index en libre partage d'<b>Eklopsis</b> &copy;<br/>
    <?PHP echo $sitename; ?> est un projet ind&eacute;pendant, &agrave; but non lucratif &copy; 2012-2014.<br/>
    Habbo est une marque d&eacute;pos&eacute;e de Sulake Corporation. Tous droits r&eacute;serv&eacute;s &agrave;
    leur(s) propri&eacute;taire(s) respectif(s).<br/>Nous ne sommes pas approuv&eacute;s, affili&eacute;s ou offertes
    par Sulake Corporation LTD.<br><br><u>&copy; GabCMS v<?PHP echo $version; ?> - Créer par l'équipe de GabCMS</u>
</div>
</body>
</html>