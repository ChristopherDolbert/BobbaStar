<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");

if (!isset($_SESSION['username']) || $user['rank'] < 8 || $user['rank'] > 11) {
	Redirect("" . $url . "/managements/access_neg");
	exit();
}

if (isset($_POST['raison'], $_POST['dateDebutAbsence'], $_POST['dateFinAbsence'])) {
	$raison = Secu($_POST['raison']);
	$dateDebutAbsence = Secu($_POST['dateDebutAbsence']);
	$dateFinAbsence = Secu($_POST['dateFinAbsence']);

	$date_expl = explode("/", $dateDebutAbsence);
	$timestamp = mktime(00, 00, 01, $date_expl[1], $date_expl[0], $date_expl[2]);

	$date_explz = explode("/", $dateFinAbsence);
	$timestampz = mktime(23, 59, 59, $date_explz[1], $date_explz[0], $date_explz[2]);

	if (!empty($raison) && !empty($dateDebutAbsence) && !empty($dateFinAbsence)) {
		$insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
		$insertn1->execute([
			':pseudo' => $user['username'],
			':action' => 'sera absent du <b>' . $dateDebutAbsence . '</b> au <b>' . $dateFinAbsence . '</b>',
			':date' => FullDate('full')
		]);

		$insertn2 = $bdd->prepare("INSERT INTO gabcms_absence_staff (pseudo,depuis,jusqua,raison,ip) VALUES (:pseudo, :depuis, :jus, :raison, :ip)");
		$insertn2->execute([
			':pseudo' => $user['username'],
			':depuis' => $timestamp,
			':jus' => $timestampz,
			':raison' => $raison,
			':ip' => $user['ip_current']
		]);

		echo '<h4 class="alert_success">Ton absence a été signalé aux administrateurs.</h4>';
	} else {
		echo '<h4 class="alert_error">Merci de remplir les champs vide</h4>';
	}
}

?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />

<body>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
	<script src="//code.jquery.com/jquery-1.9.1.js" type="text/javascript"></script>
	<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js" type="text/javascript"></script>
	<script>
		$(function() {
			$("#dateDebutAbsence").datepicker({
				monthNamesShort: ["Jan", "Fev", "Mars", "Avr", "Mai", "Juin", "Juil", "Août", "Sep", "Octo", "Nov", "Dec"],
				dayNamesMin: ["Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa"],
				changeMonth: true,
				changeYear: true,
				dateFormat: 'dd/mm/yy',
				minDate: '+0j',
				maxDate: '+1w'
			});
		});
		$(function() {
			$("#dateFinAbsence").datepicker({
				monthNamesShort: ["Jan", "Fev", "Mars", "Avr", "Mai", "Juin", "Juil", "Août", "Sep", "Octo", "Nov", "Dec"],
				dayNamesMin: ["Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa"],
				changeMonth: true,
				changeYear: true,
				dateFormat: 'dd/mm/yy',
				minDate: '+1j',
				maxDate: '+2m'
			});
		});
	</script>
	<span id="titre">Signales ton absence</span><br />
	Ici signales ton absence aux autres staffs
	<br />
	<br />
	<form name='editor' method='post' action="?do=abs">
		<b>Raison:</b><br />
		<td width='80%' class='tbl'><textarea name='raison' wrap=discuss rows=3 cols=34></textarea><br /></td><br />
		Date de départ : <input type="text" id="dateDebutAbsence" readonly="readonly" name="dateDebutAbsence" maxlength="10" size="10" /><br />
		Date de retour : <input type="text" id="dateFinAbsence" readonly="readonly" name="dateFinAbsence" maxlength="10" size="10" /><br />
		<input type='submit' name='submit' value='Exécuter'>
	</form>
	<br />
</body>

</html>