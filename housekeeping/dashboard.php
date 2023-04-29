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

$pagename = "Dashboard";

if (isset($_POST['notes'])) {
	$notes = filter_var($_POST['notes'], FILTER_SANITIZE_STRING);
	$stmt = $bdd->prepare("UPDATE cms_system SET admin_notes = :notes LIMIT 1");
	$stmt->execute(array(':notes' => $notes));
}

$stmt = $bdd->query("SELECT * FROM cms_system LIMIT 1");
$system = $stmt->fetch(PDO::FETCH_ASSOC);

$onlineCutOff = (time() - 601);
$stmt = $bdd->prepare("SELECT COUNT(*) FROM users WHERE online > ?");
$stmt->execute(array($onlineCutOff));
$onlineUsers = $stmt->fetchColumn();


@include('subheader.php');
@include('header.php');
?>
<table cellpadding='0' cellspacing='8' width='100%' id='tablewrap'>
	<tr>
		<td width='100%' valign='top' id='rightblock'>
			<div><!-- RIGHT CONTENT BLOCK -->


				<div style='font-size:30px; padding-left:7px; letter-spacing:-2px; border-bottom:1px solid #EDEDED'>
					MyHabbo Housekeeping
				</div>
				<br />
				<div id='ipb-get-members' style='border:1px solid #000; background:#FFF; padding:2px;position:absolute;width:120px;display:none;z-index:100'></div>
				<!--in_dev_notes-->
				<!--in_dev_check-->
				<table border='0' width='100%' cellpadding='0' cellspacing='4'>
					<tr>
						<td valign='top' width='75%'>
							<table border='0' width='100%' cellpadding='0' cellspacing='0'>
								<tr>
									<td>
										<div class='homepage_pane_border'>
											<div class='homepage_section'>Tasks and Statistics</div>
											<table width='100%' cellspacing='0' cellpadding='4'>
												<tr>
													<td width='50%' valign='top'>
														<div class='homepage_border'>
															<div class='homepage_sub_header'>System Overview</div>
															<table width='100%' cellpadding='4' cellspacing='0'>
																<tr>
																	<td class='homepage_sub_row' width='60%'><strong>Version de MyHabbo</strong> &nbsp;</td>
																	<td class='homepage_sub_row' width='40%'><strong><?php echo $version; ?></td>
																</tr>
																<tr>
																	<td class='homepage_sub_row'><strong>Members</strong></td>
																	<td class='homepage_sub_row'>
																		<?php echo IsUserOnline(1) . " (<a href='index.php?p=onlinelist'>" . $onlineUsers . "</a> online)"; ?>
																	</td>
																</tr>
																<tr>
																	<td class='homepage_sub_row'><strong>Rooms</strong></td>
																	<td class='homepage_sub_row'>
																		<?php
																		$stmt = $bdd->prepare('SELECT COUNT(*) FROM rooms');
																		$stmt->execute();
																		$result = $stmt->fetchColumn();
																		echo $result;
																		?>
																		(of which
																		<?php
																		$stmt = $bdd->prepare('SELECT COUNT(*) FROM rooms WHERE is_public = 1');
																		$stmt->execute();
																		$result = $stmt->fetchColumn();
																		echo $result;
																		?>

																		public rooms)
																	</td>
																</tr>
																<tr>
																	<td class='homepage_sub_row'><strong>Furniture</strong></td>
																	<td class='homepage_sub_row'>
																		<?php
																		$stmt = $bdd->prepare('SELECT COUNT(*) FROM items');
																		$stmt->execute();
																		$result = $stmt->fetchColumn();
																		echo $result;
																		?>
																	</td>
																</tr>
																<tr>
																	<td class='homepage_sub_row'><strong>Groups</strong></td>
																	<td class='homepage_sub_row'>
																		<?php
																		$stmt = $bdd->prepare('SELECT COUNT(*) FROM guilds');
																		$stmt->execute();
																		$result = $stmt->fetchColumn();
																		echo $result;
																		?>
																	</td>
																</tr>
																<tr>
																	<td class='homepage_sub_row'><strong>Stafflog Entries</strong></td>
																	<td class='homepage_sub_row'>
																		<?php
																		$stmt = $bdd->prepare('SELECT COUNT(*) FROM system_stafflog');
																		$stmt->execute();
																		$result = $stmt->fetchColumn();
																		echo $result;
																		?>
																	</td>
																</tr>
																<tr>
																	<td class='homepage_sub_row'><strong>Active Bans</strong></td>
																	<td class='homepage_sub_row'>
																		<a href='index.php?p=banlist'>
																			<?php
																			$stmt = $bdd->prepare('SELECT COUNT(*) FROM bans');
																			$stmt->execute();
																			$result = $stmt->fetchColumn();
																			echo $result;
																			?>
																		</a>
																	</td>
																</tr>

															</table>
														</div>
													</td>
													<td width='50%' valign='top'>
														<div class='homepage_border'>
															<div class='homepage_sub_header'>Server Setup</div>
															<table width='100%' cellpadding='4' cellspacing='0'>
																<tr>
																	<td class='homepage_sub_row'><strong>Game Port</strong></td>
																	<td class='homepage_sub_row'>
																		<?php echo FetchServerSetting(['port']); ?>
																	</td>
																</tr>
																<tr>
																	<td class='homepage_sub_row'><strong>&nbsp;&nbsp;&nbsp;&nbsp;- MUS Port</strong></td>
																	<td class='homepage_sub_row'>
																		<?php echo FetchServerSetting('mus_port'); ?>
																	</td>
																</tr>
																<tr>
																	<td class='homepage_sub_row'><strong>Trading Enabled</strong></td>
																	<td class='homepage_sub_row'>
																		<?php echo FetchServerSetting('trading_enable', true); ?>
																	</td>
																</tr>
																<tr>
																	<td class='homepage_sub_row'><strong>Recycler Enabled</strong></td>
																	<td class='homepage_sub_row'>
																		<?php echo FetchServerSetting('recycler_enable', true); ?>
																	</td>
																</tr>
																<tr>
																	<td class='homepage_sub_row'><strong>Wordfilter Enabled</strong></td>
																	<td class='homepage_sub_row'>
																		<?php echo FetchServerSetting('wordfilter_enable', true); ?> (<?php echo FetchServerSetting('wordfilter_censor'); ?>)
																	</td>
																</tr>
															</table>
														</div>
													</td>
												</tr>
											</table>
										</div>
									</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>
										<div class='homepage_pane_border'>
											<div class='homepage_section'>Communication</div>
											<table width='100%' cellspacing='0' cellpadding='4'>
												<tr>
													<td valign='top' width='50%'>
														<div class='homepage_border'>
															<div class='homepage_sub_header'>Housekeeping Notes</div>
															<br />
															<div align='center'>
																<form action='index.php?p=dashboard&do=save' method='post'>
																	<textarea name='notes' style='background-color:#F9FFA2;border:1px solid #CCC;width:95%;font-family:verdana;font-size:10px' rows='8' cols='25'><?php echo Secu($system['admin_notes']); ?></textarea>
																	<div><br /><input type='submit' value='Save Admin Notes' class='realbutton' /></div>
																</form>
															</div><br />
														</div>
													</td>
													<td width='50%' valign='top'>
														<div class='homepage_border'>
															<div class='homepage_sub_header'><?php echo $sitename; ?> Administrators</div>
															<table width='100%' cellpadding='4' cellspacing='0'>
																<?php
																$sql = "SELECT id, username, mail FROM users WHERE rank > 6 ORDER BY username ASC LIMIT 20";
																$stmt = $bdd->query($sql);

																// Boucle pour récupérer les résultats de la requête
																while ($row = $stmt->fetch()) {
																	printf(" <tr>
 <td class='tablerow1' align='center'>
	 <strong><div style='font-size:12px'><a href='../user_profile.php?name=%s' target='_blank'>%s</a></strong> (ID: %d)
</td>
 <td class='tablerow2'>
	<div style='margin-top:6px'><a href='mailto:%s'>%s</a></div>
</td>
</tr>", $row['username'], $row['username'], $row['id'], $row['mail'], $row['mail']);
																}
																?>
															</table>
														</div>
													</td>
												</tr>
											</table>
										</div>
									</td>
								</tr>

							</table>
						</td>
						<td valign='top' width='25%'>
							<div id='acp-update-wrapper'>
								<div class='homepage_pane_border' id='acp-update-normal'>
									<div class='homepage_section'>Mise a jours MyHabbo</div>
									<div style='font-size:12px;padding:4px; text-align:center'>
										<p>

											<br />
											regarder le <a href='http://habbohotel.britania.ws/showthread.php?tid=4170'>topic de MyHabbo</a> pour voir les patch secu ou nouvelle version
										</p>
									</div>
								</div>
								<br />
							</div>
							<div id='acp-update-wrapper'>
								<div class='homepage_pane_border' id='acp-update-normal'>
									<div class='homepage_section'>Donation pour MyHabbo</div>
									<div style='font-size:12px;padding:4px; text-align:center'>
										<p>
											Merci de faire des <strong>Dons</strong> a MyHabbo pour nous aider a ameliorer MyHabbo il se peut que si nous avons pas asser de dons la prochaine version risque d'etre closed source (version payents)
											<strong><a href="http://88.191.226.237/MyHabbo">> Faire un dons allopass << /a></strong>
									</div>
									<br />
								</div>

								<br />
							</div>
			</div><!-- / RIGHT CONTENT BLOCK -->
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