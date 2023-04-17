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
	Redirect("".$url."/managements/acces_neg");
	exit();
	}
	if($user['rank'] > 8) {              
	Redirect("".$url."/managements/acces_neg");
	exit();
	}	
	
	if(isset($_POST['raisons']) || isset($_POST['pseudo'])) {
	$raison = Secu($_POST['raison']);
	$pseudo = Secu($_POST['pseudo']);
	$sql = $bdd->query("SELECT id FROM users WHERE username = '".$pseudo."'");
	$row = $sql->rowCount();
	$assoc = $sql->fetch(PDO::FETCH_ASSOC);
	if($raison != "" && $pseudo != "" && $row > 0) {
        $bdd->query("UPDATE users SET message = '0' WHERE id = '".$assoc['id']."'");
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a enlevé tous les messages à <b>'.$pseudo.'</b>');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute();
        $insertn2 = $bdd->prepare("INSERT INTO gabcms_management (user_id, message, auteur, date, look) VALUES (:userid, :message, :auteur, :date, :look)");
            $insertn2->bindValue(':userid', $modifierrecrut);
            $insertn2->bindValue(':message', 'Nous venons de t\'enlever touts tes messages pour la raison suivante : <b>'.$raison.'</b>');
            $insertn2->bindValue(':auteur', $user['username']);
            $insertn2->bindValue(':date', FullDate('full'));
            $insertn2->bindValue(':look', $user['look']);
        $insertn2->execute();
	   echo '<h4 class="alert_success">Tous les messages de '.$pseudo.' ont été effacés</h4>';
	  } else if($row == 0) {
	  echo '<h4 class="alert_error">Merci d\'entrer un pseudo valide</h4>';
	  } else {
	  echo '<h4 class="alert_error">Merci de remplir les champs vides</h4>';
	  }
  }
?>
<link rel="stylesheet" href="css/contenu.css" type="text/css" media="screen" /><body></body>
<span id="titre">Supprimes tous les messages</span><br />
Enleves tous les messages des utilisateurs qui spam le plus !<br/><br/>
<form name='editor' method='post' action="#">
<td width='100' class='tbl'><b>Pseudo :</b><br/></td>
<td width='80%' class='tbl'><input type='text' name='pseudo' class='text' size="50" maxlength='50'><br/></td>
<td width='100' class='tbl'><b>Raison :</b><br/></td>
<td width='80%' class='tbl'><textarea type='text' name="raison" class='text' wrap=discuss rows=3 cols=34'></textarea><br/></td>
<td align='center' colspan='2' class='tbl'>
<input type='submit' name='submit' value='Exécuter' class='submit'></form></td>
</tr>
</body>
</html>