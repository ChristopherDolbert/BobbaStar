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
	$query = "SELECT userid FROM cms_homes_stickers WHERE id = :widgetid LIMIT 1";
	$stmt = $bdd->prepare($query);
	$stmt->bindParam(':widgetid', $widgetid);
	$stmt->execute();
	$row1 = $stmt->fetch(PDO::FETCH_ASSOC);
	$user = $row1['userid'];
	$offset = ($page - 1) * 20;
	$query = "SELECT * FROM messenger_friendships WHERE user_one_id = :user OR user_two_id = :user LIMIT 20 OFFSET :offset";
	$stmt = $bdd->prepare($query);
	$stmt->bindParam(':user', $user);
	$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
	<div class="avatar-widget-list-container">
		<ul id="avatar-list-list" class="avatar-widget-list">
			<?php
			while ($friendrow = $sql->fetch(PDO::FETCH_ASSOC)) {
				if ($friendrow['user_one_id'] == $user) {
					$friendid = $friendrow['user_two_id'];
				} else {
					$friendid = $friendrow['user_one_id'];
				}

				$stmt = $bdd->prepare("SELECT * FROM users WHERE id = :friendid LIMIT 1");
				$stmt->bindParam(':friendid', $friendid);
				$stmt->execute();
				$friend = $stmt->fetch(PDO::FETCH_ASSOC);
			?>

				<li id="avatar-list-<?php echo $widgetid; ?>-<?php echo $friendid; ?>" title="<?php echo $friend['name']; ?>">
					<div class="avatar-list-open">
						<a href="#" id="avatar-list-open-link-<?php echo $widgetid; ?>-<?php echo $friendid; ?>" class="avatar-list-open-link"></a>
					</div>
					<div class="avatar-list-avatar">
						<img src="http://www.habbo.co.uk/habbo-imaging/avatarimage?figure=<?php echo $friend['figure']; ?>&size=s&direction=2&head_direction=2&gesture=sml" alt="" />
					</div>
					<h4>
						<a href="./user_profile.php?name=<?php echo $friend['name']; ?>"><?php echo $friend['name']; ?></a>
					</h4>
					<p class="avatar-list-birthday"><?php echo $friend['hbirth']; ?></p>
					<p></p>
				</li>

			<?php } ?>
		</ul>

		<div id="avatar-list-info" class="avatar-list-info">
			<div class="avatar-list-info-close-container"><a href="#" class="avatar-list-info-close"></a></div>
			<div class="avatar-list-info-container"></div>
		</div>

	</div>

	<div id="avatar-list-paging">
		<?php

		$query = "SELECT COUNT(*) as count FROM messenger_friendships WHERE user_one_id = :user OR user_two_id = :user";
		$stmt = $bdd->prepare($query);
		$stmt->bindParam(':user', $user);
		$stmt->execute();

		$count = $stmt->fetchColumn();
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
	$query = "SELECT userid FROM cms_homes_stickers WHERE id = :widgetid LIMIT 1";
	$statement = $bdd->prepare($query);
	$statement->bindValue(':widgetid', $widgetid);
	$statement->execute();
	$row1 = $statement->fetch(PDO::FETCH_ASSOC);
	$user = $row1['userid'];

	$offset = ($page - 1) * 10;

	$query = "SELECT users.id, users.username, users.look, users.account_day_of_birth 
          FROM users
          INNER JOIN messenger_friendships ON messenger_friendships.user_one_id = users.id
          WHERE messenger_friendships.user_two_id = :user
          AND users.name LIKE :search
          LIMIT 10 OFFSET :offset";
	$statement = $bdd->prepare($query);
	$statement->bindValue(':user', $user);
	$statement->bindValue(':search', '%' . $search . '%');
	$statement->bindValue(':offset', $offset, PDO::PARAM_INT);
	$statement->execute();
	$results = $statement->fetchAll(PDO::FETCH_ASSOC);

	$query2 = "SELECT users.id, users.username, users.look, users.account_day_of_birth 
           FROM users
           INNER JOIN messenger_friendships ON messenger_friendships.user_two_id = users.id
           WHERE messenger_friendships.user_one_id = :user
           AND users.name LIKE :search
           LIMIT 10 OFFSET :offset";
	$statement2 = $bdd->prepare($query2);
	$statement2->bindValue(':user', $user);
	$statement2->bindValue(':search', '%' . $search . '%');
	$statement2->bindValue(':offset', $offset, PDO::PARAM_INT);
	$statement2->execute();
	$results2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
?>
	<div class="avatar-widget-list-container">
		<ul id="avatar-list-list" class="avatar-widget-list">
			<?php
			while ($friendrow = $statement->fetch(PDO::FETCH_ASSOC)) {
			?>
				<li id="avatar-list-<?php echo $widgetid; ?>-<?php echo $friendrow['id']; ?>" title="<?php echo $friendrow['username']; ?>">
					<div class="avatar-list-open"><a href="#" id="avatar-list-open-link-<?php echo $widgetid; ?>-<?php echo $friendrow; ?>" class="avatar-list-open-link"></a></div>
					<div class="avatar-list-avatar"><img src="http://www.habbo.co.uk/habbo-imaging/avatarimage?figure=<?php echo $friendrow['look']; ?>&size=s&direction=2&head_direction=2&gesture=sml" alt="" /></div>
					<h4><a href="./user_profile.php?name=<?php echo $friendrow['username']; ?>"><?php echo $friendrow['username']; ?></a></h4>
					<p class="avatar-list-birthday"><?php echo $friendrow['account_day_of_birth']; ?></p>
					<p>

					</p>
				</li>

			<?php }
			while ($friendrow = $statement2->fetch(PDO::FETCH_ASSOC)) {
			?>
				<li id="avatar-list-<?php echo $widgetid; ?>-<?php echo $friendrow['id']; ?>" title="<?php echo $friendrow['username']; ?>">
					<div class="avatar-list-open"><a href="#" id="avatar-list-open-link-<?php echo $widgetid; ?>-<?php echo $friendrow; ?>" class="avatar-list-open-link"></a></div>
					<div class="avatar-list-avatar"><img src="http://www.habbo.co.uk/habbo-imaging/avatarimage?figure=<?php echo $friendrow['look']; ?>&size=s&direction=2&head_direction=2&gesture=sml" alt="" /></div>
					<h4><a href="./user_profile.php?name=<?php echo $friendrow['username']; ?>"><?php echo $friendrow['username']; ?></a></h4>
					<p class="avatar-list-birthday"><?php echo $friendrow['account_day_of_birth']; ?></p>
					<p>

					</p>
				</li>

			<?php } ?>
		</ul>

		<div id="avatar-list-info" class="avatar-list-info">
			<div class="avatar-list-info-close-container"><a href="#" class="avatar-list-info-close"></a></div>
			<div class="avatar-list-info-container"></div>
		</div>

	</div>

	<div id="avatar-list-paging">
		<?php
		$count = $statement->rowCount() + $statement2->rowCount();
		$offset = $offset * 2;
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