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



require_once('../core.php');

if($hkzone !== true){ header("Location: index.php?throwBack=true"); exit; }

if(!session_is_registered(acp)){ header("Location: index.php?p=login"); exit; }



if($_GET['a'] == "delete"){

mysqli_query($con,("DELETE FROM cms_campaigns WHERE id = '".$_GET['key']."'");

header("Location: index.php?p=campaign");

}



if(!isset($_GET['a'])){

	$_GET['a'] = "add";

}



$pagename = "Add Hot Campaign";



@include('subheader.php');

@include('header.php');



if(isset($_POST['edit']) && isset($_POST['title']) && isset($_POST['description']) && isset($_POST['furni_image']) && isset($_POST['furni_image_small']) && isset($_POST['year']) && isset($_POST['month']) && isset($_POST['tid'])) {

mysqli_query($con,("UPDATE cms_campaigns SET name='".$_POST['name']."',image='".$_POST['image']."',url='".$_POST['url']."',desc='".$_POST['desc']."' WHERE id='".$_GET['key']."' LIMIT 1") or die(mysql_error());

$msg = "Succesfully modified!";

}elseif(isset($_POST['add'])) {

mysqli_query($con,("INSERT INTO cms_campaigns (`name`, `image`, `url`, `desc`) VALUES ('".$_POST['name']."','".$_POST['image']."','".$_POST['url']."','".$_POST['desc']."')") or die(mysql_error());

$msg = "News A la Une mise en place";

}else{

$msg = "Oublier pas de remplire les champs";

}



?>

<table cellpadding='0' cellspacing='8' width='100%' id='tablewrap'>

<tr> <td width='22%' valign='top' id='leftblock'>

 <div>

 <!-- LEFT CONTEXT SENSITIVE MENU -->

<?php @include('sitemenu.php'); ?>

 <!-- / LEFT CONTEXT SENSITIVE MENU -->

 </div>

 </td>

 <td width='78%' valign='top' id='rightblock'>

 <div><!-- RIGHT CONTENT BLOCK -->

 

<?php if(isset($msg)){ ?><p><strong><?php echo $msg; ?></strong></p><?php } ?>

 

<form action='index.php?p=campaign&a=post' method='post' name='theAdminForm' id='theAdminForm'>

<div class='tableborder'>

<div class='tableheaderalt'><?php if($_GET['a'] == "add"){ echo "Add "; }elseif($_GET['a'] == "edit") { echo "Edit "; } ?>Campaign</div>



<table width='100%' cellspacing='0' cellpadding='5' align='center' border='0'>

<?php if($_GET['a'] == "add") { ?>

<tr>

<td class='tablerow1'  width='40%'  valign='middle'><b>Nom</b><div class='graytext'>Nom A la Une</div></td>

<td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='name' value="<?php echo $_POST['name']; ?>" maxlength='500' class='textinput'></td>

</tr>



<tr>

<td class='tablerow1'  width='40%'  valign='middle'><b>Image</b><div class='graytext'>Lien de l'image pour A la une</div></td>

<td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='image' value="<?php echo $_POST['image']; ?>" maxlength='500' class='textinput'></td>

</tr>



<tr>

<td class='tablerow1'  width='40%'  valign='middle'><b>Lien</b><div class='graytext'>Lien de la News ou Groupe</div></td>

<td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='url' value="<?php echo $_POST['url']; ?>" maxlength='500' class='textinput'></td>

</tr>



<tr>

<td class='tablerow1'  width='40%'  valign='middle'><b>Description</b><div class='graytext'>Description de votre News A la Une</div></td>

<td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='desc' value="<?php echo $_POST['desc']; ?>" maxlength='500' class='textinput'></td>

</tr>



<?php }elseif($_GET['a'] == "edit") {

		if(isset($_GET['key'])) {

		$sql = mysqli_query($con,("SELECT * FROM cms_campaigns WHERE id='".HoloText($_GET['key'])."' LIMIT 1");

		$row = mysql_fetch_assoc($sql);?>

<tr>

<td class='tablerow1'  width='40%'  valign='middle'><b>Name</b><div class='graytext'>Name of the Campaign.</div></td>

<td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='name' value="<?php echo $_POST['name']; ?>" maxlength='500' class='textinput'></td>

</tr>



<tr>

<td class='tablerow1'  width='40%'  valign='middle'><b>Image</b><div class='graytext'>The Image for the Campaign.</div></td>

<td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='image' value="<?php echo $_POST['image']; ?>" maxlength='500' class='textinput'></td>

</tr>



<tr>

<td class='tablerow1'  width='40%'  valign='middle'><b>URL</b><div class='graytext'>The URL of the Campaign.</div></td>

<td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='url' value="<?php echo $_POST['url']; ?>" maxlength='500' class='textinput'></td>

</tr>



<tr>

<td class='tablerow1'  width='40%'  valign='middle'><b>Description</b><div class='graytext'>The Description of the Campaign.</div></td>

<td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='desc' value="<?php echo $_POST['desc']; ?>" maxlength='500' class='textinput'></td>

</tr>



<?php }

} ?>



<?php if(isset($_GET['a']) && !isset($_GET['key'])) {

		if($_GET['a'] == "edit") {

echo "If you want to edit a Campaign, please go to the over-view and than click on the edit-icon.";

	}

}	?>

<tr>

<tr><td align='center' class='tablesubheader' colspan='2' ><input type='submit' name='<?php if($_GET['a'] == "add") { echo "add"; }else{ echo "edit"; } ?>' value='<?php if($_GET['a'] == "add") { echo "Ajouter la News"; }else{ echo "Edit Campaign"; } ?>' class='realbutton' accesskey='s'></td></tr>

</form></table></div><br />	 </div><!-- / RIGHT CONTENT BLOCK -->

	 </td></tr>

</table>

</div><!-- / OUTERDIV -->

<div align='center'><br />

<?php

$mtime = explode(' ', microtime());

$totaltime = $mtime[0] + $mtime[1] - $starttime;

printf('Time: %.3f', $totaltime);

?>

</div>
