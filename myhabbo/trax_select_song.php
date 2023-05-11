<?php
include('../config.php');

$songid = $_POST['songId'];
$id = $_POST['widgetId'];

$updateQuery = "UPDATE cms_homes_stickers SET var = :songid WHERE id = :id";
$updateStmt = $bdd->prepare($updateQuery);
$updateStmt->bindParam(':songid', $songid);
$updateStmt->bindParam(':id', $id);
$updateStmt->execute();

?>

<embed type="application/x-shockwave-flash" src="<?php echo $path; ?>web-gallery/flash/traxplayer/traxplayer.swf" name="traxplayer" quality="high" base="<?php echo $path; ?>web-gallery/flash/traxplayer/" allowscriptaccess="always" menu="false" wmode="transparent" flashvars="songUrl=<?php echo $path; ?>myhabbo/trax_song.php?songId=<?php echo $songid; ?>&amp;sampleUrl=http://images.habbohotel.com/dcr/hof_furni//mp3/" height="66" width="210" />