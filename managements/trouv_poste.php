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

if (isset($_POST['username']) && !empty($_POST['username'])) {
    $username = Secu($_POST['username']);
    $sql = $bdd->query("SELECT * FROM users WHERE username = '$username'");
    $row = $sql->rowCount();
    $assoc = $sql->fetch(PDO::FETCH_ASSOC);
} else {
    $message = 'Remplie les champs vide!';
}

if (isset($_GET['sup'])) {
    $sup = Secu($_GET['sup']);
    $sql = $bdd->query("SELECT * FROM gabcms_postes WHERE id = '$sup'");
    $a = $sql->fetch();
    $sql2 = $bdd->query("SELECT * FROM users WHERE id = '{$a['user_id']}'");
    $assoc2 = $sql2->fetch(PDO::FETCH_ASSOC);
    $correct = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '{$a['poste']}'");
    $c = $correct->fetch();
    if ($sup) {
        $action = "a déstitué <b>{$assoc2['username']}</b> de son poste de <b>" . addslashes($assoc2['gender'] == 'M' ? $c['nom_M'] : $c['nom_F']) . "</b>";
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo, action, date) VALUES (:pseudo, :action, :date)");
        $insertn1->execute(array(':pseudo' => $user['username'], ':action' => $action, ':date' => FullDate('full')));
        $bdd->query("DELETE FROM gabcms_postes WHERE id = '$sup'");
        echo "<h4 class=\"alert_success\"><b>{$assoc2['username']}</b> a bien été destitué de son poste <b>({$c['nom_M']})</b></h4>";
    }
}

?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />

<body>
    <span id="titre">Déstitue une personne de son poste</span><br />
    Déstitues un staff de son ou ses postes.<br /><br />
    <form method="post" action="?do=recherche">
        <td width='100' class='tbl'><b>Pseudo :</b></td>
        <td width='80%' class='tbl'>
            <select name="username" id="pays">
                <?php
                $sql_a = $bdd->query("SELECT username FROM users WHERE rank >= '4' ORDER BY rank DESC");
                while ($a = $sql_a->fetch(PDO::FETCH_ASSOC)) {
                    $selected = (isset($_POST['username']) && $_POST['username'] == $a['username']) ? 'selected="selected"' : '';
                    echo '<option value="' . $a['username'] . '" ' . $selected . '>' . $a['username'] . '</option>';
                }
                ?>
            </select>
        </td>&nbsp;&nbsp;<input type="submit" value="Rechercher" />
    </form>
    <table>
        <tbody>
            <tr class="haut">
                <td class="haut">Poste</td>
                <td class="haut">Attribué par</td>
                <td class="haut">Attribué le</td>
                <td class="haut">Action</td>
            </tr>
            <?php
            if (isset($_POST['username'])) {
                $username = Secu($_POST['username']);
                $sql = $bdd->query("SELECT * FROM users WHERE username = '" . $username . "'");
                $assoc = $sql->fetch(PDO::FETCH_ASSOC);

                $sql_postes = $bdd->query("SELECT * FROM gabcms_postes WHERE user_id = '" . $assoc['id'] . "'");
                while ($poste = $sql_postes->fetch()) {
                    $correct = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '" . $poste['poste'] . "'");
                    $c = $correct->fetch();

                    $modif_poste = ($assoc['gender'] == 'M') ? $c['nom_M'] : $c['nom_F'];
            ?>
                    <tr class="bas">
                        <td class="bas"><?= $modif_poste ?></td>
                        <td class="bas"><?= $poste['par'] ?></td>
                        <td class="bas"><?= $poste['date'] ?></td>
                        <td class="bas"><a href="?sup=<?= $poste['id'] ?>">Destitué</a></td>
                    </tr>
            <?php
                }
            }
            ?>

        </tbody>
    </table>
</body>

</html>