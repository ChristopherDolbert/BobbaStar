<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");

if (!isset($_SESSION['username']) || $user['rank'] < 9 || $user['rank'] > 11) {
    Redirect("" . $url . "/managements/access_neg");
    exit();
}
?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />

<body>
    <span id="titre">Transactions des utilisateurs</span><br />
    Regardes les transactions des utilisateurs que tu souhaites.<br /><br />
    <form method='post' action="?do=lookup">
        <b>Pseudo :</b><br />
        <input type="text" name="username" maxlength="50"><br />
        <input type="submit" value="Rechercher">
    </form>
    <table>
        <tbody>
            <tr class="haut">
                <td class="haut">Produit</td>
                <td class="haut">Prix</td>
                <td class="haut">Date</td>
            </tr>
            <?php
            if (isset($_GET['do']) && $_GET['do'] == "lookup") {
                $username = Secu($_POST['username']);
                $req = $bdd->prepare("SELECT * FROM users WHERE username = ?");
                $req->execute([$username]);
                $row = $req->rowCount();
                $req_assoc = $req->fetch(PDO::FETCH_ASSOC);
                if ($row > 0) {
                    $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
                    $insertn1->execute([':pseudo' => $user['username'], ':action' => 'a regardé les transactions de <b>' . $req_assoc['username'] . '</b>', ':date' => FullDate('full')]);
                    echo 'Tu viens d\'effectuer une recherche sur <b>' . $req_assoc['username'] . '</b>';
                    $transac = $bdd->prepare("SELECT * FROM gabcms_transaction WHERE user_id = ? ORDER BY id DESC");
                    $transac->execute([$req_assoc['id']]);
                    while ($t = $transac->fetch(PDO::FETCH_ASSOC)) {
                        $modif_color = ($t['gain'] == '+') ? 'green' : 'red';
            ?>
                        <tr class="bas">
                            <td class="bas"><?= $t['produit'] ?></td>
                            <td class="bas"><span style="color:<?= $modif_color ?>"><b><?= $t['gain'] . $t['prix'] ?></b></span></td>
                            <td class="bas"><?= $t['date'] ?></td>
                        </tr>
            <?php
                    }
                } else {
                    echo '<h4 class="alert_error">Le pseudo n\'existe pas</h4>';
                }
            }
            ?>

        </tbody>
    </table>
</body>

</html>