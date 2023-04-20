<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|

#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("./config.php");
$pagename = "Achats";
$pageid = "achats";

if (!isset($_SESSION['username'])) {
    Redirect("" . $url . "/index");
}
$cof_prix = $bdd->query("SELECT * FROM gabcms_config_prix WHERE id = '1'");
$cp = $cof_prix->fetch();

if (isset($_GET['do'])) {
    $do = Secu($_GET['do']);
    if ($do == "check") {
        $prix_ticket0 = Secu($_POST['transactions_winwin']);
        if ($user['jetons'] >= $cp['winwin'] && $user['id'] != "" && $prix_ticket0 == $cp['winwin']) {
            $bdd->query("UPDATE users SET jetons = jetons - " . $cp['winwin'] . " WHERE id = '" . $user['id'] . "'");
            $bdd->query("UPDATE users_settings SET achievement_score = achievement_score + 1000 WHERE user_id = '" . $user['id'] . "'");
            $insertn1 = $bdd->prepare("INSERT INTO gabcms_transaction (user_id, produit, prix, gain, date) VALUES (:userid, :produit, :prix, :gain, :date)");
            $insertn1->bindValue(':userid', $user['id']);
            $insertn1->bindValue(':produit', 'Achat 1000 points winwin');
            $insertn1->bindValue(':prix', $cp['winwin']);
            $insertn1->bindValue(':gain', '-');
            $insertn1->bindValue(':date', FullDate('full'));
            $insertn1->execute();
            $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-green\"> 
              Tu viens d'être rechargé de 1000 points win-win !
            </div> 
        </div> 
</div>";
        } else {
            $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
              Tu n'as pas assez de jetons
            </div> 
        </div> 
</div>";
        }
    }

    if ($do == "check2") {
        $prix_ticket2 = Secu($_POST['transactions_respects300']);
        if ($user['jetons'] >= $cp['respects_300'] && $user['id'] != "" && $prix_ticket2 == $cp['respects_300']) {
            $bdd->query("UPDATE users SET jetons = jetons - " . $cp['respects_300'] . " WHERE id = '" . $user['id'] . "'");
            $bdd->query("UPDATE users_settings SET 	daily_respect_points = 	daily_respect_points + 300 WHERE user_id = '" . $user['id'] . "'");
            $insertn1 = $bdd->prepare("INSERT INTO gabcms_transaction (user_id, produit, prix, gain, date) VALUES (:userid, :produit, :prix, :gain, :date)");
            $insertn1->bindValue(':userid', $user['id']);
            $insertn1->bindValue(':produit', 'Achat 300 respects');
            $insertn1->bindValue(':prix', $cp['respects_300']);
            $insertn1->bindValue(':gain', '-');
            $insertn1->bindValue(':date', FullDate('full'));
            $insertn1->execute();
            $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-green\"> 
              Tu viens d'être rechargé avec 300 respects !
            </div> 
        </div> 
</div>";
        } else {
            $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
			  Tu n'as pas assez de jetons
            </div> 
        </div> 
</div>";
        }
    }

    if ($do == "check3") {
        $prix_ticket3 = Secu($_POST['transactions_respects700']);
        if ($user['jetons'] >= $cp['respects_700'] && $user['id'] != "" && $prix_ticket3 == $cp['respects_700']) {
            $bdd->query("UPDATE users SET jetons = jetons - " . $cp['respects_700'] . " WHERE id = '" . $user['id'] . "'");
            $bdd->query("UPDATE users_settings SET daily_respect_points = daily_respect_points + 700 WHERE user_id = '" . $user['id'] . "'");
            $insertn1 = $bdd->prepare("INSERT INTO gabcms_transaction (user_id, produit, prix, gain, date) VALUES (:userid, :produit, :prix, :gain, :date)");
            $insertn1->bindValue(':userid', $user['id']);
            $insertn1->bindValue(':produit', 'Achat 700 respects');
            $insertn1->bindValue(':prix', $cp['respects_700']);
            $insertn1->bindValue(':gain', '-');
            $insertn1->bindValue(':date', FullDate('full'));
            $insertn1->execute();
            $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-green\"> 
              Tu viens d'être rechargé avec 700 respects !
            </div> 
        </div> 
</div>";
        } else {
            $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
              Tu n'as pas assez de jetons
            </div> 
        </div> 
</div>";
        }
    }

    if ($do == "check4") {
        $prix_ticket4 = Secu($_POST['transactions_caresses_400']);
        if ($user['jetons'] >= $cp['caresses_400'] && $user['id'] != "" && $prix_ticket4 == $cp['caresses_400']) {
            $bdd->query("UPDATE users SET jetons = jetons - " . $cp['caresses_400'] . " WHERE id = '" . $user['id'] . "'");
            $bdd->query("UPDATE users_settings SET daily_pet_respect_points = daily_pet_respect_points + 400 WHERE user_id = '" . $user['id'] . "'");
            $insertn1 = $bdd->prepare("INSERT INTO gabcms_transaction (user_id, produit, prix, gain, date) VALUES (:userid, :produit, :prix, :gain, :date)");
            $insertn1->bindValue(':userid', $user['id']);
            $insertn1->bindValue(':produit', 'Achat 400 caresses');
            $insertn1->bindValue(':prix', $cp['caresses_400']);
            $insertn1->bindValue(':gain', '-');
            $insertn1->bindValue(':date', FullDate('full'));
            $insertn1->execute();
            $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-green\"> 
              Tu viens d'être rechargé avec 400 caresses !
            </div> 
        </div> 
</div>";
        } else {
            $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
              Tu n'as pas assez de jetons
            </div> 
        </div> 
</div>";
        }
    }
    if ($do == "check5") {
        $prix_ticket5 = Secu($_POST['transactions_caresses_900']);
        if ($user['jetons'] >= $cp['caresses_900'] && $user['id'] != "" && $prix_ticket5 == $cp['caresses_900']) {
            $bdd->query("UPDATE users SET jetons = jetons - " . $cp['caresses_900'] . " WHERE id = '" . $user['id'] . "'");
            $bdd->query("UPDATE users_settings SET daily_pet_respect_points = daily_pet_respect_points + 900 WHERE user_id = '" . $user['id'] . "'");
            $insertn1 = $bdd->prepare("INSERT INTO gabcms_transaction (user_id, produit, prix, gain, date) VALUES (:userid, :produit, :prix, :gain, :date)");
            $insertn1->bindValue(':userid', $user['id']);
            $insertn1->bindValue(':produit', 'Achat 900 caresses');
            $insertn1->bindValue(':prix', $cp['caresses_900']);
            $insertn1->bindValue(':gain', '-');
            $insertn1->bindValue(':date', FullDate('full'));
            $insertn1->execute();
            $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-green\"> 
              Tu viens d'être rechargé avec 900 caresses !
            </div> 
        </div> 
</div>";
        } else {
            $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
              Tu n'as pas assez de jetons
            </div> 
        </div> 
</div>";
        }
    }

    if ($do == "check6") {
        $prix_ticket6 = Secu($_POST['transactions_messages']);
        if ($user['jetons'] >= $cp['messages'] && $user['id'] != "" && $prix_ticket6 == $cp['messages']) {
            $bdd->query("UPDATE users SET jetons = jetons - " . $cp['messages'] . ", message = message + 30 WHERE id = '" . $user['id'] . "'");
            $insertn1 = $bdd->prepare("INSERT INTO gabcms_transaction (user_id, produit, prix, gain, date) VALUES (:userid, :produit, :prix, :gain, :date)");
            $insertn1->bindValue(':userid', $user['id']);
            $insertn1->bindValue(':produit', 'Achat 30 messages');
            $insertn1->bindValue(':prix', $cp['messages']);
            $insertn1->bindValue(':gain', '-');
            $insertn1->bindValue(':date', FullDate('full'));
            $insertn1->execute();
            $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-green\"> 
              Tu viens d'être recharger de 30 messages ! Défoule toi sur le tchat !
            </div> 
        </div> 
</div>";
        } else {
            $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
              Tu n'as pas assez de jetons
            </div> 
        </div> 
</div>";
        }
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">

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
        var habboImagerUrl = "http://www.habbo.co.uk/habbo-imaging/";
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
    <script src="<?PHP echo $imagepath; ?>static/js/fullcontent.js" type="text/javascript"></script>

    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/style.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/buttons.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/boxes.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/tooltips.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/personal.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
    <script src="<?PHP echo $imagepath; ?>static/js/habboclub.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/minimail.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/myhabbo/control.textarea.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
    <script src="<?PHP echo $imagepath; ?>static/js/minimail.js" type="text/javascript"></script>

    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>static/styles/cbs2credits.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>static/styles/newcredits.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
    <script src="<?PHP echo $imagepath; ?>static/js/cbs2credits.js" type="text/javascript"></script>

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

                <div class="habblet-container" id="okt" style="float:left; width: 770px;">
                    <div class="cbb clearfix orange ">

                        <div class="campaign-banner-vip">
                            <div style="padding-top: 5px;"></div>
                            <div class="campaign-banner-monsterplant-header-container-left">
                                <div class="campaign-banner-monsterplant-header-mid">
                                    <div class="campaign-banner-monsterplant-header-inner"></div>
                                </div>
                            </div>
                            <div class="campaign-banner-monsterplant-header-container-right">
                                <div class="campaign-banner-monsterplant-info-mid">
                                </div>
                            </div>



                            <div class="campaign-banner-monsterplant-status-line-container">


                            </div>
                        </div>

                        <div class="method-group phone clearfix   cbs2">
                            <?PHP if (isset($affichage)) {
                                echo "<br/>" . $affichage . "<br/><br/>";
                            } ?>
                            <div class="method idx0 m-smsma nosmallprint">
                                <div class="method-content">
                                    <h2>
                                        <font color="#F24987">RESPECTS</font>
                                    </h2>
                                    <div class="top">
                                        <div></div>
                                    </div>

                                    <div class="summary clearfix">

                                        <ol>
                                            <div>Ici, tu peux obtenir <b>300</b> ou bien <b>700</b> respects en un simple clique.<br /> Les respects te permettent de respecter les <?PHP echo $sitename; ?>iens, <br />pour te faire un max d'amis.<br />L'achat de respects est <b>payant</b>.<br />
                                                <h4><img src="<?PHP echo $imagepath; ?>v2/images/attention.gif"> 300 = <?PHP echo $cp['respects_300'] ?> JETONS<br />
                                                    <font color="#EDEDED">_-</font> 700 = <?PHP echo $cp['respects_700'] ?> JETONS</b>
                                                </h4>
                                            </div>
                                        </ol>

                                        <form name="editor" method="post" action="?do=check2"><input type="hidden" name="transactions_respects300" value="<?PHP echo $cp['respects_300'] ?>" />
                                            <center><input type="submit" name="submit" value="Acheter 300 respects" /></center>
                                        </form><br />
                                        <form name="editor" method="post" action="?do=check3"><input type="hidden" name="transactions_respects700" value="<?PHP echo $cp['respects_700'] ?>" />
                                            <center><input type="submit" name="submit" value="Acheter 700 respects" /></center>
                                        </form>
                                        <br />
                                    </div>
                                </div>

                                <div class="price">
                                    <div>
                                        <div>




                                            <div class="pricepoint-amount-container">
                                                <img src="<?PHP echo $imagepath; ?>v2/images/divers/ACH_RespectEarned10.gif">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </ol>

                                <div class="bottom">
                                    <div></div>
                                </div>
                            </div>

                            <div class="method idx0 m-smsma nosmallprint">

                                <div class="method-content">
                                    <h2>
                                        <font color="#0ECA27">CARESSES</font>
                                    </h2>
                                    <div class="top">
                                        <div></div>
                                    </div>

                                    <div class="summary clearfix">

                                        <ol>
                                            <div>Ici, tu peux obtenir <b>400</b> ou bien <b>900</b> caresses en un simple clique.<br /> Les caresser te permettent de faire évoluer plus rapidement tes animaux en les caressant.<br />L'achat de caresses est <b>payant</b>.<br />
                                                <h4><img src="<?PHP echo $imagepath; ?>v2/images/attention.gif"> 400 = <?PHP echo $cp['caresses_400'] ?> JETONS<br />
                                                    <font color="#EDEDED">_-</font> 900 = <?PHP echo $cp['caresses_900'] ?> JETONS</b>
                                                </h4>
                                            </div>
                                        </ol>

                                        <form name="editor" method="post" action="?do=check4"><input type="hidden" name="transactions_caresses_400" value="<?PHP echo $cp['caresses_400'] ?>" />
                                            <center><input type="submit" name="submit" value="Acheter 400 caresses" /></center>
                                        </form><br />
                                        <form name="editor" method="post" action="?do=check5"><input type="hidden" name="transactions_caresses_900" value="<?PHP echo $cp['caresses_900'] ?>" />
                                            <center><input type="submit" name="submit" value="Acheter 900 caresses" /></center>
                                        </form>
                                        <br />
                                    </div>
                                </div>

                                <div class="price">
                                    <div>
                                        <div>




                                            <div class="pricepoint-amount-container">
                                                <img src="<?PHP echo $imagepath; ?>v2/images/divers/ACH_PetLover10.gif">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="bottom">
                                    <div></div>
                                </div>
                            </div>
                            <div class="method idx0 m-smsma nosmallprint">

                                <br />
                                <div class="method-content">
                                    <h2>
                                        <font color="#30BFEA">WINWIN</font>
                                    </h2>
                                    <div class="top">
                                        <div></div>
                                    </div>

                                    <div class="summary clearfix">


                                        <ol>
                                            <div>Ici, tu peux obtenir <b>1000</b> points winwin en un simple clique. Ils te permettront de frimer dans l'hôtel et de devenir le king des missions.<br />L'achat de winwins est <b>payant</b>.<br />
                                                <h4><img src="<?PHP echo $imagepath; ?>v2/images/attention.gif"> PRIX = <?PHP echo $cp['winwin'] ?> JETONS</h4>
                                            </div>
                                        </ol>
                                        <form name="editor" method="post" action="?do=check"><input type="hidden" name="transactions_winwin" value="<?PHP echo $cp['winwin'] ?>" />
                                            <center><input type="submit" name="submit" value="Acheter 1000 winwins" /></center>
                                        </form>
                                        <div style="float: right; padding: 0 15px 15px 0; ">


                                            </p>
                                        </div>


                                    </div>
                                </div>

                                <div class="price">
                                    <div>
                                        <div>




                                            <div class="pricepoint-amount-container">
                                                <img src="<?PHP echo $imagepath; ?>v2/images/divers/ach_friendlistsize6.gif">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bottom">
                                    <div></div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    if (!$(document.body).hasClassName('process-template')) {
                        Rounder.init();
                    }
                </script>
                <script type="text/javascript">
                    HabboView.run();
                </script>
            </div>
        </div>
        <!--[if lt IE 7]>
<script type="text/javascript">
Pngfix.doPngImageFix();
</script>
<![endif]-->
        <!-- FOOTER -->
        <?PHP include("./template/footer.php"); ?>
        <div style="clear: both;"></div>
    </div>
    </div>
    <script type="text/javascript">
        HabboView.run();
    </script>
</body>

</html>