<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");

if (!isset($_SESSION['username']) || $user['rank'] < 7 || $user['rank'] > 11) {
    Redirect("" . $url . "/managements/acces_interdit");
    exit();
}

if (isset($_GET['modif'])) {
    $modif = Secu($_GET['modif']);
}

if (isset($_GET['do'], $_POST['nom_categorie'], $_POST['couleur']) && $_GET['do'] == "create") {
    $nom_categorie = addslashes($_POST['nom_categorie']);
    $couleur = addslashes($_POST['couleur']);

    if (!empty($nom_categorie) && !empty($couleur)) {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
        $insertn1->execute(array(':pseudo' => $user['username'], ':action' => 'a créé une catégorie de forum <b>(' . $nom_categorie . ')</b>', ':date' => FullDate('full')));

        $insertn2 = $bdd->prepare("INSERT INTO gabcms_forum_categorie (nom, create_par, date, couleur) VALUES (:nom, :user, :date, :color)");
        $insertn2->execute(array(':nom' => $nom_categorie, ':user' => $user['username'], ':date' => time(), ':color' => $couleur));

        echo '<h4 class="alert_success">La catégorie a été enregistrée</h4>';
    } else {
        echo '<h4 class="alert_error">Une erreur est survenue</h4>';
    }
}

if (isset($_GET['do'])) {
    if ($_GET['do'] === 'create' && isset($_POST['nom_categorie'], $_POST['couleur']) && !empty($_POST['nom_categorie']) && !empty($_POST['couleur'])) {
        $nom_categorie = addslashes($_POST['nom_categorie']);
        $couleur = addslashes($_POST['couleur']);
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
        $insertn1->execute([
            ':pseudo' => $user['username'],
            ':action' => 'a créé une catégorie de forum <b>(' . $nom_categorie . ')</b>',
            ':date' => FullDate('full')
        ]);
        $insertn2 = $bdd->prepare("INSERT INTO gabcms_forum_categorie (nom, create_par, date, couleur) VALUES (:nom, :user, :date, :color)");
        $insertn2->execute([
            ':nom' => $nom_categorie,
            ':user' => $user['username'],
            ':date' => time(),
            ':color' => $couleur
        ]);
        echo '<h4 class="alert_success">La catégorie a été enregistrée</h4>';
    } elseif ($_GET['do'] === 'sup' && isset($_GET['sup'])) {
        $sup = Secu($_GET['sup']);
        $sql_modif = $bdd->prepare("SELECT nom FROM gabcms_forum_categorie WHERE id = :id");
        $sql_modif->execute([':id' => $sup]);
        $nom_categorie = $sql_modif->fetchColumn();
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
        $insertn1->execute([
            ':pseudo' => $user['username'],
            ':action' => 'a supprimé une catégorie de forum <b>(' . addslashes($nom_categorie) . ')</b>',
            ':date' => FullDate('full')
        ]);
        $bdd->prepare("DELETE FROM gabcms_forum_categorie WHERE id = :id")->execute([':id' => $sup]);
        echo '<h4 class="alert_success">La catégorie a bien été supprimée</h4>';
    } else {
        echo '<h4 class="alert_error">Une erreur est survenue</h4>';
    }
}

if (isset($_GET['modifierrecrut'], $_POST['nom_modif'], $_POST['couleur_modif'])) {
    $modifierrecrut = Secu($_GET['modifierrecrut']);
    $nom_modif = addslashes($_POST['nom_modif']);
    $couleur_modif = addslashes($_POST['couleur_modif']);

    $sql_modif = $bdd->prepare("SELECT nom FROM gabcms_forum_categorie WHERE id = :id");
    $sql_modif->execute([':id' => $modifierrecrut]);
    $modif_a = $sql_modif->fetch();

    if (!empty($nom_modif) && !empty($couleur_modif)) {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
        $insertn1->execute([
            ':pseudo' => $user['username'],
            ':action' => 'a modifié la catégorie de forum <b>' . addslashes($modif_a['nom']) . '</b> en <b>' . $nom_modif . '</b>',
            ':date' => FullDate('full')
        ]);

        $bdd->prepare("UPDATE gabcms_forum_categorie SET nom = :nom, couleur = :couleur WHERE id = :id")
            ->execute([
                ':nom' => $nom_modif,
                ':couleur' => $couleur_modif,
                ':id' => $modifierrecrut
            ]);

        echo '<h4 class="alert_success">La modification a bien eu lieu</h4>';
    } else {
        echo '<h4 class="alert_error">Une erreur est survenue</h4>';
    }
}

?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />

<body></body>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<?php if (!isset($_GET['modif'])) { ?>
    <span id="titre">Créer une catégorie</span><br />
    Ajoutes une catégorie pour le forum.<br /><br />
    <form name='editor' method='post' action="?do=create">
        <td width='100' class='tbl'><b>Nom de la catégorie :</b><br /></td>
        <td width='80%' class='tbl'><input type="text" name="nom_categorie" value="<?php if (!empty($_POST["nom_categorie"])) {
                                                                                        echo htmlspecialchars($_POST["nom_categorie"], ENT_QUOTES);
                                                                                    } ?>" class="text" style="width: 360px" /><br /></td>
        <td width='100' class='tbl'><b>Couleur de la catégorie :</b><br /></td>
        <td width='80%' class='tbl'><select name="couleur" style="width:150px;">
                <option value="black" style="background-color:#000000; color:#FFFFFF;">Noir</option>
                <option value="gray" style="background-color:#333">Gris</option>
                <option value="settings" style="background-color:#595959">Gris clair</option>
                <option value="hcred" style="background-color:#676767">Gris très clair</option>
                <option value="promogray" style="background-color:#9c350f">Marron foncé</option>
                <option value="brown" style="background-color:#a67a3e">Marron</option>
                <option value="lightbrown" style="background-color:#cf9c44">Marron clair</option>
                <option value="red" style="background-color:#d64242">Rouge</option>
                <option value="darkred" style="background-color:#c73c3c">Rouge foncé</option>
                <option value="blue" style="background-color:#2767a7">Bleu</option>
                <option value="activehomes" style="background-color:#51a5d5">Bleu clair</option>
                <option value="orange" style="background-color:#f66200">Orange</option>
                <option value="green" style="background-color:#4ab501">Vert</option>
                <option value="yellow" style="background-color:#C1B31C">Jaune</option>
                <option value="white" style="background-color:#ffffff">Blanc</option>
            </select>
        </td>
        <br /><br /><input type="submit" value="Ajouter" />
    </form>
    <hr />
    <span id="titre">Action sur une catégorie</span><br />
    Modifies ou supprimes une catégorie du forum.<br /><br />
    <table>
        <tbody>
            <tr class="haut">
                <td class="haut">Nom de la catégorie</td>
                <td class="haut">Créé par</td>
                <td class="haut">Créé le</td>
                <td class="haut">Actions</td>
            </tr>
            <?PHP
            $sql = $bdd->query("SELECT * FROM gabcms_forum_categorie ORDER BY id ASC");
            while ($a = $sql->fetch()) {
                $vraie_date = date('d/m/Y à H:i', $a['date']);
            ?>
                <tr class="bas">
                    <td class="bas"><?PHP echo $a['nom']; ?></td>
                    <td class="bas"><?PHP echo $a['create_par']; ?></td>
                    <td class="bas"><?PHP echo $vraie_date; ?></td>
                    <td class="bas"><a href="?modif=<?PHP echo $a['id']; ?>">Modifier</a> - <a href="?sup=<?PHP echo $a['id']; ?>" onclick="return confirm('Es-tu certain de supprimer cette catégorie ? Si oui, toutes les sous catégories de cette catégorie n'auront aucune affectation.')">Supprimer</a></td>
                </tr>
            <?PHP } ?>
        </tbody>
    </table>
<?PHP }
if (isset($_GET['modif'])) {
    $sql_modif = $bdd->query("SELECT * FROM gabcms_forum_categorie WHERE id = '" . $modif . "'");
    $modif_a = $sql_modif->fetch();
?>
    <p><span id="titre">Modifies une catégorie du forum</span><br />
        Tu peux modifier dans cette page le nom d'une catégorie du forum<br /><br />
    <form name='editor' method='post' action="?modifierrecrut=<?php echo $modif; ?>">
        <td width='100' class='tbl'><b>Nom de la catégorie :</b><br /></td>
        <td width='80%' class='tbl'><input type="text" name="nom_modif" value="<?php echo $modif_a['nom'] ?>" class="text" style="width: 360px" /><br /></td>
        <td width='100' class='tbl'><b>Couleur de la catégorie :</b><br /></td>
        <td width='80%' class='tbl'><select name="couleur_modif">
                <option value="black" <?php if (isset($modif_a['couleur']) && $modif_a['couleur'] == "black") echo 'selected="selected"'; ?> style="background-color:#000000; color:#FFFFFF;">Noir</option>
                <option value="gray" <?php if (isset($modif_a['couleur']) && $modif_a['couleur'] == "gray") echo 'selected="selected"'; ?> style="background-color:#333">Gris</option>
                <option value="settings" <?php if (isset($modif_a['couleur']) && $modif_a['couleur'] == "settings") echo 'selected="selected"'; ?> style="background-color:#595959">Gris clair</option>
                <option value="hcred" <?php if (isset($modif_a['couleur']) && $modif_a['couleur'] == "hcred") echo 'selected="selected"'; ?> style="background-color:#676767">Gris très clair</option>
                <option value="promogray" <?php if (isset($modif_a['couleur']) && $modif_a['couleur'] == "promogray") echo 'selected="selected"'; ?> style="background-color:#9c350f">Marron foncé</option>
                <option value="brown" <?php if (isset($modif_a['couleur']) && $modif_a['couleur'] == "brown") echo 'selected="selected"'; ?> style="background-color:#a67a3e">Marron</option>
                <option value="lightbrown" <?php if (isset($modif_a['couleur']) && $modif_a['couleur'] == "lightbrown") echo 'selected="selected"'; ?> style="background-color:#cf9c44">Marron clair</option>
                <option value="red" <?php if (isset($modif_a['couleur']) && $modif_a['couleur'] == "red") echo 'selected="selected"'; ?> style="background-color:#d64242">Rouge</option>
                <option value="darkred" <?php if (isset($modif_a['couleur']) && $modif_a['couleur'] == "darkred") echo 'selected="selected"'; ?> style="background-color:#c73c3c">Rouge foncé</option>
                <option value="blue" <?php if (isset($modif_a['couleur']) && $modif_a['couleur'] == "blue") echo 'selected="selected"'; ?> style="background-color:#2767a7">Bleu</option>
                <option value="activehomes" <?php if (isset($modif_a['couleur']) && $modif_a['couleur'] == "activehomes") echo 'selected="selected"'; ?> style="background-color:#51a5d5">Bleu clair</option>
                <option value="orange" <?php if (isset($modif_a['couleur']) && $modif_a['couleur'] == "orange") echo 'selected="selected"'; ?> style="background-color:#f66200">Orange</option>
                <option value="green" <?php if (isset($modif_a['couleur']) && $modif_a['couleur'] == "green") echo 'selected="selected"'; ?> style="background-color:#4ab501">Vert</option>
                <option value="yellow" <?php if (isset($modif_a['couleur']) && $modif_a['couleur'] == "yellow") echo 'selected="selected"'; ?> style="background-color:#C1B31C">Jaune</option>
                <option value="white" <?php if (isset($modif_a['couleur']) && $modif_a['couleur'] == "white") echo 'selected="selected"'; ?> style="background-color:#ffffff">Blanc</option>
            </select>
        </td>
        <br /><input type="submit" value="Modifier" />
    </form><br />

    </form>
<?php
}
?>

</body>

</html>