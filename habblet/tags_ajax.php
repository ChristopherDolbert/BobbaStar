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

include('../config.php');

$key = $_GET['key'];
$tag = FilterText($_POST['tagName']);

$stmt = $bdd->prepare("SELECT * FROM cms_tags WHERE ownerid = :user_id LIMIT 20");
$stmt->execute(array(':user_id' => $user['id']));
$tags = $stmt->fetchAll(PDO::FETCH_ASSOC);
$tags_num = count($tags);

$randomq[] = "What is your favourite TV show?";
$randomq[] = "Who is your favourite actor?";
$randomq[] = "Who is your favourite actress?";
$randomq[] = "What's your favourite pastime?";
$randomq[] = "What is your favorite song?";
$randomq[] = "How do you describe yourself?";
$randomq[] = "What is your favorite band?";
$randomq[] = "What is your favorite comic?";
$randomq[] = "What is your favourite time of year?";
$randomq[] = "What is your favorite food?";
$randomq[] = "What sport you play?";
$randomq[] = "Who was your first love?";
$randomq[] = "What is your favorite movie?";
$randomq[] = "Cats, dogs, or something more exotic?";
$randomq[] = "What is your favorite color?";
mt_srand(time());

$chosen = array_rand($randomq);
$tag_question = $randomq[$chosen];

$chosen = rand(0, count($randomq) - 1);

if ($key == "remove") {

	$stmt = $bdd->prepare("DELETE FROM cms_tags WHERE tag = :tag AND ownerid = :user_id LIMIT 1");
	$stmt->execute(array(':tag' => $tag, ':user_id' => $user['id']));
	echo "SUCCESS";
} elseif ($key == "p_remove") {

	echo "<div id=\"profile-tags-container\">\n";

	$stmt = $bdd->prepare("DELETE FROM cms_tags WHERE tag = :tag AND ownerid = :user_id LIMIT 1");
	$stmt->execute(array(':tag' => $tag, ':user_id' => $user['id']));

	$get_tags = $bdd->prepare("SELECT * FROM cms_tags WHERE ownerid = :user_id ORDER BY id LIMIT 25");
	$get_tags->execute(array(':user_id' => $user['id']));
	$rows = $get_tags->rowCount();

	if ($rows > 0) {
		while ($row = $get_tags->fetch(PDO::FETCH_ASSOC)) {
			printf(
				"<span class=\"tag-search-rowholder\">
				<a href=\"tags.php?tag=%s\" class=\"tag-search-link tag-search-link-%s\">%s</a>
				<img border=\"0\" class=\"tag-delete-link tag-delete-link-%s\" 
				onMouseOver=\"this.src='http://images.habbohotel.co.uk/habboweb/21_5527e6590eba8f3fb66348bdf271b5a2/14/web-gallery/images/buttons/tags/tag_button_delete_hi.gif'\"
				onMouseOut=\"this.src='http://images.habbohotel.co.uk/habboweb/21_5527e6590eba8f3fb66348bdf271b5a2/14/web-gallery/images/buttons/tags/tag_button_delete.gif'\"
				src=\"http://images.habbohotel.co.uk/habboweb/21_5527e6590eba8f3fb66348bdf271b5a2/14/web-gallery/images/buttons/tags/tag_button_delete.gif\" />
				</span>",
				htmlspecialchars($row['tag']),
				htmlspecialchars($row['tag']),
				htmlspecialchars($row['tag']),
				htmlspecialchars($row['tag'])
			);
		}
	} else {
		echo "No tags";
	}

	echo "\n    <img id=\"tag-img-added\" border=\"0\" src=\"http://images.habbohotel.co.uk/habboweb/21_5527e6590eba8f3fb66348bdf271b5a2/14/web-gallery/images/buttons/tags/tag_button_added.gif\" style=\"display:none\"/>    
</div>";
} elseif ($key == "p_list") {

	echo "<div id=\"profile-tags-container\">\n";

	// Delete tag
	$delete_tag_stmt = $bdd->prepare("DELETE FROM cms_tags WHERE tag = :tag AND ownerid = :user_id LIMIT 1");
	$delete_tag_stmt->execute(array(':tag' => $tag, ':user_id' => $user['id']));

	// Get tags
	$get_tags_stmt = $bdd->prepare("SELECT * FROM cms_tags WHERE ownerid = :user_id ORDER BY id LIMIT 25");
	$get_tags_stmt->execute(array(':user_id' => $user['id']));
	$fetch_tags = $get_tags_stmt->fetchAll(PDO::FETCH_ASSOC);

	$rows = count($fetch_tags);

	if ($rows > 0) {
		$get_tags = $bdd->prepare("SELECT * FROM cms_tags WHERE ownerid = :owner_id ORDER BY id LIMIT 25");
		$get_tags->execute(array(':owner_id' => $user['id']));

		while ($row = $get_tags->fetch(PDO::FETCH_ASSOC)) {
			printf("    <span class=\"tag-search-rowholder\">
				<a href=\"tags.php?tag=%s\" class=\"tag-search-link tag-search-link-%s\"
				>%s</a><img border=\"0\" class=\"tag-delete-link tag-delete-link-%s\" onMouseOver=\"this.src='http://images.habbohotel.co.uk/habboweb/21_5527e6590eba8f3fb66348bdf271b5a2/14/web-gallery/images/buttons/tags/tag_button_delete_hi.gif'\" onMouseOut=\"this.src='http://images.habbohotel.co.uk/habboweb/21_5527e6590eba8f3fb66348bdf271b5a2/14/web-gallery/images/buttons/tags/tag_button_delete.gif'\" src=\"http://images.habbohotel.co.uk/habboweb/21_5527e6590eba8f3fb66348bdf271b5a2/14/web-gallery/images/buttons/tags/tag_button_delete.gif\"
				/></span>", $row['tag'], $row['tag'], $row['tag'], $row['tag']);
		}
	} else {
		echo "No tags";
	}

	echo "\n    <img id=\"tag-img-added\" border=\"0\" src=\"http://images.habbohotel.co.uk/habboweb/21_5527e6590eba8f3fb66348bdf271b5a2/14/web-gallery/images/buttons/tags/tag_button_added.gif\" style=\"display:none\"/>    
</div>";
} elseif ($key == "add") {

	$tag = strtolower(FilterText($_POST['tagName']));
	$filter = preg_replace("/[^a-z\d]/i", "", $tag);

	if (strlen($tag) < 2 || $filter !== $tag || strlen($tag) > 20) {
		echo "invalidtag";
		exit;
	} else {
		$check = $bdd->prepare("SELECT * FROM cms_tags WHERE ownerid = :user_id AND tag = :tag LIMIT 1");
		$check->execute(array(':user_id' => $user['id'], ':tag' => $tag));
		$num = $check->rowCount();
		if ($num > 0) {
			echo "invalidtag";
			exit;
		} else {
			$stmt = $bdd->prepare("SELECT * FROM cms_tags WHERE ownerid = :user_id LIMIT 20");
			$stmt->execute(array(':user_id' => $user['id']));
			$tag_num = $stmt->rowCount();
			if ($tag_num > 20) {
				echo "invalidtag";
				exit;
			} else {
				$insert = $bdd->prepare("INSERT INTO cms_tags (ownerid,tag) VALUES (:user_id,:tag)");
				$insert->execute(array(':user_id' => $user['id'], ':tag' => $tag));
				echo "valid";
				exit;
			}
		}
	}
} elseif ($key == "mytagslist") {

	echo "   <div class=\"habblet\" id=\"my-tags-list\">\n\n";
	echo "<ul class=\"tag-list make-clickable\"> ";
	$stmt = $bdd->prepare("SELECT tag FROM cms_tags WHERE ownerid = :ownerid ORDER BY id LIMIT 25");
	$stmt->execute(array(':ownerid' => $user['id']));
	$tags = $stmt->fetchAll(PDO::FETCH_ASSOC);

	if ($tags) {
		foreach ($tags as $tag) {
			printf("<li><a href=\"tags.php?tag=%s\" class=\"tag\" style=\"font-size:10px\">%s</a>\n
						<a class=\"tag-remove-link\"\n
						title=\"Remove tag\"\n
						href=\"#\"></a></li>\n", $tag['tag'], $tag['tag']);
		}
	} else {
		echo "No tags found";
	}

	echo "</ul>";
	if ($tag_num < 20) {
		echo "     <form method=\"post\" action=\"tag_ajax.php?key=add\" onsubmit=\"TagHelper.addFormTagToMe();return false;\" >
    <div class=\"add-tag-form clearfix\">
		<a  class=\"new-button\" href=\"#\" id=\"add-tag-button\" onclick=\"TagHelper.addFormTagToMe();return false;\"><b>Add tag</b><i></i></a>
        <input type=\"text\" id=\"add-tag-input\" maxlength=\"20\" style=\"float: right\"/>
        <em class=\"tag-question\">" . $randomq[$chosen] . "</em>
    </div>
    <div style=\"clear: both\"></div> 
    </form>";
	}
	echo "    </div>

<script type=\"text/javascript\">

    TagHelper.setTexts({
        tagLimitText: \"You\'ve reached the tag limit - delete one of your tags if you want to add a new one.\",
        invalidTagText: \"Invalid tag\",
        buttonText: \"OK\"
    });
        TagHelper.bindEventsToTagLists();

</script>\n";
}
