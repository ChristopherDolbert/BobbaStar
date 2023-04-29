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

$ids = array('id1', 'id2', 'id3', 'id4', 'id5', 'id6', 'id7', 'id8', 'id9', 'id10');
$values = array();

foreach ($ids as $id) {
    if (isset($_POST[$id])) {
        $value = Secu($_POST[$id]);
        if ($value !== '') {
            $values[] = $value;
        }
    }
}

if (count($values) === 10) {
    $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
    $insertn1->bindValue(':pseudo', $user['username']);
    $insertn1->bindValue(':action', 'a mis à jour les <b>rappels</b> (Bureau des staffs)');
    $insertn1->bindValue(':date', FullDate('full'));
    $insertn1->execute();

    foreach ($ids as $key => $id) {
        $bdd->query("UPDATE gabcms_bureau_rappels SET affichage = '" . Secu($values[$key]) . "' WHERE id = " . ($key + 1));
    }

    echo '<h4 class="alert_success">Tes informations sont maintenant disponibles sur le site.</h4>';
} else {
    echo '<h4 class="alert_error">Une erreur est survenue.</h4>';
}

$sql = $bdd->query("SELECT * FROM gabcms_bureau_rappels");
$cofs = $sql->fetchAll(PDO::FETCH_ASSOC);
$cof1 = $cofs[0];
$cof2 = $cofs[1];
$cof3 = $cofs[2];
$cof4 = $cofs[3];
$cof5 = $cofs[4];
$cof6 = $cofs[5];
$cof7 = $cofs[6];
$cof8 = $cofs[7];
$cof9 = $cofs[8];
$cof10 = $cofs[9];
?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />

<body>
    <span id="titre">Modifies les rappels</span><br />
    Choisis si tu affiches ou pas certains rappels sur la page <b>bureau des staffs</b>
    <br /><br />
    <script type="text/javascript" src="editeur_html/jscripts/tiny_mce/tiny_mce.js"></script>

    <form name='editor' method='post' action="?do=modif">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody>
                <tr style="font-weight:bolder;">
                    <td style="padding: 5px;text-align: center;vertical-align: middle;background-color: #0055b0;font-size: 11px;color: #81c1cc;">Texte</td>
                    <td style="padding: 5px;text-align: center;vertical-align: middle;background-color: #0055b0;font-size: 11px;color: #81c1cc;">Ne pas afficher</td>
                    <td style="padding: 5px;text-align: center;vertical-align: middle;background-color: #0055b0;font-size: 11px;color: #81c1cc;">Afficher</td>
                </tr>
                <tr style="background-color:#d0d4d4;">
                    <td style="padding:5px; text-align: center; vertical-align: middle;font-size:11px;">Être actif sur l'hôtel</td>
                    <td style="padding:5px; text-align: center; vertical-align: middle;font-size:11px;"><input type="radio" name="id1" value="1" <?PHP if ($cof1['affichage'] == "1") { ?> checked="checked" <?PHP } ?> /></td>
                    <td style="padding:5px; text-align: center; vertical-align: middle;font-size:11px;"><input type="radio" name="id1" value="2" <?PHP if ($cof1['affichage'] == "2") { ?> checked="checked" <?PHP } ?> /></td>
                </tr>
                <tr style="background-color:#eaeaea;">
                    <td style="padding:5px; text-align: center; vertical-align: middle;font-size:11px;">Puber sur d'autres serveurs</td>
                    <td style="padding:5px; text-align: center; vertical-align: middle;font-size:11px;"><input type="radio" name="id2" value="1" <?PHP if ($cof2['affichage'] == "1") { ?> checked="checked" <?PHP } ?> /></td>
                    <td style="padding:5px; text-align: center; vertical-align: middle;font-size:11px;"><input type="radio" name="id2" value="2" <?PHP if ($cof2['affichage'] == "2") { ?> checked="checked" <?PHP } ?> /></td>
                </tr>
                <br /><br />
                <tr style="background-color:#d0d4d4;">
                    <td style="padding:5px; text-align: center; vertical-align: middle;font-size:11px;">Faire beaucoup d'animation</td>
                    <td style="padding:5px; text-align: center; vertical-align: middle;font-size:11px;"><input type="radio" name="id3" value="1" <?PHP if ($cof3['affichage'] == "1") { ?> checked="checked" <?PHP } ?> /></td>
                    <td style="padding:5px; text-align: center; vertical-align: middle;font-size:11px;"><input type="radio" name="id3" value="2" <?PHP if ($cof3['affichage'] == "2") { ?> checked="checked" <?PHP } ?> /></td>
                </tr>
                <tr style="background-color:#eaeaea;">
                    <td style="padding:5px; text-align: center; vertical-align: middle;font-size:11px;">Modérer correctement</td>
                    <td style="padding:5px; text-align: center; vertical-align: middle;font-size:11px;"><input type="radio" name="id4" value="1" <?PHP if ($cof4['affichage'] == "1") { ?> checked="checked" <?PHP } ?> /></td>
                    <td style="padding:5px; text-align: center; vertical-align: middle;font-size:11px;"><input type="radio" name="id4" value="2" <?PHP if ($cof4['affichage'] == "2") { ?> checked="checked" <?PHP } ?> /></td>
                </tr>
                <tr style="background-color:#d0d4d4;">
                    <td style="padding:5px; text-align: center; vertical-align: middle;font-size:11px;">Remplir le planning d'animation</td>
                    <td style="padding:5px; text-align: center; vertical-align: middle;font-size:11px;"><input type="radio" name="id5" value="1" <?PHP if ($cof5['affichage'] == "1") { ?> checked="checked" <?PHP } ?> /></td>
                    <td style="padding:5px; text-align: center; vertical-align: middle;font-size:11px;"><input type="radio" name="id5" value="2" <?PHP if ($cof5['affichage'] == "2") { ?> checked="checked" <?PHP } ?> /></td>
                </tr>
                <tr style="background-color:#eaeaea;">
                    <td style="padding:5px; text-align: center; vertical-align: middle;font-size:11px;">Traiter efficacement les demandes d'aide</td>
                    <td style="padding:5px; text-align: center; vertical-align: middle;font-size:11px;"><input type="radio" name="id6" value="1" <?PHP if ($cof6['affichage'] == "1") { ?> checked="checked" <?PHP } ?> /></td>
                    <td style="padding:5px; text-align: center; vertical-align: middle;font-size:11px;"><input type="radio" name="id6" value="2" <?PHP if ($cof6['affichage'] == "2") { ?> checked="checked" <?PHP } ?> /></td>
                </tr>
                <tr style="background-color:#d0d4d4;">
                    <td style="padding:5px; text-align: center; vertical-align: middle;font-size:11px;">Lire et approuver les notes de service</td>
                    <td style="padding:5px; text-align: center; vertical-align: middle;font-size:11px;"><input type="radio" name="id7" value="1" <?PHP if ($cof7['affichage'] == "1") { ?> checked="checked" <?PHP } ?> /></td>
                    <td style="padding:5px; text-align: center; vertical-align: middle;font-size:11px;"><input type="radio" name="id7" value="2" <?PHP if ($cof7['affichage'] == "2") { ?> checked="checked" <?PHP } ?> /></td>
                </tr>
                <tr style="background-color:#eaeaea;">
                    <td style="padding:5px; text-align: center; vertical-align: middle;font-size:11px;">Visiter souvent le tchat des staffs</td>
                    <td style="padding:5px; text-align: center; vertical-align: middle;font-size:11px;"><input type="radio" name="id8" value="1" <?PHP if ($cof8['affichage'] == "1") { ?> checked="checked" <?PHP } ?> /></td>
                    <td style="padding:5px; text-align: center; vertical-align: middle;font-size:11px;"><input type="radio" name="id8" value="2" <?PHP if ($cof8['affichage'] == "2") { ?> checked="checked" <?PHP } ?> /></td>
                </tr>
                <tr style="background-color:#d0d4d4;">
                    <td style="padding:5px; text-align: center; vertical-align: middle;font-size:11px;">Faire peu d'animation</td>
                    <td style="padding:5px; text-align: center; vertical-align: middle;font-size:11px;"><input type="radio" name="id9" value="1" <?PHP if ($cof9['affichage'] == "1") { ?> checked="checked" <?PHP } ?> /></td>
                    <td style="padding:5px; text-align: center; vertical-align: middle;font-size:11px;"><input type="radio" name="id9" value="2" <?PHP if ($cof9['affichage'] == "2") { ?> checked="checked" <?PHP } ?> /></td>
                </tr>
                <tr style="background-color:#eaeaea;">
                    <td style="padding:5px; text-align: center; vertical-align: middle;font-size:11px;">Modérer plus finement</td>
                    <td style="padding:5px; text-align: center; vertical-align: middle;font-size:11px;"><input type="radio" name="id10" value="1" <?PHP if ($cof10['affichage'] == "1") { ?> checked="checked" <?PHP } ?> /></td>
                    <td style="padding:5px; text-align: center; vertical-align: middle;font-size:11px;"><input type="radio" name="id10" value="2" <?PHP if ($cof10['affichage'] == "2") { ?> checked="checked" <?PHP } ?> /></td>
                </tr>
            </tbody>
        </table><br /><br />
        <input type='submit' name='submit' value='Modifier' class='submit'>
    </form>
</body>

</html>