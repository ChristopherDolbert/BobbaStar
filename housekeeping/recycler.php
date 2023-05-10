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

$pagename = "Recycler Options";

if (isset($_POST['recycler_enable'])) {
	$recycler_enable = $_POST['recycler_enable'];
	$sql = "UPDATE emulator_settings SET value = :recycler_enable WHERE `key` = 'hotel.catalog.recycler.enabled' LIMIT 1";
	$stmt = $bdd->prepare($sql);
	$stmt->execute(['recycler_enable' => $recycler_enable]);

	$msg = "Settings saved successfully.";

	$sql = "INSERT INTO system_stafflog (action,message,note,userid,targetid,timestamp) VALUES ('Housekeeping','Updated Server Settings (Recycler Options)','recycler.php',:my_id,'',:date_full)";
	$stmt = $bdd->prepare($sql);
	$stmt->execute(['my_id' => $user['id'], 'date_full' => FullDate('full')]);
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

				<form action='index.php?p=recycler&do=save' method='post' name='theAdminForm' id='theAdminForm'>
					<div class='tableborder'>
						<div class='tableheaderalt'>Recycler Options</div>

						<table width='100%' cellspacing='0' cellpadding='5' align='center' border='0'>
							<tr>
								<td class='tablerow1' width='40%' valign='middle'><b>Enable recycler</b></td>
								<td class='tablerow2' width='60%' valign='middle'><select name='recycler_enable' class='dropdown'>
										<option value='1'>Enabled</option>
										<option value='0' <?php if (FetchEmulatorSetting('hotel.catalog.recycler.enabled') == "0") {
																echo "selected='selected'";
															} ?>>Disabled</option>
									</select>

								</td>
							</tr>

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