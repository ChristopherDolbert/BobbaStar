<?php
if ($bypass == true) {
	$page = "1";
	$search = "";
} else {
	include('../config.php');
	$page = $_POST['pageNumber'];
	$search = FilterText($_POST['searchString']);
	$widgetid = $_POST['widgetId'];
}

if ($search == "") {
	$sql = $bdd->prepare("SELECT groupid FROM cms_homes_stickers WHERE id = :widgetid LIMIT 1");
	$sql->bindParam(':widgetid', $widgetid);
	$sql->execute();
	$row1 = $sql->fetch(PDO::FETCH_ASSOC);
	$groupid = $row1['groupid'];
	$offset = $page - 1;
	$offset = $offset * 20;
	$sql = $bdd->prepare("SELECT user_id, is_current, member_rank FROM groups_memberships WHERE guild_id = :groupid AND is_pending = '0' ORDER BY member_rank ASC LIMIT 20 OFFSET :offset");
	$sql->bindParam(':groupid', $groupid);
	$sql->bindParam(':offset', $offset, PDO::PARAM_INT);
	$sql->execute();
	// Rest of your code
?>
	<div class="avatar-widget-list-container">
		<ul id="avatar-list-list" class="avatar-widget-list">
			<?php
			while ($membership = $sql->fetch(PDO::FETCH_ASSOC)) {

				$userstmt = $bdd->prepare("SELECT id,username,look,account_day_of_birth FROM users WHERE id = :userid LIMIT 1");
				$userstmt->bindParam(':userid', $membership['userid']);
				$userstmt->execute();
				$found = $userstmt->rowCount();

				$groupdetailsstmt = $bdd->prepare("SELECT * FROM guilds WHERE id = :groupid LIMIT 1");
				$groupdetailsstmt->bindParam(':groupid', $groupid);
				$groupdetailsstmt->execute();
				$groupdetails = $groupdetailsstmt->fetch(PDO::FETCH_ASSOC);
				$ownerid = $groupdetails['ownerid'];


				if ($found > 0) {
					$userrow = $userstmt->fetch(PDO::FETCH_ASSOC);


					echo "<li id=\"avatar-list-" . $groupid . "-" . $userrow['id'] . "\" title=\"" . $userrow['name'] . "\">
<div class=\"avatar-list-open\">
	<a href=\"#\" id=\"avatar-list-open-link-" . $groupid . "-" . $userrow['id'] . "\" class=\"avatar-list-open-link\"></a>
</div>
<div class=\"avatar-list-avatar\">
	<img src=\"" . $avatarimage . $userrow['look'] . "&size=s&direction=2&head_direction=2&gesture=sml\" alt=\"\" />
</div>
<h4>
	<a href=\"user_profile.php?name=" . $userrow['username'] . "\">" . $userrow['name'] . "</a>
</h4>
<p class=\"avatar-list-birthday\">
	" . $userrow['hbirth'] . "
</p>
<p>";
					if ($userrow['id'] == $ownerid) {
						echo "<img src=\"./web-gallery/images/groups/owner_icon.gif\" alt=\"\" class=\"avatar-list-groupstatus\" />";
					} elseif ($membership['member_rank'] == "2") {
						echo "<img src=\"./web-gallery/images/groups/administrator_icon.gif\" alt=\"\" class=\"avatar-list-groupstatus\" />";
					}
					if ($membership['is_current'] == "1") {
						echo "<img src=\"./web-gallery/images/groups/favourite_group_icon.gif\" alt=\"Favorite\" class=\"avatar-list-groupstatus\" />";
					}
					echo "</p>
</li>";
				}
			} ?>
		</ul>

		<div id="avatar-list-info" class="avatar-list-info">
			<div class="avatar-list-info-close-container"><a href="#" class="avatar-list-info-close"></a></div>
			<div class="avatar-list-info-container"></div>
		</div>

	</div>

	<div id="avatar-list-paging">
		<?php
		$sql = $bdd->prepare("SELECT * FROM guilds_members WHERE guild_id = :groupid AND is_pending = '0'");
		$sql->bindParam(':groupid', $groupid);
		$sql->execute();
		$count = $sql->rowCount();

		$at = $page - 1;
		$at = $at * 20;
		$at = $at + 1;
		$to = $offset + 20;
		if ($to > $count) {
			$to = $count;
		}
		$totalpages = ceil($count / 20);
		?>
		<?php echo $at; ?> - <?php echo $to; ?> / <?php echo $count; ?>
		<br />
		<?php if ($page != 1) { ?>
			<a href="#" class="avatar-list-paging-link" id="avatarlist-search-first">First</a> |
			<a href="#" class="avatar-list-paging-link" id="avatarlist-search-previous">&lt;&lt;</a> |
		<?php } else { ?>
			First |
			&lt;&lt; |
		<?php } ?>
		<?php if ($page != $totalpages) { ?>
			<a href="#" class="avatar-list-paging-link" id="avatarlist-search-next">&gt;&gt;</a> |
			<a href="#" class="avatar-list-paging-link" id="avatarlist-search-last">Last</a>
		<?php } else { ?>
			&gt;&gt; |
			Last
		<?php } ?>
		<input type="hidden" id="pageNumber" value="<?php echo $page; ?>" />
		<input type="hidden" id="totalPages" value="<?php echo $totalpages; ?>" />
	</div>
<?php } else {
	$sql = $bdd->prepare("SELECT groupid FROM cms_homes_stickers WHERE id = :widgetid LIMIT 1");
	$sql->bindParam(':widgetid', $widgetid);
	$sql->execute();
	$row1 = $sql->fetch(PDO::FETCH_ASSOC);

	$groupid = $row1['groupid'];
	$offset = $page - 1;
	$offset = $offset * 20;
	$sql = $bdd->prepare("SELECT groups_memberships.userid, groups_memberships.is_current, groups_memberships.member_rank, users.name FROM groups_memberships JOIN users ON groups_memberships.userid = users.id WHERE groupid = :groupid AND is_pending = '0' AND name LIKE :search ORDER BY member_rank ASC LIMIT 20 OFFSET :offset");
	$sql->bindValue(':groupid', 44, PDO::PARAM_INT);
	$sql->bindValue(':search', '%' . $search . '%');
	$sql->bindValue(':offset', $offset, PDO::PARAM_INT);
	$sql->execute();
?>
	<div class="avatar-widget-list-container">
		<ul id="avatar-list-list" class="avatar-widget-list">
			<?php
			while ($membership = $sql->fetch(PDO::FETCH_ASSOC)) {

				$userstmt = $bdd->prepare("SELECT id, username, look, account_day_of_birth FROM users WHERE id = :userid LIMIT 1");
				$userstmt->bindParam(':userid', $membership['userid']);
				$userstmt->execute();
				$found = $userstmt->rowCount();

				$groupdetailsstmt = $bdd->prepare("SELECT * FROM guilds WHERE id = :groupid LIMIT 1");
				$groupdetailsstmt->bindParam(':groupid', $groupid);
				$groupdetailsstmt->execute();
				$groupdetails = $groupdetailsstmt->fetch(PDO::FETCH_ASSOC);
				$ownerid = $groupdetails['user_id'];


				if ($found > 0) {
					$userrow = $userstmt->fetch(PDO::FETCH_ASSOC);


					echo "<li id=\"avatar-list-" . $groupid . "-" . $userrow['id'] . "\" title=\"" . $userrow['name'] . "\">
<div class=\"avatar-list-open\">
	<a href=\"#\" id=\"avatar-list-open-link-" . $groupid . "-" . $userrow['id'] . "\" class=\"avatar-list-open-link\"></a>
</div>
<div class=\"avatar-list-avatar\">
	<img src=\"" . $avatarimage . $userrow['look'] . "&size=s&direction=2&head_direction=2&gesture=sml\" alt=\"\" />
</div>
<h4>
	<a href=\"user_profile.php?name=" . $userrow['username'] . "\">" . $userrow['username'] . "</a>
</h4>
<p class=\"avatar-list-birthday\">
	" . $userrow['account_day_of_birth'] . "
</p>
<p>";
					if ($userrow['id'] == $ownerid) {
						echo "<img src=\"./web-gallery/images/groups/owner_icon.gif\" alt=\"\" class=\"avatar-list-groupstatus\" />";
					} elseif ($membership['member_rank'] == "2") {
						echo "<img src=\"./web-gallery/images/groups/administrator_icon.gif\" alt=\"\" class=\"avatar-list-groupstatus\" />";
					}
					if ($membership['is_current'] == "1") {
						echo "<img src=\"./web-gallery/images/groups/favourite_group_icon.gif\" alt=\"Favorite\" class=\"avatar-list-groupstatus\" />";
					}
					echo "</p>
</li>";
				}
			} ?>
		</ul>

		<div id="avatar-list-info" class="avatar-list-info">
			<div class="avatar-list-info-close-container"><a href="#" class="avatar-list-info-close"></a></div>
			<div class="avatar-list-info-container"></div>
		</div>

	</div>

	<div id="avatar-list-paging">
		<?php
		$sql = $bdd->prepare("SELECT groups_memberships.userid, groups_memberships.is_current, groups_memberships.member_rank, users.name FROM groups_memberships JOIN users ON groups_memberships.userid = users.id WHERE groupid = :groupid AND is_pending = '0' AND name LIKE :search");
		$sql->bindValue(':groupid', 44, PDO::PARAM_INT);
		$sql->bindValue(':search', '%' . $search . '%');
		$sql->execute();
		$count = $sql->rowCount();

		$at = $page - 1;
		$at = $at * 20;
		$at = $at + 1;
		$to = $offset + 20;
		if ($to > $count) {
			$to = $count;
		}
		$totalpages = ceil($count / 20);
		?>
		<?php echo $at; ?> - <?php echo $to; ?> / <?php echo $count; ?>
		<br />
		<?php if ($page != 1) { ?>
			<a href="#" class="avatar-list-paging-link" id="avatarlist-search-first">First</a> |
			<a href="#" class="avatar-list-paging-link" id="avatarlist-search-previous">&lt;&lt;</a> |
		<?php } else { ?>
			First |
			&lt;&lt; |
		<?php } ?>
		<?php if ($page != $totalpages) { ?>
			<a href="#" class="avatar-list-paging-link" id="avatarlist-search-next">&gt;&gt;</a> |
			<a href="#" class="avatar-list-paging-link" id="avatarlist-search-last">Last</a>
		<?php } else { ?>
			&gt;&gt; |
			Last
		<?php } ?>
		<input type="hidden" id="pageNumber" value="<?php echo $page; ?>" />
		<input type="hidden" id="totalPages" value="<?php echo $totalpages; ?>" />
	</div>
<?php } ?>