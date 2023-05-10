<?php
/*===================================================+
|| # HoloCMS - Website and Content Management System
|+===================================================+
|| # Copyright � 2008 Meth0d. All rights reserved.
|| # http://www.meth0d.org
|+===================================================+
|| # HoloCMS is provided "as is" and comes without
|| # warrenty of any kind. HoloCMS is free software!
|+===================================================*/

require_once('../config.php');
if ($hkzone !== true) {
	header("Location: index.php?throwBack=true");
	exit;
}
if (!isset($_SESSION['acp'])) {
	header("Location: index.php?p=login");
	exit;
}

$pagename = "Welcome Message Options";

if (isset($_POST['welcomemessage_enable'])) {

	$welcomemessage_enable = $_POST['welcomemessage_enable'];
	$welcomemessage_text = $_POST['welcomemessage_text'];

	if (!empty($welcomemessage_text)) {

		$sql = "UPDATE emulator_settings SET value = :welcomemessage_enable WHERE `key` = 'hotel.welcome.alert.enabled' LIMIT 1";
		$stmt = $bdd->prepare($sql);
		$stmt->execute(['welcomemessage_enable' => $welcomemessage_enable]);

		$sql = "UPDATE emulator_settings SET value = :welcomemessage_text WHERE `key` = 'hotel.welcome.alert.message' LIMIT 1";
		$stmt = $bdd->prepare($sql);
		$stmt->execute(['welcomemessage_text' => $welcomemessage_text]);

		$msg = "Settings saved successfully.";

		$sql = "INSERT INTO system_stafflog (action,message,note,userid,targetid,timestamp) VALUES ('Housekeeping','Updated Server Settings (Welcome Message Options)','welcomemsg.php',:my_id,'',:date_full)";
		$stmt = $bdd->prepare($sql);
		$stmt->execute(['my_id' => $user['id'], 'date_full' => FullDate('full')]);
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

				<form action='index.php?p=welcomemsg&do=save' method='post' name='theAdminForm' id='theAdminForm'>
					<div class='tableborder'>
						<div class='tableheaderalt'>Welcome Message Options</div>

						<table width='100%' cellspacing='0' cellpadding='5' align='center' border='0'>
							<tr>
								<td class='tablerow1' width='40%' valign='middle'><b>Enable welcome message</b></td>
								<td class='tablerow2' width='60%' valign='middle'><select name='welcomemessage_enable' class='dropdown'>
										<option value='1'>Enabled</option>
										<option value='0' <?php if (FetchEmulatorSetting('hotel.welcome.alert.enabled') == "0") {
																echo "selected='selected'";
															} ?>>Disabled</option>
									</select>

								</td>
							</tr>

							<tr>
								<td class='tablerow1' width='40%' valign='middle'><b>Welcome message</b></td>
								<td class='tablerow2' width='60%' valign='middle'><textarea name='welcomemessage_text' cols='60' rows='5' wrap='soft' id='sub_desc' class='multitext'><?php echo FetchEmulatorSetting('hotel.welcome.alert.message'); ?></textarea></td>
							</tr>


							<tr>
							<tr>
								<td align='center' class='tablesubheader' colspan='2'><input type='submit' value='Save Options' class='realbutton' accesskey='s'></td>
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