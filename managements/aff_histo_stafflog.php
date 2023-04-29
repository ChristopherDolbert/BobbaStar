<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");

if (!isset($_SESSION['username']) || $user['rank'] > 11) {
	Redirect("" . $url . "/managements/access_neg");
	exit();
}

$id = Secu($_GET['id']);
?>
<title>Historique stafflog - Demande #<?PHP echo $id; ?></title>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

<body>
	<span id="titre">Historique stafflog</span><br />
	Ici est affiché l'historique des avis d'une demande<br /><br />
	<?php
	$a = $bdd->query("SELECT * FROM gabcms_stafflog_delete WHERE id = '{$id}'")->fetch();

	$assoc1 = $bdd->query("SELECT username FROM users WHERE id = '{$a['staff1']}'")->fetch(PDO::FETCH_ASSOC);
	$assoc2 = $bdd->query("SELECT username FROM users WHERE id = '{$a['staff2']}'")->fetch(PDO::FETCH_ASSOC);

	$date = date('d/m/Y H:i', $a['date']);

	$etat_modif = match ($a['etat']) {
		1 => "<span style=\"color:#0000FF;\"><b>Attente avis 2ème fondateur</b></span>",
		2 => "<span style=\"color:#008800;\"><b>Demande acceptée</b></span>",
		3 => "<span style=\"color:#FF0000;\"><b>Demande refusée</b></span>",
		default => ""
	};

	$avis_modif = match ($a['avis']) {
		0 => "<span style=\"color:#0000FF;\"><b>En attente</span>",
		1 => "<span style=\"color:#008800;\"><b>Accepté</span>",
		2 => "<span style=\"color:#FF0000;\"><b>Refusé</b></span>",
		default => ""
	};
	?>


	<table border="0" cellpadding="0" style="border-color:rgb(0, 0, 0); border-style: solid;" cellspacing="0" width="100%">
		<tbody>
			<tr>
				<td style="background-color: rgb(204, 51, 0); border-color: rgb(0, 0, 0); text-align: left; vertical-align: middle; width:50%;"><span style="font-size:12px"><span style="color:rgb(255, 255, 255)">Date de demande : <b><?PHP echo $date; ?></b></span></span></td>
				<td style="background-color: rgb(204, 51, 0); border-color: rgb(0, 0, 0); text-align: left; vertical-align: middle; width:50%;"><span style="font-size:12px"><span style="color:rgb(255, 255, 255)">Etat de la demande : <b><?PHP echo $etat_modif; ?></b></span></span></td>
			</tr>
			<tr>
				<td style="background-color: #D1D1D1; border-color:rgb(0, 0, 0); height:20px; text-align:left; vertical-align:top"><span style="font-size:12px">Demande de : <?PHP echo $assoc1['username']; ?></span></td>
				<td style="background-color: #D1D1D1; border-color:rgb(0, 0, 0); text-align:left; vertical-align:top"><span style="font-size:12px">Avis du 2ème staff (<?PHP echo $assoc2['username']; ?>) : <?PHP echo $avis_modif; ?></span></td>
			</tr>
			<tr>
				<td rowspan="2" style="background-color: #C0C0C0; border-color: rgb(0, 0, 0); text-align: left; vertical-align: top; width: 300px; height: 140px;">
					<div style="overflow-y:auto; max-height:100px; font-size:11px;"><?PHP echo nl2br(stripslashes($a['avisstaff1'])); ?></div>
				</td>
				<td rowspan="2" style="background-color: #C0C0C0; border-color: rgb(0, 0, 0); text-align: left; vertical-align: top; width: 300px; height: 140px;">
					<div style="overflow-y:auto; max-height:100px; font-size:11px;"><?PHP echo nl2br(stripslashes($a['avisstaff2'])); ?></div>
				</td>
			</tr>
		</tbody>
	</table>
</body>

</html>