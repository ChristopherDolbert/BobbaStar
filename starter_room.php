<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("./config.php");
$pagename = "Starters";
$pageid = "starters";

$check = $bdd->prepare("SELECT noob FROM users WHERE id = ?");
$check->execute([$user['id']]);
$row = $check->fetch(PDO::FETCH_ASSOC);

if ($row['noob'] != "Oui") {
    Redirect($url . "/moi");
} else {
    if (isset($_GET['createRoom'])) {
        $choosedRoom = $_GET['createRoom'];

        if ($choosedRoom >= 0 && $choosedRoom <= 5) {
            switch ($choosedRoom) {
                case 0:
                    $reqCreateRoom = $bdd->prepare("INSERT INTO `rooms` (`owner_id`, `owner_name`, `name`,`description`,`model`,`password`,`state`,`users`,`users_max`,`guild_id`,`category`,`score`,`paper_floor`,`paper_wall`,`paper_landscape`,`thickness_wall`,`wall_height`,`thickness_floor`,`moodlight_data`,`tags`,`is_public`,`is_staff_picked`,`allow_other_pets`,`allow_other_pets_eat`,`allow_walkthrough`,`allow_hidewall`,`chat_mode`,`chat_weight`,`chat_speed`,`chat_hearing_distance`,`chat_protection`,`override_model`,`who_can_mute`,`who_can_kick`,`who_can_ban`,`poll_id`,`roller_speed`,`promoted`,`trade_mode`,`move_diagonally`,`jukebox_active`,`hidewired`,`is_forsale`,`trax_active`) VALUES (?, ?, ?,'','model_a','','open',1,10,0,9,0,'0.0','0.0','0.0',0,-1,0,'2,1,1,#000000,255;2,2,2,#000000,255;2,3,1,#000000,255;','','0','0','0','0','1','0',0,1,1,50,2,'0',0,0,0,0,4,'0',0,'1','0','0','0',0);");
                    $reqCreateRoom->execute([$user['id'], $user['username'], "Appart de " . $user['username']]);

                    $roomId = $bdd->lastInsertId();

                    $reqInsertItems = $bdd->prepare("INSERT INTO `items` (`user_id`,`room_id`,`item_id`,`wall_pos`,`x`,`y`,`z`,`rot`,`extra_data`,`wired_data`,`limited_data`,`guild_id`) 
                    VALUES (:userid,:roomid,154,'',6,13,0,0,'0','','0:0',0)
                    ,(:userid,:roomid,1912,'',7,8,0,0,'0','','0:0',0)
                    ,(:userid,:roomid,157,'',9,7,0,0,'0','','0:0',0)
                    ,(:userid,:roomid,157,'',7,4,0,0,'0','','0:0',0)");
                    $reqInsertItems->execute([
                        'userid' => $user['id'],
                        'roomid' => $roomId
                    ]);
                    break;
                case 1:
                    $reqCreateRoom = $bdd->prepare("INSERT INTO `rooms` (`owner_id`, `owner_name`, `name`,`description`,`model`,`password`,`state`,`users`,`users_max`,`guild_id`,`category`,`score`,`paper_floor`,`paper_wall`,`paper_landscape`,`thickness_wall`,`wall_height`,`thickness_floor`,`moodlight_data`,`tags`,`is_public`,`is_staff_picked`,`allow_other_pets`,`allow_other_pets_eat`,`allow_walkthrough`,`allow_hidewall`,`chat_mode`,`chat_weight`,`chat_speed`,`chat_hearing_distance`,`chat_protection`,`override_model`,`who_can_mute`,`who_can_kick`,`who_can_ban`,`poll_id`,`roller_speed`,`promoted`,`trade_mode`,`move_diagonally`,`jukebox_active`,`hidewired`,`is_forsale`,`trax_active`) VALUES (?, ?, ?,'','model_a','','open',1,10,0,9,0,'0.0','0.0','0.0',0,-1,0,'2,1,1,#000000,255;2,2,2,#000000,255;2,3,1,#000000,255;','','0','0','0','0','1','0',0,1,1,50,2,'0',0,0,0,0,4,'0',0,'1','0','0','0',0);");
                    $reqCreateRoom->execute([$user['id'], $user['username'], "Appart de " . $user['username']]);

                    $roomId = $bdd->lastInsertId();

                    $reqInsertItems = $bdd->prepare("INSERT INTO `items` (`user_id`,`room_id`,`item_id`,`wall_pos`,`x`,`y`,`z`,`rot`,`extra_data`,`wired_data`,`limited_data`,`guild_id`) 
                    VALUES (:userid,:roomid,154,'',6,13,0,0,'0','','0:0',0)
                    ,(:userid,:roomid,1912,'',7,8,0,0,'0','','0:0',0)
                    ,(:userid,:roomid,157,'',9,7,0,0,'0','','0:0',0)
                    ,(:userid,:roomid,157,'',7,4,0,0,'0','','0:0',0)");
                    $reqInsertItems->execute([
                        'userid' => $user['id'],
                        'roomid' => $roomId
                    ]);
                    break;
                case 2:
                    $reqCreateRoom = $bdd->prepare("INSERT INTO `rooms` (`owner_id`, `owner_name`, `name`,`description`,`model`,`password`,`state`,`users`,`users_max`,`guild_id`,`category`,`score`,`paper_floor`,`paper_wall`,`paper_landscape`,`thickness_wall`,`wall_height`,`thickness_floor`,`moodlight_data`,`tags`,`is_public`,`is_staff_picked`,`allow_other_pets`,`allow_other_pets_eat`,`allow_walkthrough`,`allow_hidewall`,`chat_mode`,`chat_weight`,`chat_speed`,`chat_hearing_distance`,`chat_protection`,`override_model`,`who_can_mute`,`who_can_kick`,`who_can_ban`,`poll_id`,`roller_speed`,`promoted`,`trade_mode`,`move_diagonally`,`jukebox_active`,`hidewired`,`is_forsale`,`trax_active`) VALUES (?, ?, ?,'','model_a','','open',1,10,0,9,0,'0.0','0.0','0.0',0,-1,0,'2,1,1,#000000,255;2,2,2,#000000,255;2,3,1,#000000,255;','','0','0','0','0','1','0',0,1,1,50,2,'0',0,0,0,0,4,'0',0,'1','0','0','0',0);");
                    $reqCreateRoom->execute([$user['id'], $user['username'], "Appart de " . $user['username']]);

                    $roomId = $bdd->lastInsertId();

                    $reqInsertItems = $bdd->prepare("INSERT INTO `items` (`user_id`,`room_id`,`item_id`,`wall_pos`,`x`,`y`,`z`,`rot`,`extra_data`,`wired_data`,`limited_data`,`guild_id`) 
                    VALUES (:userid,:roomid,154,'',6,13,0,0,'0','','0:0',0)
                    ,(:userid,:roomid,1912,'',7,8,0,0,'0','','0:0',0)
                    ,(:userid,:roomid,157,'',9,7,0,0,'0','','0:0',0)
                    ,(:userid,:roomid,157,'',7,4,0,0,'0','','0:0',0)");
                    $reqInsertItems->execute([
                        'userid' => $user['id'],
                        'roomid' => $roomId
                    ]);
                    break;
                case 3:
                    $reqCreateRoom = $bdd->prepare("INSERT INTO `rooms` (`owner_id`, `owner_name`, `name`,`description`,`model`,`password`,`state`,`users`,`users_max`,`guild_id`,`category`,`score`,`paper_floor`,`paper_wall`,`paper_landscape`,`thickness_wall`,`wall_height`,`thickness_floor`,`moodlight_data`,`tags`,`is_public`,`is_staff_picked`,`allow_other_pets`,`allow_other_pets_eat`,`allow_walkthrough`,`allow_hidewall`,`chat_mode`,`chat_weight`,`chat_speed`,`chat_hearing_distance`,`chat_protection`,`override_model`,`who_can_mute`,`who_can_kick`,`who_can_ban`,`poll_id`,`roller_speed`,`promoted`,`trade_mode`,`move_diagonally`,`jukebox_active`,`hidewired`,`is_forsale`,`trax_active`) VALUES (?, ?, ?,'','model_a','','open',1,10,0,9,0,'0.0','0.0','0.0',0,-1,0,'2,1,1,#000000,255;2,2,2,#000000,255;2,3,1,#000000,255;','','0','0','0','0','1','0',0,1,1,50,2,'0',0,0,0,0,4,'0',0,'1','0','0','0',0);");
                    $reqCreateRoom->execute([$user['id'], $user['username'], "Appart de " . $user['username']]);

                    $roomId = $bdd->lastInsertId();

                    $reqInsertItems = $bdd->prepare("INSERT INTO `items` (`user_id`,`room_id`,`item_id`,`wall_pos`,`x`,`y`,`z`,`rot`,`extra_data`,`wired_data`,`limited_data`,`guild_id`) 
                    VALUES (:userid,:roomid,154,'',6,13,0,0,'0','','0:0',0)
                    ,(:userid,:roomid,1912,'',7,8,0,0,'0','','0:0',0)
                    ,(:userid,:roomid,157,'',9,7,0,0,'0','','0:0',0)
                    ,(:userid,:roomid,157,'',7,4,0,0,'0','','0:0',0)");
                    $reqInsertItems->execute([
                        'userid' => $user['id'],
                        'roomid' => $roomId
                    ]);
                    break;
                case 4:
                    $reqCreateRoom = $bdd->prepare("INSERT INTO `rooms` (`owner_id`, `owner_name`, `name`,`description`,`model`,`password`,`state`,`users`,`users_max`,`guild_id`,`category`,`score`,`paper_floor`,`paper_wall`,`paper_landscape`,`thickness_wall`,`wall_height`,`thickness_floor`,`moodlight_data`,`tags`,`is_public`,`is_staff_picked`,`allow_other_pets`,`allow_other_pets_eat`,`allow_walkthrough`,`allow_hidewall`,`chat_mode`,`chat_weight`,`chat_speed`,`chat_hearing_distance`,`chat_protection`,`override_model`,`who_can_mute`,`who_can_kick`,`who_can_ban`,`poll_id`,`roller_speed`,`promoted`,`trade_mode`,`move_diagonally`,`jukebox_active`,`hidewired`,`is_forsale`,`trax_active`) VALUES (?, ?, ?,'','model_a','','open',1,10,0,9,0,'0.0','0.0','0.0',0,-1,0,'2,1,1,#000000,255;2,2,2,#000000,255;2,3,1,#000000,255;','','0','0','0','0','1','0',0,1,1,50,2,'0',0,0,0,0,4,'0',0,'1','0','0','0',0);");
                    $reqCreateRoom->execute([$user['id'], $user['username'], "Appart de " . $user['username']]);

                    $roomId = $bdd->lastInsertId();

                    $reqInsertItems = $bdd->prepare("INSERT INTO `items` (`user_id`,`room_id`,`item_id`,`wall_pos`,`x`,`y`,`z`,`rot`,`extra_data`,`wired_data`,`limited_data`,`guild_id`) 
                    VALUES (:userid,:roomid,154,'',6,13,0,0,'0','','0:0',0)
                    ,(:userid,:roomid,1912,'',7,8,0,0,'0','','0:0',0)
                    ,(:userid,:roomid,157,'',9,7,0,0,'0','','0:0',0)
                    ,(:userid,:roomid,157,'',7,4,0,0,'0','','0:0',0)");
                    $reqInsertItems->execute([
                        'userid' => $user['id'],
                        'roomid' => $roomId
                    ]);
                    break;
                case 5:
                    $reqCreateRoom = $bdd->prepare("INSERT INTO `rooms` (`owner_id`, `owner_name`, `name`,`description`,`model`,`password`,`state`,`users`,`users_max`,`guild_id`,`category`,`score`,`paper_floor`,`paper_wall`,`paper_landscape`,`thickness_wall`,`wall_height`,`thickness_floor`,`moodlight_data`,`tags`,`is_public`,`is_staff_picked`,`allow_other_pets`,`allow_other_pets_eat`,`allow_walkthrough`,`allow_hidewall`,`chat_mode`,`chat_weight`,`chat_speed`,`chat_hearing_distance`,`chat_protection`,`override_model`,`who_can_mute`,`who_can_kick`,`who_can_ban`,`poll_id`,`roller_speed`,`promoted`,`trade_mode`,`move_diagonally`,`jukebox_active`,`hidewired`,`is_forsale`,`trax_active`) VALUES (?, ?, ?,'','model_a','','open',1,10,0,9,0,'0.0','0.0','0.0',0,-1,0,'2,1,1,#000000,255;2,2,2,#000000,255;2,3,1,#000000,255;','','0','0','0','0','1','0',0,1,1,50,2,'0',0,0,0,0,4,'0',0,'1','0','0','0',0);");
                    $reqCreateRoom->execute([$user['id'], $user['username'], "Appart de " . $user['username']]);

                    $roomId = $bdd->lastInsertId();

                    $reqInsertItems = $bdd->prepare("INSERT INTO `items` (`user_id`,`room_id`,`item_id`,`wall_pos`,`x`,`y`,`z`,`rot`,`extra_data`,`wired_data`,`limited_data`,`guild_id`) 
                    VALUES (:userid,:roomid,154,'',6,13,0,0,'0','','0:0',0)
                    ,(:userid,:roomid,1912,'',7,8,0,0,'0','','0:0',0)
                    ,(:userid,:roomid,157,'',9,7,0,0,'0','','0:0',0)
                    ,(:userid,:roomid,157,'',7,4,0,0,'0','','0:0',0)");
                    $reqInsertItems->execute([
                        'userid' => $user['id'],
                        'roomid' => $roomId
                    ]);
                    break;
            }

            $reqNoob = $bdd->prepare("UPDATE users SET noob = 'Non' WHERE id = ?");
            $reqNoob->execute([$user['id']]);
            Redirect($url . "/client");
        } else {
            Redirect($url . "/moi");
        }
    }
}
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

                            <h2 class="title">Choisis ton appart gratuitement!
                            </h2>
                            <div id="roomselection-welcome-intro" class="box-content">
                                Choisis ton appart pour avoir des mobis gratuitement tous les jours !
                            </div>
                            <ul class="roomselection-welcome clearfix">
                                <li class="odd">
                                    <a class="roomselection-select new-button" href="starter_room?createRoom=0"><b>Sélectionner</b><i></i></a>
                                </li>
                                <li class="even">
                                    <a class="roomselection-select new-button" href="starter_room?createRoom=1"><b>Sélectionner</b><i></i></a>
                                </li>
                                <li class="odd">
                                    <a class="roomselection-select new-button" href="starter_room?createRoom=2"><b>Sélectionner</b><i></i></a>
                                </li>
                                <li class="even">
                                    <a class="roomselection-select new-button" href="starter_room?createRoom=3"><b>Sélectionner</b><i></i></a>
                                </li>
                                <li class="odd">
                                    <a class="roomselection-select new-button" href="starter_room?createRoom=4"><b>Sélectionner</b><i></i></a>
                                </li>
                                <li class="even">
                                    <a class="roomselection-select new-button" href="starter_room?createRoom=5"><b>Sélectionner</b><i></i></a>
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

                        <div style="background-color:white !important" class="cbb clearfix lightgreen">

                            <div class="welcome-intro clearfix">
                                <img alt="Prince-Cutie9" src="https://avatar.myhabbo.fr/?figure=<?php echo $user['look']; ?>&size=b&action=crr=667&direction=3&head_direction=3&gesture=srp
                                    " width="64" height="110" class="welcome-habbo" />
                                <div style="padding-bottom:5px !important;text-align:center" id="welcome-intro-welcome-user"><?php echo $user['username']; ?>,
                                    bienvenue <?php echo $sitename; ?>!
                                </div>
                                <div style="padding-top:0 !important;text-align:center" id="welcome-intro-welcome-party" class="box-content">Choisis ton appart et deviens officiellement propriétaire de ton
                                    premier appart !
                                </div>
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
                                <div id="welcome-shockwave-text"><?php echo $sitename; ?> a investi dans une techologie de
                                    pointe, qui te permets de profiter d'un Habbo OldSchool sans Shockwave
                                </div>
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