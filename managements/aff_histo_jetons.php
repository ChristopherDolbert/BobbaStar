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

$id = Secu($_GET['id']);
?>
<title>Historique utilisation de codes jetons - Code #<?PHP echo $id; ?></title>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

<body>
    <span id="titre">Historique utilisation de codes jetons</span><br />
    Ici est affiché l'historique des utilisations de codes jetons, ainsi vous pouvez voir, qui à utiliser le plus de codes.<br /><br />
    <table>
        <tbody>
            <tr class="haut">
                <td class="haut">Pseudo</td>
                <td class="haut">Code utilisé</td>
                <td class="haut">Date</td>
            </tr>
            <?php
            $sql = $bdd->query("SELECT j.*, u.username FROM gabcms_jetons_logs j 
                    JOIN users u ON j.user_id = u.id
                    WHERE j.code_id = '" . $id . "' ORDER BY j.date DESC");

            while ($a = $sql->fetch(PDO::FETCH_ASSOC)) {
                $date = date('d/m/Y H:i:s', $a['date']);
            ?>
                <tr class="bas">
                    <td class="bas"><?php echo Secu($a['username']); ?></td>
                    <td class="bas"><?php echo Secu($a['code']); ?></td>
                    <td class="bas"><?php echo Secu($date); ?></td>
                </tr>
            <?php } ?>

        </tbody>
    </table>
</body>

</html>