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
	Redirect("".$url."/managements/acces_neg");
	exit();
	}
	if($user['rank'] > 8) {              
	Redirect("".$url."/managements/acces_neg");
	exit();
	}	
	
	$id = Secu($_GET['id']);
?>
<title>Historique stafflog - Demande #<?PHP echo $id; ?></title>
<link rel="stylesheet" href="css/contenu.css<?php echo '?'.mt_rand(); ?>" type="text/css" media="screen" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8" /><body>
<span id="titre">Historique stafflog</span><br />
Ici est affiché l'historique des avis d'une demande<br/><br/>
<?php
 $sql = $bdd->query("SELECT * FROM gabcms_stafflog_delete WHERE id = '".$id."'");
 $a = $sql->fetch();

						$sql1 = $bdd->query("SELECT username FROM users WHERE id = '".$a['staff1']."'");
						$row1 = $sql1->rowCount();
						$assoc1 = $sql1->fetch(PDO::FETCH_ASSOC);
						$sql2 = $bdd->query("SELECT username FROM users WHERE id = '".$a['staff2']."'");
						$row2 = $sql2->rowCount();
						$assoc2 = $sql2->fetch(PDO::FETCH_ASSOC);
						$date = date('d/m/Y H:i', $a['date']);
if($a['etat'] == 1) { $etat_modif = "<span style=\"color:#0000FF;\"><b>Attente avis 2ème fondateur</b></span>"; }
if($a['etat'] == 2) { $etat_modif = "<span style=\"color:#008800;\"><b>Demande acceptée</b></span>"; }
if($a['etat'] == 3) { $etat_modif = "<span style=\"color:#FF0000;\"><b>Demande refusée</b></span>"; }
if($a['avis'] == 0) { $avis_modif = "<span style=\"color:#0000FF;\"><b>En attente</span>"; }
if($a['avis'] == 1) { $avis_modif = "<span style=\"color:#008800;\"><b>Accepté</span>"; }
if($a['avis'] == 2) { $avis_modif = "<span style=\"color:#FF0000;\"><b>Refusé</b></span>"; }
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
			<td rowspan="2" style="background-color: #C0C0C0; border-color: rgb(0, 0, 0); text-align: left; vertical-align: top; width: 300px; height: 140px;"><div style="overflow-y:auto; max-height:100px; font-size:11px;"><?PHP echo nl2br(stripslashes($a['avisstaff1'])); ?></div></td>
			<td rowspan="2" style="background-color: #C0C0C0; border-color: rgb(0, 0, 0); text-align: left; vertical-align: top; width: 300px; height: 140px;"><div style="overflow-y:auto; max-height:100px; font-size:11px;"><?PHP echo nl2br(stripslashes($a['avisstaff2'])); ?></div></td>
		</tr>
	</tbody>
</table>
</body>
</html>