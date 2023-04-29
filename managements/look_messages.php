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

if (isset($_GET['do']) && $_GET['do'] === 'lookmes' && isset($_POST['username'])) {
    $username = Secu($_POST['username']);
    $req = $bdd->prepare("SELECT message FROM users WHERE username = :username");
    $req->bindValue(':username', $username);
    $req->execute();
    $message = $req->fetchColumn();
    if ($message !== false) {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo, action, date) VALUES (:pseudo, :action, :date)");
        $insertn1->bindValue(':pseudo', $user['username']);
        $insertn1->bindValue(':action', "a recherché le nombre de messages que <b>$username</b> peut poster sur le tchat");
        $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute();
        echo "<h4 class='alert_success'><b>$username</b> a <b>$message</b> message(s) à utiliser.</h4>";
    } else {
        echo "<h4 class='alert_error'>Le compte $username n'existe pas.</h4>";
    }
}

?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />

<body>
    <span id="titre">Info messages</span><br />
    Cet outil est fait pour savoir combien l'utilisateur a de message(s).<br /><br />
    <form method='post' action="?do=lookmes">
        <b>Pseudo:</b><br />
        <input type="text" name="username" maxlength="50"><br /><br />
        <input type="submit" value="Rechercher">
    </form>
</body>

</html>