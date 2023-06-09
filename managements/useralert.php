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

if (isset($_POST['username'], $_POST['alerte']) && !empty($_POST['username']) && !empty($_POST['alerte'])) {
    $username = Secu($_POST['username']);
    $sujet = Secu($_POST['sujet']);
    $act = Secu($_POST['act']);
    $sql = $bdd->prepare("SELECT id FROM users WHERE username = ?");
    $sql->execute([$username]);
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    if ($row['id'] < 1) {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
        $insertn1->execute([':pseudo' => $user['username'], ':action' => 'a envoyé une alerte à <b>' . $username . '</b>', ':date' => FullDate('full')]);

        $insertn2 = $bdd->prepare("INSERT INTO gabcms_management (user_id, message, auteur, date, look) VALUES (:userid, :message, :auteur, :date, :look)");
        $insertn2->execute([':userid' => $row['id'], ':message' => 'Nous venons de t\'envoyer une alerte ! Merci d\'aller la lire au <b>PLUS VITE</b> en <a href="' . $url . '/alerts">cliquant ici</a> !', ':auteur' => $user['username'], ':date' => FullDate('full'), ':look' => $user['look']]);

        $insertn3 = $bdd->prepare("INSERT INTO gabcms_alertes (userid, sujet, alerte, par, date, look, action) VALUES (:id, :sujet, :alerte, :par, :date, :look, :act)");
        $insertn3->execute([':id' => $row['id'], ':sujet' => $sujet, ':alerte' => addslashes($_POST['alerte']), ':par' => $user['username'], ':date' => FullDate('full'), ':look' => $user['look'], ':act' => $act]);

        echo '<h4 class="alert_success">L\'alerte a été envoyée avec succès !</h4>';
    } else {
        echo '<h4 class="alert_error">Merci de remplir les champs vides</h4>';
    }
}

?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />

<body>
    <script language="javascript" type="text/javascript">
        function insert_texte(texte) {
            var ou = document.getElementsByName("alerte")[0];
            var phrase = texte + " ";
            ou.value += phrase;
            ou.focus();
        }
    </script>
    <span id="titre">Envoyes une alerte</span><br />
    Envoyes une alerte à un utilisateur que tu souhaites.
    <br />
    <br />
    <form method="post" action="?do=givebadge">
        <td width='100' class='tbl'><b>Pseudo :</b><br /></td>
        <td width='80%' class='tbl'><input type='text' name='username' value='' class='text' style='width: 240px' maxlength="50"><br /></td><br />
        <td width='100' class='tbl'><b>Sujet :</b><br /></td>
        <td width='80%' class='tbl'><input type='text' name='sujet' value='' class='text' style='width: 240px' maxlength="500"><br /></td> <br />
        <td width='100' class='tbl'><b>Alerte :</b><br /></td>
        <a href="#" onclick="insert_texte('<b> </b>')"><img src="<?PHP echo $imagepath; ?>smileys/gras.png" /></a>
        <a href="#" onclick="insert_texte('<i> </i>')"><img src="<?PHP echo $imagepath; ?>smileys/italique.png" /></a>
        <a href="#" onclick="insert_texte('<u> </u>')"><img src="<?PHP echo $imagepath; ?>smileys/souligne.png" /></a><br />
        <td width='80%' class='tbl'><textarea name='alerte' wrap=discuss rows=3 cols=34></textarea><br /></td>
        <td width='100' class='tbl'><b>Trait du visage :</b><br /></td>
        <select name="act" id="pays">
            <option value="0">Normal</option>
            <option value="sml">Heureux</option>
            <option value="agr">Énervé</option>
            <option value="srp">Étonné</option>
        </select>
        <br /><br />
        <input type="submit" value="Envoyer l'alerte" />

    </form>
    <br />
</body>

</html>