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
$do = Secu($_GET['do']);
	if($do == "massjetons"){
    $jetons = Secu($_POST['jetons']);
    $nombre = Secu($_POST['nombre']);
    $valid = Secu($_POST['validite']);
        if(is_numeric($nombre) != "") {
        $base = Genere_lettre(4);
        $base = $base . "-";
        $base = $base . Genere_lettre(4);
        $base = $base . "-";
        $base = $base . Genere_lettre(4);
        $base = $base . "-";
        $base = $base . Genere_lettre(4);
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a créé un code jetons pour <b>'.$nombre.' personne(s)</b> (d\'une valeur de <b>'.$jetons.' jetons</b>)');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
		$insertn2 = $bdd->prepare("INSERT INTO gabcms_jetons (nombremax, code, value, valid) VALUES (:nbr, :code, :jetons, :valid)");
            $insertn2->bindValue(':nbr', $nombre);
            $insertn2->bindValue(':code', $base);
            $insertn2->bindValue(':jetons', $jetons);
            $insertn2->bindValue(':valid', $valid);
        $insertn2->execute();
				echo '<h4 class="alert_success">Le code jetons a été crée : <b>'.$base.'</b> d\'une valeur de <b>'.$jetons.'</b> jetons pour '.$nombre.' utilisateur(s)</h4>';
			} else {
				echo '<h4 class="alert_error">Merci d\'écrire que des chiffres</h4>';
			}
				
		}
}
?>
<link rel="stylesheet" href="css/contenu.css" type="text/css" media="screen" /><body></body>
<SCRIPT LANGUAGE="JavaScript">
function newPopup(url, name_page)
{
window.open (url, name_page, config='height=300, width=900, toolbar=no, menubar=no, scrollbars=yes, resizable=no, location=no, directories=no, status=no');
}
</SCRIPT>
<span id="titre">Crées un code jetons</span><br/>
Donnes au nombre de personnes de ton choix, <b>1</b> code qui lui servira &agrave; gagner des jetons en rentrant le code depuis la page jetons du site.<br/><br/><form name='editor' method='post' action="?do=massjetons">
<b>Code valide combien de fois ? :</b><br/>
<input type="text" name="nombre" value="" class="text" size="3" maxlength="3"><br/>
<b>Nombre de jetons :</b><br/>
<select name="jetons" id="jetons" class="select">
<option value="1">1 jetons</option>
<option value="5">5 jetons</option>
<option value="10">10 jetons</option>
<option value="15">15 jetons</option>
<option value="20">20 jetons</option>
<option value="25">25 jetons</option>
<option value="30">30 jetons</option></select><br/>
<tr>
<b>Validité du code :</b><br/>
<i>Est-ce que...</i><br/>
    <input type="radio" value="1" name="validite" checked />... le code sera valide qu'une fois par personne ?<br/>
    <input type="radio" value="0" name="validite" />... le code sera valide autant de fois que le veut la personne ?<br/><br/>
<td align='center' colspan='2' class='tbl'>
<input type='submit' name='submit' value='Créer' class='submit'></form>
</tr><br/><hr/><br/>
  <?php 
  $sql = $bdd->query("SELECT * FROM gabcms_jetons ORDER BY nombremax DESC");
	if($sql->rowCount() == 0)
        {
            echo "<i><center>Aucun code jetons n'a été crée.</center></i>";
        }
	if($sql->rowCount() >= 1)
        {
            echo '<table><tbody>
<tr class="haut">
<td class="haut">Code jetons</td>
<td class="haut">Nombre d\'utilisation(s) restante(s)</td>
<td class="haut">Nombre de jetons donnés</td>
<td class="haut">Code utilisable</td>
<td class="haut">Historique</td>
</tr>';
	while($n = $sql->fetch()) {
		if($n['nombremax'] <= "3") {
		$modif = "#FF0000";
		}
		if($n['nombremax'] > "3" && $n['nombremax'] < "5") {
		$modif = "#FF4500";
		}
		if($n['nombremax'] >= "5" && $n['nombremax'] < "10") {
		$modif = "#FFA500";
		}
		if($n['nombremax'] >= "10" && $n['nombremax'] < "15") {
		$modif = "#FFCC00";
		}
		if($n['nombremax'] >= "15") {
		$modif = "#008000";
		}
        if($n['valid'] == '0') { $valider = "Autant que veut la personne"; }
        if($n['valid'] == '1') { $valider = "Une fois par personne"; }
?>
<tr class="bas">
<td class="bas"><?PHP echo Secu($n['code'])?></td>
<td class="bas"><span style="color:<?PHP echo $modif?>;"><?PHP echo Secu($n['nombremax'])?></span></td>
<td class="bas"><?PHP echo Secu($n['value'])?></td>
<td class="bas"><?PHP echo Secu($valider)?></td>
<td class="bas"><a href="#" onclick="newPopup('<?PHP echo $url ?>/managements/aff_histo_jetons?id=<?PHP echo $n['id'] ?>', 'Historique stafflogs');return false;">Voir les personnes ayant utilisé</a></td>
</tr>
<?PHP } } ?>
</body>
</html>
