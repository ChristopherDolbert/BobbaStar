<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

$GabCMS_hote = 'sql.myhabbo.org'; # Le chemin vers le serveur
$GabCMS_port = '3306'; # Ne pas toucher
$GabCMS_nom_bd = 'bbstrnt'; # Le nom de votre base de données
$GabCMS_utilisateur = 'bbstrnt'; # Nom d'utilisateur pour se connecter
$GabCMS_mot_passe = 'Ae!71o79e'; # Mot de passe de l'utilisateur pour se connecter

try {
    $bdd = new PDO('mysql:host='.$GabCMS_hote.';port='.$GabCMS_port.';dbname='.$GabCMS_nom_bd.'', $GabCMS_utilisateur, $GabCMS_mot_passe);
} catch (PDOException $e) {
    die('Erreur sur le fichier SQL.php : ' . $e->getMessage());
}

