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
	if($user['rank'] < 4) {
	Redirect("".$url."/managements/acces_neg");
	exit();
	}
	if($user['rank'] > 8) {              
	Redirect("".$url."/managements/acces_neg");
	exit();
	}	

if(isset($_GET['id'])) {
    
$id = Secu($_GET['id']);
$sql_modif = $bdd->query("SELECT * FROM gabcms_test_staff WHERE id = '".$id."'");
$modif_a = $sql_modif->fetch();
$sql_modifa = $bdd->query("SELECT * FROM users WHERE id = '".$modif_a['user_id']."'");
$modif_e = $sql_modifa->fetch();
$sql_modifz = $bdd->query("SELECT * FROM gabcms_test_commentaires WHERE id_test = '".$id."'");
$modif_z = $sql_modifz->fetch();
			$date_but = date('d/m/Y H:i', $modif_a['date_fin']);
				$sql = $bdd->query("SELECT * FROM users WHERE id = '".$modif_a['user_id']."'");
				$assoc = $sql->fetch(PDO::FETCH_ASSOC);
				$sql2 = $bdd->query("SELECT username FROM users WHERE id = '".$modif_a['tuteur']."'");
				$assoc2 = $sql2->fetch(PDO::FETCH_ASSOC);
if($modif_z['avistuteur'] == 1) {
$etat1 = "<span style=\"color:#008000\"><b>Favorable</b></span>";
}
if($modif_z['avistuteur'] == 2) {
$etat1 = "<span style=\"color:#FF0000\"><b>Défavorable</b></span>";
}	
if($modif_z['avistuteur'] == 0) {
$etat1 = "<span style=\"color:#0000FF\"><b>en attente</b></span>";
}
if($modif_z['avisdir'] == 0) {
$etat2 = "<span style=\"color:#0000FF\"><b>en attente</b></span>";
}	
if($modif_z['avisdir'] == 1) {
$etat2 = "<span style=\"color:#008000\"><b>Favorable</b></span>";
}
if($modif_z['avisdir'] == 2) {
$etat2 = "<span style=\"color:#FF0000\"><b>Défavorable</b></span>";
}	
if($modif_z['avistuteur'] == 0) {
$etat3 = "";
}
if($modif_z['avisdir'] == 0) {
$etat4 = "";
}	

if($modif_z['avistuteur'] == 1) {
$etat3 = "&nbsp;(".stripslashes(addslashes($modif_z['avistuteur_pseudo'])).")";
}
if($modif_z['avistuteur'] == 2) {
$etat3 = "&nbsp;(".stripslashes(addslashes($modif_z['avistuteur_pseudo'])).")";
}	
if($modif_z['avisdir'] == 1) {
$etat4 = "&nbsp;(".stripslashes(addslashes($modif_z['avisdir_pseudo'])).")";
}
if($modif_z['avisdir'] == 2) {
$etat4 = "&nbsp;(".stripslashes(addslashes($modif_z['avisdir_pseudo'])).")";
}	
					$correct = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '".$modif_a['poste']."'");
					$c = $correct->fetch();
?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?'.mt_rand(); ?>" type="text/css" media="screen" /><body>
<span id="titre">Regardes les périodes de tests</span><br/>
Regardes les avis qu'il y a eu durant les périodes de tests.<br/><br/>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody>
		<tr>
			<td style="background-color: rgb(204, 51, 0); border-color: rgb(0, 0, 0); vertical-align: middle; text-align: center; width:30%;"><span style="font-size:12px"><span style="color:rgb(255, 255, 255)"><em><strong>Informations staff en test</strong></em></span></span></td>
			<td style="background-color: rgb(204, 51, 0); border-color: rgb(0, 0, 0); text-align: left; vertical-align: middle; width:35%;"><span style="font-size:12px"><span style="color:rgb(255, 255, 255)">Pseudo du tuteur : <b><?PHP echo $assoc2['username'] ?></b></span></span></td>
			<td style="background-color: rgb(204, 51, 0); border-color: rgb(0, 0, 0); text-align: left; vertical-align: middle; width:35%;"><span style="font-size:12px"><span style="color:rgb(255, 255, 255)">Derni&egrave;re connexion du staff en test : <b><?PHP $connexion = date('d/m/Y H:i:s', $modif_e['last_online']);
echo $connexion ;?></b></span></span></td>
		</tr>
		<tr>
			<td rowspan="3" style="background-color: rgb(255, 204, 51); border-color: rgb(0, 0, 0); text-align: left; max-height:140px;">
<span style="font-size:12px">Pseudo : <b><?PHP echo $assoc['username'] ?></b></span><br/>
<span style="font-size:12px">Date d&#39;inscription : <b><?PHP echo $assoc['account_created'] ?></b></span><br/>
<span style="font-size:12px; text-align: center;">__________________________</span><br/>
<span style="font-size:12px">Poste : <b><?PHP echo $c['nom_M'] ?></b></span><br/>
<span style="font-size:12px">En test depuis le <b><?PHP echo $modif_a['date_debut'] ?></b></span><br/>
<span style="font-size:12px">En attente d&#39;avis depuis le <b><?PHP echo $date_but ?></b></span>
			</td>
			<td style="background-color: #D1D1D1; border-color:rgb(0, 0, 0); text-align:left; vertical-align:top;"><span style="font-size:12px">Avis du tuteur<?PHP echo $etat3 ?> : <?PHP echo $etat1 ?></span></td>
			<td style="background-color: #D1D1D1; border-color:rgb(0, 0, 0); text-align:left; vertical-align:top;"><span style="font-size:12px">Avis de la direction<?PHP echo $etat4 ?> : <?PHP echo $etat2 ?></span></td>
		</tr>
		<tr>
			<td rowspan="2" style="background-color: #C0C0C0; border-color: rgb(0, 0, 0); text-align: left; vertical-align: top;"><span style="font-size:12px"><div style="overflow-y:auto; max-height:100px;"><?PHP echo nl2br(stripslashes($modif_z['avistuteur_commentaire'])); ?></div></span></td>
			<td rowspan="2" style="background-color: #C0C0C0; border-color: rgb(0, 0, 0); text-align: left; vertical-align: top;"><span style="font-size:12px"><div style="overflow-y:auto; max-height:100px;"><?PHP echo nl2br(stripslashes($modif_z['avisdir_commentaire'])); ?></div></span></td>
		</tr>
	</tbody>
</table><br/><br/>
<?PHP 
$modif_page = '';
    if(isset($_GET['page'])) {
        $page = Secu($_GET['page']);
        if($page == 'tuteur') { $modif_page = 'avis_test_tuteur'; }
        if($page == 'dir') { $modif_page = 'avis_test_dir'; }
        if($page == 'add') { $modif_page = 'add_test'; }
    }
?>
<a href="<?PHP echo $url ?>/managements/<?PHP echo $modif_page; ?>">Revenir aux choix de tests</a>
<?PHP } else { ?>
Erreur dans l'encodage
<?PHP } ?>