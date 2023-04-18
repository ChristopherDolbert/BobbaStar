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
        if($do == "lookup") {
            $req = $bdd->query("SELECT * FROM users WHERE username = '".$_POST['username']."'");
            $row = $req->rowCount();
            $req_assoc = $req->fetch(PDO::FETCH_ASSOC);
            if($row > 0) {
            $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
                $insertn1->bindValue(':pseudo', $user['username']);
                $insertn1->bindValue(':action', 'a recherché l\'IP de <b>'.$req_assoc['username'].'</b>');
                $insertn1->bindValue(':date', FullDate('full'));
            $insertn1->execute(); 
    $ip = $req_assoc['ip_current'];
    $username = $req_assoc['username'];
    echo '<h4 class="alert_success">L\'IP du compte <b>'.$username.'</b> à la dernière connexion est la suivante : <b>'.$ip.'</b></h4>';
            } else { echo '<h4 class="alert_error">Le compte n\'existe pas</h4>';
        } 
    }
}
?>
<link rel="stylesheet" href="css/contenu.css" type="text/css" media="screen" /><body>
<span id="titre">Detection IP.</span><br />
Cet outil peut &ecirc;tre utilisé pour la recherche de l'IP d'un utilisateur, particuli&egrave;rement utilisé lorsque vous avez besoin d'exclure une personne d'ordinateur plut&ocirc;t qu'un simple compte. <a href="banip" target="main">Bannir une IP</a><br/><br/>
<form method='post' action="?do=lookup">
Pseudo:<br />
<input type="text" name="username" maxlength="50"><br/><br/>
<input type="submit" value="Rechercher">
</form>
</body>
</html>