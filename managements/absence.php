<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");
$pagename = "Les absents";
$pageid = "sta";

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

if (isset($_GET['action'])) {
    $action = Secu($_GET['action']);

    if (is_numeric($action)) {
        $rech = $bdd->query("SELECT * FROM gabcms_absence_staff WHERE id = '" . $action . "' LIMIT 1");
        $r = $rech->fetch();

        if (Secu($r['depuis']) <= Secu($nowtime) && Secu($r['jusqua']) > Secu($nowtime) && Secu($r['etat'] == 1)) {
            $pseudo = $user['username'];
            $actionLog = 'a annulé sa propre absence';
            $affichageMsg = 'Tu viens d\'annuler ton absence avec succès !';

            if ($r['pseudo'] !== $user['username'] && $user['rank'] >= '8') {
                $pseudo = $r['pseudo'];
                $actionLog = 'a annulé l\'absence de <b>' . $r['pseudo'] . '</b>';
                $affichageMsg = 'Tu viens d\'annuler l\'absence de <b>' . $r['pseudo'] . '</b> avec succès !';
            }

            $bdd->query("UPDATE gabcms_absence_staff SET jusqua = '" . $nowtime . "', annule = '1' WHERE id = '" . $action . "'");
            $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $pseudo);
            $insertn1->bindValue(':action', $actionLog);
            $insertn1->bindValue(':date', FullDate('full'));
            $insertn1->execute();
            $affichage = "<div id=\"purse-redeem-result\"> 
                            <div class=\"redeem-error\"> 
                                <div class=\"rounded rounded-green\"> 
                                " . $affichageMsg . "
                                </div> 
                            </div> 
                        </div>";
        } else {
            $affichage = "<div id=\"purse-redeem-result\"> 
                            <div class=\"redeem-error\"> 
                                <div class=\"rounded rounded-red\"> 
                                    L'absence en question est déjà dépassée.
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
                    <div class="cbb clearfix orange">
                        <h2 class="title">Infos</h2>
                        <div class="box-content">
                            Pour signaler ton absence, rends-toi dans l'administration dans <b>AUTRES &raquo; Signaler son absence</b> où tu devras choisir la date de départ et la date de retour ainsi qu'un motif. Elle sera validé ou non par la suite par les fondateurs.
                            <?PHP if (isset($affichage)) {
                                echo "<br/>" . $affichage . "";
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div id="column1" class="column">
                <div class="habblet-container">
                    <div class="cbb clearfix green">
                        <h2 class="title">Remarques</h2>
                        <div class="box-content">
                            Lorsque que tu signales ton absence, celle-ci peut être refusé par le ou les fondateurs. Si elle est validée, et tu reviens plus tôt que prévu, elle peut être annulé.<br /><br />
                            <i>NB : Les fondateurs peuvent annuler n'importe quelle absence, alors que toi, tu ne peux annulé que la tienne.</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="container">
        <div id="content">
            <div id="column11" class="column">
                <div class="habblet-container" id="ok" style="float:left; width: 770px;">
                    <div class="cbb clearfix red">
                        <h2 class="title">Les absences justifiées</h2>
                        <div class="box-content">
                            <table>
                                <tbody>
                                    <tr class="haut">
                                        <td class="haut">Pseudo</td>
                                        <td class="haut">Date de départ</td>
                                        <td class="haut">Date de retour</td>
                                        <td class="haut">Raison</td>
                                        <td class="haut">Etat</td>
                                        <td class="haut">Action</td>
                                    </tr>
                                    <?php
                                    $sql = $bdd->query("SELECT * FROM gabcms_absence_staff WHERE etat < 2 ORDER BY jusqua DESC");
                                    while ($a = $sql->fetch()) {

                                        $date_depuis = date('d/m/Y', Secu($a['depuis']));
                                        $date_jusqua = date('d/m/Y', Secu($a['jusqua']));

                                        if ($a['etat'] == 0) {
                                            $etat2 = '<img src="' . $url . '/managements/img/images/invalide.gif" /><br/><center>En attente de traitement</center>';
                                        }
                                        if ($a['depuis'] > Secu($nowtime) && Secu($a['etat'] == 1) && Secu($a['annule']) == 0) {
                                            $etat2 = '<img src="' . $url . '/managements/img/images/valide.gif" /><br/><center>Acceptée</center>';
                                        }
                                        if ($a['jusqua'] < Secu($nowtime) && Secu($a['etat'] == 1) && Secu($a['annule']) == 0) {
                                            $etat2 = '<img src="' . $url . '/managements/img/images/invalide.gif" /><br/><center>Dépassée</center>';
                                        }
                                        if ($a['depuis'] > Secu($nowtime) && Secu($a['etat'] == 1) && Secu($a['annule']) == 1) {
                                            $etat2 = '<img src="' . $url . '/managements/img/images/invalide.gif" /><br/><center>Annulée</center>';
                                        }
                                        if ($a['jusqua'] < Secu($nowtime) && Secu($a['etat'] == 1) && Secu($a['annule']) == 1) {
                                            $etat2 = '<img src="' . $url . '/managements/img/images/invalide.gif" /><br/><center>Annulée</center>';
                                        }
                                        if ($a['depuis'] <= Secu($nowtime) && Secu($a['jusqua']) > Secu($nowtime) && Secu($a['etat'] == 1) && Secu($a['annule']) == 0) {
                                            $etat2 = '<img src="' . $url . '/managements/img/images/valide.gif" /><br/><center>En cours</center>';
                                        }
                                        if ($a['depuis'] <= Secu($nowtime) && Secu($a['jusqua']) > Secu($nowtime) && Secu($a['etat'] == 1) && Secu($a['annule']) == 1) {
                                            $etat2 = '<img src="' . $url . '/managements/img/images/invalide.gif" /><br/><center>Annulée</center>';
                                        }
                                    ?>
                                        <tr class="bas">
                                            <td class="bas"><?PHP echo Secu($a['pseudo']); ?></td>
                                            <td class="bas"><?PHP echo Secu($date_depuis); ?></td>
                                            <td class="bas"><?PHP echo Secu($date_jusqua); ?></td>
                                            <td class="bas"><?PHP echo Secu($a['raison']); ?></td>
                                            <td class="bas"><?PHP echo $etat2; ?></td>
                                            <td class="bas"><?PHP
                                                            if ($user['rank'] == '8' || $user['username'] == $a['pseudo']) {
                                                                if ($a['depuis'] <= Secu($nowtime) && Secu($a['jusqua']) > Secu($nowtime) && Secu($a['etat'] == 1)) {
                                                            ?><a href="?action=<?PHP echo Secu($a['id']); ?>" onclick="return confirm('Es-tu certains d\'annuler cette absence ?')" title="Annuler cette absence" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)"><img src="<?PHP echo $url; ?>/managements/img/images/invalide.gif" /></a><?PHP }
                                                                                                                                                                                                                                                                                                                                                    } ?></td>
                                        </tr>
                                    <?PHP } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--[if lt IE 7]>
<![endif]-->
    <!-- FOOTER -->
    <?PHP include("../template/footer.php"); ?>
    <!-- FIN FOOTER -->
    <div style="clear: both;"></div>
    <script type="text/javascript">
        HabboView.run();
    </script>
</body>

</html>