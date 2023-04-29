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
?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />

<body>
     <span id="titre">Affiches les images uploadés</span><br />
     Toutes les images hébergés sur le site sont inscrites ici.<br /><br />
     <table>
          <tbody>
               <tr class="haut">
                    <td class="haut">Image (et lien)</td>
                    <td class="haut">Hébergé par</td>
                    <td class="haut">Date</td>
                    <td class="haut">IP</td>
               </tr>
               
               <?php
               $messagesParPage = 8;
               $total = $bdd->query('SELECT COUNT(*) AS total FROM gabcms_upload')->fetchColumn();
               $nombreDePages = ceil($total / $messagesParPage);
               $pageActuelle = isset($_GET['page']) ? min(intval($_GET['page']), $nombreDePages) : 1;
               $premiereEntree = ($pageActuelle - 1) * $messagesParPage;
               $retour_messages = $bdd->query("SELECT * FROM gabcms_upload ORDER BY id DESC LIMIT $premiereEntree, $messagesParPage");
               foreach ($retour_messages as $a) {
               ?>
                    <tr class="bas">
                         <td class="bas"><a href="<?= $a['lien'] ?>" target="_blank"><img src="<?= $a['lien'] ?>" style="height:50px;width:50px;" /></a></td>
                         <td class="bas"><?= $a['par'] ?></td>
                         <td class="bas"><?= $a['date'] ?></td>
                         <td class="bas"><?= $a['ip'] ?></td>
                    </tr>
               <?php
               }

               echo '<p align="center">Page : ';
               for ($i = 1; $i <= $nombreDePages; $i++) {
                    if ($i == $pageActuelle) {
                         echo ' [ ' . $i . ' ] ';
                    } else {
                         echo ' <a href="aff_upload?page=' . $i . '">' . $i . '</a> ';
                    }
               }
               echo '</p>';
               ?>

          </tbody>
     </table>
</body>

</html>