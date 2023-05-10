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

if (isset($_GET['do'])) {
    $do = Secu($_GET['do']);
}
?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />

<body>
    <span id="titre">Choisis le poste vacant</span><br />
    Cliques sur un poste vacant pour voir toutes les informations et candidatures...<br /><br />
    <table>
        <tbody>
            <tr class="haut">
                <td class="haut">Poste</td>
                <td class="haut">Date de publication</td>
                <td class="haut">Date butoire</td>
                <td class="haut">Nombre de candidatures<br />à traitées</td>
                <td class="haut">Commentaires</td>
                <td class="haut">Action</td>
            </tr>
            <?php
            $sql = $bdd->query("SELECT r.*, p.nom_M FROM gabcms_recrutement r LEFT JOIN gabcms_postes_noms p ON r.poste = p.id WHERE r.date_butoire <= $nowtime AND r.etat != 2 ORDER BY r.date_butoire ASC");

            while ($a = $sql->fetch()) {
                $date_but = date('d/m/Y', $a['date_butoire']);
                $nb_inscrit = $bdd->query("SELECT COUNT(*) AS id FROM gabcms_recrutement_dossier WHERE id_recrut = '{$a['id']}' AND retenu = '0'")->fetch();
                $modif = $a['nom_M'] ?: "<i>Poste supprimé</i>";
            ?>
                <tr class="bas">
                    <td class="bas"><?= $modif ?></td>
                    <td class="bas"><?= $a['date'] ?></td>
                    <td class="bas"><?= $date_but ?></td>
                    <td class="bas"><?= $nb_inscrit['id'] ?></td>
                    <td class="bas"><?= $a['comment'] ?></td>
                    <td class="bas"><a href="<?= $url ?>/managements/dossiers_recrutement?id=<?= $a['id'] ?>">Traiter la session</a></td>
                </tr>
            <?php } ?>

        </tbody>
    </table>
    <br />
    <hr />Historique des postes vacant :<br /><br />
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
            $sql = $bdd->query("SELECT r.*, p.nom_M FROM gabcms_recrutement r LEFT JOIN gabcms_postes_noms p ON r.poste = p.id WHERE r.date_butoire <= $nowtime AND r.etat = '2' ORDER BY r.date_butoire DESC LIMIT 0,100");
            while ($a = $sql->fetch()) {
                $date_but = date('d/m/Y', $a['date_butoire']);
                $nb_inscrit = $bdd->query("SELECT COUNT(*) AS id FROM gabcms_recrutement_dossier WHERE id_recrut = '{$a['id']}'")->fetch()['id'];
                $modif = $a['nom_M'] ?: "<i>Poste supprimé</i>";
            ?>
                <tr class="bas">
                    <td class="bas"><?= $modif ?></td>
                    <td class="bas"><?= $a['date'] ?></td>
                    <td class="bas"><?= $date_but ?></td>
                    <td class="bas"><?= $nb_inscrit ?></td>
                    <td class="bas"><a href="<?= $url ?>/managements/look_recrut?id=<?= $a['id'] ?>">Regarder</a></td>
                </tr>
            <?php } ?>

        </tbody>
    </table>
</body>

</html>