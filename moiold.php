<?php
/*---------------------------------------------------+
| HoloCMS - Website and Content Management System
+----------------------------------------------------+
| Copyright &copy; 2008 Meth0d
+----------------------------------------------------+
| HoloCMS is provided "as is" and comes without
| warrenty of any kind.
+---------------------------------------------------*/

@include './config.php';
@include '../config.php';
require 'includes/news_headlines.php';
$today = date("d-m-Y");

if (isset($_GET['do']) && isset($_GET['key']) && $_GET['do'] == "RemoveFeedItem" && is_numeric($_GET['key'])) {  // ex. me.php?do=RemoveFeedItem&key=5
    $stmt = $bdd->prepare("DELETE FROM cms_alerts WHERE userid = :my_id AND id = :key ORDER BY id ASC LIMIT 1");
    $stmt->execute(array(':my_id' => $user['id'], ':key' => $_GET['key']));
}

$pagename = "Accueil";
$pageid = "accueil";

// Header for minimail
$stmt = $bdd->prepare("SELECT COUNT(*) FROM cms_minimail WHERE to_id = :my_id");
$stmt->execute(array(':my_id' => $user['id']));
$messages = $stmt->fetchColumn();
header("X-JSON: {\"totalMessages\":" . $messages . "}");

include('template/subheader.php');
include('template/header.php');

// Query tags
$stmt2 = $bdd->prepare("SELECT tag,id FROM cms_tags WHERE ownerid = :my_id LIMIT 20");
$stmt2->execute(array(':my_id' => $user['id']));
$fetch_tags = $stmt2->fetchAll(PDO::FETCH_ASSOC);
if (is_array($fetch_tags)) {
    $tags_num = count($fetch_tags);
    foreach ($fetch_tags as $row) {
        printf("<li><a href=\"tags.php?tag=%s\" class=\"tag\" style=\"font-size:10px\">%s</a>\n
<a class=\"tag-remove-link\"\n
title=\"Remove tag\"\n
href=\"#\"></a></li>\n", $row['tag'], $row['tag']);
    }
} else {
    echo "No tags found";
}

// Create the random tag questions array
$randomq = array();
$randomq[] = "Quel est ton show favori?";
$randomq[] = "Quel est ton acteur préféré?";
$randomq[] = "Ton pseudo?";
$randomq[] = "Ta musique préférée?";
$randomq[] = "Décris-toi!";
$randomq[] = "Ton staff favori?";

// Select a random question from the array above
$chosen = array_rand($randomq);
$tag_question = $randomq[$chosen];

?>

<div id="container">
    <div id="content">
        <div id="column1" class="column">
            <div class="habblet-container ">

                <div id="new-personal-info" style="background-image:url(./web-gallery/v2/images/personal_info/hotel_views/htlview_br.png)" />
                <div id="enter-hotel">
                    <?php if ($cof['etat_client'] == '1' || $cof['etat_client'] == '3') { ?>
                        <div class="open">
                            <?php
                            if (HoloText(getContent('client-widescreen'), true) == "1") {
                                $wide_enabled = true;
                            } else {
                                $wide_enabled = false;
                            }
                            ?>
                            <a href="client.php<?php if ($wide_enabled == false) {
                                                    echo "?wide=false";
                                                } ?>" target="client" onclick="openOrFocusHabbo(this); return false;">Entrer <?php echo $shortname; ?><i></i></a>
                            <b></b>
                        </div>
                    <?php } else { ?>
                        <div class="closed">
                            <span>Hotel ferm&eacute;</span>
                            <b></b>
                        </div>
                    <?php } ?>
                </div>

                <div id="habbo-plate">
                    <a href="account.php?tab=1">
                        <img alt="<?php echo $user['username']; ?>" src="<?php echo $avatarimage; ?>?figure=<?php echo $user['look']; ?>&size=b&direction=4&head_direction=3&gesture=sml" width="64" height="110" />
                    </a>
                </div>

                <div id="habbo-info">
                    <div id="motto-container" class="clearfix"><strong><?php echo $user['username']; ?>:</strong>
                        <div><span title="Click to enter your motto/ status"><?php if (!empty($user['motto'])) {
                                                                                    echo stripslashes($user['motto']);
                                                                                } else {
                                                                                    echo "Click here to enter your motto";
                                                                                } ?></span>
                            <p style="display: none"><input type="text" length="30" name="motto" value="<?php echo stripslashes($user['motto']); ?>" /></p>
                        </div>
                    </div>
                    <div id="motto-links" style="display: none"><a href="#" id="motto-cancel">Cancel</a></div>
                </div>
                <ul id="link-bar" class="clearfix">
                    <li class="change-looks"><a href="account.php?tab=1">Change de look &raquo;</a></li>
                    <li class="credits">
                        <a href="credits.php"><?php echo $user['credits']; ?></a> cr&eacute;dits
                    </li>
                    <li class="club">
                        <a href="club.php"><?php if (!IsHCMember($user['id'])) {
                                                echo "Rejoins le " . $shortname . " club &raquo;</a>";
                                            } else {
                                                echo HCDaysLeft($user['id']) . " </a>jours HC";
                                            } ?>
                    </li>
                    <li class="club"><a href="deletehand.php">Badge Shop</a></li>
                </ul>

                <div id="habbo-feed">
                    <ul id="feed-items">

                        <?php
                        $sqluser = $bdd->prepare("SELECT hc_before FROM users WHERE id=:my_id LIMIT 1");
                        $sqluser->execute(array(':my_id' => $user['id']));
                        $users = $sqluser->fetch(PDO::FETCH_ASSOC);

                        $sql = $bdd->prepare("SELECT * FROM users_club WHERE userid=:my_id LIMIT 1");
                        $sql->execute(array(':my_id' => $user['id']));
                        if ($users['hc_before'] > 0 && $sql->rowCount() == 0) { ?>
                            <li id="feed-item-hc-reminder">
                                <a href="#" class="remove-feed-item" id="remove-hc-reminder" title="Remove notification">Remove notification</a>
                                <div>
                                    <?php if ($sql->rowCount() == 0) { ?> Your <?php echo $shortname; ?> Club is expired. Do you want to extend your <?php echo $shortname; ?> Club?<?php } ?>
                                </div>
                                <div id="hc-reminder-buttons" class="clearfix">
                                    <a href="#" class="new-button" id="hc-reminder-1" title="31 days, 20 Credits"><b>1 month</b><i></i></a>
                                    <a href="#" class="new-button" id="hc-reminder-2" title="93 days, 50 Credits"><b>3 months</b><i></i></a>
                                    <a href="#" class="new-button" id="hc-reminder-3" title="186 days, 80 Credits"><b>6 months</b><i></i></a>
                                </div>
                            </li>
                            <script type="text/javascript">
                                L10N.put("subscription.title", "HABBO CLUB");
                            </script>

                            <?php
                        }

                        if (IsHCMember($user['id'])) {
                            if ($user['hc_before'] > 0) {
                                if (HCDaysLeft($user['id']) < 6) { ?>
                                    <li id="feed-item-hc-reminder">
                                        <a href="#" class="remove-feed-item" id="remove-hc-reminder" title="Remove notification">Remove notification</a>
                                        <div>
                                            Votre <?php echo $shortname; ?> Club expire plus dans<?php echo HCDaysLeft($user['id']); ?> jours. Voulez-vous prolonger votre <?php echo $shortname; ?> Club?
                                        </div>
                                        <div id="hc-reminder-buttons" class="clearfix">
                                            <a href="#" class="new-button" id="hc-reminder-1" title="31 jours, 20 Credits"><b>1 mois</b><i></i></a>
                                            <a href="#" class="new-button" id="hc-reminder-2" title="93 jours, 50 Credits"><b>3 mois</b><i></i></a>
                                            <a href="#" class="new-button" id="hc-reminder-3" title="186 jours, 80 Credits"><b>6 mois</b><i></i></a>
                                        </div>
                                    </li>
                                    <script type="text/javascript">
                                        L10N.put("subscription.title", "HABBO CLUB");
                                    </script>

                                <?php
                                }
                            }
                        }

                        if ($user['rank'] > 5) {
                            $stmt = $bdd->prepare("SELECT COUNT(*) FROM cms_help WHERE picked_up = '0'");
                            $stmt->execute();
                            $alerts = $stmt->fetchColumn();
                            if ($alerts > 0) {
                                echo "            <li class=\"small\" id=\"feed-group-discussion\">
                <strong>Bessoin d'aide ?</strong><br />Il y a ";
                                if ($alerts == 1) {
                                    echo " ";
                                } else {
                                    echo " ";
                                }
                                echo " <strong><a href='./housekeeping/index.php?p=helper' target='_self'>" . $alerts . "</a></strong> alertes non prises.";
                                if ($alerts > 1) {
                                    echo "";
                                } else {
                                    echo "";
                                }
                                echo "
            </li>";
                            }
                        }

                        $tmp = $bdd->prepare("SELECT * FROM cms_alerts WHERE userid = :my_id");
                        $tmp->execute(array(':my_id' => $user['id']));
                        $alerts = $tmp->rowCount();

                        if ($alerts > 0) {

                            $row = $tmp->fetch(PDO::FETCH_ASSOC);

                            $id = $row['id'];
                            $type = $row['type'];

                            if ($type == 1) {
                                $heading = "Notification";
                            } elseif ($type == 2) {
                                $heading = "Message du " . $shortname . " Staff";
                            } else {
                                $heading = "undefined";
                            }

                            if ($tmp->rowCount() > 0) { ?>
                                <li id="feed-item-campaign" class="contributed">
                                    <a href="#" class="remove-feed-item" id="remove-feed-item-<?php echo $row['id']; ?>" title="Remove notification">Remove notification</a>
                                    <div>
                                        <b><?php echo $heading; ?></b><br />
                                        <?php echo HoloText(nl2br(trim(FilterText($row['alert'])))); ?>
                                    </div>
                                </li>
                                <?php while ($row = $tmp->fetch(PDO::FETCH_ASSOC)) {

                                ?>
                                    <li id="feed-item-campaign" class="contributed">
                                        <a href="#" class="remove-feed-item" id="remove-feed-item-<?php echo $row['id']; ?>" title="Remove notification">Remove notification</a>
                                        <div>
                                            <b><?php echo $heading; ?></b><br />
                                            <?php echo HoloText(nl2br(trim(FilterText($row['alert'])))); ?>
                                        </div>
                                    </li>

                            <?php
                                }
                            }
                        }
                        $sql = $bdd->prepare("SELECT * FROM cms_noobgifts WHERE userid=:user_id LIMIT 1");
                        $sql->execute(array(':user_id' => $user['id']));
                        if ($sql->rowCount() > 0) { ?>
                            <li id="feed-item-giftqueue" class="contributed">
                                <a href="#" class="remove-feed-item" title="Remove notification">Remove notification</a>
                                <div>
                                    Un nouveau cadeau est arriv&eacute;. Cette fois, vous avez re&ccedil;u une <?php if ($row['gift'] == 0) {
                                                                                                                    echo "My first " . $shortname . " stool";
                                                                                                                } elseif ($row['gift'] == 1) {
                                                                                                                    echo "plant";
                                                                                                                } ?>.
                                </div>
                            </li>
                        <?php
                        }

                        $dob = $user['account_day_of_birth'];
                        $bits = explode("-", $dob);
                        $day = $bits[0];

                        if ($day == $today && $month2 == $month && HoloText(getContent('birthday-notifications'), true) == "1") {

                            $age = $year - $year2;

                            // If we have haxxorz that bypassed the age check (only javascript validates it), they may be like, what,
                            // one year old, so instead of showing 'happy 1th birthday', we properly show 'happy 1st birthday' etc.
                            if ($age == 1 || $age == 21) {
                                $age = $age . "st";
                            } elseif ($age == 2 || $age == 22) {
                                $age = $age . "nd";
                            } elseif ($age == 3 || $age = 33) {
                                $age = $age . "rd";
                            } else {
                                $age = $age . "th";
                            }
                        ?>

                            <li id="feed-birthday">
                                <div>
                                    Happy <?php echo $age; ?> birthday, <?php echo $user['username']; ?>!<br />We hope you have a great day today.
                                </div>
                            </li>
                        <?php } ?>
                        <?php
                        $sql = $bdd->prepare("SELECT * FROM messenger_friendrequests WHERE user_to_id=:user_id");
                        $sql->execute(array(':user_id' => $user['id']));
                        $count = $sql->rowCount();
                        if ($count != 0) { ?>
                            <li id="feed-notification">
                                Vous avez <a href="./client.php" onclick="HabboClient.openOrFocus(this); return false;"><?php echo $count; ?> des demande de amigos</a> attente
                            </li>
                        <?php } ?>

                        <li class="small" id="feed-lastlogin">
                            Derni&egrave;re connexion:
                            <?php echo $user['last_online']; ?>
                        </li>


                    </ul>
                </div>

                <p class="last"></p>
            </div>
            <div class="habblet-container">
                <div class="cbb clearfix orange ">
                    <h2 class="title">A la Une
                    </h2>
                    <div id="hotcampaigns-habblet-list-container">
                        <ul id="hotcampaigns-habblet-list">
                            <?php
                            $getcampaigns = $bdd->query("select * from cms_campaigns");
                            while ($campaigns = $getcampaigns->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                                <li class="even">
                                    <div class="hotcampaign-container">
                                        <a href="<?php echo $campaigns['url']; ?>"><img src="<?php echo $campaigns['image']; ?>" align="left" alt="" /></a>
                                        <h3><?php echo $campaigns['name']; ?></h3>
                                        <p><?php echo $campaigns['desc']; ?></p>
                                        <p class="link"><a href="<?php echo $campaigns['url']; ?>">Voir >></a></p>
                                    </div>
                                </li>
                            <?php  } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                HabboView.add(function() {
                    L10N.put("personal_info.motto_editor.spamming", "Don\'t spam me, bro!");
                    PersonalInfo.init("");
                });
            </script>



        <script type="text/javascript">
            if (!$(document.body).hasClassName('process-template')) {
                Rounder.init();
            }
        </script>

        <?php /* Minimail */ ?>
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
                $sql = $bdd->prepare("
               SELECT * FROM messenger_friendships WHERE user_one_id = :user_id OR user_two_id = :user_id;
               SELECT * FROM cms_minimail WHERE to_id = :user_id OR senderid = :user_id
           ");
                $sql->execute(array(':user_id' => $user['id']));

                $count = $sql->rowCount();
                $sql->nextRowset();
                $mescount = $sql->rowCount();


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

        <?php /*Habbo Search*/ ?>
        <div class="habblet-container ">
            <div class="cbb clearfix default ">
                <div class="box-tabs-container clearfix">
                    <h2><?php echo $shortname; ?>s</h2>
                    <ul class="box-tabs">

                        <li id="tab-0-3-2" class="selected"><a href="#">Cherche des <?php echo $shortname; ?>s</a><span class="tab-spacer"></span></li>
                    </ul>
                </div>
                <div id="tab-0-3-1-content" style="display: none">
                    <div id="friend-invitation-habblet-container" class="box-content">
                        <div id="invitation-form" class="clearfix">
                            <textarea name="invitation_message" id="invitation_message" class="invitation-message">Come and hangout with me in <?php echo $shortname; ?>.
- <?php echo $rawname; ?></textarea>
                            <div id="invitation-email">
                                <div class="invitation-input">1.<input onkeypress="$('invitation_recipient2').enable()" type="text" name="invitation_recipients" id="invitation_recipient1" value="Friend's email" class="invitation-input" />
                                </div>
                                <div class="invitation-input">2.<input disabled onkeypress="$('invitation_recipient3').enable()" type="text" name="invitation_recipients" id="invitation_recipient2" value="Friend's email" class="invitation-input" />
                                </div>
                                <div class="invitation-input">3.<input disabled type="text" name="invitation_recipients" id="invitation_recipient3" value="Friend's email" class="invitation-input" />
                                </div>
                            </div>
                            <div class="clear"></div>
                            <div class="fielderror" id="invitation_message_error" style="display: none;">
                                <div class="rounded"></div>
                            </div>
                        </div>

                        <div class="invitation-buttons clearfix" id="invitation_buttons">
                            <a class="new-button" id="send-friend-invite-button" href="#"><b>Invite friend(s)</b><i></i></a>
                        </div>
                    </div>
                    <script type="text/javascript">
                        L10N.put("invitation.button.invite", "Invite friend(s)");
                        L10N.put("invitation.form.recipient", "Friend's email");
                        L10N.put("invitation.error.message_too_long", "invitation.error.message_limit");
                        inviteFriendHabblet = new InviteFriendHabblet(500);
                        $("friend-invitation-habblet-container").select(".fielderror .rounded").each(function(el) {
                            Rounder.addCorners(el, 8, 8);
                        });
                    </script>
                </div>
                <div id="tab-0-3-2-content">
                    <div class="habblet-content-info">
                        <a name="habbo-search">Tape le pseudo d'un <?php echo $shortname; ?> pour aller sur sa home.</a>
                    </div>
                    <div id="habbo-search-error-container" style="display: none;">
                        <div id="habbo-search-error" class="rounded rounded-red"></div>
                    </div>
                    <br clear="all" />
                    <div id="avatar-habblet-list-search">
                        <input type="text" id="avatar-habblet-search-string" />
                        <a href="#" id="avatar-habblet-search-button" class="new-button"><b>Chercher</b><i></i></a>
                    </div>

                    <br clear="all" />

                    <div id="avatar-habblet-content">
                        <div id="avatar-habblet-list-container" class="habblet-list-container">
                            <ul class="habblet-list">
                            </ul>

                        </div>
                        <script type="text/javascript">
                            L10N.put("habblet.search.error.search_string_too_long", "The search keyword was too long. Maximum length is 25 characters.");
                            L10N.put("habblet.search.error.search_string_too_short", "The search keyword was too short. 1 character required (as a minimum).");
                            L10N.put("habblet.search.add_friend.title", "Send friend request?");
                            new HabboSearchHabblet(1, 25);
                        </script>
                    </div>

                    <script type="text/javascript">
                        Rounder.addCorners($("habbo-search-error"), 8, 8);
                    </script>
                </div>

            </div>
        </div>
        <script type="text/javascript">
            if (!$(document.body).hasClassName('process-template')) {
                Rounder.init();
            }
        </script>
        <?php /* Groups */ ?>
        <div class="habblet-container ">
            <div class="cbb clearfix blue ">
                <div class="box-tabs-container clearfix">
                    <h2>Groups</h2>
                    <ul class="box-tabs">
                        <li id="tab-2-1"><a href="#">Clans au hasard</a><span class="tab-spacer"></span></li>
                        <li id="tab-2-2" class="selected"><a href="#">Mes Clans</a><span class="tab-spacer"></span></li>
                    </ul>
                </div>
                <div id="tab-2-1-content" style="display: none">
                    <div class="progressbar"><img src="./web-gallery/images/progress_bubbles.gif" alt="" width="29" height="6" /></div>
                    <a href="randomgroups.php?sp=plain" class="tab-ajax"></a>
                </div>
                <div id="tab-2-2-content">


                    <div id="groups-habblet-info" class="habblet-content-info">
                        Look les clans de tes amis et cr&eacute;e toi-en!
                    </div>

                    <div id="groups-habblet-list-container" class="habblet-list-container groups-list">

                        <?php
                        $get_em = $bdd->prepare("SELECT * FROM guilds_members WHERE user_id = :user_id");
                        $get_em->execute(array(':user_id' => $user['id']));
                        $groups = $get_em->rowCount();


                        echo "\n    <ul class=\"habblet-list two-cols clearfix\">";

                        $num = 0;

                        $num = 0;
                        $rights = 0;
                        $lefts = 0;
                        $get_em = $bdd->prepare("SELECT * FROM guilds_members WHERE user_id = :user_id");
                        $get_em->execute(array(':user_id' => $user['id']));

                        foreach ($get_em as $row) {
                            $num++;
                            if (IsEven($num)) {
                                $pos = "right";
                                $rights++;
                            } else {
                                $pos = "left";
                                $lefts++;
                            }

                            if (IsEven($lefts)) {
                                $oddeven = "odd";
                            } else {
                                $oddeven = "even";
                            }

                            $group_id = $row['groupid'];
                            $check = $bdd->prepare("SELECT * FROM groups_details WHERE id = :group_id LIMIT 1");
                            $check->execute(array(':group_id' => $group_id));
                            $groupdata = $check->fetch(PDO::FETCH_ASSOC);

                            echo "            <li class=\"" . $oddeven . " " . $pos . "\" style=\"background-image: url(./habbo-imaging/badge.php?badge=" . $groupdata['badge'] . ")\">\n            	\n                \n                <a class=\"item\" href=\"group_profile.php?id=" . $group_id . "\">" . HoloText($groupdata['name']) . "</a>\n            </li>";
                        }

                        $rights_should_be = $lefts;
                        if ($rights !== $rights_should_be) {
                            echo "<li class=\"" . $oddeven . " right\"><div class=\"item\">&nbsp;</div></li>";
                        }

                        echo "\n    </ul>";
                        ?>

                        <div class="habblet-button-row clearfix"><a class="new-button" id="purchase-group-button" href="#"><b>Cr&eacute;er un clan</b><i></i></a></div>
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

    <script type='text/javascript'>
        if (!$(document.body).hasClassName('process-template')) {
            Rounder.init();
        }
    </script>
    <div id="column2" class="column">
        <div class="habblet-container news-promo">
            <div class="cbb clearfix notitle ">


                <div id="newspromo">
                    <div id="topstories">
                        <div class="topstory" style="background-image: url(<?php echo $news_1_topstory; ?>)">
                            <h4>Derni&egrave;re news <a href="./rss.php"><img src="./web-gallery/v2/images/holo/feed-icon.gif" alt="" border="0" /></a></h4>
                            <h3><a href="news.php?id=<?php echo $news_1_id; ?>"><?php echo $news_1_title; ?></a></h3>
                            <p class="summary">
                                <?php echo $news_1_snippet; ?>
                            </p>
                            <p>
                                <a href="news.php?id=<?php echo $news_1_id; ?>">Lire plus &raquo;</a>
                            </p>
                        </div>
                        <div class="topstory" style="background-image: url(<?php echo $news_2_topstory; ?>); display: none">
                            <h4>Derni&egrave;re news</h4>
                            <h3><a href="news.php?id=<?php echo $news_2_id; ?>"><?php echo $news_2_title; ?></a></h3>
                            <p class="summary">
                                <?php echo $news_2_snippet; ?>
                            </p>
                            <p>
                                <a href="news.php?id=<?php echo $news_2_id; ?>">Lire plus &raquo;</a>
                            </p>
                        </div>
                        <div id="topstories-nav" style="display: none"><a href="#" class="prev">&laquo; Pr&eacute;c&eacute;dent</a><span>1</span> / 2<a href="#" class="next">Suivant &raquo; </a></div>
                    </div>
                    <ul class="widelist">
                        <li class="even">
                            <a href="news.php?id=<?php echo $news_3_id; ?>"><?php echo $news_3_title; ?></a>
                            <div class="newsitem-date"><?php echo $news_3_date; ?></div>
                        </li>
                        <li class="odd">
                            <a href="news.php?id=<?php echo $news_4_id; ?>"><?php echo $news_4_title; ?></a>
                            <div class="newsitem-date"><?php echo $news_4_date; ?></div>
                        </li>
                        <li class="last"><a href="news.php">Toutes les news &raquo;</a></li>
                    </ul>

                </div>
                <script type="text/javascript">
                    document.observe("dom:loaded", function() {
                        NewsPromo.init();
                    });
                </script>
            </div>
        </div>
        <div class="habblet-container ">
            <div class="cbb clearfix blue ">
                <div class="box-tabs-container clearfix">
                    <h2>Salut <?php echo $user['username']; ?>!</h2>
                    <ul class="box-tabs">

                    </ul>
                </div>
                <div id="tab-2-1-content" style="display: none">
                    <div class="progressbar"><img src="./web-gallery/images/progress_bubbles.gif" alt="" width="29" height="6" /></div>
                    <a href="randomgroups?sp=plain" class="tab-ajax"></a>
                </div>
                <div id="tab-2-2-content">


                    <div id="groups-habblet-info" class="habblet-content-info">

                        <div id="invitation-link-container">
                            <h3>Invite tes amis tout en gagnant des cr&eacute;dits!</h3>
                            <div class="copytext">
                                <p>D&egrave;s &agrave; pr&eacute;sent, tu pourras puber tout en remplissant ton porte-monnaie! Comment faire?</p>
                            </div>
                        </div>

                    </div>

                    <div class="habblet-button-row clearfix"><a class="new-button" id="purchase-group-button" href="account.php?tab=5"><b>Invite tes amis!</b><i></i></a></div>









                </div>

            </div>
        </div>
        <?php /* Recommend Groups  */ ?>
        <div class="habblet-container ">
            <div class="cbb clearfix blue ">

                <h2 class="title">Recommand&eacute;s
                </h2>
                <div id="promogroups-habblet-list-container" class="habblet-list-container groups-list">
                    <ul class="habblet-list two-cols clearfix">
                        <?php
                        $sql = $bdd->query("SELECT * FROM cms_recommended WHERE type = 'group' ORDER BY id ASC");
                        $i = 0;
                        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                            $i++;
                            $groupsql = $bdd->prepare("SELECT * FROM groups_details WHERE id = :rec_id LIMIT 1");
                            $groupsql->execute(array(':rec_id' => $row['rec_id']));
                            $grouprow = $groupsql->fetch(PDO::FETCH_ASSOC);
                            if (IsEven($i)) {
                                $even = "even left";
                            } else {
                                $even = "even right";
                            }
                        ?>
                            <li class="<?php echo $even; ?>" style="background-image: url(./habbo-imaging/badge-fill/<?php echo $grouprow['badge']; ?>.gif)">
                                <?php if ($grouprow['roomid'] != 0) { ?><a href="client.php?forwardId=2&amp;roomId=<?php echo $grouprow['roomid']; ?>" onclick="HabboClient.roomForward(this, '<?php echo $grouprow['roomid']; ?>', 'private'); return false;" target="client" class="group-room"></a><?php } ?>
                                <a class="item" href="group_profile.php?id=<?php echo $grouprow['id']; ?>"><?php echo HoloText($grouprow['name']); ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>


            </div>
        </div>
        <script type="text/javascript">
            if (!$(document.body).hasClassName('process-template')) {
                Rounder.init();
            }
        </script>
        <?php /*Tags */ ?>
        <div class="habblet-container ">
            <div class="cbb clearfix green ">
                <div class="box-tabs-container clearfix">
                    <h2>Tags</h2>
                    <ul class="box-tabs">
                        <li id="tab-3-1"><a href="#">Les joueurs aiment..</a><span class="tab-spacer"></span></li>
                        <li id="tab-3-2" class="selected"><a href="#">Mes Tags</a><span class="tab-spacer"></span></li>
                    </ul>
                </div>
                <div id="tab-3-1-content" style="display: none">
                    <div class="progressbar"><img src="./web-gallery/images/progress_bubbles.gif" alt="" width="29" height="6" /></div>
                    <a href="tagcloud.php?sp=plain" class="tab-ajax"></a>
                </div>
                <div id="tab-3-2-content">
                    <div id="my-tag-info" class="habblet-content-info">
                        <?php
                        $tags_num = count($fetch_tags);
                        if ($tags_num > 19) {
                            echo "Tu as atteint la nombre maxi de tags.";
                        } elseif ($tags_num == 0) {
                            echo "Tu n'as pas de tags, tu peux en ajouter tout de suite!";
                        } elseif ($tags_num < 20) {
                            echo "Tu peux encore ajouter des tags!";
                        } ?>
                    </div>
                    <div class="box-content">
                        <div class="habblet" id="my-tags-list">

                            <?php if ($tags_num > 0) {
                                echo "<ul class=\"tag-list make-clickable\"> ";
                                foreach ($fetch_tags as $row) {
                                    printf("<li><a href=\"tags.php?tag=%s\" class=\"tag\" style=\"font-size:10px\">%s</a>\n
                <a class=\"tag-remove-link\"\n
                title=\"Remove tag\"\n
                href=\"#\"></a></li>\n", $row['tag'], $row['tag']);
                                }
                                echo "</ul>";
                            } ?>

                            <?php if ($tags_num < 20) { ?>
                                <form method="post" action="tags_ajax.php?key=add" onsubmit="TagHelper.addFormTagToMe();return false;">
                                    <div class="add-tag-form clearfix">
                                        <a class="new-button" href="#" id="add-tag-button" onclick="TagHelper.addFormTagToMe();return false;"><b>Ajouter</b><i></i></a>
                                        <input type="text" id="add-tag-input" maxlength="20" style="float: right" />
                                        <em class="tag-question"><?php echo $tag_question; ?></em>
                                    </div>
                                    <div style="clear: both"></div>
                                </form>
                            <?php } ?>
                        </div>
                    </div>

                    <script type="text/javascript">
                        document.observe("dom:loaded", function() {
                            TagHelper.setTexts({
                                tagLimitText: "You\'ve reached the tag limit - delete one of your tags if you want to add a new one.",
                                invalidTagText: "Invalid tag",
                                buttonText: "OK"
                            });
                            TagHelper.init('21063711');
                        });
                    </script>
                </div>

            </div>
        </div>
        <script type="text/javascript">
            if (!$(document.body).hasClassName('process-template')) {
                Rounder.init();
            }
        </script>


        <script type="text/javascript">
            if (!$(document.body).hasClassName('process-template')) {
                Rounder.init();
            }
        </script>
        <?php /* Random Rooms*/ ?>
        <div class="habblet-container ">
            <div class="cbb clearfix green ">
                <div class="box-tabs-container clearfix">
                    <h2>Apparts au hasard..</h2>
                    <ul class="box-tabs">
                    </ul>
                </div>
                <div id="tab-0-2-content">

                    <div id="rooms-habblet-list-container-h105" class="recommendedrooms-lite-habblet-list-container">
                        <ul class="habblet-list">

                            <?php
                            $i = 0;
                            $getem = $bdd->query("SELECT * FROM rooms WHERE owner_name IS NOT NULL ORDER BY RAND() LIMIT 5");
                            foreach ($getem as $row) {
                                if ($row['owner_name'] !== "") { // Public Rooms (and possibly bugged rooms) have no owner, thus do not display them
                                    $i++;
                                    if (IsEven($i)) {
                                        $even = "odd";
                                    } else {
                                        $even = "even";
                                    }

                                    // Calculate percentage
                                    if ($row['users_max'] == 0) {
                                        $row['users_max'] = 1;
                                    }
                                    $data[$i] = ($row['users'] / $row['users_max']) * 100;

                                    // Base room icon based on this - percantage levels may not be habbolike
                                    if ($data[$i] == 99 || $data[$i] > 99) {
                                        $room_fill = 5;
                                    } elseif ($data[$i] > 65) {
                                        $room_fill = 4;
                                    } elseif ($data[$i] > 32) {
                                        $room_fill = 3;
                                    } elseif ($data[$i] > 0) {
                                        $room_fill = 2;
                                    } elseif ($data[$i] < 1) {
                                        $room_fill = 1;
                                    }

                                    printf("<li class=\"%s\">
<span class=\"clearfix enter-room-link room-occupancy-%s\" title=\"Go to room\" roomid=\"%s\">
<span class=\"room-enter\">Entrer</span>
<span class=\"room-name\">%s</span>
<span class=\"room-description\">%s</span>
<span class=\"room-owner\">Cr&eacute;ateur: <a href=\"user_profile.php?name=%s\">%s</a></span>
</span></li>", $even, $room_fill, $row['id'], HoloText($row['name']), FilterText($row['description']), $row['owner_name'], $row['owner_name']);
                                }
                            }
                            ?>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <script type="text/javascript">
                        L10N.put("show.more", "Show more rooms");
                        L10N.put("show.less", "Show fewer rooms");
                        var roomListHabblet_h105 = new RoomListHabblet("rooms-habblet-list-container-h105", "room-toggle-more-data-h105", "room-more-data-h105");
                    </script>
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
    <?php

    include('template/footer.php');

    ?>