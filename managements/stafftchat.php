<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");
$pagename = "Tchat staff";
$pageid = "tchatstaff";

if (!isset($_SESSION['username']) || $user['rank'] < 5 || $user['rank'] > 11) {
    Redirect("" . $url . "/managements/acces_interdit");
    exit();
}

$rank_modif = "";
switch ($user['rank']) {
    case 11:
    case 10:
    case 9:
    case 8:
        $rank_modif = "fondateur";
        break;
    case 7:
        $rank_modif = "manager";
        break;
    case 6:
        $rank_modif = "administratrice";
        if ($user['gender'] == 'M') {
            $rank_modif = "administrateur";
        }
        break;
    case 5:
        $rank_modif = "modératrice";
        if ($user['gender'] == 'M') {
            $rank_modif = "modérateur";
        }
        break;
}

$captcha = rand(0, 9999999);

if (isset($_POST['message'])) {
    $message = Secu($_POST['message']);
    $captcha_verif = Secu($_POST['captcha_verif']);
    $captcha_code = Secu($_POST['captcha_code']);

    if ($message != "") {
        $affichage = "<div id=\"purse-redeem-result\">
            <div class=\"redeem-error\">
                <div class=\"rounded rounded-green\"> Ton message a été posté avec succès!</div>
            </div>
        </div>";

        if ($captcha_code != $captcha_verif) {
            $affichage = "<div id=\"purse-redeem-result\">
                <div class=\"redeem-error\">
                    <div class=\"rounded rounded-red\"> Merci de recopier le bon captcha </div>
                </div>
            </div>";
        } else {
            $insertn1 = $bdd->prepare("INSERT INTO gabcms_tchat_staff (pseudo, message, ip, date, look, rank) VALUES (:pseudo, :message, :ip, :date, :look, :rank)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':message', $message);
            $insertn1->bindValue(':ip', $user['ip_current']);
            $insertn1->bindValue(':date', FullDate('full'));
            $insertn1->bindValue(':look', $user['look']);
            $insertn1->bindValue(':rank', $user['rank']);
            $insertn1->execute();
        }
    } else {
        $affichage = "<div id=\"purse-redeem-result\">
            <div class=\"redeem-error\">
                <div class=\"rounded rounded-red\"> Merci de marquer un message </div>
            </div>
        </div>";
    }
}

$cof = $bdd->query("SELECT * FROM gabcms_config WHERE id = '1'")->fetch(PDO::FETCH_ASSOC);

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
    <?PHP include("../template/header.php"); ?>
    <!-- FIN MENU -->
    <div id="container">
        <div id="content" style="position: relative" class="clearfix">
            <div id="column2" class="column">
                <div class="habblet-container">
                    <div class="cbb clearfix red">
                        <h2 class="title">Poster un message</h2>
                        <div class="box-content">
                            <td width='100' class='tbl'><b>Message que tu souhaites poster :</b><br /></td><br />
                            <a href="#" onclick="insert_texte(';)')"><img src="<?PHP echo $imagepath; ?>smileys/clindoeil.gif" /></a>
                            <a href="#" onclick="insert_texte(':$')"><img src="<?PHP echo $imagepath; ?>smileys/embarrase.gif" /></a>
                            <a href="#" onclick="insert_texte(':o')"><img src="<?PHP echo $imagepath; ?>smileys/etonne.gif" /></a>
                            <a href="#" onclick="insert_texte(':)')"><img src="<?PHP echo $imagepath; ?>smileys/happy.gif" /></a>
                            <a href="#" onclick="insert_texte(':x')"><img src="<?PHP echo $imagepath; ?>smileys/icon_silent.png" /></a>
                            <a href="#" onclick="insert_texte(':p')"><img src="<?PHP echo $imagepath; ?>smileys/langue.gif" /></a>
                            <a href="#" onclick="insert_texte(':\'(')"><img src="<?PHP echo $imagepath; ?>smileys/sad.gif" /></a>
                            <a href="#" onclick="insert_texte(':D')"><img src="<?PHP echo $imagepath; ?>smileys/veryhappy.gif" /></a>
                            <a href="#" onclick="insert_texte(':jap:')"><img src="<?PHP echo $imagepath; ?>smileys/jap.png" /></a>
                            <a href="#" onclick="insert_texte('8)')"><img src="<?PHP echo $imagepath; ?>smileys/cool.gif" /></a>
                            <a href="#" onclick="insert_texte(':rire:')"><img src="<?PHP echo $imagepath; ?>smileys/rire.gif" /></a>
                            <a href="#" onclick="insert_texte(':evil:')"><img src="<?PHP echo $imagepath; ?>smileys/icon_evil.gif" /></a>
                            <a href="#" onclick="insert_texte(':twisted:')"><img src="<?PHP echo $imagepath; ?>smileys/icon_twisted.gif" /></a>
                            <a href="#" onclick="insert_texte(':rool:')"><img src="<?PHP echo $imagepath; ?>smileys/roll.gif" /></a>
                            <a href="#" onclick="insert_texte(':|')"><img src="<?PHP echo $imagepath; ?>smileys/neutre.gif" /></a>
                            <a href="#" onclick="insert_texte(':suspect:')"><img src="<?PHP echo $imagepath; ?>smileys/suspect.gif" /></a>
                            <a href="#" onclick="insert_texte(':no:')"><img src="<?PHP echo $imagepath; ?>smileys/no.gif" /></a>
                            <a href="#" onclick="insert_texte(':coeur:')"><img src="<?PHP echo $imagepath; ?>smileys/coeur.gif" /></a>
                            <a href="#" onclick="insert_texte(':hap:')"><img src="<?PHP echo $imagepath; ?>smileys/hap.gif" /></a>
                            <a href="#" onclick="insert_texte(':bave:')"><img src="<?PHP echo $imagepath; ?>smileys/bave.gif" /></a>
                            <a href="#" onclick="insert_texte(':areuh:')"><img src="<?PHP echo $imagepath; ?>smileys/areuh.gif" /></a>
                            <a href="#" onclick="insert_texte(':bandit:')"><img src="<?PHP echo $imagepath; ?>smileys/bandit.gif" /></a>
                            <a href="#" onclick="insert_texte(':help:')"><img src="<?PHP echo $imagepath; ?>smileys/help.gif" /></a>
                            <a href="#" onclick="insert_texte(':buzz:')"><img src="<?PHP echo $imagepath; ?>smileys/buzz.gif" /></a>
                            <a href="#" onclick="insert_texte(':contrat:')"><img src="<?PHP echo $imagepath; ?>smileys/contrat.gif" /></a>
                            <a href="#" onclick="insert_texte(':favo:')"><img src="<?PHP echo $imagepath; ?>smileys/pour.gif" /></a>
                            <a href="#" onclick="insert_texte(':contre:')"><img src="<?PHP echo $imagepath; ?>smileys/contre.gif" /></a>
                            <form name='editor' method='post' action="?do=ok">
                                <td width='80%' class='tbl'><input type='text' name='message' id='message' class='text' style='width: 240px' title="Message que tu souhaites poster.." placeholder="Écris quelque chose.." onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)"><br /></td>
                                <br />Recopie <b><?PHP echo Secu($captcha); ?></b> : <input type='text' name='captcha_code' id='message' class='text' size='7' title='Recopie le captcha exact' onmouseover='tooltip.show(this)' onmouseout='tooltip.hide(this)'><input type='hidden' name='captcha_verif' value='<?PHP echo Secu($captcha); ?>'><br /></td>
                                <tr>
                                    <td align='center' colspan='2' class='tbl'>
                                        <input type='submit' name='submit' value='Exécuter'>
                            </form>
                            </tr>
                            <?PHP if (isset($affichage)) {
                                echo "<br/>" . $affichage . "";
                            } ?>
                        </div>
                    </div>
                </div>
                <div class="habblet-container">
                    <div class="cbb clearfix orange">
                        <h2 class="title">Légende</h2>
                        <div class="box-content">
                            La légende pour la couleur des rank :<br />
                            - Modérateur : <b><span style="color:red">Rouge</span><br /></b>
                            - Administrateur : <b><span style="color:green">Vert</span><br /></b>
                            - Manageur : <b><span style="color:#C1B31C">Jaune</span><br /></b>
                            - Fondateur : <b><span style="color:blue">Bleu</span><br /></b>
                        </div>
                    </div>
                </div>
            </div>


            <div id="column1" class="column">
                <div class="habblet-container ">
                    <div class="cbb clearfix brown ">
                        <h2 class="title">Tchat</h2>

                        <div class="box-content">
                            <?php
                            $messagesParPage = $cof['nb_tchat'];
                            $pageActuelle = isset($_GET['page']) ? intval($_GET['page']) : 1;
                            $premiereEntree = ($pageActuelle - 1) * $messagesParPage;
                            $retour_messages = $bdd->query("SELECT * FROM gabcms_tchat_staff ORDER BY id DESC LIMIT $premiereEntree, $messagesParPage");

                            $total = $bdd->query('SELECT COUNT(*) AS total FROM gabcms_tchat_staff')->fetch(PDO::FETCH_ASSOC)['total'];
                            $nombreDePages = ceil($total / $messagesParPage);
                            if ($pageActuelle > $nombreDePages) {
                                $pageActuelle = $nombreDePages;
                            }

                            $rankToModifier = [
                                5 => "red",
                                6 => "green",
                                7 => "#C1B31C",
                                0 => "#F9C00B",
                                8 => "blue",
                                9 => "blue",
                                10 => "blue",
                                11 => "blue",
                            ];

                            while ($donnees_messages = $retour_messages->fetch(PDO::FETCH_ASSOC)) {
                                $modifier_r = $rankToModifier[$donnees_messages['rank']] ?? '';
                            ?>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td valign="middle" width="10" height="60">
                                                <?PHP if ($donnees_messages['pseudo'] != "") { ?><a href="<?PHP echo $url; ?>/user_profile?name=<?PHP echo Secu($donnees_messages['pseudo']); ?>" title="Aller sur son profil &raquo;" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)"><?PHP } ?><div style="width: 64px; height: 65px; margin-bottom:-9px; margin-top:-5px; margin-left: -5px; float: left; background: url(<?php echo $avatarimage; ?><?PHP echo Secu($donnees_messages['look']); ?>&action=wav&direction=2&head_direction=2&gesture=sml&size=big&img_format=gif);"></div></a>
                                            </td>
                                            <td valign="top">
                                                <span style="color:<?PHP echo $modifier_r ?>;"><b style="font-size: 13px;"><?PHP echo Secu($donnees_messages['pseudo']); ?></span></b><span style="float: right; color:#000000;font-size: 11px;"><?PHP echo Secu($donnees_messages['date']); ?></span><br />
                                                <div id="cta_01"></div>
                                                <div id="cta_02"><span style="color:#000000;font-size: 11px;"><?PHP echo smileystaff($donnees_messages['message']) ?></span></div>
                                                <div id="cta_03"></div>
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>
                            <?PHP }
                            $html = '<p align="center">Page : ';
                            foreach (range(1, $nombreDePages) as $i) {
                                $html .= $i == $pageActuelle ? ' [ ' . $i . ' ] ' : ' <a href="stafftchat?page=' . $i . '">' . $i . '</a> ';
                            }
                            $html .= '</p>';
                            echo $html;
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
            <!-- FOOTER -->
            <?PHP include("../template/footer.php"); ?>
            <!-- FIN FOOTER -->
            <div style="clear: both;"></div>
        </div>
    </div>
    <script type="text/javascript">
        HabboView.run();
    </script>
</body>

</html>