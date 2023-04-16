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
if(isset($_GET['do'])) {
$do = Secu($_GET['do']);
    if($do == "modif") {
        if(isset($_POST['haut']) || isset($_POST['bas'])) {
       $haut = addslashes($_POST['haut']);
       $bas = addslashes($_POST['bas']);
            if($haut != "" && $bas != "") {
            $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
                $insertn1->bindValue(':pseudo', $user['username']);
                $insertn1->bindValue(':action', 'a modifié <b>les textes</b> de la <b>newsletter</b>');
                $insertn1->bindValue(':date', FullDate('full'));
            $insertn1->execute(); 
            $bdd->query("UPDATE gabcms_newsletter SET newsletter_haut = '".$haut."', newsletter_bas = '".$bas."' WHERE id = '1'");
            echo '<h4 class="alert_success">Les textes des newsletters viennent d\'être modifié.</h4>';
            } else {
            echo '<h4 class="alert_error">Merci de remplir les champs vide</h4>';
            }
        }
    }
}
?>
<link rel="stylesheet" href="css/contenu.css" type="text/css" media="screen" /><body>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script type="text/javascript" src="<?PHP echo $imagepath; ?>editor/ckeditor.js"></script>
<script type="text/javascript" src="<?PHP echo $imagepath; ?>editor/config.js"></script>
<?PHP
$sql_modif = $bdd->query("SELECT * FROM gabcms_newsletter WHERE id = '1'");
$modif_a = $sql_modif->fetch();
?>
<span id="titre">Modification des textes de base</span><br \>
Tu peux modifié dans le texte ci-dessous, le texte qui sera afficher en haut ou en bas de ta newsletter.<br/>
Met le code <b>$date</b> pour afficher la date le jour de l'envoi (Au format suivant : JJ/MM/AAAA)
<br/><br/>
<form name="editor" method="post" action="?do=modif">
<td width="100" class="tbl"><b>Le haut de ta newsletter :</b><br/></td>
<td width="80%" class="tbl"><textarea name="haut" wrap="discuss rows=10 cols=142" id="editor1"><?php echo $modif_a['newsletter_haut']; ?></textarea>
<script>CKEDITOR.replace( 'editor1', { toolbar : 'Newsletter' });</script>
<br/></td><br/> 
<td width="100" class="tbl"><b>Le bas de ta newsletter :</b><br/></td>
<td width="80%" class="tbl"><textarea name="bas" wrap="discuss rows=10 cols=142" id="editor2"><?php echo $modif_a['newsletter_bas']; ?></textarea>
<script>CKEDITOR.replace( 'editor2', { toolbar : 'Newsletter' });</script>
<br/><br/></td>
<input type='submit' name='submit' value='Modifier'>
</form>
</body>
</html>