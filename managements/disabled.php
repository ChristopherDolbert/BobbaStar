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
$pseudo = Secu($_POST['name']);
$name = explode(";", $pseudo);
$nbr = count($name);
$do = Secu($_GET['do']);
	if($do == "ban") {
	if(isset($pseudo)) {
		if(!empty($pseudo)) {
	for($n = 0; $n < $nbr; $n++):
		$sql = $bdd->query("SELECT id FROM users WHERE username = '".$name[$n]."'");
		$row = $sql->rowCount();
		if($row < 1) {
				echo '<h4 class="alert_error">Le compte <b>'.$name[$n].'</b> n\'existe pas.</h4>';
				
				} else {
				$check = $bdd->query("SELECT id FROM users WHERE username = '".$name[$n]."' AND disabled = '0'");
				$row_c = $check->rowCount();
				if($row_c > 0) {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a désactivé le compte de <b>'.$name[$n].'</b>');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
		$bdd->query("UPDATE users SET disabled = '1' WHERE username = '".$name[$n]."'");
				echo '<h4 class="alert_success">Le compte <b>'.$name[$n].'</b> a été désactivé.</h4>';					
					} else {
					echo '<h4 class="alert_error">Le compte <b>'.$name[$n].'</b> est déj&agrave; désactivé.</h4>';
					}
				}
	endfor;
									 } else {
					echo '<h4 class="alert_error">Les champs ne sont pas tous remplie.</h4>';
					}
			} 
	}
}
?>
<link rel="stylesheet" href="css/contenu.css" type="text/css" media="screen" /><body></body>
<span id="titre">Désactives des comptes</span><br />
Désactives plusieurs comptes en m&ecirc;me temps pour cela apr&egrave;s chaque pseudo mettez un point virgule (;).<br/><br/>
<form name='editor' method='post' action="?do=ban">
<td width='100' class='tbl'><b>Pseudo:</b><br/></td>
<td width='80%' class='tbl'><textarea name='name' wrap=discuss rows=3 cols=34 maxlength="50"></textarea><br/></td>
<br/>
<tr>
<td align='center' colspan='2' class='tbl'>
<input type='submit' name='submit' value='Exécuter' class='submit'></form>
</tr>
</body>
</html>

</tr>