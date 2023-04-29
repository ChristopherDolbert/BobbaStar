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

if (isset($_GET['do']) && $_GET['do'] === 'lookup') {
    $username = Secu($_POST['username']);
    $req = $bdd->prepare("SELECT * FROM users WHERE username = :username");
    $req->execute(['username' => $username]);
    $req_assoc = $req->fetch(PDO::FETCH_ASSOC);

    if ($req_assoc) {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo, action, date) VALUES (:pseudo, :action, :date)");
        $insertn1->execute([
            'pseudo' => $user['username'],
            'action' => 'a recherché l\'IP de <b>' . $req_assoc['username'] . '</b>',
            'date' => FullDate('full')
        ]);

        $ip = $req_assoc['ip_current'];
        echo '<h4 class="alert_success">L\'IP du compte <b>' . $req_assoc['username'] . '</b> à la dernière connexion est la suivante : <b>' . $ip . '</b></h4>';
    } else {
        echo '<h4 class="alert_error">Le compte n\'existe pas</h4>';
    }
}

?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />

<body>
    <span id="titre">Detection IP.</span><br />
    Cet outil peut &ecirc;tre utilisé pour la recherche de l'IP d'un utilisateur, particuli&egrave;rement utilisé lorsque vous avez besoin d'exclure une personne d'ordinateur plut&ocirc;t qu'un simple compte. <a href="banip" target="main">Bannir une IP</a><br /><br />
    <form method='post' action="?do=lookup">
        Pseudo:<br />
        <input type="text" name="username" maxlength="50"><br /><br />
        <input type="submit" value="Rechercher">
    </form>
</body>

</html>