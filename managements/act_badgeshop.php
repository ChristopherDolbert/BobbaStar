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

if (isset($_GET['modif'])) {
    $modif = Secu($_GET['modif']);
}

if (isset($_GET['do']) && $_GET['do'] === 'cree') {
    $badge_id = Secu($_POST['badge_id'] ?? '');
    $nom_badge = Secu($_POST['nom_badge'] ?? '');
    $stock = Secu($_POST['stock'] ?? '');
    $prix = $_POST['prix'] ?? '';

    if (!empty($badge_id) && !empty($nom_badge) && is_numeric($stock) && is_numeric($prix)) {
        $insertn2 = $bdd->prepare("INSERT INTO gabcms_shopbadge (badge_id, nom_badge, stock, prix, par) VALUES (:id, :nom, :stock, :prix, :par)");
        $insertn2->execute(array(
            ':id' => $badge_id,
            ':nom' => $nom_badge,
            ':stock' => $stock,
            ':prix' => $prix,
            ':par' => $user['username']
        ));

        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
        $insertn1->execute(array(
            ':pseudo' => $user['username'],
            ':action' => 'a mis le badge <b>' . $badge_id . '</b> en vente limité <b>(' . $stock . ' en stock)</b> sur la boutique du site',
            ':date' => FullDate('full')
        ));

        echo '<h4 class="alert_success">Le badge <b>' . $badge_id . '</b> vient d\'&ecirc;tre ajouté sur la page de vente</h4>';
    } else {
        echo '<h4 class="alert_error">Merci de remplir les champs vides avec des valeurs valides</h4>';
    }
}

if (isset($_GET['modifierrecrut'])) {
    $modifierrecrut = Secu($_GET['modifierrecrut']);
    $badge_id = Secu($_POST['badge_id'] ?? '');
    $nom_badge = Secu($_POST['nom_badge'] ?? '');
    $stock = Secu($_POST['stock'] ?? '');
    $prix = Secu($_POST['prix'] ?? '');
    if ($badge_id != "" && $nom_badge != "" && $stock != "0" && $stock != "" && $prix != "") {
        if (is_numeric($stock) && is_numeric($prix)) {
            $bdd->query("UPDATE gabcms_shopbadge SET badge_id='" . $badge_id . "', nom_badge='" . $nom_badge . "', stock='" . $stock . "', prix='" . $prix . "' WHERE id = '" . $modifierrecrut . "'");
            $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->execute([':pseudo' => $user['username'], ':action' => 'a modifié le badge <b>(' . $badge_id . ')</b> en vente limité <b>(' . $stock . ' en stock)</b> sur la boutique du site', ':date' => FullDate('full')]);
            echo '<h4 class="alert_success">Le badge a bien été modifié.</h4>';
        } else {
            echo '<h4 class="alert_error">Le prix et le stock doivent contenir des chiffres.</h4>';
        }
    } else {
        echo '<h4 class="alert_error">Merci de remplir tous les champs.</h4>';
    }
}

if (isset($_GET['sup'])) {
    $sup = Secu($_GET['sup']);
    $sql = $bdd->query("SELECT badge_id FROM gabcms_shopbadge WHERE id = '$sup'");
    $badge_id = $sql->fetch(PDO::FETCH_COLUMN);
    $bdd->query("DELETE FROM gabcms_shopbadge WHERE id = '$sup'");
    echo '<h4 class="alert_success">Le badge ' . $badge_id . ' n\'est plus visible sur l\'interface de la boutique.</h4>';
    $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
    $insertn1->execute(array(':pseudo' => $user['username'], ':action' => 'a supprimé un badge qui était en vente <b>(' . $badge_id . ')</b>', ':date' => FullDate('full')));
}

?>
<div id="tooltip"></div>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />

<body>
    <script src="<?PHP echo $imagepath; ?>js/tooltip.js" type="text/javascript"></script>
    <?php if (!isset($_GET['modif'])) { ?>
        <span id="titre">Mets un badge à la vente</span><br />
        Mets un badge en vente sur le site ayant un stock bien défini.
        <br /><br />
        <form name='editor' method='post' action="?do=cree">
            <td width='100' class='tbl'><b>ID du badge :</b><br /></td>
            <td width='80%' class='tbl'><input type='text' placeholder='Exemple : ZZZ, MRG01...' name='badge_id' value='' class='text' style='width: 240px' maxlength="20"><br /></td>
            <td width='100' class='tbl'><b>Nom du badge :</b><br /></td>
            <td width='80%' class='tbl'><input type='text' placeholder='Exemple : Badge ZZZ...' name='nom_badge' value='' class='text' style='width: 240px' maxlength="500"><br /></td>
            <td width='100' class='tbl'><b>Stock disponible à la vente :</b><br /></td>
            <td width='80%' class='tbl'><input type='text' placeholder='Par exemple, 50 ventes disponibles' name='stock' value='' class='text' style='width: 240px' maxlength="20"></textarea><br /></td>
            <td width='100' class='tbl'><b>Prix du badge :</b><br /></td>
            <td width='80%' class='tbl'><img src="<?PHP echo $imagepath; ?>v2/images/newcredits/purse_coin.png" align="left" /><input type='text' placeholder='Généralement 5 jetons' name='prix' value='' class='text' style='width: 150px' maxlength="5"><br /></td>
            <br />
            <td align='center' colspan='2' class='tbl'>
                <input type='submit' name='submit' value='Exécuter' class='submit'>
        </form>
        <hr />
        <span id="titre">Actions sur une vente</span><br />
        Choisis le badge que tu veux modifier ou supprimer.
        <div class="content">
            <br />
            <table>
                <tbody>
                    <tr class="haut">
                        <td class="haut">Image</td>
                        <td class="haut">Nom d'affichage</td>
                        <td class="haut">Code</td>
                        <td class="haut">Stock</td>
                        <td class="haut">Prix</td>
                        <td class="haut">Enregistré par</td>
                        <td class="haut">Actions</td>
                    </tr>
                    <?php $sql = $bdd->query("SELECT * FROM gabcms_shopbadge ORDER BY stock DESC");
                    while ($a = $sql->fetch()) {
                        if ($a['stock'] <= "3") {
                            $modifa = "#FF0000";
                        }
                        if ($a['stock'] > "3" && $a['stock'] < "5") {
                            $modifa = "#FF4500";
                        }
                        if ($a['stock'] >= "5" && $a['stock'] < "10") {
                            $modifa = "#FFA500";
                        }
                        if ($a['stock'] >= "10" && $a['stock'] < "15") {
                            $modifa = "#FFCC00";
                        }
                        if ($a['stock'] >= "15") {
                            $modifa = "#008000";
                        }
                    ?>
                        <tr class="bas">
                            <td class="bas"><img src="<?PHP echo $swf_badge;
                                                        echo $a['badge_id']; ?>.gif" title="<?PHP echo $a['badge_id']; ?>" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" /></td>
                            <td class="bas"><?PHP echo $a['nom_badge']; ?></td>
                            <td class="bas"><?PHP echo $a['badge_id']; ?></td>
                            <td class="bas"><span style="color:<?PHP echo $modifa; ?>;"><?PHP echo $a['stock']; ?></span></td>
                            <td class="bas"><?PHP echo $a['prix']; ?></td>
                            <td class="bas"><?PHP echo $a['par']; ?></td>
                            <td class="bas"><a href="?modif=<?PHP echo $a['id']; ?>">Modifier</a> - <a href="?sup=<?PHP echo $a['id']; ?>" onclick="return confirm('Es-tu certain de supprimer ce badge qui est en vente ?')">Supprimer</a></td>
                        </tr>
                    <?PHP } ?>
                </tbody>
            </table>
        </div>
    <?PHP }
    if (isset($_GET['modif'])) {
        $sql_modif = $bdd->query("SELECT * FROM gabcms_shopbadge WHERE id = '" . $modif . "'");
        $modif_a = $sql_modif->fetch();
    ?>
        <span id="titre">Modifies une vente</span><br />
        Modifies ici une vente dans le badge shop du site.
        <form name='editor' method='post' action="?modifierrecrut=<?php echo $modif; ?>">
            <br /><img src="<?PHP echo $swf_badge;
                            echo $modif_a['badge_id']; ?>.gif" align="left" />
            <td width='100' class='tbl'><b>ID du badge :</b><br /></td>
            <td width='80%' class='tbl'><input type="text" name="badge_id" value="<?php echo $modif_a['badge_id']; ?>" class="text" style="width: 240px" /><br /></td>
            <td width='100' class='tbl'><b>Nom d'affichage :</b><br /></td>
            <td width='80%' class='tbl'><input type="text" name="nom_badge" value="<?php echo $modif_a['nom_badge']; ?>" class="text" style="width: 240px" /><br /></td>
            <td width='100' class='tbl'><b>Stock :</b><br /></td>
            <td width='80%' class='tbl'><input type="text" name="stock" value="<?php echo $modif_a['stock']; ?>" class="text" style="width: 50px" /><br /></td>
            <td width='100' class='tbl'><b>Prix :</b><br /></td>
            <td width='80%' class='tbl'><img src="<?PHP echo $imagepath; ?>v2/images/newcredits/purse_coin.png" align="left" /><input type="text" name="prix" value="<?php echo $modif_a['prix']; ?>" class="text" style="width: 50px" /><br /><br /></td>
            <input type='submit' name='submit' value='Modifier'>
            </div>
        </form>
    <?PHP } ?>
</body>

</html>