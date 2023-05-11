<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

$page = "inbox";
$bypass = true;

include('../config.php');


if (isset($_GET['messageId'])) {
	$mesid = $_GET['messageId'];
	$label = $_GET['label'];

	// assume $pdo is a PDO object connected to a database
	$stmt = $bdd->prepare("SELECT * FROM cms_minimail WHERE id = ?");
	$stmt->execute([$mesid]);
	$row = $stmt->fetch(PDO::FETCH_ASSOC);

	$stmt2 = $bdd->prepare("SELECT * FROM users WHERE id = ?");
	$stmt2->execute([$row['senderid']]);
	$senderrow = $stmt2->fetch(PDO::FETCH_ASSOC);

	$stmt3 = $bdd->prepare("SELECT * FROM users WHERE id = ?");
	$stmt3->execute([$row['to_id']]);
	$torow = $stmt3->fetch(PDO::FETCH_ASSOC);
?>

	<ul class="message-headers">
		<li><a href="#" class="report" title="Report as offensive"></a></li>
		<li><b>Subject:</b> <?php echo htmlspecialchars($row['subject'], ENT_QUOTES); ?></li>
		<li><b>From:</b> <?php echo htmlspecialchars($senderrow['name'], ENT_QUOTES); ?></li>
		<li><b>To:</b> <?php echo htmlspecialchars($torow['name'], ENT_QUOTES); ?></li>
	</ul>
	<div class="body-text"><?php echo Secu($row['message'], false, true); ?><br></div>
	<div class="reply-controls">
		<div>
			<div class="new-buttons clearfix">
				<?php if ($row['conversationid'] != '0') { ?>
					<a href="#" class="related-messages" id="rel-<?php echo htmlspecialchars($row['conversationid'], ENT_QUOTES); ?>" title="Show full conversation"></a>
				<?php } ?>
				<?php if ($label == "trash") { ?>
					<a href="#" class="new-button undelete"><b>Undelete</b><i></i></a>
					<a href="#" class="new-button red-button delete"><b>Delete</b><i></i></a>
				<?php } elseif ($label == "inbox") { ?>
					<a href="#" class="new-button red-button delete"><b>Delete</b><i></i></a>
					<a href="#" class="new-button reply"><b>Reply</b><i></i></a>
				<?php } ?>
			</div>
		</div>
		<div style="display: none;">
			<textarea rows="5" cols="10" class="message-text"></textarea><br>
			<div class="new-buttons clearfix">
				<a href="#" class="new-button cancel-reply"><b>Cancel</b><i></i></a>
				<a href="#" class="new-button preview"><b>Preview</b><i></i></a>
				<a href="#" class="new-button send-reply"><b>Send</b><i></i></a>
			</div>
		</div>
	</div>

	<?php
	if ($label == "inbox") {
		$stmt4 = $bdd->prepare("UPDATE cms_minimail SET read_mail = '1' WHERE id = ?");
		$stmt4->execute([$mesid]);
	}
}


if (isset($_POST['label']) or $bypass == "true") {
	$label = isset($_POST['label']) ? $_POST['label'] : "";
	$start = isset($_POST['start']) ? $_POST['start'] : "";
	$conversationid = isset($_POST['conversationId']) ? $_POST['conversationId'] : "";
	$unread = isset($_POST['unreadOnly']) ? $_POST['unreadOnly'] : "";

	if ($bypass == "true") {
		$label = $page ?? "";
		$start = $startpage ?? "";
	}


	?>
	<a href="#" class="new-button compose"><b>Nouveau</b><i></i></a>

	<div class="clearfix labels nostandard">
		<ul class="box-tabs">
			<?php
			$stmt = $bdd->prepare("SELECT COUNT(*) AS count FROM cms_minimail WHERE to_id = ? AND read_mail = 0");
			$stmt->execute([$user['id']]);
			$unreadmail = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
			?>
			<li <?php if ($label == "inbox") {
					echo "class=\"selected\"";
				} ?>><a href="#" label="inbox">Boite<?php if ($unreadmail <> 0) {
														echo " (" . htmlspecialchars($unreadmail, ENT_QUOTES) . ")";
													} ?></a><span class="tab-spacer"></span></li>
			<li <?php if ($label == "sent") {
					echo "class=\"selected\"";
				} ?>><a href="#" label="sent">Envoy&eacute;s</a><span class="tab-spacer"></span></li>
			<li <?php if ($label == "trash") {
					echo "class=\"selected\"";
				} ?>><a href="#" label="trash">Corbeille</a><span class="tab-spacer"></span></li>
		</ul>
	</div>


	<div id="message-list" class="label-<?php echo $label; ?>">
		<div class="new-buttons clearfix">
			<div class="labels inbox-refresh"><a href="#" class="new-button green-button" label="inbox" style="float: left; margin: 0"><b>Rafra&icirc;chir</b><i></i></a></div>
		</div>

		<div style="clear: both; height: 1px"></div>
		<?php if ($label == "inbox") { ?>
			<div class="navigation">
				<div class="unread-selector"><input type="checkbox" class="unread-only" <?php if ($unread == "true") {
																							echo "checked";
																						} ?> /> non lus</div>
				<?php
				$stmt1 = $bdd->prepare("SELECT COUNT(*) AS count FROM cms_minimail WHERE to_id = ? AND deleted = 0");
				$stmt1->execute([$user['id']]);
				$allmail = $stmt1->fetch(PDO::FETCH_ASSOC)['count'];

				$stmt2 = $bdd->prepare("SELECT COUNT(*) AS count FROM cms_minimail WHERE to_id = ? AND deleted = 0 AND read_mail = 0");
				$stmt2->execute([$user['id']]);
				$unreadmail = $stmt2->fetch(PDO::FETCH_ASSOC)['count'];

				if ($unread == "true") {
					$allnum = $unreadmail;
				} else {
					$allnum = $allmail;
				}
				if ($start != null) {
					$offset = $start;
					$startnum = $start + 1;
					$endnum = $start + 10;
					if ($endnum > $allnum) {
						$endnum = $allnum;
					}
				} else {
					$stmt = $bdd->prepare("SELECT COUNT(*) AS count FROM cms_minimail WHERE to_id = ? AND deleted = 0 LIMIT 10");
					$stmt->execute([$user['id']]);
					$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
					$endnum = count($rows);

					$offset = "0";
					$startnum = "1";
				}
				$var1 = " <a href=\"#\" class=\"newer\">Newer</a> ";
				$var2 = " " . $startnum . " - " . $endnum . " of " . $allnum . " ";
				$var3 = " <a href=\"#\" class=\"older\">Older</a> ";
				$var4 = " <a href=\"#\" class=\"newest\">Newest</a> ";
				$var5 = "<!-- <a href=\"#\" class=\"oldest\">Oldest</a> -->";
				$totalpages = ceil($allnum / 10);
				if ($endnum != $allnum && $startnum != 1) {
					$maillist = $var1 . $var2 . $var3;
				} elseif ($endnum != $allnum && $startnum == 1) {
					$maillist = $var2 . $var3;
				} elseif ($endnum == $allnum && $startnum != 1) {
					$maillist = $var1 . $var2;
				} elseif ($endnum == $allnum && $startnum == 1) {
					$maillist = $var2;
				}
				if ($startnum + 20 < $allnum && $endnum <> $allnum) {
					$maillist = $maillist . $var5;
				}
				if ($startnum - 20 > 0) {
					$maillist = $var4 . $maillist;
				}
				$maillist = "<p>" . $maillist . "</p>";
				?>
				<?php if ($allmail == 0) { ?>
					<p class="no-messages">
						Pas de messages
					</p>
				<?php } elseif ($unreadmail == "0" && $unread == "true") { ?>
					<p class="no-messages">
						No unread messages
					</p>
				<?php } ?>
				<div class="progress"></div>
				<?php if ($unread == "true") {
					if ($unreadmail <> 0) {
						echo $maillist;
					}
				} else {
					if ($allmail <> 0) {
						echo $maillist;
					}
				} ?>
			</div>

			<?php
			$i = 0;
			if ($unread == "true") {
				$stmt = $bdd->prepare("SELECT * FROM cms_minimail WHERE to_id = ? AND deleted = 0 AND read_mail = 0 ORDER BY ID DESC LIMIT 10");
				$stmt->execute([$user['id']]); // cast offset to integer to avoid syntax error
			} else {
				$stmt = $bdd->prepare("SELECT * FROM cms_minimail WHERE to_id = ? AND deleted = 0 ORDER BY id DESC LIMIT 10");
				$stmt->execute([$user['id']]);
			}




			$getem = $stmt->fetchAll(PDO::FETCH_ASSOC);

			foreach ($getem as $row) {
				$i++;

				if ($row['read_mail'] == 0) {
					$read = "unread";
				} else {
					$read = "read";
				}

				$stmt = $bdd->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
				$stmt->execute([$row['senderid']]);
				$senderrow = $stmt->fetch(PDO::FETCH_ASSOC);
				$figure = $avatarimage . "?figure=" . $senderrow['figure'] . "&size=s&direction=9&head_direction=2&gesture=sml";

				printf("<div class=\"message-item %s \" id=\"msg-%s\">
							<div class=\"message-preview\" status=\"%s\">
			
								<span class=\"message-tstamp\" isotime=\"%s\" title=\"%s\">
									%s
								</span>
								<img src=\"%s\" />
								<span class=\"message-sender\" title=\"%s\">%s</span>
			
								<span class=\"message-subject\" title=\"%s\">&ldquo;%s&rdquo;</span>
							</div>
							<div class=\"message-body\" style=\"display: none;\">
								<div class=\"contents\"></div>
			
								<div class=\"message-body-bottom\"></div>
							</div>
				</div>", $read, $row['id'], $read, $row['date'], $row['date'], $row['date'], $figure, $senderrow['name'], $senderrow['name'], $row['subject'], $row['subject']);
			}

			?>

			<div class="navigation">
				<div class="progress"></div>

				<?php if ($unread == "true") {
					if ($unreadmail <> 0) {
						echo $maillist;
					}
				} else {
					if ($allmail <> 0) {
						echo $maillist;
					}
				} ?>
			</div>

	</div>
<?php } elseif ($label == "sent") { ?>
	<div class="navigation">
		<?php
			$sql1 = $bdd->query("SELECT * FROM cms_minimail WHERE senderid = '" . $user['id'] . "'");
			$allmail = $sql1->rowCount();
			$allnum = $allmail;
			if ($start != null) {
				$offset = $start;
				$startnum = $start + 1;
				$endnum = $start + 10;
				if ($endnum > $allnum) {
					$endnum = $allnum;
				}
			} else {
				$sql1 = $bdd->query("SELECT * FROM cms_minimail WHERE senderid = '" . $user['id'] . "' AND deleted = '0' LIMIT 10");
				$endnum = $sql1->rowCount();
				$offset = "0";
				$startnum = "1";
			}
			$var1 = " <a href=\"#\" class=\"newer\">Newer</a> ";
			$var2 = " " . $startnum . " - " . $endnum . " of " . $allnum . " ";
			$var3 = " <a href=\"#\" class=\"older\">Older</a> ";
			$var4 = " <a href=\"#\" class=\"newest\">Newest</a> ";
			$var5 = "<!-- <a href=\"#\" class=\"oldest\">Oldest</a> -->";
			$totalpages = ceil($allnum / 10);
			if ($endnum != $allnum && $startnum != 1) {
				$maillist = $var1 . $var2 . $var3;
			} elseif ($endnum != $allnum && $startnum == 1) {
				$maillist = $var2 . $var3;
			} elseif ($endnum == $allnum && $startnum != 1) {
				$maillist = $var1 . $var2;
			} elseif ($endnum == $allnum && $startnum == 1) {
				$maillist = $var2;
			}
			if ($startnum + 20 < $allnum && $endnum <> $allnum) {
				$maillist = $maillist . $var5;
			}
			if ($startnum - 20 > 0) {
				$maillist = $var4 . $maillist;
			}
			$maillist = "<p>" . $maillist . "</p>";
		?>
		<?php if ($allmail == 0) { ?>
			<p class="no-messages">
				No sent messages
			</p>
		<?php } ?>
		<div class="progress"></div>

		<?php if ($allmail <> 0) {
				echo $maillist;
			} ?>
	</div>
	<?php
			$i = 0;
			$getem = $bdd->prepare("SELECT * FROM cms_minimail WHERE senderid = :my_id ORDER BY id DESC LIMIT 10 OFFSET :offset");
			$getem->bindParam(':my_id', $user['id']);
			$getem->bindParam(':offset', $offset, PDO::PARAM_INT);
			$getem->execute();

			while ($row = $getem->fetch(PDO::FETCH_ASSOC)) {
				$i++;

				if ($row['read_mail'] == 0) {
					$read = "unread";
				} else {
					$read = "read";
				}

				$stmt = $bdd->prepare("SELECT * FROM users WHERE id = ?");
				$stmt->execute([$row['senderid']]);
				$senderrow = $stmt->fetch(PDO::FETCH_ASSOC);

				$figure = $avatarimage . "" . $senderrow['figure'] . "&size=s&direction=9&head_direction=2&gesture=sml";

				printf("	<div class=\"message-item %s \" id=\"msg-%s\">
				<div class=\"message-preview\" status=\"%s\">

					<span class=\"message-tstamp\" isotime=\"%s\" title=\"%s\">
						%s
					</span>
					<img src=\"%s\" />
					<span class=\"message-sender\" title=\"To: %s\">To: %s</span>

					<span class=\"message-subject\" title=\"%s\">&ldquo;%s&rdquo;</span>
				</div>
				<div class=\"message-body\" style=\"display: none;\">
					<div class=\"contents\"></div>

					<div class=\"message-body-bottom\"></div>
				</div>
			</div>", $read, $row['id'], $read, $row['date'], $row['date'], $row['date'], $figure, $senderrow['name'], $senderrow['name'], $row['subject'], $row['subject']);
			}
	?>

	<div class="navigation">
		<div class="progress"></div>

		<?php if ($allmail <> 0) {
				echo $maillist;
			} ?>
	</div>
<?php } elseif ($label == "trash") { ?>
	<div class="trash-controls notice">
		Messages in this folder that are older than 30 days are deleted automatically. <a href="#" class="empty-trash">Empty trash</a>

	</div>

	<div class="navigation">
		<?php
			$stmt = $bdd->prepare("SELECT * FROM cms_minimail WHERE to_id = :my_id AND deleted = '1'");
			$stmt->bindParam(':my_id', $user['id']);
			$stmt->execute();
			$allmail = $stmt->rowCount();
			$allnum = $allmail;

			if ($start != null) {
				$offset = $start;
				$startnum = $start + 1;
				$endnum = $start + 10;
				if ($endnum > $allnum) {
					$endnum = $allnum;
				}
			} else {
				$stmt = $bdd->prepare("SELECT * FROM cms_minimail WHERE to_id = :my_id AND deleted = '1' LIMIT 10");
				$stmt->bindParam(':my_id', $user['id']);
				$stmt->execute();
				$endnum = $stmt->rowCount();
				$offset = "0";
				$startnum = "1";
			}

			$var1 = " <a href=\"#\" class=\"newer\">Newer</a> ";
			$var2 = " " . $startnum . " - " . $endnum . " of " . $allnum . " ";
			$var3 = " <a href=\"#\" class=\"older\">Older</a> ";
			$var4 = " <a href=\"#\" class=\"newest\">Newest</a> ";
			$var5 = "<!-- <a href=\"#\" class=\"oldest\">Oldest</a> -->";

			$totalpages = ceil($allnum / 10);

			if ($endnum != $allnum && $startnum != 1) {
				$maillist = $var1 . $var2 . $var3;
			} elseif ($endnum != $allnum && $startnum == 1) {
				$maillist = $var2 . $var3;
			} elseif ($endnum == $allnum && $startnum != 1) {
				$maillist = $var1 . $var2;
			} elseif ($endnum == $allnum && $startnum == 1) {
				$maillist = $var2;
			}

			if ($startnum + 20 < $allnum && $endnum <> $allnum) {
				$maillist = $maillist . $var5;
			}

			if ($startnum - 20 > 0) {
				$maillist = $var4 . $maillist;
			}

			$maillist = "<p>" . $maillist . "</p>";

		?>
		<?php if ($allmail == 0) { ?>
			<p class="no-messages">
				No deleted messages
			</p>
		<?php } ?>
		<div class="progress"></div>

		<?php if ($allmail <> 0) {
				echo $maillist;
			} ?>
	</div>
	<?php
			$i = 0;
			$query = "SELECT * FROM cms_minimail WHERE to_id = :my_id AND deleted = '1' ORDER BY ID DESC LIMIT 10 OFFSET :offset";
			$stmt = $bdd->prepare($query);
			$stmt->bindParam(':my_id', $user['id'], PDO::PARAM_INT);
			$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
			$stmt->execute();

			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$i++;

				if ($row['read_mail'] == 0) {
					$read = "unread";
				} else {
					$read = "read";
				}

				$query2 = "SELECT * FROM users WHERE id = :sender_id LIMIT 1";
				$stmt2 = $bdd->prepare($query2);
				$stmt2->bindParam(':sender_id', $row['senderid'], PDO::PARAM_INT);
				$stmt2->execute();
				$senderrow = $stmt2->fetch(PDO::FETCH_ASSOC);
				$figure = $avatarimage . "" . $senderrow['figure'] . "&size=s&direction=9&head_direction=2&gesture=sml";

				printf("	<div class=\"message-item %s \" id=\"msg-%s\">
					 <div class=\"message-preview\" status=\"%s\">
						 <span class=\"message-tstamp\" isotime=\"%s\" title=\"%s\">
							 %s
						 </span>
						 <img src=\"%s\" />
						 <span class=\"message-sender\" title=\"%s\">%s</span>
						 <span class=\"message-subject\" title=\"%s\">&ldquo;%s&rdquo;</span>
					 </div>
					 <div class=\"message-body\" style=\"display: none;\">
						 <div class=\"contents\"></div>
						 <div class=\"message-body-bottom\"></div>
					 </div>
				 </div>", $read, $row['id'], $read, $row['date'], $row['date'], $row['date'], $figure, $senderrow['name'], $senderrow['name'], $row['subject'], $row['subject']);
			}
	?>

	<div class="navigation">
		<div class="progress"></div>

		<?php if ($allmail <> 0) {
				echo $maillist;
			} ?>
	</div>

	</div>
<?php } elseif ($label == "conversation") { ?>
	<div class="trash-controls notice">
		You are reading a conversation. Click the tabs above to go back to your folders.

	</div>
	<?php $id = $_POST['messageId'];
			$conid = $_POST['conversationId']; ?>

	<div class="navigation">
		<?php
			$sql1 = $bdd->prepare("SELECT * FROM cms_minimail WHERE conversationid = :conid AND deleted = '0'");
			$sql1->bindParam(':conid', $conid, PDO::PARAM_STR);
			$sql1->execute();
			$allmail = $sql1->rowCount();

			$allnum = $allmail;
			if ($start != null) {
				$offset = $start;
				$startnum = $start + 1;
				$endnum = $start + 10;
				if ($endnum > $allnum) {
					$endnum = $allnum;
				}
			} else {
				$sql1 = $bdd->prepare("SELECT * FROM cms_minimail WHERE conversationid = :conid AND deleted = '0' LIMIT 10");
				$sql1->execute(array('conid' => $conid));
				$endnum = $sql1->rowCount();
				$offset = "0";
				$startnum = "1";
			}
			$var1 = " <a href=\"#\" class=\"newer\">Newer</a> ";
			$var2 = " " . $startnum . " - " . $endnum . " of " . $allnum . " ";
			$var3 = " <a href=\"#\" class=\"older\">Older</a> ";
			$var4 = " <a href=\"#\" class=\"newest\">Newest</a> ";
			$var5 = "<!-- <a href=\"#\" class=\"oldest\">Oldest</a> -->";
			$totalpages = ceil($allnum / 10);
			if ($endnum != $allnum && $startnum != 1) {
				$maillist = $var1 . $var2 . $var3;
			} elseif ($endnum != $allnum && $startnum == 1) {
				$maillist = $var2 . $var3;
			} elseif ($endnum == $allnum && $startnum != 1) {
				$maillist = $var1 . $var2;
			} elseif ($endnum == $allnum && $startnum == 1) {
				$maillist = $var2;
			}
			if ($startnum + 20 < $allnum && $endnum <> $allnum) {
				$maillist = $maillist . $var5;
			}
			if ($startnum - 20 > 0) {
				$maillist = $var4 . $maillist;
			}
			$maillist = "<p>" . $maillist . "</p>";
		?>
		<?php if ($allmail == 0) { ?>
			<p class="no-messages">
				No conversation messages
			</p>
		<?php } ?>
		<div class="progress"></div>

		<?php if ($allmail <> 0) {
				echo $maillist;
			} ?>
	</div>
	<?php
			$i = 0;
			$stmt = $bdd->prepare("SELECT * FROM cms_minimail WHERE conversationid = :conid AND deleted = '0' ORDER BY id DESC LIMIT 10 OFFSET :offset");
			$stmt->bindParam(':conid', $conid);
			$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
			$stmt->execute();

			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$i++;

				if ($row['read_mail'] == 0) {
					$read = "unread";
				} else {
					$read = "read";
				}

				$stmt2 = $bdd->prepare("SELECT * FROM users WHERE id = :senderid LIMIT 1");
				$stmt2->bindParam(':senderid', $row['senderid']);
				$stmt2->execute();
				$senderrow = $stmt2->fetch(PDO::FETCH_ASSOC);
				$figure = $avatarimage . $senderrow['look'] . "&size=s&direction=9&head_direction=2&gesture=sml";

				printf("	<div class=\"message-item %s \" id=\"msg-%s\">
				<div class=\"message-preview\" status=\"%s\">
			
					<span class=\"message-tstamp\" isotime=\"%s\" title=\"%s\">
						%s
					</span>
					<img src=\"%s\" />
					<span class=\"message-sender\" title=\"%s\">%s</span>
			
					<span class=\"message-subject\" title=\"%s\">&ldquo;%s&rdquo;</span>
				</div>
				<div class=\"message-body\" style=\"display: none;\">
					<div class=\"contents\"></div>
			
					<div class=\"message-body-bottom\"></div>
				</div>
			</div>", $read, $row['id'], $read, $row['date'], $row['date'], $row['date'], $figure, $senderrow['name'], $senderrow['name'], $row['subject'], $row['subject']);
			}

	?>

	<div class="navigation">
		<div class="progress"></div>

		<?php if ($allmail <> 0) {
				echo $maillist;
			} ?>
	</div>
<?php }
?><div style="opacity: 1;" class="notification"></div>
</div><?php
	}
		?>