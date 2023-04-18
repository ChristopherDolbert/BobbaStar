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
				$check = $bdd->query("SELECT * FROM bans WHERE value = '".$name[$n]."'");
				$row_c = $check->rowCount();
				if($row_c > 0) {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a procédé au débanissement de <b>'.$name[$n].'</b>');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
		$bdd->query("DELETE FROM bans WHERE value = '".$name[$n]."'");
				echo '<h4 class="alert_success">Le compte <b>'.$name[$n].'</b> &agrave; été débannis.</h4>';					
					} else {
					echo '<h4 class="alert_error">Le compte <b>'.$name[$n].'</b> n\'est pas bannis.</h4>';
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
<span id="titre">Débannir des utilisateurs</span><br />
Débannis plusieurs utilisateurs en m&ecirc;me temps pour cela apr&egrave;s chaque pseudo mettez un point virgule (;).<br/><br/>
<form name='editor' method='post' action="?do=ban">
<td width='100' class='tbl'><b>Pseudo:</b><br/></td>
<td width='80%' class='tbl'><textarea name='name' wrap=discuss rows=3 cols=34 ></textarea><br/></td>
<br/>
<tr>
<td align='center' colspan='2' class='tbl'>
<input type='submit' name='submit' value='Exécuter' class='submit'></form>
</tr><br/>
Voici la liste des bannis actuel.<br />
<table>
    <tbody>
        <tr class="haut">
            <td class="haut">Pseudo</td>
            <td class="haut">Raison</td>
            <td class="haut">Banni par</td>
            <td class="haut">Jusqu'au</td>
        </tr>
<?PHP
$sql = $bdd->query("SELECT * FROM bans WHERE bantype='user' ORDER BY id DESC");
 while($a = $sql->fetch()) {
    $expire = date('d/m/Y H:i', $a['expire']);
?>
        <tr class="bas">
            <td class="bas"><?PHP echo $a['value']; ?></td>
            <td class="bas"><?PHP echo $a['reason']; ?></td>
            <td class="bas"><?PHP echo $a['added_by']; ?></td>
            <td class="bas"><?PHP echo $expire; ?></td>
        </tr>
<?PHP } ?>
    </tbody>
</table>
</body>
</html>