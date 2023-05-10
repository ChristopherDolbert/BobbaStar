<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("./config.php");
$pagename = "Mes préférences";
$pageid = "option";
$rawname = $user['username'];

if (!isset($_SESSION['username'])) {
    Redirect($url . "/index");
}

if (isset($_GET['tab'])) {
    if ($_GET['tab'] < 1 || $_GET['tab'] > 8) {
        header("Location: profile.php?tab=1");
        $tab = 0;
        exit;
    } else {
        $tab = $_GET['tab'];
    }
} else {
    $tab = "1";
}

if ($tab == "1") {

    if (isset($_POST['figureData'])) {
        $refer = $_SERVER['HTTP_REFERER'];
        $pos = strrpos($refer, "profile.php");
        if ($pos === false) {
            echo "<h1>Security check failure.</h1>";
            exit;
        }
        $new_figure = Secu($_POST['figureData']);
        $new_gender = Secu($_POST['newGender']);
        if ($new_gender !== "M" && $new_gender !== "F") {
            $result = "An error occured. Please try again.";
            $error = "1";
        } else {
            if (empty($new_figure)) {
                $result = "An error occured trying to process your request.";
                $error = "1";
            } else {
                $stmt = $bdd->prepare("UPDATE users SET look = :new_figure, gender = :new_gender WHERE username = :rawname LIMIT 1");
                $stmt->execute(array(
                    ':new_figure' => $new_figure,
                    ':new_gender' => $new_gender,
                    ':rawname' => $user['username']
                ));
                $result = "Modifications enregistrées";
                $mylook1 = filter_input(INPUT_POST, 'figureData');
                $mysex1 = filter_input(INPUT_POST, 'newGender');
                /*SendMUSData('UPRA' . $user['id']);*/
            }
        }
    } else {
        $mylook1 = $user['look'];
        $mysex1 = $user['gender'];
    }

    // Wardrobe handler
    $stmt = $bdd->prepare("SELECT look, gender FROM users_wardrobe WHERE slot_id = '1' AND user_id = :my_id LIMIT 1");
    $stmt->bindParam(':my_id', $user['id']);
    $stmt->execute();
    $slot1 = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!empty($slot1['look'])) {
        $slot1_url = $avatarimage . $slot1['look'] . "&size=s&direction=4&head_direction=4&gesture=sml";
    }
    $stmt2 = $bdd->prepare("SELECT look, gender FROM users_wardrobe WHERE slot_id = '2' AND user_id = :my_id LIMIT 1");
    $stmt2->bindParam(':my_id', $user['id']);
    $stmt2->execute();
    $slot2 = $stmt2->fetch(PDO::FETCH_ASSOC);
    if (!empty($slot2['look'])) {
        $slot2_url = $avatarimage . $slot2['look'] . "&size=s&direction=4&head_direction=4&gesture=sml";
    }
    $stmt3 = $bdd->prepare("SELECT look, gender FROM users_wardrobe WHERE slot_id = '3' AND user_id = :my_id LIMIT 1");
    $stmt3->bindParam(':my_id', $user['id']);
    $stmt3->execute();
    $slot3 = $stmt3->fetch(PDO::FETCH_ASSOC);
    if (!empty($slot3['figure'])) {
        $slot3_url = $avatarimage . $slot2['look'] . "&size=s&direction=4&head_direction=4&gesture=sml";
    }
    $stmt4 = $bdd->prepare("SELECT look, gender FROM users_wardrobe WHERE slot_id = '4' AND user_id = :my_id LIMIT 1");
    $stmt4->bindParam(':my_id', $user['id']);
    $stmt4->execute();
    $slot4 = $stmt4->fetch(PDO::FETCH_ASSOC);
    if (!empty($slot4['figure'])) {
        $slot4_url = $avatarimage . $slot2['look'] . "&size=s&direction=4&head_direction=4&gesture=sml";
    }
    $stmt5 = $bdd->prepare("SELECT look, gender FROM users_wardrobe WHERE slot_id = '5' AND user_id = :my_id LIMIT 1");
    $stmt5->bindParam(':my_id', $user['id']);
    $stmt5->execute();
    $slot5 = $stmt5->fetch(PDO::FETCH_ASSOC);
    if (!empty($slot5['figure'])) {
        $slot5_url = $avatarimage . $slot2['look'] . "&size=s&direction=4&head_direction=4&gesture=sml";
    }
} else if ($tab == "2") {
    if (isset($_POST['save'])) {
        if (strlen($_POST['motto']) > 32) {
            $result = "D&eacute;sol&eacute;, mais la mission que tu as entr&eacute;e est trop longue!";
            $error = "1";
            $motto = $_POST['motto']; // Do not add slashes, no database communication here.
        } else {
            $motto = filter_input(INPUT_POST, 'motto');
            if ($user['online'] != 1) {
                $stmt6 = $bdd->prepare("UPDATE users SET motto = :motto WHERE username = :rawname LIMIT 1");
                $stmt6->bindParam(':motto', $motto);
                $stmt6->bindParam(':rawname', $rawname);
                $stmt6->execute();
                $result = "Ton habbo à été modifié!";
                $error = "0";
            } else {
                @SendMUSData('setmotto', ['user_id' => $user['id'], 'motto' => $motto]);
                $result = "Ton habbo à été modifié!";
                $error = "0";
            }
        }
    } else {
        $motto = Secu($user['motto']);
    }
} else if ($tab == "3") {
    if (isset($_POST['save'])) {
        $pass1 = $_POST['password'];
        $mail1 = $_POST['email'];
        $themail = $mail1;
        $newsletterdb = 0;
        if (isset($_POST['directemail'])) {
            $newsletter = "checked=\"checked\"";
            $newsletterdb = 1;
        } else {
            $newsletter = "";
            $newsletterdb = 0;
        }

        $stmt = $bdd->prepare("SELECT mail FROM users WHERE mail = ?");
        $stmt->execute([$mail1]);
        $mail = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() <= 0) {
            if (password_verify($pass1, $user['password'])) {
                $email_check = preg_match("/^[a-z0-9_\.-]+@([a-z0-9]+([\-]+[a-z0-9]+)*\.)+[a-z]{2,7}$/i", $mail1);
                if ($email_check == "1") {
                    $stmt7 = $bdd->prepare("UPDATE users SET mail = :email, newsletter = :newsletter WHERE username = :name");
                    $stmt7->execute(array(':email' => $mail1, ':newsletter' => $newsletterdb, ':name' => $user['username']));
                    $result = "Votre adresse e-mail a été modifiée en " . $mail1 . "";
                    $error = "0";
                } else {
                    $result = "Invalid e-mail address";
                    $error = "1";
                }
            } else {
                $result = "The given information doesn't match what we have on record";
                $error = "1";
            }
        } else {
            $result = "Cette adresse e-mail est déjà utilisée.";
            $error = "1";
        }
    } else {
        $themail = $user['mail'];
        if ($user['newsletter'] == "1") {
            $newsletter = "checked=\"checked\"";
        } else {
            $newsletter = "";
        }
    }
} else if ($tab == "4") {
    if (isset($_POST['save'])) {
        $pass1 = $_POST['password'];
        $newpass = $_POST['pass'];
        $newpass_hash = password_hash($newpass, PASSWORD_BCRYPT);
        $newpass_conf = $_POST['confpass'];
        if (password_verify($pass1, $user['password'])) {
            if ($newpass == $newpass_conf) {
                if (strlen($newpass) < 6) {
                    $result = "Ton mot de passe est trop court!";
                    $error = "1";
                } else {
                    if (strlen($newpass) > 25) {
                        $result = "Ton mot de passe est trop long!";
                        $error = "1";
                    } else {
                        //Updates password --encryption--
                        $stmt8 = $bdd->prepare("UPDATE users SET password = :newpass_hash WHERE username = :rawname");
                        $stmt8->bindParam(':newpass_hash', $newpass_hash);
                        $stmt8->bindParam(':rawname', $user['username']);
                        if ($stmt8->execute()) {
                            $result = "Ton mot de passe a été modifié, reconnectes-toi désormais !";
                            $error = "0";
                        } else {
                            $result = "Erreur lors de la modification de ton mot de passe, veuillez réessayer ultérieurement.";
                            $error = "1";
                        }
                    }
                }
            } else {
                $result = "Les mots de passe ne correspondent pas.";
                $error = "1";
            }
        } else {
            $result = "The given information doesn't match what we have on record";
            $error = "1";
        }
    }
} else if ($tab == "7") {
    if (isset($_POST['save'])) {
        $pass1 = $_POST['password'];
        //Hashes and salts the old password with the user id (in lowercase) --encryption--
        $pass1_hash = password_hash($pass1, PASSWORD_BCRYPT);
        $newpass = $_POST['pass'];
        //Hashes and salts the new password with the user id (in lowercase) --encryption--
        $newpass_hash = password_hash($newpass, PASSWORD_BCRYPT);
        $newpass_conf = $_POST['confpass'];
        if (password_verify($pass1_hash, $user['password'])) {
            if ($newpass == $newpass_conf) {
                if (strlen($newpass) < 6) {
                    $result = "Password is too short, 6 characters minimum";
                    $error = "1";
                } else {
                    if (strlen($newpass) > 25) {
                        $result = "Password is too long, 25 characters maximum";
                        $error = "1";
                    } else {
                        //Updates password --encryption--
                        $stmt9 = $bdd->prepare("UPDATE users SET password = :newpass_hash WHERE username = :rawname");
                        $stmt9->bindParam(':newpass_hash', $newpass_hash);
                        $stmt9->bindParam(':rawname', $rawname);
                        $stmt9->execute();
                        $result = "Ton mot de passe a &eacute;t&eacute; modifi&eacute;, reconnectes-toi d&eacute;sormais!";
                    }
                }
            } else {
                $result = "The passwords don't match";
                $error = "1";
            }
        } else {
            $result = "The given information doesn't match what we have on record";
            $error = "1";
        }
    }
} else if ($tab == "8") {
    if (isset($_POST['save'])) {
        $stmt20 = $bdd->prepare("UPDATE users_settings SET block_friendrequests = :block_friendrequests, old_chat = :old_chat, block_roominvites = :block_roominvites, block_following = :block_following WHERE user_id = :id");
        $stmt20->bindParam(':my_id', $_POST['block_friendrequests']);
        $stmt20->bindParam(':old_chat', $_POST['old_chat']);
        $stmt20->bindParam(':block_roominvites', $_POST['block_roominvites']);
        $stmt20->bindParam(':block_following', $_POST['block_following']);
        $stmt20->bindParam(':my_id', $user['id']);
        $result = "Paramètres mis à jour";
        $error = "0";
    }
}

// Save it in a variable to avoid having to check wether this user is HC member or not each time
$hc_member = IsHCMember($user['id']);

?>

    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <title><?PHP echo $sitename; ?> &raquo; <?PHP echo $pagename; ?></title>
        <script src="https://unpkg.com/@ruffle-rs/ruffle"></script>
        <script>
            window.RufflePlayer = window.RufflePlayer || {};
            window.RufflePlayer.config = {
                // Start playing the content automatically, without audio if the browser in use does not allow audio to autoplay
                "autoplay": "on",
                // Do not show an overlay to unmute the content while it plays; when the content area receives its first interaction, it will unmute
                "unmuteOverlay": "hidden",
                // Do not show a splash screen before the content loads; the content area will remain blank until Ruffle fully loads the content
                "splashScreen": false,
            }
        </script>

        <script type="text/javascript">
            var andSoItBegins = (new Date()).getTime();
            var ad_keywords = "";
            document.habboLoggedIn = true;
            var habboName = "<?PHP echo $user['username']; ?>";
            var habboReqPath = "<?PHP echo $url; ?>/";
            var habboStaticFilePath = "<?PHP echo $imagepath; ?>";
            var habboImagerUrl = "<?PHP echo $avatarimage; ?>";
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
        <script src="<?PHP echo $imagepath; ?>static/js/settings.js" type="text/javascript"></script>
        <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/settings.css" type="text/css" />
        <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/friendmanagement.css" type="text/css" />

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
        <script src="<?PHP echo $imagepath; ?>static/js/settings.js" type="text/javascript"></script>
        <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/settings.css<?php echo '?' . mt_rand(); ?>" type="text/css" />


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
<div id="tooltip"></div>
<div id="overlay"></div>
<!-- MENU -->
<?PHP include("./template/header.php"); ?>
<!-- FIN MENU -->

<div id="container">
    <div id="content">
        <div>
            <div class="content">
                <div class="habblet-container" style="float:left; width:210px;">
                    <div class="cbb settings">

                        <h2 class="title">Mes pr&eacute;f&eacute;rences</h2>
                        <div class="box-content">
                            <div id="settingsNavigation">
                                <ul>
                                    <?php
                                    if ($tab == "1") {
                                        echo "<li class='selected'>LOOK
                </li>";
                                    } else {
                                        echo "<li><a href='profile.php?tab=1'>LOOK</a>
                </li>";
                                    }

                                    if ($tab == "2") {
                                        echo "<li class='selected'>MISSION
                </li>";
                                    } else {
                                        echo "<li><a href='profile.php?tab=2'>MISSION</a>
                </li>";
                                    }

                                    if ($tab == "3") {
                                        echo "<li class='selected'>EMAIL
                </li>";
                                    } else {
                                        echo "<li><a href='profile.php?tab=3'>EMAIL</a>
                </li>";
                                    }

                                    if ($tab == "4") {
                                        echo "<li class='selected'>MOT DE PASSE
                </li>";
                                    } else {
                                        echo "<li><a href='profile.php?tab=4'>MOT DE PASSE</a>
                </li>";
                                    }

                                    if ($tab == "5") {
                                        echo "<li class='selected'>DU CREDIT?
                </li>";
                                    } else {
                                        echo "<li><a href='profile.php?tab=5'>DU CREDIT?</a>
                </li>";
                                    }

                                    if ($tab == "6") {
                                        echo "<li class='selected'>GESTION AMIS
                </li>";
                                    } else {
                                        echo "<li><a href='profile.php?tab=6'>GESTION AMIS</a>
                </li>";
                                    }

                                    if ($tab == "7") {
                                        echo "<li class='selected'>COMPTE
                </li>";
                                    } else {
                                        echo "<li><a href='profile.php?tab=7'>COMPTE</a>
                </li>";
                                    }

                                    if ($tab == "8") {
                                        echo "<li class='selected'>CLIENT
				</li>";
                                    } else {
                                        echo "<li><a href='profile.php?tab=8'>CLIENT</a>
				</li>";
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php if (!IsHCMember($user['id'])) { ?>
                        <div class="cbb habboclub-tryout">
                            <h2 class="title">Rejoins le <?php echo $shortname; ?> Club</h2>
                            <div class="box-content">
                                <div class="habboclub-banner-container habboclub-clothes-banner"></div>
                                <p class="habboclub-header">Le <?php echo $shortname; ?> Club est seulement pour les VIP's: c'est un max d'avantages, de v&ecirc;tements trop funs et surtout une console qui peut habiter plus de 600 amis!</p>
                                <p class="habboclub-link"><a href="club.php">Adh&egrave;res au <?php echo $shortname; ?> Club &gt;&gt;</a></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <?php if ($tab == "1") { ?>
                <div class="habblet-container" style="float:left; width: 560px;">
                    <div class="cbb clearfix settings">

                        <h2 class="title">Change ton look</h2>
                        <div class="box-content">

                            <?php
                            if (!empty($result)) {
                                if ($error == "1") {
                                    echo "<div class='rounded rounded-red'>";
                                } else {
                                    echo "<div class='rounded rounded-green'>";
                                }
                                echo "" . $result . "<br />
	</div><br />";
                            }
                            ?>
                            <div>&nbsp;</div>

                            <div id="settings-editor">
                                Pour te changer, il te faut Flash player d'Adobe: <a target="_blank" href="http://www.adobe.com/go/getflashplayer">http://www.adobe.com/go/getflashplayer</a>
                            </div>

                            <?php if ($hc_member) { ?><div id="settings-wardrobe" style="display: none">
                                <ol id="wardrobe-slots">
                                    <li>
                                        <p id="wardrobe-slot-1" style="background-image: url(<?php echo $slot1_url; ?>)">
                                            <span id="wardrobe-store-1" class="wardrobe-store"></span>
                                            <span id="wardrobe-dress-1" class="wardrobe-dress"></span>
                                        </p>
                                    </li>
                                    <li>
                                        <p id="wardrobe-slot-2" style="background-image: url(<?php echo $slot2_url; ?>)">
                                            <span id="wardrobe-store-2" class="wardrobe-store"></span>
                                            <span id="wardrobe-dress-2" class="wardrobe-dress"></span>
                                        </p>
                                    </li>
                                    <li>
                                        <p id="wardrobe-slot-3" style="background-image: url(<?php echo $slot3_url; ?>)">
                                            <span id="wardrobe-store-3" class="wardrobe-store"></span>
                                            <span id="wardrobe-dress-3" class="wardrobe-dress"></span>
                                        </p>
                                    </li>
                                    <li>
                                        <p id="wardrobe-slot-4" style="background-image: url(<?php echo $slot4_url; ?>)">
                                            <span id="wardrobe-store-4" class="wardrobe-store"></span>
                                            <span id="wardrobe-dress-4" class="wardrobe-dress"></span>
                                        </p>
                                    </li>
                                    <li>
                                        <p id="wardrobe-slot-5" style="background-image: url(<?php echo $slot5_url; ?>)">
                                            <span id="wardrobe-store-5" class="wardrobe-store"></span>
                                            <span id="wardrobe-dress-5" class="wardrobe-dress"></span>
                                        </p>
                                    </li>
                                </ol>

                                <script type="text/javascript">
                                    <?php if (!empty($slot1['figure'])) { ?>
                                    Wardrobe.add(1, "<?php echo $slot1['figure']; ?>", "<?php echo $slot1['gender']; ?>", true);
                                    $("wardrobe-dress-" + 1).show();
                                    <?php } ?>
                                    <?php if (!empty($slot2['figure'])) { ?>
                                    Wardrobe.add(2, "<?php echo $slot2['figure']; ?>", "<?php echo $slot2['gender']; ?>", true);
                                    $("wardrobe-dress-" + 2).show();
                                    <?php } ?>
                                    <?php if (!empty($slot3['figure'])) { ?>
                                    Wardrobe.add(3, "<?php echo $slot3['figure']; ?>", "<?php echo $slot3['gender']; ?>", true);
                                    $("wardrobe-dress-" + 3).show();
                                    <?php } ?>
                                    <?php if (!empty($slot4['figure'])) { ?>
                                    Wardrobe.add(4, "<?php echo $slot4['figure']; ?>", "<?php echo $slot4['gender']; ?>", true);
                                    $("wardrobe-dress-" + 4).show();
                                    <?php } ?>
                                    <?php if (!empty($slot5['figure'])) { ?>
                                    Wardrobe.add(5, "<?php echo $slot5['figure']; ?>", "<?php echo $slot5['gender']; ?>", true);
                                    $("wardrobe-dress-" + 5).show();
                                    <?php } ?>
                                    L10N.put("profile.figure.wardrobe_replace.title", "Replace?");
                                    L10N.put("profile.figure.wardrobe_replace.dialog", "<p\>\nAre you sure you want to replace the stored outfit with the new one?\n</p\>\n\n<p\>\n<a href=\"#\" class=\"new-button\" id=\"wardrobe-replace-cancel\"\><b\>Cancel</b\><i\></i\></a\>\n<a href=\"#\" class=\"new-button\" id=\"wardrobe-replace-ok\"\><b\>OK</b\><i\></i\></a\>\n</p\>\n\n<div class=\"clear\"\></div\>\n");
                                    L10N.put("profile.figure.wardrobe_invalid_data", "Error! This outfit cannot be saved.");
                                    L10N.put("profile.figure.wardrobe_instructions", "Press red arrows to save up to 5 outfits to your wardrobe. Press green arrow to select an outfit and save changes to take it into use.");
                                    Wardrobe.init();
                                </script>
                                </div><?php } ?>

                            <div id="settings-hc" style="display: none">
                                <div class="rounded rounded-hcred clearfix">
                                    <a href="club.php" id="settings-hc-logo"></a>
                                    Les v&ecirc;tements avec le symbole <img src="./web-gallery/v2/images/habboclub/hc_mini.png" /> sont utilisables pour les membres du Club! <a href="club.php">Adh&egrave;res vite!</a>
                                </div>
                            </div>

                            <div id="settings-oldfigure" style="display: none">
                                <div class="rounded rounded-lightbrown clearfix">
                                    Ton habbo a besoin de couleurs et de v&ecirc;tements!.
                                </div>
                            </div>

                            <form method="post" action="profile.php?tab=1" id="settings-form" style="display: none">
                                <input type="hidden" name="tab" value="1" />
                                <input type="hidden" name="__app_key" value="HoloCMS" />
                                <input type="hidden" name="figureData" id="settings-figure" value="<?php echo $mylook1; ?>" />
                                <input type="hidden" name="newGender" id="settings-gender" value="<?php echo $mysex1; ?>" />
                                <input type="hidden" name="editorState" id="settings-state" value="" />
                                <a href="#" id="settings-submit" class="new-button disabled-button"><b>Enregistrer</b><i></i></a>

                                <script type="text/javascript" language="JavaScript">
                                    var swfobj = new SWFObject("<?php echo $url; ?>/flash/HabboRegistration.swf", "habboreg", "435", "400", "8");
                                    swfobj.addParam("base", "flash/");
                                    swfobj.addParam("wmode", "opaque");
                                    swfobj.addParam("AllowScriptAccess", "always");
                                    swfobj.addVariable("figuredata_url", "xml/figuredata.xml");
                                    swfobj.addVariable("draworder_url", "xml/draworder.xml");
                                    swfobj.addVariable("localization_url", "xml/figure_editor.xml");
                                    swfobj.addVariable("figure", "");
                                    swfobj.addVariable("gender", "<?php echo $mysex1; ?>");

                                    swfobj.addVariable("showClubSelections", "1");
                                    <?php if ($hc_member) { ?>swfobj.addVariable("userHasClub", "1");
                                    <?php } ?>

                                    if (deconcept.SWFObjectUtil.getPlayerVersion()["major"] >= 8) {
                                        <?php if (!$hc_member) { ?>$("settings-editor").setStyle({
                                            textAlign: "center"
                                        });
                                        <?php } ?>
                                        swfobj.write("settings-editor");
                                        $("settings-form").show();
                                        <?php if ($hc_member) { ?>$("settings-wardrobe").show();
                                        <?php } ?>
                                    }
                                </script>

                            </form>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } else if ($tab == "2") { ?>
    <div class="habblet-container " style="float:left; width: 560px;">
        <div class="cbb clearfix settings">

            <h2 class="title">Change de profile</h2>
            <div class="box-content">



                <form action="profile.php?tab=2" method="post">
                    <input type="hidden" name="tab" value="2" />
                    <input type="hidden" name="__app_key" value="HoloCMS" />

                    <?php
                    if (!empty($result)) {
                        if ($error == "1") {
                            echo "<div class='rounded rounded-red'>";
                        } else {
                            echo "<div class='rounded rounded-green'>";
                        }
                        echo $result . "<br />
	</div><br />";
                    }
                    ?>

                    <h3>Ta mission</h3>

                    <p>
                        Choisis ta mission au fil de tes envies!
                    </p>

                    <p>
                        <span class="label">Mission:</span>
                        <input type="text" name="motto" size="32" maxlength="32" value="<?php echo Secu($motto); ?>" id="avatarmotto" />
                    </p>

                    <?php if (IsHCMember($user['id'])) { ?>
                        <h3>Habbo Club</h3>

                        <p>Tu es un membre du <?php echo $shortname; ?> Club. Ton adh&eacute;sion se termine dans <b><?php echo HCDaysLeft($user['id']);  ?> jours</b>. Si tu veux le renouveler, cliques <a href='club.php'>ici</a>.</p>
                    <?php } ?>
                    <div class="settings-buttons">
                        <input type="submit" value="Enregistrer" name="save" class="submit" />
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
    </div>
    </div>
<?php } else if ($tab == "3") { ?>
    <div class="habblet-container " style="float:left; width: 560px;">
        <div class="cbb clearfix settings">

            <h2 class="title">Change d'E-mail</h2>
            <div class="box-content">

                <?php
                if (!empty($result)) {
                    if ($error == "1") {
                        echo "<div class='rounded rounded-red'>";
                    } else {
                        echo "<div class='rounded rounded-green'>";
                    }
                    echo "" . $result . "<br />
	</div><br />";
                }
                ?>



                <form action="profile.php?tab=3" method="post" id="emailform">
                    <input type="hidden" name="tab" value="3" />
                    <input type="hidden" name="__app_key" value="HoloCMS" />

                    <div class="settings-step">

                        <h4>1.</h4>
                        <div class="settings-step-content">

                            <h3>Donne tes donn&eacute;es personnelles:</h3>

                            <p>
                                <label for="currentpassword">Mon mot de passe:</label><br />
                                <input type="password" size="32" maxlength="32" name="password" id="currentpassword" class="currentpassword " />
                            </p>

                            <div>
                                <div><label for="birthdate">Date de naissance:</label></div>
                                <div id="required-birthday"><select name="day" id="day" class="dateselector">
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
                                    </select> <select name="month" id="month" class="dateselector">
                                        <option value="">Mois</option>
                                        <option value="1">January</option>
                                        <option value="2">February</option>
                                        <option value="3">March</option>
                                        <option value="4">April</option>
                                        <option value="5">May</option>
                                        <option value="6">June</option>
                                        <option value="7">July</option>
                                        <option value="8">August</option>
                                        <option value="9">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select> <select name="year" id="year" class="dateselector">
                                        <option value="">Ann&eacute;e</option>
                                        <option value="2008">2008</option>
                                        <option value="2007">2007</option>
                                        <option value="2006">2006</option>
                                        <option value="2005">2005</option>
                                        <option value="2004">2004</option>
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
                                    </select> </div>
                            </div>

                        </div>
                    </div>
                    <div class="settings-step">

                        <h4>2.</h4>
                        <div class="settings-step-content">

                            <h3>Entre ton adresse e-mail que tu as actuellement</h3>

                            <p>Fais attention &agrave; mettre la bonne!</p>

                            <p>
                                <label for="email">Adresse e-mail:</label><br />
                                <input type="text" name="email" id="email" size="32" maxlength="48" value="<?php echo $themail; ?>" />
                            </p>

                            <p>
                                <input name="directemail" id="directemail" <?php echo $newsletter; ?> type="checkbox"> <label for="directemail">Oui, merci de m'envoyer les nouveaut&eacute;s de l'h&ocirc;tel par e-mail!</label>
                            </p>

                        </div>
                    </div>

                    <div class="settings-buttons">
                        <input type="submit" value="Enregistrer" name="save" class="submit" />
                    </div>

                </form>

            </div>
        </div>
    </div>
    </div>


    </div>
    </div>
<?php } else if ($tab == "4") { ?>
    <div class="habblet-container " style="float:left; width: 560px;">
        <div class="cbb clearfix settings">

            <h2 class="title">Change ton mot de passe</h2>
            <div class="box-content">

                <?php
                if (!empty($result)) {
                    if ($error == "1") {
                        echo "<div class='rounded rounded-red'>";
                    } else {
                        echo "<div class='rounded rounded-green'>";
                    }
                    echo "" . $result . "<br />
	</div><br />";
                }
                ?>

                <form action="profile.php?tab=4" method="post" id="passwordform">
                    <input type="hidden" name="tab" value="4" />
                    <input type="hidden" name="__app_key" value="HoloCMS" />

                    <div class="settings-step">

                        <h4>1.</h4>
                        <div class="settings-step-content">

                            <h3>Donne tes donn&eacute;es personnelles</h3>

                            <p>
                                <label for="currentpassword">Ton mot de passe:</label><br />
                                <input type="password" size="32" maxlength="32" name="password" id="currentpassword" class="currentpassword " />
                            </p>

                        </div>
                    </div>
                    <div class="settings-step">

                        <h4>2.</h4>
                        <div class="settings-step-content">

                            <h3>Choisis un nouveau mot de passe</h3>

                            <p>Entre ton nouveau passe, et re-tapes le ensuite!</p>

                            <p>
                                <label for="pass">Nouveau passe:</label><br />
                                <input type="password" name="pass" id="password" size="32" maxlength="48" value="" />
                            </p>

                            <p>
                                <label for="confpass">Confirme ton passe:</label><br />
                                <input type="password" name="confpass" id="password" size="32" maxlength="48" value="" />
                            </p>

                        </div>
                    </div>

                    <div class="settings-buttons">
                        <input type="submit" value="Enregistrer" name="save" class="submit" />
                    </div>

                </form>

            </div>
        </div>
    </div>
    </div>


    </div>
    </div>
<?php } else if ($tab == "5") { ?>
    <div class="habblet-container " style="float:left; width: 560px;">
        <div class="cbb clearfix settings">

            <h2 class="title">Besoin de cr&eacute;dit?</h2>
            <div class="box-content">
                <h3>Lien d'inscription qui donne des cr&eacute;dits!</h3>
                <p>Tu es a cours de cr&eacute;dit? Les staffs sont super occup&eacute;s et t'en a vraiment besoin? Il existe une solution!</p>
                <h3>Comment sa se passe?</h3>
                <p>C'est sous forme d'un lien a donner &agrave; tes amis! C'est simple, et efficace!</p>
                <p><b>1. Donne &agrave; ton ami ton lien.</b><br />En deux minutes, ton ami s'inscris via ton lien! Tes cr&eacute;dits vont &ecirc;tre envoy&eacute;s automatiquement! Voici le lien:<br />
                    <input type="text" size="80%" enabled="enabled" value="<?php if (!empty($path)) {
                        echo $path;
                    } ?>register.php?refer=<?php echo $rawname; ?>">
                </p>
                <p><b>2. Attendre que ton ami s'inscrive!</b><br />Apr&egrave;s &ccedil;a, a toi les mobis branch&eacute;s et deviens le plus riche de l'h&ocirc;tel!
                <h3>Tu gagnes combien?</h3>
                <p>Voici le montant de cr&eacute;dits que tu gagnes &agrave; la fin:<br />
                    <br />
                    <b><?php echo $credits; ?></b> cr&eacute;dits <sup>par inscription</sup>
                </p>
            </div>
        </div>
    </div>
<?php } elseif ($tab == "6") { ?>
    <div id="friend-management" class="habblet-container">
        <div class="cbb clearfix settings">
            <h2 class="title">Gestion des amis</h2>
            <div id="friend-management-container" class="box-content">
                <div id="category-view" class="clearfix">
                    <div id="search-view">
                        Cherche un ami
                        <div id="friend-search" class="friendlist-search">
                            <input type="text" maxlength="32" id="friend_query" class="friend-search-query" />
                            <a class="friendlist-search new-button search-icon" id="friend-search-button"><b><span></span></b><i></i></a>
                        </div>
                    </div>
                    <div id="category-list">
                        <div id="friends-category-title">
                            Cat&eacute;gories
                        </div>

                        <div class="category-default category-item selected-category" id="category-item-0">Amis</div>

                        <input type="text" maxlength="32" id="category-name" class="create-category" />
                        <div id="add-category-button" class="friendmanagement-small-icons add-category-item add-category"></div>
                    </div>
                </div>
                <div id="friend-list" class="clearfix">
                    <div id="friend-list-header-container" class="clearfix">
                        <div id="friend-list-header">
                            <div class="page-limit">
                                <div class="big-icons friend-header-icon">Amis
                                    <br />Show
                                    30 |
                                    <a class="category-limit" id="pagelimit-50">50</a> |
                                    <a class="category-limit" id="pagelimit-100">100</a>
                                </div>
                            </div>
                        </div>
                        <div id="friend-list-paging">
                            1 |
                            <?php
                            $stmt11 = $bdd->prepare("SELECT COUNT(*) FROM messenger_friendships WHERE user_one_id = '1' OR user_two_id = '1'");
                            $stmt11->execute();
                            $friendsCount = $stmt11->fetchColumn();
                            $pages = ceil($friendsCount / 30);
                            $n = 1;
                            while ($n < $pages) {
                                $n++;
                                echo "<a href=\"#\" class=\"friend-list-page\" id=\"page-" . $n . "\">" . $n . "</a> |";
                            }

                            echo "<a href=\"#\" class=\"friend-list-page\" id=\"page-2\">&gt;&gt;</a>"
                            ?>

                        </div>
                    </div>


                    <form id="friend-list-form">
                        <table id="friend-list-table" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr class="friend-list-header">
                                <td class="friend-select">
                                <td class="friend-name table-heading">Nom</td>
                                <td class="friend-login table-heading">Derni&egrave;re connexion</td>
                                <td class="friend-remove table-heading">Retour</td>
                            </tr>
                            <?php
                            $i = 0;
                            $stmt = $bdd->prepare("SELECT * FROM messenger_friendships WHERE user_one_id = '1' OR user_two_id = '1' LIMIT 30");
                            $stmt->execute();

                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $i++;

                                if (IsEven($i)) {
                                    $even = "odd";
                                } else {
                                    $even = "even";
                                }

                                if ($row['user_two_id'] == 1) {
                                    $friendstmt = $bdd->prepare("SELECT * FROM users WHERE id = ?");
                                    $friendstmt->execute(array($row['user_one_id']));
                                } else {
                                    $friendstmt = $bdd->prepare("SELECT * FROM users WHERE id = ?");
                                    $friendstmt->execute(array($row['user_two_id']));
                                }

                                $friendrow = $friendstmt->fetch(PDO::FETCH_ASSOC);

                                printf("<tr class=\"%s\">
												<td><input type=\"checkbox\" name=\"friendList[]\" value=\"%s\" /></td>
												<td class=\"friend-name\">
												 %s
												</td>
												<td class=\"friend-login\" title=\"%s\">%s</td>
												<td class=\"friend-remove\"><div id=\"remove-friend-button-%s\" class=\"friendmanagement-small-icons friendmanagement-remove remove-friend\"></div></td>
											</tr>", $even, $friendrow['id'], $friendrow['username'], $friendrow['last_online'], $friendrow['last_online'], $friendrow['id']);
                            }
                            ?>
                            </tbody>
                        </table>
                        <a class="select-all" id="friends-select-all" href="#">S&eacute;lectionner tout</a> |
                        <a class="deselect-all" href="#" id="friends-deselect-all">D&eacute;selectionner tout</a>
                    </form>
                </div>
                <script type="text/javascript">
                    new FriendManagement({
                        currentCategoryId: 0,
                        pageListLimit: 30,
                        pageNumber: 1
                    });
                </script>
                <div id="category-options" class="clearfix">
                    <select id="category-list-select" name="category-list">
                        <option value="0">Friends</option>
                        <option value="1">Test Friends</option>
                    </select>
                    <div class="friend-del"><a class="new-button red-button cancel-icon" href="#" id="delete-friends"><b><span></span>Supprimer les amis s&eacute;lectionn&eacute;s</b><i></i></a></div>
                    <div class="friend-move"><a class="new-button" href="#" id="move-friend-button"><b><span></span>Retour</b><i></i></a></div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script type="text/javascript">
        L10N.put("friendmanagement.tooltip.deletefriends", "Es-tu sur de supprimer ces amis?\n<div class=\"friendmanagement-small-icons friendmanagement-save friendmanagement-tip-delete\"\>\n    <a class=\"friends-delete-button\" id=\"delete-friends-button\"\>Delete</a\>\n</div\>\n<div class=\"friendmanagement-small-icons friendmanagement-remove friendmanagement-tip-cancel\"\>\n    <a id=\"cancel-delete-friends\"\>Cancel</a\>\n</div\>\n\n");
        L10N.put("friendmanagement.tooltip.deletefriend", "Es-tu sur de supprimer cet ami?\n<div class=\"friendmanagement-small-icons friendmanagement-save friendmanagement-tip-delete\"\>\n    <a id=\"delete-friend-%friend_id%\"\>Delete</a\>\n</div\>\n<div class=\"friendmanagement-small-icons friendmanagement-remove friendmanagement-tip-cancel\"\>\n    <a id=\"remove-friend-can-%friend_id%\"\>Cancel</a\>\n</div\>");
        L10N.put("friendmanagement.tooltip.deletecategory", "Es-tu sur de supprimer cette cat&eacute;gorie?\n<div class=\"friendmanagement-small-icons friendmanagement-save friendmanagement-tip-delete\"\>\n    <a class=\"delete-category-button\" id=\"delete-category-%category_id%\"\>Delete</a\>\n</div\>\n<div class=\"friendmanagement-small-icons friendmanagement-remove friendmanagement-tip-cancel\"\>\n    <a id=\"cancel-cat-delete-%category_id%\"\>Cancel</a\>\n</div\>");
    </script>

    </div>
    </div>
<?php } else if ($tab == "7") { ?>
    <div class="habblet-container " style="float:left; width: 560px;">
        <div class="cbb clearfix settings">

            <h2 class="title">Compte</h2>
            <div class="box-content">

                <h3>Télécharger mes données</h3>
                <p><?php echo $sitename; ?> vous propose de télécharger les données stockées à votre sujet</p>

                <form method='post' action='download.php'>
                    <input class="submit" type='submit' value='Exporter mes données' name='Export'>
                    <?php
                    try {
                        $query = "SELECT * FROM users WHERE id = :id";
                        $stmt = $bdd->prepare($query);
                        $stmt->bindParam(':id', $user['id'], PDO::PARAM_INT);
                        $stmt->execute();

                        $user_arr = array();
                        while ($row = $stmt->fetch()) {
                            $id = "ID du compte : " . (isset($row['id']) ? $row['id'] : 'N/A');
                            $uname = "Nom d'utilisateur : " . (isset($row['username']) ? $row['username'] : 'N/A');
                            $name = "Nom réel du compte : " . (isset($row['real_name']) ? $row['real_name'] : 'N/A');
                            $mail = "E-mail du compte : " . (isset($row['mail']) ? $row['mail'] : 'N/A');
                            $account_created = "Compte créé le : " . date('d/m/Y à H:i:s', $row['account_created']);
                            $account_day_of_birth = "Utilisateur né le :" . date('d/m/Y à H:i:s', $row['account_day_of_birth']);
                            $last_login = "Dernière connexion : " . date('d/m/Y à H:i:s', $row['last_login']);
                            $motto = "Mission : " . (isset($row['motto']) ? $row['motto'] : 'N/A');
                            $sexe = "Sexe : " . (isset($row['gender']) ? $row['gender'] : 'N/A');
                            $ip_register = "IP Inscription : " . (isset($row['ip_register']) ? $row['ip_register'] : 'N/A');
                            $ip_current = "IP Actuelle : " . (isset($row['ip_current']) ? $row['ip_current'] : 'N/A');
                            $machine_id = "ID Machine : " . (isset($row['machine_id']) ? $row['machine_id'] : 'N/A');

                            $user_arr[] = array($id, $uname, $name, $mail, $account_created, $account_day_of_birth, $last_login, $motto, $sexe, $ip_register, $ip_current, $machine_id);
                        }
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                        die();
                    }
                    ?>
                    <?php
                    $serialize_user_arr = serialize($user_arr);
                    ?>
                    <textarea name='export_data' style='display: none;'><?php echo $serialize_user_arr; ?></textarea>
                </form>
                <br />
                <h3>Supprimer mes données</h3>
                <p>Supprimer toute trace de votre passage sur <?php echo $sitename; ?>, <strong style="color:red">cette action est irreversible.</strong></p>
                <form method="post">
                    <?php if ($user['rank'] <= 1) { ?>
                        <input class="submit" type='submit' value='Supprimer mes données' name='Suppression' disabled>
                    <?php } elseif ($user['rank'] > 2) { ?>
                        <div id="purse-redeem-result">
                            <div class="redeem-error">
                                <div class="rounded-container">
                                    <div style="background-color: rgb(255, 255, 255);">
                                        <div style="margin: 0px 4px; height: 1px; overflow: hidden; background-color: rgb(255, 255, 255);">
                                            <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(238, 107, 122);">
                                                <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(231, 40, 62);">
                                                    <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(227, 8, 33);">
                                                        <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(226, 0, 26);"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="margin: 0px 2px; height: 1px; overflow: hidden; background-color: rgb(255, 255, 255);">
                                            <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(238, 105, 121);">
                                                <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(226, 1, 27);">
                                                    <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(226, 0, 26);"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="margin: 0px 1px; height: 1px; overflow: hidden; background-color: rgb(255, 255, 255);">
                                            <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(233, 64, 83);">
                                                <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(226, 0, 26);"></div>
                                            </div>
                                        </div>
                                        <div style="margin: 0px 1px; height: 1px; overflow: hidden; background-color: rgb(238, 105, 121);">
                                            <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(226, 0, 26);"></div>
                                        </div>
                                        <div style="margin: 0px; height: 1px; overflow: hidden; background-color: rgb(255, 255, 255);">
                                            <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(226, 1, 27);">
                                                <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(226, 0, 26);"></div>
                                            </div>
                                        </div>
                                        <div style="margin: 0px; height: 1px; overflow: hidden; background-color: rgb(238, 107, 122);">
                                            <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(226, 0, 26);"></div>
                                        </div>
                                        <div style="margin: 0px; height: 1px; overflow: hidden; background-color: rgb(231, 40, 62);">
                                            <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(226, 0, 26);"></div>
                                        </div>
                                        <div style="margin: 0px; height: 1px; overflow: hidden; background-color: rgb(227, 8, 33);">
                                            <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(226, 0, 26);"></div>
                                        </div>
                                    </div>
                                    <div class="rounded-red rounded-done">
                                        <strong>Rank trop élevé</strong>, merci d'informer vos supérieurs <a href="./managements/stafftchat">ici</a>.
                                    </div>
                                    <div style="background-color: rgb(255, 255, 255);">
                                        <div style="margin: 0px; height: 1px; overflow: hidden; background-color: rgb(227, 8, 33);">
                                            <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(226, 0, 26);"></div>
                                        </div>
                                        <div style="margin: 0px; height: 1px; overflow: hidden; background-color: rgb(231, 40, 62);">
                                            <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(226, 0, 26);"></div>
                                        </div>
                                        <div style="margin: 0px; height: 1px; overflow: hidden; background-color: rgb(238, 107, 122);">
                                            <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(226, 0, 26);"></div>
                                        </div>
                                        <div style="margin: 0px; height: 1px; overflow: hidden; background-color: rgb(255, 255, 255);">
                                            <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(226, 1, 27);">
                                                <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(226, 0, 26);"></div>
                                            </div>
                                        </div>
                                        <div style="margin: 0px 1px; height: 1px; overflow: hidden; background-color: rgb(238, 105, 121);">
                                            <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(226, 0, 26);"></div>
                                        </div>
                                        <div style="margin: 0px 1px; height: 1px; overflow: hidden; background-color: rgb(255, 255, 255);">
                                            <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(233, 64, 83);">
                                                <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(226, 0, 26);"></div>
                                            </div>
                                        </div>
                                        <div style="margin: 0px 2px; height: 1px; overflow: hidden; background-color: rgb(255, 255, 255);">
                                            <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(238, 105, 121);">
                                                <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(226, 1, 27);">
                                                    <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(226, 0, 26);"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="margin: 0px 4px; height: 1px; overflow: hidden; background-color: rgb(255, 255, 255);">
                                            <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(238, 107, 122);">
                                                <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(231, 40, 62);">
                                                    <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(227, 8, 33);">
                                                        <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(226, 0, 26);"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
<?php } else if ($tab == "8") { ?>
    <div class="habblet-container " style="float:left; width: 560px;">
        <div class="cbb clearfix settings">

            <h2 class="title">Autres</h2>
            <div class="box-content">
                <form action="profile.php?tab=8" method="post">
                    <input type="hidden" name="tab" value="8" />
                    <input type="hidden" name="__app_key" value="HoloCMS" />

                    <?php
                    if (!empty($result)) {
                        if ($error == "1") {
                            echo "<div class='rounded rounded-red'>";
                        } else {
                            echo "<div class='rounded rounded-green'>";
                        }
                        echo $result . "</div>";
                    }
                    ?>

                    <?php
                    $stmt = $bdd->prepare("SELECT * FROM users_settings WHERE user_id = :my_id LIMIT 1");
                    $stmt->bindParam(':my_id', $user['id'], PDO::PARAM_INT);
                    $stmt->execute();

                    if ($stmt->rowCount() <= 0) {
                        $stmt = $bdd->prepare("INSERT INTO users_settings (user_id) VALUES (:my_id)");
                        $stmt->bindParam(':my_id', $user['id'], PDO::PARAM_INT);
                        $stmt->execute();

                        $stmt = $bdd->prepare("SELECT * FROM users_settings WHERE user_id = :my_id LIMIT 1");
                        $stmt->bindParam(':my_id', $user['id'], PDO::PARAM_INT);
                        $stmt->execute();
                    }

                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    ?>


                    <h3>Bloquer les Textamigo</h3>
                    <p>
                        <input type="radio" name="block_friendrequests" value="1" <?php if ($row['block_friendrequests'] == "1") { ?> checked="checked" <?php } ?> />Oui
                        <input type="radio" name="block_friendrequests" value="0" <?php if ($row['block_friendrequests'] == "0") { ?> checked="checked" <?php } ?> />Non
                    </p>

                    <h3>Ancien chat</h3>
                    <p>
                        <input type="radio" name="old_chat" value="1" <?PHP if ($row['old_chat'] == "1") { ?> checked="checked" <?PHP } ?> />Ancien
                        <input type="radio" name="old_chat" value="0" <?PHP if ($row['old_chat'] == "0") { ?> checked="checked" <?PHP } ?> />Nouveau
                    </p>

                    <h3>Bloquer les invitations d'appart</h3>
                    <p>
                        <input type="radio" name="block_roominvites" value="1" <?PHP if ($row['block_roominvites'] == "1") { ?> checked="checked" <?PHP } ?> />Oui
                        <input type="radio" name="block_roominvites" value="0" <?PHP if ($row['block_roominvites'] == "0") { ?> checked="checked" <?PHP } ?> />Non
                    </p>

                    <h3>Bloquer le suivi</h3>
                    <p>
                        <input type="radio" name="block_following" value="1" <?PHP if ($row['block_following'] == "1") { ?> checked="checked" <?PHP } ?> />Oui
                        <input type="radio" name="block_following" value="0" <?PHP if ($row['block_following'] == "0") { ?> checked="checked" <?PHP } ?> />Non
                    </p>

                    <div class="settings-buttons">
                        <input type="submit" value="Enregistrer" name="save" class="submit" />
                    </div>

                </form>

            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
<?php } else { ?>
    <b>Tab appears to be valid, but no tab data found. Please report this issue.</b>
<?php } ?>

<script type="text/javascript">
    if (!$(document.body).hasClassName('process-template')) {
        Rounder.init();
    }
</script>

<?php

include('template/footer.php');

?>