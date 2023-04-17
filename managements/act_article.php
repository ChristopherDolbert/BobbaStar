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
	if($user['rank'] < 6) {
	Redirect("".$url."/managements/acces_neg");
	exit();
	}
	if($user['rank'] > 8) {              
	Redirect("".$url."/managements/acces_neg");
	exit();
	}	

if(isset($_GET['modif'])) { $modif = Secu($_GET['modif']); }
if(isset($_GET['modift'])) { $modift = Secu($_GET['modift']); }

if(isset($_GET['modifiernews'])) {
	$modifiernews = Secu($_GET['modifiernews']);
	if(isset($_POST['desc']) || isset($_POST['image']) || isset($_POST['article']) || isset($_POST['sign']) || isset($_POST['info']) || isset($_POST['commentaires'])) {
   $desc = Secu($_POST['desc']);
   $image = Secu($_POST['image']);
   $article = $_POST['article'];
   $sign = Secu($_POST['sign']);
   $ca = Secu($_POST['catart']);
   $info = Secu($_POST['info']);	
   $sql_mo = $bdd->query("SELECT * FROM gabcms_news WHERE id = '".$modifiernews."'");
   $mod_t = $sql_mo->fetch();   
      if($desc != "" && $image != "" && $article != "") {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a modifié un article <b>('.$mod_t['title'].')</b>');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
        $insertn2= $bdd->prepare("UPDATE gabcms_news SET topstory_image = :img, info = :info, snippet = :desc, category_id = :ca, sign = :sign, body = :body, modifier = :modif, modif_date = :date, modif_auteur = :auteur, look = :look WHERE id = :id");
            $insertn2->bindValue(':img', $image);
            $insertn2->bindValue(':info', $info);
            $insertn2->bindValue(':desc', $desc);
            $insertn2->bindValue(':ca', $ca);
            $insertn2->bindValue(':sign', $sign);
            $insertn2->bindValue(':body', addslashes($article));
            $insertn2->bindValue(':modif', '1');
            $insertn2->bindValue(':date', $nowtime);
            $insertn2->bindValue(':auteur', $user['username']);
            $insertn2->bindValue(':look', $user['look']);
            $insertn2->bindValue(':id', $modifiernews);
        $insertn2->execute();
	  echo '<h4 class="alert_success">L\'article vient d\'&ecirc;tre modifié.</h4>';
	  } else {
	  echo '<h4 class="alert_error">Merci de remplir les champs vide</h4>';
	  }
  }
		}

if(isset($_GET['modifiertitle'])) {
    $modifiertitle = Secu($_GET['modifiertitle']);
	if(isset($_POST['titre'])) {
   $titre = Secu($_POST['titre']);
   $sql_modir = $bdd->query("SELECT * FROM gabcms_news WHERE id = '".$modifiertitle."'");
   $modif_r = $sql_modir->fetch();
      if($titre != "") {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a modifié le titre d\'un article <b>'.$titre.'</b> (auparavant : '.$modif_r['title'].')');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
        $insertn2 = $bdd->prepare("UPDATE gabcms_news SET title = :titre, modifier = :modif, modif_date = :date, modif_auteur = :auteur, look = :look WHERE id = :id");
            $insertn2->bindValue(':titre', $titre);
            $insertn2->bindValue(':modif', '1');
            $insertn2->bindValue(':date', $nowtime);
            $insertn2->bindValue(':auteur', $user['username']);
            $insertn2->bindValue(':look', $user['look']);
            $insertn2->bindValue(':id', $modifiertitle);
        $insertn2->execute();
	  echo '<h4 class="alert_success">Le titre de l\'article vient d\'&ecirc;tre modifié.</h4>';
	  } else {
	  echo '<h4 class="alert_error">Merci de marquer un titre</h4>';
	  }
    }
}		

if(isset($_GET['do'])) {
    $do = Secu($_GET['do']);
    $sql_do = $bdd->query("SELECT * FROM gabcms_news WHERE id = '".$do."'");
    $mod_do = $sql_do->fetch();  
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a supprimé un article <b>('.$mod_do['title'].')</b>');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
        $bdd->query("DELETE FROM gabcms_news_recommande WHERE news_id = '".$do."'");
        $bdd->query("DELETE FROM gabcms_news WHERE id = '".$do."'");
	echo '<h4 class="alert_success">L\'article vient d\'&ecirc;tre supprimé</h4>';
	}
?>
<link rel="stylesheet" href="css/contenu.css" type="text/css" media="screen" /><body>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script type="text/javascript" src="<?PHP echo $imagepath; ?>editor/ckeditor.js"></script>
<script type="text/javascript" src="<?PHP echo $imagepath; ?>editor/config.js"></script>
	<?php if(!isset($_GET['modif']) && !isset($_GET['modift'])) { ?>
<span id="titre">Actions sur des articles</span><br/>
Choisis l'article que tu désires modifier ou supprimer.
<br/><br/>
<div class="content">
<table>
    <tbody>
        <tr class="haut">
            <td class="haut">Titre de l'article</td>
            <td class="haut">Description</td>
            <td class="haut">Créer par</td>
            <td class="haut">Date</td>
            <td class="haut">Actions</td>
        </tr>
<?php
 $sql = $bdd->query("SELECT * FROM gabcms_news WHERE event = '1' ORDER BY id DESC LIMIT 0,100");
 while($a = $sql->fetch()) {
     $date_but = date('d/m/Y à H:i', $a['date']);
?>
        <tr class="bas">
            <td class="bas"><?PHP echo stripslashes($a['title']); ?> <i>(<a href="?modift=<?PHP echo Secu($a['id']); ?>">Modifier le titre</a>)</i></td>
            <td class="bas"><?PHP echo stripslashes($a['snippet']); ?></td>
            <td class="bas"><?PHP echo Secu($a['auteur']); ?></td>
            <td class="bas"><?PHP echo Secu($date_but); ?></td>
            <td class="bas"><a href="?modif=<?PHP echo Secu($a['id']); ?>">Modifier</a> - <a href="?do=<?PHP echo Secu($a['id']); ?>" onclick="return confirm(\'Êtes-vous certain de supprimer cet article ?\')">Supprimer</a></td>
        </tr>
<?PHP } ?>
</tbody>
</table>
</div>
	<?php
	}
	?>
<?php if(isset($_GET['modif'])) {
$sql_modif = $bdd->query("SELECT * FROM gabcms_news WHERE id = '".$modif."'");
$modif_a = $sql_modif->fetch();
?>
<span id="titre">Modification de l'article.</span><br/>
Tu peux modifié la description, l'image, le corps de ton article, le texte de ton button et pleins d'autres choses !
<br/><br/>
<form name="editor" method="post" action="?modifiernews=<?php echo $modif; ?>">
<td width="100" class="tbl"><b>Catégorie de l'article :</b><br/></td>
<label><input type="radio" name="catart" value="articles" <?PHP if($modif_a['category_id'] == "articles") { ?> checked="checked" <?PHP } ?> />Article</label> 
<label><input type="radio" name="catart" value="événements" <?PHP if($modif_a['category_id'] == "événements") { ?> checked="checked" <?PHP } ?> />Événement</label> 
<label><input type="radio" name="catart" value="informations" <?PHP if($modif_a['category_id'] == "informations") { ?> checked="checked" <?PHP } ?>/>Information</label>
<label><input type="radio" name="catart" value="communiqués" <?PHP if($modif_a['category_id'] == "communiqués") { ?> checked="checked" <?PHP } ?>/>Communiqué</label> <br/><br/>
<td width="100" class="tbl"><b>Description :</b><br/></td>
<td width="80%" class="tbl"><input type="text" name="desc" value="<?php echo $modif_a['snippet']; ?>" class="text" style="width: 480px"><br/></td>
<br/>
<td width="100" class="tbl"><b>Image que tu afficheras : <a href="<?PHP echo $url; ?>/articles_topstory" class="new-button green-button" target="_blank"><b>Images pour les news</b><i></i></a> </b><br/></td>
<td width="80%" class="tbl"><input type="text" name="image" value="<?php echo nl2br($modif_a['topstory_image']); ?>" class="text" style="width: 360px"><br/></td>
<br/>
<td width="100" class="tbl"><b>Le corps de l'article : <a href="<?PHP echo $url; ?>/managements/upload" target="_blank">Upload tes images !</a> </b><br/></td>
<td width="80%" class="tbl"><textarea name="article" wrap="discuss rows=12 cols=142" id="editor1"><?php echo $modif_a['body']; ?></textarea>
<script>CKEDITOR.replace( 'editor1', { toolbar : 'Journalisme' });</script>
<br/></td>
<td width="100" class="tbl"><b>Message du bouton :</b><br/></td>
<td width="80%" class="tbl"><input type="text" name="info" style="background-image: url('images/text_news.png'); height: 54px; width: 147px; border: none; padding-left: 10px; margin-top: 6px; color: white; font-size:14px;" value="<?PHP echo $modif_a['info']; ?>" class="text"><br/></td>
<br/>
<td width="100" class="tbl"><b>Signature :</b><br/></td>
<td width="80%" class="tbl"><input type="text" name="sign" value="<?php echo nl2br($modif_a['sign']); ?>" class="text" style="width: 240px"><br/></td>
<br/>
<input type='submit' name='submit' value='Modifier'>
</form>
<?php
}
?>
<?php if(isset($_GET['modift'])) { ?>
<?PHP
$sql_modie = $bdd->query("SELECT * FROM gabcms_news WHERE id = '".$modift."'");
$modif_e = $sql_modie->fetch();
?>
<span id="titre">Modification du titre de l'article.</span><br \>
Tu peux modifié le titre de l'article.
<br/><br/>
<form name="editor" method="post" action="?modifiertitle=<?php echo $modift; ?>">
<td width="100" class="tbl"><b>Titre de ton article :</b><br/></td>
<td width="80%" class="tbl"><input type="text" name="titre" value="<?php echo $modif_e['title']; ?>" class="text" style="width: 480px"><br/></td>
<br/>
<input type='submit' name='submit' value='Modifier le titre'>
</form>
<?php
}
?>
</div></div>
</body>
</html>