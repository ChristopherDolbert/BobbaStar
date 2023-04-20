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
	
	if($user['rank'] < 8) {
	Redirect("".$url."/managements/acces_interdit");
	exit();
	}
	if($user['rank'] > 8) {              
	Redirect("".$url."/managements/acces_interdit");
	exit();
	}

if(isset($_GET['do'])) {
$do = Secu($_GET['do']);
if(isset($_POST['etat_client']) && $do == 'act_client') {
$sql = $bdd->query("SELECT * FROM gabcms_config WHERE id = '1'");
$cof = $sql->fetch(PDO::FETCH_ASSOC);
	$etat_client = Secu($_POST['etat_client']);
if($etat_client == '1') { $modif_etat = '<span style="color:#008800;">Hôtel ouvert</span>'; } 
elseif($etat_client == '2') { $modif_etat = '<span style="color:#FF0000;">Hôtel fermé</span>'; } 
elseif($etat_client == '3') { $modif_etat = '<span style="color:#FF0000;">Hôtel fermé (durée déterminée)</span>'; }
	if($etat_client != $cof['etat_client']) {
		if($etat_client > '0' && $etat_client <= '3') {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a modifié <b>l\'état d\'accès au client</b> ('.$modif_etat.')');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
		$insertn2 = $bdd->prepare("UPDATE gabcms_config SET etat_client = :etat WHERE id = :id");
            $insertn2->bindValue(':etat', $etat_client);
            $insertn2->bindValue(':id', '1');
        $insertn2->execute();
	 echo '<h4 class="alert_success">Tes modifications ont bien eu lieu !</h4>';
	  } else {
	  echo '<h4 class="alert_error">Une erreur est surevenue.</h4>';
	  } } else {
	  echo '<h4 class="alert_error">Impossible de modifier l\'état d\'accès, car tu as choisi un état déjà actif.</h4>';
	  }
 }
}
if(isset($_GET['do'])) {
$do = Secu($_GET['do']);
if($do == 'modif_etat_client') {
$sql = $bdd->query("SELECT * FROM gabcms_config WHERE id = '1'");
$cof = $sql->fetch(PDO::FETCH_ASSOC);

	$dateDebutAbsence = Secu($_POST['jourd']);
	$dateFinAbsence = Secu($_POST['jourf']);
    $debuth = Secu($_POST['heuresd']);
    $debutm = Secu($_POST['minutesd']);
    $finh = Secu($_POST['heuresf']);
    $finm = Secu($_POST['minutesf']);
$date_expl=explode("/",$dateDebutAbsence);
$timestamp=mktime($debuth,$debutm,01,$date_expl[1],$date_expl[0],$date_expl[2]);

$date_explz=explode("/",$dateFinAbsence);
$timestampz=mktime($finh,$finm,00,$date_explz[1],$date_explz[0],$date_explz[2]);

if($cof['etat_client'] == '3') {
	if($dateDebutAbsence != "" && $dateFinAbsence != "") {
		if($debuth != "" && $debutm != "" && $finh != "" && $finm != "") {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a fermé l\'hôtel du <b>'.$dateDebutAbsence.' '.$debuth.'h'.$debutm.'</b> au <b>'.$dateFinAbsence.' '.$finh.'h'.$finm.'</b>');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
		$insertn2 = $bdd->prepare("UPDATE gabcms_config SET si3_debut = :debut, si3_fin = :fin WHERE id = :id");
            $insertn2->bindValue(':debut', $timestamp);
            $insertn2->bindValue(':fin', $timestampz);
            $insertn2->bindValue(':id', '1');
        $insertn2->execute();
	 echo '<h4 class="alert_success">L\'hôtel sera fermé du <b>'.$dateDebutAbsence.' '.$debuth.'h'.$debutm.'</b> au <b>'.$dateFinAbsence.' '.$finh.'h'.$finm.'</b></h4>';
	  } else {
	  echo '<h4 class="alert_error">Les heures renseignées ne sont pas bonnes.</h4>';
	  } } else {
	  echo '<h4 class="alert_error">Les dates renseignées ne sont pas bonnes ou non remplies.</h4>';
	  } } else {
	  echo '<h4 class="alert_error">L\'état actuel du client ne permet pas d\'effectuer cette action.</h4>';
	  }
 }
}
$sql = $bdd->query("SELECT * FROM gabcms_config WHERE id = '1'");
$cof = $sql->fetch(PDO::FETCH_ASSOC);
?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?'.mt_rand(); ?>" type="text/css" media="screen" /><body>
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<script src="//code.jquery.com/jquery-1.9.1.js" type="text/javascript" ></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js" type="text/javascript" ></script>
<script>
		$(function() {
			$("#dateDebutAbsence").datepicker({
				monthNamesShort: [ "Jan", "Fev", "Mars", "Avr", "Mai", "Juin", "Juil", "Août", "Sep", "Octo", "Nov", "Dec" ],
				dayNamesMin: [ "Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa" ],
				changeMonth: true,
				changeYear: true,
				dateFormat: 'dd/mm/yy',
				minDate: '+0j',
				maxDate: '+1w'
			});
		});
		$(function() {
			$("#dateFinAbsence").datepicker({
				monthNamesShort: [ "Jan", "Fev", "Mars", "Avr", "Mai", "Juin", "Juil", "Août", "Sep", "Octo", "Nov", "Dec" ],
				dayNamesMin: [ "Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa" ],
				changeMonth: true,
				changeYear: true,
				dateFormat: 'dd/mm/yy',
				minDate: '+0j',
				maxDate: '+1m'
			});
		});
</script>
<span id="titre">Actions sur l'accès au client</span><br/>
Ouvre ou ferme le client depuis cette page.<br/><br/> 
<form name='editor' method='post' action="?do=act_client">
<b>État du client :</b><br/>
<label><input type="radio" name="etat_client" value="1" <?PHP if($cof['etat_client'] == "1") { ?> checked="checked" <?PHP } ?> /><span style="color:#008800;">Hôtel en ligne</span></label><br/>
<label><input type="radio" name="etat_client" value="2" <?PHP if($cof['etat_client'] == "2") { ?> checked="checked" <?PHP } ?> /><span style="color:#FF0000;">Hôtel en hors ligne</span></label><br/>
<label><input type="radio" name="etat_client" value="3" <?PHP if($cof['etat_client'] == "3") { ?> checked="checked" <?PHP } ?> /><span style="color:#FF0000;">Hôtel en hors ligne, à durer à déterminer ci-dessous</span></label><br/>
<br/>
<input type='submit' name='submit' value='Modifier'></form><?PHP if($cof['etat_client'] == '3') { ?><hr/><span class="HEADLINE">Fermeture de l'hôtel contrôlée</span><br/>
Sur cette page, et seulement si le client est sous l'état "<span style="color:#FF0000;">Hôtel en hors ligne, à durer à déterminer ci-dessous</span>", rempli le formulaire ci-dessous :<br/><br/>
<form name='editor' method='post' action="?do=modif_etat_client">
<b>Date de début pour fermer l'hôtel :</b><br/> 
Jour/Mois/Année : <input type="text" id="dateDebutAbsence" readonly="readonly" name="jourd" maxlength="10" size="10" /><br/>
Heure & Minute :	<select name="heuresd" id="lenght" class="select">
		<option value="00">Minuit</option>
		<option value="01">01</option>
		<option value="02">02</option>
		<option value="03">03</option>
		<option value="04">04</option>
		<option value="05">05</option>
		<option value="06">06</option>
		<option value="07">07</option>
		<option value="08">08</option>
		<option value="09">09</option>
		<option value="10">10</option>
		<option value="11">11</option>
		<option value="12">12</option>
		<option value="13">13</option>
		<option value="14">14</option>
		<option value="15">15</option>
		<option value="16">16</option>
		<option value="17">17</option>
		<option value="18">18</option>
		<option value="19">19</option>
		<option value="20">20</option>
		<option value="21">21</option>
		<option value="22">22</option>
		<option value="23">23</option>
	</select>h<select name="minutesd" id="lenght" class="select">
		<option value="00">00</option>
		<option value="05">05</option>
		<option value="10">10</option>
		<option value="15">15</option>
		<option value="20">20</option>
		<option value="25">25</option>
		<option value="30">30</option>
		<option value="35">35</option>
		<option value="40">40</option>
		<option value="45">45</option>
		<option value="50">50</option>
		<option value="55">55</option>
	</select><br/><br/>
<b>Date de fin afin de réouvrir l'hôtel automatiquement :</b><br/> 
Jour/Mois/Année : <input type="text" id="dateFinAbsence" readonly="readonly" name="jourf" maxlength="10" size="10" /><br/>
Heure & Minute : <select name="heuresf" id="lenght" class="select">
		<option value="00">Minuit</option>
		<option value="01">01</option>
		<option value="02">02</option>
		<option value="03">03</option>
		<option value="04">04</option>
		<option value="05">05</option>
		<option value="06">06</option>
		<option value="07">07</option>
		<option value="08">08</option>
		<option value="09">09</option>
		<option value="10">10</option>
		<option value="11">11</option>
		<option value="12">12</option>
		<option value="13">13</option>
		<option value="14">14</option>
		<option value="15">15</option>
		<option value="16">16</option>
		<option value="17">17</option>
		<option value="18">18</option>
		<option value="19">19</option>
		<option value="20">20</option>
		<option value="21">21</option>
		<option value="22">22</option>
		<option value="23">23</option>
	</select>h<select name="minutesf" id="lenght" class="select">
		<option value="00">00</option>
		<option value="05">05</option>
		<option value="10">10</option>
		<option value="15">15</option>
		<option value="20">20</option>
		<option value="25">25</option>
		<option value="30">30</option>
		<option value="35">35</option>
		<option value="40">40</option>
		<option value="45">45</option>
		<option value="50">50</option>
		<option value="55">55</option>
	</select><br/><input type='submit' name='submit' value='Envoyer'></form><?PHP } ?>
</body>
</html>