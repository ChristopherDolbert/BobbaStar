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
    $pseudo = Secu($_POST['name']);
    $raison = Secu($_POST['raison']);
    $poste = Secu($_POST['poste']);
    $name = explode(";", $pseudo);
    $nbr = count($name);
    $do = Secu($_GET['do']);
    $correct = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '" . $poste . "'");
    $c = $correct->fetch();
    if (isset($pseudo)) {
        if (!empty($pseudo)) {

            for ($n = 0; $n < $nbr; $n++) :
                $sql = $bdd->query("SELECT id FROM users WHERE username = '" . $name[$n] . "'");
                $row = $sql->rowCount();
                $assoc = $sql->fetch(PDO::FETCH_ASSOC);
                if ($row > 0) {
                    for ($n = 0; $n < $nbr; $n++) {
                        $sql = $bdd->query("SELECT id FROM users WHERE username = '" . $name[$n] . "'");
                        $row = $sql->rowCount();
                        $assoc = $sql->fetch(PDO::FETCH_ASSOC);
                        if ($row > 0) {
                            $actions = [
                                ['action' => 'a été déstitué de son rank par <b>' . $user['username'] . '</b> pour la raison suivante : <b><i>' . $raison . '</i></b>'],
                                ['action' => 'a reçu automatiquement un commentaire sur son dossier'],
                                ['action' => 's\'est vu retiré tous ses postes']
                            ];
                            foreach ($actions as $action) {
                                $insertn = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
                                $insertn->bindValue(':pseudo', $name[$n]);
                                $insertn->bindValue(':action', $action['action']);
                                $insertn->bindValue(':date', FullDate('full'));
                                $insertn->execute();
                            }
                            // rest of the code here
                        } else {
                            echo '<h4 class="alert_error">Le compte <b>' . $name[$n] . '</b> n\'existe pas.</h4>';
                        }
                    }
                    $bdd->query("UPDATE users SET rank = '1' WHERE username = '" . $name[$n] . "'");
                    $bdd->query("DELETE FROM gabcms_postes WHERE user_id = '" . $assoc['id'] . "'");
                    $bdd->query("DELETE FROM user_badges WHERE user_id = '" . $assoc['id'] . "' AND badge_id = 'ADM'");
                    $bdd->query("DELETE FROM user_badges WHERE user_id = '" . $assoc['id'] . "' AND badge_id = 'HS1'");
                    $insertn2 = $bdd->prepare("INSERT INTO gabcms_alertes (userid, sujet, alerte, par, date, look, action) VALUES (:id, :sujet, :alerte, :par, :date, :look, :act)");
                    $insertn2->bindValue(':id', $assoc['id']);
                    $insertn2->bindValue(':sujet', 'Poste dans le rétro');
                    $insertn2->bindValue(':alerte', 'J\'ai le devoir de t\'annoncer, qu\'à partir de ce jour, tu ne fais plus parti de l\'équipe pour la raison suivante : ' . $raison . '');
                    $insertn2->bindValue(':par', $user['username']);
                    $insertn2->bindValue(':date', FullDate('full'));
                    $insertn2->bindValue(':look', $user['look']);
                    $insertn2->bindValue(':act', '0');
                    $insertn2->execute();
                    $insertn3 = $bdd->prepare("INSERT INTO gabcms_management (user_id, message, auteur, date, look) VALUES (:userid, :message, :auteur, :date, :look)");
                    $insertn3->bindValue(':userid', $assoc['id']);
                    $insertn3->bindValue(':message', 'Nous venons de t\'envoyer une alerte ! Merci d\'aller la lire au <b>PLUS VITE</b> en <a href="' . $url . '/alerts">cliquant ici</a> !');
                    $insertn3->bindValue(':auteur', $user['username']);
                    $insertn3->bindValue(':date', FullDate('full'));
                    $insertn3->bindValue(':look', $user['look']);
                    $insertn3->execute();
                    $insertn4 = $bdd->prepare("INSERT INTO gabcms_dossier (userid, commentaire, par, date, look, avis, ip, poste) VALUES (:id, :com, :par, :date, :look, :avis, :ip, :poste)");
                    $insertn4->bindValue(':id', $assoc['id']);
                    $insertn4->bindValue(':com', 'Dérank ce jour, au poste de simple utilisateur pour la raison suivante : <b>' . $raison . '</b>');
                    $insertn4->bindValue(':par', $user['username']);
                    $insertn4->bindValue(':date', FullDate('hc'));
                    $insertn4->bindValue(':look', $user['look']);
                    $insertn4->bindValue(':avis', '3');
                    $insertn4->bindValue(':ip', $user['ip_current']);
                    if ($user['gender'] == 'M') {
                        $insertn4->bindValue(':poste', addslashes($c['nom_M']));
                    } elseif ($user['gender'] == 'F') {
                        $insertn4->bindValue(':poste', addslashes($c['nom_F']));
                    }
                    $insertn4->execute();
                    echo '<h4 class="alert_success">Le compte <b>' . $name[$n] . '</b> a été deranker, a reçu une alerte et un commentaire sur son dossier.</h4>';
                } else {
                    echo '<h4 class="alert_error">Le compte <b>' . $name[$n] . '</b> n\'existe pas.</h4>';
                }
            endfor;
        } else {
            echo '<h4 class="alert_error">Les champs ne sont pas tous remplis.</h4>';
        }
    }
}

if (isset($_GET['recherche']) && $_GET['recherche'] === "1" && isset($_POST['poste_rech'])) {
    $rank = Secu($_POST['poste_rech']);
    if (!empty($rank)) {
        $rech = $bdd->query("SELECT * FROM users WHERE rank = '" . $rank . "'");
        $row = $rech->rowCount();
    }
}


?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />
<script language="javascript" type="text/javascript">
    function insert_texte(texte) {
        var ou = document.getElementsByName("name")[0];
        var phrase = texte;
        ou.value += phrase;
        ou.focus();
    }
</script>

<body>
    <span id="titre">Derank un utilisateur.</span><br />
    Derank plusieurs utilisateurs en m&ecirc;me temps pour cela apr&egrave;s chaque pseudo mettez un point virgule (;).<br /><br />
    <form name='editor' method='post' action="?do=derank">
        <td width='100' class='tbl'><b>Pseudo :</b><br /></td>
        <td width='80%' class='tbl'><input type='text' name='name' value='' class='text' style='width: 240px'><br /></td>
        <td width='100' class='tbl'><b>Raison :</b><br /></td>
        <td width='80%' class='tbl'><textarea name='raison' wrap=discuss rows=3 cols=40></textarea><br /></td>
        <td width='100' class='tbl'><b>Poste :</b> (pour afficher dans le dossier)<br /></td>
        <td width='80%' class='tbl'>
            <select name="poste" id="pays">
                <option value="">-- Choisis le poste --</option>
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
        <td align='center' colspan='2' class='tbl'>
            <input type='submit' name='submit' value='Exécuter' class='submit'>
    </form>
    <hr /><br />
    <span id="titre">Regarde le rank</span><br />
    Regarde les personnes ayant un rank avec des filtres<br /><br />
    <form method="post" action="?recherche=ok">
        <b>Pseudo :</b><br />
        <select name="poste_rech" id="pays">
            <option value="">-- Choisis le rank --</option>
            <option value="2">VIP CLUB</option>
            <option value="3">STAFF CLUB</option>
            <option value="5">Modérateurs</option>
            <option value="6">Administrateurs</option>
            <option value="7">Managers</option>
            <option value="8">Fondateurs</option>
        </select>&nbsp;<input type="submit" name="submit" value="Rechercher" class="submit" />
    </form>
    <?PHP
    if (isset($_GET['recherche']) && $_GET['recherche'] == "ok") {
        $rank = Secu($_POST['poste_rech']);
        switch ($rank) {
            case '2':
                $modif = 'VIP CLUB';
                break;
            case '3':
                $modif = 'STAFF CLUB';
                break;
            case '5':
                $modif = 'Modérateur';
                break;
            case '6':
                $modif = 'Administrateur';
                break;
            case '7':
                $modif = 'Manager';
                break;
            case '8':
            case '9':
            case '10':
            case '11':
                $modif = 'Fondateur';
                break;
            default:
                $modif = '';
                break;
        }
        if (!empty($rank)) {
            $sqla = $bdd->query("SELECT * FROM users WHERE rank = '" . $rank . "'");
            $row = $sqla->rowCount();
        }
    }

    if ($row != '0') {
        if (isset($_POST['poste_rech'])) {
    ?>
            Recherche effectuée : <b><?PHP echo $modif; ?></b>
            <table>
                <tbody>
                    <tr class="haut">
                        <td class="haut">Pseudo</td>
                        <td class="haut">Dernière connexion</td>
                        <td class="haut">IP</td>
                        <td class="haut">Action</td>
                    </tr>
                    <?PHP
                    while ($r = $sqla->fetch()) {
                        $date = date('d/m/Y H:i', $r['last_online']);
                    ?>
                        <tr class="bas">
                            <td class="bas"><?PHP echo $r['username']; ?></td>
                            <td class="bas"><?PHP echo $date; ?></td>
                            <td class="bas"><?PHP echo $r['ip_current']; ?></td>
                            <td class="bas"><a href="#" onclick="insert_texte('<?PHP echo $r['username']; ?>;')">Ajouter</a></td>
                        </tr>
                    <?PHP } ?>
                </tbody>
            </table>
        <?PHP }
    } elseif ($row == '0') {
        if (isset($_POST['poste_rech'])) {
        ?>
            Recherche effectuée : <b><?PHP echo $modif; ?></b><br /><br />
            <i>Aucun utilisateur disponible au rank <?PHP echo $modif; ?></i>
    <?PHP }
    } ?>
</body>

</html>