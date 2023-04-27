<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");

if (isset($_GET['pageNumber'])) {

	$page = $_GET['pageNumber'];
	$pagesize = $_GET['pageSize'];
	$myid = $user['id'];

?>
	<div id="friend-list" class="clearfix">
		<div id="friend-list-header-container" class="clearfix">
			<div id="friend-list-header">
				<div class="page-limit">
					<div class="big-icons friend-header-icon">Friends
						<br />Show

						<?php if ($pagesize == 30) { ?>
							30 |
							<a class="category-limit" id="pagelimit-50">50</a> |
							<a class="category-limit" id="pagelimit-100">100</a>
						<?php } elseif ($pagesize == 50) { ?>
							<a class="category-limit" id="pagelimit-30">30</a> |
							50 |
							<a class="category-limit" id="pagelimit-100">100</a>
						<?php } elseif ($pagesize == 100) { ?>
							<a class="category-limit" id="pagelimit-30">30</a> |
							<a class="category-limit" id="pagelimit-50">50</a> |
							100
						<?php } ?>
					</div>
				</div>
			</div>
			<div id="friend-list-paging">
				<?php
				if ($page <> 1) {
					$pageminus = $page - 1;
					echo "<a href=\"#\" class=\"friend-list-page\" id=\"page-" . $pageminus . "\">&lt;&lt;</a> |";
				}
				$stmt = $bdd->prepare("SELECT COUNT(*) FROM messenger_friendships WHERE user_one_id = :my_id OR user_two_id = :my_id");
				$stmt->bindParam(':my_id', $my_id);
				$stmt->execute();
				$friendscount = $stmt->fetchColumn();
				$pages = ceil($friendscount / $pagesize);
				if ($pages == 1) {
					echo "1";
				} else {
					$n = 0;
					while ($n < $pages) {
						$n++;
						if ($n == $page) {
							echo $n . " |";
						} else {
							echo "<a href=\"#\" class=\"friend-list-page\" id=\"page-" . $n . "\">" . $n . "</a> |";
						}
					}

					if ($page <> $pages) {
						$pageplus = $page + 1;
						echo "<a href=\"#\" class=\"friend-list-page\" id=\"page-" . $pageplus . "\">&gt;&gt;</a>";
					}
				}
				?>

			</div>
		</div>


		<form id="friend-list-form">
			<table id="friend-list-table" border="0" cellpadding="0" cellspacing="0">
				<tbody>
					<tr class="friend-list-header">
						<td class="friend-select" />
						<td class="friend-name table-heading">Name</td>
						<td class="friend-login table-heading">Last login</td>
						<td class="friend-remove table-heading">Remove</td>
					</tr>
					<?php
					$i = 0;
					$offset = $pagesize * $page;
					$offset = $offset - $pagesize;

					$stmt = $bdd->prepare("SELECT * FROM messenger_friendships WHERE user_one_id = :my_id OR user_two_id = :my_id LIMIT :pagesize OFFSET :offset");
					$stmt->bindParam(':my_id', $my_id);
					$stmt->bindParam(':pagesize', $pagesize, PDO::PARAM_INT);
					$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
					$stmt->execute();

					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
						$i++;

						if (IsEven($i)) {
							$even = "odd";
						} else {
							$even = "even";
						}

						if ($row['user_two_id'] == $my_id) {
							$stmt = $bdd->prepare("SELECT * FROM users WHERE id = :user_one_id");
							$stmt->bindParam(':user_one_id', $row['user_one_id']);
							$stmt->execute();
							$friendsql = $stmt->fetch(PDO::FETCH_ASSOC);
						} else {
							$stmt = $bdd->prepare("SELECT * FROM users WHERE id = :user_two_id");
							$stmt->bindParam(':user_two_id', $row['user_two_id']);
							$stmt->execute();
							$friendsql = $stmt->fetch(PDO::FETCH_ASSOC);
						}

						$friendrow = $friendsql;



						printf("   <tr class=\"%s\">
               <td><input type=\"checkbox\" name=\"friendList[]\" value=\"%s\" /></td>
               <td class=\"friend-name\">
                %s
               </td>
               <td class=\"friend-login\" title=\"%s\">%s</td>
               <td class=\"friend-remove\"><div id=\"remove-friend-button-%s\" class=\"friendmanagement-small-icons friendmanagement-remove remove-friend\"></div></td>
           </tr>", $even, $friendrow['id'], $friendrow['username'], $friendrow['last_online'], $friendrow['last_online'], $friendrow['id']);
					}
					?>
				</tbody>
			</table>
			<a class="select-all" id="friends-select-all" href="#">Select all</a> |
			<a class="deselect-all" href="#" id="friends-deselect-all">Deselect all</a>
		</form>
	</div>
	<script type="text/javascript">
		new FriendManagement({
			currentCategoryId: 0,
			pageListLimit: <?php echo $pagesize; ?>,
			pageNumber: <?php echo $page; ?>
		});
	</script>



<?php } elseif (isset($_POST['searchString'])) {
	$search = $_POST['searchString'];
	$pagesize = $_POST['pageSize'];
	$page = 1;
?>
	<div id="friend-list" class="clearfix">
		<div id="friend-list-header-container" class="clearfix">
			<div id="friend-list-header">
				<div class="page-limit">
					<div class="big-icons friend-header-icon">Friends
						<br />Show

						<?php if ($pagesize == 30) { ?>
							30 |
							<a class="category-limit" id="pagelimit-50">50</a> |
							<a class="category-limit" id="pagelimit-100">100</a>
						<?php } elseif ($pagesize == 50) { ?>
							<a class="category-limit" id="pagelimit-30">30</a> |
							50 |
							<a class="category-limit" id="pagelimit-100">100</a>
						<?php } elseif ($pagesize == 100) { ?>
							<a class="category-limit" id="pagelimit-30">30</a> |
							<a class="category-limit" id="pagelimit-50">50</a> |
							100
						<?php } ?>
					</div>
				</div>
			</div>
			<div id="friend-list-paging">
				<?php
				if ($page <> 1) {
					$pageminus = $page - 1;
					echo "<a href=\"#\" class=\"friend-list-page\" id=\"page-" . $pageminus . "\">&lt;&lt;</a> |";
				}
				$i = 0;
				$list = 0;

				$stmt = $bdd->prepare("SELECT * FROM messenger_friendships WHERE user_one_id = :my_id OR user_two_id = :my_id");
				$stmt->bindParam(':my_id', $my_id);
				$stmt->execute();

				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$i++;

					if ($row['user_two_id'] == 1) {
						$stmt = $bdd->prepare("SELECT * FROM users WHERE id = :user_one_id AND username LIKE :search");
						$stmt->bindParam(':user_one_id', $row['user_one_id']);
						$stmt->bindValue(':search', '%' . $search . '%');
						$stmt->execute();
						$friendsql = $stmt->fetch(PDO::FETCH_ASSOC);
					} else {
						$stmt = $bdd->prepare("SELECT * FROM users WHERE id = :user_two_id AND username LIKE :search");
						$stmt->bindParam(':user_two_id', $row['user_two_id']);
						$stmt->bindValue(':search', '%' . $search . '%');
						$stmt->execute();
						$friendsql = $stmt->fetch(PDO::FETCH_ASSOC);
					}
					$list = $list + $friendsql;
				}

				$pages = ceil($list / $pagesize);

				if ($pages == 1) {

					echo "1";
				} else {

					$n = 0;

					while ($n < $pages) {
						$n++;
						if ($n == $page) {
							echo $n . " |";
						} else {
							echo "<a href=\"#\" class=\"friend-list-page\" id=\"page-" . $n . "\">" . $n . "</a> |";
						}
					}

					if ($page <> $pages) {
						$pageplus = $page + 1;
						echo "<a href=\"#\" class=\"friend-list-page\" id=\"page-" . $pageplus . "\">&gt;&gt;</a>";
					}
				}
				?>

			</div>
		</div>


		<form id="friend-list-form">
			<table id="friend-list-table" border="0" cellpadding="0" cellspacing="0">
				<tbody>
					<tr class="friend-list-header">
						<td class="friend-select" />
						<td class="friend-name table-heading">Name</td>
						<td class="friend-login table-heading">Last login</td>
						<td class="friend-remove table-heading">Remove</td>
					</tr>
					<?php
					$i = 0;
					$n = 0;
					$stmt = $bdd->prepare("SELECT * FROM messenger_friendships WHERE user_one_id = :my_id OR user_two_id = :my_id");
					$stmt->bindParam(':my_id', $my_id);
					$stmt->execute();

					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
						$i++;

						if ($row['user_two_id'] == $my_id) {
							$stmt = $bdd->prepare("SELECT * FROM users WHERE id = :user_one_id AND username LIKE :search");
							$stmt->bindParam(':user_one_id', $row['user_one_id']);
							$stmt->bindValue(':search', '%' . $search . '%');
							$stmt->execute();
							$friendsql = $stmt->fetch(PDO::FETCH_ASSOC);
						} else {
							$stmt = $bdd->prepare("SELECT * FROM users WHERE id = :user_two_id AND username LIKE :search");
							$stmt->bindParam(':user_two_id', $row['user_two_id']);
							$stmt->bindValue(':search', '%' . $search . '%');
							$stmt->execute();
							$friendsql = $stmt->fetch(PDO::FETCH_ASSOC);
						}

						$friendrow = $friendsql;

						if (!empty($friendrow['username'])) {

							$n++;

							if (IsEven($n)) {
								$even = "odd";
							} else {
								$even = "even";
							}

							printf("   <tr class=\"%s\">
               <td><input type=\"checkbox\" name=\"friendList[]\" value=\"%s\" /></td>
               <td class=\"friend-name\">
                %s
               </td>
               <td class=\"friend-login\" title=\"%s\">%s</td>
               <td class=\"friend-remove\"><div id=\"remove-friend-button-%s\" class=\"friendmanagement-small-icons friendmanagement-remove remove-friend\"></div></td>
           </tr>", $even, $friendrow['id'], $friendrow['username'], $friendrow['last_online'], $friendrow['last_online'], $friendrow['id']);
						}
					}
					?>
				</tbody>
			</table>
			<a class="select-all" id="friends-select-all" href="#">Select all</a> |
			<a class="deselect-all" href="#" id="friends-deselect-all">Deselect all</a>
		</form>
	</div>
	<script type="text/javascript">
		new FriendManagement({
			currentCategoryId: 0,
			pageListLimit: <?php echo $pagesize; ?>,
			pageNumber: <?php echo $page; ?>
		});
	</script>
<?php } ?>