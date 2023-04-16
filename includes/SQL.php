<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|           GabCMS - Site Web et Content Management System               #|
#|         Copyright © 2012-2014 - Gabodd Tout droits réservés.           #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

    $GabCMS_hote = 'sql.myhabbo.org'; # Le chemin vers le serveur
    $GabCMS_port = '3306'; # Ne pas toucher
    $GabCMS_nom_bd = 'bbstr'; # Le nom de votre base de données
    $GabCMS_utilisateur = 'bbstr'; # Nom d'utilisateur pour se connecter
    $GabCMS_mot_passe = 'Fg55dc8&2'; # Mot de passe de l'utilisateur pour se connecter
 
try {
$bdd = new PDO('mysql:host='.$GabCMS_hote.';port='.$GabCMS_port.';dbname='.$GabCMS_nom_bd.'', $GabCMS_utilisateur, $GabCMS_mot_passe);
} catch (PDOException $e) {
die('Erreur sur le fichier SQL.php : ' . $e->getMessage());
}
?>
