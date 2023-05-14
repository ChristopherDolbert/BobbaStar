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

$pseudo = Secu($_GET['pseudo']);

$info = $bdd->prepare("SELECT * FROM gabcms_recrutement_dossier WHERE id_recrut = ?");
$info->execute([$pseudo]);
$i = $info->fetch();
?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

<body>
    <span id="titre">Historique des candidatures</span><br />
    <title>Historique des candidatures de <?PHP echo $pseudo ?></title>
    L'historique des candidatures d'une personne<br /><br />
    <table>
        <tbody>
            <tr class="haut">
                <td class="haut">Poste</td>
                <td class="haut">Pseudo</td>
                <td class="haut">Date</td>
                <td class="haut">Age</td>
                <td class="haut">CV</td>
                <td class="haut">Retenu</td>
                <td class="haut">Traité par</td>
            </tr>
            
            <?php
            $sql = $bdd->prepare("SELECT * FROM gabcms_recrutement_dossier WHERE pseudo = ? ORDER BY id DESC");
            $sql->execute([$pseudo]);
            while ($a = $sql->fetch()) {
                $dossiers = $bdd->prepare("SELECT * FROM gabcms_recrutement WHERE id = ?");
                $dossiers->execute([$a['id_recrut']]);
                $e = $dossiers->fetch();
                $correct = $bdd->prepare("SELECT nom_M FROM gabcms_postes_noms WHERE id = ?");
                $correct->execute([$e['poste']]);
                $modif = ($e['poste'] == "") ? "<i>Session supprimée</i>" : ($correct->rowCount() == 0 ? "<i>Poste supprimé</i>" : $correct->fetch()['nom_M']);
                $modif_traite = ($a['retenu'] == 2) ? "<span style=\"color:#008000;\">Accepté</span>" : (($a['retenu'] == 1) ? "<span style=\"color:#FF0000;\">Refusé</span>" : "<span style=\"color:#0000FF;\">En attente</span>");
            ?>
                <tr class="bas">
                    <td class="bas"><?PHP echo $modif ?></td>
                    <td class="bas"><?PHP echo $a['pseudo'] ?></td>
                    <td class="bas"><?PHP echo $a['date'] ?></td>
                    <td class="bas"><?PHP echo $a['age'] ?></td>
                    <td style="padding:5px; text-align: left; vertical-align: middle;font-size:11px;">
                        <div class="quotetitle"><b>CV DE <?PHP echo $a['pseudo'] ?> :</b> <input type="button" value="Afficher" style="width:50px;font-size:10px;margin:0px;padding:0px;" onclick="if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = ''; this.innerText = ''; this.value = 'Cacher'; } else { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; this.innerText = ''; this.value = 'Afficher'; }" /></div>
                        <div class="quotecontent">
                            <div style="display: none;"><?PHP echo $a['cv'] ?></div>
                        </div>
                    </td>
                    <td class="bas"><?PHP echo $modif_traite ?></td>
                    <td class="bas"><?PHP echo $a['traite_par'] ?></td>
                </tr>
            <?PHP } ?>

        </tbody>
    </table>
</body>

</html>