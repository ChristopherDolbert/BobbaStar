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
	Redirect("".$url."/managements/acces_neg");
	exit();
	}
	if($user['rank'] > 8) {              
	Redirect("".$url."/managements/acces_neg");
	exit();
	}	

if(isset($_GET['do'])) {
$do = Secu($_GET['do']);
	if($do == "create") {
	if(isset($_POST['info']) || isset($_POST['url']) || isset($_POST['titre']) || isset($_POST['desc']) || isset($_POST['image'])) {
   $titre = Secu($_POST['titre']);
   $desc = Secu($_POST['desc']);
   $image = Secu($_POST['image']);
   $info = Secu($_POST['info']);
   $url_article = Secu($_POST['url']);
      if($titre != "") {
$bdd->query("INSERT INTO gabcms_news (`topstory_image`,`title`,`snippet`,`info`,`body`,`auteur`,`date`,`sign`,`category_id`,`look`,`event`,`lien_event`) VALUES ('".$image."','".addslashes($titre)."','".addslashes($desc)."','".$info."','Ceci n\'est pas un article !','".$user['username']."','".$nowtime."','-','Événement','".$user['look']."','2','http://".$url_article."')");
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a créé un événement avec lien <b>('.addslashes($titre).')</b>');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
	  echo '<h4 class="alert_success">L\'événement vient d\'&ecirc;tre ajouté.</h4>';
	  } else {
	  echo '<h4 class="alert_error">Merci de remplir les champs vides.</h4>';
	  }
  }
}
}
?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?'.mt_rand(); ?>" type="text/css" media="screen" /><body></body>
<span id="titre">Crée un événement</span><br/>
Crées un événement avec un lien afin que tout l'hôtel puisse le voir. Penses à bien compléter tous les champs.
 <br/><br/>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
 <form name='editor' method='post' action="?do=create">
<td width='100' class='tbl'><b>Titre de ton événement :</b><br/></td>
<td width='80%' class='tbl'><input type="text" name="titre" value="<?php  if (!empty($_POST["titre"])) {  echo htmlspecialchars($_POST["titre"],ENT_QUOTES);  } ?>" class="text" style="width: 320px"><br/></td>
<br/>
<td width='100' class='tbl'><b>Description :</b><br/></td>
<td width='80%' class='tbl'><textarea name="desc" rows="5" cols="50"><?php
 if (isset($_POST["desc"])) {
 echo htmlspecialchars($_POST["desc"],ENT_QUOTES);
 }
?></textarea><br/></td>
<br/>
<td width='100' class='tbl'><b>Image que tu afficheras : <a href="<?PHP echo $url; ?>/articles_topstory" target="_blank">Images pour les news</a> </b><br/></td>
<td width='80%' class='tbl'><input type="text" name="image" value="<?php  if (!empty($_POST["image"])) {  echo htmlspecialchars($_POST["image"],ENT_QUOTES);  } ?>" class="text" style="width: 360px"><br/></td>
<br/>
<td width='100' class='tbl'><b>Message du bouton :</b><br/></td>
<td width='80%' class='tbl'><input type="text" name="info" style="background-image: url('images/text_news.png'); height: 54px; width: 147px; border: none; padding-left: 10px; margin-top: 6px; color: white; font-size:14px;" value="En savoir plus »" class="text" maxlength="34"><br/></td>
<br/>
<td width='100' class='tbl'><b>Lien :</b><br/></td>
<td width='80%' class='tbl'>HTTP://<input type="text" name="url" value="<?php  if (!empty($_POST["url"])) {  echo htmlspecialchars($_POST["url"],ENT_QUOTES);  } ?>" class="text" style="width: 240px"><br/></td>
<br/>

<br/>
<td align='center' colspan='2' class='tbl'>
<input type='submit' name='submit' value='Exécuter' class='submit'></form>
</tr>
<br/>
</body>
</html>

</tr>