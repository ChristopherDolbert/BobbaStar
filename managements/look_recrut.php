<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");

if (!isset($_SESSION['username']) || $user['rank'] < 10 || $user['rank'] > 11) {
    Redirect("" . $url . "/managements/access_neg");
    exit();
}

if (isset($_GET['id'])) {
    $id = Secu($_GET['id']);

    $info = $bdd->query("SELECT * FROM gabcms_recrutement_dossier WHERE id = '$id'");
    $i = $info->fetch();

    $poste = $bdd->query("SELECT nom FROM gabcms_postes_noms WHERE id = (SELECT poste FROM gabcms_recrutement WHERE id = '$id')");
    $poste_nom = $poste->fetchColumn();

    $date_but = date('d/m/Y', $bdd->query("SELECT date_butoire FROM gabcms_recrutement WHERE id = '$id'")->fetchColumn());
}

?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />

<body>
    <span id="titre">Regardes une vacance de poste</span><br />
    Regardes les lettres de motivation de postes vacant traités.<br /><br />
    <SCRIPT LANGUAGE="JavaScript">
        function newPopup(url, name_page) {
            window.open(url, name_page, config = 'height=500, width=700, toolbar=no, menubar=no, scrollbars=yes, resizable=no, location=no, directories=no, status=no');
        }
    </SCRIPT>
    Voici les informations sur ce poste :<br /><br />
    Poste à pourvoir : <b><?PHP echo $c['nom_M']; ?></b><br />
    Date de publication : <b><?PHP echo $r['date']; ?></b><br />
    Date butoire : <b><?PHP echo $date_but; ?></b><br />
    Nombre de postulant : <b><?php $req = "SELECT COUNT(*) AS id FROM gabcms_recrutement_dossier WHERE id_recrut = '" . $id . "'";
                                $query = $bdd->query($req);
                                $nb_inscrit = $query->fetch();
                                echo $nb_inscrit['id'];
                                ?></b><br />
    Commentaires : <b><?PHP echo $r['comment'] ?></b><br />
    Candidature(s) acceptée(s) :
    <?php
    $recrut = $bdd->query("SELECT * FROM gabcms_recrutement_dossier WHERE id_recrut = '" . $id . "' AND retenu = '2'");
    while ($rt = $recrut->fetch()) {
    ?>
        <span style="color:#008000;"><?PHP echo $rt['pseudo']; ?></span> - <?PHP } ?><br /><br />
    <table>
        <tbody>
            <tr class="haut">
                <td class="haut">Pseudo</td>
                <td class="haut">Date</td>
                <td class="haut">Age</td>
                <td class="haut">CV</td>
                <td class="haut">Retenu</td>
                <td class="haut">Traité par</td>
                <td class="haut">Action</td>
            </tr>
            <?php
            $sql = $bdd->query("SELECT * FROM gabcms_recrutement_dossier WHERE id_recrut = '" . $id . "' && retenu != '0' ORDER BY id DESC");

            while ($a = $sql->fetch()) {
                $modif_traite = ($a['retenu'] == 2) ? "<span style=\"color:#008000;\">Accepté</span>" : "<span style=\"color:#FF0000;\">Refusé</span>";
            ?>
                <tr class="bas">
                    <td class="bas"><?PHP echo $a['pseudo'] ?></td>
                    <td class="bas"><?PHP echo $a['date'] ?></td>
                    <td class="bas"><?PHP echo $a['age'] ?></td>
                    <td class="bas">
                        <div style="margin-top:5px">
                            <div class="quotetitle"><b>CV DE <?PHP echo $a['pseudo'] ?> :</b> <input type="button" value="Afficher" style="width:50px;font-size:10px;margin:0px;padding:0px;" onclick="if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = '';        this.innerText = ''; this.value = 'Cacher'; } else { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; this.innerText = ''; this.value = 'Afficher'; }" /></div>
                            <div class="quotecontent">
                                <div style="display: none;"><?PHP echo $a['cv'] ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="bas"><?PHP echo $modif_traite ?></td>
                    <td class="bas"><?PHP echo $a['traite_par'] ?></td>
                    <td class="bas"><a href="#" onclick="newPopup('<?PHP echo $url ?>/managements/aff_histo_recrut?pseudo=<?PHP echo $a['pseudo'] ?>', 'Historique des candidatures');return false;">Historique</a></td>
                </tr>
            <?php } ?>

        </tbody>
    </table>
</body>

</html>