<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

require_once('../config.php');

if ($hkzone !== true) {
	header("Location: index.php?throwBack=true");
	exit;
}

if (!isset($_SESSION['acp'])) {
	header("Location: index.php?p=login");
	exit;
}

$pagename = "Server Configuration";

if (isset($_POST['game_port'])) {

	$game_port = $_POST['game_port'];
	$mus_port = $_POST['mus_port'];
	$mus_host = $_POST['mus_host'];

	if (!empty($game_port) && !empty($mus_port) && !empty($mus_host)) {

		$stmt = $bdd->prepare("UPDATE gabcms_client SET port = ? WHERE id = 1 LIMIT 1");
		$stmt->execute([$game_port]);

		$stmt = $bdd->prepare("UPDATE gabcms_client SET mus_port = ? WHERE id = 1 LIMIT 1");
		$stmt->execute([$mus_port]);

		$stmt = $bdd->prepare("UPDATE gabcms_client SET ip = ? WHERE id = 1 LIMIT 1");
		$stmt->execute([$mus_host]);

		$msg = "Settings saved successfully.";

		$stmt = $bdd->prepare("INSERT INTO system_stafflog (action,message,note,userid,targetid,timestamp) VALUES ('Housekeeping','Updated Server Settings (General Configuration)','server.php',?,?,?)");
		$stmt->execute([$user['id'], '', FullDate('full')]);
	} else {

		$msg = "Please do not leave any fields blank. Settings not saved.";
	}
}

@include('subheader.php');
@include('header.php');
?>
<table cellpadding='0' cellspacing='8' width='100%' id='tablewrap'>
	<tr>
		<td width='22%' valign='top' id='leftblock'>
			<div>
				<!-- LEFT CONTEXT SENSITIVE MENU -->
				<?php @include('servermenu.php'); ?>
				<!-- / LEFT CONTEXT SENSITIVE MENU -->
			</div>
		</td>
		<td width='78%' valign='top' id='rightblock'>
			<div><!-- RIGHT CONTENT BLOCK -->

				<?php if (isset($msg)) { ?><p><strong><?php echo $msg; ?></strong></p><?php } ?>

				<form action='index.php?p=server&do=save' method='post' name='theAdminForm' id='theAdminForm'>
					<div class='tableborder'>
						<div class='tableheaderalt'>General Configuration</div>

						<table width='100%' cellspacing='0' cellpadding='5' align='center' border='0'>
							<tr>
								<td class='tablerow1' width='40%' valign='middle'><b>Game Port</b>
									<div class='graytext'>This is the port the game server will listen on.</div>
								</td>
								<td class='tablerow2' width='60%' valign='middle'><input type='text' name='game_port' value="<?php
																		$server_setting_value = FetchServerSetting('port');
																		echo $server_setting_value;
																		?>" size='30' class='textinput'></td>
							</tr>

							<tr>
								<td class='tablerow1' width='40%' valign='middle'><b>MUS Port</b>
									<div class='graytext'>This is the port the MUS socket will listen on.</div>
								</td>
								<td class='tablerow2' width='60%' valign='middle'><input type='text' name='mus_port' value="<?php
																		$server_setting_value = FetchServerSetting('mus_port');
																		echo $server_setting_value;
																		?>" size='30' class='textinput'></td>
							</tr>

							<tr>
								<td class='tablerow1' width='40%' valign='middle'><b>MUS Host</b>
									<div class='graytext'>The only IP address or hostname the MUS socket will accept connections from.</div>
								</td>
								<td class='tablerow2' width='60%' valign='middle'><input type='text' name='mus_host' value="<?php
																		$server_setting_value = FetchServerSetting('ip');
																		echo $server_setting_value;
																		?>" size='30' class='textinput'></td>
							</tr>

							<tr>
							<tr>
								<td align='center' class='tablesubheader' colspan='2'><input type='submit' value='Save Configuration' class='realbutton' accesskey='s'></td>
							</tr>
				</form>
</table>
</div><br /> </div><!-- / RIGHT CONTENT BLOCK -->
</td>
</tr>
</table>
</div><!-- / OUTERDIV -->
<div align='center'><br />
	<?php
	$mtime = explode(' ', microtime());
	$totaltime = $mtime[0] + $mtime[1] - $starttime;
	printf('Time: %.3f', $totaltime);
	?>
</div>