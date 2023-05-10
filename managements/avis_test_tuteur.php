<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");

if (!isset($_SESSION['username']) || $user['rank'] < 7 || $user['rank'] > 11) {
    Redirect("" . $url . "/managements/access_neg");
    exit();
}

if (isset($_GET['modif'])) {
    $modif = Secu($_GET['modif']);
}

if (isset($_GET['modifierrecrut'])) {
    $modifierrecrut = Secu($_GET['modifierrecrut']);
    $infr = $bdd->query("SELECT * FROM gabcms_test_staff WHERE id = '" . $modifierrecrut . "'");
    $r = $infr->fetch();
    if (isset($_POST['commentaire']) || isset($_POST['avis'])) {
        $commentaire = addslashes($_POST['commentaire']);
        $avis = addslashes($_POST['avis']);
        $sql = $bdd->query("SELECT * FROM users WHERE id = '" . $r['user_id'] . "'");
        $row = $sql->rowCount();
        $assoc = $sql->fetch(PDO::FETCH_ASSOC);
        $correct = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '" . $r['poste'] . "'");
        $c = $correct->fetch();
        if ($commentaire != "" && $avis != "" && $user['id'] == $r['tuteur']) {
            $insertn2 = $bdd->prepare("INSERT INTO gabcms_test_commentaires (id_test, avistuteur_pseudo, avistuteur_commentaire, avistuteur) VALUES (:id, :user, :com, :avis)");
            $insertn2->bindValue(':id', $modifierrecrut);
            $insertn2->bindValue(':user', $user['username']);
            $insertn2->bindValue(':com', addslashes($commentaire));
            $insertn2->bindValue(':avis', $avis);
            $insertn2->execute();
            $bdd->query("UPDATE gabcms_test_staff SET etat = '1' WHERE id = '" . $modifierrecrut . "'");
            $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            if ($assoc['gender'] == 'M') {
                $insertn1->bindValue(':action', '(tuteur) a donné son avis sur le test de <b>' . $assoc['username'] . '</b> pour le poste de <b>' . addslashes($c['nom_M']) . '</b>');
            } elseif ($assoc['gender'] == 'F') {
                $insertn1->bindValue(':action', '(tuteur) a donné son avis sur le test de <b>' . $assoc['username'] . '</b> pour le poste de <b>' . addslashes($c['nom_F']) . '</b>');
            }
            $insertn1->bindValue(':date', FullDate('full'));
            $insertn1->execute();
            echo '<h4 class="alert_success">Ton avis sur le test de <b>' . $assoc['username'] . '</b> a été enregistré.</h4>';
        } else {
            echo '<h4 class="alert_error">Une erreur s\'est produite</h4>';
        }
    }
}
?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />

<body></body>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<?php if (!isset($_GET['modif'])) { ?>
    <span id="titre">Donnes ton avis sur des tests</span><br />
    Si tu es tuteur, tu dois donner ton avis sur le test de ton tutoré.
    <div class="content">
        <br /><br />
        <table>
            <tbody>
                <tr class="haut">
                    <td class="haut">Pseudo</td>
                    <td class="haut">Poste</td>
                    <td class="haut">Date de début</td>
                    <td class="haut">Date de fin</td>
                    <td class="haut">Tuteur</td>
                    <td class="haut">Ouvert par</td>
                    <td class="haut">Actions</td>
                </tr>
                <?php
                $sql = $bdd->query("SELECT * FROM gabcms_test_staff WHERE date_fin <= '" . $nowtime . "' AND etat = '0' ORDER BY date_fin DESC");
                while ($e = $sql->fetch()) {
                    $date_but = date('d/m/Y H:i', $e['date_fin']);
                    $sqlz = $bdd->query("SELECT username FROM users WHERE id = '" . $e['user_id'] . "'");
                    $rowz = $sqlz->rowCount();
                    $assocz = $sqlz->fetch(PDO::FETCH_ASSOC);
                    $sql2 = $bdd->query("SELECT username FROM users WHERE id = '" . $e['tuteur'] . "'");
                    $row2 = $sql2->rowCount();
                    $assoc2 = $sql2->fetch(PDO::FETCH_ASSOC);
                    $correct = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '" . $e['poste'] . "'");
                    $c = $correct->fetch();
                ?>
                    <tr class="bas">
                        <td class="bas"><?PHP echo $assocz['username'] ?></td>
                        <td class="bas"><?PHP echo $c['nom_M'] ?></td>
                        <td class="bas"><?PHP echo $e['date_debut'] ?></td>
                        <td class="bas"><?PHP echo $date_but ?></td>
                        <td class="bas"><?PHP echo $assoc2['username'] ?></td>
                        <td class="bas"><?PHP echo $e['par'] ?></td>
                        <td class="bas"><?PHP if ($user['id'] == $e['tuteur']) { ?><a href="?modif=<?PHP echo $e['id']; ?>">Donner son avis</a><?PHP } ?></td>
                    </tr>
                <?PHP } ?>
            </tbody>
        </table>
        <hr />
        <table>
            <tbody>
                <tr class="haut">
                    <td class="haut">Pseudo</td>
                    <td class="haut">Poste</td>
                    <td class="haut">Date de début</td>
                    <td class="haut">Date de fin</td>
                    <td class="haut">Tuteur</td>
                    <td class="haut">Ouvert par</td>
                    <td class="haut">Etat</td>
                    <td class="haut">Actions</td>
                </tr>
                <?php
                $sql = $bdd->query("SELECT * FROM gabcms_test_staff WHERE date_fin <= '" . $nowtime . "' ORDER BY date_fin DESC");
                while ($e = $sql->fetch()) {
                    $date_but = date('d/m/Y H:i', $e['date_fin']);
                    $sqlz = $bdd->query("SELECT username FROM users WHERE id = '" . $e['user_id'] . "'");
                    $rowz = $sqlz->rowCount();
                    $assocz = $sqlz->fetch(PDO::FETCH_ASSOC);
                    $sql2 = $bdd->query("SELECT username FROM users WHERE id = '" . $e['tuteur'] . "'");
                    $row2 = $sql2->rowCount();
                    $assoc2 = $sql2->fetch(PDO::FETCH_ASSOC);
                    if ($e['etat'] == 0) {
                        $etat_modif = "<span style=\"color:#0000FF;\"><b>Attente avis<br/>tuteur</b></span>";
                    }
                    if ($e['etat'] == 1) {
                        $etat_modif = "<span style=\"color:#0000FF;\"><b>Attente avis<br/>direction</b></span>";
                    }
                    if ($e['etat'] == 2) {
                        $etat_modif = "<span style=\"color:#008800;\"><b>Traitée</b></span>";
                    }
                    $correct = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '" . $e['poste'] . "'");
                    $c = $correct->fetch();
                ?>
                    <tr class="bas">
                        <td class="bas"><?PHP echo $assocz['username'] ?></td>
                        <td class="bas"><?PHP echo $c['nom_M'] ?></td>
                        <td class="bas"><?PHP echo $e['date_debut'] ?></td>
                        <td class="bas"><?PHP echo $date_but ?></td>
                        <td class="bas"><?PHP echo $assoc2['username'] ?></td>
                        <td class="bas"><?PHP echo $e['par'] ?></td>
                        <td class="bas"><?PHP echo $etat_modif ?></td>
                        <td class="bas"><a href="<?PHP echo $url ?>/managements/look_test?id=<?PHP echo $e['id'] ?>&page=tuteur">Voir</a></td>
                    </tr>
                <?PHP } ?>
            </tbody>
        </table>
    </div>
<?PHP }
if (isset($_GET['modif'])) {
    $sql_modif = $bdd->query("SELECT * FROM gabcms_test_staff WHERE id = '" . $modif . "'");
    $modif_a = $sql_modif->fetch();
    $sql_modifa = $bdd->query("SELECT * FROM users WHERE id = '" . $modif_a['user_id'] . "'");
    $modif_e = $sql_modifa->fetch();
    $date_but = date('d/m/Y H:i', $modif_a['date_fin']);
    $sql = $bdd->query("SELECT * FROM users WHERE id = '" . $modif_a['user_id'] . "'");
    $assoc = $sql->fetch(PDO::FETCH_ASSOC);
    $sql2 = $bdd->query("SELECT username FROM users WHERE id = '" . $modif_a['tuteur'] . "'");
    $assoc2 = $sql2->fetch(PDO::FETCH_ASSOC);
    $correct = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '" . $modif_a['poste'] . "'");
    $c = $correct->fetch();
?>
    <span id="titre">Donnes ton avis</span><br />
    Donnes ton avis sur une période de test d'un de tes tutorés :<br /><br />
    <form name='editor' method='post' action="?modifierrecrut=<?php echo $modif; ?>">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody>
                <tr>
                    <td style="background-color: rgb(204, 51, 0); border-color: rgb(0, 0, 0); vertical-align: middle; width:35%; text-align: center;"><span style="font-size:12px"><span style="color:rgb(255, 255, 255)"><em><strong>Informations staff en test</strong></em></span></span></td>
                    <td style="background-color: rgb(204, 51, 0); border-color: rgb(0, 0, 0); text-align: left; vertical-align: middle; width:35%;"><span style="font-size:12px"><span style="color:rgb(255, 255, 255)">Pseudo du tuteur : <b><?PHP echo $assoc2['username'] ?></b></span></span></td>
                    <td style="background-color: rgb(204, 51, 0); border-color: rgb(0, 0, 0); text-align: left; vertical-align: middle; width:35%;"><span style="font-size:12px"><span style="color:rgb(255, 255, 255)">Derni&egrave;re connexion du staff en test : <b><?PHP $connexion = date('d/m/Y H:i:s', $modif_e['last_online']);
                                                                                                                                                                                                                                                                        echo $connexion; ?></b></span></span></td>
                </tr>
                <tr>
                    <td rowspan="3" style="background-color: rgb(255, 204, 51); border-color: rgb(0, 0, 0); text-align: left;">
                        <span style="font-size:12px">Pseudo : <b><?PHP echo $assoc['username'] ?></b></span><br />
                        <span style="font-size:12px">Date d&#39;inscription : <b><?PHP echo $assoc['account_created'] ?></b></span><br />
                        <span style="font-size:12px; text-align: center;">__________________________</span><br />
                        <span style="font-size:12px">Poste : <b><?PHP echo $c['nom_M'] ?></b></span><br />
                        <span style="font-size:12px">En test depuis le <b><?PHP echo $modif_a['date_debut'] ?></b></span><br />
                        <span style="font-size:12px">En attente d&#39;avis depuis le <b><?PHP echo $date_but ?></b></span>
                    </td>
                    <td style="background-color: #D1D1D1; border-color:rgb(0, 0, 0); height:20px; text-align:left; vertical-align:top"><span style="font-size:12px">Avis du tuteur : <select name="avis" id="lenght" class="select">
                                <option value="1">Favorable</option>
                                <option value="2">Défavorable</option>
                            </select></span></td>
                    <td style="background-color: #D1D1D1; border-color:rgb(0, 0, 0); text-align:left; vertical-align:top"><span style="font-size:12px">Avis de la direction : <span style="color:#0000FF"><b>en attente</b></span></span></td>
                </tr>
                <tr>
                    <td rowspan="2" style="background-color: #C0C0C0; border-color: rgb(0, 0, 0); text-align: left; vertical-align: top; width: 300px; height: 140px;">Donner son avis :<br />
                        <textarea name="commentaire" rows=4 cols=55></textarea><br />
                        <input type='submit' name='submit' value='Donner son avis'>
    </form>
    </td>
    <td rowspan="2" style="background-color: #C0C0C0; border-color: rgb(0, 0, 0); text-align: left; vertical-align: top; width: 300px; height: 140px;"></td>
    </tr>
    </tbody>
    </table>
    </div>
<?php } ?>
</div>
</body>

</html>