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

if (isset($_POST['achat_jetons']) || isset($_POST['respects_300']) || isset($_POST['respects_700']) || isset($_POST['caresses_400']) || isset($_POST['caresses_900']) || isset($_POST['messages']) || isset($_POST['winwin']) || isset($_POST['bots']) || isset($_POST['vipclub']) || isset($_POST['staffclub'])) {
    $achat_jetons = Secu($_POST['achat_jetons']);
    $respects_300 = Secu($_POST['respects_300']);
    $respects_700 = Secu($_POST['respects_700']);
    $caresses_400 = Secu($_POST['caresses_400']);
    $caresses_900 = Secu($_POST['caresses_900']);
    $messages = Secu($_POST['messages']);
    $winwin = Secu($_POST['winwin']);
    $bots = Secu($_POST['bots']);
    $vipclub = Secu($_POST['vipclub']);
    $staffclub = Secu($_POST['staffclub']);
    if ($achat_jetons != "" && $respects_300 != "" && $respects_700 != "" && $caresses_400 != "" && $caresses_900 != "" && $messages != "" && $winwin != "" && $bots != "" && $vipclub != "" && $staffclub != "") {
        if ($achat_jetons != "0") {
            $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a mis à jour les <b>prix de la boutique</b>');
            $insertn1->bindValue(':date', FullDate('full'));
            $insertn1->execute();
            $bdd->query("UPDATE gabcms_config_prix SET achat_jetons = '" . $achat_jetons . "', respects_300 = '" . $respects_300 . "', respects_700 = '" . $respects_700 . "', caresses_400 = '" . $caresses_400 . "', caresses_900 = '" . $caresses_900 . "', messages = '" . $messages . "', winwin = '" . $winwin . "', bots = '" . $bots . "', vipclub = '" . $vipclub . "', staffclub = '" . $staffclub . "' WHERE id = 1");
            echo '<h4 class="alert_success">Tes informations sont maintenant disponible sur le site.</h4>';
        } else {
            echo '<h4 class="alert_error">Merci de ne pas mettre 0 pour l\'achat de jetons.</h4>';
        }
    } else {
        echo '<h4 class="alert_error">Merci de marquer une information valide.</h4>';
    }
}
$sql = $bdd->query("SELECT * FROM gabcms_config_prix WHERE id = '1'");
$cof = $sql->fetch(PDO::FETCH_ASSOC);
?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />

<body></body>
<span id="titre">Configuration générales</span><br />
Modifies le nombre de jetons donnés à l'achat, le prix du staff club...
<br /><br />
<script type="text/javascript" src="editeur_html/jscripts/tiny_mce/tiny_mce.js"></script>
<form name='editor' method='post' action="#">
    <table>
        <tbody>
            <tr class="haut">
                <td class="haut" colspan="2">Nombre de jetons à l'achat</td>
            </tr>
            <tr class="bas">
                <td class="bas"><img src="<?PHP echo $imagepath ?>v2/images/newcredits/details_coin.png" align="left" /></td>
                <td class="bas"><input type="text" name="achat_jetons" value="<?PHP echo $cof['achat_jetons']; ?>" class="text" size="3" maxlength="3" /></td>
            </tr>
            <tr class="haut">
                <td class="haut" colspan="2">Prix d'achat respects</td>
            </tr>
            <tr class="bas">
                <td class="bas"><img src="<?PHP echo $imagepath ?>v2/images/divers/ACH_RespectEarned10.gif" align="left" />x300</td>
                <td class="bas"><input type="text" name="respects_300" value="<?PHP echo $cof['respects_300']; ?>" class="text" size="2" maxlength="2" /></td>
            </tr>
            <tr class="bas">
                <td class="bas"><img src="<?PHP echo $imagepath ?>v2/images/divers/ACH_RespectEarned10.gif" align="left" />x700</td>
                <td class="bas"><input type="text" name="respects_700" value="<?PHP echo $cof['respects_700']; ?>" class="text" size="2" maxlength="2" /></td>
            </tr>
            <tr class="haut">
                <td class="haut" colspan="2">Prix d'achat caresses</td>
            </tr>
            <tr class="bas">
                <td class="bas"><img src="<?PHP echo $imagepath ?>v2/images/divers/ACH_PetLover10.gif" align="left" />x400</td>
                <td class="bas"><input type="text" name="caresses_400" value="<?PHP echo $cof['caresses_400']; ?>" class="text" size="2" maxlength="2" /></td>
            </tr>
            <tr class="bas">
                <td class="bas"><img src="<?PHP echo $imagepath ?>v2/images/divers/ACH_PetLover10.gif" align="left" />x900</td>
                <td class="bas"><input type="text" name="caresses_900" value="<?PHP echo $cof['caresses_900']; ?>" class="text" size="2" maxlength="2" /></td>
            </tr>
            <tr class="haut">
                <td class="haut" colspan="2">Prix d'achat de 30 messages</td>
            </tr>
            <tr class="bas">
                <td class="bas" colspan="2"><input type="text" name="messages" value="<?PHP echo $cof['messages']; ?>" class="text" size="2" maxlength="2" /></td>
            </tr>
            <tr class="haut">
                <td class="haut" colspan="2">Prix d'achat de win-win</td>
            </tr>
            <tr class="bas">
                <td class="bas"><img src="<?PHP echo $imagepath ?>v2/images/divers/ach_friendlistsize6.gif" align="left" />x1000</td>
                <td class="bas"><input type="text" name="winwin" value="<?PHP echo $cof['winwin']; ?>" class="text" size="2" maxlength="2" /></td>
            </tr>
            <tr class="haut">
                <td class="haut" colspan="2">Prix d'achat d'un bot</td>
            </tr>
            <tr class="bas">
                <td class="bas"><img src="<?PHP echo $imagepath ?>v2/images/divers/BOT.gif" align="left" /></td>
                <td class="bas"><input type="text" name="bots" value="<?PHP echo $cof['bots']; ?>" class="text" size="2" maxlength="2" /></td>
            </tr>
            <tr class="haut">
                <td class="haut" colspan="2">Prix d'achat d'un club</td>
            </tr>
            <tr class="bas">
                <td class="bas"><img src="<?PHP echo $imagepath ?>v2/images/divers/ACH_VipClub12.gif" align="left" /></td>
                <td class="bas"><input type="text" name="vipclub" value="<?PHP echo $cof['vipclub']; ?>" class="text" size="2" maxlength="2" /></td>
            </tr>
            <tr class="bas">
                <td class="bas"><img src="<?PHP echo $imagepath ?>v2/images/divers/ADM.gif" align="left" /></td>
                <td class="bas"><input type="text" name="staffclub" value="<?PHP echo $cof['staffclub']; ?>" class="text" size="2" maxlength="2" /></td>
            </tr>
            <tr class="haut">
                <td class="haut" colspan="2"><input type='submit' name='submit' value='Exécuter' class='submit' /></td>
            </tr>
        </tbody>
    </table>
</form>
</body>

</html>