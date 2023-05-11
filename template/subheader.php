<?php
/*---------------------------------------------------+
| HoloCMS - Website and Content Management System
+----------------------------------------------------+
| Copyright � 2008 Meth0d
+----------------------------------------------------+
| HoloCMS is provided "as is" and comes without
| warrenty of any kind.
+---------------------------------------------------*/

if (!isset($_SESSION['username'])) {
	Redirect("" . $url . "/index");
	exit;
}

if (!isset($pagename) || empty($pagename)) {
	$pagename = $shortname;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

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

	<?php if ($pageid == "pageid" || empty($pageid)) { ?>
		<link rel="stylesheet" href="./web-gallery/v2/styles/welcome.css" type="text/css" />
		<link rel="stylesheet" href="./web-gallery/v2/styles/personal.css" type="text/css" />

		<link rel="stylesheet" href="./web-gallery/v2/styles/group.css" type="text/css" />
		<script src="web-gallery/static/js/group.js" type="text/javascript"></script>

		<link rel="stylesheet" href="./web-gallery/v2/styles/rooms.css" type="text/css" />
		<script src="web-gallery/static/js/rooms.js" type="text/javascript"></script>
	<?php } ?>

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

	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/minimail.css" type="text/css" />
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>styles/myhabbo/control.textarea.css" type="text/css" />
	<script src="<?PHP echo $imagepath; ?>static/js/minimail.js" type="text/javascript"></script>

	<meta name="description" content="<?PHP echo $description; ?>" />
	<meta name="keywords" content="<?PHP echo $keyword; ?>" />
	<meta name="build" content="<?PHP echo $build; ?> >> <?PHP echo $version; ?>" />

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
</head>