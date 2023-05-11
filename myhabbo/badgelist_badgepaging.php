<?php
if ($bypass1 == true) {
    $page = "1";
} else {
    include('../config.php');
    $page = $_POST['pageNumber'];
    $widgetid = $_POST['widgetId'];
}

$sql = $bdd->prepare("SELECT userid FROM cms_homes_stickers WHERE id = :widgetid LIMIT 1");
$sql->bindParam(':widgetid', $widgetid);
$sql->execute();
$rrow1 = $sql->fetch(PDO::FETCH_ASSOC);
$user = $rrow1['userid'];
$offset = $page - 1;
$offset = $offset * 16;
$sql = $bdd->prepare("SELECT * FROM users_badges WHERE userid = :user ORDER BY iscurrent DESC LIMIT 16 OFFSET :offset");
$sql->bindParam(':user', $user);
$sql->bindParam(':offset', $offset, PDO::PARAM_INT);
$sql->execute();

?>
<ul class="clearfix">
    <?php while ($rrow = $sql->fetch(PDO::FETCH_ASSOC)) { ?>
        <li style="background-image: url(<?php echo $cimagesurl . $badgesurl . $rrow['badgeid'] . ".gif"; ?>)"></li>
    <?php } ?>
</ul>

<div id="badge-list-paging">
    <?php
    $sql = $bdd->prepare("SELECT * FROM users_badges WHERE userid = :user ORDER BY iscurrent DESC");
    $sql->bindParam(':user', $user);
    $sql->execute();
    $count = $sql->rowCount();

    $offset = $offset * 2;
    $at = $page - 1;
    $at = $at * 16;
    $at = $at + 1;
    $to = $offset + 16;
    if ($to > $count) {
        $to = $count;
    }
    $totalpages = ceil($count / 16);
    ?>
    <?php echo $at; ?> - <?php echo $to; ?> / <?php echo $count; ?>
    <br />
    <?php if ($page != 1) { ?>
        <a href="#" id="badge-list-search-first">First</a> |
        <a href="#" id="badge-list-search-previous">&lt;&lt;</a> |
    <?php } else { ?>
        First |
        &lt;&lt; |
    <?php } ?>
    <?php if ($page != $totalpages) { ?>
        <a href="#" id="badge-list-search-next">&gt;&gt;</a> |
        <a href="#" id="badge-list-search-last">Last</a>
    <?php } else { ?>
        &gt;&gt; |
        Last
    <?php } ?>
    <input type="hidden" id="badgeListPageNumber" value="<?php echo $page; ?>" />
    <input type="hidden" id="badgeListTotalPages" value="<?php echo $totalpages; ?>" />
</div>