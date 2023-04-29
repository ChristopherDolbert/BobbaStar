<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");

if (!isset($_SESSION['username']) || $user['rank'] < 10 || $user['rank'] > 11) {
    Redirect("" . $url . "/managements/access_neg");
    exit();
}

if (isset($_GET['do']) && $_GET['do'] == "modif") {
    $haut = addslashes($_POST['haut'] ?? '');
    $bas = addslashes($_POST['bas'] ?? '');
    if ($haut && $bas) {
        $bdd->query("UPDATE gabcms_newsletter SET newsletter_haut = '$haut', newsletter_bas = '$bas' WHERE id = 1");
        $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)")
            ->execute([':pseudo' => $user['username'], ':action' => 'a modifié <b>les textes</b> de la <b>newsletter</b>', ':date' => FullDate('full')]);
        echo '<h4 class="alert_success">Les textes des newsletters viennent d\'être modifiés.</h4>';
    } else {
        echo '<h4 class="alert_error">Merci de remplir les champs vides.</h4>';
    }
}

?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />

<body>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/37.0.1/classic/ckeditor.js"></script>
    <script type="text/javascript" src="<?PHP echo $imagepath; ?>editor/config.js"></script>
    <?PHP
    $sql_modif = $bdd->query("SELECT * FROM gabcms_newsletter WHERE id = '1'");
    $modif_a = $sql_modif->fetch();
    ?>
    <span id="titre">Modification des textes de base</span><br \>
    Tu peux modifié dans le texte ci-dessous, le texte qui sera afficher en haut ou en bas de ta newsletter.<br />
    Met le code <b>$date</b> pour afficher la date le jour de l'envoi (Au format suivant : JJ/MM/AAAA)
    <br /><br />
    <form name="editor" method="post" action="?do=modif">
        <td width="100" class="tbl"><b>Le haut de ta newsletter :</b><br /></td>
        <td width="80%" class="tbl"><textarea name="haut" wrap="discuss rows=10 cols=142" id="editor1"><?php echo $modif_a['newsletter_haut']; ?></textarea>
            <script>
                CKEDITOR.replace('editor1', {
                    toolbar: 'Newsletter'
                });
            </script>
            <br />
        </td><br />
        <td width="100" class="tbl"><b>Le bas de ta newsletter :</b><br /></td>
        <td width="80%" class="tbl"><textarea name="bas" wrap="discuss rows=10 cols=142" id="editor2"><?php echo $modif_a['newsletter_bas']; ?></textarea>
            <script>
                CKEDITOR.replace('editor2', {
                    toolbar: 'Newsletter'
                });
            </script>
            <br /><br />
        </td>
        <input type='submit' name='submit' value='Modifier'>
    </form>
</body>

</html>