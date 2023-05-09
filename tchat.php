<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("./config.php");
$pagename = "Tchat";
$pageid = "tchat";

if (!isset($_SESSION['username'])) {
    Redirect("" . $url . "/index");
}
$captcha = rand(0, 9999999);
if (isset($_POST['message'])) {
    $message = Secu($_POST['message']);
    $captcha_verif = Secu($_POST['captcha_verif']);
    $captcha_code = Secu($_POST['captcha_code']);
    if (empty($message)) {
        $affichage = get_error_msg("Merci de marquer un message", "red");
    } elseif ($captcha_code !== $captcha_verif) {
        $affichage = get_error_msg("Merci de recopier le bon captcha", "red");
    } else {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_tchat (pseudo,message,ip,date,look,rank) VALUES (:pseudo,:message,:ip,:date,:look,:rank)");
        $insertn1->execute(array(
            ':pseudo' => $user['username'],
            ':message' => $message,
            ':ip' => $user['ip_current'],
            ':date' => FullDate('full'),
            ':look' => $user['look'],
            ':rank' => $user['rank']
        ));
        $bdd->query("UPDATE users SET message = message - 1 WHERE id = '" . $user['id'] . "'");
        $affichage = get_error_msg("Ton message a été posté avec succès!", "green");
    }
}

function get_error_msg($message, $color)
{
    return "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-$color\"> 
              $message
            </div> 
        </div> 
</div>";
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
    <script src="<?PHP echo $imagepath; ?>static/js/common.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>js/tooltip.js" type="text/javascript"></script>
    <script language="javascript" type="text/javascript">
        function insert_texte(texte) {
            var ou = document.getElementsByName("message")[0];
            var phrase = texte + " ";
            ou.value += phrase;
            ou.focus();
        }
    </script>
    <script src="<?PHP echo $imagepath; ?>static/js/fullcontent.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/style.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/buttons.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/boxes.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/tooltips.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/personal.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
    <script src="<?PHP echo $imagepath; ?>static/js/habboclub.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/minimail.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/myhabbo/control.textarea.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
    <script src="<?PHP echo $imagepath; ?>static/js/minimail.js" type="text/javascript"></script>



    <meta name="description" content="<?PHP echo $description; ?>" />
    <meta name="keywords" content="<?PHP echo $keyword; ?>" />
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
body { behavior: url(http://www.habbo.com/js/csshover.htc); }
</style>
<![endif]-->
    <meta name="build" content="<?PHP echo $build; ?> >> <?PHP echo $version; ?>" />
</head>

<body id="home">
    <div id="tooltip"></div>
    <div id="overlay"></div>
    <!-- MENU -->
    <?PHP include("./template/header.php"); ?>
    <!-- FIN MENU -->
    <div id="container">
        <div id="content" style="position: relative" class="clearfix">
            <div id="column2" class="column">
                <div class="habblet-container">
                    <div class="cbb clearfix blue">
                        <h2 class="title">Quelques infos</h2>
                        <div class="box-content">
                            <?php
                            $modifier_mes = ($user['message'] >= 2) ? 'messages' : (($user['message'] == 1) ? 'message, attention, tu ne pourras plus en poster après celui-ci' : 'message');
                            ?>
                            Avant de poster un message, assure toi que:<br />
                            &nbsp;&nbsp;&nbsp;- Tu ne pubs pas<br />
                            &nbsp;&nbsp;&nbsp;- Tu ne flood pas<br />
                            &nbsp;&nbsp;&nbsp;- Tu respectes la <?PHP echo $sitename; ?> attitude<br /><br />
                            Si tu respectes tout ça, tu peux poster ton message! En revanche, si tu ne respectes pas nos conditions, tes messages se verront supprimés et ton compte bannis.<br /><br />
                            Tu peux encore poster <b><?php echo $user['message']; ?></b> <?PHP echo $modifier_mes; ?>.
                            <?PHP if (isset($affichage)) {
                                echo "<br/>" . $affichage . "";
                            } ?>
                        </div>
                    </div>
                </div>
                <div class="habblet-container">
                    <div class="cbb clearfix red">
                        <h2 class="title">Poster un message</h2>
                        <div class="box-content">
                            <?php
                            if ($user['message'] >= 1) {
                                $smileys = [
                                    ';)' => 'clindoeil.gif',
                                    ':$' => 'embarrase.gif',
                                    ':o' => 'etonne.gif',
                                    ':)' => 'happy.gif',
                                    ':x' => 'icon_silent.png',
                                    ':p' => 'langue.gif',
                                    ':\'(' => 'sad.gif',
                                    ':D' => 'veryhappy.gif',
                                    ':jap:' => 'jap.png',
                                    '8)' => 'cool.gif',
                                    ':rire:' => 'rire.gif',
                                    ':evil:' => 'icon_evil.gif',
                                    ':twisted:' => 'icon_twisted.gif',
                                    ':rool:' => 'roll.gif',
                                    ':|' => 'neutre.gif',
                                    ':suspect:' => 'suspect.gif',
                                    ':no:' => 'no.gif',
                                    ':coeur:' => 'coeur.gif',
                                    ':hap:' => 'hap.gif',
                                    ':bave:' => 'bave.gif',
                                    ':areuh:' => 'areuh.gif',
                                    ':bandit:' => 'bandit.gif',
                                    ':help:' => 'help.gif'
                                ];

                                $modifier_u = "<td width='100' class='tbl'><b>Message que tu souhaites poster:</b><br/>";
                                foreach ($smileys as $smiley => $image) {
                                    $modifier_u .= "<a href=\"#\" onclick=\"insert_texte('{$smiley}')\"><img src=\"./web-gallery/smileys/{$image}\"/></a>";
                                }
                                $modifier_u .= "<form name='editor' method='post' action=\"?do=ok\">
        <td width='80%' class='tbl'>
            <input type='text' name='message' id='message' class='text' style='width: 240px' title='Message que tu souhaites poster..' placeholder='Écris quelque chose..'  onmouseover='tooltip.show(this)' onmouseout='tooltip.hide(this)'><br/>
        </td>
        <br/>Recopie <b>{$captcha}</b> : <input type='text' name='captcha_code' id='message' class='text' size='7' title='Recopie le captcha exact' onmouseover='tooltip.show(this)' onmouseout='tooltip.hide(this)'><input type='hidden' name='captcha_verif' value='{$captcha}'><br/>
        </td>
        <tr>
            <td align='center' colspan='2' class='tbl'>
                <input type='submit' name='submit' value='Exécuter'>
            </td>
        </tr>
    </form>";
                            } else {
                                $modifier_u = "Tu ne peux pas poster de message, vu que tu n'as plus assez de \"Messages\". Pour en avoir plus, demande à un staff via le service client, ou achètes les via la boutique!";
                            }

                            ?>
                            <?PHP echo $modifier_u; ?>
                        </div>
                    </div>
                </div>
                <div class="habblet-container">
                    <div class="cbb clearfix orange">
                        <h2 class="title">Légende</h2>
                        <div class="box-content">
                            La légende pour la couleur des rank:<br />
                            - Utilisateur: <b><span style="color:#FF8C00">Orange</span><br /></b>
                            - VIP: <b><span style="color:#B22222">Rouge foncé</span><br /></b>
                            - STAFF CLUB : <b><span style="color:#32CD32">Vert clair</span><br /></b>
                            - Membre de l'équipe: <b><span style="color:red">Rouge</span><br /></b>
                        </div>
                    </div>
                </div>
            </div>
            <div id="column1" class="column">
                <div class="habblet-container ">
                    <div class="cbb clearfix brown ">
                        <h2 class="title">Tchat</h2>

                        <div class="box-content">
                            <style>
                                table {
                                    background-color: #fff;
                                    font-size: 11px;
                                    padding: 4px;
                                    margin-left: -15px;
                                    width: 105%;
                                }

                                table:nth-child(2n+1) {
                                    background-color: #fffcaf;
                                    font-size: 11px;
                                    padding: 4px;
                                    margin-left: -15px;
                                    width: 105%;
                                }
                            </style>
                            <?php
                            $messagesParPage = $cof['nb_tchat'];
                            $pageActuelle = isset($_GET['page']) ? intval($_GET['page']) : 1;

                            $total = $bdd->query('SELECT COUNT(*) AS total FROM gabcms_tchat')->fetchColumn();
                            $nombreDePages = ceil($total / $messagesParPage);

                            $pageActuelle = min(max(1, $pageActuelle), $nombreDePages);
                            $premiereEntree = ($pageActuelle - 1) * $messagesParPage;

                            $retour_messages = $bdd->prepare('SELECT * FROM gabcms_tchat ORDER BY id DESC LIMIT :premiereEntree, :messagesParPage');
                            $retour_messages->bindParam(':premiereEntree', $premiereEntree, PDO::PARAM_INT);
                            $retour_messages->bindParam(':messagesParPage', $messagesParPage, PDO::PARAM_INT);
                            $retour_messages->execute();

                            while ($donnees_messages = $retour_messages->fetch(PDO::FETCH_ASSOC)) {
                                switch ($donnees_messages['rank']) {
                                    case 1:
                                        $modifier_r = "#FF8C00";
                                        break;
                                    case 2:
                                        $modifier_r = "#B22222";
                                        break;
                                    case 3:
                                        $modifier_r = "#32CD32";
                                        break;
                                    case 5:
                                    case 6:
                                    case 7:
                                    case 8:
                                        $modifier_r = "red";
                                        break;
                                    default:
                                        $modifier_r = "";
                                        break;
                                }

                                switch ($donnees_messages['alert']) {
                                    case 1:
                                        $alert = "red";
                                        $alert_2 = "<b>";
                                        $alert_3 = "</b>";
                                        $alert_4 = "<span style=\"color:#FF0000\">ALERTE DE </span>";
                                        break;
                                    default:
                                        $alert = "#000000";
                                        $alert_2 = $alert_3 = $alert_4 = "";
                                        break;
                                }


                            ?>
                                <table>

                                    <tbody>
                                        <tr>
                                            <td valign="middle" width="10" height="60">
                                                <?PHP if ($donnees_messages['pseudo'] != "") { ?><a href="<?PHP echo $url ?>/info?tag=<?PHP echo $donnees_messages['pseudo'] ?>" title="Aller sur son profil &raquo;" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)"><?PHP } ?><div style="width: 64px; height: 65px; margin-bottom:-9px; margin-top:-5px; margin-left: -5px; float: left; background: url(<?php echo $avatarimage; ?><?PHP echo $donnees_messages['look'] ?>&action=wav&direction=2&head_direction=2&gesture=sml&size=big&img_format=gif);"></div></a>
                                            </td>
                                            <td valign="top">
                                                <b style="font-size: 13px;"><?PHP echo $alert_4 ?><span style="color:<?PHP echo $modifier_r ?>;"><?PHP echo $donnees_messages['pseudo'] ?></span></b><span style="float: right; color:#000000;font-size: 11px;"><?PHP echo $donnees_messages['date'] ?></span><br />
                                                <div id="cta_01"></div>
                                                <div id="cta_02"><span style="color:<?PHP echo $alert ?>;font-size: 11px;"><?PHP echo $alert_2 ?><?PHP echo smileys($donnees_messages['message']) ?><?PHP echo $alert_3 ?></span></div>
                                                <div id="cta_03"></div>
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>
                            <?PHP }

                            $messagesParPage = $cof['nb_tchat'];
                            $retour_total = $bdd->query('SELECT COUNT(*) AS total FROM gabcms_tchat');
                            $total = $retour_total->fetch(PDO::FETCH_ASSOC)['total'];
                            $nombreDePages = ceil($total / $messagesParPage);
                            $pageActuelle = isset($_GET['page']) ? min(intval($_GET['page']), $nombreDePages) : 1;
                            $premiereEntree = ($pageActuelle - 1) * $messagesParPage;
                            $retour_messages = $bdd->query("SELECT * FROM gabcms_tchat ORDER BY id DESC LIMIT $premiereEntree, $messagesParPage");

                            while ($donnees_messages = $retour_messages->fetch(PDO::FETCH_ASSOC)) {
                                $modifier_r = "#000000";
                                if ($donnees_messages['rank'] == 1) {
                                    $modifier_r = "#FF8C00";
                                } else if ($donnees_messages['rank'] == 2) {
                                    $modifier_r = "#B22222";
                                } else if ($donnees_messages['rank'] == 3) {
                                    $modifier_r = "#32CD32";
                                } else if ($donnees_messages['rank'] >= 5 && $donnees_messages['rank'] <= 8) {
                                    $modifier_r = "red";
                                }

                                $alert = $donnees_messages['alert'] == 1 ? "red" : "#000000";
                                $alert_2 = $donnees_messages['alert'] == 1 ? "<b>" : "";
                                $alert_3 = $donnees_messages['alert'] == 1 ? "</b>" : "";
                                $alert_4 = $donnees_messages['alert'] == 1 ? "<span style=\"color:#FF0000\">ALERTE DE </span>" : "";

                                // affichage du message
                            }

                            echo '<p align="center">Page: ';
                            for ($i = 1; $i <= $nombreDePages; $i++) {
                                if ($i == $pageActuelle) {
                                    echo ' [ ' . $i . ' ] ';
                                } else {
                                    echo ' <a href="tchat?page=' . $i . '">' . $i . '</a> ';
                                }
                            }
                            echo '</p>';

                            ?>
                        </div>

                    </div>
                </div>
            </div>
            <script type="text/javascript">
                if (!$(document.body).hasClassName('process-template')) {
                    Rounder.init();
                }
            </script>
            <!--[if lt IE 7]>
<![endif]-->
            <div style="clear: both;"></div>
        </div>
    </div>
    <script type="text/javascript">
        HabboView.run();
    </script>
</body>

</html>