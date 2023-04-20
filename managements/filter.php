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
$pseudo = htmlspecialchars($_POST['name']);
$name = explode(";", $pseudo);
$nbr = count($name);
$filter = htmlspecialchars($_POST['filtre']);
$do = Secu($_GET['do']);
if($do == "filtre") {	
	if(isset($pseudo)) {
		if(!empty($pseudo)) {
	for($n = 0; $n < $nbr; $n++):
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a filtré le mot <b>'.addslashes($name[$n]).'</b> qui est remplacé par <b>'.addslashes($filter).'</b>');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
		$bdd->query("INSERT INTO wordfilter (word, replacement, strict) VALUES ('".$name[$n]."', '".$filter."', '1')");
				echo '<h4 class="alert_success">>Le mot : <b>'.$name[$n].'</b> &agrave; été ajouté.</h4>';
	endfor;
									 } else {
					echo '<h4 class="alert_error">Les champs ne sont pas tous remplie.</h4>';
					}
			} 
	}
}
?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?'.mt_rand(); ?>" type="text/css" media="screen" /><body></body>
<span id="titre">Filtres un mot.</span><br />
Ici vous pourriez filtrer plusieurs mots en les séparents d'un point virgule (;). Ces mots seront filtrés sur le tchat, et sur le client !<br/><br/>
<form name='editor' method='post' action="?do=filtre">
<td width='100' class='tbl'><b>Mot interdit :</b><br/></td>
<td width='80%' class='tbl'><textarea name='name' wrap=discuss rows=3 cols=34 ></textarea><br/></td>
<td width='100' class='tbl'><b>Remplacé par..</b><br/></td>
<td width='80%' class='tbl'><textarea name='filtre' wrap=discuss rows=3 cols=34 ></textarea><br/></td>
<tr><br/>
<td align='center' colspan='2' class='tbl'>
<input type='submit' name='submit' value='Exécuter' class='submit'></form>
</tr>
<hr/>
<span id="titre">Les mots actuellements filtrés</span><br />
Tu peux voir les mots actuellements filtrés.<br/><br/>
<table>
    <tbody>
        <tr class="haut">
            <td class="haut">Mot filtré</td>
            <td class="haut">Remplacé par</td>
        </tr>
<?PHP
$sql = $bdd->query("SELECT * FROM wordfilter");
while($a = $sql->fetch()) {
?>
        <tr class="bas">
            <td class="bas"><?PHP echo $a['word']; ?></td>
            <td class="bas"><?PHP echo $a['replacement']; ?></td>
        </tr>
<?PHP } ?>
    </tbody>
</table>
</body>
</html>