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
?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />

<body>
     <span id="titre">Logs des staffs</span><br />
     Toutes les actions des staffs sont marquées ici.<br /><br />
     <?php
     $messagesParPage = 35;
     $total = $bdd->query('SELECT COUNT(*) AS total FROM gabcms_stafflog')->fetchColumn();
     $nombreDePages = ceil($total / $messagesParPage);
     $pageActuelle = isset($_GET['page']) ? min(intval($_GET['page']), $nombreDePages) : 1;
     $premiereEntree = ($pageActuelle - 1) * $messagesParPage;
     $retour_messages = $bdd->query("SELECT * FROM gabcms_stafflog ORDER BY id DESC LIMIT $premiereEntree, $messagesParPage");

     while ($donnees_messages = $retour_messages->fetch(PDO::FETCH_ASSOC)) {
     ?>
          <td><span style="color:#008000;"><?= Secu($donnees_messages['date']); ?></span> <b><?= Secu($donnees_messages['pseudo']); ?></b> <?= stripslashes($donnees_messages['action']); ?></td><br />
     <?php
     }

     echo '<p align="center">Page : ';
     for ($i = 1; $i <= $nombreDePages; $i++) {
          echo $i == $pageActuelle ? " [ $i ] " : " <a href=\"logs?page=$i\">$i</a> ";
     }
     echo '</p>';
     ?>


</body>

</html>