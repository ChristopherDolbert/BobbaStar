<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include "./config.php";
$pagename = "Articles";
$pageid = "articles";


if (!isset($_SESSION['username'])) {
    Redirect($url . "/index");
}

$sql = $bdd->query("SELECT * FROM gabcms_config WHERE id = '1'");
$cof = $sql->fetch(PDO::FETCH_ASSOC);

if (isset($_GET['id'])) {
    $id = Secu($_GET['id']);

    $sqle = $bdd->prepare("SELECT * FROM gabcms_news WHERE id = :id");
    $sqle->bindValue(':id', $id);
    $sqle->execute();

    $n = $sqle->fetch(PDO::FETCH_ASSOC);

    if (isset($_POST['message'])) {
        $message = Secu($_POST['message']);

        if ($message !== "" && $id !== "") {
            $insertn1 = $bdd->prepare("INSERT INTO gabcms_news_recommande (news_id,message,pseudo,date,ip) VALUES (:news_id, :message, :pseudo, :date, :ip)");
            $insertn1->bindValue(':news_id', $n['id']);
            $insertn1->bindValue(':message', $message);
            $insertn1->bindValue(':pseudo', $_SESSION['username']);
            $insertn1->bindValue(':date', FullDate('full'));
            $insertn1->bindValue(':ip', $_SERVER['REMOTE_ADDR']);
            $insertn1->execute();

            $affichage = "<div id=\"purse-redeem-result\">
        <div class=\"redeem-error\">
            <div class=\"rounded rounded-green\">
              Tu as bien voté pour cet article!
            </div>
        </div>
</div>";
        } else {
            $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\">
            <div class=\"rounded rounded-red\">
               Une erreur est survenue
            </div>
        </div>
</div>";
        }
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
    <script src="https://cdn.ckeditor.com/ckeditor5/37.0.1/classic/ckeditor.js"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/libs.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/common.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>js/tooltip.js" type="text/javascript"></script>
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

<body id="news">
    <div id="tooltip"></div>
    <div id="overlay"></div>
    <!-- MENU -->
    <?PHP include("./template/header.php"); ?>
    <!-- FIN MENU -->

    <div id="container">
        <div id="content" style="position: relative" class="clearfix">
            <div id="column1" class="column">
                <div class="habblet-container ">
                    <div class="cbb clearfix default ">
                        <h2 class="title">Autres infos
                        </h2>
                        <div id="article-archive">
                            <?PHP
                            $aujourdhui = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
                            $fin_aujourdhui = mktime(23, 59, 59, date("m"), date("d"), date("Y"));
                            $hier = mktime(0, 0, 0, date("m"), date("d") - 1, date("Y"));
                            $fin_hier = mktime(23, 59, 59, date("m"), date("d") - 1, date("Y"));
                            $cettesemaine = mktime(0, 0, 0, date("m"), date("d") - 2, date("Y"));
                            $fin_cettesemaine = mktime(23, 59, 59, date("m"), date("d") - 7, date("Y"));
                            $prochainesemaine = mktime(0, 0, 0, date("m"), date("d") - 8, date("Y"));
                            $fin_prochainesemaine = mktime(23, 59, 59, date("m"), date("d") - 14, date("Y"));
                            $cemois = mktime(0, 0, 0, date("m"), date("d") - 15, date("Y"));
                            $fin_cemois = mktime(23, 59, 59, date("m"), 31, date("Y"));
                            $moisdernier = mktime(0, 0, 0, date("m") - 1, 1, date("Y"));
                            $fin_moisdernier = mktime(23, 59, 59, date("m") - 2, 31, date("Y"));
                            $cetteannee = mktime(0, 0, 0, date("m") - 3, 1, date('Y'));
                            $fin_cetteannee = mktime(23, 59, 59, 12, 31, date('Y'));
                            $anneederniere = mktime(0, 0, 0, 1, 1, date('Y') - 1);
                            $fin_anneederniere = mktime(23, 59, 59, 12, 31, date('Y') - 1);
                            $sqla = $bdd->query("SELECT * FROM `gabcms_news` WHERE event = '1' AND date BETWEEN $aujourdhui AND $fin_aujourdhui ORDER BY id DESC LIMIT 0,30");
                            $rowa = $sqla->rowCount();
                            if ($rowa > '0') {
                            ?>
                                <h2>Aujourd'hui</h2>
                                <ul>
                                    <?PHP
                                    while ($newsa = $sqla->fetch()) { ?>
                                        <li>
                                            <?php if (isset($_GET['id']) && $newsa['id'] == $id) {
                                                echo stripslashes($newsa['title']); ?>&nbsp;&raquo;
                                        <?php
                                            } else {
                                        ?>
                                            <a href="<?PHP echo $url; ?>/articles?id=<?PHP echo $newsa['id']; ?>"><?PHP echo stripslashes($newsa['title']); ?>&nbsp;&raquo;</a>
                                        </li>
                            <?PHP }
                                        }
                                    } ?>
                                </ul>
                                <?PHP
                                $sqlz = $bdd->query("SELECT * FROM `gabcms_news` WHERE event = '1' AND date BETWEEN $hier AND $fin_hier ORDER BY id DESC LIMIT 0,30");
                                $rowz = $sqlz->rowCount();
                                if ($rowz > '0') {
                                ?>
                                    <h2>Hier</h2>
                                    <ul>
                                        <?PHP
                                        while ($newsz = $sqlz->fetch()) { ?>
                                            <li>
                                                <?php if (isset($_GET['id']) && $newsz['id'] == $id) {
                                                    echo stripslashes($newsz['title']); ?>&nbsp;&raquo;
                                            <?php
                                                } else {
                                            ?>
                                                <a href="<?PHP echo $url; ?>/articles?id=<?PHP echo $newsz['id']; ?>"><?PHP echo stripslashes($newsz['title']); ?>&nbsp;&raquo;</a>
                                            </li>
                                <?PHP }
                                            }
                                        } ?>
                                    </ul>
                                    <?PHP
                                    $sqle = $bdd->query("SELECT * FROM `gabcms_news` WHERE event = '1' AND date BETWEEN $cettesemaine AND $fin_cettesemaine ORDER BY id DESC LIMIT 0,30");
                                    $rowe = $sqle->rowCount();
                                    if ($rowe > '0') {
                                    ?>
                                        <h2>Cette semaine</h2>
                                        <ul>
                                            <?PHP
                                            while ($newse = $sqle->fetch()) { ?>
                                                <li>
                                                    <?php if (isset($_GET['id']) && $newse['id'] == $id) {
                                                        echo stripslashes($newse['title']); ?>&nbsp;&raquo;
                                                <?php
                                                    } else {
                                                ?>
                                                    <a href="<?PHP echo $url; ?>/articles?id=<?PHP echo $newse['id']; ?>"><?PHP echo stripslashes($newse['title']); ?>&nbsp;&raquo;</a>
                                                </li>
                                    <?PHP }
                                                }
                                            }
                                    ?>
                                        </ul>
                                        <?PHP
                                        $sqlr = $bdd->query("SELECT * FROM `gabcms_news` WHERE event = '1' AND date BETWEEN $prochainesemaine AND $fin_prochainesemaine ORDER BY id DESC LIMIT 0,30");
                                        $rowr = $sqlr->rowCount();
                                        if ($rowr > '0') {
                                        ?>
                                            <h2>Semaine dernière</h2>
                                            <ul>
                                                <?PHP
                                                while ($newsr = $sqlr->fetch()) { ?>
                                                    <li>
                                                        <?php if (isset($_GET['id']) && $newsr['id'] == $id) {
                                                            echo stripslashes($newsr['title']); ?>&nbsp;&raquo;
                                                    <?php
                                                        } else {
                                                    ?>
                                                        <a href="<?PHP echo $url; ?>/articles?id=<?PHP echo $newsr['id']; ?>"><?PHP echo stripslashes($newsr['title']); ?>&nbsp;&raquo;</a>
                                                    </li>
                                        <?PHP }
                                                    }
                                                } ?>
                                            </ul>
                                            <?PHP
                                            $sqlt = $bdd->query("SELECT * FROM `gabcms_news` WHERE event = '1' AND date BETWEEN $cemois AND $fin_cemois ORDER BY id DESC LIMIT 0,30");
                                            $rowt = $sqlt->rowCount();
                                            if ($rowt > '0') {
                                            ?>
                                                <h2>Mois en cours</h2>
                                                <ul>
                                                    <?PHP
                                                    while ($newst = $sqlt->fetch()) { ?>
                                                        <li>
                                                            <?php if (isset($_GET['id']) && $newst['id'] == $id) {
                                                                echo stripslashes($newst['title']); ?>&nbsp;&raquo;
                                                        <?php
                                                            } else {
                                                        ?>
                                                            <a href="<?PHP echo $url; ?>/articles?id=<?PHP echo $newst['id']; ?>"><?PHP echo stripslashes($newst['title']); ?>&nbsp;&raquo;</a>
                                                        </li>
                                            <?PHP }
                                                        }
                                                    } ?>
                                                </ul>
                                                <?PHP
                                                $sqly = $bdd->query("SELECT * FROM `gabcms_news` WHERE event = '1' AND date BETWEEN $moisdernier AND $fin_moisdernier ORDER BY id DESC LIMIT 0,30");
                                                $rowy = $sqly->rowCount();
                                                if ($rowy > '0') {
                                                ?>
                                                    <h2>Mois dernier</h2>
                                                    <ul>
                                                        <?PHP
                                                        while ($newsy = $sqly->fetch()) { ?>
                                                            <li>
                                                                <?php if (isset($_GET['id']) && $newsy['id'] == $id) {
                                                                    echo stripslashes($newsy['title']); ?>&nbsp;&raquo;
                                                            <?php
                                                                } else {
                                                            ?>
                                                                <a href="<?PHP echo $url; ?>/articles?id=<?PHP echo $newsy['id']; ?>"><?PHP echo stripslashes($newsy['title']); ?>&nbsp;&raquo;</a>
                                                            </li>
                                                <?PHP }
                                                            }
                                                        } ?>
                                                    </ul>
                                                    <?PHP
                                                    $sqlu = $bdd->query("SELECT * FROM `gabcms_news` WHERE event = '1' AND date BETWEEN $cetteannee AND $fin_cetteannee ORDER BY id DESC LIMIT 0,30");
                                                    $rowu = $sqlu->rowCount();
                                                    if ($rowu > '0') {
                                                    ?>
                                                        <h2>Année en cours</h2>
                                                        <ul>
                                                            <?PHP
                                                            while ($newsu = $sqlu->fetch()) { ?>
                                                                <li>
                                                                    <?php if (isset($_GET['id']) && $newsu['id'] == $id) {
                                                                        echo stripslashes($newsu['title']); ?>&nbsp;&raquo;
                                                                <?php
                                                                    } else {
                                                                ?>
                                                                    <a href="<?PHP echo $url; ?>/articles?id=<?PHP echo $newsu['id']; ?>"><?PHP echo stripslashes($newsu['title']); ?>&nbsp;&raquo;</a>
                                                                </li>
                                                    <?PHP }
                                                                }
                                                            } ?>
                                                        </ul>
                                                        <?PHP
                                                        $sqli = $bdd->query("SELECT * FROM `gabcms_news` WHERE event = '1' AND date BETWEEN $anneederniere AND $fin_anneederniere ORDER BY id DESC LIMIT 0,30");
                                                        $rowi = $sqli->rowCount();
                                                        if ($rowi > '0') {
                                                        ?>
                                                            <h2>Année dernière</h2>
                                                            <ul>
                                                                <?PHP
                                                                while ($newsi = $sqli->fetch()) { ?>
                                                                    <li>
                                                                        <?php if (isset($_GET['id']) && $newsi['id'] == $id) {
                                                                            echo stripslashes($newsi['title']); ?>&nbsp;&raquo;
                                                                    <?php
                                                                        } else {
                                                                    ?>
                                                                        <a href="<?PHP echo $url; ?>/articles?id=<?PHP echo $newsi['id']; ?>"><?PHP echo stripslashes($newsi['title']); ?>&nbsp;&raquo;</a>
                                                                    </li>
                                                        <?PHP }
                                                                    }
                                                                } ?>
                                                            </ul>
                                                            <?PHP if (isset($affichage)) {
                                                                echo "<br/>" . $affichage . "";
                                                            } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div id="column2" class="column">
                <div class="habblet-container ">
                    <div class="cbb clearfix notitle ">
                        <?PHP
                        if (isset($_GET['id'])) {
                            $id = Secu($_GET['id']);
                            $sql = $bdd->prepare("SELECT * FROM gabcms_news WHERE id = ? LIMIT 1");
                            $sql->execute([$id]);
                            $row = $sql->rowCount();
                            $n = $sql->fetch(PDO::FETCH_ASSOC);
                            if (empty($id)) { ?>
                                <div id="article-wrapper">
                                    <h2>Aucune news</h2>
                                    <div class="article-meta"><?PHP echo FullDate('full'); ?>
                                        <a href="<?PHP echo $url; ?>/articles">Introuvable</a>
                                    </div>
                                    <p class="summary">Aucun article choisi</p>
                                    <div class="article-body">
                                        Merci de sélectionner un article dans la liste des articles à votre gauche.
                                        <div class="article-author"><?php echo $owner; ?></div>
                                        <div class="article-images clearfix">
                                        </div>
                                    </div>
                                </div>
                            <?PHP } elseif ($row < 1) {
                            ?>
                                <div id="article-wrapper">
                                    <h2>Aucune news</h2>
                                    <div class="article-meta"><?PHP echo FullDate('full'); ?>
                                        <a href="<?PHP echo $url; ?>/articles">Introuvable</a>
                                    </div>
                                    <p class="summary">Articles introuvable.</p>
                                    <div class="article-body">
                                        Il est probable que l'article que vous recherchez est inéxistant.<br />
                                        Merci d'en sélectionner un autre dans la liste des articles à votre gauche.


                                        <div class="article-author"><?php echo $owner; ?></div>
                                        <div class="article-images clearfix">
                                        </div>
                                    </div>
                                </div>
                            <?PHP } else { ?>
                                <div id="article-wrapper">
                                    <h2><?PHP echo stripslashes($n['title']); ?></h2>
                                    <div class="article-meta">
                                        <p class="summary"><?PHP echo stripslashes($n['snippet']); ?></p>
                                        <div class="article-body"><?php echo stripslashes($n['body']); ?>
                                            <div class="article-author"><?PHP echo stripslashes($n['sign']); ?></div>
                                            <?PHP
                                            $search = $bdd->prepare("SELECT pseudo FROM gabcms_news_recommande WHERE news_id = ? AND pseudo = ?");
                                            $search->execute([$n['id'], $user['username']]);
                                            $ok = $search->fetch();
                                            $rowCount = $search->rowCount();


                                            if (isset($user['username']) && $rowCount == 0) {
                                                $query = $bdd->prepare("SELECT COUNT(*) AS nb_recommandations FROM gabcms_news_recommande WHERE news_id = ?");
                                                $query->execute([$n['id']]);
                                                $nb_recommandations = $query->fetchColumn();

                                                $query = $bdd->prepare("SELECT pseudo FROM gabcms_news_recommande WHERE news_id = ? AND pseudo = ?");
                                                $query->execute([$n['id'], $user['username']]);
                                                $recommandation_existante = $query->fetch();

                                                $modifier_br = "<br/><br/><br/>";

                                                if (!$recommandation_existante) {
                                                    $modifier_a = "Être le premier!";
                                                    $modifier_r = "<b>" . $nb_recommandations . ($nb_recommandations === 1 ? " utilisateur" : " utilisateurs") . "</b> ont trouvé";
                                                } else {
                                                    $nb_recommandations--;
                                                    $modifier_a = "Moi aussi!";
                                                    $modifier_r = "<b>Vous</b> et <b>" . $nb_recommandations . ($nb_recommandations === 1 ? " autre utilisateur" : " autres utilisateurs") . "</b> avez trouvé";
                                                }

                                                if ($n['modifier'] == '1') {
                                                    $date_modif = date('d/m/Y à H:i', $n['modif_date']);
                                                }

                                                $date_but = date('d/m/Y à H:i', $n['date']);

                                                $query = $bdd->prepare("SELECT COUNT(*) AS nb_inscrit FROM gabcms_news_recommande WHERE news_id = ?");
                                                $query->execute([$n['id']]);
                                                $nb_inscrit = $query->fetch();

                                                if ($nb_inscrit['nb_inscrit'] == 0) {
                                                    $modifier_r = "<b>Aucun utilisateur</b> n'a été trouvé";
                                                } elseif ($nb_inscrit['nb_inscrit'] == 1) {
                                                    $modifier_r = "<b>" . $nb_inscrit['nb_inscrit'] . " utilisateur</b> a été trouvé";
                                                } else {
                                                    $modifier_r = "<b>" . $nb_inscrit['nb_inscrit'] . " utilisateurs</b> ont été trouvés";
                                                }

                                                if ($nb_inscrit['nb_inscrit'] == 0) {
                                                    $modifier_a = "Soyez le premier!";
                                                } else {
                                                    $modifier_a = "Moi aussi!";
                                                }
                                            }

                                            if ($rowCount >= 1) {
                                                $query = $bdd->prepare("SELECT COUNT(*) AS nb_recommandations FROM gabcms_news_recommande WHERE news_id = ?");
                                                $query->execute([$n['id']]);
                                                $nb_recommandations = $query->fetch(PDO::FETCH_ASSOC);

                                                if ($nb_recommandations['nb_recommandations'] == 0) {
                                                    $modifier_r = "<b>Vous êtes le seul</b> à avoir recommandé cette nouvelle";
                                                } elseif ($nb_recommandations['nb_recommandations'] == 1) {
                                                    $modifier_r = "<b>Vous et " . $nb_recommandations['nb_recommandations'] . " autre utilisateur</b> avez recommandé cette nouvelle";
                                                } else {
                                                    $modifier_r = "<b>Vous et " . $nb_recommandations['nb_recommandations'] . " autres utilisateurs</b> avez recommandé cette nouvelle";
                                                }

                                                $modifier_br = "<br/><br/>";
                                            }

                                            if (isset($n['date'])) {
                                                $date_but = date('d/m/Y à H:i', $n['date']);
                                            }
                                            if ($n['modifier'] == '1') {
                                                $date_modif = date('d/m/Y à H:i', $n['modif_date']);
                                            }
                                            ?><br />
                                            <form method="post" action="<?PHP echo $url; ?>/articles.php?id=<?PHP echo $n['id']; ?>#">
                                                <span style="float:right;"><?PHP echo $modifier_r; ?> cet article utile. <?PHP if ($rowCount == 0) { ?><input type="text" value="okok" name="message" maxlength="100" hidden="hidden"> <input type='submit' name='submit' value='<?PHP echo $modifier_a; ?>' class='submit'> <?PHP } ?></span>
                                            </form>
                                        </div><?PHP echo $modifier_br; ?>

                                        <div id="article_haut" style="text-align: left; display: flex; justify-content: left; align-items: center;">
                                            <span style="width: 64px; height: 83px; margin-top:-5px; margin-left:-5px; float: left; background: url(<?php echo $avatarimage; ?><?PHP echo Secu($n['look']); ?>&action=wav&direction=2&head_direction=2&gesture=sml&size=big&img_format=gif);"></span>
                                            <span style="color: #000000; font-size: 11px;"><b>Posté par :</b> <?PHP echo $n['auteur']; ?><br /><b>Date :</b> <?PHP echo Secu($date_but); ?><br /><b>Catégorie :</b> <?PHP echo Secu($n['category_id']); ?><br /><br /><?PHP if ($n['modifier'] == 1) { ?>Article modifié par <b><?PHP echo $n['modif_auteur']; ?></b> le <i><?PHP echo $date_modif; ?></i><?PHP } ?></span>
                                        </div>
                                    </div>
                                </div>
                    </div>
                </div>
            <?PHP }
                        } else { ?>
            <div id="article-wrapper">
                <h2>Aucune news</h2>
                <div class="article-meta"><?PHP echo FullDate('full'); ?>
                    <a href="<?PHP echo $url; ?>/articles">Introuvable</a>
                </div>
                <p class="summary">Aucun article choisi</p>
                <div class="article-body">
                    Merci de sélectionner un article dans la liste des articles à votre gauche.
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
    <?PHP include("./template/footer.php"); ?>
    <!-- FIN FOOTER -->
    </div>
    </div>
    </div>
    </div>
    <script type="text/javascript">
        HabboView.run();
    </script>
</body>

</html>