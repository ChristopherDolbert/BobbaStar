<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         GabCMS - Site Web et Content Management System                 #|
#|         Copyright © 2013 Gabodd Tout droits réservés.                  #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");
$pagename = "Forum &raquo; Topics";
$pageid = "forum";

if (!isset($_SESSION['username'])) {
    Redirect("" . $url . "/index");
}

$id = Secu($_GET['id']);
if (isset($_GET['topic'])) {
    $topic = Secu($_GET['topic']);
}
if (isset($_GET['do'])) {
    $do = Secu($_GET['do']);
}
$captcha = rand(0, 9999999);
if (isset($_GET['epingle'])) {
    $epingle = Secu($_GET['epingle']);
}
if (isset($_GET['fermer'])) {
    $fermer = Secu($_GET['fermer']);
}
if (isset($_GET['epingle'])) {
    if ($epingle == "1") {
        $sql = $bdd->query("SELECT * FROM gabcms_forum_topic WHERE id = '" . $topic . "'");
        $n = $sql->fetch(PDO::FETCH_ASSOC);
        $sqla = $bdd->query("SELECT * FROM users WHERE id = '" . $n['user_id'] . "'");
        $assoc = $sqla->fetch(PDO::FETCH_ASSOC);
        if ($epingle == "1" && $n['epingle'] == "0") {
            if ($user['rank'] >= '5') {
                $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo,:texte,:date)");
                $insertn1->bindValue(':pseudo', $user['username']);
                $insertn1->bindValue(':texte', 'a épinglé un topic de <b>' . $assoc['username'] . '</b> (' . addslashes($n['titre']) . ')');
                $insertn1->bindValue(':date', FullDate('full'));
                $insertn1->execute();
                $bdd->query("UPDATE gabcms_forum_topic SET epingle = '1' WHERE id = '" . $topic . "'");
                $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-green\"> 
              Le sujet a bien été épinglé
            </div> 
        </div> 
</div>";
            } else {
                $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
               Tu n'es pas administrateur pour épingler le sujet.
            </div> 
        </div> 
</div>";
            }
        } else {
            $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
               Tu ne peux pas épingler un sujet déjà épinglé.
            </div> 
        </div> 
</div>";
        }
    }
}
if (isset($_GET['epingle'])) {
    if ($epingle == "0") {
        $sql = $bdd->query("SELECT * FROM gabcms_forum_topic WHERE id = '" . $topic . "'");
        $n = $sql->fetch(PDO::FETCH_ASSOC);
        $sqla = $bdd->query("SELECT * FROM users WHERE id = '" . $n['user_id'] . "'");
        $assoc = $sqla->fetch(PDO::FETCH_ASSOC);
        if ($epingle == "0" && $n['epingle'] == "1") {
            if ($user['rank'] >= '5') {
                $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo,:texte,:date)");
                $insertn1->bindValue(':pseudo', $user['username']);
                $insertn1->bindValue(':texte', 'a désépinglé un topic de <b>' . $assoc['username'] . '</b> (' . addslashes($n['titre']) . ')');
                $insertn1->bindValue(':date', FullDate('full'));
                $insertn1->execute();
                $bdd->query("UPDATE gabcms_forum_topic SET epingle = '0' WHERE id = '" . $topic . "'");
                $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-green\"> 
              Le sujet a bien été désépinglé
            </div> 
        </div> 
</div>";
            } else {
                $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
               Tu n'es pas administrateur pour désépingler le sujet.
            </div> 
        </div> 
</div>";
            }
        } else {
            $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
               Tu ne peux pas désépingler un sujet déjà désépingler.
            </div> 
        </div> 
</div>";
        }
    }
}
if (isset($_GET['fermer'])) {
    if ($fermer != "1") {
        $sql = $bdd->query("SELECT * FROM gabcms_forum_topic WHERE id = '" . $topic . "'");
        $n = $sql->fetch(PDO::FETCH_ASSOC);
        $sqla = $bdd->query("SELECT * FROM users WHERE id = '" . $n['user_id'] . "'");
        $assoc = $sqla->fetch(PDO::FETCH_ASSOC);
        if ($fermer != "1" && $n['etat'] == "1") {
            if ($user['rank'] >= '5') {
                $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo,:texte,:date)");
                $insertn1->bindValue(':pseudo', $user['username']);
                $insertn1->bindValue(':texte', 'a fermé un topic de <b>' . $assoc['username'] . '</b> (' . addslashes($n['titre']) . ')');
                $insertn1->bindValue(':date', FullDate('full'));
                $insertn1->execute();
                $bdd->query("UPDATE gabcms_forum_topic SET etat = '" . $fermer . "' WHERE id = '" . $topic . "'");
                $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-green\"> 
              Le sujet a bien été fermé
            </div> 
        </div> 
</div>";
            } else {
                $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
               Tu n'es pas administrateur pour fermer le sujet.
            </div> 
        </div> 
</div>";
            }
        } else {
            $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
               Tu ne peux pas fermer un sujet déjà fermé.
            </div> 
        </div> 
</div>";
        }
    }
}
if (isset($_GET['fermer'])) {
    if ($fermer == "1") {
        $sql = $bdd->query("SELECT * FROM gabcms_forum_topic WHERE id = '" . $topic . "'");
        $n = $sql->fetch(PDO::FETCH_ASSOC);
        $sqla = $bdd->query("SELECT * FROM users WHERE id = '" . $n['user_id'] . "'");
        $assoc = $sqla->fetch(PDO::FETCH_ASSOC);
        if ($fermer == "1" && $n['etat'] != "1") {
            if ($user['rank'] >= '5') {
                $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo,:texte,:date)");
                $insertn1->bindValue(':pseudo', $user['username']);
                $insertn1->bindValue(':texte', 'a ré-ouvert un topic de <b>' . $assoc['username'] . '</b> (' . addslashes($n['titre']) . ')');
                $insertn1->bindValue(':date', FullDate('full'));
                $insertn1->execute();
                $bdd->query("UPDATE gabcms_forum_topic SET etat = '1' WHERE id = '" . $topic . "'");
                $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-green\"> 
              Le sujet a bien été ré-ouvert
            </div> 
        </div> 
</div>";
            } else {
                $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
               Tu n'es pas administrateur pour ré-ouvrir le sujet.
            </div> 
        </div> 
</div>";
            }
        } else {
            $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
               Tu ne peux pas ré-ouvrir un sujet déjà ré-ouvert.
            </div> 
        </div> 
</div>";
        }
    }
}
if (isset($_GET['do'])) {
    if ($user['id'] != "") {
        if ($do == "post_comment") {
            if (isset($_POST['commentaire'])) {
                $commentaire = addslashes($_POST['commentaire']);
                $captcha_verif = Secu($_POST['captcha_verif']);
                $captcha_code = Secu($_POST['captcha_code']);
                $sql = $bdd->query("SELECT * FROM gabcms_forum_topic WHERE id = '" . $topic . "'");
                $n = $sql->fetch(PDO::FETCH_ASSOC);
                if ($commentaire != "" && $topic != "") {
                    if ($captcha_code == $captcha_verif) {
                        $insertn1 = $bdd->prepare("INSERT INTO gabcms_forum_commentaires (id_topic, user_id, texte, date, ip, etat) VALUES (:topic, :userid, :commentaire, :date, :ip, :etat)");
                        $insertn1->bindValue(':topic', $topic);
                        $insertn1->bindValue(':userid', $user['id']);
                        $insertn1->bindValue(':commentaire', $commentaire);
                        $insertn1->bindValue(':date', time());
                        $insertn1->bindValue(':ip', $user['ip_last']);
                        $insertn1->bindValue(':etat', '1');
                        $insertn1->execute();
                        $com = $bdd->lastInsertId();
                        $bdd->query("UPDATE gabcms_forum_topic SET commentaire = '" . $com . "' WHERE id = '" . $topic . "'");
                        $insertn2 = $bdd->prepare("INSERT INTO gabcms_management (user_id, message, auteur, date, look) VALUES (:userid, :message, :auteur, :date, :look)");
                        $insertn2->bindValue(':userid', $n['user_id']);
                        $insertn2->bindValue(':message', 'Je viens de commenter ton <a href="' . $url . '/forum/topic?id=' . $n['categorie_forum'] . '&topic=' . $n['id'] . '">topic</a>. N\'hésite pas à aller regarder ma réponse.');
                        $insertn2->bindValue(':auteur', $user['username']);
                        $insertn2->bindValue(':date', FullDate('full'));
                        $insertn2->bindValue(':look', $user['look']);
                        $insertn2->execute();
                        $bdd->query("DELETE FROM gabcms_forum_lu WHERE id_topic = '" . $topic . "'");
                        $insertn3 = $bdd->prepare("INSERT INTO gabcms_forum_lu (user_id, id_topic, date) VALUES (:user, :topic, :date)");
                        $insertn3->bindValue(':user', $user['id']);
                        $insertn3->bindValue(':topic', $topic);
                        $insertn3->bindValue(':date', FullDate('full'));
                        $insertn3->execute();
                        $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-green\"> 
              Ton message vient d'être ajouté.
            </div> 
        </div> 
</div>";
                    } else {
                        $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
               Merci de recopier le bon captcha
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
        }
    }
}
$congif = $bdd->query("SELECT * FROM gabcms_config WHERE id = '1'");
$cof = $congif->fetch(PDO::FETCH_ASSOC);
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
    <script src="<?PHP echo $imagepath; ?>static/js/fullcontent.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/style.css" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/buttons.css" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/boxes.css" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/tooltips.css" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/personal.css" type="text/css" />
    <script src="<?PHP echo $imagepath; ?>static/js/habboclub.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/minimail.css" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/myhabbo/control.textarea.css" type="text/css" />
    <script src="<?PHP echo $imagepath; ?>static/js/minimail.js" type="text/javascript"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/37.0.1/classic/ckeditor.js"></script>
    <script language="javascript">
        function newPopup(url, name_page) {
            window.open(url, name_page, config = 'height=300, width=700, toolbar=no, menubar=no, scrollbars=yes, resizable=no, location=no, directories=no, status=no');
        }
    </script>
    <meta name="description" content="<?PHP echo $description; ?>" />
    <meta name="keywords" content="<?PHP echo $keyword; ?>" />
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
body { behavior: url(http://www.habbo.com/js/csshover.htc); }
</style>
<![endif]-->
    <meta name="build" content="<?PHP echo $build; ?> >> <?PHP echo $version; ?>" />
</head>


<div id="tooltip"></div>

<body id="news" class=" ">
    <div id="overlay"></div>
    <!-- MENU -->
    <?PHP include("../template/header.php"); ?>
    <!-- FIN MENU -->
    <div id="container">
        <div id="content" style="position: relative" class="clearfix">
            <div id="column1" class="column">
                <div class="habblet-container ">
                    <div class="cbb clearfix red">

                        <h2 class="title">Menu
                        </h2>
                        <div class="box-content">
                            <a href="<?PHP echo $url; ?>/forum/">Revenir à l'accueil du forum &raquo;</a><br />
                            <a href="<?PHP echo $url; ?>/forum/add_billet?forum=<?PHP echo $id; ?>">Poster un topic dans se forum &raquo;</a><br />
                        </div>
                    </div>
                </div>

                <div class="habblet-container ">
                    <div class="cbb clearfix default ">

                        <h2 class="title">Autres infos
                        </h2>
                        <div id="article-archive">



                            <h2>Les 30 derniers topics</h2>
                            <ul>
                                <?PHP
                                if (isset($_GET['id'])) {
                                    $sql = $bdd->query("SELECT * FROM gabcms_forum_topic WHERE categorie_forum = '" . $id . "' AND epingle = '1' AND etat = '1' ORDER BY commentaire DESC");
                                    while ($news = $sql->fetch()) {
                                        $search = $bdd->query("SELECT * FROM gabcms_forum_lu WHERE id_topic = '" . $news['id'] . "' AND user_id = '" . $user['id'] . "'");
                                        $ok = $search->fetch();
                                        if ($ok['user_id'] != $user['id']) {
                                            $modif = '<img src="' . $url . '/forum/img/message_anime.gif" />';
                                        }
                                        if ($ok['user_id'] == $user['id']) {
                                            $modif = '';
                                        }
                                ?>
                                        <li>
                                            <?php if (isset($_GET['topic']) && $news['id'] == $topic) { ?>
                                                <img src="<?PHP echo $url ?>/forum/img/epingle.png" /> <?PHP echo stripslashes($news['titre']); ?>&nbsp;&raquo; <?PHP echo $modif ?>
                                            <?php
                                            } else {
                                            ?>
                                                <a href="<?PHP echo $url; ?>/forum/topic?id=<?PHP echo Secu($news['categorie_forum']); ?>&topic=<?PHP echo Secu($news['id']); ?>"><img src="<?PHP echo $url ?>/forum/img/epingle.png" /> <?PHP echo stripslashes($news['titre']); ?>&nbsp;&raquo; <?PHP echo $modif; ?></a>
                                        </li>
                                    <?PHP }
                                        }
                                        $sql = $bdd->query("SELECT * FROM gabcms_forum_topic WHERE categorie_forum = '" . $id . "' AND epingle = '1' AND etat >= '2' ORDER BY commentaire DESC");
                                        while ($news = $sql->fetch()) {
                                            $search = $bdd->query("SELECT * FROM gabcms_forum_lu WHERE id_topic = '" . $news['id'] . "' AND user_id = '" . $user['id'] . "'");
                                            $ok = $search->fetch();
                                            if ($ok['user_id'] != $user['id']) {
                                                $modif = '<img src="' . $url . '/forum/img/message_anime.gif" />';
                                            }
                                            if ($ok['user_id'] == $user['id']) {
                                                $modif = '';
                                            }
                                    ?>
                                    <li>
                                        <?php if (isset($_GET['topic']) && $news['id'] == $topic) { ?>
                                            <img src="<?PHP echo $url; ?>/forum/img/epingle.png" /> <img src="<?PHP echo $url; ?>/forum/img/fermer.png" /> <?PHP echo stripslashes($news['titre']); ?>&nbsp;&raquo; <?PHP echo $modif; ?>
                                        <?php
                                            } else {
                                        ?>
                                            <a href="<?PHP echo $url; ?>/forum/topic?id=<?PHP echo Secu($news['categorie_forum']); ?>&topic=<?PHP echo Secu($news['id']); ?>"><img src="<?PHP echo $url ?>/forum/img/epingle.png" /> <img src="<?PHP echo $url; ?>/forum/img/fermer.png" /> <?PHP echo stripslashes($news['titre']); ?>&nbsp;&raquo; <?PHP echo $modif; ?></a>
                                    </li>
                                <?PHP } ?>
                            <?PHP } ?>
                            <?PHP
                                    $sql = $bdd->query("SELECT * FROM gabcms_forum_topic WHERE categorie_forum = '" . $id . "' AND etat = '1' AND epingle = '0' ORDER BY commentaire DESC");
                                    while ($news = $sql->fetch()) {
                                        $search = $bdd->query("SELECT * FROM gabcms_forum_lu WHERE id_topic = '" . $news['id'] . "' AND user_id = '" . $user['id'] . "'");
                                        $ok = $search->fetch();
                                        if ($ok['user_id'] != $user['id']) {
                                            $modif = '<img src="' . $url . '/forum/img/message_anime.gif" />';
                                        }
                                        if ($ok['user_id'] == $user['id']) {
                                            $modif = '';
                                        }
                            ?>
                                <li>
                                    <?php if (isset($_GET['topic']) && $news['id'] == $topic) { ?>
                                        <?PHP echo stripslashes($news['titre']); ?>&nbsp;&raquo; <?PHP echo $modif; ?>
                                    <?php
                                        } else {
                                    ?>
                                        <a href="<?PHP echo $url; ?>/forum/topic?id=<?PHP echo Secu($news['categorie_forum']); ?>&topic=<?PHP echo Secu($news['id']); ?>"> <?PHP echo stripslashes($news['titre']); ?>&nbsp;&raquo; <?PHP echo $modif; ?></a>
                                </li>
                            <?PHP } ?>
                        <?PHP } ?>
                        <?PHP
                                    $sql = $bdd->query("SELECT * FROM gabcms_forum_topic WHERE categorie_forum = '" . $id . "' AND etat != '1' AND epingle = '0' ORDER BY commentaire DESC");
                                    while ($news = $sql->fetch()) {
                                        $search = $bdd->query("SELECT * FROM gabcms_forum_lu WHERE id_topic = '" . $news['id'] . "' AND user_id = '" . $user['id'] . "'");
                                        $ok = $search->fetch();
                                        if ($ok['user_id'] != $user['id']) {
                                            $modif = '<img src="' . $url . '/forum/img/message_anime.gif" />';
                                        }
                                        if ($ok['user_id'] == $user['id']) {
                                            $modif = '';
                                        }
                        ?>
                            <li>
                                <?php if (isset($_GET['topic']) && $news['id'] == $topic) { ?>
                                    <img src="<?PHP echo $url ?>/forum/img/fermer.png" /> <?PHP echo stripslashes($news['titre']); ?>&nbsp;&raquo; <?PHP echo $modif; ?>
                                <?php
                                        } else {
                                ?>
                                    <a href="<?PHP echo $url; ?>/forum/topic?id=<?PHP echo Secu($news['categorie_forum']); ?>&topic=<?PHP echo Secu($news['id']); ?>"><img src="<?PHP echo $url; ?>/forum/img/fermer.png" /> <?PHP echo stripslashes($news['titre']); ?>&nbsp;&raquo;</a> <?PHP echo $modif; ?>
                            </li>
                <?PHP }
                                    }
                                } ?>

                            </ul>
                        </div>


                    </div>
                </div>
                <script type="text/javascript">
                    if (!$(document.body).hasClassName('process-template')) {
                        Rounder.init();
                    }
                </script>
                <div class="habblet-container">
                    <div class="cbb clearfix green">
                        <h2 class="title">Les smileys</h2>
                        <div class="box-content">
                            Pour voir le code qui affiche le smiley, il suffit de passer la souris sur le smiley en question<br /><br />
                            <img src="<?PHP echo $imagepath; ?>smileys/clindoeil.gif" alt=";)" title=";)" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
                            <img src="<?PHP echo $imagepath; ?>smileys/embarrase.gif" alt=":$" title=":$" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
                            <img src="<?PHP echo $imagepath; ?>smileys/etonne.gif" alt=":o" title=":o" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
                            <img src="<?PHP echo $imagepath; ?>smileys/happy.gif" alt=":)" title=":)" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
                            <img src="<?PHP echo $imagepath; ?>smileys/icon_silent.png" alt=":x" title=":x" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
                            <img src="<?PHP echo $imagepath; ?>smileys/langue.gif" alt=":p" title=":p" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
                            <img src="<?PHP echo $imagepath; ?>smileys/sad.gif" alt=":'(" title=":'(" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
                            <img src="<?PHP echo $imagepath; ?>smileys/veryhappy.gif" alt=":D" title=":D" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
                            <img src="<?PHP echo $imagepath; ?>smileys/jap.png" alt=":jap:" title=":jap:" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
                            <img src="<?PHP echo $imagepath; ?>smileys/cool.gif" alt="8)" title="8)" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
                            <img src="<?PHP echo $imagepath; ?>smileys/rire.gif" alt=":rire:" title=":rire:" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
                            <img src="<?PHP echo $imagepath; ?>smileys/icon_evil.gif" alt=":evil:" title=":evil:" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
                            <img src="<?PHP echo $imagepath; ?>smileys/icon_twisted.gif" alt=":twisted:" title=":twisted:" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
                            <img src="<?PHP echo $imagepath; ?>smileys/roll.gif" alt=":rool:" title=":rool:" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
                            <img src="<?PHP echo $imagepath; ?>smileys/neutre.gif" alt=":|" title=":|" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
                            <img src="<?PHP echo $imagepath; ?>smileys/suspect.gif" alt=":suspect:" title=":suspect:" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
                            <img src="<?PHP echo $imagepath; ?>smileys/no.gif" alt=":no:" title=":no:" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
                            <img src="<?PHP echo $imagepath; ?>smileys/coeur.gif" alt=":coeur:" title=":coeur:" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
                            <img src="<?PHP echo $imagepath; ?>smileys/hap.gif" alt=":hap:" title=":hap:" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
                            <img src="<?PHP echo $imagepath; ?>smileys/bave.gif" alt=":bave:" title=":bave:" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
                            <img src="<?PHP echo $imagepath; ?>smileys/areuh.gif" alt=":areuh:" title=":areuh:" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
                            <img src="<?PHP echo $imagepath; ?>smileys/bandit.gif" alt=":bandit:" title=":bandit:" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
                            <img src="<?PHP echo $imagepath; ?>smileys/help.gif" alt=":help:" title=":help:" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
                            <img src="<?PHP echo $imagepath; ?>smileys/buzz.gif" alt=":buzz:" title=":buzz:" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
                            <img src="<?PHP echo $imagepath; ?>smileys/contrat.gif" alt=":contrat:" title=":contrat:" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
                            <img src="<?PHP echo $imagepath; ?>smileys/pour.gif" alt=":favo:" title=":favo:" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
                            <img src="<?PHP echo $imagepath; ?>smileys/contre.gif" alt=":contre:" title=":contre:" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
                            <?PHP if (isset($affichage)) {
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

            </div>
            <div id="column2" class="column">

                <div class="habblet-container ">
                    <div class="cbb clearfix notitle ">
                        <?PHP
                        if (isset($topic)) {
                            $sql = $bdd->query("SELECT * FROM gabcms_forum_topic WHERE id = '" . $topic . "'");
                            $row = $sql->rowCount();
                            $n = $sql->fetch(PDO::FETCH_ASSOC);
                            if (empty($topic)) { ?>

                                <div id="article-wrapper">
                                    <h2>Aucun topic</h2>
                                    <div class="article-meta"><?PHP echo FullDate('full'); ?>
                                        <a href="<?PHP echo $url ?>/forum/topic">Introuvable</a>
                                    </div>


                                    <p class="summary">Topic introuvable.</p>

                                    <div class="article-body">

                                        Il est probable que le topic que vous recherchez est inéxistant.<br />
                                        Merci d'en sélectionner un autre dans la liste des topics à votre gauche ou en revenant à l'accueil du forum !

                                        <div class="article-author"></div>


                                        <div class="article-images clearfix">
                                        </div>


                                    </div>

                                </div>
                            <?PHP } elseif ($row < 1) {
                            ?>
                                <div id="article-wrapper">
                                    <h2>Aucun topic</h2>
                                    <div class="article-meta"><?PHP echo FullDate('full'); ?>
                                        <a href="<?PHP echo $url ?>/forum/topic">Introuvable</a>
                                    </div>


                                    <p class="summary">Topics introuvable.</p>

                                    <div class="article-body">

                                        Il est probable que le topic que vous recherchez est inéxistant.<br />
                                        Merci d'en sélectionner un autre dans la liste des topics à votre gauche ou en revenant à l'accueil du forum !

                                        <div class="article-author"></div>


                                        <div class="article-images clearfix">
                                        </div>


                                    </div>

                                </div>


                            <?PHP } else {
                                $sql = $bdd->query("SELECT * FROM users WHERE id = '" . $n['user_id'] . "'");
                                $assoc = $sql->fetch(PDO::FETCH_ASSOC);
                                $sqlbravo = $bdd->query("SELECT * FROM users WHERE id = '" . $n['modif_par'] . "'");
                                $assoc2 = $sqlbravo->fetch(PDO::FETCH_ASSOC);
                                $vraie_date = date('d/m/Y à H:i', $n['date']);
                                $insertlu = $bdd->prepare("INSERT INTO gabcms_forum_lu (user_id,id_topic,date) VALUES (:user, :idtopic, :date)");
                                $insertlu->bindValue(':user', $user['id']);
                                $insertlu->bindValue(':idtopic', $n['id']);
                                $insertlu->bindValue(':date', FullDate('full'));
                                $insertlu->execute();
                            ?>
                                <div id="article-wrapper">
                                    <h2><?PHP echo $n['titre']; ?></h2>
                                    <div class="article-meta">
                                        <p class="summary"></p>
                                        <div class="article-body"><?php echo smileyforum(stripslashes($n['texte'])); ?></div><br /><br />
                                        <div id="article_haut"><a href="<?PHP echo $url ?>/info?name=<?PHP echo $assoc['username'] ?>" title="Aller sur son profil &raquo;" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)"><span style="width: 64px; height: 83px; margin-top:-5px; margin-left:-5px; float: left; background: url(http://www.habbo.co.uk/habbo-imaging/avatarimage?figure=<?PHP echo $assoc['look']; ?>&action=wav&direction=2&head_direction=2&gesture=sml&size=big&img_format=gif);"></span></a><span style="color: #000000; font-size: 11px;"><br /><b>Posté par :</b> <?PHP echo $assoc['username']; ?><br /><b>Date :</b> <?PHP echo $vraie_date; ?><br /><br /><?PHP if ($n['modif'] == 1) { ?>Topic modifié par <b><?PHP echo $assoc2['username']; ?></b> le <i><?PHP echo $n['modif_le']; ?></i><?PHP } ?></span></div>
                                        <?PHP if ($user['rank'] >= 5 && $n['user_id'] != $user['id']) { ?><br /><?PHP if ($n['epingle'] == 0) { ?><a href="<?PHP echo $url; ?>/forum/topic?id=<?PHP echo $n['categorie_forum']; ?>&topic=<?PHP echo $n['id']; ?>&epingle=1"><img src="<?PHP echo $url ?>/forum/img/epingle.png" /> Épingler</a><?PHP } elseif ($n['epingle'] == 1) { ?><a href="<?PHP echo $url; ?>/forum/topic?id=<?PHP echo $n['categorie_forum']; ?>&topic=<?PHP echo $n['id']; ?>&epingle=0"><img src="<?PHP echo $url ?>/forum/img/epingle.png" /> Désépingler</a><?PHP } ?> |
                                            <?PHP if ($n['etat'] == 1) { ?><a href="<?PHP echo $url; ?>/forum/topic?id=<?PHP echo $n['categorie_forum']; ?>&topic=<?PHP echo $n['id']; ?>&fermer=2"><img src="<?PHP echo $url ?>/forum/img/fermer.png" /> Fermer le topic sans commentaires</a> | <a href="<?PHP echo $url; ?>/forum/topic?id=<?PHP echo $n['categorie_forum']; ?>&topic=<?PHP echo $n['id']; ?>&fermer=3"><img src="<?PHP echo $url ?>/forum/img/fermer.png" /> Fermer le topic</a><?PHP } elseif ($n['etat'] != 1) { ?><a href="<?PHP echo $url; ?>/forum/topic?id=<?PHP echo $n['categorie_forum']; ?>&topic=<?PHP echo $n['id']; ?>&fermer=1"><img src="<?PHP echo $url ?>/forum/img/fermer.png" /> Ré-ouvrir</a><?PHP } ?> |
                                            <a href="#" onclick="newPopup('<?PHP echo $url ?>/forum/deplace_topic?deplace=<?PHP echo $n['id']; ?>', 'Déplacer un topic');return false;"><img src="<?PHP echo $url ?>/forum/img/deplace.gif" /> Déplacer</a> |
                                            <a href="#" onclick="newPopup('<?PHP echo $url ?>/forum/modif_topic?modif=<?PHP echo $n['id']; ?>', 'Modifier un topic');return false;"><img src="<?PHP echo $url ?>/forum/img/modifier.png" /> Modifier</a> |
                                            <a href="#" onclick="newPopup('<?PHP echo $url ?>/forum/signale_topic?signale=<?PHP echo $n['id']; ?>', 'Signaler un topic');return false;"><img src="<?PHP echo $url ?>/forum/img/save.png" /> Signaler</a>
                                        <?PHP } elseif ($user['rank'] >= 5 && $n['user_id'] == $user['id']) { ?><br /><?PHP if ($n['epingle'] == 0) { ?><a href="<?PHP echo $url; ?>/forum/topic?id=<?PHP echo $n['categorie_forum']; ?>&topic=<?PHP echo $n['id']; ?>&epingle=1"><img src="<?PHP echo $url ?>/forum/img/epingle.png" /> Épingler</a><?PHP } elseif ($n['epingle'] == 1) { ?><a href="<?PHP echo $url; ?>/forum/topic?id=<?PHP echo $n['categorie_forum']; ?>&topic=<?PHP echo $n['id']; ?>&epingle=0"><img src="<?PHP echo $url ?>/forum/img/epingle.png" /> Désépingler</a><?PHP } ?> |
                                            <?PHP if ($n['etat'] == 1) { ?><a href="<?PHP echo $url; ?>/forum/topic?id=<?PHP echo $n['categorie_forum']; ?>&topic=<?PHP echo $n['id']; ?>&fermer=2"><img src="<?PHP echo $url ?>/forum/img/fermer.png" /> Fermer le topic sans commentaires</a> | <a href="<?PHP echo $url; ?>/forum/topic?id=<?PHP echo $n['categorie_forum']; ?>&topic=<?PHP echo $n['id']; ?>&fermer=3"><img src="<?PHP echo $url ?>/forum/img/fermer.png" /> Fermer le topic</a><?PHP } elseif ($n['etat'] != 1) { ?><a href="<?PHP echo $url; ?>/forum/topic?id=<?PHP echo $n['categorie_forum']; ?>&topic=<?PHP echo $n['id']; ?>&fermer=1"><img src="<?PHP echo $url ?>/forum/img/fermer.png" /> Ré-ouvrir</a><?PHP } ?> |
                                            <a href="#" onclick="newPopup('<?PHP echo $url ?>/forum/deplace_topic?deplace=<?PHP echo $n['id']; ?>', 'Déplacer un topic');return false;"><img src="<?PHP echo $url ?>/forum/img/deplace.gif" /> Déplacer</a> |
                                            <a href="#" onclick="newPopup('<?PHP echo $url ?>/forum/modif_topic_author?modif=<?PHP echo $n['id']; ?>', 'Modifier un topic');return false;"><img src="<?PHP echo $url ?>/forum/img/modifier.png" /> Modifier</a> |
                                            <a href="#" onclick="newPopup('<?PHP echo $url ?>/forum/signale_topic?signale=<?PHP echo $n['id']; ?>', 'Signaler un topic');return false;"><img src="<?PHP echo $url ?>/forum/img/save.png" /> Signaler</a>
                                        <?PHP } elseif ($n['user_id'] == $user['id']) { ?><br /><?PHP if ($n['etat'] == '1') { ?><a href="#" onclick="newPopup('<?PHP echo $url ?>/forum/modif_topic_author?modif=<?PHP echo $n['id']; ?>', 'Modifier un topic');return false;"><img src="<?PHP echo $url ?>/forum/img/modifier.png" /> Modifier</a> | <?PHP } ?>
                                            <a href="#" onclick="newPopup('<?PHP echo $url ?>/forum/signale_topic?signale=<?PHP echo $n['id']; ?>', 'Signaler un topic');return false;"><img src="<?PHP echo $url ?>/forum/img/save.png" /> Signaler</a>
                                        <?PHP } elseif ($n['user_id'] != $user['id']) { ?><br />
                                            <a href="#" onclick="newPopup('<?PHP echo $url ?>/forum/signale_topic?signale=<?PHP echo $n['id']; ?>', 'Signaler un topic');return false;"><img src="<?PHP echo $url ?>/forum/img/save.png" /> Signaler</a>
                                        <?PHP } ?>
                                    </div>
                                </div>
                    </div>
                </div>
                <?PHP if ($n['etat'] == 1) { ?><div class="habblet-container">
                        <div class="cbb clearfix green">
                            <h2 class="title">Réactions (<?php $gabcms = "SELECT COUNT(*) AS id FROM gabcms_forum_commentaires WHERE id_topic = '" . $n['id'] . "' AND etat != '2'";
                                                            $query = $bdd->query($gabcms);
                                                            $resul = $query->fetch();
                                                            echo $resul['id'];
                                                            ?>)</h2>
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
                                    $messagesParPage = $cof['nb_com'];
                                    $retour_total = $bdd->query("SELECT COUNT(*) AS total FROM gabcms_forum_commentaires WHERE id_topic = '" . $n['id'] . "' AND etat != '2'");
                                    $donnees_total = $retour_total->fetch(PDO::FETCH_ASSOC);
                                    $total = $donnees_total['total'];
                                    $nombreDePages = ceil($total / $messagesParPage);
                                    if (isset($_GET['page'])) {
                                        $pageActuelle = intval($_GET['page']);

                                        if ($pageActuelle > $nombreDePages) {
                                            $pageActuelle = $nombreDePages;
                                        }
                                    } else {
                                        $pageActuelle = 1;
                                    }
                                    $premiereEntree = ($pageActuelle - 1) * $messagesParPage;
                                    $sql = $bdd->query("SELECT * FROM gabcms_forum_commentaires WHERE id_topic = '" . $n['id'] . "' AND etat != '2' ORDER BY id DESC LIMIT " . $premiereEntree . "," . $messagesParPage . "");
                                    while ($a = $sql->fetch(PDO::FETCH_ASSOC)) {
                                        $spl = $bdd->query("SELECT * FROM users WHERE id = '" . $a['user_id'] . "'");
                                        $as = $spl->fetch(PDO::FETCH_ASSOC);
                                        if ($as['rank'] == 1) {
                                            $modifier_r = "#FF8C00";
                                        }
                                        if ($as['rank'] == 2) {
                                            $modifier_r = "#B22222";
                                        }
                                        if ($as['rank'] == 3) {
                                            $modifier_r = "#32CD32";
                                        }
                                        if ($as['rank'] >= 5 && $as['rank'] <= 8) {
                                            $modifier_r = "red";
                                        }
                                        $vraie_date = date('d/m/Y à H:i', $a['date']);
                                ?>
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td valign="middle" width="10" height="60">
                                                    <a href="<?PHP echo $url; ?>/info?name=<?PHP echo $as['username']; ?>" title="Aller sur son profil &raquo;" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)">
                                                        <div style="width: 64px; height: 65px; margin-bottom:-15px; margin-top:-5px; margin-left: -5px; float: right; background: url(http://www.habbo.co.uk/habbo-imaging/avatarimage?figure=<?PHP echo $as['look']; ?>&action=wav&direction=2&head_direction=2&gesture=sml&size=big&img_format=gif);"></div>
                                                    </a>
                                                </td>
                                                <td valign="top">
                                                    <span style="color:<?PHP echo $modifier_r; ?>;"><b style="font-size: 110%;"><?PHP echo $as['username']; ?></span></b><span style="float: right; color:#000000;"><?PHP echo $vraie_date; ?> <a href="#" onclick="newPopup('<?PHP echo $url; ?>/forum/signale_commentaire?signale=<?PHP echo $a['id']; ?>', 'Signaler un commentaire');return false;">[signaler]</a></span> <br />
                                                    <div id="cta_01"></div>
                                                    <div id="cta_02"><span><?PHP echo stripslashes(smileyforum($a['texte'])); ?></span></div>
                                                    <div id="cta_03"></div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                <?PHP }
                                    echo '<p align="center">Page : ';
                                    for ($i = 1; $i <= $nombreDePages; $i++) {
                                        if ($i == $pageActuelle) {
                                            echo ' [ ' . $i . ' ] ';
                                        } else {
                                            echo ' <a href="' . $url . '/forum/topic?id=' . $n['categorie_forum'] . '&topic=' . $n['id'] . '&page=' . $i . '">' . $i . '</a> ';
                                        }
                                    }
                                    echo '</p>';
                                ?>
                            </div>
                        </div>
                        <div class="cbb clearfix blue">
                            <h2 class="title">Poste ton message</h2>
                            <div class="box-content" id="MontrerMessage">
                                Tu veux réagir au topic de cet utilisateur ? Alors écris un message ci-dessous.<br /><br />
                                <form action="<?PHP echo $url; ?>/forum/topic?id=<?PHP echo $n['categorie_forum']; ?>&topic=<?PHP echo $n['id']; ?>&do=post_comment" method="post">
                                    <textarea name="commentaire" rows="4" id="editor"><?php
                                                                                        if (isset($_POST["commentaire"])) {
                                                                                            echo htmlspecialchars($_POST["commentaire"], ENT_QUOTES);
                                                                                        }
                                                                                        ?></textarea>
                                    <script>
                                        ClassicEditor
                                            .create(document.querySelector('#editor'))
                                            .catch(error => {
                                                console.error(error);
                                            });
                                    </script>
                                    Recopie <b><?PHP echo $captcha ?></b> : <input type="text" name="captcha_code" id="message" class="text" size="7" title="Recopie le captcha exact" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" /><input type="hidden" name="captcha_verif" value="<?PHP echo $captcha ?>" /><br /></td>
                                    <input type="submit" name="post_comment" value="Répondre" />
                                </form>
                            </div>
                        </div>
                    </div>
            <?PHP }
                            } ?>
            <?PHP if ($n['etat'] == 2) { ?><div class="habblet-container">
                    <div class="cbb clearfix red">
                        <h2 class="title">Topic fermé</h2>
                        <div class="box-content">
                            Ce topic a été fermé par un administrateur, donc aucun message peut être posté.
                        </div>
                    </div>
                </div>

            <?PHP } ?>

            <?PHP if ($n['etat'] == 3) { ?><div class="habblet-container">
                    <div class="cbb clearfix red">
                        <h2 class="title">Topic fermé</h2>
                        <div class="box-content">
                            Ce topic a été fermé par un administrateur, donc aucun message peut être posté.
                        </div>
                    </div>
                    <style>
                        table {
                            background-color: #fff;
                            font-size: 11px;
                            padding: 4px;
                            margin-left: -14px;
                            width: 105%;
                        }

                        table:nth-child(2n+1) {
                            background-color: #fffcaf;
                            font-size: 11px;
                            padding: 4px;
                            margin-left: -14px;
                            width: 105%;
                        }
                    </style>
                    <div class="cbb clearfix green">
                        <h2 class="title">Réactions (<?php $gabcms = "SELECT COUNT(*) AS id FROM gabcms_forum_commentaires WHERE id_topic = '" . $n['id'] . "' AND etat != '2'";
                                                        $query = $bdd->query($gabcms);
                                                        $resul = $query->fetch();
                                                        echo $resul['id'];
                                                        ?>)</h2>
                        <div class="box-content">
                            <?php
                                $messagesParPage = $cof['nb_com'];
                                $retour_total = $bdd->query("SELECT COUNT(*) AS total FROM gabcms_forum_commentaires WHERE id_topic = '" . $n['id'] . "' AND etat != '2'");
                                $donnees_total = $retour_total->fetch(PDO::FETCH_ASSOC);
                                $total = $donnees_total['total'];
                                $nombreDePages = ceil($total / $messagesParPage);
                                if (isset($_GET['page'])) {
                                    $pageActuelle = intval($_GET['page']);

                                    if ($pageActuelle > $nombreDePages) {
                                        $pageActuelle = $nombreDePages;
                                    }
                                } else {
                                    $pageActuelle = 1;
                                }
                                $premiereEntree = ($pageActuelle - 1) * $messagesParPage;
                                $sql = $bdd->query("SELECT * FROM gabcms_forum_commentaires WHERE id_topic = '" . $n['id'] . "' AND etat != '2' ORDER BY id DESC LIMIT " . $premiereEntree . "," . $messagesParPage . "");
                                while ($a = $sql->fetch(PDO::FETCH_ASSOC)) {
                                    $spl = $bdd->query("SELECT * FROM users WHERE id = '" . $a['user_id'] . "'");
                                    $as = $spl->fetch(PDO::FETCH_ASSOC);

                                    if ($as['rank'] == 1) {
                                        $modifier_r = "#FF8C00";
                                    }
                                    if ($as['rank'] == 2) {
                                        $modifier_r = "#B22222";
                                    }
                                    if ($as['rank'] == 3) {
                                        $modifier_r = "#32CD32";
                                    }
                                    if ($as['rank'] >= 5 && $as['rank'] <= 8) {
                                        $modifier_r = "red";
                                    }
                                    $vraie_date = date('d/m/Y à H:i', $a['date']);

                                    echo '<table>
            <tbody><tr> 
                    <td valign="middle" width="10" height="60"> 
                    <a href="' . $url . '/info?name=' . $as['username'] . '" title="Aller sur son profil &raquo;" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)"><div style="width: 64px; height: 65px; margin-bottom:-15px; margin-top:-5px; margin-left: -5px; float: right; background: url(http://www.habbo.co.uk/habbo-imaging/avatarimage?figure=' . $as['look'] . '&action=wav&direction=2&head_direction=2&gesture=sml&size=big&img_format=gif);"></div></a>
					</td> 
                    <td valign="top">
                      <span style="color:' . $modifier_r . ';"><b style="font-size: 110%;">' . $as['username'] . '</span></b><span style="float: right; color:#000000;">' . $vraie_date . ' <a href="#" onclick="newPopup(\'' . $url . '/forum/signale_commentaire?signale=' . $a['id'] . '\', \'Signaler un commentaire\');return false;">[signaler]</a></span> <br/>
                       <div id="cta_01"></div><div id="cta_02"><span>' . stripslashes(smileyforum($a['texte'])) . '</span></div><div id="cta_03"></div>
                   </td></tr></tbody> 

</table>';
                                }
                                echo '<p align="center">Page : ';
                                for ($i = 1; $i <= $nombreDePages; $i++) {
                                    if ($i == $pageActuelle) {
                                        echo ' [ ' . $i . ' ] ';
                                    } else {
                                        echo ' <a href="' . $url . '/forum/topic?id=' . $n['categorie_forum'] . '&topic=' . $n['id'] . '&page=' . $i . '">' . $i . '</a> ';
                                    }
                                }
                                echo '</p>';
                            ?>
                        </div>
                    </div>
                </div>

            <?PHP }
                        } else { ?>
            <div id="article-wrapper">
                <h2>Aucun topic</h2>
                <div class="article-meta"><?PHP echo FullDate('full'); ?>
                    <a href="<?PHP echo $url; ?>/articles">Introuvable</a>
                </div>
                <p class="summary">Aucun topic choisi</p>
                <div class="article-body">
                    Merci de sélectionner un topic dans la liste des topics à votre gauche ou sinon retourné à l'accueil du forum.
                    <div class="article-author"><?php echo $owner; ?></div>
                    <div class="article-images clearfix">
                    </div>
                </div>
            </div>
        <?PHP } ?>
            </div>
            <script type="text/javascript">
                if (!$(document.body).hasClassName('process-template')) {
                    Rounder.init();
                }
            </script>


        </div>
    </div>
    <!-- FOOTER -->
    <?PHP include("../template/footer.php"); ?>
    <!-- FIN FOOTER -->
    <script type="text/javascript">
        HabboView.run();
    </script>
</body>

</html>