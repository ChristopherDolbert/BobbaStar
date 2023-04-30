<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("./config.php");
$pagename = "Accueil";
$pageid = "accueil";

if (!isset($_SESSION['username'])) {
    Redirect("" . $url . "/index");
    exit;
}

$sql = $bdd->query("SELECT * FROM gabcms_config WHERE id = '1'");
$cof = $sql->fetch(PDO::FETCH_ASSOC);

$stmt = $bdd->prepare("SELECT COUNT(*) FROM cms_minimail WHERE to_id = ?");
$stmt->execute([$user['id']]);
$messages = $stmt->fetchColumn();
header("X-JSON: {\"totalMessages\":" . $messages . "}");

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
    <script src="<?PHP echo $imagepath; ?>js/tooltip.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/common.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>static/styles/lightweightmepage.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
    <script src="<?PHP echo $imagepath; ?>static/js/lightweightmepage.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/fullcontent.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/style.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/buttons.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/boxes.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/tooltips.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/personal.css<?php echo '?' . mt_rand(); ?>" type="text/css" />

    <meta name="description" content="<?PHP echo $description; ?>" />
    <meta name="keywords" content="<?PHP echo $keyword; ?>" />
    <meta name="build" content="<?PHP echo $build; ?> >> <?PHP echo $version; ?>" />
</head>

<body id="home" class=" ">
    <div id="tooltip"></div>
    <div id="overlay"></div>
    <!-- MENU -->
    <?PHP include("./template/header.php"); ?>
    <!-- FIN MENU -->
    <div id="container">
        <div id="content" style="position: relative" class="clearfix">
            <div id="column1" class="column">
                <div id="wide-personal-info">

                    <div id="habbo-plate">
                        <a href="<?PHP echo $url; ?>/info">
                            <img src="<?php echo $avatarimage; ?><?php echo $user['look']; ?>">
                        </a>
                    </div>

                    <div id="name-box" class="info-box">
                        <div class="label">Pseudo :</div>
                        <div class="content"><?PHP echo $user['username']; ?></div>
                    </div>
                    <div id="motto-box" class="info-box">
                        <div class="label">Mission :</div>
                        <div class="content">
                            <?PHP
                            if (empty($user['motto'])) {
                                echo "Pas de mission";
                            } else {
                                echo Secu($user['motto']);
                            }
                            ?>
                        </div>
                    </div>
                    <div id="last-logged-in-box" class="info-box">
                        <div class="label">Dernière connexion:</div>
                        <div class="content"><?PHP $connexion = date('d/m/Y H:i:s', $user['last_online']);
                                                echo $connexion; ?></div>
                    </div>

                    <?PHP if ($cof['etat_client'] == '1' || $cof['etat_client'] == '3' && $cof['si3_debut'] < $nowtime && $cof['si3_fin'] < $nowtime) { ?>
                        <div class="enter-hotel-btn">
                            <div class="open enter-btn">
                                <a href="<?PHP echo $url ?>/client" onclick="openOrFocusHabbo(this); return false;" target="client">ENTRER DANS L'H&Ocirc;TEL<i></i></a>
                                <b></b>
                            </div>
                        </div>
                    <?PHP } elseif ($cof['etat_client'] == '2') { ?>
                        <div class="enter-hotel-btn">
                            <div class="closed enter-btn">
                                <span>L'H&Ocirc;TEL EST FERM&Eacute;</span>
                                <b></b>
                            </div>
                        </div>
                    <?PHP } elseif ($cof['etat_client'] == '3' && $cof['si3_debut'] <= $nowtime && $cof['si3_fin'] >= $nowtime) { ?>
                        <div class="enter-hotel-btn">
                            <div class="closed enter-btn">
                                <span>L'H&Ocirc;TEL EST FERM&Eacute;</span>
                                <b></b>
                            </div>
                        </div>
                    <?PHP } ?>
                </div>

                <div style="clear:both;"></div>
                <div id="promo-box">
                    <div id="promo-bullets"></div>
                    <?PHP
                    $sql = $bdd->query("SELECT * FROM gabcms_news ORDER BY -id LIMIT 0," . $cof['nb_news'] . "");
                    $c = 0;
                    while ($news = $sql->fetch()) {
                        $c++;
                    ?>
                        <div class="promo-container" style="<?php if ($c != 1) {
                                                                echo "display: none; ";
                                                            } ?> background-image: url(<?PHP echo $news['topstory_image']; ?>);">
                            <div class="promo-content">
                                <div class="title"><?PHP echo stripslashes($news['title']); ?></div>
                                <div class="body"><?PHP echo stripslashes($news['snippet']); ?></div>

                                <?PHP if ($news['event'] == 1) { ?><div class="promo-link-container">
                                        <div class="enter-hotel-btn">
                                            <div class="open enter-btn">
                                                <a style="padding: 0 8px 0 19px;" href="<?PHP echo $url ?>/articles?id=<?PHP echo $news['id']; ?>"><?PHP echo $news['info']; ?></a><b></b>

                                            </div>
                                        </div>
                                    </div><?PHP } ?>
                                <?PHP if ($news['event'] == 2) { ?><div class="promo-link-container">
                                        <div class="enter-hotel-btn">
                                            <div class="open enter-btn">
                                                <a style="padding: 0 8px 0 19px;" href="<?PHP echo $news['lien_event']; ?>"><?PHP echo $news['info']; ?></a><b></b>

                                            </div>
                                        </div>
                                    </div><?PHP } ?>
                            </div>
                        </div>
                    <?PHP } ?>
                    <script type="text/javascript">
                        document.observe("dom:loaded", function() {
                            PromoSlideShow.init();
                        });
                    </script>
                </div>
            </div>

        </div>
        <div id="content" style="position: relative" class="clearfix">
            <div id="column1" class="column">
                <div class="habblet-container ">
                    <div class="cbb clearfix green">
                        <h2 class="title">Flux</h2>

                        <div class="box-content">
                            <style>
                                table {
                                    background-color: #fff;
                                    font-size: 11px;
                                    padding: 4px;
                                    margin-left: -14px;
                                    width: 107%;
                                }

                                table:nth-child(2n+1) {
                                    background-color: #fffcaf;
                                    font-size: 11px;
                                    padding: 4px;
                                    margin-left: -14px;
                                    width: 107%;
                                }
                            </style>
                            <?php
                            $sql = $bdd->prepare("SELECT * FROM gabcms_management WHERE user_id = :userid ORDER BY id DESC LIMIT 0," . $cof['nb_flux'] . "");
                            $sql->bindValue(':userid', $user['id']);
                            $sql->execute();
                            $i = 1;
                            while ($a = $sql->fetch()) {
                            ?>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td valign="middle" width="10" height="60">
                                                <?PHP if ($a['auteur'] != 'Système') { ?><a href="<?PHP echo $url ?>/info?pseudo=<?PHP echo $a['auteur'] ?>" title="Aller sur son profil &raquo;" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)"><?PHP } ?><div style="width: 64px; height: 65px; margin-bottom:-15px; margin-top:-5px; margin-left: -5px; float: right; background: url(<?php echo $avatarimage; ?><?PHP echo $a['look'] ?>&action=wav&direction=2&head_direction=2&gesture=sml&size=big&img_format=gif);"></div></a>
                                            </td>
                                            <td valign="top">
                                                <span style="color:#333333;"><b style="font-size: 110%;"><?PHP echo $a['auteur'] ?></span></b><span style="float: right; color:#000000;"><?PHP echo $a['date'] ?></span><br />
                                                <span style="color:#000000"><?PHP echo $a['message'] ?></span><br />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            <?PHP } ?>
                            <br />Tu peux voir tous tes autres flux en <a href="<?PHP echo $url; ?>/flux">cliquant ici</a>
                        </div>
                    </div>
                </div>

                <div class="habblet-container minimail" id="mail">
                    <div class="cbb clearfix blue ">

                        <h2 class="title">Mes Messages
                        </h2>
                        <div id="minimail">
                            <div class="minimail-contents">
                                <?php
                                $bypass = true;
                                $page = "inbox";
                                include('./minimail/loadMessage.php');
                                ?>
                            </div>
                            <div id="message-compose-wait"></div>
                            <form style="display: none" id="message-compose">
                                <div>To</div>
                                <div id="message-recipients-container" class="input-text" style="width: 426px; margin-bottom: 1em">
                                    <input type="text" value="" id="message-recipients" />
                                    <div class="autocomplete" id="message-recipients-auto">
                                        <div class="default" style="display: none;">Tape le nom de ton ami:</div>
                                        <ul class="feed" style="display: none;"></ul>

                                    </div>
                                </div>
                                <div>Subject<br />
                                    <input type="text" style="margin: 5px 0" id="message-subject" class="message-text" maxlength="100" tabindex="2" />
                                </div>
                                <div>Message<br />
                                    <textarea style="margin: 5px 0" rows="5" cols="10" id="message-body" class="message-text" tabindex="3"></textarea>

                                </div>
                                <div class="new-buttons clearfix">
                                    <a href="#" class="new-button preview"><b>Pr&eacute;voir</b><i></i></a>
                                    <a href="#" class="new-button send"><b>Envoyer</b><i></i></a>
                                </div>
                            </form>
                        </div>
                        <?php
                        $stmt = $bdd->prepare("SELECT * FROM messenger_friendships WHERE user_one_id = :my_id OR user_two_id = :my_id");
                        $stmt->bindParam(':my_id', $my_id);
                        $stmt->execute();
                        $count = $stmt->rowCount();

                        $stmt = $bdd->prepare("SELECT * FROM cms_minimail WHERE to_id = :my_id OR senderid = :my_id");
                        $stmt->bindParam(':my_id', $my_id);
                        $stmt->execute();
                        $mescount = $stmt->rowCount();

                        ?>
                        <script type="text/javascript">
                            L10N.put("minimail.compose", "Compose").put("minimail.cancel", "Quitter")
                                .put("bbcode.colors.red", "Red").put("bbcode.colors.orange", "Orange")
                                .put("bbcode.colors.yellow", "Yellow").put("bbcode.colors.green", "Green")
                                .put("bbcode.colors.cyan", "Cyan").put("bbcode.colors.blue", "Blue")
                                .put("bbcode.colors.gray", "Gray").put("bbcode.colors.black", "Black")
                                .put("minimail.empty_body.confirm", "Are you sure you want to send the message with an empty body?")
                                .put("bbcode.colors.label", "Color").put("linktool.find.label", " ")
                                .put("linktool.scope.habbos", "<?php echo $shortname; ?>s").put("linktool.scope.rooms", "Rooms")
                                .put("linktool.scope.groups", "Groups").put("minimail.report.title", "Report message to moderators");

                            L10N.put("date.pretty.just_now", "just now");
                            L10N.put("date.pretty.one_minute_ago", "1 minute ago");
                            L10N.put("date.pretty.minutes_ago", "{0} minutes ago");
                            L10N.put("date.pretty.one_hour_ago", "1 hour ago");
                            L10N.put("date.pretty.hours_ago", "{0} hours ago");
                            L10N.put("date.pretty.yesterday", "yesterday");
                            L10N.put("date.pretty.days_ago", "{0} days ago");
                            L10N.put("date.pretty.one_week_ago", "1 week ago");
                            L10N.put("date.pretty.weeks_ago", "{0} weeks ago");
                            new MiniMail({
                                pageSize: 10,
                                total: <?php echo $mescount; ?>,
                                friendCount: <?php echo $count; ?>,
                                maxRecipients: 50,
                                messageMaxLength: 20,
                                bodyMaxLength: 4096,
                                secondLevel: <?php if ($count = 0) {
                                                    echo "true";
                                                } else {
                                                    echo "false";
                                                } ?>
                            });
                        </script>
                    </div>
                </div>


                <script type="text/javascript">
                    if (!$(document.body).hasClassName('process-template')) {
                        Rounder.init();
                    }
                </script>

            </div>
            <script type="text/javascript">
                if (!$(document.body).hasClassName('process-template')) {
                    Rounder.init();
                }
            </script>
            <div id="column2" class="column">
                <div class="habblet-container ">
                    <div class="cbb clearfix brown">
                        <h2 class="title">Météo dans votre ville</h2>
                        <div class="box-content">
                            <?php
                            if (isset($_POST['location'])) {
                                $location = $_POST['location'];
                                if (!empty($location)) {
                                    $json = file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=$location&units=metric&appid=bbd6317faa550a56ecd096a66c8f78b2");
                                    $data = json_decode($json, true);
                                    if (isset($data['cod']) && $data['cod'] == 200) {
                                        $location = $data['name'] . ', ' . $data['sys']['country'];
                                        $weather = $data['weather'][0]['main'] . ' (' . $data['main']['temp'] . '°C)';
                                        echo "<p>$location</p>";
                                        echo "<p>$weather</p>";
                                    } else {
                                        echo "<p>Impossible de trouver la ville '$location'.</p>";
                                    }
                                } else {
                                    echo '<form method="post" action="" id="location-form"><input type="hidden" name="lat" id="lat"><input type="hidden" name="lon" id="lon"><input type="text" name="location" placeholder="Entrez une ville"><input type="submit" value="Rechercher"></form>';
                                }
                            } else {
                                // Demander l'accès à la localisation de l'utilisateur
                                echo '<script>if ("geolocation" in navigator) { navigator.geolocation.getCurrentPosition(function(position) { document.getElementById("lat").value = position.coords.latitude; document.getElementById("lon").value = position.coords.longitude; document.getElementById("location-form").submit(); }); }</script>';
                                // Récupérer la position géographique de l'utilisateur
                                if (isset($_POST['lat']) && isset($_POST['lon'])) {
                                    $lat = $_POST['lat'];
                                    $lon = $_POST['lon'];
                                    $json = file_get_contents("https://api.openweathermap.org/data/2.5/weather?lat=$lat&lon=$lon&units=metric&appid=bbd6317faa550a56ecd096a66c8f78b2");
                                    $data = json_decode($json, true);
                                    if (isset($data['cod']) && $data['cod'] == 200) {
                                        $location = $data['name'] . ', ' . $data['sys']['country'];
                                        $weather = $data['weather'][0]['main'] . ' (' . $data['main']['temp'] . '°C)';
                                        echo "<p>$location</p>";
                                        echo "<p>$weather</p>";
                                    } else {
                                        echo "<p>Impossible de récupérer les prévisions météorologiques pour cette ville.</p>";
                                    }
                                } else {
                                    echo "<p>Impossible de détecter la ville actuelle.</p>";
                                }
                                // Formulaire pour rechercher une ville
                                echo '<form method="post" action="" id="location-form"><input type="hidden" name="lat" id="lat"><input type="hidden" name="lon" id="lon"><input type="text" name="location" placeholder="Entrez une ville"><input type="submit" value="Rechercher"></form>';
                            }
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
        </div>

        <script type="text/javascript">
            HabboView.run();
        </script>
        <!--[if lt IE 7]>
<script type="text/javascript">
Pngfix.doPngImageFix();
</script>
<![endif]-->
        <!-- FOOTER -->
        <?PHP include("./template/footer.php"); ?>
        <!-- FIN FOOTER -->