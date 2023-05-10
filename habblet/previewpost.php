<?php
/*===================================================+
|| # HoloCMS - Website and Content Management System
|+===================================================+
|| # Copyright &copy; 2008 Meth0d. All rights reserved.
|| # http://www.meth0d.org
|+===================================================+
|| # HoloCMS is provided \"as is\" and comes without
|| # warrenty of any kind. HoloCMS is free software!
|+===================================================*/

include('../config.php');
$x = $_GET['x'];

if(getContent('forum-enabled') !== "1"){ 
    header("Location: index.php"); 
    exit; 
}

session_start();
if(!isset($_SESSION['username'])){ 
    exit; 
}

if($x !== "topic" && $x !== "post"){ 
    exit; 
}

$message = $_POST['message'];
$topicName = $_POST['topicName'];

if(empty($topicName)){ 
    $topicName = "Pr&eacute;voir le message"; 
}

$avatarUrl = "http://www.habbo.co.uk/habbo-imaging/avatarimage?figure=".$myrow['figure']."&size=b&direction=2&head_direction=2&gesture=sml";
$groupBadgeUrl = GetUserGroup($user['id']) !== false ? "<a href=\"group_profile.php?id=".GetUserGroup($user['id'])."\"><img src=\"./habbo-imaging/badge.php?badge=".GetUserGroupBadge($user['id'])."\" /></a>" : "";
$avatarBadgeUrl = GetUserBadge($user['id']) !== false ? "<img src=\"http://images.habbohotel.co.uk/c_images/album1584/".GetUserBadge($user['id']).".gif\" />" : "";

echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"group-postlist-list\" id=\"group-postlist-list\">
<tr class=\"post-list-index-preview\">
    <td class=\"post-list-row-container\">
        <a href=\"user_profile.php?name=".$myrow['name']."\" class=\"post-list-creator-link post-list-creator-info\">".$myrow['name']."</a><br />
            &nbsp;&nbsp;<img alt=\"offline\" src=\"./web-gallery/images/myhabbo/habbo_online_anim.gif\" />
        <div class=\"post-list-posts post-list-creator-info\">Messages: ".$myrow['postcount']."</div>
        <div class=\"clearfix\">
            <div class=\"post-list-creator-avatar\"><img src=\"$avatarUrl\" alt=\"".$userdata['name']."\" /></div>
            <div class=\"post-list-group-badge\">
                $groupBadgeUrl
            </div>
            <div class=\"post-list-avatar-badge\">
                $avatarBadgeUrl
            </div>
        </div>
        <div class=\"post-list-motto post-list-creator-info\">".$userdata['mission']."</div>
    </td>
    <td class=\"post-list-message\" valign=\"top\" colspan=\"2\">
            <a href=\"#\" id=\"edit-post-message\" class=\"resume-edit-link\">&laquo; Modifier</a>
        <span class=\"post-list-message-header\"> ".$topicName."</span><br />
        <span class=\"post-list-message-time\">".$date_full."</span>
        <div class=\"post-list-report-element\">
        </div>
        <div class=\"post-list-content-element\">
            ".bbcode_format(trim(nl2br(HoloText($message))))."
        </div>
    <div>&nbsp;</div><div>&nbsp;</div>

        <div>\n";
            if($x == "topic"){
                echo "<a id=\"topic-form-cancel-preview\" class=\"new-button red-button cancel-icon\" href=\"#\"><b><span></span>Quitter</b><i></i></a>
                <a id=\"topic-form-save-preview\" class=\"new-button green-button save-icon\" href=\"#\"><b><span></span>Sauvegarder</b><i></i></a>            ";
            } else {
			  echo "<a id=\"post-form-cancel\" class=\"new-button red-button cancel-icon\" href=\"#\"><b><span></span>Quitter</b><i></i></a>
		        <a id=\"post-form-save\" class=\"new-button green-button save-icon\" href=\"#\"><b><span></span>Sauvegarder</b><i></i></a>";
			}
echo "\n	</div>
	</td>
</tr>
</table>";
