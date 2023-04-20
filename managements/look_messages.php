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
	
if(isset($_GET['do'])) {
$do = Secu($_GET['do']);
	if($do == "lookmes") {
        $req = $bdd->query("SELECT * FROM users WHERE username = '".$_POST['username']."'");
        $row = $req->rowCount();
        $req_assoc = $req->fetch(PDO::FETCH_ASSOC);
        if($row > 0) {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a recherché le nombre de messages que <b>'.$req_assoc['username'].'</b> peut poster sur le tchat');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
            $message = $req_assoc['message'];
            $username = $req_assoc['username'];
        echo '<h4 class="alert_success"><b>'.$username.'</b> a <b>'.$message.'</b> message(s) à utilisés.</h4>';
        } else {
        echo '<h4 class="alert_error">Le compte n\'existe pas</h4>';
        } 
}
}
?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?'.mt_rand(); ?>" type="text/css" media="screen" /><body>
<span id="titre">Info messages</span><br />
Cet outil est fait pour savoir combien l'utilisateur a de message(s).<br/><br/>
<form method='post' action="?do=lookmes">
<b>Pseudo:</b><br/>
<input type="text" name="username" maxlength="50"><br/><br/>
<input type="submit" value="Rechercher">
</form>
</body>
</html>
