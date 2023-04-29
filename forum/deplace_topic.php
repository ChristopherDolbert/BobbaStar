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
	
	if($user['rank'] < 5) {
	Redirect("".$url."/forum/");
	exit();
	}
	if($user['rank'] > 8) {              
	Redirect("".$url."/forum/");
	exit();
	}	
if(isset($_GET['deplacement'])) {
$deplacement = Secu($_GET['deplacement']);
}
if(isset($_GET['deplace'])) {
$deplace = Secu($_GET['deplace']);
}
if($user['rank'] >= 5) {
  if(isset($_GET['deplacement'])) {  
  	if($deplacement != "") {
			$new_categorie = Secu($_POST['new_categorie']);
			$raison = addslashes($_POST['raison']);
				$sql = $bdd->query("SELECT * FROM gabcms_forum_topic WHERE id = '".$deplacement."'");
				$n = $sql->fetch(PDO::FETCH_ASSOC);
				$sql_deplacee = $bdd->query("SELECT * FROM gabcms_forum_sous_categorie WHERE id = '".$n['categorie_forum']."'");
				$deplace_a = $sql_deplacee->fetch();
				$sql_deplacez = $bdd->query("SELECT * FROM gabcms_forum_sous_categorie WHERE id = '".$new_categorie."'");
				$deplace_b = $sql_deplacez->fetch();
				$sqla = $bdd->query("SELECT * FROM users WHERE id = '".$n['user_id']."'");
				$assoc = $sqla->fetch(PDO::FETCH_ASSOC);
			if($new_categorie != "" && $raison != "") {
                $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :texte, :date)");
                $insertn1->bindValue(':pseudo', $user['username']);
                $insertn1->bindValue(':texte', 'a déplacé un topic de <b>'.$assoc['username'].'</b> ('.addslashes($n['titre']).') dans la catégorie <b>\"'.addslashes($deplace_b['nom']).'\"</b> (avant : '.addslashes($deplace_a['nom']).')');
                $insertn1->bindValue(':date', FullDate('full'));
                $insertn1->execute();
                $insertn2 = $bdd->prepare("INSERT INTO gabcms_management (user_id,message,auteur,date,look) VALUES (:user_id, :message, :auteur, :date, :look)");
                $insertn2->bindValue(':user_id', $assoc['id']);
                $insertn2->bindValue(':message', 'Je viens de déplacer ton topic ('.addslashes($n['titre']).') dans la catégorie <b>"'.addslashes($deplace_b['nom']).'"</b> pour la raison suivante : <i>'.$raison.'</i>');
                $insertn2->bindValue(':auteur', $user['username']);
                $insertn2->bindValue(':date', FullDate('full'));
                $insertn2->bindValue(':look', $user['look']);
                $insertn2->execute();
	  $bdd->query("UPDATE gabcms_forum_topic SET categorie_forum = '".$new_categorie."' WHERE id = '".$deplacement."'");
	  echo '<h4 class="alert_success">Le déplacement a bien eu lieu</h4>';
	  } else {
	  echo '<h4 class="alert_error">Une erreur est survenue</h4>';
	  }
  }
}
}
	$sql = $bdd->query("SELECT * FROM gabcms_forum_topic WHERE id = '".$deplace."'");
	$n = $sql->fetch(PDO::FETCH_ASSOC);
?>
<link href="<?PHP echo $url ?>/managements/css/contenu.css" rel="stylesheet" type="text/css">
<meta http-equiv="content-type" content="text/html; charset=UTF-8" /><body>
<title>Déplace un topic (<?PHP echo $n['titre'] ?>)</title>
	<?php if ($deplace == "") { ?>
<p><span id="titre">Selectionnes un topic</span><br/>
Merci de sélectionner un topic
	<?php
	} else {
	?>
<p><span id="titre">Déplacer un topic</span><br/>
Déplaces un topic d'une catégorie à une autre.<br/><br/>
<?PHP
$sql_deplace = $bdd->query("SELECT * FROM gabcms_forum_topic WHERE id = '".$deplace."'");
$deplace_a = $sql_deplace->fetch();
$sql_deplacez = $bdd->query("SELECT * FROM gabcms_forum_sous_categorie WHERE id = '".$deplace_a['categorie_forum']."'");
$deplace_b = $sql_deplacez->fetch();
	$sqla = $bdd->query("SELECT * FROM users WHERE id = '".$deplace_a['user_id']."'");
	$assoc = $sqla->fetch(PDO::FETCH_ASSOC);
?>
Actuellement, le topic de <b><?PHP echo $assoc['username']; ?></b> se trouve dans la catégorie <b><?PHP echo $deplace_b['nom']; ?></b>.<br/><br/>
<form name='editor' method='post' action="?deplacement=<?php echo $deplace; ?>">
<td width='100' class='tbl'><b>Nouvelle catégorie :</b><br/></td>
<select name="new_categorie" id="pays">
<?PHP
if($user['rank'] >= 5) {
$sql_a = $bdd->query("SELECT * FROM gabcms_forum_sous_categorie WHERE staff = '1' AND id != '".$deplace_a['categorie_forum']."' ORDER BY id DESC");
while($a = $sql_a->fetch()) {
?>
			<option value="<?PHP echo $a['id'] ?>">[STAFF] » <?PHP echo $a['nom'] ?></option>
<?PHP } } ?>
<?PHP
$sql_b = $bdd->query("SELECT * FROM gabcms_forum_sous_categorie WHERE staff = '0' AND id != '".$deplace_a['categorie_forum']."' ORDER BY id DESC");
while($b = $sql_b->fetch()) {
?>
			<option value="<?PHP echo $b['id'] ?>">» <?PHP echo $b['nom'] ?></option>
<?PHP } ?>	
</select>
	<br/>
<td width='100' class='tbl'><b>Raison :</b><br/></td>
<td width='80%' class='tbl'><textarea name='raison' wrap=discuss rows=3 cols=34 ></textarea><br/></td>
	<input type="submit" value="Déplacer" /></form>
<?PHP } ?>
</body>
</html>