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
}
$sql = $bdd->query("SELECT * FROM gabcms_config WHERE id = '1'");
$cof = $sql->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Retro: Home </title>

    <script type="text/javascript">
        var andSoItBegins = (new Date()).getTime();
    </script>
    <link rel="shortcut icon" href="<?PHP echo $imagepath; ?>v2/favicon.ico" type="image/vnd.microsoft.icon" />
    <link rel="alternate" type="application/rss+xml" title="Retro: RSS" href="<?PHP echo $url; ?>/articles/rss.xml" />
    <script src="<?PHP echo $imagepath; ?>static/js/libs2.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/visual.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/libs.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/common.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/fullcontent.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/style.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/buttons.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/boxes.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/tooltips.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>styles/local/com.css<?php echo '?'.mt_rand(); ?>" type="text/css" />

    <script src="<?PHP echo $imagepath; ?>js/local/com.js" type="text/javascript"></script>

    <script type="text/javascript">
        document.habboLoggedIn = true;
        var habboName = "Testeur";
        var ad_keywords = "";
        var habboReqPath = "<?PHP echo $url; ?>";
        var habboStaticFilePath = "<?PHP echo $url; ?>/web-gallery";
        var habboImagerUrl = "<?PHP echo $url; ?>/habbo-imaging/";
        var habboPartner = "";
        window.name = "habboMain";
        if (typeof HabboClient != "undefined") {
            HabboClient.windowName = "client";
        }
    </script>

    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/personal2.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
    <script src="<?PHP echo $imagepath; ?>static/js/habboclub.js" type="text/javascript"></script>

    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/minimail.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>styles/myhabbo/control.textarea.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
    <script src="<?PHP echo $imagepath; ?>static/js/minimail.js" type="text/javascript"></script>


    <meta name="description" content="Join the world's largest virtual hangout where you can meet and make friends. Design your own rooms, collect cool furniture, throw parties and so much more! Create your FREE Retro today!" />
    <meta name="keywords" content="Retro, virtual, world, join, groups, forums, play, games, online, friends, teens, collecting, social network, create, collect, connect, furniture, virtual, goods, sharing, badges, social, networking, hangout, safe, music, celebrity, celebrity visits, cele" />

    <!--[if IE 8]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/ie8.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<![endif]-->
    <!--[if lt IE 8]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/ie.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<![endif]-->
    <!--[if lt IE 7]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/ie6.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<script src="<?PHP echo $imagepath; ?>static/js/pngfix.js" type="text/javascript"></script>
<script type="text/javascript">
try { document.execCommand('BackgroundImageCache', false, true); } catch(e) {}
</script>

<style type="text/css">
body { behavior: url(<?PHP echo $imagepath; ?>js/csshover.htc); }
</style>
<![endif]-->
    <meta name="build" content="PHPRetro 4.0.10 BETA" />
</head>

<body id="home" class=" ">
    <div id="tooltip"></div>
    <div id="overlay"></div>
    <!-- MENU -->
    <?PHP include("./template/header.php"); ?>
    <!-- FIN MENU -->


    <div id="container">
        <div id="content">
            <div id="column1" class="column">
                <div class="habblet-container ">

                    <div id="new-personal-info" style="background-image:url(<?PHP echo $imagepath; ?>v2/images/personal_info/hotel_views/htlview_fr.png)">
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

                        <div id="habbo-plate">
                            <a href="<?PHP echo $url; ?>/profile">
                                <img alt="<?PHP echo $user['username']; ?>" src="<?php echo $avatarimage; ?><?PHP echo $user['look']; ?>" width="64" height="110">
                            </a>
                        </div>

                        <div id="habbo-info">
                            <div id="motto-container" class="clearfix">
                                <strong><?PHP echo $user['username']; ?>:</strong>
                                <div style="width: 246px;">
                                    <span title="<?PHP echo $user['motto']; ?>"><?PHP echo $user['motto']; ?></span>
                                    <p style="display: none"><input type="text" length="30" name="motto" value="" style="width: 243px;"></p>
                                </div>
                            </div>
                            <div id="motto-links" style="display: none"><a href="#" id="motto-cancel">Cancel</a></div>
                        </div>

                        <ul id="link-bar" class="clearfix">
                            <li class="change-looks"><a href="<?PHP echo $url; ?>/profile">Change looks »</a></li>
                            <li class="credits">
                                <a href="<?PHP echo $url; ?>/credits"><?PHP echo $user['credits']; ?></a> Credits
                            </li>
                            <li class="activitypoints">
                                <a href="<?PHP echo $url; ?>/credits/pixels"><?PHP echo $user['pixels']; ?></a> Pixels
                            </li>
                        </ul>

                        <div id="habbo-feed">
                            <ul id="feed-items">


                                <li class="small" id="feed-lastlogin">Dernière connexion : <?PHP $connexion = date('d/m/Y', $user['last_online']);
                                                                                            echo $connexion; ?></li>


                            </ul>
                        </div>
                        <p class="last"></p>
                    </div>

                    <script type="text/javascript">
                        HabboView.add(function() {
                            L10N.put("personal_info.motto_editor.spamming", "Don\'t spam me, bro!");
                            PersonalInfo.init("");
                        });
                    </script>


                </div>
                <script type="text/javascript">
                    if (!$(document.body).hasClassName('process-template')) {
                        Rounder.init();
                    }
                </script>

                <div class="habblet-container ">
                    <div class="cb clearfix orange ">
                        <div class="bt">
                            <div></div>
                        </div>
                        <div class="i1">
                            <div class="i2">
                                <div class="i3">


                                    <div class="rounded-container">
                                        <div style="background-color: rgb(255, 255, 255);">
                                            <div style="margin: 0px 1px; height: 1px; overflow: hidden; background-color: rgb(255, 255, 255);">
                                                <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(249, 150, 85);">
                                                    <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(247, 108, 16);">
                                                        <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(246, 98, 0);"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div style="margin: 0px; height: 1px; overflow: hidden; background-color: rgb(255, 255, 255);">
                                                <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(247, 108, 16);">
                                                    <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(246, 98, 0);"></div>
                                                </div>
                                            </div>
                                            <div style="margin: 0px; height: 1px; overflow: hidden; background-color: rgb(249, 150, 85);">
                                                <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(246, 98, 0);"></div>
                                            </div>
                                            <div style="margin: 0px; height: 1px; overflow: hidden; background-color: rgb(247, 108, 16);">
                                                <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(246, 98, 0);"></div>
                                            </div>
                                        </div>
                                        <h2 class="title rounded-done">Hot Campaigns </h2>
                                        <div style="background-color: rgb(255, 255, 255);">
                                            <div style="margin: 0px; height: 1px; overflow: hidden; background-color: rgb(247, 108, 16);">
                                                <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(246, 98, 0);"></div>
                                            </div>
                                            <div style="margin: 0px; height: 1px; overflow: hidden; background-color: rgb(249, 150, 85);">
                                                <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(246, 98, 0);"></div>
                                            </div>
                                            <div style="margin: 0px; height: 1px; overflow: hidden; background-color: rgb(255, 255, 255);">
                                                <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(247, 108, 16);">
                                                    <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(246, 98, 0);"></div>
                                                </div>
                                            </div>
                                            <div style="margin: 0px 1px; height: 1px; overflow: hidden; background-color: rgb(255, 255, 255);">
                                                <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(249, 150, 85);">
                                                    <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(247, 108, 16);">
                                                        <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(246, 98, 0);"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="hotcampaigns-habblet-list-container">
                                        <ul id="hotcampaigns-habblet-list">

                                            <li class="even">
                                                <div class="hotcampaign-container">
                                                    <a href="http://code.google.com/p/phpretro/issues/list"><img src="http://images.habbohotel.co.uk/c_images/hot_campaign_images_gb/uk_newsletter_160x70.gif" align="left" alt=""></a>
                                                    <h3>Found a bug?</h3>
                                                    <p>Submit it to our Google Codes page!</p>

                                                    <p class="link"><a href="http://code.google.com/p/phpretro/issues/list">Go there »</a></p>
                                                </div>
                                            </li>


                                            <li class="odd">
                                                <div class="hotcampaign-container">
                                                    <a href="<?PHP echo $url; ?>/articles"><img src="http://images.habbohotel.co.uk/c_images/hot_campaign_images_gb/easter_160x60.gif" align="left" alt=""></a>
                                                    <h3>News</h3>
                                                    <p>See the latest news in our hotel.</p>

                                                    <p class="link"><a href="<?PHP echo $url; ?>/articles">Go there »</a></p>
                                                </div>
                                            </li>


                                            <li class="even">
                                                <div class="hotcampaign-container">
                                                    <a href="<?PHP echo $url; ?>/housekeeping/"><img src="http://images.habbohotel.co.uk/c_images/hot_campaign_images_gb/cb_country_160x60.gif" align="left" alt=""></a>
                                                    <h3>Please change</h3>
                                                    <p>These are sample campaigns, please edit them via housekeeping.</p>

                                                    <p class="link"><a href="<?PHP echo $url; ?>/housekeeping/">Go there »</a></p>
                                                </div>
                                            </li>

                                        </ul>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="bb">
                            <div></div>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    if (!$(document.body).hasClassName('process-template')) {
                        Rounder.init();
                    }
                </script>

                <div class="habblet-container minimail" id="mail">
                    <div class="cb clearfix blue ">
                        <div class="bt">
                            <div></div>
                        </div>
                        <div class="i1">
                            <div class="i2">
                                <div class="i3">

                                    <div class="rounded-container">
                                        <div style="background-color: rgb(255, 255, 255);">
                                            <div style="margin: 0px 1px; height: 1px; overflow: hidden; background-color: rgb(255, 255, 255);">
                                                <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(141, 190, 232);">
                                                    <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(96, 164, 222);">
                                                        <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(85, 158, 220);"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div style="margin: 0px; height: 1px; overflow: hidden; background-color: rgb(255, 255, 255);">
                                                <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(96, 164, 222);">
                                                    <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(85, 158, 220);"></div>
                                                </div>
                                            </div>
                                            <div style="margin: 0px; height: 1px; overflow: hidden; background-color: rgb(141, 190, 232);">
                                                <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(85, 158, 220);"></div>
                                            </div>
                                            <div style="margin: 0px; height: 1px; overflow: hidden; background-color: rgb(96, 164, 222);">
                                                <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(85, 158, 220);"></div>
                                            </div>
                                        </div>
                                        <h2 class="title rounded-done">My Messages </h2>
                                        <div style="background-color: rgb(255, 255, 255);">
                                            <div style="margin: 0px; height: 1px; overflow: hidden; background-color: rgb(96, 164, 222);">
                                                <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(85, 158, 220);"></div>
                                            </div>
                                            <div style="margin: 0px; height: 1px; overflow: hidden; background-color: rgb(141, 190, 232);">
                                                <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(85, 158, 220);"></div>
                                            </div>
                                            <div style="margin: 0px; height: 1px; overflow: hidden; background-color: rgb(255, 255, 255);">
                                                <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(96, 164, 222);">
                                                    <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(85, 158, 220);"></div>
                                                </div>
                                            </div>
                                            <div style="margin: 0px 1px; height: 1px; overflow: hidden; background-color: rgb(255, 255, 255);">
                                                <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(141, 190, 232);">
                                                    <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(96, 164, 222);">
                                                        <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(85, 158, 220);"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="minimail" class="second-level-auth">
                                        <div class="minimail-contents">
                                            <a href="#" class="new-button compose"><b>Compose</b><i></i></a>
                                            <div class="clearfix labels nostandard">
                                                <ul class="box-tabs">
                                                    <li class="selected"><a href="#" label="inbox">Inbox</a><span class="tab-spacer"></span></li>
                                                    <li><a href="#" label="sent">Sent</a><span class="tab-spacer"></span></li>
                                                    <li><a href="#" label="trash">Trash</a><span class="tab-spacer"></span></li>
                                                </ul>

                                            </div>
                                            <div id="message-list" class="label-inbox">
                                                <div class="new-buttons clearfix">
                                                    <div class="labels inbox-refresh"><a href="#" class="new-button green-button" label="inbox" style="float: left; margin: 0"><b>Refresh</b><i></i></a></div>
                                                </div>

                                                <div style="clear: both; height: 1px"></div>
                                                <div class="navigation">
                                                    <div class="unread-selector"><input type="checkbox" class="unread-only"> only unread</div>
                                                    <p class="no-messages">
                                                        No messages </p>
                                                    <div class="progress"></div>
                                                </div>


                                                <div class="navigation">
                                                    <div class="progress"></div>

                                                </div>

                                            </div>
                                        </div>
                                        <div id="message-compose-wait"></div>
                                        <form style="display: none" id="message-compose">
                                            <div>To</div>
                                            <div id="message-recipients-container" class="input-text" style="width: 426px; margin-bottom: 1em">
                                                <input type="text" value="" id="message-recipients">
                                                <div class="autocomplete" id="message-recipients-auto">
                                                    <div class="default" style="display: none;">Type the name of your friend</div>
                                                    <ul class="feed" style="display: none;"></ul>

                                                </div>
                                            </div>
                                            <div>Subject<br>
                                                <input type="text" style="margin: 5px 0" id="message-subject" class="message-text" maxlength="100" tabindex="2">
                                            </div>
                                            <div>Message<br>
                                                <textarea style="margin: 5px 0" rows="5" cols="10" id="message-body" class="message-text" tabindex="3"></textarea>

                                            </div>
                                            <div class="new-buttons clearfix">
                                                <a href="#" class="new-button preview"><b>Preview</b><i></i></a>
                                                <a href="#" class="new-button send"><b>Send</b><i></i></a>
                                            </div>
                                        </form>
                                    </div>
                                    <script type="text/javascript">
                                        L10N.put("minimail.compose", "Compose").put("minimail.cancel", "Cancel")
                                            .put("bbcode.colors.red", "Red").put("bbcode.colors.orange", "Orange")
                                            .put("bbcode.colors.yellow", "Yellow").put("bbcode.colors.green", "Green")
                                            .put("bbcode.colors.cyan", "Cyan").put("bbcode.colors.blue", "Blue")
                                            .put("bbcode.colors.gray", "Gray").put("bbcode.colors.black", "Black")
                                            .put("minimail.empty_body.confirm", "Are you sure you want to send the message with an empty body?")
                                            .put("bbcode.colors.label", "Color").put("linktool.find.label", " ")
                                            .put("linktool.scope.habbos", "Retros").put("linktool.scope.rooms", "Rooms")
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
                                            total: 0,
                                            friendCount: 0,
                                            maxRecipients: 50,
                                            messageMaxLength: 20,
                                            bodyMaxLength: 4096,
                                            secondLevel: true
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                        <div class="bb">
                            <div></div>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    if (!$(document.body).hasClassName('process-template')) {
                        Rounder.init();
                    }
                </script>

                <div class="habblet-container ">
                    <div class="cb clearfix default ">
                        <div class="bt">
                            <div></div>
                        </div>
                        <div class="i1">
                            <div class="i2">
                                <div class="i3">
                                    <div class="box-tabs-container clearfix">
                                        <h2>Retros</h2>
                                        <ul class="box-tabs">
                                            <li id="tab-0-4-1"><a href="#">Search Retros</a><span class="tab-spacer"></span></li>

                                            <li id="tab-0-4-2" class="selected"><a href="#">Invite Friend(s)</a><span class="tab-spacer"></span></li>
                                        </ul>
                                    </div>
                                    <div id="tab-0-4-1-content" style="display: none">
                                        <div class="habblet-content-info">
                                            <a name="habbo-search">Type in the first characters of the name to search for other Retros.</a>
                                        </div>
                                        <div id="habbo-search-error-container" style="display: none;">
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
                                                <div id="habbo-search-error" class="rounded-red rounded-done"></div>
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
                                        <br clear="all">
                                        <div id="avatar-habblet-list-search">
                                            <input type="text" id="avatar-habblet-search-string">

                                            <a href="#" id="avatar-habblet-search-button" class="new-button"><b>Search</b><i></i></a>
                                        </div>

                                        <br clear="all">

                                        <div id="avatar-habblet-content">
                                            <div id="avatar-habblet-list-container" class="habblet-list-container">
                                                <ul class="habblet-list">
                                                </ul>

                                            </div>
                                            <script type="text/javascript">
                                                L10N.put("habblet.search.error.search_string_too_long", "The search keyword was too long. Maximum length is 30 characters.");
                                                L10N.put("habblet.search.error.search_string_too_short", "The search keyword was too short. 2 characters required.");
                                                L10N.put("habblet.search.add_friend.title", "Add to friend list");
                                                new HabboSearchHabblet(2, 30);
                                            </script>

                                        </div>

                                        <script type="text/javascript">
                                            Rounder.addCorners($("habbo-search-error"), 8, 8);
                                        </script>
                                    </div>
                                    <div id="tab-0-4-2-content">
                                        <div id="friend-invitation-habblet-container" class="box-content">
                                            <div style="display: none">
                                                <div id="invitation-form" class="clearfix">
                                                    <textarea name="invitation_message" id="invitation_message" class="invitation-message">Come and hangout with me in Retro.- Testeur</textarea>
                                                    <div id="invitation-email">
                                                        <div class="invitation-input">1.<input onkeypress="$('invitation_recipient2').enable()" type="text" name="invitation_recipients" id="invitation_recipient1" value="Friend's email address:" class="invitation-input">

                                                        </div>
                                                        <div class="invitation-input">2.<input disabled="" onkeypress="$('invitation_recipient3').enable()" type="text" name="invitation_recipients" id="invitation_recipient2" value="Friend's email address:" class="invitation-input">
                                                        </div>
                                                        <div class="invitation-input">3.<input disabled="" type="text" name="invitation_recipients" id="invitation_recipient3" value="Friend's email address:" class="invitation-input">
                                                        </div>
                                                    </div>
                                                    <div class="clear"></div>
                                                    <div class="fielderror" id="invitation_message_error" style="display: none;">
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
                                                            <div class="rounded-done"></div>
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

                                                <div class="invitation-buttons clearfix" id="invitation_buttons">
                                                    <a class="new-button" id="send-friend-invite-button" href="#"><b>Invite Friend(s)</b><i></i></a>
                                                </div>

                                                <hr>
                                            </div>
                                            <div id="invitation-link-container">
                                                <h3>Enjoy Retro more with real life friends!</h3>

                                                <div class="copytext">
                                                    <p>Invite your friends to Retro and earn cool rewards! Send a link to your friend and ask them to register and activate their email. If they are using Retro in active way you get rewarded with 1000 coins.</p>
                                                </div>
                                                <div class="invitation-buttons clearfix">
                                                    <a class="new-button" id="getlink-friend-invite-button" href="#"><b>Click for the invitation link!</b><i></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <script type="text/javascript">
                                            L10N.put("invitation.button.invite", "Invite Friend(s)");
                                            L10N.put("invitation.form.recipient", "Friend's email address:");
                                            L10N.put("invitation.error.message_too_long", "invitation.error.message_limit");
                                            inviteFriendHabblet = new InviteFriendHabblet(500);
                                            $("friend-invitation-habblet-container").select(".fielderror .rounded").each(function(el) {
                                                Rounder.addCorners(el, 8, 8);
                                            });
                                        </script>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="bb">
                            <div></div>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    if (!$(document.body).hasClassName('process-template')) {
                        Rounder.init();
                    }
                </script>

                <div class="habblet-container ">
                    <div class="cb clearfix darkred ">
                        <div class="bt">
                            <div></div>
                        </div>
                        <div class="i1">
                            <div class="i2">
                                <div class="i3">

                                    <div class="rounded-container">
                                        <div style="background-color: rgb(255, 255, 255);">
                                            <div style="margin: 0px 1px; height: 1px; overflow: hidden; background-color: rgb(255, 255, 255);">
                                                <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(218, 125, 125);">
                                                    <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(203, 72, 72);">
                                                        <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(199, 60, 60);"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div style="margin: 0px; height: 1px; overflow: hidden; background-color: rgb(255, 255, 255);">
                                                <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(203, 72, 72);">
                                                    <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(199, 60, 60);"></div>
                                                </div>
                                            </div>
                                            <div style="margin: 0px; height: 1px; overflow: hidden; background-color: rgb(218, 125, 125);">
                                                <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(199, 60, 60);"></div>
                                            </div>
                                            <div style="margin: 0px; height: 1px; overflow: hidden; background-color: rgb(203, 72, 72);">
                                                <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(199, 60, 60);"></div>
                                            </div>
                                        </div>
                                        <h2 class="title rounded-done">Events </h2>
                                        <div style="background-color: rgb(255, 255, 255);">
                                            <div style="margin: 0px; height: 1px; overflow: hidden; background-color: rgb(203, 72, 72);">
                                                <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(199, 60, 60);"></div>
                                            </div>
                                            <div style="margin: 0px; height: 1px; overflow: hidden; background-color: rgb(218, 125, 125);">
                                                <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(199, 60, 60);"></div>
                                            </div>
                                            <div style="margin: 0px; height: 1px; overflow: hidden; background-color: rgb(255, 255, 255);">
                                                <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(203, 72, 72);">
                                                    <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(199, 60, 60);"></div>
                                                </div>
                                            </div>
                                            <div style="margin: 0px 1px; height: 1px; overflow: hidden; background-color: rgb(255, 255, 255);">
                                                <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(218, 125, 125);">
                                                    <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(203, 72, 72);">
                                                        <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(199, 60, 60);"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="current-events">
                                        <div class="category-selector">
                                            <p>Browse latest events by their category</p>
                                            <select id="event-category">
                                                <option value="1">Parties &amp; Music</option>
                                                <option value="2">Trading</option>
                                                <option value="3">Games</option>
                                                <option value="4">Retro Guides</option>
                                                <option value="5">Debates &amp; Discussion</option>
                                                <option value="6">Grand Openings</option>
                                                <option value="7">Dating</option>
                                                <option value="8">Jobs</option>
                                                <option value="9">Group Events</option>
                                                <option value="10">Performance</option>
                                                <option value="11">Help Desk</option>
                                            </select>
                                        </div>
                                        <div id="event-list">

                                            <ul class="habblet-list">
                                            </ul>
                                        </div>
                                    </div>
                                    <script type="text/javascript">
                                        document.observe('dom:loaded', function() {
                                            CurrentRoomEvents.init();
                                        });
                                    </script>


                                </div>
                            </div>
                        </div>
                        <div class="bb">
                            <div></div>
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
                if (!$(document.body).hasClassName('process-template')) {
                    Rounder.init();
                }
            </script>
            <div id="column2" class="column">
                <div class="habblet-container news-promo">
                    <div class="cbb clearfix notitle ">

                        <?php $sql = $bdd->query("SELECT * FROM gabcms_news ORDER BY -id LIMIT 0," . $cof['nb_news'] . "");
                        $i = 0;
                        while ($row = $sql->fetch()) {
                            $row['summary'] = $row['snippet'];
                            $row['title'] = $row['title'];
                            $row['title_safe'] = $row['title'];
                            $row['date'] = date('M j, Y', $row['date']);
                            $news[$i] = $row;
                            $i++;
                        }
                        ?>
                        <div id="newspromo">
                            <div id="topstories">
                                <div class="topstory" style="background-image: url(<?php echo $news[0]['topstory_image']; ?>)">
                                    <h4>Dernières news</a></h4>
                                    <h3><a href="<?PHP echo $news[0]['lien_event']; ?>"><?php echo $news[0]['title']; ?></a></h3>
                                    <p class="summary">
                                        <?php echo $news[0]['summary']; ?>
                                    </p>
                                    <p>
                                        <a href="<?PHP echo $news[0]['lien_event']; ?>"><?PHP echo $news[0]['info']; ?></a>
                                    </p>
                                </div>
                                <div class="topstory" style="background-image: url(<?php echo $news[1]['header_image']; ?>); display: none">
                                    <h4>Dernières news</a></h4>
                                    <h3><a href="<?PHP echo $news[1]['lien_event']; ?>"><?php echo $news[1]['title']; ?></a></h3>
                                    <p class="summary">
                                        <?php echo $news[1]['summary']; ?>
                                    </p>
                                    <p>
                                        <a href="<?PHP echo $news[1]['lien_event']; ?>"><?PHP echo $news[1]['info']; ?></a>
                                    </p>
                                </div>
                                <div class="topstory" style="background-image: url(<?php echo $news[2]['header_image']; ?>); display: none">
                                    <h4>Dernières news</a></h4>
                                    <h3><a href="<?PHP echo $news[2]['lien_event']; ?>"><?php echo $news[2]['title']; ?></a></h3>
                                    <p class="summary">
                                        <?php echo $news[2]['summary']; ?>
                                    </p>
                                    <p>
                                        <a href="<?PHP echo $news[2]['lien_event']; ?>"><?PHP echo $news[2]['info']; ?></a>
                                    </p>
                                </div>
                                <div id="topstories-nav" style="display: none"><a href="#" class="prev">Précédent</a><span>1</span> / 3<a href="#" class="next">Suivant</a></div>
                            </div>
                            <ul class="widelist">
                                <li class="even">
                                    <a href="<?PHP echo $news[3]['lien_event']; ?>"><?php echo $news[3]['title']; ?></a>
                                    <div class="newsitem-date"><?php echo $news[3]['date']; ?></div>
                                </li>
                                <li class="odd">
                                    <a href="<?PHP echo $news[3]['lien_event']; ?>"><?php echo $news[3]['info']; ?></a>
                                    <div class="newsitem-date"><?php echo $news[3]['date']; ?></div>
                                </li>
                                <li class="last"><a href="<?php echo $url; ?>/articles">Tous les articles</a></li>
                            </ul>
                        </div>
                        <script type="text/javascript">
                            document.observe("dom:loaded", function() {
                                NewsPromo.init();
                            });
                        </script>
                    </div>

                </div>
                <script type="text/javascript">
                    if (!$(document.body).hasClassName('process-template')) {
                        Rounder.init();
                    }
                </script>

                <div class="habblet-container ">
                    <div class="cb clearfix red ">
                        <div class="bt">
                            <div></div>
                        </div>
                        <div class="i1">
                            <div class="i2">
                                <div class="i3">
                                    <div class="box-tabs-container clearfix">
                                        <h2>Staff Picks</h2>
                                        <ul class="box-tabs">
                                            <li id="tab-1-3-1"><a href="#">Rooms</a><span class="tab-spacer"></span></li>
                                            <li id="tab-1-3-2" class="selected"><a href="#">Groups</a><span class="tab-spacer"></span></li>
                                        </ul>

                                    </div>
                                    <div id="tab-1-3-1-content" style="display: none">
                                        <div class="progressbar"><img src="<?PHP echo $imagepath; ?>images/progress_bubbles.gif" alt="" width="29" height="6"></div>
                                        <a href="<?PHP echo $url; ?>/habblet/proxy?hid=h21" class="tab-ajax"></a>
                                    </div>
                                    <div id="tab-1-3-2-content">
                                        <div id="staffpicks-groups-habblet-list-container" class="habblet-list-container groups-list">
                                            <ul class="habblet-list two-cols clearfix">
                                            </ul>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="bb">
                            <div></div>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    if (!$(document.body).hasClassName('process-template')) {
                        Rounder.init();
                    }
                </script>

                <div class="habblet-container ">
                    <div class="cb clearfix blue ">
                        <div class="bt">
                            <div></div>
                        </div>
                        <div class="i1">
                            <div class="i2">
                                <div class="i3">

                                    <div class="rounded-container">
                                        <div style="background-color: rgb(255, 255, 255);">
                                            <div style="margin: 0px 1px; height: 1px; overflow: hidden; background-color: rgb(255, 255, 255);">
                                                <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(111, 153, 196);">
                                                    <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(53, 113, 173);">
                                                        <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(39, 103, 167);"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div style="margin: 0px; height: 1px; overflow: hidden; background-color: rgb(255, 255, 255);">
                                                <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(53, 113, 173);">
                                                    <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(39, 103, 167);"></div>
                                                </div>
                                            </div>
                                            <div style="margin: 0px; height: 1px; overflow: hidden; background-color: rgb(111, 153, 196);">
                                                <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(39, 103, 167);"></div>
                                            </div>
                                            <div style="margin: 0px; height: 1px; overflow: hidden; background-color: rgb(53, 113, 173);">
                                                <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(39, 103, 167);"></div>
                                            </div>
                                        </div>
                                        <h2 class="title rounded-done">Recommended </h2>
                                        <div style="background-color: rgb(255, 255, 255);">
                                            <div style="margin: 0px; height: 1px; overflow: hidden; background-color: rgb(53, 113, 173);">
                                                <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(39, 103, 167);"></div>
                                            </div>
                                            <div style="margin: 0px; height: 1px; overflow: hidden; background-color: rgb(111, 153, 196);">
                                                <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(39, 103, 167);"></div>
                                            </div>
                                            <div style="margin: 0px; height: 1px; overflow: hidden; background-color: rgb(255, 255, 255);">
                                                <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(53, 113, 173);">
                                                    <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(39, 103, 167);"></div>
                                                </div>
                                            </div>
                                            <div style="margin: 0px 1px; height: 1px; overflow: hidden; background-color: rgb(255, 255, 255);">
                                                <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(111, 153, 196);">
                                                    <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(53, 113, 173);">
                                                        <div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(39, 103, 167);"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="promogroups-habblet-list-container" class="habblet-list-container groups-list">
                                        <ul class="habblet-list two-cols clearfix">
                                        </ul>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="bb">
                            <div></div>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    if (!$(document.body).hasClassName('process-template')) {
                        Rounder.init();
                    }
                </script>

                <div class="habblet-container ">
                    <div class="cb clearfix green ">
                        <div class="bt">
                            <div></div>
                        </div>
                        <div class="i1">
                            <div class="i2">
                                <div class="i3">
                                    <div class="box-tabs-container clearfix">
                                        <h2>Tags</h2>
                                        <ul class="box-tabs">
                                            <li id="tab-1-5-1"><a href="#">Retros Like...</a><span class="tab-spacer"></span></li>

                                            <li id="tab-1-5-2" class="selected"><a href="#">My Tags</a><span class="tab-spacer"></span></li>
                                        </ul>
                                    </div>
                                    <div id="tab-1-5-1-content" style="display: none">
                                        <div class="progressbar"><img src="<?PHP echo $imagepath; ?>images/progress_bubbles.gif" alt="" width="29" height="6"></div>
                                        <a href="<?PHP echo $url; ?>/habblet/proxy?hid=h24" class="tab-ajax"></a>
                                    </div>
                                    <div id="tab-1-5-2-content">
                                        <div id="my-tag-info" class="habblet-content-info">
                                            You have no tags. Answer the question below or just add a tag of your choice. </div>
                                        <div class="box-content">

                                            <div class="habblet" id="my-tags-list">

                                                <form method="post" action="<?PHP echo $url; ?>/myhabbo/tag/add" onsubmit="TagHelper.addFormTagToMe();return false;">
                                                    <div class="add-tag-form clearfix">
                                                        <a class="new-button" href="#" id="add-tag-button" onclick="TagHelper.addFormTagToMe();return false;"><b>Add tag</b><i></i></a>
                                                        <input type="text" id="add-tag-input" maxlength="20" style="float: right">
                                                        <em class="tag-question">Who is your favourite actor?</em>
                                                    </div>
                                                    <div style="clear: both"></div>
                                                </form>

                                            </div>
                                        </div>


                                        <script type="text/javascript">
                                            document.observe("dom:loaded", function() {
                                                TagHelper.setTexts({
                                                    tagLimitText: "You\'ve reached the tag limit - delete one of your tags if you want to add a new one.",
                                                    invalidTagText: "Invalid tag, the tag must be less than 20 characters and composed only of alphanumeric characters.",
                                                    buttonText: "OK"
                                                });
                                                TagHelper.init('4');
                                            });
                                        </script>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="bb">
                            <div></div>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    if (!$(document.body).hasClassName('process-template')) {
                        Rounder.init();
                    }
                </script>

                <div class="habblet-container ">
                    <div class="cb clearfix blue ">
                        <div class="bt">
                            <div></div>
                        </div>
                        <div class="i1">
                            <div class="i2">
                                <div class="i3">
                                    <div class="box-tabs-container clearfix">
                                        <h2>Groups</h2>
                                        <ul class="box-tabs">
                                            <li id="tab-2-1"><a href="#">Hot Groups</a><span class="tab-spacer"></span></li>
                                            <li id="tab-2-2" class="selected"><a href="#">My Groups</a><span class="tab-spacer"></span></li>
                                        </ul>
                                    </div>
                                    <div id="tab-2-1-content" style="display: none">
                                        <div class="progressbar"><img src="<?PHP echo $imagepath; ?>images/progress_bubbles.gif" alt="" width="29" height="6"></div>
                                        <a href="<?PHP echo $url; ?>/habblet/proxy?hid=groups" class="tab-ajax"></a>
                                    </div>
                                    <div id="tab-2-2-content">


                                        <div id="groups-habblet-info" class="habblet-content-info">
                                            View the groups you are in, create your own group, or get some inspiration from the 'Hot Groups'-tab! </div>

                                        <div id="groups-habblet-list-container" class="habblet-list-container groups-list">


                                            <ul class="habblet-list two-cols clearfix">
                                            </ul>
                                            <div class="habblet-button-row clearfix"><a class="new-button" id="purchase-group-button" href="#"><b>Create/buy a Group</b><i></i></a></div>
                                        </div>

                                        <div id="groups-habblet-group-purchase-button" class="habblet-list-container"></div>

                                        <script type="text/javascript">
                                            $("purchase-group-button").observe("click", function(e) {
                                                Event.stop(e);
                                                GroupPurchase.open();
                                            });
                                        </script>





                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="bb">
                            <div></div>
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
                HabboView.add(LoginFormUI.init);
            </script>
            <script type="text/javascript">
                HabboView.run();
            </script>


            <div id="column3" class="column">
                <div class="habblet-container ">
                    <div class="ad-container">
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
            <!-- FOOTER -->
            <?PHP include("./template/footer.php"); ?>
            <!-- FIN FOOTER -->