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

<body></body>
<span id="titre">Info utilisateur</span><br />
Entres le nom de l'utilisateur pour afficher ses infos<br /><br />
<form method='post' action="?do=lookup">
    Pseudo :<br />
    <input type="text" name="username" maxlength="50">&nbsp;
    <input type="submit" value="Rechercher">
</form>
</tr>

<?PHP
if (isset($_GET['do']) && $_GET['do'] === "lookup") {
    $req = $bdd->prepare("SELECT * FROM users WHERE username = ?");
    $req->execute([$_POST['username']]);
    $user = $req->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
        $insertn1->execute([
            ':pseudo' => $user['username'],
            ':action' => 'a recherché des infos sur <b>' . $user['username'] . '</b>',
            ':date' => FullDate('full')
        ]);

        $modifier_gender = ($user['gender'] === 'F') ? "<span style=\"color: #FF6699;\">" : "<span style=\"color: #0000ff;\">";
        $modifier_disabled = ($user['disabled']) ? "<span style=\"color: #ff0000;\">désactivé</span>" : "<span style=\"color: #008000;\">activé</span>";

        echo 'Son pseudo : ' . $modifier_gender . '<b>' . $user['username'] . '</b></span> <br/>
            Son ID : ' . $modifier_gender . '<b>' . $user['id'] . '</b> </span><br/>
            Son IP : ' . $modifier_gender . '<b>' . $user['ip_current'] . '</b> </span><br/>
            Jetons au total : ' . $modifier_gender . '<b>' . $user['jetons'] . '</b> </span><br/>
            Dernière connexion : ' . $modifier_gender . '<b>' . date('d/m/Y H:i:s', $user['last_online']) . '</b> </span><br/>
            Sa phrase perso : ' . $modifier_gender . '<b>' . $user['motto'] . '</b> </span><br/>
            Son look : ' . $modifier_gender . '<b>' . $user['look'] . '</b> </span><br/>
            Ce compte est <b>' . $modifier_disabled . '</b><br/>
            Son adresse Email: ' . $modifier_gender . '<b>' . $user['mail'] . '</b> </span><br/>
            Son rank : ' . $modifier_gender . '<b>' . $user['rank'] . '</b></span> <br/>
            <br/><br/><a href="' . $url . '/managements/act_users?modif=' . $user['id'] . '">Modifier ses informations</a><br/><br/>
            Légende : <span style="color: #FF6699;">rose</span> = fille, <span style="color: #0000ff;">bleu</span> = garçon.';
    } else {
        echo '<h4 class="alert_error">Le compte n\'existe pas</h4>';
    }
}

?>
</body>

</html>