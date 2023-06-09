<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");

if (!isset($_SESSION['username']) || $user['rank'] < 6 || $user['rank'] > 11) {
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

if (isset($_GET['modif'])) {
    $modif = Secu($_GET['modif']);
}

if (isset($_GET['modifiernews'])) {
    $modifiernews = Secu($_GET['modifiernews']);
    if (isset($_POST['titre']) || isset($_POST['desc']) || isset($_POST['image'])) {
        $titre = Secu($_POST['titre']);
        $desc = Secu($_POST['desc']);
        $image = Secu($_POST['image']);
        $sql_mo = $bdd->prepare("SELECT * FROM gabcms_news WHERE id = ?");
        $sql_mo->execute([$modifiernews]);
        $mod_t = $sql_mo->fetch();
        if ($titre != "" && $desc != "" && $image != "") {
            $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a modifié un événement sans lien <b>(' . $mod_t['title'] . ')</b>');
            $insertn1->bindValue(':date', FullDate('full'));
            $insertn1->execute();
            $stmt = $bdd->prepare("UPDATE gabcms_news SET topstory_image = ?, title = ?, snippet = ?, modifier = '1', modif_date = ?, modif_auteur = ?, look = ? WHERE id = ?");
            $stmt->execute([$image, $titre, $desc, $nowtime, $user['username'], $user['look'], $modifiernews]);
            echo '<h4 class="alert_success">L\'événement vient d\'&ecirc;tre modifié.</h4>';
        } else {
            echo '<h4 class="alert_error">Merci de remplir les champs vide</h4>';
        }
    }
}

if (isset($_GET['do'])) {
    $do = Secu($_GET['do']);
    $sql_do = $bdd->prepare("SELECT * FROM gabcms_news WHERE id = ?");
    $sql_do->execute([$do]);
    $mod_do = $sql_do->fetch();
    $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
    $insertn1->bindValue(':pseudo', $user['username']);
    $insertn1->bindValue(':action', 'a supprimé un événement sans lien <b>(' . addslashes($mod_do['title']) . ')</b>');
    $insertn1->bindValue(':date', FullDate('full'));
    $insertn1->execute();
    $stmt2 = $bdd->prepare"DELETE FROM gabcms_news_recommande WHERE news_id = ?");
    $stmt2->execute([$do]);
    $stmt3 = $bdd->prepare("DELETE FROM gabcms_news WHERE id = ?");
    $stmt3->execute([$do]);
    echo '<h4 class="alert_success">L\'événement vient d\'&ecirc;tre supprimé.</h4>';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="editeur_html/ckeditor/ckeditor.js"></script>
</head>

<body>
    <?php if (!isset($_GET['modif'])) { ?>
        <span id="titre">Actions sur des événements</span><br />
        Choisis l'événement sans lien que tu désires modifier ou supprimer.
        <br /><br />
        <table>
            <tbody>
                <tr class="haut">
                    <td class="haut">Titre de l'événement</td>
                    <td class="haut">Description</td>
                    <td class="haut">Créer par</td>
                    <td class="haut">Date</td>
                    <td class="haut">Actions</td>
                </tr>
                <?php
                $sql = $bdd->query("SELECT * FROM gabcms_news WHERE event = '0' ORDER BY id DESC LIMIT 0,100");
                while ($a = $sql->fetch()) {
                    $date_but = date('d/m/Y à H:i', $a['date']);
                ?>
                    <tr class="bas">
                        <td class="bas"><?PHP echo stripslashes($a['title']); ?></td>
                        <td class="bas"><?PHP echo stripslashes($a['snippet']); ?></td>
                        <td class="bas"><?PHP echo $a['auteur']; ?></td>
                        <td class="bas"><?PHP echo $date_but; ?></td>
                        <td class="bas"><a href="?modif=<?PHP echo $a['id']; ?>">Modifier</a> - <a href="?do=<?PHP echo $a['id']; ?>" onclick="return confirm(\'Êtes-vous certain de supprimer cet événement ?\')">Supprimer</a></td>
                    </tr>
                <?PHP } ?>
            </tbody>
        </table>
    <?php
    }
    ?>
    <?php if (isset($_GET['modif'])) {
        $sql_modif = $bdd->prepare("SELECT * FROM gabcms_news WHERE id = ?");
        $sql_modif->execute([$modif]);
        $modif_a = $sql_modif->fetch();
    ?>
        <span id="titre">Modification de l'article.</span><br \>
        <form name='editor' method='post' action="?modifiernews=<?php echo $modif; ?>">
            <td width='100' class='tbl'><b>Titre de ton article :</b><br /></td>
            <td width='80%' class='tbl'><input type='text' name='titre' value="<?php echo stripslashes($modif_a['title']); ?>" class='text' style='width: 240px'><br /></td>
            <br />
            <td width='100' class='tbl'><b>Description :</b><br /></td>
            <td width='80%' class='tbl'><textarea name="desc" rows="5" cols="50"><?php echo stripslashes($modif_a['snippet']); ?></textarea>
                <br />
            <td width='100' class='tbl'><b>Image que tu afficheras : <a href="<?PHP echo $url; ?>/articles_topstory" target="_blank">Images pour les news</a> </b><br /></td>
            <td width='80%' class='tbl'><input type='text' name='image' value="<?php echo $modif_a['topstory_image']; ?>" class='text' style='width: 240px'><br /></td>
            <br />
            <input type='submit' name='submit' value='Modifier'>
        </form>
    <?php
    }
    ?>
</body>

</html>