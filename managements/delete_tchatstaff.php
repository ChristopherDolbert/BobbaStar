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
    $tchat_type = 'staff';
    $tchat_type_text = 'tchat des staffs';

    $tchat = $bdd->query("SELECT * FROM gabcms_tchat_{$tchat_type} WHERE id = '{$do}'")->fetch();
    $bdd->query("UPDATE gabcms_tchat_{$tchat_type} SET message='<span style=\"color:#B5B5B5;\"><i>Ce message a été modéré par un modérateur.</i></span>' WHERE id = '{$do}'");

    $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
    $insertn1->execute(array(
        ':pseudo' => $user['username'],
        ':action' => "a modéré un <b>tchat</b> de <b>{$tchat['pseudo']}</b> sur le {$tchat_type_text}",
        ':date' => FullDate('full')
    ));

    echo '<h4 class="alert_success">Un tchat a été modéré avec succès !</h4>';
}

if (isset($_GET['sup'])) {
    $sup = Secu($_GET['sup']);
    $tchat_type = 'staff';
    $tchat_type_text = 'tchat des staffs';

    $tchat = $bdd->query("SELECT * FROM gabcms_tchat_{$tchat_type} WHERE id = '{$sup}'")->fetch();
    $bdd->query("DELETE FROM gabcms_tchat_{$tchat_type} WHERE id = '{$sup}'");

    $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
    $insertn1->execute(array(
        ':pseudo' => $user['username'],
        ':action' => "a supprimé un <b>tchat</b> de <b>{$tchat['pseudo']}</b> sur le {$tchat_type_text}",
        ':date' => FullDate('full')
    ));

    echo '<h4 class="alert_success">Un tchat a été supprimé avec succès !</h4>';
}

?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />

<body>
    <span id="titre">Modères un tchat</span><br />
    Modères un tchat qui a été posté sur le stafftchat du rétro.<br /><br />
    <table>
        <tbody>
            <tr class="haut">
                <td class="haut">Pseudo</td>
                <td class="haut">Date</td>
                <td class="haut">Message</td>
                <td class="haut">IP</td>
                <td class="haut">Action</td>
            </tr>
            <?PHP $sql = $bdd->query("SELECT * FROM gabcms_tchat_staff WHERE pseudo != '' AND message != '<span style=\"color:#B5B5B5;\"><i>Ce message a été modéré par un modérateur.</i></span>' ORDER BY id DESC LIMIT 0,25");
            while ($a = $sql->fetch()) {
            ?>
                <tr class="bas">
                    <td class="bas"><?PHP echo $a['pseudo']; ?></td>
                    <td class="bas"><?PHP echo $a['date']; ?></td>
                    <td class="bas"><?PHP echo $a['message']; ?></td>
                    <td class="bas"><?PHP echo $a['ip']; ?></td>
                    <td class="bas"><a href="?do=<?PHP echo $a['id']; ?>">Modérer</a> - <a href="?sup=<?PHP echo $a['id']; ?>">Supprimer</a></td>
                </tr>
            <?PHP } ?>
        </tbody>
    </table>
</body>

</html>