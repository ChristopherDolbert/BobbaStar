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
    $tdo1 = $bdd->query("SELECT userid FROM gabcms_alertes WHERE id = '$do'");
    $t1 = $tdo1->fetch();
    $zer = $bdd->query("SELECT username FROM users WHERE id = '" . $t1['userid'] . "'");
    $assoc = $zer->fetch(PDO::FETCH_ASSOC);
    if ($do) {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
        $insertn1->execute(array(':pseudo' => $user['username'], ':action' => 'a demandé la suppression d\'une alerte de <b>' . $assoc['username'] . '</b> (ID : ' . $do . ')', ':date' => FullDate('full')));
        $insertn2 = $bdd->prepare("INSERT INTO gabcms_management (user_id, message, auteur, date, look) VALUES (:userid, :message, :auteur, :date, :look)");
        $insertn2->execute(array(':userid' => $t1['userid'], ':message' => 'Je viens de demander la suppression d\'une de tes alertes. Une réponse de cette demande te sera transmise une fois traitée par un administrateur. (n° de l\'alerte : ' . $do . ')', ':auteur' => $user['username'], ':date' => FullDate('full'), ':look' => $user['look']));
        $bdd->query("INSERT INTO gabcms_demande (number_alert,pseudo,date) VALUES ('$do','{$user['username']}','" . FullDate('full') . "')");
        echo '<h4 class="alert_success">Ta demande de suppression a été prise en compte !</h4>';
    }
}

?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />

<body>
    <span id="titre">Demandes a effacer une alerte</span><br />
    Cette page te permet de demander une suppression d'une alerte.<br /><br />
    <table>
        <tbody>
            <tr class="haut">
                <td class="haut">ID</td>
                <td class="haut">Pseudo</td>
                <td class="haut">Sujet</td>
                <td class="haut">Message</td>
                <td class="haut">Action</td>
            </tr>
            <?php
            $sql = $bdd->query("SELECT a.id, a.sujet, a.alerte, a.userid, d.number_alert 
                    FROM gabcms_alertes a 
                    LEFT JOIN gabcms_demande d ON a.id = d.number_alert 
                    ORDER BY a.id DESC LIMIT 0,100");
            while ($a = $sql->fetch()) {
                $zer = $bdd->query("SELECT username FROM users WHERE id = '" . $a['userid'] . "'");
                $assoc = $zer->fetch(PDO::FETCH_ASSOC);
                $modif = "";
                if (empty($a['number_alert'])) {
                    $modif = '<a href="?do=' . $a['id'] . '">Demande de suppression</a>';
                } else {
                    $modif = '<img src="' . $url . '/managements/img/images/valide.gif" /> Demande déjà émise';
                }
            ?>
                <tr class="bas">
                    <td class="bas"><?PHP echo $a['id']; ?></td>
                    <td class="bas"><?PHP echo $assoc['username']; ?></td>
                    <td class="bas"><?PHP echo $a['sujet']; ?></td>
                    <td class="bas"><?PHP echo stripslashes($a['alerte']); ?></td>
                    <td class="bas"><?PHP echo $modif; ?></td>
                </tr>
            <?PHP } ?>

        </tbody>
    </table>
</body>

</html>