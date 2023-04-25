<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("./config.php");
$pagename = "Acheter des badges";
$pageid = "badgeshop";

if (!isset($_SESSION['username'])) {
    Redirect("" . $url . "/index");
}
if (isset($_GET['do'])) {
    $do = Secu($_GET['do']);

    if ($do == "buy") {
        if (isset($_POST['badge'])) {
            $code_badge = Secu($_POST['badge']);
            
            $selectcode = $bdd->query("SELECT * FROM gabcms_shopbadge WHERE badge_id = '" . $code_badge . "'");
            $codet = $selectcode->fetch();

            $havebadge = $bdd->query("SELECT * FROM users_badges WHERE user_id = " . $user['id'] . " AND badge_code = '" . $code_badge . "'");
            $have = $havebadge->fetch();

            if ($have == false) {

                if ($user['jetons'] >= $codet['prix'] && $code_badge == $codet['badge_id']) {
                    if ($code_badge == "ADM" || $code_badge == "HBA" || $code_badge == "EXH" || $code_badge == "NWB" || $code_badge == "HS1" || $code_badge == "XXX" || $code_badge == "Z0" || $codet['stock'] == "0") {
                        $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
              Ce badge ne peut être acheté.
            </div> 
        </div> 
</div>";
                    } else {
                        $bdd->query("UPDATE gabcms_shopbadge SET stock = stock - 1 WHERE badge_id = '" . $codet['badge_id'] . "'");
                        $bdd->query("UPDATE users SET jetons = jetons - " . $codet['prix'] . " WHERE username = '" . $user['username'] . "'");
                        $insertn2 = $bdd->prepare("INSERT INTO users_badges (user_id,slot_id,badge_code) VALUES (:userid, :slot, :badge)");
                        $insertn2->bindValue(':userid', $user['id']);
                        $insertn2->bindValue(':slot', '0');
                        $insertn2->bindValue(':badge', $codet['badge_id']);
                        $insertn2->execute();
                        $insertn1 = $bdd->prepare("INSERT INTO gabcms_transaction (user_id, produit, prix, gain, date) VALUES (:userid, :produit, :prix, :gain, :date)");
                        $insertn1->bindValue(':userid', $user['id']);
                        $insertn1->bindValue(':produit', 'Achat badge (' . $codet['badge_id'] . ')');
                        $insertn1->bindValue(':prix', $codet['prix']);
                        $insertn1->bindValue(':gain', '-');
                        $insertn1->bindValue(':date', FullDate('full'));
                        $insertn1->execute();
                        $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-green\"> 
              Bravo! Tu viens d'acheter le badge pour seulement <b>" . $codet['prix'] . " jetons</b>!
            </div> 
        </div> 
</div>";
                    }
                } else {
                    $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
               Tu n'as pas assez de jetons pour acheter ce badge!
            </div> 
        </div> 
</div>";
                }
            } else {
                $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
              Vous avez déjà ce badge.
            </div> 
        </div> 
</div>";
            }
        }
    } else {
        $affichage = "<div id=\"purse-redeem-result\"> 
<div class=\"redeem-error\"> 
    <div class=\"rounded rounded-red\"> 
      Le badge n'est pas en vente.
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
        if (typeof HabboClient == "undefined") {
            HabboClient.windowName = "uberClientWnd";
        }
    </script>



    <link rel="shortcut icon" href="<?PHP echo $imagepath; ?>favicon.ico" type="image/vnd.microsoft.icon" />
    <script src="<?PHP echo $imagepath; ?>static/js/libs2.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/visual.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/libs.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/common.js" type="text/javascript"></script>

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



<body id="home" class=" ">
    <div id="overlay"></div>
    <!-- MENU -->
    <?PHP include("./template/header.php"); ?>
    <!-- FIN MENU -->
    <div id='container'>
        <div id='content'>
            <div id='column1' class='column'>
                <div class="habblet-container ">
                    <div class="cbb clearfix blue">
                        <h2 class="title">Badges en vente
                        </h2>
                        <div class="box-content">
                            <center>Merci de <b>vérifier</b> que <u>tu n'as pas déjà le badge</u> avant de l'acheter, aucun remboursement ne sera effectué en cas d'erreur.</center>
                            <script src="<?PHP echo $imagepath; ?>static/js/credits.js" type="text/javascript"></script>
                            <p class='credits-countries-select'>
                            <form name="achat_badge" action="?do=buy" method="post">
                                <center><input type="image" src="<?PHP echo $imagepath; ?>v2/images/valider.png"></center>
                                </p>
                                <center>
                                    <ul id="credits-methods">
                                        <li id="credits-type-promo">
                                            <tbody>
                                                <?php
                                                $sql = $bdd->query("SELECT * FROM gabcms_shopbadge WHERE stock != '0' ORDER BY stock ASC");
                                                if ($sql->rowCount() == 0) {
                                                    echo "<i><center>Aucun badge est en vente</center></i>";
                                                }
                                                if ($sql->rowCount() >= 1) {
                                                ?>
                                                    <table>
                                                        <tbody>
                                                            <tr class="haut">
                                                                <td class="haut">Image</td>
                                                                <td class="haut">Nom</td>
                                                                <td class="haut">Stock</td>
                                                                <td class="haut">Prix</td>
                                                                <td class="haut">Action</td>
                                                            </tr>
                                                        <?PHP }
                                                    while ($n = $sql->fetch(PDO::FETCH_ASSOC)) {

                                                        if ($n['stock'] <= "3") {
                                                            $modif = "#FF0000";
                                                        }
                                                        if ($n['stock'] > "3" && $n['stock'] < "5") {
                                                            $modif = "#FF4500";
                                                        }
                                                        if ($n['stock'] >= "5" && $n['stock'] < "10") {
                                                            $modif = "#FFA500";
                                                        }
                                                        if ($n['stock'] >= "10" && $n['stock'] < "15") {
                                                            $modif = "#FFCC00";
                                                        }
                                                        if ($n['stock'] >= "15") {
                                                            $modif = "#008000";
                                                        }
                                                        ?>
                                                            <tr class="bas">
                                                                <td class="bas"><img src="<?PHP echo $swf_badge; ?><?php echo Secu($n['badge_id']); ?>.gif"></td>
                                                                <td class="bas"><?PHP echo Secu($n['nom_badge']) ?></td>
                                                                <td class="bas"><span style="color:<?PHP echo $modif; ?>;"><?PHP echo Secu($n['stock']); ?></span></td>
                                                                <td class="bas"><?PHP echo Secu($n['prix']); ?></td>
                                                                <td class="bas"><input name="badge" value="<?php echo Secu($n['badge_id']); ?>" type="radio"></td>
                                                            </tr>
                                                        <?PHP } ?>
                                                        </tbody>
                                                    </table>
                                </center>
                            </form>
                        </div>
                    </div>
                </div>
                </li>
                </ul>
            </div>
            <div id="column2" class="column">
                <div class="habblet-container">

                    <div class="cbb clearfix green ">
                        <h2 class='title'>Votre porte monnaie
                        </h2>
                        <div id="purse-habblet">
                            <ul>
                                <li class="even icon-purse-jetons">
                                    <div>Vous avez actuellement:</div>
                                    <span class="purse-balance-amount"><?PHP echo $user['jetons']; ?> Jetons</span>
                                </li>
                                <li class="odd">
                                    <div class="box-content">
                                        Tu as un code promo de jetons ? <a href="<?PHP echo $url; ?>/code_promo">Clique ici pour l'utiliser</a>
                                        <?PHP if (isset($affichage)) {
                                            echo "<br/>" . $affichage . "";
                                        } ?>
                                    </div>
                                </li>
                            </ul>
                            </ul>
                        </div>
                    </div>
                    <script type="text/javascript">
                        new PurseHabblet();
                    </script>
                </div>
                <script type="text/javascript">
                    if (!$(document.body).hasClassName('process-template')) {
                        Rounder.init();
                    }
                </script>
                <script type='text/javascript'>
                    if (!$(document.body).hasClassName('process-template')) {
                        Rounder.init();
                    }
                </script>
                <div class="habblet-container ">
                    <div class="cbb clearfix brown">
                        <h2 class="title">Acheter un badge ?</h2>

                        <div class="box-content">

                            <div id='jetons-promo' class='box-content jetons-info'>
                                <div class='credit-info-text clearfix'>
                                    <p><img src="<?PHP echo $imagepath; ?>v2/images/help.png" align="right" />
                                        Pour acheter un badge, il n'y a rien de plus simple! Il suffit d'appuyer sur le bouton rond dans la colonne "Action" puis d'appuyer sur "Valider" en haut de la page.
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--[if lt IE 7]>
<script type="text/javascript">
Pngfix.doPngImageFix();
</script>
<![endif]-->
        <!-- FOOTER -->
        <?PHP include("./template/footer.php"); ?>
        <!-- FIN FOOTER -->


        <div style="clear: both;"></div>



        <script type="text/javascript">
            HabboView.run();
        </script>


</body>

</html>