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

if (isset($_GET['do']) && $_GET['do'] == 'ajouter' && isset($_POST['club'], $_POST['badge_id'])) {
    $club = Secu($_POST['club']);
    $badge_id = Secu($_POST['badge_id']);
    if ($club == '1') {
        $modif_club = 'VIP Club';
    } elseif ($club == '2') {
        $modif_club = 'STAFF Club';
    }
    if (!empty($badge_id) && !empty($club)) {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
        $insertn1->execute(array(
            ':pseudo' => $user['username'],
            ':action' => 'a ajouté un badge pour le <b>' . $modif_club . '</b> (' . $badge_id . ')',
            ':date' => FullDate('full')
        ));
        $insertn2 = $bdd->prepare("INSERT INTO gabcms_config_badges (club, badge_id, date, pseudo, ip) VALUES (:club, :badge, :date, :pseudo, :ip)");
        $insertn2->execute(array(
            ':club' => $club,
            ':badge' => $badge_id,
            ':date' => FullDate('full'),
            ':pseudo' => $user['username'],
            ':ip' => $user['ip_current']
        ));
        echo '<h4 class="alert_success">Tu viens d\'ajouter le badge <b>' . $badge_id . '</b> pour les adhérants au <b>' . $modif_club . '</b></h4>';
    } else {
        echo '<h4 class="alert_error">Merci de remplir tous les champs vides.</h4>';
    }
}


if (isset($_GET['sup'])) {
    $sup = Secu($_GET['sup']);
    $info = $bdd->query("SELECT * FROM gabcms_config_badges WHERE id = '" . $sup . "'");
    $i = $info->fetch(PDO::FETCH_ASSOC);
    $modifier_club = ($i['club'] == '1') ? 'VIP Club' : 'STAFF Club';
    if ($sup != "" && $i) {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
        $insertn1->bindValue(':pseudo', $user['username']);
        $insertn1->bindValue(':action', 'a supprimé un badge qui était pour le <b>' . $modifier_club . '</b> (' . $i['badge_id'] . ')');
        $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute();
        $bdd->query("DELETE FROM gabcms_config_badges WHERE id = '" . $sup . "'");
        echo '<h4 class="alert_success">Tu viens de supprimer le badge <b>' . $i['badge_id'] . '</b> qui était pour les adhérants au <b>' . $modifier_club . '</b></h4>';
    } else {
        echo '<h4 class="alert_error">Le badge que vous voulez supprimer n\'existe pas.</h4>';
    }
}

?>

<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />

<body>
    <span id="titre">Badges pour les clubs</span><br />
    Ajoute, modifie ou supprime un badge qui devrait être donné pour un club.
    <br /><br />
    <script type="text/javascript" src="editeur_html/jscripts/tiny_mce/tiny_mce.js"></script>
    <form name='editor' method='post' action="?do=ajouter">
        <b>ID du badge qui sera donné :</b><br />
        <input type="text" placeholder="Exemple : Badge MRG01..." name="badge_id" value="" class="text" size="25" maxlength="25"><br /><br />
        <b>Club pour le quel le badge sera donné :</b><br />
        <select name="club" id="lenght" class="select">
            <option value="">-- Choisis ton club --</option>
            <option value="1">VIP Club</option>
            <option value="2">STAFF Club</option>
        </select><br /><br />
        <input type='submit' name='submit' value='Ajouter' class='submit'>
    </form>
    <hr />
    <table>
        <tbody>
            <tr class="haut">
                <td class="haut">Badge ID</td>
                <td class="haut">Club</td>
                <td class="haut">Créer par</td>
                <td class="haut">Date</td>
                <td class="haut">IP</td>
                <td class="haut">Actions</td>
            </tr>
            <?php
            $i = 0;
            $sql = $bdd->query("SELECT * FROM gabcms_config_badges ORDER BY club DESC");
            while ($a = $sql->fetch()) {
                if ($a['club'] == '1') {
                    $modifier_club = 'VIP Club';
                }
                if ($a['club'] == '2') {
                    $modifier_club = 'STAFF Club';
                }
            ?>
                <tr class="bas">
                    <td class="bas"><img src="<?PHP echo $swf_badge;
                                                echo Secu($a['badge_id']); ?>.gif" /><br />(<?PHP echo Secu($a['badge_id']); ?>)</td>
                    <td class="bas"><?PHP echo $modifier_club; ?></td>
                    <td class="bas"><?PHP echo Secu($a['pseudo']); ?></td>
                    <td class="bas"><?PHP echo Secu($a['date']); ?></td>
                    <td class="bas"><?PHP echo Secu($a['ip']); ?></td>
                    <td class="bas"><a href="?sup=<?PHP echo Secu($a['id']); ?>" onclick="return confirm(\'Êtes-vous certain de supprimer ce badge ?\')">Supprimer</a></td>
                </tr>
            <?PHP } ?>
        </tbody>
    </table>
</body>

</html>