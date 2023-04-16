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
		Redirect("".$url."/index.php");
		exit();
	}
	
	if($user['rank'] < 7) {
	Redirect("".$url."/managements/acces_neg.php");
	exit();
	}
	if($user['rank'] > 8) {              
	Redirect("".$url."/managements/acces_neg.php");
	exit();
	}	
	
if(isset($_POST['pseudo']) && isset($_POST['tuteur'])) {
	if(empty($_POST['pseudo']) && empty($_POST['tuteur'])) {
	} else {
	$pseudo = Secu($_POST['pseudo']);
	$date = Secu($_POST['date']);
	$poste = Secu($_POST['poste']);
	$tuteur = Secu($_POST['tuteur']);
	$sql = $bdd->query("SELECT id FROM users WHERE username = '".$pseudo."'");
	$row = $sql->rowCount();
	$assoc = $sql->fetch(PDO::FETCH_ASSOC);
	$tute = $bdd->query("SELECT id FROM users WHERE username = '".$tuteur."'");
	$assoc2 = $tute->fetch(PDO::FETCH_ASSOC);
		$search = $bdd->query("SELECT user_id FROM gabcms_test_staff WHERE user_id = '".$assoc['id']."' AND etat != '2'");
		$ok = $search->fetch();
				$correct = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '".$poste."'");
				$c = $correct->fetch();
	$date_debut = time();
	$date_calcul = $date * 86400; 
	$date_ban = $date_debut + $date_calcul;
	if($pseudo != "" && $poste != "" && $date != "" && $tuteur != "" && $ok['user_id'] != $assoc['id'] && $pseudo != $tuteur) {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a placé <b>'.$pseudo.'</b> en test pour son poste de <b>'.addslashes($c['nom_M']).'</b> (sous la tutelle de <b>'.$tuteur.'</b>)');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
        $insertn2 = $bdd->prepare("INSERT INTO gabcms_test_staff (user_id, poste, date_debut, date_fin, tuteur, par) VALUES (:id, :poste, :dateun, :datede, :tuteur, :par)");
            $insertn2->bindValue(':id', $assoc['id']);
            $insertn2->bindValue(':poste', $poste);
            $insertn2->bindValue(':dateun', FullDate('full'));
            $insertn2->bindValue(':datede', $date_ban);
            $insertn2->bindValue(':tuteur', $assoc2['id']);
            $insertn2->bindValue(':par', $user['username']);
        $insertn2->execute();
        $insertn3 = $bdd->prepare("INSERT INTO gabcms_management (user_id, message, auteur, date, look) VALUES (:userid, :message, :auteur, :date, :look)");
            $insertn3->bindValue(':userid', $assoc['id']);
            $insertn3->bindValue(':message', 'Bonjour,<br/><br/>Je viens de te placer en test pour ton poste de <b>'.addslashes($c['nom_M']).'</b>. Le verdict de ton test tombera dans minimum <b>'.$date.' jour(s)</b> !<br/><br/>Ton tuteur ('.$tuteur.'), prendra contacte avec toi pour te former. Bonne chance !');
            $insertn3->bindValue(':auteur', $user['username']);
            $insertn3->bindValue(':date', FullDate('full'));
            $insertn3->bindValue(':look', $user['look']);
        $insertn3->execute();
        $bdd->query("UPDATE users SET staff_test = '1' WHERE id = '".$assoc['id']."'");	
        $insertn4 = $bdd->prepare("INSERT INTO gabcms_management (user_id, message, auteur, date, look) VALUES (:userid, :message, :auteur, :date, :look)");
            $insertn4->bindValue(':userid', $assoc2['id']);
            $insertn4->bindValue(':message', 'Tu as été placé sous la tutelle de <b>'.$pseudo.'</b> pour son poste de <b>'.addslashes($c['nom_M']).'</b>. Ta mission est de le surveiller, le conseiller. Une fois sa période de test terminée, tu devras rendre ton avis sur ton tutoré, pour rendre ton avis dans <b>'.$date.' jour(s)</b> tu devras aller dans l\'administration, ensuite en haut de la page, tu auras un cadre bleu dans lequel il y aura un lien. Il te suffira de cliquer dessus.');
            $insertn4->bindValue(':auteur', $user['username']);
            $insertn4->bindValue(':date', FullDate('full'));
            $insertn4->bindValue(':look', $user['look']);
        $insertn4->execute();
	echo '<h4 class="alert_success">'.$pseudo.' a été placé en test pendant '.$date.' jour(s)</h4>';
	  } else if($ok['user_id'] == $assoc['id']) {
	  echo '<h4 class="alert_error">Personnel déjà en test dans un autre poste/rank</h4>';
	  } else if($pseudo == $tuteur) {
	  echo '<h4 class="alert_error">La personne envoyée en test ne peut pas être le tuteur.</h4>';
	  } else {
	  echo '<h4 class="alert_error">Merci de renseigner les champs vides</h4>';
	  }
  }
  }
?>
<link rel="stylesheet" href="css/contenu.css" type="text/css" media="screen" /><body></body>
<span id="titre">Envois un staff en test</span><br/>
Ajoutes un staff en test, afin qu'il fasse ses preuves.
 <br/>
 <br/> 
 <form method="post" action="?do=givebadge">
<td width='100' class='tbl'><b>Pseudo :</b><br/></td>
<td width='80%' class='tbl'><select name="pseudo" id="pays">
            <option value="">-- Choisir le staff --</option>
<?PHP
$sql_a = $bdd->query("SELECT * FROM users WHERE rank >= '4' ORDER BY rank DESC");
while($a = $sql_a->fetch()) {
?>
			<option value="<?PHP echo $a['username']; ?>"><?PHP echo $a['username']; ?></option>
<?PHP } ?>
	</select><br/></td><td width='100' class='tbl'><b>Poste :</b><br/></td>
<td width='80%' class='tbl'>
	<select name="poste" id="pays" size="10">
<?PHP
$sql_a = $bdd->query("SELECT * FROM gabcms_postes_categorie ORDER BY id ASC");
while($a = $sql_a->fetch()) {
?>
				<optgroup label="<?PHP echo $a['nom'] ?>">
<?PHP
$sql_b = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id_categorie = '".$a['id']."' ORDER BY id ASC");
while($b = $sql_b->fetch()) {
?>
			<option value="<?PHP echo $b['id'] ?>"><?PHP echo $b['nom_M'] ?></option>
<?PHP } ?>
				</optgroup>
<?PHP } ?>
</select>
</td><br/><td width='100' class='tbl'><b>Durée du test :</b><br/></td>
<td width='80%' class='tbl'><select name="date" id="lenght" class="select"><option value="1">1 jour</option><option value="2">2 jours</option><option value="3">3 jours</option><option value="4">4 jours</option><option value="5">5 jours</option><option value="6">6 jours</option><option value="7">1 semaine</option><option value="14">2 semaines</option></select>
<br/>
<td width='100' class='tbl'><b>Tuteur</b> (celui qui s'occupe du staff) <b>:</b><br/></td>
<td width='80%' class='tbl'><select name="tuteur" id="pays">
            <option value="">-- Choisir le tuteur --</option>
<?PHP
$sql_a = $bdd->query("SELECT * FROM users WHERE rank >= '4' ORDER BY rank DESC");
while($a = $sql_a->fetch()) {
?>
			<option value="<?PHP echo $a['username']; ?>"><?PHP echo $a['username']; ?></option>
<?PHP } ?>
	</select><br/><br/>
	<input type="submit" value="Envoyer en test" />

</form><hr/>
<span id="titre">Staffs actuellement en test</span><br/>
Voici les staffs actuellement en test<br/><br/> 
<?PHP
	$sql = $bdd->query("SELECT * FROM gabcms_test_staff WHERE date_fin > '".$nowtime."' AND etat = '0' ORDER BY date_fin ASC");
	if($sql->rowCount() == 0)
        {
            echo "<i>Aucun staff en test</i>";
        }
	if($sql->rowCount() >= 1)
        {
            echo '<table><tbody>
<tr class="haut">
<td class="haut">Pseudo</td>
<td class="haut">Poste</td>
<td class="haut">Date de début</td>
<td class="haut">Date de fin</td>
<td class="haut">Tuteur</td>
<td class="haut">Ouvert par</td>
</tr>';
	while($e = $sql->fetch()) {

			$date_but = date('d/m/Y H:i', $e['date_fin']);
				$sqlz = $bdd->query("SELECT username FROM users WHERE id = '".$e['user_id']."'");
				$rowz = $sqlz->rowCount();
				$assocz = $sqlz->fetch(PDO::FETCH_ASSOC);
				$sql2 = $bdd->query("SELECT username FROM users WHERE id = '".$e['tuteur']."'");
				$row2 = $sql2->rowCount();
				$assoc2 = $sql2->fetch(PDO::FETCH_ASSOC);
					$correct = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '".$e['poste']."'");
					$c = $correct->fetch();					
?>
<tr class="bas">
<td class="bas"><?PHP echo $assocz['username'] ?></td>
<td class="bas"><?PHP echo $c['nom_M'] ?></td>
<td class="bas"><?PHP echo $e['date_debut'] ?></td>
<td class="bas"><?PHP echo $date_but ?></td>
<td class="bas"><?PHP echo $assoc2['username'] ?></td>
<td class="bas"><?PHP echo $e['par'] ?></td>
</tr>
    <?PHP } ?>
</tbody>
</table>
<?PHP } ?>
<hr/>
<span id="titre">Historique</span><br/>
Voici l'historique des staffs ayant été en test<br/><br/>
<table>
    <tbody>
        <tr class="haut">
            <td class="haut">Pseudo</td>
            <td class="haut">Poste</td>
            <td class="haut">Date de début</td>
            <td class="haut">Date de fin</td>
            <td class="haut">Tuteur</td>
            <td class="haut">Ouvert par</td>
            <td class="haut">Etat</td>
            <td class="haut">Actions</td>
        </tr>
<?php
 $sql = $bdd->query("SELECT * FROM gabcms_test_staff WHERE date_fin <= '".$nowtime."' ORDER BY date_fin DESC");
 while($e = $sql->fetch()) {
$date_but = date('d/m/Y H:i', $e['date_fin']);
    $sqlz = $bdd->query("SELECT username FROM users WHERE id = '".$e['user_id']."'");
    $rowz = $sqlz->rowCount();
    $assocz = $sqlz->fetch(PDO::FETCH_ASSOC);
    $sql2 = $bdd->query("SELECT username FROM users WHERE id = '".$e['tuteur']."'");
    $row2 = $sql2->rowCount();
    $assoc2 = $sql2->fetch(PDO::FETCH_ASSOC);
if($e['etat'] == 0) { $etat_modif = "<span style=\"color:#0000FF;\"><b>Attente avis<br/>tuteur</b></span>"; }
if($e['etat'] == 1) { $etat_modif = "<span style=\"color:#0000FF;\"><b>Attente avis<br/>direction</b></span>"; }
if($e['etat'] == 2) { $etat_modif = "<span style=\"color:#008800;\"><b>Traitée</b></span>"; }
        $correct = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '".$e['poste']."'");
        $c = $correct->fetch();
?>
        <tr class="bas">
            <td class="bas"><?PHP echo $assocz['username'] ?></td>
            <td class="bas"><?PHP echo $c['nom_M'] ?></td>
            <td class="bas"><?PHP echo $e['date_debut'] ?></td>
            <td class="bas"><?PHP echo $date_but ?></td>
            <td class="bas"><?PHP echo $assoc2['username'] ?></td>
            <td class="bas"><?PHP echo $e['par'] ?></td>
            <td class="bas"><?PHP echo $etat_modif ?></td>
            <td class="bas"><a href="<?PHP echo $url ?>/managements/look_test?id=<?PHP echo $e['id'] ?>&page=add">Voir</a></td>
        </tr>
<?PHP } ?>
    </tbody>
</table>
</body>
</html>