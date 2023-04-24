<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         WayCMS - Website and Content Management System                 #|
#|         Copyright © 2011 SnX. All rights reserved.                     #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
include("./config.php");
$pagename = "Crée ton " . $sitename . "";
$pageid = "accueil";

if (isset($_GET['do'])) {
    $do = Secu($_GET['do']);
} else {
    $do = "";
}
if (isset($_GET['page'])) {
    $page = Secu($_GET['page']);
} else {
    $page = "";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title><?PHP echo $sitename; ?>: <?PHP echo $pagename; ?></title>

    <script type="text/javascript">
        var andSoItBegins = (new Date()).getTime();
        var ad_keywords = "";
        document.habboLoggedIn = true;
        var habboName = "";
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


    <link rel="shortcut icon" href="<?PHP echo $imagepath; ?>favicon.ico" type="image/vnd.microsoft.icon"/>
    <script src="<?PHP echo $imagepath; ?>static/js/libs2.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/visual.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/libs.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/common.js" type="text/javascript"></script>

    <script src="<?PHP echo $imagepath; ?>static/js/fullcontent.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/style.css<?php echo '?'.mt_rand(); ?>" type="text/css"/>
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/buttons.css<?php echo '?'.mt_rand(); ?>" type="text/css"/>
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/boxes.css<?php echo '?'.mt_rand(); ?>" type="text/css"/>
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/tooltips.css<?php echo '?'.mt_rand(); ?>" type="text/css"/>
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/personal.css<?php echo '?'.mt_rand(); ?>" type="text/css"/>
    <script src="<?PHP echo $imagepath; ?>static/js/habboclub.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/minimail.css<?php echo '?'.mt_rand(); ?>" type="text/css"/>
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/myhabbo/control.textarea.css<?php echo '?'.mt_rand(); ?>" type="text/css"/>
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/newcredits.css<?php echo '?'.mt_rand(); ?>" type="text/css"/>
    <script src="<?PHP echo $imagepath; ?>static/js/minimail.js" type="text/javascript"></script>

    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/quickregister.css<?php echo '?'.mt_rand(); ?>" type="text/css"/>
    <script src="<?PHP echo $imagepath; ?>static/js/quickregister.js" type="text/javascript"></script>


    <meta name="description" content="<?PHP echo $description; ?>"/>
    <meta name="keywords" content="<?PHP echo $keyword; ?>"/>
    <meta property="fb:app_id" content=""/>

    <meta property="og:site_name" content="Habbo Hotel"/>
    <meta property="og:title"
          content="BobbaLova: Crée ton avatar, décore ton appart, chatte et fais-toi plein d'amis."/>
    <meta property="og:url" content="http://www.bobbalova.fr"/>
    <meta property="og:image" content="http://www.habbol.fr/web-gallery/v2/images/facebook/app_habbo_hotel_image.gif"/>
    <meta property="og:locale" content="fr_FR"/>
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
    <meta name="build" content="<?PHP echo $build; ?> >> <?PHP echo $version; ?>"/>
</head>

<?PHP if ($page == "") { ?>

<body id="client" class="background-agegate">
<?PHP } elseif ($page == "1") { ?>

<body id="client" class="background-accountdetails-<?PHP if ($_SESSION['gender'] == "M") {
    echo "male";
} else {
    echo "female";
} ?>">
<?PHP } else { ?>

<body id="client" class="background-agegate">
<?PHP } ?>
<div id="overlay"></div>
<img src="<?PHP echo $imagepath; ?>v2/images/page_loader.gif" style="position:absolute; margin: -1500px;"/>

<?PHP if ($page == "") {
    if (isset($_SESSION['page'])) {
        Redirect($url . "/register?page=1");
    } ?>
    <div id="stepnumbers">
        <div class="step1focus">Date de naissance et sexe</div>
        <div class="step2">Détails du compte</div>
        <!--<div class="step3">Code de sécurité</div> -->
        <div class="stephabbo"></div>
    </div>

    <div id="main-container">
        <?PHP if ($do == "check") {
            $day = Secu($_POST['bean_day']);
            $month = Secu($_POST['bean_month']);
            $year = Secu($_POST['bean_year']);
            $gender = Secu($_POST['bean_gender']);

            if (isset($day) && isset($month) && isset($year) && isset($gender)) {

                if ($day < 1 || $day > 31 || $month > 12 || $month < 1 || $year < 1920 || $year > 2008) {
                    $message = "Merci d'indiquer une date valide";
                } elseif ($gender !== "M" && $gender !== "F") {
                    $gender = "M";
                } else {
                    $_SESSION['dob'] = $day . "-" . $month . "-" . $year;
                    $_SESSION['gender'] = $gender;
                    $_SESSION['page'] = 1;
                    Redirect($url . "/register?page=1");
                    exit();
                }
            }
        }
        ?> <?PHP if (isset($message)) { ?>
            <div id="error-messages-container" class="cbb">
                <div class="rounded" style="background-color: #cb2121;">
                    <div id="error-title" class="error">
                        <?PHP echo $message; ?><br/>
                    </div>
                </div>
            </div>
        <?PHP } ?>
        <form id="quickregisterform" method="post" action="?page=&do=check">

            <div id="title">
                Date de naissance &amp; Sexe
            </div>

            <div id="date-selector">
                <div id="agegate-notice"><span style="font-size:12px; color: #00ccff;">Merci d'indiquer ta <b>vraie</b> date de naissance </span>
                </div>
                <select name="bean_day" id="bean_day" class="dateselector">
                    <option value="">Jour</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="19">19</option>
                    <option value="20">20</option>
                    <option value="21">21</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
                    <option value="24">24</option>
                    <option value="25">25</option>
                    <option value="26">26</option>
                    <option value="27">27</option>
                    <option value="28">28</option>
                    <option value="29">29</option>
                    <option value="30">30</option>
                    <option value="31">31</option>
                </select> <select name="bean_month" id="bean_month" class="dateselector">
                    <option value="">Mois</option>
                    <option value="1">janvier</option>
                    <option value="2">février</option>
                    <option value="3">mars</option>
                    <option value="4">avril</option>
                    <option value="5">mai</option>
                    <option value="6">juin</option>
                    <option value="7">juillet</option>
                    <option value="8">août</option>
                    <option value="9">septembre</option>
                    <option value="10">octobre</option>
                    <option value="11">novembre</option>
                    <option value="12">décembre</option>
                </select> <select name="bean_year" id="bean_year" class="dateselector">
                    <option value="">Année</option>
                    <option value="2003">2003</option>
                    <option value="2002">2002</option>
                    <option value="2001">2001</option>
                    <option value="2000">2000</option>
                    <option value="1999">1999</option>
                    <option value="1998">1998</option>
                    <option value="1997">1997</option>
                    <option value="1996">1996</option>
                    <option value="1995">1995</option>
                    <option value="1994">1994</option>
                    <option value="1993">1993</option>
                    <option value="1992">1992</option>
                    <option value="1991">1991</option>
                    <option value="1990">1990</option>
                    <option value="1989">1989</option>
                    <option value="1988">1988</option>
                    <option value="1987">1987</option>
                    <option value="1986">1986</option>
                    <option value="1985">1985</option>
                    <option value="1984">1984</option>
                    <option value="1983">1983</option>
                    <option value="1982">1982</option>
                    <option value="1981">1981</option>
                    <option value="1980">1980</option>
                    <option value="1979">1979</option>
                    <option value="1978">1978</option>
                    <option value="1977">1977</option>
                    <option value="1976">1976</option>
                    <option value="1975">1975</option>
                    <option value="1974">1974</option>
                    <option value="1973">1973</option>
                    <option value="1972">1972</option>
                    <option value="1971">1971</option>
                    <option value="1970">1970</option>
                    <option value="1969">1969</option>
                    <option value="1968">1968</option>
                    <option value="1967">1967</option>
                    <option value="1966">1966</option>
                    <option value="1965">1965</option>
                    <option value="1964">1964</option>
                    <option value="1963">1963</option>
                    <option value="1962">1962</option>
                    <option value="1961">1961</option>
                    <option value="1960">1960</option>
                    <option value="1959">1959</option>
                    <option value="1958">1958</option>
                    <option value="1957">1957</option>
                    <option value="1956">1956</option>
                    <option value="1955">1955</option>
                    <option value="1954">1954</option>
                    <option value="1953">1953</option>
                    <option value="1952">1952</option>
                    <option value="1951">1951</option>
                    <option value="1950">1950</option>
                    <option value="1949">1949</option>
                    <option value="1948">1948</option>
                    <option value="1947">1947</option>
                    <option value="1946">1946</option>
                    <option value="1945">1945</option>
                    <option value="1944">1944</option>
                    <option value="1943">1943</option>
                    <option value="1942">1942</option>
                    <option value="1941">1941</option>
                    <option value="1940">1940</option>
                    <option value="1939">1939</option>
                    <option value="1938">1938</option>
                    <option value="1937">1937</option>
                    <option value="1936">1936</option>
                    <option value="1935">1935</option>
                    <option value="1934">1934</option>
                    <option value="1933">1933</option>
                    <option value="1932">1932</option>
                    <option value="1931">1931</option>
                    <option value="1930">1930</option>
                    <option value="1929">1929</option>
                    <option value="1928">1928</option>
                    <option value="1927">1927</option>
                    <option value="1926">1926</option>
                    <option value="1925">1925</option>
                    <option value="1924">1924</option>
                    <option value="1923">1923</option>
                    <option value="1922">1922</option>
                    <option value="1921">1921</option>
                    <option value="1920">1920</option>
                    <option value="1919">1919</option>
                    <option value="1918">1918</option>
                    <option value="1917">1917</option>
                    <option value="1916">1916</option>
                    <option value="1915">1915</option>
                    <option value="1914">1914</option>
                    <option value="1913">1913</option>
                    <option value="1912">1912</option>
                    <option value="1911">1911</option>
                    <option value="1910">1910</option>
                    <option value="1909">1909</option>
                    <option value="1908">1908</option>
                    <option value="1907">1907</option>
                    <option value="1906">1906</option>
                    <option value="1905">1905</option>
                    <option value="1904">1904</option>
                    <option value="1903">1903</option>
                    <option value="1902">1902</option>
                    <option value="1901">1901</option>
                    <option value="1900">1900</option>
                </select>
            </div>

            <div class="delimiter_smooth">
                <div class="flat">&nbsp;</div>
                <div class="arrow">&nbsp;</div>
                <div class="flat">&nbsp;</div>
            </div>

            <div id="inner-container">
                <div id="gender-selection">
                    <div class="select_gender boy selected">
                        <div class="select-container">
                            <input type='radio' id='radio-button-boy' name='bean_gender' value='M' checked='checked'/>
                            <label for="radio-button-boy">Garçon</label>
                        </div>
                        <div class="silhouette">
                            <img src="<?PHP echo $imagepath; ?>v2/images/frontpage/silhouette_boy.png"/>
                        </div>
                    </div>
                    <div class="select_gender girl">
                        <div class="select-container">
                            <input type='radio' id='radio-button-girl' name='bean_gender' value='F'/>
                            <label for="radio-button-girl">Fille</label>
                        </div>
                        <div class="silhouette">
                            <img src="<?PHP echo $imagepath; ?>v2/images/frontpage/silhouette_girl.png"/>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div id="select">
            <a id="back-link" href="<?PHP echo $url; ?>">Retour</a>
            <div class="button">
                <a id="proceed" href="#" class="area">Continuer</a>
                <span class="close"></span>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        L10N.put("identity.register.overlay.loading.text", 'Chargement...');
        document.observe("dom:loaded", function () {
            QuickRegister.initAgeGate(true);
        });
    </script>
<?PHP } elseif ($page == '1') { ?>

    <div id="stepnumbers">

        <div class="stepdone">Date de naissance et sexe</div>

        <div class="step2focus">Détails du compte</div>


        <div class="stephabbo"></div>

    </div>


    <div id="main-container">
        <?PHP if ($do == "check") {
            $pseudo = Secu($_POST['bean_name']);
            $email = Secu($_POST['bean_email']);
            $motdepasse = Secu($_POST['bean_password']);
            $remotdepasse = Secu($_POST['bean_repassword']);
            $filtre_pseudo = preg_replace("/[^a-z\d\-=\?!@:\.]/i", "", $pseudo);
            $verifmail = preg_match("/^[a-z0-9_\.-]+@([a-z0-9]+([\-]+[a-z0-9]+)*\.)+[a-z]{2,7}$/i", $email);
            $selectuser = $bdd->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
            $selectuser->execute([$pseudo]);
            $su = $selectuser->rowCount();
            $selectmail = $bdd->prepare("SELECT id FROM users WHERE mail = ? LIMIT 1");
            $selectmail->execute([$email]);
            $sm = $selectmail->rowCount();
            if (isset($pseudo) && isset($email) && isset($motdepasse) && isset($remotdepasse)) {
                if ($su > 0) {
                    $message['name'] = "Ton pseudo est déj&agrave; utilisé.";
                }
                if ($sm > 0) {
                    $message['name'] = "Ton adresse e-mail est déjà utilisé.";
                } elseif ($filtre_pseudo !== $pseudo) {
                    $message['name'] = "Ton pseudo contient des caract&egrave;res non-autorisé.";
                } elseif (strlen($pseudo) > 24) {
                    $message['name'] = "Ton pseudo est trop long.";
                } elseif (strlen($pseudo) < 1) {
                    $message['name'] = "Merci d'entrer un pseudo.";
                }

                if ($motdepasse != $remotdepasse) {
                    $message['password'] = "Les mots de passe ne correspondent pas.";
                } elseif (strlen($motdepasse) < 6) {
                    $message['password'] = "Ton mot de passe est trop court.";
                }

                if (strlen($email) < 6) {
                    $message['email'] = "Ton adresse e-mail est invalide.";
                } elseif ($verifmail !== 1) {
                    $message['email'] = "Ton adresse e-mail est invalide.";
                }
                $mdpok = password_hash($motdepasse, PASSWORD_BCRYPT);
                if ($_SESSION['gender'] == "M") {
                    $look = $look_boy;
                } else {
                    $look = $look_girl;
                }
                if (empty($message)) {
                    if (!empty($_POST['envoimail'])) {
                        $insertuser = $bdd->prepare("INSERT INTO users (username, password, mail, rank, look, gender, motto, credits, last_login, account_created, ip_register, message, newsletter) VALUES (:pseudo, :mdp, :mail, :rank, :look, :sexe, :motto, :credits, :date, :ins, :ip, :message, :newsletter)");
                        $insertuser->bindValue(':pseudo', $pseudo);
                        $insertuser->bindValue(':mdp', $mdpok);
                        $insertuser->bindValue(':mail', $email);
                        $insertuser->bindValue(':rank', $rank);
                        $insertuser->bindValue(':look', $look);
                        $insertuser->bindValue(':sexe', $_SESSION['gender']);
                        $insertuser->bindValue(':motto', $mission);
                        $insertuser->bindValue(':credits', $credits);
                        //todo : pixels
                        //    $insertuser->bindValue(':pixels', $pixels);
                        $insertuser->bindValue(':date', time());
                        $insertuser->bindValue(':ins', FullDate('hc'));
                        $insertuser->bindValue(':ip', $_SERVER["REMOTE_ADDR"]);
                        $insertuser->bindValue(':message', '100');
                        $insertuser->bindValue(':newsletter', '1');
                        $insertuser->execute();
                        $fichier_message = '<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bonjour <b>' . $pseudo . '</b>,</div>
<div>&nbsp;</div>
<div>Tu as désiré t&#39;inscrire &agrave; la newsletter de ' . $sitename . ', nous t&#39;en remercions.</div>
<div>&nbsp;</div>
<div>Pour info, tu peux &agrave; tout moment t&#39;inscrire ou te désinscrire depuis la page &quot;Mes préférences&quot;.</div>
<div>&nbsp;</div><div style="text-align: right;">Cordialement, l&#39;équipe de ' . $sitename . '</div>'; //On ajoute les infos au message
                        // On définit la liste des inscrits.
                        $message = $fichier_message;
                        $destinataire = $email;

                        $objet = "Inscription Newsletter - " . $sitename . ""; // On définit l'objet qui contient la date.

                        // On définit le reste des paramètres.
                        $headers = "MIME-Version: 1.0 \r\n";
                        $headers .= "Content-type: text/html; charset=iso-8859-1 \r\n";
                        $headers .= "From: Newsletter - " . $sitename . " <" . $mail_newsletter . "> \r\n"; // On définit l'expéditeur.

                        // On envoie l'e-mail.
                        mail($destinataire, $objet, $fichier_message, $headers);
                    } else {
                        $insertusera = $bdd->prepare("INSERT INTO users (username, password, mail, rank, look, gender, motto, credits, last_login, account_created, ip_register, message, newsletter) VALUES (:pseudo, :mdp, :mail, :rank, :look, :sexe, :motto, :credits, :date, :ins, :ip, :message, :newsletter)");
                        $insertusera->bindValue(':pseudo', $pseudo);
                        $insertusera->bindValue(':mdp', $mdpok);
                        $insertusera->bindValue(':mail', $email);
                        $insertusera->bindValue(':rank', $rank);
                        $insertusera->bindValue(':look', $look);
                        $insertusera->bindValue(':sexe', $_SESSION['gender']);
                        $insertusera->bindValue(':motto', $mission);
                        $insertusera->bindValue(':credits', $credits);
                        //todo : pixels
                        //    $insertuser->bindValue(':pixels', $pixels);
                        $insertusera->bindValue(':date', time());
                        $insertusera->bindValue(':ins', FullDate('hc'));
                        $insertusera->bindValue(':ip', $_SERVER["REMOTE_ADDR"]);
                        $insertusera->bindValue(':message', '100');
                        $insertusera->bindValue(':newsletter', '0');
                        $insertusera->execute();
                    }
                    $_SESSION['username'] = $pseudo;
                    $_SESSION['password'] = $mdpok;
                    Redirect($url . '/bienvenue');
                }
            }
        }
        ?>


        <?PHP if (isset($message)) { ?>
            <div id="error-messages-container" class="cbb">
                <div class="rounded" style="background-color: #cb2121;">
                    <div id="error-title" class="error">
                        <?PHP if (isset($message['name'])) {
                            echo "" . $message['name'] . "<br>";
                        } ?>
                        <?PHP if (isset($message['email'])) {
                            echo "" . $message['email'] . "<br>";
                        } ?>
                        <?PHP if (isset($message['password'])) {
                            echo "" . $message['password'] . "<br>";
                        } ?>
                    </div>
                </div>
            </div>
        <?PHP } ?>


        <div id="title">

            <center>Détails du compte</center>
        </div>


        <form method="post" action="?page=1&do=check" id="quickregister-form">

            <div id="inner-container">

                <div class="inner-content bottom-border">


                    <div class="field-content clearfix">

                        <div class="left">

                            <div class="label" class="registration-text"><b><span
                                            style="font-size:11px; color: #22b9f1;">Pseudo</span></b></div>

                            <input type='text' id='pseudo' name='bean_name' value='' required/>

                        </div>

                        <div class="right">

                            <div class="help"><u>Etape n°1 :</u> Entre le pseudo que tu souhaite avoir.</div>

                        </div>

                    </div>


                    <div class="field-content clearfix">

                        <div class="left">

                            <div class="label" class="registration-text"><span
                                        style="font-size:11px; color: #22b9f1;"><b>Email</b></span></div>

                            <input type='text' id='email-address' name='bean_email' value='' required/>

                        </div>

                        <div class="right">

                            <div class="help"><u>Etape n°2 :</u> Entre ton adresse email. Pour le service client.</div>

                        </div>

                    </div>


                    <div class="field-content clearfix">

                        <div class="left">

                            <div class="field">

                                <div class="label" class="registration-text"><span
                                            style="font-size:11px; color: #22b9f1;"><b>Mot de passe</b></span></div>

                                <input type='password' name='bean_password' id='register-password' maxlength='32'
                                       value='' required/>

                            </div>

                            <div class="password-field">

                                <div class="label" class="registration-text"><span
                                            style="font-size:11px; color: #22b9f1;"><b>Re-tape ton Mot de Passe</b>
                                </div>

                                <input type='password' name='bean_repassword' id='register-password2' maxlength='32'
                                       value='' required/>

                            </div>


                        </div>

                        <div class="right">

                            <div class="help"><u>Etape n°3 :</u> Choisis un mot de passe difficile et sécurisé.<br><br>
                                <font color="red">Pense a utilisé un mot de passe que tu n'as jamais mis nul
                                    part.</font>
                            </div>

                        </div>

                    </div>

                </div>


                <div class="inner-content top-margin">

                    <div class="field-content checkbox ">

                        <label>

                            <input type='checkbox' name='bean_condition' id='terms' value='true'
                                   class='checkbox-field' required/>

                            J'accepte les <a href="#" target="_blank"
                                             onclick="window.open('../disclaimer'); return false;">conditions générales
                                d'utilisations</a><br/>

                        </label>

                    </div>


                    <div>

                        <label>


                        </label>

                    </div>

                </div>

            </div>


        </form>


        <div id="select">

            <div class="button">

                <a id="proceed-button" href="#" class="area">Continuer</a>

                <span class="close"></span>

            </div>

            <a href="<?PHP echo $url; ?>/register?page=back" id="back-link">Retour</a>

        </div>

    </div>


    <script type="text/javascript">
        document.observe("dom:loaded", function () {

            Event.observe($("back-link"), "click", function () {

                Overlay.show(null, 'Chargement...');

            });

            Event.observe($("proceed-button"), "click", function () {

                Overlay.show(null, 'Chargement...');

                $("quickregister-form").submit();

            });

            $("email-address").focus();

        });
    </script>
<?PHP } elseif ($page == "back") {
    session_destroy();
    Redirect("" . $url . "/register");
} else {
    Redirect("" . $url . "/register");
} ?>

<script type="text/javascript">
    HabboView.run();
</script>

</body>

</html>