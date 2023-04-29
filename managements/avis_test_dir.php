<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");

if (!isset($_SESSION['username']) || $user['rank'] > 11) {
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
    $infa = $bdd->query("SELECT * FROM gabcms_test_commentaires WHERE id_test = '" . $modifierrecrut . "'");
    $a = $infa->fetch();
    if (isset($_POST['commentaire']) || isset($_POST['avis'])) {
        $commentaire = $_POST['commentaire'];
        $avis = $_POST['avis'];

        $user_id = $r['user_id'];
        $sql = $bdd->query("SELECT * FROM users WHERE id = '{$user_id}'");
        $assoc = $sql->fetch(PDO::FETCH_ASSOC);

        $poste = $r['poste'];
        $correct = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '{$poste}'");
        $c = $correct->fetch();

        if ($commentaire && $avis && $user['id'] != $r['user_id'] && $user['id'] != $r['tuteur'] && !$a['avisdir_commentaire']) {
            $bdd->query("UPDATE gabcms_test_commentaires SET avisdir_pseudo = '{$user['username']}', avisdir_commentaire = '" . addslashes($commentaire) . "', avisdir = '$avis', avisfinal = '$avis' WHERE id_test = '$modifierrecrut'");
            $bdd->query("UPDATE gabcms_test_staff SET etat = '2' WHERE id = '$modifierrecrut'");
            $bdd->query("UPDATE users SET staff_test = '0' WHERE id = '{$r['user_id']}'");

            $poste_nom = ($assoc['gender'] == 'M') ? addslashes($c['nom_M']) : addslashes($c['nom_F']);
            $action = "(direction) a donné son avis sur le test de <b>{$assoc['username']}</b> pour le poste de <b>{$poste_nom}</b>";
            $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo, action, date) VALUES (:pseudo, :action, :date)");
            $insertn1->execute([':pseudo' => $user['username'], ':action' => $action, ':date' => FullDate('full')]);
        }

        if ($avis == 1) {
            $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->execute([
                ':pseudo' => $assoc['username'],
                ':action' => 'a réussi son test.',
                ':date' => FullDate('full')
            ]);

            $nom_poste = ($assoc['gender'] == 'M') ? addslashes($c['nom_M']) : addslashes($c['nom_F']);
            $message_alerte = "<b>Bonjour {$assoc['username']}</b><br/><br/>Je viens de traiter ton test, et j'ai le plaisir de t'annoncer que ton test a été <b>concluant</b>, donc réussi. Tu détiens à partir de maintenant ton poste <b>('{$nom_poste}')</b>.<br/><br/><i>Ce message est généré automatiquement après l'avis de la direction</i>";
            $insertn2 = $bdd->prepare("INSERT INTO gabcms_alertes (userid, sujet, alerte, par, date, look, action) VALUES (:id, :sujet, :alerte, :par, :date, :look, :act)");
            $insertn2->execute([
                ':id' => $r['user_id'],
                ':sujet' => 'Résultat de ton test',
                ':alerte' => $message_alerte,
                ':par' => $user['username'],
                ':date' => FullDate('full'),
                ':look' => $user['look'],
                ':act' => '0'
            ]);

            $insertn3 = $bdd->prepare("INSERT INTO gabcms_management (user_id, message, auteur, date, look) VALUES (:userid, :message, :auteur, :date, :look)");
            $insertn3->execute([
                ':userid' => $r['user_id'],
                ':message' => "Je viens de donner mon avis définitif sur ta période de test ! Merci d'aller lire au <b>PLUS VITE</b> le résultat en <a href='{$url}/alerts'>cliquant ici</a> !",
                ':auteur' => $user['username'],
                ':date' => FullDate('full'),
                ':look' => $user['look']
            ]);
        }

        if ($avis == 2) {
            $date = FullDate('full');
            $username = $assoc['username'];
            $user_id = $r['user_id'];
            $look = $user['look'];
            $url_alerts = $url . '/alerts';
            $message = '<b>Bonjour ' . $username . '</b><br/><br/>Je viens de traiter ton test, et j\'ai le devoir de t\'annoncer que ton test a été <b>échoué</b>. La direction n\'est pas dans l\'obligation de justifier ce refus. Toutes fois tu peux toujours demander.<br/><br/><i>Ce message est généré automatiquement après l\'avis de la direction</i>';

            $stmt1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $stmt1->execute([
                'pseudo' => $username,
                'action' => 'a échoué son test.',
                'date' => $date
            ]);

            $stmt2 = $bdd->prepare("INSERT INTO gabcms_alertes (userid, sujet, alerte, par, date, look, action) VALUES (:id, :sujet, :alerte, :par, :date, :look, :act)");
            $stmt2->execute([
                'id' => $user_id,
                'sujet' => 'Résultat de ton test',
                'alerte' => $message,
                'par' => $user['username'],
                'date' => $date,
                'look' => $look,
                'act' => 0
            ]);

            $stmt3 = $bdd->prepare("INSERT INTO gabcms_management (user_id, message, auteur, date, look) VALUES (:userid, :message, :auteur, :date, :look)");
            $stmt3->execute([
                'userid' => $user_id,
                'message' => 'Je viens de donner mon avis définitif sur ta période de test ! Merci d\'aller lire au <b>PLUS VITE</b> le résultat en <a href="' . $url_alerts . '">cliquant ici</a> !',
                'auteur' => $user['username'],
                'date' => $date,
                'look' => $look
            ]);
        }
        echo '<h4 class="alert_success">Ton avis sur le test de <b>' . $assoc['username'] . '</b> a été enregistré.</h4>';
    } else {
        echo '<h4 class="alert_error">Une erreur s\'est produite</h4>';
    }
}
?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />

<body>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <?php if (!isset($_GET['modif'])) { ?>
        <span id="titre">Donnes ton avis sur des tests</span><br />
        Donnes un avis définitif sur un staff en test.<br /><br />
        <div class="content">
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
                    $sql = $bdd->query("SELECT t.*, u1.username AS username, u2.username AS tuteur, p.nom_M AS poste_nom
                    FROM gabcms_test_staff t
                    LEFT JOIN users u1 ON t.user_id = u1.id
                    LEFT JOIN users u2 ON t.tuteur = u2.id
                    LEFT JOIN gabcms_postes_noms p ON t.poste = p.id
                    WHERE t.date_fin <= '$nowtime' AND t.etat = '1'
                    ORDER BY t.date_fin DESC");

                    while ($e = $sql->fetch(PDO::FETCH_ASSOC)) {
                        $date_fin = date('d/m/Y H:i', $e['date_fin']);
                        $avis_link = $user['id'] != $e['tuteur'] ? '<a href="?modif=' . $e['id'] . '">Donner son avis</a>' : '';
                        echo '<tr class="bas">';
                        echo '<td class="bas">' . $e['username'] . '</td>';
                        echo '<td class="bas">' . $e['poste_nom'] . '</td>';
                        echo '<td class="bas">' . $e['date_debut'] . '</td>';
                        echo '<td class="bas">' . $date_fin . '</td>';
                        echo '<td class="bas">' . $e['tuteur'] . '</td>';
                        echo '<td class="bas">' . $e['par'] . '</td>';
                        echo '<td class="bas">' . $avis_link . '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
            <hr />
            <table>
                <tbody>
                    <tr style="font-weight:bolder;">
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
                    $sql = $bdd->query("SELECT t.*, u1.username AS username, u2.username AS tuteur, p.nom_M AS poste_nom
                    FROM gabcms_test_staff t
                    LEFT JOIN users u1 ON t.user_id = u1.id
                    LEFT JOIN users u2 ON t.tuteur = u2.id
                    LEFT JOIN gabcms_postes_noms p ON t.poste = p.id
                    WHERE t.date_fin <= '$nowtime'
                    ORDER BY t.date_fin DESC");
                    while ($e = $sql->fetch(PDO::FETCH_ASSOC)) {
                        $date_fin = date('d/m/Y H:i', $e['date_fin']);
                        if ($e['etat'] == 0) {
                            $etat_modif = "<span style=\"color:#0000FF;\"><b>Attente avis<br/>tuteur</b></span>";
                        } elseif ($e['etat'] == 1) {
                            $etat_modif = "<span style=\"color:#0000FF;\"><b>Attente avis<br/>direction</b></span>";
                        } else {
                            $etat_modif = "<span style=\"color:#008800;\"><b>Traitée</b></span>";
                        }
                        echo '<tr class="bas">';
                        echo '<td class="bas">' . $e['username'] . '</td>';
                        echo '<td class="bas">' . $e['poste_nom'] . '</td>';
                        echo '<td class="bas">' . $e['date_debut'] . '</td>';
                        echo '<td class="bas">' . $date_fin . '</td>';
                        echo '<td class="bas">' . $e['tuteur'] . '</td>';
                        echo '<td class="bas">' . $e['par'] . '</td>';
                        echo '<td class="bas">' . $etat_modif . '</td>';
                        echo '<td class="bas"><a href="' . $url . '/managements/look_test?id=' . $e['id'] . '&page=dir">Voir</a></td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>

    <?PHP }
    if (isset($_GET['modif'])) {
        $sql = $bdd->query("
    SELECT t.*, u.username, u.account_created, p.nom_M, tuteur.username AS tuteur_username, c.avistuteur
    FROM gabcms_test_staff t 
    INNER JOIN users u ON t.user_id = u.id 
    INNER JOIN gabcms_postes_noms p ON t.poste = p.id 
    INNER JOIN users tuteur ON t.tuteur = tuteur.id 
    LEFT JOIN gabcms_test_commentaires c ON t.id = c.id_test 
    WHERE t.id = '$modif'");
        $modif_a = $sql->fetch();
        $modif_e = $modif_a;
        $modif_z = $sql->fetch(PDO::FETCH_ASSOC);
        $date_but = date('d/m/Y H:i', $modif_a['date_fin']);
        $assoc = $modif_a;
        $assoc2 = ['username' => $modif_a['tuteur_username']];
        $etat2 = '';
        if ($modif_z['avistuteur'] == 1) {
            $etat2 = "<span style=\"color:#008000\"><b>Favorable</b></span>";
        } elseif ($modif_z['avistuteur'] == 2) {
            $etat2 = "<span style=\"color:#FF0000\"><b>Défavorable</b></span>";
        }
        $c = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '{$modif_a['poste']}'")->fetch();

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
                        <td style="background-color: #D1D1D1; border-color:rgb(0, 0, 0); text-align:left; vertical-align:top;"><span style="font-size:12px">Avis du tuteur (<?PHP echo $modif_z['avistuteur_pseudo'] ?>) : <?PHP echo $etat2 ?></span></td>
                        <td style="background-color: #D1D1D1; border-color:rgb(0, 0, 0); text-align:left; vertical-align:top"><span style="font-size:12px">Avis de la direction : <select name="avis" id="lenght" class="select">
                                    <option value="1">Favorable</option>
                                    <option value="2">Défavorable</option>
                                </select></span></td>
                    </tr>
                    <tr>
                        <td rowspan="2" style="background-color: #C0C0C0; border-color: rgb(0, 0, 0); text-align: left; vertical-align: top;">
                            <div style="overflow-y:auto; max-height:100px;"><?PHP echo nl2br(stripslashes($modif_z['avistuteur_commentaire'])); ?></div>
                        </td>
                        <td rowspan="2" style="background-color: #C0C0C0; border-color: rgb(0, 0, 0); text-align: left; vertical-align: top;">Donner son avis :<br />
                            <textarea name="commentaire" rows=4 cols=55></textarea><br />
                            <input type='submit' name='submit' value='Donner son avis'>
        </form>
        </td>
        </tr>
        </tbody>
        </table>
        </div>
    <?php } ?>
    </div>
</body>

</html>