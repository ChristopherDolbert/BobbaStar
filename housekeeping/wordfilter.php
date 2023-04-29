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

$pagename = "Wordfilter Options";

if (isset($_POST['wordfilter_enable'])) {

	$wordfilter_enable = $_POST['wordfilter_enable'];
	$wdroom = $_POST['wordfilter_room'];
	$wdmess = $_POST['wordfilter_messenger'];
	$wdmte = $_POST['wordfilter_automute'];
	$wdrpl = $_POST['wordfilter_replacement'];

	if (!empty($wdrpl)) {

		$sql = "UPDATE emulator_settings SET value = :wordfilter_enable WHERE `key` = 'hotel.wordfilter.enabled' LIMIT 1";
		$stmt = $bdd->prepare($sql);
		$stmt->execute(['wordfilter_enable' => $wordfilter_enable]);

		$sql = "UPDATE emulator_settings SET value = :wdroom WHERE `key` = 'hotel.wordfilter.rooms' LIMIT 1";
		$stmt = $bdd->prepare($sql);
		$stmt->execute(['wdroom' => $wdroom]);

		$sql = "UPDATE emulator_settings SET value = :wdmess WHERE `key` = 'hotel.wordfilter.messenger' LIMIT 1";
		$stmt = $bdd->prepare($sql);
		$stmt->execute(['wdmess' => $wdmess]);

		$sql = "UPDATE emulator_settings SET value = :wdmte WHERE `key` = 'hhotel.wordfilter.automute' LIMIT 1";
		$stmt = $bdd->prepare($sql);
		$stmt->execute(['wdmte' => $wdmte]);

		$sql = "UPDATE emulator_settings SET value = :wdrpl WHERE `key` = 'hotel.wordfilter.replacement' LIMIT 1";
		$stmt = $bdd->prepare($sql);
		$stmt->execute(['wdrpl' => $wdrpl]);

		$msg = "Settings saved successfully.";

		$sql = "INSERT INTO system_stafflog (action,message,note,userid,targetid,timestamp) VALUES ('Housekeeping','Updated Server Settings (Wordfilter Options)','wordfilter.php',:my_id,'',:date_full)";
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

				<form action='index.php?p=wordfilter&do=save' method='post' name='theAdminForm' id='theAdminForm'>
					<div class='tableborder'>
						<div class='tableheaderalt'>Wordfilter Options</div>

						<table width='100%' cellspacing='0' cellpadding='5' align='center' border='0'>
							<tr>
								<td class='tablerow1' width='40%' valign='middle'><b>Enable woldfilter</b></td>
								<td class='tablerow2' width='60%' valign='middle'><select name='wordfilter_enable' class='dropdown'>
										<option value='1'>Enabled</option>
										<option value='0' <?php if (FetchEmulatorSetting('hotel.wordfilter.enabled') == "0") {
																echo "selected='selected'";
															} ?>>Disabled</option>
									</select>

								</td>
							</tr>

							<tr>
								<td class='tablerow1' width='40%' valign='middle'><b>Room woldfilter</b></td>
								<td class='tablerow2' width='60%' valign='middle'><select name='wordfilter_room' class='dropdown'>
										<option value='1'>Enabled</option>
										<option value='0' <?php if (FetchEmulatorSetting('hotel.wordfilter.rooms') == "0") {
																echo "selected='selected'";
															} ?>>Disabled</option>
									</select>

								</td>
							</tr>

							<tr>
								<td class='tablerow1' width='40%' valign='middle'><b>Wordfilter automute</b></td>
								<td class='tablerow2' width='60%' valign='middle'><select name='wordfilter_automute' class='dropdown'>
										<option value='1'>Enabled</option>
										<option value='0' <?php if (FetchEmulatorSetting('hotel.wordfilter.automute') == "0") {
																echo "selected='selected'";
															} ?>>Disabled</option>
									</select>

								</td>
							</tr>

							<tr>
								<td class='tablerow1' width='40%' valign='middle'><b>Messenger woldfilter</b></td>
								<td class='tablerow2' width='60%' valign='middle'><select name='wordfilter_messenger' class='dropdown'>
										<option value='1'>Enabled</option>
										<option value='0' <?php if (FetchEmulatorSetting('hotel.wordfilter.messenger') == "0") {
																echo "selected='selected'";
															} ?>>Disabled</option>
									</select>

								</td>
							</tr>

							<tr>
								<td class='tablerow1' width='40%' valign='middle'><b>Wordfilter replacement</b></td>
								<td class='tablerow2' width='60%' valign='middle'><input type='text' name='wordfilter_replacement' value="<?php echo FetchEmulatorSetting('hotel.wordfilter.replacement'); ?>" size='30' class='textinput'></td>
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