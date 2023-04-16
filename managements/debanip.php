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
$ip = Secu($_POST['ip']);
$ip= explode(";", $ip);
$nbr = count($ip);
$do = Secu($_GET['do']);
	if($do == "ban") {
	if(isset($ip)) {
		if(!empty($ip)) {
	
	for($n = 0; $n < $nbr; $n++):
				$check = $bdd->query("SELECT * FROM bans WHERE value = '".$ip[$n]."'");
				$row_c = $check->rowCount();
				if($row_c > 0) {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a procédé au débanissement de l\'ip <b>'.$ip[$n].'</b>');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
        $bdd->query("DELETE FROM bans WHERE value = '".$ip[$n]."'");
				echo '<h4 class="alert_success">L\'adresse IP <b>'.$ip[$n].'</b> &agrave; &eacute;t&eacute; d&eacute;bannis.</h4>';					
					} else {
					echo '<h4 class="alert_error">L\'adresse IP  <b>'.$ip[$n].'</b> n\'est pas bannis.</h4>';
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
<span id="titre">D&eacute;bannir des adresses IP</span><br />
Débannis des IP que vous avez bannis précédemment.<br/><br/>
<form name='editor' method='post' action="?do=ban">
<td width='100' class='tbl'><b>Adresse IP:</b><br/></td>
<td width='80%' class='tbl'><textarea name='ip' wrap=discuss rows=3 cols=34 ></textarea><br/></td>
<br/>
<tr>
<td align='center' colspan='2' class='tbl'>
<input type='submit' name='submit' value='Ex&eacute;cuter' class='submit'></form>
</tr><br/>
Voici la liste des bannis actuel.
   <br />
<table>
    <tbody>
        <tr class="haut">
            <td class="haut">IP</td>
            <td class="haut">Raison</td>
            <td class="haut">Banni par</td>
            <td class="haut">Jusqu'au</td>
        </tr>
<?PHP
 $sql = $bdd->query("SELECT * FROM bans WHERE bantype='ip' ORDER BY id DESC");
 while($a = $sql->fetch()) {
    $stamp_now = mktime(date('H:i:s d-m-Y'));
    $stamp_expire = $a['expire'];
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