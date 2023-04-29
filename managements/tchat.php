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

if ($_GET['do'] === 'tchat') {
    $insertn2 = $bdd->prepare("INSERT INTO gabcms_tchat (pseudo, message, ip, date, look, rank, alert) VALUES (:user, :msg, :ip, :date, :look, :rank, :alert)");
    $insertn2->execute([
        ':user' => $user['username'],
        ':msg' => Secu($_POST['message']),
        ':ip' => $user['ip_current'],
        ':date' => FullDate('full'),
        ':look' => $user['look'],
        ':rank' => $user['rank'],
        ':alert' => '1',
    ]);

    $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo, action, date) VALUES (:pseudo, :action, :date)");
    $insertn1->execute([
        ':pseudo' => $user['username'],
        ':action' => 'a ajouté une alerte sur le tchat',
        ':date' => FullDate('full'),
    ]);

    echo '<h4 class="alert_success">Une alerte a été ajoutée sur le tchat</h4>';
}

?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />

<body>
    <script language="javascript" type="text/javascript">
        function insert_texte(texte) {
            var ou = document.getElementsByName("message")[0];
            var phrase = texte + " ";
            ou.value += phrase;
            ou.focus();
        }
    </script>
    <span id="titre">Ajoutes une alerte sur le tchat</span><br />
    Ajoutes une alerte sur le chat, elle sera visible en rouge !<br /><br />
    <td width='100' class='tbl'><b>Message :</b><br /></td>
    <?php
    $smileys = array(
        ';)' => 'clindoeil.gif',
        ':$' => 'embarrase.gif',
        ':o' => 'etonne.gif',
        ':)' => 'happy.gif',
        ':x' => 'icon_silent.png',
        ':p' => 'langue.gif',
        ':\'(' => 'sad.gif',
        ':D' => 'veryhappy.gif',
        ':jap:' => 'jap.png',
        '8)' => 'cool.gif',
        ':rire:' => 'rire.gif',
        ':evil:' => 'icon_evil.gif',
        ':twisted:' => 'icon_twisted.gif',
        ':rool:' => 'roll.gif',
        ':|' => 'neutre.gif',
        ':suspect:' => 'suspect.gif',
        ':no:' => 'no.gif',
        ':coeur:' => 'coeur.gif',
        ':hap:' => 'hap.gif',
        ':bave:' => 'bave.gif',
        ':areuh:' => 'areuh.gif',
        ':bandit:' => 'bandit.gif',
        ':help:' => 'help.gif',
        ':buzz:' => 'buzz.gif'
    );
    foreach ($smileys as $code => $image) {
        echo '<a href="#" onclick="insert_texte(\'' . $code . '\')"><img src="' . $imagepath . 'smileys/' . $image . '" /></a>';
    }
    ?>
    <form name='editor' method='post' action="?do=tchat">
        <td width='80%' class='tbl'><input type='text' name='message' class='text' style='width: 240px'><br /></td>
        <br />
        <tr>
            <td align='center' colspan='2' class='tbl'>
                <input type='submit' name='submit' value='Exécuter' class='submit'>
    </form>
    </tr>
</body>

</html>

</tr>