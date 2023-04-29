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

$rank_modif = "";
switch ($user['rank']) {
    case 11:
    case 10:
    case 9:
    case 8:
        $rank_modif = "fondateur";
        break;
    case 7:
        $rank_modif = "manager";
        break;
    case 6:
        $rank_modif = "administratrice";
        if ($user['gender'] == 'M') {
            $rank_modif = "administrateur";
        }
        break;
    case 5:
        $rank_modif = "modératrice";
        if ($user['gender'] == 'M') {
            $rank_modif = "modérateur";
        }
        break;
}

if (isset($_POST['pseudo'], $_POST['raison'])) {
    $pseudo = Secu($_POST['pseudo']);
    $raison = Secu($_POST['raison']);
    $poste = Secu($_POST['poste']);
    $sql = $bdd->query("SELECT id FROM users WHERE username = '{$pseudo}'");
    $assoc = $sql->fetch(PDO::FETCH_ASSOC);
    $correct = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '{$poste}'");
    $c = $correct->fetch();

    if ($pseudo != "" && $user['username'] != $pseudo) {
        $insertn3 = $bdd->prepare("INSERT INTO gabcms_avertissement (user_id, raison, par, date, ip, look) VALUES (:id, :raison, :par, :date, :ip, :look)");
        $insertn3->execute([
            ':id' => $assoc['id'],
            ':raison' => $raison,
            ':par' => $user['username'],
            ':date' => FullDate('full'),
            ':ip' => $user['ip_current'],
            ':look' => $user['look']
        ]);

        $insertn4 = $bdd->prepare("INSERT INTO gabcms_dossier (userid, commentaire, par, date, look, avis, ip, poste) VALUES (:id, :com, :par, :date, :look, :avis, :ip, :poste)");
        $insertn4->execute([
            ':id' => $assoc['id'],
            ':com' => "Je viens d'émettre un avertissement envers toi pour la raison suivante : <b>" . addslashes($raison) . "</b><br/><br/>Merci de faire en sorte que cela ne se reproduise plus.",
            ':par' => $user['username'],
            ':date' => FullDate('hc'),
            ':look' => $user['look'],
            ':avis' => '2',
            ':ip' => $user['ip_current'],
            ':poste' => addslashes($c[($user['gender'] == 'M' ? 'nom_M' : 'nom_F')])
        ]);

        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
        $insertn1->execute([
            ':pseudo' => $user['username'],
            ':action' => "a émis un <b>avertissement</b> sur le staff <b>{$pseudo}</b>",
            ':date' => FullDate('full')
        ]);

        $insertn2 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
        $insertn2->execute([
            ':pseudo' => $pseudo,
            ':action' => "a reçu automatiquement un commentaire sur son dossier",
            ':date' => FullDate('full')
        ]);

        echo "<h4 class='alert_success'>L'avertissement a bien été émis à {$pseudo}</b></h4>";
    } else {
        echo "<h4 class='alert_error'>Merci de remplir les champs vides ou de ne pas vous auto-avertir</h4>";
    }
}

if (isset($_POST['pseudo_recherche']) && !empty($_POST['pseudo_recherche'])) {
    $pseudo = Secu($_POST['pseudo_recherche']);
    $sql = $bdd->query("SELECT * FROM users WHERE username = '" . $pseudo . "'");
    $row = $sql->rowCount();
    $assoc = $sql->fetch(PDO::FETCH_ASSOC);
    if ($assoc['username'] != '') {
        $nb_inscrita = $bdd->query("SELECT COUNT(*) AS id FROM gabcms_avertissement WHERE user_id = '" . $assoc['id'] . "'")->fetch();
        $nb_inscritz = $bdd->query("SELECT COUNT(*) AS id FROM gabcms_avertissement WHERE user_id = '" . $assoc['id'] . "' AND annuler = '1'")->fetch();
        $bdd->query("SELECT * FROM gabcms_avertissement WHERE user_id = '" . $assoc['id'] . "'");
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
        $insertn1->execute([
            ':pseudo' => $user['username'],
            ':action' => 'a regardé les avertissements de <b>' . $assoc['username'] . '</b>',
            ':date' => FullDate('full')
        ]);
        echo '<h4 class="alert_success">Le staff <b>' . $pseudo . '</b> a reçu un total de <b>' . $nb_inscrita['id'] . ' avertissement(s)</b> dont <b>' . $nb_inscritz['id'] . ' avertissement(s) annulé(s)</b></h4>';
    } else {
        echo '<h4 class="alert_error">La personne n\'existe pas.</h4>';
    }
} else {
    echo '<h4 class="alert_error">Merci d\'écrire quelque chose</h4>';
}

if (isset($_GET['annule'])) {
    $annule = Secu($_GET['annule']);
    $sql = $bdd->query("SELECT a.*, u.username FROM gabcms_avertissement AS a INNER JOIN users AS u ON a.user_id = u.id WHERE a.id = '" . $annule . "' AND a.annuler = '0' AND a.user_id != '" . $user['id'] . "'");
    $modif_r = $sql->fetch(PDO::FETCH_ASSOC);
    if ($modif_r) {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
        $insertn1->bindValue(':pseudo', $user['username']);
        $insertn1->bindValue(':action', 'a annulé un avertissement de <b>' . $modif_r['username'] . '</b>');
        $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute();
        $bdd->query("UPDATE gabcms_avertissement SET annuler = '1' WHERE id = '" . $annule . "'");
        echo '<h4 class="alert_success">L\'avertissement de <b>' . $modif_r['username'] . '</b> a été annulé.</h4>';
    } elseif ($modif_r['user_id'] == $user['id']) {
        echo '<h4 class="alert_error">Vous ne pouvez pas annuler l\'un de vos avertissements</h4>';
    } else {
        echo '<h4 class="alert_error">Impossible d\'annuler cet avertissement.</h4>';
    }
}

?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />

<body></body>
<span id="titre">Envois un avertissement</span><br />
Tu peux envoyer un ou des avertissement(s) à des staffs, pour différente raison, ça figurera dans leur dossier.<br /><br />
<script type="text/javascript" src="editeur_html/jscripts/tiny_mce/tiny_mce.js"></script>

<form name='editor' method='post' action="#">
    <td width='100' class='tbl'><b>Pseudo :</b><br /></td>
    <td width='80%' class='tbl'><select name="pseudo" id="pays">
            <?PHP
            $sql_a = $bdd->query("SELECT * FROM users WHERE rank >= '4' ORDER BY rank DESC");
            while ($a = $sql_a->fetch()) {
            ?>
                <option value="<?PHP echo $a['username']; ?>"><?PHP echo $a['username']; ?></option>
            <?PHP } ?>
        </select><br /></td>
    <td width='100' class='tbl'><b>Raison :</b><br /></td>
    <td width='80%' class='tbl'><input type='text' name='raison' placeholder='Raison' class='text' style='width: 240px' maxlength='450'>
        <br />
    </td>
    <b>Mon poste :</b> (pour afficher dans le dossier)<br /></td>
    <td width='80%' class='tbl'>
        <select name="poste" id="pays">
            <option value="">-- Choisis ton poste --</option>
            <?PHP
            if ($user['gender'] == 'M') {
                $sql_a = $bdd->query("SELECT * FROM gabcms_postes WHERE user_id = '" . $user['id'] . "' ORDER BY id DESC");
                while ($a = $sql_a->fetch()) {
                    $correct = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '" . $a['poste'] . "'");
                    $c = $correct->fetch();
            ?>
                    <option value="<?PHP echo $a['poste']; ?>"><?PHP echo $c['nom_M']; ?></option>
                <?PHP }
            }
            if ($user['gender'] == 'F') {
                $sql_a = $bdd->query("SELECT * FROM gabcms_postes WHERE user_id = '" . $user['id'] . "' ORDER BY id DESC");
                while ($a = $sql_a->fetch()) {
                    $correct = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '" . $a['poste'] . "'");
                    $c = $correct->fetch();
                ?>
                    <option value="<?PHP echo $a['poste']; ?>"><?PHP echo $c['nom_F']; ?></option>
            <?PHP }
            } ?>
        </select>
    </td><br /><br />
    <tr>
        <td align='center' colspan='2' class='tbl'>
            <input type='submit' name='submit' value='Exécuter' class='submit'>
</form>
</tr>
<br />
<hr /><br />
<span id="titre">Affiches les avertissements</span><br />
Affiches les avertissements qu'un staff a pu avoir.
<br />
<br />
<form method="post" action="?do=givebadge">
    <td width='100' class='tbl'><b>Pseudo :</b><br /></td>
    <td width='80%' class='tbl'><input type='text' name='pseudo_recherche' value='<?php if (!empty($_POST["pseudo_recherche"])) {
                                                                                        echo htmlspecialchars($_POST["pseudo_recherche"], ENT_QUOTES);
                                                                                    } ?>' placeholder="Pseudo" class='text' style='width: 240px'></td> <input type="submit" value="Rechercher" />
</form>
<table>
    <tbody>
        <tr class="haut">
            <td class="haut">Pseudo</td>
            <td class="haut">Raison</td>
            <td class="haut">Par</td>
            <td class="haut">Date</td>
            <td class="haut">Actions</td>
        </tr>
        <?PHP if (isset($_GET['annule']) || isset($_GET['do'])) { ?>
            <tr style="background-color:#a8a8a8;">
                <td colspan="5" style="padding:5px; text-align: center; vertical-align: middle;font-size:11px; color:#000000">Les avertissements encore actifs</td>
            </tr>
            <?PHP
            $sql = $bdd->query("SELECT * FROM gabcms_avertissement WHERE user_id = '" . $assoc['id'] . "' AND annuler = '0' ORDER BY id DESC");
            $sqla = $bdd->query("SELECT username FROM users WHERE id = '" . $assoc['id'] . "'");
            $rowa = $sqla->rowCount();
            $assoca = $sqla->fetch(PDO::FETCH_ASSOC);
            while ($a = $sql->fetch()) {
            ?>
                <tr class="bas">
                    <td class="bas"><?PHP echo $assoca['username']; ?></td>
                    <td class="bas"><?PHP echo $a['raison']; ?></td>
                    <td class="bas"><?PHP echo $a['par']; ?></td>
                    <td class="bas"><?PHP echo $a['date']; ?></td>
                    <?PHP if ($a['annuler'] == '0') { ?>
                        <td class="bas"><a href="?annule=<?PHP echo $a['id']; ?>" onclick="return confirm('Es-tu certain d\'annuler cet avertissement ? Cette action est irrévocable.')">Annuler</a></td>
                    <?PHP } ?>
                </tr>
            <?PHP } ?>
            <tr style="background-color:#a8a8a8;">
                <td colspan="5" style="padding:5px; text-align: center; vertical-align: middle;font-size:11px; color:#000000">Les avertissements annulés</td>
            </tr>
            <?PHP
            $sql = $bdd->query("SELECT * FROM gabcms_avertissement WHERE user_id = '" . $assoc['id'] . "' AND annuler = '1' ORDER BY id DESC");
            $sqla = $bdd->query("SELECT username FROM users WHERE id = '" . $assoc['id'] . "'");
            $rowa = $sqla->rowCount();
            $assoca = $sqla->fetch(PDO::FETCH_ASSOC);
            while ($a = $sql->fetch()) {
            ?>
                <tr class="bas">
                    <td class="bas"><?PHP echo $assoca['username']; ?></td>
                    <td class="bas"><?PHP echo $a['raison']; ?></td>
                    <td class="bas"><?PHP echo $a['par']; ?></td>
                    <td class="bas"><?PHP echo $a['date']; ?></td>
                    <td class="bas"></td>
                </tr>
        <?PHP }
        } ?>
    </tbody>
</table>
</body>

</html>