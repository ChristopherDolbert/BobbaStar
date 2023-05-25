<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");
$pagename = "Actions &raquo; Service client";
$pageid = "sc_index";

if (!isset($_SESSION['username']) || $user['rank'] < 5 || $user['rank'] > 11) {
    Redirect("" . $url . "/managements/acces_interdit");
    exit();
}

$rank_modif = "";
switch ($user['rank']) {
    case 11:
        $rank_modif = "fondateur";
        break;
    case 10:
        $rank_modif = "fondateur";
        break;
    case 9:
        $rank_modif = "fondateur";
        break;
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

$id = Secu($_GET['id']);
$infr = $bdd->prepare("SELECT * FROM gabcms_contact WHERE id = :id");
$infr->bindValue(':id', $id);
$infr->execute();
$r = $infr->fetch(PDO::FETCH_ASSOC);

$etat_modifs = array(
    0 => "<span style=\"color:#FF4500\"><b>Signalé</b></span>",
    1 => "<span style=\"color:#4B0082\"><b>En étude</b></span>",
    2 => "<span style=\"color:#FF0000\"><b>Correction à faire</b></span>",
    3 => "<span style=\"color:#0000FF\"><b>Attente réponse du joueur</b></span>",
    4 => "<span style=\"color:#8B4513\"><b>Réponse donnée par le joueur</b></span>",
    5 => "<span style=\"color:#2E8B57\"><b>En test</b></span>",
    6 => "<span style=\"color:#008000\"><b>Fermé - Résolu</b></span>",
    7 => "<span style=\"color:#8bda20\"><b>Fermé - déjà signalé/résolu</b></span>",
    8 => "<span style=\"color:#DAA520\"><b>Fermé - sans suite</b></span>",
);

if (isset($etat_modifs[$r['resul']])) {
    $etat_modif = $etat_modifs[$r['resul']];
} else {
    $etat_modif = '';
}

$stmt = $bdd->prepare("SELECT id FROM users WHERE username = :username");
$stmt->bindValue(':username', $r['pseudo']);
$stmt->execute();
$row = $stmt->rowCount();
$assoc = $stmt->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['etat'])) {
    $etat = Secu($_POST['etat']);
    if ($id != "" && $etat != "") {
        $etat_to_modif = array(
            0 => "<span style=\"color:#FF4500\"><b>Signalé</b></span>",
            1 => "<span style=\"color:#4B0082\"><b>En étude</b></span>",
            2 => "<span style=\"color:#FF0000\"><b>Correction à faire</b></span>",
            3 => "<span style=\"color:#0000FF\"><b>Attente réponse du joueur</b></span>",
            4 => "<span style=\"color:#8B4513\"><b>Réponse donnée par le joueur</b></span>",
            5 => "<span style=\"color:#2E8B57\"><b>En test</b></span>",
            6 => "<span style=\"color:#008000\"><b>Fermé - Résolu</b></span>",
            7 => "<span style=\"color:#8bda20\"><b>Fermé - déjà signalé/résolu</b></span>",
            8 => "<span style=\"color:#DAA520\"><b>Fermé - sans suite</b></span>"
        );
        $retat_modif = $etat_to_modif[$etat];

        $insertn1 = "INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)";
        $insertn2 = "INSERT INTO gabcms_contact_info (contact_id,message,date,ip) VALUES (:id, :message, :date, :ip)";
        $insertn3 = "INSERT INTO gabcms_management (user_id, message, auteur, date, look) VALUES (:userid, :message, :auteur, :date, :look)";

        $params1 = [':pseudo' => $user['username'], ':action' => 'a passé un sujet d\'aide de <b>' . $r['pseudo'] . '</b> (ID : ' . $id . ') de l\'état ' . $etat_modif . ' à ' . $retat_modif . '', ':date' => FullDate('full')];
        $params2 = [':id' => $id, ':message' => '<b>' . $user['username'] . '</b> passe le sujet d\'aide de l\'état ' . $etat_modif . ' à ' . $retat_modif . '', ':date' => FullDate('full') . ' :', ':ip' => $user['ip_current']];
        $params3 = [':userid' => $assoc['id'], ':message' => 'Je viens de passer ton sujet d\'aide de l\'état "' . $etat_modif . '" à "' . $retat_modif . '", pour plus d\'infos, <a href="' . $url . '/service_client/tickets">cliques ici</a> ! (Ticket #' . $id . ')', ':auteur' => $user['username'], ':date' => FullDate('full'), ':look' => $user['look']];

        $affichage = "<div id=\"purse-redeem-result\"> 
    <div class=\"redeem-error\"> 
        <div class=\"rounded rounded-green\"> 
            La demande d'aide a été classé dans la catégorie " . $retat_modif . ".
        </div> 
    </div> 
</div>";

        $bdd->beginTransaction();

        try {
            $bdd->prepare($insertn1)->execute($params1);
            $bdd->prepare($insertn2)->execute($params2);
            $bdd->prepare($insertn3)->execute($params3);
            $bdd->query("UPDATE gabcms_contact SET resul='" . $etat . "', resul_par='" . $user['username'] . "' WHERE id = '" . $id . "'");
            $bdd->commit();
        } catch (Exception $e) {
            $bdd->rollback();
            $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
                Une erreur est survenue.
            </div> 
        </div> 
    </div>";
        }
    } else {
        $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
               Une erreur est survenue.
            </div> 
        </div> 
</div>";
    }
}

if (isset($_POST['message'])) {
    $message = Secu($_POST['message']);
    if (!empty($message) && !empty($id)) {
        $userMsg = '<b>Message de ' . $user['username'] . ' (CTA) :</b> ' . $message;
        $time = FullDate('full');
        $staffLogMsg = "a émis un commentaire sur une demande d'aide de <b>{$r['pseudo']}</b> (ID : $id)";
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo, action, date) VALUES (:pseudo, :action, :date)");
        $insertn1->execute([':pseudo' => $user['username'], ':action' => $staffLogMsg, ':date' => $time]);
        $insertn2 = $bdd->prepare("INSERT INTO gabcms_contact_info (contact_id, message, date, ip) VALUES (:id, :message, :date, :ip)");
        $insertn2->execute([':id' => $id, ':message' => $userMsg, ':date' => $time . ' :', ':ip' => $user['ip_current']]);
        $insertn3 = $bdd->prepare("INSERT INTO gabcms_management (user_id, message, auteur, date, look) VALUES (:userid, :message, :auteur, :date, :look)");
        $msg = "Je viens d'émettre un commentaire sur ton sujet d'aide, pour plus d'infos, <a href='$url/service_client/tickets'>cliques ici</a> ! (Ticket #$id)";
        $insertn3->execute([':userid' => $assoc['id'], ':message' => $msg, ':auteur' => $user['username'], ':date' => $time, ':look' => $user['look']]);
        $bdd->query("UPDATE gabcms_contact SET resul_par='{$user['username']}' WHERE id = $id");
        $affichagee = "<div id=\"purse-redeem-result\"><div class=\"redeem-error\"><div class=\"rounded rounded-green\">Un commentaire a été émis avec succès</div></div></div>";
    } else {
        $affichagee = "<div id=\"purse-redeem-result\"><div class=\"redeem-error\"><div class=\"rounded rounded-red\">Une erreur est survenue.</div></div></div>";
    }
}


if (isset($_POST['sujet'])) {
    $sujet = Secu($_POST['sujet']);
    $infr = $bdd->query("SELECT * FROM gabcms_contact WHERE id = '" . $id . "'");
    $r = $infr->fetch();
    if ($sujet != "" && $id != "") {
        $user_message = '<b>' . $user['username'] . ' (CTA)</b> a modifié le sujet du ticket <b>' . addslashes($sujet) . '</b> (auparavant : <b>' . addslashes($r['sujet']) . '</b>)';

        $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)")
            ->execute([
                ':pseudo' => $user['username'],
                ':action' => 'a modifié le sujet d\'un ticket de <b>' . $r['pseudo'] . '</b> (ID : ' . $id . ')',
                ':date' => FullDate('full')
            ]);

        $bdd->prepare("INSERT INTO gabcms_contact_info (contact_id,message,date,ip) VALUES (:id, :message, :date, :ip)")
            ->execute([
                ':id' => $r['id'],
                ':message' => $user_message,
                ':date' => FullDate('full') . ' :',
                ':ip' => $user['ip_current']
            ]);

        $bdd->prepare("INSERT INTO gabcms_management (user_id, message, auteur, date, look) VALUES (:userid, :message, :auteur, :date, :look)")
            ->execute([
                ':userid' => $assoc['id'],
                ':message' => 'Je viens de modifié le sujet de ton sujet d\'aide, pour plus d\'infos, <a href="' . $url . '/service_client/tickets">cliques ici</a> ! (Ticket #' . $id . ')',
                ':auteur' => $user['username'],
                ':date' => FullDate('full'),
                ':look' => $user['look']
            ]);

        $bdd->query("UPDATE gabcms_contact SET sujet = '" . addslashes($sujet) . "' WHERE id = '" . $id . "'");

        $affichageee = "<div id=\"purse-redeem-result\"> 
            <div class=\"redeem-error\"> 
                <div class=\"rounded rounded-green\"> 
                  Le sujet a été modifié avec succès !
                </div> 
            </div> 
        </div>";
    } else {
        $affichageee = "<div id=\"purse-redeem-result\"> 
            <div class=\"redeem-error\"> 
                <div class=\"rounded rounded-red\"> 
                   Une erreur est survenue.
                </div> 
            </div> 
        </div>";
    }
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
    <script src="<?PHP echo $imagepath; ?>static/js/libs2.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/visual.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/libs.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/common.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>js/tooltip.js" type="text/javascript"></script>
    <style>
        #raison {
            background-color: #cecece;
            -webkit-box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            box-shadow: 0 1px 0 #fff, 0 2px 3px rgba(0, 0, 0, 0.5) inset;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            padding: 7px;
            text-shadow: rgba(255, 255, 255, 0.5) 0 1px 0;
        }

        #ticket {
            background-color: #FFFFFF;
            -webkit-box-shadow: 0 0 20px rgba(176, 196, 222, 0.5);
            box-shadow: 0 1px 0 #fff, 0 2px 3px rgba(176, 196, 222, 0.5) inset;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            padding: 7px;
            text-shadow: rgba(255, 255, 255, 0.5) 0 1px 0;
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
    <script language="javascript" type="text/javascript">
        function insert_texte(texte) {
            var ou = document.getElementsByName("message")[0];
            var phrase = texte + " ";
            ou.value += phrase;
            ou.focus();
        }
    </script>


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
                    <div class="cbb clearfix green">
                        <h2 class="title">Informations</h2>
                        <div class="box-content">
                            Salut <b><?php echo $username; ?></b>,<br />
                            Tu es sur le point d'effectuer une action sur une demande d'aide émise depuis le service client du site.<br /><br />
                            <a href="<?PHP echo $url; ?>/managements/sc_index">Revenir au dépôt</a>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    if (!$(document.body).hasClassName('process-template')) {
                        Rounder.init();
                    }
                </script>
                <div class="habblet-container">
                    <div class="cbb clearfix blue">
                        <h2 class="title">Action</h2>
                        <div class="box-content">
                            <form name='editor' method='post' action="#">
                                <?PHP
                                $retour_messages = $bdd->query('SELECT * FROM gabcms_contact WHERE id = ' . $id . '');
                                $t = $retour_messages->fetch();
                                ?>

                                <select name="etat" id="pays">
                                    <option value="0" <?php if (isset($t['resul']) && $t['resul'] == "0") echo 'selected="selected"'; ?>>Signalé</option>
                                    <option value="1" <?php if (isset($t['resul']) && $t['resul'] == "1") echo 'selected="selected"'; ?>>En étude</option>
                                    <option value="2" <?php if (isset($t['resul']) && $t['resul'] == "2") echo 'selected="selected"'; ?>>Correction à faire</option>
                                    <option value="3" <?php if (isset($t['resul']) && $t['resul'] == "3") echo 'selected="selected"'; ?>>Attente réponse du joueur</option>
                                    <option value="5" <?php if (isset($t['resul']) && $t['resul'] == "5") echo 'selected="selected"'; ?>>En test</option>
                                    <option value="6" <?php if (isset($t['resul']) && $t['resul'] == "6") echo 'selected="selected"'; ?>>Fermé - Résolu</option>
                                    <option value="7" <?php if (isset($t['resul']) && $t['resul'] == "7") echo 'selected="selected"'; ?>>Fermé - déjà signalé/résolu</option>
                                    <option value="8" <?php if (isset($t['resul']) && $t['resul'] == "8") echo 'selected="selected"'; ?>>Fermé - sans suite</option>
                                </select>
                                <input type='submit' name='submit' value='Exécuter' class='submit'>
                            </form><?PHP if (isset($affichage)) {
                                        echo "<br/>" . $affichage . "";
                                    } ?>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    if (!$(document.body).hasClassName('process-template')) {
                        Rounder.init();
                    }
                </script>
                <div class="habblet-container">
                    <div class="cbb clearfix red">
                        <h2 class="title">Commentaire</h2>
                        <div class="box-content">
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
                            <form name="editor" method="post" action="#">
                                <td width="80%" class="tbl"><input type="text" name="message" value="" placeholder="Tape ton message.." class="text" style="width: 240px"><br /></td>
                                <input type="submit" name="submit" value="Commenter" class="submit">
                            </form><?PHP if (isset($affichagee)) {
                                        echo "<br/>" . $affichagee . "";
                                    } ?>
                        </div>
                    </div>
                </div>

                <div class="habblet-container">
                    <div class="cbb clearfix orange">
                        <h2 class="title">Modifie le sujet</h2>
                        <div class="box-content">
                            <form name="editor" method="post" action="#">
                                <td width="80%" class="tbl"><input type="text" name="sujet" value="<?PHP echo $r['sujet'] ?>" class="text" style="width: 240px"><br /></td>
                                <input type="submit" name="submit" value="Modifier" class="submit">
                            </form><?PHP if (isset($affichageee)) {
                                        echo "<br/>" . $affichageee . "";
                                    } ?>
                        </div>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                if (!$(document.body).hasClassName('process-template')) {
                    Rounder.init();
                }
            </script>
            <div id="column1" class="column">
                <div class="habblet-container">
                    <div class="cbb clearfix brown">
                        <h2 class="title">Ticket #<?PHP echo $r['id']; ?></h2>
                        <div class="box-content">
                            <?PHP
                            $statuses = array(
                                0 => "<span style=\"color:#FF4500\"><b>Signalé</b></span>",
                                1 => "<span style=\"color:#4B0082\"><b>En étude</b></span>",
                                2 => "<span style=\"color:#FF0000\"><b>Correction à faire</b></span>",
                                3 => "<span style=\"color:#0000FF\"><b>Attente réponse du joueur</b></span>",
                                4 => "<span style=\"color:#8B4513\"><b>Réponse donnée par le joueur</b></span>",
                                5 => "<span style=\"color:#2E8B57\"><b>En test</b></span>",
                                6 => "<span style=\"color:#008000\"><b>Fermé - Résolu</b></span>",
                                7 => "<span style=\"color:#8bda20\"><b>Fermé - déjà signalé/résolu</b></span>",
                                8 => "<span style=\"color:#DAA520\"><b>Fermé - sans suite</b></span>"
                            );
                            $modif = $statuses[$t['resul']] ?? '';
                            ?>
                            <table width="100%">
                                <tbody>
                                    <tr>
                                        <td valign="top">Pseudo du demandeur : <b><?PHP echo Secu($t['pseudo']); ?></b> - <a href="<?PHP echo $url; ?>/info?name=<?PHP echo Secu($t['pseudo']); ?>" target="_blank">Aller sur son profil &raquo;</a><br />
                                            Sujet : <b><?PHP echo stripslashes($t['sujet']); ?></b>
                                            <br />Date : <b><?PHP echo Secu($t['date']); ?></b>
                                            <br />Catégorie : <b><?PHP echo Secu($t['categorie']); ?></b><br />
                                            <div id="ticket"><?PHP echo smileyforum(stripslashes($t['texte'])); ?></div><br />
                                            Historique :<br />
                                            <div id="raison"><?PHP $infe = $bdd->query("SELECT * FROM gabcms_contact_info WHERE contact_id = '" . $id . "'");
                                                                if ($infe->rowCount() == 0) {
                                                                    echo "<i>Aucun historique, en attente d'affectation à un opérateur..</i>";
                                                                }
                                                                while ($rt = $infe->fetch()) { ?><span style="color:#008000;"><?PHP echo Secu($rt['date']); ?></span> <?PHP echo smileyforum($rt['message']) ?><br /><?PHP } ?></div>
                                            <br /><?PHP echo $modif; ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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