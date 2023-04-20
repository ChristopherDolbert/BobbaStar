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
if(isset($_GET['pseudo'])) {
$pseudo = Secu($_GET['pseudo']);
}
if(isset($_GET['signalement'])) {
$signalement = Secu($_GET['signalement']);
} if(isset($_GET['signale'])) {
$signale = Secu($_GET['signale']);
}
if(isset($_POST['username']) && isset($_POST['alerte'])) {
	if(empty($_POST['username']) && empty($_POST['alerte'])) {
	} else {
	$usernamea = Secu($_POST['username']);
	$sujet = Secu($_POST['sujet']);
	$act = Secu($_POST['act']);
	$sql = $bdd->query("SELECT id FROM users WHERE username = '".$username."'");
	$row = $sql->rowCount();
	$assoc = $sql->fetch(PDO::FETCH_ASSOC);
		$infr = $bdd->query("SELECT * FROM gabcms_forum_signalement WHERE id = '".$signale."'");
		$r = $infr->fetch();
	if($row['id'] < 1) {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a envoyé une alerte à <b>'.$usernamea.'</b> suite au signalement de <b>'.$r['signaler_par'].'</b> (ID : '.$r['id'].')');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute();
        $insertn2 = $bdd->prepare("INSERT INTO gabcms_alertes (userid,sujet,alerte,par,date,look,action) VALUES (:userid, :sujet, :alerte, :par, :date, :look, :act)");
            $insertn2->bindValue(':userid', $assoc['id']);
            $insertn2->bindValue(':sujet', $sujet);
            $insertn2->bindValue(':alerte', addslashes($_POST['alerte']));
            $insertn2->bindValue(':par', $user['username']);
            $insertn2->bindValue(':date', FullDate('full'));
            $insertn2->bindValue(':look', $user['look']);
            $insertn2->bindValue(':act', $act);
        $insertn2->execute();
        $insertn3 = $bdd->prepare("INSERT INTO gabcms_management (user_id, message, auteur, date, look) VALUES (:userid, :message, :user, :date, :look)");
            $insertn3->bindValue(':userid', $assoc['id']);
            $insertn3->bindValue(':message', 'Nous venons de t\'envoyer une alerte ! Merci d\'aller la lire au <b>PLUS VITE</b> en <a href=\"'.$url.'/alerts\">cliquant ici</a> !');
            $insertn3->bindValue(':user', $user['username']);
            $insertn3->bindValue(':date', FullDate('full'));
            $insertn3->bindValue(':look', $user['look']);
        $insertn3->execute();
	   echo '<h4 class="alert_success">L\'alerte a été envoyer avec succès !</h4>';
	  } else {
	  echo '<h4 class="alert_error">Merci de remplir les champs vide</h4>';
	  }
  }
  }
?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?'.mt_rand(); ?>" type="text/css" media="screen" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8" /><body>
<title>Envoyer une alerte suite à un topic</title> 
 <script language="javascript" type="text/javascript">
   function insert_texte(texte)
   {
       var ou = document.getElementsByName("alerte")[0];
       var phrase = texte +" ";
       ou.value += phrase;
       ou.focus();
   }
</script>
<?PHP if(isset($_GET['signalement'])) { ?>
<span id="titre">Envoyes une alerte</span><br/>
Envoyes une alerte à un utilisateur que tu souhaites.
 <br/>
 <br/> 
 <form method="post" action="?do=givebadge&signale=<?PHP echo $signalement; ?>">
<td width='100' class='tbl'><b>Pseudo :</b><br/></td>
<td width='80%' class='tbl'><input type='text' name='username' value="<?PHP echo $pseudo; ?>" class='text' style='width: 240px' maxlength="50" readonly><br/></td><br/>
<td width='100' class='tbl'><b>Sujet :</b><br/></td>
<td width='80%' class='tbl'><input type='text' name='sujet' value='' class='text' style='width: 240px' maxlength="500"><br/></td>																																			<br/>
<td width='100' class='tbl'><b>Alerte :</b><br/></td>
<a href="#" onclick="insert_texte('<b> </b>')"><img src="<?PHP echo $imagepath; ?>smileys/gras.png"/></a>
<a href="#" onclick="insert_texte('<i> </i>')"><img src="<?PHP echo $imagepath; ?>smileys/italique.png"/></a>
<a href="#" onclick="insert_texte('<u> </u>')"><img src="<?PHP echo $imagepath; ?>smileys/souligne.png"/></a><br/>
<td width='80%' class='tbl'><textarea name='alerte' wrap=discuss rows=3 cols=34 ></textarea><br/></td>
<td width='100' class='tbl'><b>Trait du visage :</b><br/></td>
<select name="act" id="pays">
			<option value="0">Normal</option>
			<option value="sml">Heureux</option>
			<option value="agr">Énervé</option>
			<option value="srp">Étonné</option>			
</select>
<br/><br/>
	<input type="submit" value="Envoyer l'alerte" />

</form>
<?PHP } else { ?>
<span id="titre">Selectionnes un topic</span><br \>
Merci de sélectionner un topic
<?PHP } ?>
</body>
</html>