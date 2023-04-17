<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         GabCMS - Site Web et Content Management System                 #|
#|         Copyright © 2013 Gabodd Tout droits réservés.                  #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");

if(!isset($_SESSION['username']))
	{
		Redirect("".$url."/index");
		exit();
	}
	
	if($user['rank'] < 6) {
	Redirect("".$url."/index");
	exit();
	}

if(isset($_GET['modif'])) { $modif = Secu($_GET['modif']); }

if(isset($_GET['modifiernews'])) {
$modifiernews = Secu($_GET['modifiernews']);
	if(isset($_POST['info']) || isset($_POST['url']) || isset($_POST['titre']) || isset($_POST['desc']) || isset($_POST['image'])) {
   $titre = Secu($_POST['titre']);
   $desc = Secu($_POST['desc']);
   $image = Secu($_POST['image']);
   $info = Secu($_POST['info']);
   $url_article = Secu($_POST['url']);
   $sql_mo = $bdd->query("SELECT * FROM gabcms_news WHERE id = '".$modifiernews."'");
   $mod_t = $sql_mo->fetch();   
      if($titre != "" && $desc != "" && $url_article != "") {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a modifié un événement avec lien <b>('.$mod_t['title'].')</b>');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
        $bdd->query("UPDATE gabcms_news SET info = '".($info)."', topstory_image = '".($image)."', title = '".($titre)."', snippet = '".($desc)."', lien_event = '".($url_article)."', modifier = '1', modif_date = '".$nowtime."', modif_auteur = '".$user['username']."', look = '".$user['look']."' WHERE id = '".$modifiernews."'");
	  echo '<h4 class="alert_success">L\'événement vient d\'&ecirc;tre modifié.</h4>';
	  } else {
	  echo '<h4 class="alert_error">Merci de remplir les champs vide</h4>';
	  }
  }
		}	 
if(isset($_GET['do'])) {
   $do = Secu($_GET['do']);
   $sql_do = $bdd->query("SELECT * FROM gabcms_news WHERE id = '".$do."'");
   $mod_do = $sql_do->fetch(); 
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a supprimé un événement avec lien <b>('.addslashes($mod_do['title']).')</b>');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
        $bdd->query("DELETE FROM gabcms_news_recommande WHERE news_id = '".$do."'");
        $bdd->query("DELETE FROM gabcms_news WHERE id = '".$do."'");
	echo '<h4 class="alert_success">L\'événement vient d\'&ecirc;tre supprimé.</h4>';
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
	
<head> 
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="css/contenu.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="editeur_html/ckeditor/ckeditor.js"></script>
</head>
	<body>
<?php if(!isset($_GET['modif'])) { ?>
<p><span id="titre">Actions sur des événements</span><br/>
Choisis l'événement sans lien que tu désires modifier ou supprimer.
<br/><br/>
<table>
    <tbody>
        <tr>
            <td class="haut">Titre de l'événement</td>
            <td class="haut">Description</td>
            <td class="haut">Créer par</td>
            <td class="haut">Date</td>
            <td class="haut">Actions</td>
        </tr>
<?php
 $sql = $bdd->query("SELECT * FROM gabcms_news WHERE event = '2' ORDER BY id DESC LIMIT 0,100");
 while($a = $sql->fetch()) {
     $date_but = date('d/m/Y à H:i', $a['date']);
?>
        <tr class="bas">
            <td class="bas"><?PHP echo stripslashes($a['title']); ?></td>
            <td class="bas"><?PHP echo stripslashes($a['snippet']); ?></td>
            <td class="bas"><?PHP echo Secu($a['auteur']); ?></td>
            <td class="bas"><?PHP echo $date_but; ?></td>
            <td class="bas"><a href="?modif=<?PHP echo Secu($a['id']); ?>">Modifier</a> - <a href="?do=<?PHP echo Secu($a['id']); ?>" onclick="return confirm(\'Êtes-vous certain de supprimer cet événement ?\')">Supprimer</a></td>
        </tr>
<?PHP } ?>
</tbody>
</table>
	<?php
	}
	?>
<?php if(isset($_GET['modif'])) {
$sql_modif = $bdd->query("SELECT * FROM gabcms_news WHERE id = '".$modif."'");
$modif_a = $sql_modif->fetch();
?>
 <p><span id="titre">Modification de l'article.</span><br \>
<form name='editor' method='post' action="?modifiernews=<?php echo $modif; ?>">
<td width='100' class='tbl'><b>Titre de ton article :</b><br/></td>
<td width='80%' class='tbl'><input type='text' name='titre' value="<?php echo stripslashes($modif_a['title']); ?>" class='text' style='width: 240px'><br/></td>
<br/>
<td width='100' class='tbl'><b>Description :</b><br/></td>
<td width='80%' class='tbl'><textarea name="desc" rows="5" cols="50"><?php echo stripslashes($modif_a['snippet']); ?></textarea>
<br/>
<td width='100' class='tbl'><b>Image que tu afficheras : <a href="<?PHP echo $url; ?>/articles_topstory" target="_blank"><b>Images pour les news</b></a> </b><br/></td>
<td width='80%' class='tbl'><input type='text' name='image' value="<?php echo $modif_a['topstory_image']; ?>" class='text' style='width: 240px'><br/></td>
<br/>
<td width='100' class='tbl'><b>Message du bouton</b><br/></td>
<td width='80%' class='tbl'><input type='text' name='info' style="background-image: url('images/text_news.png'); height: 43px; width: 130px; border: none; padding-left: 10px; margin-top: 6px; color: white; font-size:14px;" value="<?php echo stripslashes($modif_a['info']); ?>" class='text'><br/></td>
<br/>
<td width='100' class='tbl'><b>Lien :</b><br/></td>
<td width='80%' class='tbl'><input type='text' name='url' value="<?php echo $modif_a['lien_event']; ?>" class='text' style='width: 240px'><br/></td>
<br/>
<input type='submit' name='submit' value='Modifier'>
<br/>

<br/><br/>
</form>
<?php
}
?>
	
	</body>

</html>