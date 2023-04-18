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
		
?>
<link rel="stylesheet" href="css/contenu.css" type="text/css" media="screen" /><body></body>
<span id="titre">Info utilisateur</span><br />
Entres le nom de l'utilisateur pour afficher ses infos<br/><br/>
<form method='post' action="?do=lookup">
Pseudo :<br />
<input type="text" name="username" maxlength="50">&nbsp;
<input type="submit" value="Rechercher">
</form>
</tr>

<?PHP
if(isset($_GET['do'])) {
$do = Secu($_GET['do']);
    if($do == "lookup") {
        $req = $bdd->query("SELECT * FROM users WHERE username = '".$_POST['username']."'");
        $row = $req->rowCount();
        $req_assoc = $req->fetch(PDO::FETCH_ASSOC);
        if($row > 0) {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a recherché des infos sur <b>'.$req_assoc['username'].'</b>');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
$ip = $req_assoc['ip_last'];
$username = $req_assoc['username'];
$id = $req_assoc['id'];
$jetons = $req_assoc['jetons'];
$last_online = $req_assoc['last_online'];
$connexion = date('d/m/Y H:i:s', $last_online);
$motto = $req_assoc['motto'];
$look = $req_assoc['look'];
$gender = $req_assoc['gender'];
$mail = $req_assoc['mail'];
$rank = $req_assoc['rank'];
$disabled = $req_assoc['disabled'];
if($req_assoc['disabled'] == 1) {
$modifier_disabled = "<span style=\"color: #ff0000;\">désactivé</span>";
}

if($req_assoc['disabled'] == 0) {
$modifier_disabled = "<span style=\"color: #008000;\">activé</span>";
}

if($req_assoc['gender'] == 'F') {
$modifier_gender = "<span style=\"color: #FF6699;\">";
}

if($req_assoc['gender'] == 'M') {
$modifier_gender = "<span style=\"color: #0000ff;\">";
}
echo '
Son pseudo : '.$modifier_gender.'<b>'.$username.'</b></span> <br/>
Son ID : '.$modifier_gender.'<b>'.$id.'</b> </span><br/>
Son IP : '.$modifier_gender.'<b>'.$ip.'</b> </span><br/>
Jetons au total : '.$modifier_gender.'<b>'.$jetons.'</b> </span><br/>
Dernière connexion : '.$modifier_gender.'<b>'.$connexion.'</b> </span><br/>
Sa phrase perso : '.$modifier_gender.'<b>'.$motto.'</b> </span><br/>
Son look : '.$modifier_gender.'<b>'.$look.'</b> </span><br/>
Ce compte est <b>'.$modifier_disabled.'</b><br/>
Son adresse Email: '.$modifier_gender.'<b>'.$mail.'</b> </span><br/>
Son rank : '.$modifier_gender.'<b>'.$rank.'</b></span> <br/>
<br/><br/><a href="'.$url.'/managements/act_users?modif='.$id.'">Modifier ses informations</a><br/><br/>
Légende : <span style="color: #FF6699;">rose</span> = fille, <span style="color: #0000ff;">bleu</span> = garçon.';
        } else {
        echo '<h4 class="alert_error">Le compte n\'existe pas</h4>';
    }
}
}
?>
</body>
</html>