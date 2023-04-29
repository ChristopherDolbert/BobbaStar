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

if (isset($_POST['id1']) || isset($_POST['id2']) || isset($_POST['id3']) || isset($_POST['id4']) || isset($_POST['id5']) || isset($_POST['id6']) || isset($_POST['id7']) || isset($_POST['id8'])) {
    $id1 = Secu($_POST['id1']);
    $id2 = Secu($_POST['id2']);
    $id3 = Secu($_POST['id3']);
    $id4 = Secu($_POST['id4']);
    $id5 = Secu($_POST['id5']);
    $id6 = Secu($_POST['id6']);
    $id7 = Secu($_POST['id7']);
    $id8 = Secu($_POST['id8']);
    $id9 = Secu($_POST['id9']);
    $id10 = Secu($_POST['id10']);
    if ($id1 != "" && $id2 != "" && $id3 != "" && $id4 != "" && $id5 != "" && $id6 != "" && $id7 != "" && $id8 != "" && $id9 != "" && $id10 != "") {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
        $insertn1->bindValue(':pseudo', $user['username']);
        $insertn1->bindValue(':action', 'a mis à jour les <b>rappels</b> (Bureau des staffs)');
        $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute();
        $bdd->query("UPDATE gabcms_bureau_rappels SET affichage = '" . Secu($id1) . "' WHERE id = 1");
        $bdd->query("UPDATE gabcms_bureau_rappels SET affichage = '" . Secu($id2) . "' WHERE id = 2");
        $bdd->query("UPDATE gabcms_bureau_rappels SET affichage = '" . Secu($id3) . "' WHERE id = 3");
        $bdd->query("UPDATE gabcms_bureau_rappels SET affichage = '" . Secu($id4) . "' WHERE id = 4");
        $bdd->query("UPDATE gabcms_bureau_rappels SET affichage = '" . Secu($id5) . "' WHERE id = 5");
        $bdd->query("UPDATE gabcms_bureau_rappels SET affichage = '" . Secu($id6) . "' WHERE id = 6");
        $bdd->query("UPDATE gabcms_bureau_rappels SET affichage = '" . Secu($id7) . "' WHERE id = 7");
        $bdd->query("UPDATE gabcms_bureau_rappels SET affichage = '" . Secu($id8) . "' WHERE id = 8");
        $bdd->query("UPDATE gabcms_bureau_rappels SET affichage = '" . Secu($id9) . "' WHERE id = 9");
        $bdd->query("UPDATE gabcms_bureau_rappels SET affichage = '" . Secu($id10) . "' WHERE id = 10");
        echo '<h4 class="alert_success">Tes informations sont maintenant disponible sur le site.</h4>';
    } else {
        echo '<h4 class="alert_error">Une erreur est surevenue</h4>';
    }
}
$sql1 = $bdd->query("SELECT * FROM gabcms_bureau_rappels WHERE id = 1");
$cof1 = $sql1->fetch(PDO::FETCH_ASSOC);
$sql2 = $bdd->query("SELECT * FROM gabcms_bureau_rappels WHERE id = 2");
$cof2 = $sql2->fetch(PDO::FETCH_ASSOC);
$sql3 = $bdd->query("SELECT * FROM gabcms_bureau_rappels WHERE id = 3");
$cof3 = $sql3->fetch(PDO::FETCH_ASSOC);
$sql4 = $bdd->query("SELECT * FROM gabcms_bureau_rappels WHERE id = 4");
$cof4 = $sql4->fetch(PDO::FETCH_ASSOC);
$sql5 = $bdd->query("SELECT * FROM gabcms_bureau_rappels WHERE id = 5");
$cof5 = $sql5->fetch(PDO::FETCH_ASSOC);
$sql6 = $bdd->query("SELECT * FROM gabcms_bureau_rappels WHERE id = 6");
$cof6 = $sql6->fetch(PDO::FETCH_ASSOC);
$sql7 = $bdd->query("SELECT * FROM gabcms_bureau_rappels WHERE id = 7");
$cof7 = $sql7->fetch(PDO::FETCH_ASSOC);
$sql8 = $bdd->query("SELECT * FROM gabcms_bureau_rappels WHERE id = 8");
$cof8 = $sql8->fetch(PDO::FETCH_ASSOC);
$sql9 = $bdd->query("SELECT * FROM gabcms_bureau_rappels WHERE id = 9");
$cof9 = $sql9->fetch(PDO::FETCH_ASSOC);
$sql10 = $bdd->query("SELECT * FROM gabcms_bureau_rappels WHERE id = 10");
$cof10 = $sql10->fetch(PDO::FETCH_ASSOC);
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