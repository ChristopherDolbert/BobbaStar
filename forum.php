<?php
    #|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
    #|                                                                        #|
    #|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
    #|																		  #|
    #|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

    include("./config.php");
	$pageid = "forum";
    $pagename = "Forum";
    
    if (!isset($_SESSION['username'])) {
        Redirect("" . $url . "/index");
    }

    $threads = $bdd->query("SELECT * FROM gabcms_config WHERE id = '1'");
$pages = $threads->fetch(PDO::FETCH_ASSOC);

$threads = $bdd->query("SELECT COUNT(*) FROM gabcms_forum_topic WHERE id='0'");
$pages = ceil(($threads + 0) / 10);

if($page > $pages || $page < 1){
	$page = 1;
}

$key = 0;

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
	        var habboImagerUrl = "<?php echo $avatarimage ?>";
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

	<body id="home" class=" ">
	    <div id="tooltip"></div>
	    <div id="overlay"></div>
	    <!-- MENU -->
	    <?PHP include("./template/header.php"); ?>
	    <!-- FIN MENU -->
	    <div id="container">
	<div id="content" style="position: relative" class="clearfix">
    <div id="mypage-wrapper" class="cbb blue">
<div class="box-tabs-container box-tabs-left clearfix">
	<div class="myhabbo-view-tools">
	</div>
    <h2 class="page-owner">
    	Forum
    </h2>
    <ul class="box-tabs">
        <li class="selected"><a href="forum.php">Forum</a><span class="tab-spacer"></span></li>
    </ul>
</div>
	<div id="mypage-content">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="content-1col">
            <tr>
                <td valign="top" style="width: 750px;" class="habboPage-col rightmost">
                    <div id="discussionbox">
<div id="group-topiclist-container">
<div class="topiclist-header clearfix">
        <input type="hidden" id="email-verfication-ok" value="1"/>
        <?php if($logged_in){ ?><a href="#" id="newtopic-upper" class="new-button verify-email newtopic-icon" style="float:left"><b><span></span>Nouveau topic</b><i></i></a><?php } ?>
    <div class="page-num-list">
    Page 
<?php
	for ($i = 1; $i <= $pages; $i++){
		if($page == $i){
			echo $i . "\n";
		} else {
			echo "<a href=\"forum.php?page=" . $i . "\" class=\"topiclist-page-link\">" . $i . "</a>\n";
		}
	} 
?>
    </div>
</div>
<table class="group-topiclist" border="0" cellpadding="0" cellspacing="0" id="group-topiclist-list">
	<tr class="topiclist-columncaption">
		<td class="topiclist-columncaption-topic">Topic</td>
		<td class="topiclist-columncaption-lastpost">Dernier post</td>
		<td class="topiclist-columncaption-replies">R&eacute;ponses</td>
		<td class="topiclist-columncaption-views">Vues</td>
	</tr>
	
<?php

if($threads == 0){
echo "	<tr class=\"topiclist-row-1\">
		<td class=\"topiclist-rowtopic\" valign=\"top\">
			Aucun topic.
		</td>
		</tr>";
}

$sql = $bdd->query("SELECT * FROM gabcms_forum_topic WHERE id='0'");
$stickies = fetch($sql);

$query_min = ($page * 10) - 10;
$query_max = 10;

$query_max = $query_max - $stickies;
$query_min = $query_min - $stickies;

if($query_min < 0){ // Page 1
$query_min = 0;
}

while($row = fetch($sql)){

	$key++;

	if(IsEven($key)){
		$x = "odd";
	} else {
		$x = "even";
	}

	echo "<tr class=\"topiclist-row-" . $x . "\">
		<td class=\"topiclist-rowtopic\" valign=\"top\">
			<div class=\"topiclist-row-content\">
			<a class=\"topiclist-link icon icon-sticky\" href=\"viewthread.php?thread=".$row['id']."\">".HoloText($row['title'])."</a>";

			if($row['type'] == 4){
			echo "&nbsp;<span class=\"topiclist-row-topicsticky\"><img src=\"./web-gallery/images/groups/status_closed.gif\" title=\"Closed Thread\" alt=\"Closed Thread\"></span>";
			}

			echo "&nbsp;(page ";

			$thread_pages = ceil(($row['posts'] + 1) / 10);

			for ($i = 1; $i <= $thread_pages; $i++){
				echo "<a href=\"viewthread.php?thread=" . $row['id'] . "&page=" . $i . "\" class=\"topiclist-page-link\">" . $i . "</a>\n";
			} 

            echo ")
			<br />
			<span><a class=\"topiclist-row-openername\" href=\"user_profile.php?name=" . $row['author'] . "\">" . $row['author'] . "</a></span>";

			$date_bits = explode(" ", $row['date']);
			$date = $date_bits[0];
			$time = $date_bits[1];
			
				echo "&nbsp;<span class=\"latestpost\">" . $date . "</span>
			<span class=\"latestpost\">(" . $time . ")</span>
			</div>
		</td>
		<td class=\"topiclist-lastpost\" valign=\"top\">
		    <a class=\"lastpost-page-link\" href=\"viewthread.php?thread=" . $row['id'] . "&sp=JumpToLast\">";

			$date_bits = explode(" ", $row['lastpost_date']);
			$date = $date_bits[0];
			$time = $date_bits[1];

				echo "<span class=\"lastpost\">" . $date . "</span>
            <span class=\"lastpost\">(" . $time . ")</span></a><br />
			<span class=\"topiclist-row-writtenby\">de:</span> <a class=\"topiclist-row-openername\" href=\"user_profile.php?name=" . $row['lastpost_author'] . "\">" . $row['lastpost_author'] . "</a>&nbsp;
		</td>
 		<td class=\"topiclist-replies\" valign=\"top\">" . $row['posts'] . "</td>
 		<td class=\"topiclist-views\" valign=\"top\">" . $row['views'] . "</td>
	</tr>";

}

$sql = $bdd->query("SELECT * FROM gabcms_forum_topic WHERE id='0'");

while($row = mysql_fetch_assoc($sql)){

	$key++;

	if(IsEven($key)){
		$x = "odd";
	} else {
		$x = "even";
	}

	echo "<tr class=\"topiclist-row-" . $x . "\">
		<td class=\"topiclist-rowtopic\" valign=\"top\">
			<div class=\"topiclist-row-content\">
			<a class=\"topiclist-link \" href=\"viewthread.php?thread=".$row['id']."\">".HoloText($row['title'])."</a>";

			if($row['type'] == 2){
			echo "&nbsp;<span class=\"topiclist-row-topicsticky\"><img src=\"./web-gallery/images/groups/status_closed.gif\" title=\"Closed Thread\" alt=\"Closed Thread\"></span>";
			}

			echo "&nbsp;(page ";

			$thread_pages = ceil(($row['posts'] + 1) / 10);

			for ($i = 1; $i <= $thread_pages; $i++){
				echo "<a href=\"viewthread.php?thread=" . $row['id'] . "&page=" . $i . "\" class=\"topiclist-page-link\">" . $i . "</a>\n";
			} 

            echo ")
			<br />
			<span><a class=\"topiclist-row-openername\" href=\"user_profile.php?name=" . $row['author'] . "\">" . $row['author'] . "</a></span>";

			$date_bits = explode(" ", $row['date']);
			$date = $date_bits[0];
			$time = $date_bits[1];
			
				echo "&nbsp;<span class=\"latestpost\">" . $date . "</span>
			<span class=\"latestpost\">(" . $time . ")</span>
			</div>
		</td>
		<td class=\"topiclist-lastpost\" valign=\"top\">
		    <a class=\"lastpost-page-link\" href=\"viewthread.php?thread=" . $row['id'] . "&sp=JumpToLast\">";

			$date_bits = explode(" ", $row['lastpost_date']);
			$date = $date_bits[0];
			$time = $date_bits[1];

				echo "<span class=\"lastpost\">" . $date . "</span>
            <span class=\"lastpost\">(" . $time . ")</span></a><br />
			<span class=\"topiclist-row-writtenby\">de:</span> <a class=\"topiclist-row-openername\" href=\"user_profile.php?name=" . $row['lastpost_author'] . "\">" . $row['lastpost_author'] . "</a>&nbsp;
		</td>
 		<td class=\"topiclist-replies\" valign=\"top\">" . $row['posts'] . "</td>
 		<td class=\"topiclist-views\" valign=\"top\">" . $row['views'] . "</td>
	</tr>";

}

?>	

	</table>
<div class="topiclist-footer clearfix">
        <?php if($logged_in){ ?><a href="#" id="newtopic-lower" class="new-button verify-email newtopic-icon" style="float:left"><b><span></span>Nouveau topic</b><i></i></a><?php } else { echo "Tu dois &ecirc;tre connect&eacute; pour poster des topics."; } ?>
    <div class="page-num-list">
    Page 
<?php
	for ($i = 1; $i <= $pages; $i++){
		if($page == $i){
			echo $i . "\n";
		} else {
			echo "<a href=\"forum.php?page=" . $i . "\" class=\"topiclist-page-link\">" . $i . "</a>\n";
		}
	} 
?>
    </div>
</div>
</div>

<script type="text/javascript" language="JavaScript">
L10N.put("myhabbo.discussion.error.topic_name_empty", "Topic title may not be empty");
Discussions.initialize("0", "forum.php", null);
</script>
                    </div>
					
                </td>
                <td style="width: 4px;"></td>
                <td valign="top" style="width: 164px;">
    <div class="habblet ">
    
    </div>
                </td>
            </tr>
        </table>
    </div>
</div>

<script type="text/javascript">
	Event.observe(window, "load", observeAnim);
	document.observe("dom:loaded", initDraggableDialogs);
</script>
    </div>
<div id="footer">
	<p><a href="index.php" target="_self">Accueil</a> | <a href="./disclaimer.php" target="_self">Conditions d'utilisation</a> | <a href="./privacy.php" target="_self">Informations pratiques</a></p>
	<?php /*@@* DO NOT EDIT OR REMOVE THE LINE BELOW WHATSOEVER! *@@*/ ?>
	<p>Powered by HoloCMS &copy; 2008 Meth0d & Parts by Yifan, sisija.<br/>
HABBO est une marque d&eacute;pos&eacute;e de Sulake Corporation LTD. Tous droits r&eacute;verv&eacute;s.<br />BioCMS est un CMS traduit et modifi&eacute; par Kiiwi.</br> Merci de respecter le travail de Kiiwi et de ne pas copier, ou enlever ce copyright.<br /> 2008/2009</p>

</div></div>

</div>

<div class="cbb topdialog black" id="dialog-group-settings">
	
	<div class="box-tabs-container">
<ul class="box-tabs">
	<li class="selected" id="group-settings-link-group"><a href="#">Groepsinstellingen</a><span class="tab-spacer"></span></li>
	<li id="group-settings-link-forum"><a href="#">Foruminstellingen</a><span class="tab-spacer"></span></li>
	<li id="group-settings-link-room"><a href="#">Kamersettings</a><span class="tab-spacer"></span></li>
</ul>
</div>

	<a class="topdialog-exit" href="#" id="dialog-group-settings-exit">X</a>
	<div class="topdialog-body" id="dialog-group-settings-body">
<p style="text-align:center"><img src="http://images.habbohotel.nl/habboweb/21_5527e6590eba8f3fb66348bdf271b5a2/17/web-gallery/images/progress_bubbles.gif" alt="" width="29" height="6" /></p>
	</div>
</div>	

<script language="JavaScript" type="text/javascript">
Event.observe("dialog-group-settings-exit", "click", function(e) {
    Event.stop(e);
    closeGroupSettings();
}, false);
</script><div class="cbb topdialog" id="postentry-verifyemail-dialog">
	<h2 class="title dialog-handle">Bevestig e-mailadres</h2>
	
	<a class="topdialog-exit" href="#" id="postentry-verifyemail-dialog-exit">X</a>
	<div class="topdialog-body" id="postentry-verifyemail-dialog-body">
	<p>Je moet je mailadres invullen voor je een reactie kunt plaatsen.</p>
	<p><a href="/profile?tab=3">Activeer je mailadres</a></p>
	<p class="clearfix">
		<a href="#" id="postentry-verifyemail-ok" class="new-button"><b>OK</b><i></i></a>
	</p>
	</div>
</div>	
					
<script type="text/javascript">
HabboView.run();
</script>

</body>
</html>