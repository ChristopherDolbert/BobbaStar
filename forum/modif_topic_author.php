<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|           GabCMS - Site Web et Content Management System               #|
#|         Copyright © 2012-2014 - Gabodd Tout droits réservés.           #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");

if(!isset($_SESSION['username']))
	{
		Redirect("".$url."/index");
		exit();
	}

$modifiertopic = Secu($_GET['modifiertopic']);
$modif = Secu($_GET['modif']);
     $sqlalpha = $bdd->query("SELECT * FROM gabcms_forum_topic WHERE id = '".$modif."'");
	 $mod = $sqlalpha->fetch(); 
     $sql_moa = $bdd->query("SELECT * FROM gabcms_forum_topic WHERE id = '".$modifiertopic."'");
	 $mod_ta = $sql_moa->fetch();  
if ($modifiertopic != "") { 	 
	if($mod_ta['user_id'] == $user['id'] && $mod_ta['etat'] == '1') {
		if(isset($_POST['topic']) || isset($_POST['titre'])) {
	 $topic = addslashes($_POST['topic']);
	 $titre = addslashes($_POST['titre']);
     $sql_mo = $bdd->query("SELECT * FROM gabcms_forum_topic WHERE id = '".$modifiertopic."'");
	 $mod_t = $sql_mo->fetch();   
		$sqla = $bdd->query("SELECT * FROM users WHERE id = '".$mod_t['user_id']."'");
		$assoc = $sqla->fetch(PDO::FETCH_ASSOC);
	if($topic != "" && $titre != "") {
	  $bdd->query("UPDATE gabcms_forum_topic SET titre='".$titre."', texte='".$topic."', modif='1', modif_le='".FullDate('full')."',modif_par='".$user['id']."' WHERE id = '".$modifiertopic."'");
	echo '<div id="ok">Le topic vient d\'être modifié.</div>';
	} else {
	echo '<div id="pasok">Merci de remplir les champs vide</div>';
   }
  }
 } else {
echo '<div id="pasok">Tu n\'as pas l\'autorisation de modifier ce topic.</div>';
} 
}
?>
<link href="<?PHP echo $url; ?>/managements/template/style.css" rel="stylesheet" type="text/css">
<meta http-equiv="content-type" content="text/html; charset=UTF-8" /><body>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script type="text/javascript" src="<?PHP echo $imagepath; ?>editor/ckeditor.js"></script>
<title>Modifie un topic (<?PHP echo $mod['titre'] ?>)</title>
<script type="text/javascript" src="<?PHP echo $imagepath; ?>editor/config.js"></script>
	<?php if ($modif == "") { ?>

<p><span class="HEADLINE">Selectionnes un topic</span><br \>
Merci de sélectionner un topic
	<?php
	}
	?>
<?php if ($modif != "") { ?>
<?PHP
$sql_modif = $bdd->query("SELECT * FROM gabcms_forum_topic WHERE id = '".$modif."'");
$modif_a = $sql_modif->fetch();
?>
<p><span class="HEADLINE">Modification d'un topic.</span><br \>
Tu peux modifié le titre et le texte du topic.
<br/><br/>
<form name="editor" method="post" action="?modifiertopic=<?php echo $modif; ?>">
<td width="100" class="tbl"><b>Titre :</b><br/></td>
<td width="80%" class="tbl"><input type="text" name="titre" value="<?php echo stripslashes($modif_a['titre']); ?>" class="text" style="width: 240px"><br/></td>
<br/>
<td width="100" class="tbl"><b>Le corps du topic : <a href="<?PHP echo $url; ?>/managements/upload.php" target="_blank">Upload tes images !</a> </b><br/></td>
<td width="80%" class="tbl"><textarea name="topic" wrap="discuss rows=12 cols=142" id="editor1"><?php echo $modif_a['texte']; ?></textarea>
<script>CKEDITOR.replace( 'editor1', { toolbar : 'Forum' });</script>
<br/></td>
<input type='submit' name='submit' value='Modifier'>
</form>
<?php
}
?>
	</body>

</html>