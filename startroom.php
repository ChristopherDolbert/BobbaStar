<?php
/*---------------------------------------------------+
| HoloCMS - Website and Content Management System
+----------------------------------------------------+
| Copyright � 2008 Meth0d
+----------------------------------------------------+
| HoloCMS is provided "as is" and comes without
| warrenty of any kind.
+---------------------------------------------------*/

include("./config.php");
$pagename = "Starters";
$pageid = "starters";

$check = $bdd->query("SELECT noob FROM users WHERE id= " . $user['id'] . "") or die(mysql_error());;
$row = $check->fetch(PDO::FETCH_ASSOC);

if ($row['noob'] != "Oui") {
    header("location:../index.php");
    exit();
?>

    <html>

    <head>
        <title>Redirecting...</title>
        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
        <style type="text/css">
            body {
                background-color: #e3e3db;
                text-align: center;
                font: 11px Verdana, Arial, Helvetica, sans-serif;
            }

            a {
                color: #fc6204;
            }
        </style>
    </head>

    <body>
    </body>

    </html>
<?php
} else {
?>
    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <title><?PHP echo $sitename; ?> &raquo; <?PHP echo $pagename; ?></title>
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

        <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/welcome.css" type="text/css" />
        <link rel="shortcut icon" href="favicon.ico" type="image/vnd.microsoft.icon" />
        <script src="<?PHP echo $imagepath; ?>static/js/antiFireBug.js" type="text/javascript"></script>
        <script src="<?PHP echo $imagepath; ?>static/js/visual.js" type="text/javascript"></script>
        <script src="<?PHP echo $imagepath; ?>static/js/libs.js" type="text/javascript"></script>
        <script src="<?PHP echo $imagepath; ?>static/js/common.js" type="text/javascript"></script>
        <script src="<?PHP echo $imagepath; ?>static/js/fullcontent.js" type="text/javascript"></script>
        <script src="<?PHP echo $imagepath; ?>static/js/libs2.js" type="text/javascript"></script>
        <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/style.css" type="text/css" />
        <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/buttons.css" type="text/css" />
        <link rel="stylesheet" href="<?PHP echo $imagepath; ?>styles/boxes.css" type="text/css" />
        <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/tooltips.css" type="text/css" />
        <link rel="alternate" type="application/rss+xml" title="<?php $sitename; ?> News RSS" href="./rss.php" />
        <link rel="stylesheet" href="./web-gallery/v2/styles/rooms.css" type="text/css" />
        <script src="web-gallery/static/js/rooms.js" type="text/javascript"></script>
    </head>

    <body id="home" class=" ">
        <div id="tooltip"></div>
        <div id="overlay"></div>
        <!-- MENU -->
        <?PHP include("./template/header.php"); ?>
        <!-- FIN MENU -->
        <div id="container">
            <div id="content" style="position: relative" class="clearfix">
                <div id="content" style="position: relative" class="clearfix">
                    <div id="column1" class="column">
                        <div class="habblet-container ">
                            <div class="cbb clearfix lightgreen ">

                                <h2 class="title">Choisis ton appart pour avoir des mobis gratuitement!
                                </h2>
                                <div id="roomselection-welcome-intro" class="box-content">
                                    Choisis ton appart pour avoir des mobis gratuitement tous les jours !
                                </div>
                                <ul class="roomselection-welcome clearfix">
                                    <li class="odd">
                                        <a class="roomselection-select new-button" href="client.php?createRoom=0" target="client" onclick="return RoomSelectionHabblet.create(this, 0);"><b>Sélectionner</b><i></i></a>
                                    </li>
                                    <li class="even">
                                        <a class="roomselection-select new-button" href="client.php?createRoom=1" target="client" onclick="return RoomSelectionHabblet.create(this, 1);"><b>Sélectionner</b><i></i></a>
                                    </li>
                                    <li class="odd">
                                        <a class="roomselection-select new-button" href="client.php?createRoom=2" target="client" onclick="return RoomSelectionHabblet.create(this, 2);"><b>Sélectionner</b><i></i></a>
                                    </li>
                                    <li class="even">
                                        <a class="roomselection-select new-button" href="client.php?createRoom=3" target="client" onclick="return RoomSelectionHabblet.create(this, 3);"><b>Sélectionner</b><i></i></a>
                                    </li>
                                    <li class="odd">
                                        <a class="roomselection-select new-button" href="client.php?createRoom=4" target="client" onclick="return RoomSelectionHabblet.create(this, 4);"><b>Sélectionner</b><i></i></a>
                                    </li>
                                    <li class="even">
                                        <a class="roomselection-select new-button" href="client.php?createRoom=5" target="client" onclick="return RoomSelectionHabblet.create(this, 5);"><b>Sélectionner</b><i></i></a>
                                    </li>
                                </ul>



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

                            <div class="cbb clearfix lightgreen">

                                <div class="welcome-intro clearfix">
                                    <img alt="Prince-Cutie9" src="https://avatar.myhabbo.fr/?figure=<?php echo $user['look']; ?>&size=b&action=crr=667&direction=3&head_direction=3&gesture=srp
                                    " width="64" height="110" class="welcome-habbo" />
                                    <div style="padding-bottom:5px !important;text-align:center" id="welcome-intro-welcome-user">Bienvenue <?php echo $sitename; ?>!</div>
                                    <div style="padding-top:0 !important;text-align:center" id="welcome-intro-welcome-party" class="box-content">Choisis ton appart, et deviens officiellement propriétaire de ton premier appart !</div>
                                </div>

                            </div>



                        </div>
                        <script type="text/javascript">
                            if (!$(document.body).hasClassName('process-template')) {
                                Rounder.init();
                            }
                        </script>

                        <div class="habblet-container ">





                        </div>
                        <script type="text/javascript">
                            if (!$(document.body).hasClassName('process-template')) {
                                Rounder.init();
                            }
                        </script>

                        <div class="habblet-container ">





                        </div>
                        <script type="text/javascript">
                            if (!$(document.body).hasClassName('process-template')) {
                                Rounder.init();
                            }
                        </script>

                        <div class="habblet-container ">





                        </div>
                        <script type="text/javascript">
                            if (!$(document.body).hasClassName('process-template')) {
                                Rounder.init();
                            }
                        </script>

                        <div class="habblet-container ">
                            <div class="cbb clearfix green ">

                                <h2 class="title">Adieu Shockwave...
                                </h2>
                                <div class="welcome-shockwave clearfix box-content">
                                    <div id="welcome-shockwave-text"><?php echo $sitename; ?> a investi dans une techologie de pointe, qui te permets de profiter d'un Habbo OldSchool sans Shockwave</div>
                                    <div id="welcome-shockwave-logo"><img src="web-gallery/v2/images/welcome/shockwave.gif" alt="shockwave" /></div>
                                </div>


                            </div>
                        </div>
                        <script type="text/javascript">
                            if (!$(document.body).hasClassName('process-template')) {
                                Rounder.init();
                            }
                        </script>

                    </div>
                    <script type="text/javascript">
                        HabboView.run();
                    </script>
                    <div id="column3" class="column">
                        <div class="habblet-container ">

                            <div class="ad-container">
                                <br>
                            </div>



                        </div>
                        <script type="text/javascript">
                            if (!$(document.body).hasClassName('process-template')) {
                                Rounder.init();
                            }
                        </script>

                    </div>

                    <!--[if lt IE 7]>
                        <script type="text/javascript">
                        Pngfix.doPngImageFix();
                        </script>
                        <![endif]-->

                </div>
            </div>
        </div>
    </body>
<?php } ?>