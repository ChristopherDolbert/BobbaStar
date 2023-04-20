<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");

if(!isset($_SESSION['username']))
	{
		Redirect("".$url."/index");
		exit();
	}
	
	if($user['rank'] < 5) {
	Redirect("".$url."/managements/acces_neg");
	exit();
	}
	if($user['rank'] > 8) {              
	Redirect("".$url."/managements/acces_neg");
	exit();
	}	
	
if(isset($_GET['signalement'])) {
$signalement = Secu($_GET['signalement']);
} if(isset($_GET['modifiertopic'])) {
$modifiertopic = Secu($_GET['modifiertopic']);
} if(isset($_GET['modif'])) {
$modif = Secu($_GET['modif']);
     $sqlalpha = $bdd->query("SELECT * FROM gabcms_forum_topic WHERE id = '".$modif."'");
	 $mod = $sqlalpha->fetch();  
} if(isset($_GET['signale'])) {
$signale = Secu($_GET['signale']);
}
if($user['rank'] >= 5) {
	if(isset($_GET['modifiertopic'])) {
		if(isset($_POST['topic']) || isset($_POST['titre'])) {
	 $topic = addslashes($_POST['topic']);
	 $titre = addslashes($_POST['titre']);
     $sql_mo = $bdd->query("SELECT * FROM gabcms_forum_topic WHERE id = '".$modifiertopic."'");
	 $mod_t = $sql_mo->fetch();   
		$sqla = $bdd->query("SELECT * FROM users WHERE id = '".$mod_t['user_id']."'");
		$assoc = $sqla->fetch(PDO::FETCH_ASSOC);
$infr = $bdd->query("SELECT * FROM gabcms_forum_signalement WHERE id = '".$signale."'");
$r = $infr->fetch();
	if($topic != "" && $titre != "") {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a modifié un topic de <b>'.$assoc['username'].'</b> ('.$mod_t['titre'].') suite au signalement de <b>'.$r['signaler_par'].'</b> (ID : '.$r['id'].')');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute();
	  $bdd->query("UPDATE gabcms_forum_topic SET titre='".$titre."', texte='".$topic."', modif='1', modif_le='".FullDate('full')."',modif_par='".$user['id']."' WHERE id = '".$modifiertopic."'");
	echo '<h4 class="alert_success">Le topic vient d\'être modifié.</h4>';
	} else {
	echo '<h4 class="alert_error">Merci de remplir les champs vide</h4>';
   }
  }
 } 
} else {
echo '<h4 class="alert_error">Tu n\'as pas l\'autorisation de modifier ce topic.</h4>';
}
?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?'.mt_rand(); ?>" type="text/css" media="screen" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8" /><body>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script type="text/javascript" src="<?PHP echo $imagepath; ?>editor/ckeditor.js"></script>
<title>Modifier un topic (<?PHP echo $mod['titre'] ?>)</title>
<script type="text/javascript" src="<?PHP echo $imagepath; ?>editor/config.js"></script>
	<?php if(!isset($_GET['modif'])) { ?>
<span id="titre">Selectionnes un topic</span><br \>
Merci de sélectionner un topic
	<?php
	}
	?>
<?php if(isset($_GET['modif'])) { ?>
<?PHP
$sql_modif = $bdd->query("SELECT * FROM gabcms_forum_topic WHERE id = '".$modif."'");
$modif_a = $sql_modif->fetch();
?>
<span id="titre">Modification d'un topic.</span><br \>
Tu peux modifié le titre et le texte du topic.
<br/><br/>
<form name="editor" method="post" action="?modifiertopic=<?php echo $modif; ?>&signale=<?PHP echo $signalement; ?>">
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