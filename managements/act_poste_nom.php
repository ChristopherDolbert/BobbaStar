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

if (isset($_GET['modif'])) {
    $modif = Secu($_GET['modif']);
}
if (isset($_GET['deplace'])) {
    $deplace = Secu($_GET['deplace']);
}

if (isset($_GET['do'])) {
    $do = Secu($_GET['do']);
    if ($do == "create") {
        $nom_poste_M = addslashes($_POST['nom_poste_m']);
        $nom_poste_F = addslashes($_POST['nom_poste_f']);
        $nom_poste_NDS = addslashes($_POST['nom_poste_nds']);
        $categorie = addslashes($_POST['categorie']);
        if ($nom_poste_M != "" && $nom_poste_F != "" && $categorie != "") {
            $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a créé un poste <b>(' . $nom_poste_M . ')</b>');
            $insertn1->bindValue(':date', FullDate('full'));
            $insertn1->execute();
            $bdd->query("INSERT INTO gabcms_postes_noms (id_categorie, nom_M, nom_F, nom_nds, par, le) VALUES ('" . $categorie . "', '" . $nom_poste_M . "', '" . $nom_poste_F . "', '" . $nom_poste_NDS . "', '" . $user['username'] . "', '" . FullDate('full') . "')");
            echo '<h4 class="alert_success">Le poste a bien été enregistré</h4>';
        } else {
            echo '<h4 class="alert_error">Une erreur est survenue</h4>';
        }
    }
}
if (isset($_GET['sup'])) {
    $sup = Secu($_GET['sup']);
    $sql_moder = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '" . $sup . "'");
    $moder_e = $sql_moder->fetch();
    $deplacer = $bdd->query("SELECT * FROM gabcms_postes WHERE poste = '" . $sup . "'");
    while ($d = $deplacer->fetch()) {
        $srl = $bdd->query("SELECT * FROM users WHERE id = '" . $d['user_id'] . "'");
        $assoc = $srl->fetch(PDO::FETCH_ASSOC);
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
        $insertn1->bindValue(':pseudo', $user['username']);
        $insertn1->bindValue(':action', 's\'est vu destitué de son poste <b>(' . addslashes($moder_e['nom_M']) . ')</b> car ce poste est supprimé');
        $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute();
    }
    $insertn2 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
    $insertn2->bindValue(':pseudo', $user['username']);
    $insertn2->bindValue(':action', 'a supprimé le poste <b>' . addslashes($moder_e['nom_M']) . '</b>');
    $insertn2->bindValue(':date', FullDate('full'));
    $insertn2->execute();
    $bdd->query("DELETE FROM gabcms_postes_noms WHERE id = '" . $sup . "'");
    $bdd->query("DELETE FROM gabcms_postes WHERE poste = '" . $sup . "'");
    echo '<h4 class="alert_success">Le poste a bien été supprimée</h4>';
}
if (isset($_GET['modifierrecrut'])) {
    $modifierrecrut = Secu($_GET['modifierrecrut']);
    $nom_modif_M = addslashes($_POST['nom_modif_M']);
    $nom_modif_F = addslashes($_POST['nom_modif_F']);
    $nom_modif_NDS = addslashes($_POST['nom_modif_nds']);
    $sql_modif = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '" . $modifierrecrut . "'");
    $modif_a = $sql_modif->fetch();
    if ($nom_modif_M != "" && $nom_modif_F != "") {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
        $insertn1->bindValue(':pseudo', $user['username']);
        $insertn1->bindValue(':action', 'a modifié le poste <b>' . addslashes($modif_a['nom_M']) . '</b> en <b>' . $nom_modif_M . '</b>');
        $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute();
        $bdd->query("UPDATE gabcms_postes_noms SET nom_M = '" . $nom_modif_M . "', nom_F = '" . $nom_modif_F . "', nom_nds = '" . $nom_modif_NDS . "' WHERE id = '" . $modifierrecrut . "'");
        echo '<h4 class="alert_success">La modification a bien eu lieu</h4>';
    } else {
        echo '<h4 class="alert_error">Une erreur est survenue</h4>';
    }
}
if (isset($_GET['deplacement'])) {
    $deplacement = Secu($_GET['deplacement']);
    $new_categorie = $_POST['new_categorie'];
    $sql_deplace = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '" . $deplacement . "'");
    $deplace_a = $sql_deplace->fetch();
    $sql_deplacez = $bdd->query("SELECT * FROM gabcms_postes_categorie WHERE id = '" . $deplace_a['id_categorie'] . "'");
    $deplace_b = $sql_deplacez->fetch();
    $sql = $bdd->query("SELECT * FROM gabcms_postes_categorie WHERE id = '" . $new_categorie . "'");
    $assoc = $sql->fetch(PDO::FETCH_ASSOC);
    if ($new_categorie != "") {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
        $insertn1->bindValue(':pseudo', $user['username']);
        $insertn1->bindValue(':action', 'a déplacé le poste <b>' . addslashes($deplace_a['nom_M']) . '</b> de la catégorie <b>' . addslashes($deplace_b['nom']) . '</b> à <b>' . $assoc['nom'] . '</b>');
        $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute();
        $bdd->query("UPDATE gabcms_postes_noms SET id_categorie = '" . $new_categorie . "' WHERE id = '" . $deplacement . "'");
        echo '<h4 class="alert_success">La modification a bien eu lieu</h4>';
    } else {
        echo '<h4 class="alert_error">Une erreur est survenue</h4>';
    }
}
?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />

<body>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <?php if (!isset($_GET['modif']) && !isset($_GET['deplace'])) { ?>
        <span id="titre">Créer des postes</span><br />
        Ajoutes des postes pour les sessions de recrutement ou les attribuer à un staff.
        <br /><br />
        <form name='editor' method='post' action="?do=create">
            <td width='100' class='tbl'><b>Nom du poste au masculin :</b><br /></td>
            <td width='80%' class='tbl'><input type="text" name="nom_poste_m" value="<?php if (!empty($_POST["nom_poste_m"])) {
                                                                                            echo htmlspecialchars($_POST["nom_poste_m"], ENT_QUOTES);
                                                                                        } ?>" class="text" style="width: 360px" /><br /></td>
            <td width='100' class='tbl'><b>Nom du poste au féminin :</b><br /></td>
            <td width='80%' class='tbl'><input type="text" name="nom_poste_f" value="<?php if (!empty($_POST["nom_poste_f"])) {
                                                                                            echo htmlspecialchars($_POST["nom_poste_f"], ENT_QUOTES);
                                                                                        } ?>" class="text" style="width: 360px" /><br /></td>
            <td width='100' class='tbl'><b>Nom du poste dans les NDS :</b> (suffit de mettre un S à la fin)<br /></td>
            <td width='80%' class='tbl'><input type="text" name="nom_poste_nds" value="<?php if (!empty($_POST["nom_poste_nds"])) {
                                                                                            echo htmlspecialchars($_POST["nom_poste_nds"], ENT_QUOTES);
                                                                                        } ?>" class="text" style="width: 360px" /><br /></td>
            <td width='100' class='tbl'><b>Catégorie du poste :</b><br /></td>
            <select name="categorie" id="pays">
                <?PHP
                $sql_a = $bdd->query("SELECT * FROM gabcms_postes_categorie ORDER BY id ASC");
                while ($a = $sql_a->fetch()) {
                ?>
                    <option value="<?PHP echo $a['id'] ?>"><?PHP echo $a['nom'] ?></option>
                <?PHP } ?>
            </select><br /><br />
            <input type="submit" value="Ajouter" />
        </form><br />
        <hr />
        <span id="titre">Action sur des postes</span><br />
        Modifies, déplaces, supprimes des postes.
        <br /><br />
        <table>
            <tbody>
                <tr class="haut">
                    <td class="haut">Nom de la catégorie</td>
                    <td class="haut">Nom au masculin</td>
                    <td class="haut">Nom au féminin</td>
                    <td class="haut">Nom dans les NDS</td>
                    <td class="haut">Créé par</td>
                    <td class="haut">Créé le</td>
                    <td class="haut">Actions</td>
                </tr>
                <?php
                $sql = $bdd->query("SELECT * FROM gabcms_postes_noms ORDER BY id_categorie ASC");
                while ($a = $sql->fetch()) {
                    $correct = $bdd->query("SELECT * FROM gabcms_postes_categorie WHERE id = '" . $a['id_categorie'] . "'");
                    $c = $correct->fetch();
                ?>
                    <tr class="bas">
                        <td class="bas"><?PHP echo $c['nom']; ?></td>
                        <td class="bas"><?PHP echo $a['nom_M']; ?></td>
                        <td class="bas"><?PHP echo $a['nom_F']; ?></td>
                        <td class="bas"><?PHP echo $a['nom_nds']; ?></td>
                        <td class="bas"><?PHP echo $a['par']; ?></td>
                        <td class="bas"><?PHP echo $a['le']; ?></td>
                        <td class="bas"><a href="?modif=<?PHP echo $a['id']; ?>">Modifier</a> - <a href="?deplace=<?PHP echo $a['id']; ?>">Déplacer</a> - <a href="?sup=<?PHP echo $a['id']; ?>" onclick="return confirm('Es-tu certain de supprimer ce poste ? Si oui, tous les staffs ayant ce poste ne l\'auront plus.')">Supprimer</a></td>
                    </tr>
                <?PHP
                }
                ?>
            </tbody>
        </table>
    <?php }
    if (isset($_GET['modif']) && !isset($_GET['deplace'])) {
        $sql_modif = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '" . $modif . "'");
        $modif_a = $sql_modif->fetch();
    ?>
        <p><span id="titre">Modifies un poste</span><br />
            Tu peux modifier dans cette page le nom d'un poste<br /><br />
        <form name='editor' method='post' action="?modifierrecrut=<?php echo $modif; ?>">
            <td width='100' class='tbl'><b>Nom du poste au masculin :</b><br /></td>
            <td width='80%' class='tbl'><input type="text" name="nom_modif_M" value="<?php echo $modif_a['nom_M'] ?>" class="text" style="width: 360px" /><br /></td>
            <td width='100' class='tbl'><b>Nom du poste au féminin :</b><br /></td>
            <td width='80%' class='tbl'><input type="text" name="nom_modif_F" value="<?php echo $modif_a['nom_F'] ?>" class="text" style="width: 360px" /><br /></td>
            <td width='100' class='tbl'><b>Nom du poste dans les NDS :</b> (suffit de mettre un S à la fin)<br /></td>
            <td width='80%' class='tbl'><input type="text" name="nom_modif_nds" value="<?php echo $modif_a['nom_nds'] ?>" class="text" style="width: 360px" /><br /></td>
            <br /><input type="submit" value="Modifier" />
        </form><br />

    <?php }
    if (!isset($_GET['modif']) && isset($_GET['deplace'])) {
        $sql_deplace = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '" . $deplace . "'");
        $deplace_a = $sql_deplace->fetch();
        $sql_deplacez = $bdd->query("SELECT * FROM gabcms_postes_categorie WHERE id = '" . $deplace_a['id_categorie'] . "'");
        $deplace_b = $sql_deplacez->fetch();
    ?>
        <p><span id="titre">Deplaces un poste</span><br />
            Déplaces un poste dans la catégorie de ton choix.<br /><br />
            Actuellement, le poste <b><?PHP echo $deplace_a['nom_M']; ?></b> se trouve dans la catégorie <b><?PHP echo $deplace_b['nom']; ?></b>.<br /><br />
        <form name='editor' method='post' action="?deplacement=<?php echo $deplace; ?>">
            <td width='100' class='tbl'><b>Nouvelle catégorie :</b><br /></td>
            <select name="new_categorie" id="pays">
                <?PHP
                $sql_a = $bdd->query("SELECT * FROM gabcms_postes_categorie WHERE id != " . $deplace_a['id_categorie'] . " ORDER BY id ASC");
                while ($a = $sql_a->fetch()) {
                ?>
                    <option value="<?PHP echo $a['id'] ?>"><?PHP echo $a['nom'] ?></option>
                <?PHP } ?>
            </select>
            <br /><input type="submit" value="Déplacer" />
        </form><br />
    <?PHP } ?>

</body>

</html>