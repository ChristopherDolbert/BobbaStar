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
	
	if($user['rank'] < 7) {
	Redirect("".$url."/managements/acces_neg");
	exit();
	}
	if($user['rank'] > 8) {              
	Redirect("".$url."/managements/acces_neg");
	exit();
	}	
	
	if(isset($_POST['texte'])) {
   $texte = $_POST['texte'];		
      if($texte != "") {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a modifié le message du bloc-notes <b>(Bureau des staffs)</b>');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
        $bdd->query("UPDATE gabcms_bureau_notes SET texte = '".addslashes($texte)."', date = '".FullDate('full')."', par = '".$user['username']."' WHERE id = '1'");
	  echo '<h4 class="alert_success">Le message dans le bloc-notes a été mis à jour !</h4>';
	  } else {
	  echo '<h4 class="alert_error">Merci d\'écrire quelque chose</h4>';
	  }
  }
$sql = $bdd->query("SELECT * FROM gabcms_bureau_notes WHERE id = '1'");
$c = $sql->fetch(PDO::FETCH_ASSOC);
?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script type="text/javascript" src="<?PHP echo $imagepath; ?>editor/ckeditor.js"></script>
<script type="text/javascript" src="<?PHP echo $imagepath; ?>editor/config.js"></script>
<link rel="stylesheet" href="css/contenu.css" type="text/css" media="screen" /><body>
<span id="titre">Message du bloc-notes</span><br/>
Modifies le message du bloc-notes dans le bureau des staffs<br/><br/>
<form name='editor' method='post' action="?do=modif">
<td width='100' class='tbl'><b>Message du bloc-notes : <a href="<?PHP echo $url; ?>/managements/upload" target="_blank">Upload tes images !</a> </b><br/></td>
<td width='80%' class='tbl'><textarea name='texte' wrap="discuss rows=12 cols=154" id="editor1"><?php echo $c['texte']; ?></textarea>
<script>CKEDITOR.replace( 'editor1', { toolbar : 'Journalisme' });</script>
<br/></td>
<td align='center' colspan='2' class='tbl'>
<input type='submit' name='submit' value='Exécuter' class='submit'></form>
<br/>
</body>
</html>