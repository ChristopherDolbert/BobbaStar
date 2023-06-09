<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");

if (!isset($_SESSION['username']) || $user['rank'] > 11) {
    Redirect("" . $url . "/managements/acces_interdit");
    exit();
}

if (isset($_GET['modif'])) {
    $modif = Secu($_GET['modif']);
}

if (isset($_GET['modifierrecrut'], $_POST['fonction'])) {
    $modifierrecrut = Secu($_GET['modifierrecrut']);
    $fonction = addslashes($_POST['fonction']);
    $sql = $bdd->query("SELECT username, fonction FROM users WHERE id = '$modifierrecrut'");
    if ($sql->rowCount() == 1) {
        $a = $sql->fetch();
        $oldFonction = addslashes($a['fonction']);
        $bdd->query("UPDATE users SET fonction = '$fonction' WHERE id = '$modifierrecrut'");
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
        $insertn1->execute([':pseudo' => $user['username'], ':action' => "a modifié la fonction de <b>{$a['username']}</b> : <b>$fonction</b> (auparavant : $oldFonction)", ':date' => FullDate('full')]);
        $insertn2 = $bdd->prepare("INSERT INTO gabcms_management (user_id, message, auteur, date, look) VALUES (:userid, :message, :auteur, :date, :look)");
        $insertn2->execute([':userid' => $modifierrecrut, ':message' => "Nous venons de modifier ta fonction au sein du rétro, pour en savoir plus, <a href='{$url}/alerts'>cliques ici</a> !", ':auteur' => $user['username'], ':date' => FullDate('full'), ':look' => $user['look']]);
        $insertn3 = $bdd->prepare("INSERT INTO gabcms_alertes (userid, sujet, alerte, par, date, look, action) VALUES (:userid, :sujet, :message, :pseudo, :date, :look, :act)");
        $insertn3->execute([':userid' => $modifierrecrut, ':sujet' => 'Modification de ta fonction', ':message' => "Bonjour <b>{$a['username']}</b>,<br><br>Je viens de changer ta fonction au sein du rétro (ce qui est afficher sur la page équipe), voici ta nouvelle fonction : <b>$fonction</b> <i>(auparavant : $oldFonction)</i><br><br>Cordialement,", ':pseudo' => $user['username'], ':date' => FullDate('full'), ':look' => $user['look'], ':act' => '0']);
        echo '<h4 class="alert_success">La fonction de <b>' . $a['username'] . '</b> a été modifiée.</h4>';
    } else {
        echo '<h4 class="alert_error">Une erreur est survenue</h4>';
    }
}


?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />

<body>
    <?php if (!isset($_GET['modif'])) { ?>
        <span id="titre">Modifies une fonction</span><br />
        Modifies une fonction d'un utilisateur par ce que tu souhaites. Il sera averti par alerte de ce changement.
        <br />
        <br />
        <form method="post" action="?do=recherche">
            <input type='text' name='pseudo' value='<?php if (!empty($_POST["pseudo"])) {
                                                        echo htmlspecialchars($_POST["pseudo"], ENT_QUOTES);
                                                    } ?>' placeholder="Pseudo" class='text' style='width: 240px'>&nbsp;&nbsp;
            <select name="ordre">
                <option value="1" <?php if (isset($_POST['ordre']) && $_POST['ordre'] == "1") echo 'selected="selected"'; ?>>Trier par ID croissant</option>
                <option value="2" <?php if (isset($_POST['ordre']) && $_POST['ordre'] == "2") echo 'selected="selected"'; ?>>Trier par ID décroissant</option>
                <option value="3" <?php if (isset($_POST['ordre']) && $_POST['ordre'] == "3") echo 'selected="selected"'; ?>>Trier par pseudo croissant</option>
                <option value="4" <?php if (isset($_POST['ordre']) && $_POST['ordre'] == "4") echo 'selected="selected"'; ?>>Trier par pseudo décroissant</option>
                <option value="5" <?php if (isset($_POST['ordre']) && $_POST['ordre'] == "5") echo 'selected="selected"'; ?>>Trier par rank croissant</option>
                <option value="6" <?php if (isset($_POST['ordre']) && $_POST['ordre'] == "6") echo 'selected="selected"'; ?>>Trier par rank décroissant</option>
            </select>&nbsp;&nbsp;
            <select name="rank">
                <option value="1" <?php if (isset($_POST['rank']) && $_POST['rank'] == "1") echo 'selected="selected"'; ?>>Afficher tout le monde</option>
                <option value="2" <?php if (isset($_POST['rank']) && $_POST['rank'] == "2") echo 'selected="selected"'; ?>>Afficher seulement les utilisateurs</option>
                <option value="3" <?php if (isset($_POST['rank']) && $_POST['rank'] == "3") echo 'selected="selected"'; ?>>Afficher seulement les staffs</option>
                <option value="4" <?php if (isset($_POST['rank']) && $_POST['rank'] == "4") echo 'selected="selected"'; ?>>Afficher seulement les VIP CLUB</option>
                <option value="5" <?php if (isset($_POST['rank']) && $_POST['rank'] == "5") echo 'selected="selected"'; ?>>Afficher seulement les STAFF CLUB</option>
                <option value="6" <?php if (isset($_POST['rank']) && $_POST['rank'] == "6") echo 'selected="selected"'; ?>>Afficher seulement les modérateurs</option>
                <option value="7" <?php if (isset($_POST['rank']) && $_POST['rank'] == "7") echo 'selected="selected"'; ?>>Afficher seulement les administrateurs</option>
                <option value="8" <?php if (isset($_POST['rank']) && $_POST['rank'] == "8") echo 'selected="selected"'; ?>>Afficher seulement les managers</option>
                <option value="9" <?php if (isset($_POST['rank']) && $_POST['rank'] == "9") echo 'selected="selected"'; ?>>Afficher seulement les fondateurs</option>
            </select>&nbsp;&nbsp;
            <input type="submit" value="Rechercher" />
        </form>
        <table>
            <tbody>
                <tr class="haut">
                    <td class="haut">ID</td>
                    <td class="haut">Pseudo</td>
                    <td class="haut">Mail</td>
                    <td class="haut">Créer le</td>
                    <td class="haut">Rank actuel</td>
                    <td class="haut">Fonction actuelle</td>
                    <td class="haut">Action</td>
                </tr>
                <?php
                $ordre = '1';
                $rank = '1';
                $pseudo = '';
                if (isset($_POST['ordre'])) {
                    $ordre = Secu($_POST['ordre']);
                }
                if ($ordre == '1') {
                    $mordre = 'ORDER BY id ASC';
                }
                if ($ordre == '2') {
                    $mordre = 'ORDER BY id DESC';
                }
                if ($ordre == '3') {
                    $mordre = 'ORDER BY username ASC';
                }
                if ($ordre == '4') {
                    $mordre = 'ORDER BY username DESC';
                }
                if ($ordre == '5') {
                    $mordre = 'ORDER BY rank ASC';
                }
                if ($ordre == '6') {
                    $mordre = 'ORDER BY rank DESC';
                }
                if (isset($_POST['rank'])) {
                    $rank = Secu($_POST['rank']);
                }
                if ($rank == '1') {
                    $mrank = '';
                }
                if ($rank == '2') {
                    $mrank = 'AND rank < 5';
                }
                if ($rank == '3') {
                    $mrank = 'AND rank >= 5';
                }
                if ($rank == '4') {
                    $mrank = 'AND rank = 2';
                }
                if ($rank == '5') {
                    $mrank = 'AND rank = 3';
                }
                if ($rank == '6') {
                    $mrank = 'AND rank = 5';
                }
                if ($rank == '7') {
                    $mrank = 'AND rank = 6';
                }
                if ($rank == '8') {
                    $mrank = 'AND rank = 7';
                }
                if ($rank == '9') {
                    $mrank = 'AND rank = 8';
                }
                if (isset($_POST['pseudo'])) {
                    $pseudo = Secu($_POST['pseudo']);
                }
                $sql2 = $bdd->query("SELECT * FROM `users` WHERE `username` LIKE '%" . $pseudo . "%' " . $mrank . " " . $mordre . "");
                while ($a = $sql2->fetch()) {
                    if ($a['rank'] == 1) {
                        $modifier_r = "Utilisateur";
                    }
                    if ($a['rank'] == 2) {
                        $modifier_r = "VIP";
                    }
                    if ($a['rank'] == 3) {
                        $modifier_r = "STAFF CLUB";
                    }
                    if ($a['rank'] == 4) {
                        $modifier_r = "inconnu (4)";
                    }
                    if ($a['rank'] == 5) {
                        $modifier_r = "<b><span style=\"color:red\">Modérateur</span></b>";
                    }
                    if ($a['rank'] == 6) {
                        $modifier_r = "<b><span style=\"color:green\">Administrateur</span></b>";
                    }
                    if ($a['rank'] == 7) {
                        $modifier_r = "<b><span style=\"color:#C1B31C\">Manager</span></b>";
                    }
                    if ($a['rank'] == 8) {
                        $modifier_r = "<b><span style=\"color:blue\">Fondateur</span></b>";
                    }
                ?>
                    <tr class="bas">
                        <td class="bas"><?PHP echo Secu($a['id']); ?></td>
                        <td class="bas"><?PHP echo Secu($a['username']); ?></td>
                        <td class="bas"><?PHP echo Secu($a['mail']); ?></td>
                        <td class="bas"><?PHP echo Secu($a['account_created']); ?></td>
                        <td class="bas"><?PHP echo $modifier_r; ?></td>
                        <td class="bas"><?PHP echo Secu($a['fonction']); ?></td>
                        <td class="bas"><a href="?modif=<?PHP echo Secu($a['id']); ?>">Modifier</a></td>
                    </tr>
                <?PHP } ?>
            </tbody>
        </table>
    <?PHP }
    if (isset($_GET['modif'])) {
        $sql_modif = $bdd->query("SELECT * FROM users WHERE id = '" . $modif . "'");
        $modif_a = $sql_modif->fetch();
    ?>
        <span id="titre">Modifies une fonction</span><br />
        Modifies une fonction d'un utilisateur par ce que tu souhaites. Il sera averti par alerte de ce changement.<br /><br />
        <form name='editor' method='post' action="?modifierrecrut=<?php echo $modif; ?>">
            <td width="100" class="tbl"><b>Nouvelle fonction :</b><br /></td>
            <td width="80%" class="tbl"><input type="text" name="fonction" value="<?PHP echo $modif_a['fonction']; ?>" class="text" style="width: 440px"><br /></td><br />
            <br />
            <input type="submit" value="Modifier" />
        </form>
    <?PHP } ?>
</body>

</html>

</tr>