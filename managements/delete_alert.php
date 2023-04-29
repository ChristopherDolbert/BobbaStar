<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");

if (!isset($_SESSION['username']) || $user['rank'] < 8 || $user['rank'] > 11) {
    Redirect("" . $url . "/managements/access_neg");
    exit();
}

if (isset($_GET['do'])) {
    $do = Secu($_GET['do']);
    $t1 = $bdd->query("SELECT userid FROM gabcms_alertes WHERE id = '$do'")->fetch();
    $r1 = $bdd->query("SELECT pseudo FROM gabcms_demande WHERE number_alert = '$do'")->fetch();
    $assoc = $bdd->query("SELECT username FROM users WHERE id = '{$t1['userid']}'")->fetch(PDO::FETCH_ASSOC);
    $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo, action, date) VALUES (:pseudo, :action, :date)");
    $insertn1->execute(array(':pseudo' => $user['username'], ':action' => 'a validé la demande de suppression émise par <b>' . $r1['pseudo'] . '</b> et a supprimé une alerte de <b>' . $assoc['username'] . '</b> (ID : ' . $do . ')', ':date' => FullDate('full')));
    $insertn2 = $bdd->prepare("INSERT INTO gabcms_management (user_id, message, auteur, date, look) VALUES (:userid, :message, :auteur, :date, :look)");
    $insertn2->execute(array(':userid' => $t1['userid'], ':message' => 'Je viens de traiter la suppression d\'une de tes alertes émise par <b>' . $r1['pseudo'] . '</b>. Ton alerte a été supprimé, elle ne figure plus sur le site et la base de données. (n° de l\'alerte : ' . $do . ')', ':auteur' => $user['username'], ':date' => FullDate('full'), ':look' => $user['look']));
    $bdd->query("DELETE FROM gabcms_alertes WHERE id = '$do'");
    $bdd->query("DELETE FROM gabcms_demande WHERE number_alert = '$do'");
    echo '<h4 class="alert_success">Une alerte a été supprimée avec succès !</h4>';
} elseif (isset($_GET['do2'])) {
    $do2 = Secu($_GET['do2']);
    $alertQuery = "SELECT a.*, u.username FROM gabcms_alertes a JOIN users u ON a.userid = u.id WHERE a.id = :do2";
    $alertStmt = $bdd->prepare($alertQuery);
    $alertStmt->bindValue(':do2', $do2, PDO::PARAM_INT);
    $alertStmt->execute();
    $t2 = $alertStmt->fetch();

    $demandeQuery = "SELECT * FROM gabcms_demande WHERE number_alert = :do2";
    $demandeStmt = $bdd->prepare($demandeQuery);
    $demandeStmt->bindValue(':do2', $do2, PDO::PARAM_INT);
    $demandeStmt->execute();
    $r2 = $demandeStmt->fetch();

    $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
    $insertn1->bindValue(':pseudo', $user['username']);
    $insertn1->bindValue(':action', 'a refusé une demande de suppression émise par <b>' . $r2['pseudo'] . '</b> d\'une alerte de <b>' . $t2['username'] . '</b> (ID : ' . $do2 . ')');
    $insertn1->bindValue(':date', FullDate('full'));
    $insertn1->execute();

    $insertn2 = $bdd->prepare("INSERT INTO gabcms_management (user_id, message, auteur, date, look) VALUES (:userid, :message, :auteur, :date, :look)");
    $insertn2->bindValue(':userid', $t2['userid']);
    $insertn2->bindValue(':message', 'Je viens de traiter la suppression d\'une de tes alertes émise par <b>' . $r2['pseudo'] . '</b>. La demande a été refusée, l\'alerte reste dans ton compte. (n° de l\'alerte : ' . $do2 . ')');
    $insertn2->bindValue(':auteur', $user['username']);
    $insertn2->bindValue(':date', FullDate('full'));
    $insertn2->bindValue(':look', $user['look']);
    $insertn2->execute();

    $deleteDemandeQuery = "DELETE FROM gabcms_demande WHERE number_alert = :do2";
    $deleteDemandeStmt = $bdd->prepare($deleteDemandeQuery);
    $deleteDemandeStmt->bindValue(':do2', $do2, PDO::PARAM_INT);
    $deleteDemandeStmt->execute();

    echo '<h4 class="alert_success">La demande a bien été refusée.</h4>';
}
?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />

<body>
    <span id="titre">Supprimes une alerte</span><br />
    Supprimes une alerte sur une demande d'un(e) modérateur(trice) au minimum.<br /><br />
    <table>
        <tbody>
            <tr class="haut">
                <td class="haut">Pseudo</td>
                <td class="haut">Sujet</td>
                <td class="haut">Alerte</td>
                <td class="haut">Demandeur</td>
                <td class="haut">Action</td>
            </tr>
            <?PHP
            $sql = $bdd->query("SELECT * FROM gabcms_demande ORDER BY id DESC LIMIT 0,100");
            while ($a = $sql->fetch()) {
                $t = $bdd->query("SELECT * FROM gabcms_alertes WHERE id = '" . $a['number_alert'] . "'");
                $ta = $t->fetch();
                $zer2 = $bdd->query("SELECT username FROM users WHERE id = '" . $ta['userid'] . "'");
                $row2 = $zer2->rowCount();
                $assoc2 = $zer2->fetch(PDO::FETCH_ASSOC);
            ?>
                <tr class="bas">
                    <td class="bas"><?PHP echo $assoc2['username']; ?></td>
                    <td class="bas"><?PHP echo $ta['sujet']; ?></td>
                    <td class="bas"><?PHP echo stripslashes($ta['alerte']); ?></td>
                    <td class="bas"><?PHP echo $a['pseudo']; ?></td>
                    <td class="bas"><a href="?do2=<?PHP echo $a['number_alert']; ?>">Refusé la suppression</a> - <a href="?do=<?PHP echo $a['number_alert']; ?>">Supprimé</a></td>
                </tr>
            <?PHP } ?>
        </tbody>
    </table>
</body>

</html>