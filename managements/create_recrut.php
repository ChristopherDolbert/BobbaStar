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
	if($user['rank'] < 8) {
	Redirect("".$url."/managements/acces_neg");
	exit();
	}
	if($user['rank'] > 8) {              
	Redirect("".$url."/managements/acces_neg");
	exit();
	}	
	
	if(isset($_POST['poste']) || isset($_POST['date']) || isset($_POST['comment'])) {
   $poste = Secu($_POST['poste']);
   $comment = Secu($_POST['comment']);
   $date = Secu($_POST['date']);

$jour = date('d');
$mois = date('m');
$an = date('Y'); 
$heure = 23; 
$minute = 59; 
$seconde = 59;
	$date_debut = mktime($heure, $minute, $seconde, $mois, $jour, $an);
	$date_calcul = $date * 86400; 
	$date_ban = $date_debut + $date_calcul;
			$correct = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '".$poste."'");
			$c = $correct->fetch();
      if($poste != "") {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a ouvert une session de recrutement <b>('.addslashes($c['nom_M']).')</b>');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
        $insertn2 = $bdd->prepare("INSERT INTO gabcms_recrutement (poste, date, date_butoire, comment, ouvertpar) VALUES (:poste, :date, :datede, :com, :par)");
            $insertn2->bindValue(':poste', $poste);
            $insertn2->bindValue(':date', FullDate('full'));
            $insertn2->bindValue(':datede', $date_ban);
            $insertn2->bindValue(':com', $comment);
            $insertn2->bindValue(':par', $user['username']);
        $insertn2->execute();
        $bdd->query("INSERT INTO gabcms_tchat (pseudo,message,ip,date,look,rank) VALUES ('','La direction de l\'hôtel vient d\'ouvrir un poste, qui est le poste de <b>".addslashes($c['nom_M'])."</b> ! Pour y postuler, <a href=\"".$url."/recrutement\">cliquez ici</a>. Bonne chance à tous, et soyez rapide ! Car la session reste ouverte que <b>".$date." jour(s)</b> !','0.0.0.0','".FullDate('full')."','hr-828-45.lg-285-64.ch-215-110.hd-180-2.sh-290-62.he-1607-','0')");
	  echo '<h4 class="alert_success">La session de recrutement est ouverte.</h4>';
	  } else {
	  echo '<h4 class="alert_error">Merci de remplir les champs vides.</h4>';
	  }
  } 
?><link rel="stylesheet" href="css/contenu.css" type="text/css" media="screen" /><body>
<span id="titre">Ouvres une session</span><br/>
Ouvres une session de recrutement, afin de voir les candidatures pour le poste en question.
 <br/><br/>
 <script type="text/javascript" src="editeur_html/jscripts/tiny_mce/tiny_mce.js"></script>
 
 <form name='editor' method='post' action="?do=recrute">
<td width='100' class='tbl'><b>Poste à pourvoir :</b><br/></td>
<td width='80%' class='tbl'>
	<select name="poste" id="pays" size="15">
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
</td>
<br/><td width='100' class='tbl'><b>Date butoire :</b><br/></td>
<td width='80%' class='tbl'><select name="date" id="lenght" class="select"><option value="1">1 jour après</option><option value="2">2 jours après</option><option value="3">3 jours après</option><option value="5">5 jours après</option><option value="7">1 semaine après</option><option value="14">2 semaines après</option></select>
<br/>
<td width='100' class='tbl'><b>Commentaires :</b><br/></td>
<td width='80%' class='tbl'><textarea name='comment' wrap=discuss rows=3 cols=34 placeholder='Par exemple : 2 candidatures a acceptées, nombre de candidature minimale : 10, rank 7, poste de co-fondateur.'></textarea><br/></td>
<br/>
<tr><td align='center' colspan='2' class='tbl'>
<input type='submit' name='submit' value='Ex&eacute;cuter' class='submit'></form>
</tr>
<br/>
</body>
</html>