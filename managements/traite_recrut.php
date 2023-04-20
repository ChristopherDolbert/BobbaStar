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
	
if(isset($_GET['do'])) { $do = Secu($_GET['do']); }
?><link rel="stylesheet" href="css/contenu.css<?php echo '?'.mt_rand(); ?>" type="text/css" media="screen" /><body> 
<span id="titre">Choisis le poste vacant</span><br />
Cliques sur un poste vacant pour voir toutes les informations et candidatures...<br/><br/>
<table>
    <tbody>
        <tr class="haut">
            <td class="haut">Poste</td>
            <td class="haut">Date de publication</td>
            <td class="haut">Date butoire</td>
            <td class="haut">Nombre de candidatures<br/>à traitées</td>
            <td class="haut">Commentaires</td>
            <td class="haut">Action</td>
        </tr> 
<?php
$sql = $bdd->query("SELECT * FROM gabcms_recrutement WHERE date_butoire <= ".$nowtime." AND etat != 2 ORDER BY date_butoire ASC");
while($a = $sql->fetch()) {
    $date_but = date('d/m/Y', $a['date_butoire']);
    $req = "SELECT COUNT(*) AS id FROM gabcms_recrutement_dossier WHERE id_recrut = '".$a['id']."' AND retenu = '0'";
    $query = $bdd->query($req);
    $nb_inscrit = $query->fetch();
			$correct = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '".$a['poste']."'");
			$c = $correct->fetch();
    if($c['nom_M'] == "") {
	$modif = "<i>Poste supprimé</i>";
	} else {
	$modif = $c['nom_M'];
	}
?>
        <tr class="bas">
            <td class="bas"><?PHP echo $modif; ?></td>
            <td class="bas"><?PHP echo $a['date']; ?></td>
            <td class="bas"><?PHP echo $date_but; ?></td>
            <td class="bas"><?PHP echo $nb_inscrit['id']; ?></td>
            <td class="bas"><?PHP echo $a['comment']; ?></td>
            <td class="bas"><a href="<?PHP echo $url; ?>/managements/dossiers_recrutement?id=<?PHP echo $a['id']; ?>">Traiter la session</a></center></td>
        </tr>
<?PHP } ?>
    </tbody>
</table>
<br/>
<hr />Historique des postes vacant :<br/><br/>
<table>
    <tbody>
        <tr class="haut">
            <td class="haut">Poste</td>
            <td class="haut">Date de publication</td>
            <td class="haut">Date butoire</td>
            <td class="haut">Nombres de candidatures</td>
            <td class="haut">Action</td>
        </tr> 
<?php
$sql = $bdd->query("SELECT * FROM gabcms_recrutement WHERE date_butoire <= ".$nowtime." AND etat = '2' ORDER BY date_butoire DESC LIMIT 0,100");
while($a = $sql->fetch()) {
    $date_but = date('d/m/Y', $a['date_butoire']);
    $req = "SELECT COUNT(*) AS id FROM gabcms_recrutement_dossier WHERE id_recrut = '".$a['id']."'";
    $query = $bdd->query($req);
    $nb_inscrit = $query->fetch();
			$correct = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '".$a['poste']."'");
			$c = $correct->fetch();
    if($c['nom_M'] == "") {
	$modif = "<i>Poste supprimé</i>";
	} else {
	$modif = $c['nom_M'];
	}
?>
        <tr class="bas">
            <td class="bas"><?PHP echo $modif; ?></td>
            <td class="bas"><?PHP echo $a['date']; ?></td>
            <td class="bas"><?PHP echo $date_but; ?></td>
            <td class="bas"><?PHP echo $nb_inscrit['id']; ?></td>
            <td class="bas"><a href="<?PHP echo $url; ?>/managements/look_recrut?id=<?PHP echo $a['id']; ?>">Regarder</a></center></td>
        </tr>
<?PHP } ?>
    </tbody>
</table>
</body>
</html>