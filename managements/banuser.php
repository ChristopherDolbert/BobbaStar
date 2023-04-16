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

if(isset($_GET['do'])) {
$username = Secu($_POST['username']);
$raison = Secu($_POST['reason']);
$date = Secu($_POST['date']);
$username = explode(";", $username);
$nbr = count($username);
$do = Secu($_GET['do']);
$date_ac = time();
$date_calcul = $date * 3600;
$date_ban = $date_ac + $date_calcul;  
	if($do == "ban") {
        if(isset($ip) && isset($raison)) {
            if(!empty($ip) && !empty($raison) && !empty($date)) {
	for($n = 0; $n < $nbr; $n++):
		$sql = $bdd->query("SELECT id FROM users WHERE username = '".$username[$n]."'");
		$row = $sql->rowCount();
		if($row > 0) {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a banni <b>'.$username[$n].'</b> pour la raison suivante : '.$raison.'');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
        $bdd->query("INSERT INTO bans (bantype,value,reason,expire,added_by,added_date,appeal_state) VALUES ('user','".$username[$n]."','".$raison."','".$date_ban."','".$user['username']."','".FullDate('full')."','0')");
				
				echo '<h4 class="alert_success">Le compte <b>'.$username[$n].'</b> &agrave; &eacute;t&eacute; bannis pour la raison suivante: <b>'.$raison.'</b></h4>';
					} else {
					echo '<h4 class="alert_error">>Le compte <b>'.$username[$n].'</b> n\'existe pas.</h4>';
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
<span id="titre">Bannir des utilisateurs</span><br />
Bannis plusieurs utilisateurs en m&ecirc;me temps pour cela apr&egrave;s chaque utilisateur mettez un point virgule (;).<br/><br/>
<form name='editor' method='post' action="?do=ban">
<td width='100' class='tbl'><b>Pseudo :</b><br/></td>
<td width='80%' class='tbl'><textarea name='username' wrap=discuss rows=3 cols=34 maxlength="50"></textarea><br/></td>
<br/><td width='100' class='tbl'><b>Raison:</b><br/></td>
<td width='80%' class='tbl'><textarea name='reason' wrap=discuss rows=3 cols=34 ></textarea><br/></td><br/>
<td width='80%' class='tbl'><select name="date" id="lenght" class="select"><option value="1">1 heures</option><option value="2">2 heures</option><option value="3">3 heures</option><option value="4">4 heures</option><option value="10">10 heures</option><option value="12">12 heures</option><option value="24">1 jour</option><option value="48">2 jours</option><option value="72">3 jours</option><option value="96">4 jours</option><option value="168">1 semaine</option><option value="336">2 semaines</option><option value="672">1 mois</option><option value="1344">2 mois</option><option value="4032">6 mois</option><option value="8064">1 an</option><option value="16128">2 ans</option><option value="525420">Permanent</option></select>
<tr>
<td align='center' colspan='2' class='tbl'>
<input type='submit' name='submit' value='Ex&eacute;cuter' class='submit'></form>
</tr>
</body>
</html>

</tr>