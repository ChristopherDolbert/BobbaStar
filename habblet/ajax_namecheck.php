<?php
/*===================================================+
|| # HoloCMS - Website and Content Management System
|+===================================================+
|| # Copyright � 2008 Meth0d. All rights reserved.
|| # http://www.meth0d.org
|+===================================================+
|| # HoloCMS is provided "as is" and comes without
|| # warrenty of any kind. HoloCMS is free software!
|+===================================================*/

include("../config.php");

$name = Secu($_POST['name']);
$filter = preg_replace("/[^a-z\d\-=\?!@:\.]/i", "", $name);

$sql = $bdd->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
$sql->execute([$name]);
$tmp = $sql->fetch(PDO::FETCH_ASSOC);

if ($tmp > 0) {
    header("X-JSON: {\"registration_name\":\"Désolé, mais ce nom d'utilisateur est déjà utilisé. Veuillez en choisir un autre.\"}");
} elseif ($filter !== $name) {
    header("X-JSON: {\"registration_name\":\"Désolé, mais ce nom d'utilisateur contient des caractères non valides.\"}");
} elseif (strlen($name) > 24) {
    header("X-JSON: {\"registration_name\":\"Désolé, mais ce nom d'utilisateur est trop long.\"}");
} elseif (strlen($name) < 3) {
    header("X-JSON: {\"registration_name\":\"Veuillez saisir un nom d'utilisateur.\"}");
} elseif (strpos($name, "MOD-") === 0) {
    header("X-JSON: {\"registration_name\":\"Ce nom n'est pas autorisé.\"}");
} else {
    header("X-JSON: {}");
}

