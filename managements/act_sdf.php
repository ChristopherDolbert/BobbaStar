<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|           GabCMS - Site Web et Content Management System               #|
#|         Copyright © 2012-2014 - Gabodd Tout droits réservés.           #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");

if(!isset($_SESSION['username']))
	{
		Redirect("".$url."/index");
		exit();
	}
		
	if($user['rank'] < 6) {
	Redirect("".$url."/managements/acces_neg");
	exit();
	}
	if($user['rank'] > 8) {              
	Redirect("".$url."/managements/acces_neg");
	exit();
	}	 

if(isset($_GET['do'])) {
$do = Secu($_GET['do']);
    if($do == "add_sdf") {
        $url = Secu($_POST['url']);
        $nom = Secu($_POST['nom']);
        if($nom != "" && $url != "") {
        $insertn2 = $bdd->prepare("INSERT INTO gabcms_sitedefan (url, nom) VALUES (:url, :nom)");
            $insertn2->bindValue(':url', 'http://'.$url);
            $insertn2->bindValue(':nom', $nom);
        $insertn2->execute();
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a ajouté un fansite à la liste officielle <b>(Nom : '.$nom.')</b>');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
        echo '<h4 class="alert_success">Le site de fan a bien été ajouté.</h4>';
        } else {
        echo '<h4 class="alert_error">Un des champs n\'a pas été renseigné</h4>';
        } 
    }
}
if(isset($_GET['sup'])) {
    $sup = Secu($_GET['sup']);
    $infe = $bdd->query("SELECT * FROM gabcms_sitedefan WHERE id = '".$sup."'");
    $e = $infe->fetch();
    $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
        $insertn1->bindValue(':pseudo', $user['username']);
        $insertn1->bindValue(':action', 'a supprimé un fansite de la liste officielle <b>(Nom : '.$e['nom'].')</b>');
        $insertn1->bindValue(':date', FullDate('full'));
    $insertn1->execute(); 
    $bdd->query("DELETE FROM gabcms_sitedefan WHERE id = '".$sup."'");
	echo '<h4 class="alert_success">Le site de fan a bien été supprimé.</h4>';
}
$sql = $bdd->query("SELECT * FROM gabcms_config WHERE id = '1'");
$cof = $sql->fetch(PDO::FETCH_ASSOC);	
?>
<link rel="stylesheet" href="css/contenu.css" type="text/css" media="screen" /><body>
<span id="titre">Ajouter un site de fan</span><br />
Ajoutes plusieurs sites de fans qui seront affichés sur le site.
<br/><br/><img src="<?PHP echo $imagepath; ?>images/sitedefan/habbo_friends<?PHP echo $cof['img_sdf']; ?>.png" ALIGN=RIGHT>
<form name='editor' method='post' action="?do=add_sdf">
<td width='100' class='tbl'><b>URL de ton site de fan :</b><br/></td>
<td width='80%' class='tbl'>HTTP://<input type='text' name='url' class='text' style='width: 240px' maxlength="543"><br/></td>
<td width='100' class='tbl'><b>Nom de ton site de fan :</b><br/></td>
<td width='80%' class='tbl'><input type='text' name='nom' class='text' style='width: 240px' maxlength="100"><br/></td>
<br/>
<tr>
<td align='center' colspan='2' class='tbl'>
<input type='submit' name='submit' value='Exécuter' class='submit'></form>
</tr>
<hr/>
<span id="titre">Supprimes des site de fans</span><br/>
Supprimes des sites de fans de la liste affichée sur le serveur.<br/><br/>
<table>
    <tbody>
        <tr class="haut">
            <td class="haut">URL</td>
            <td class="haut">Nom du site</td>
            <td class="haut">Action</td>
        </tr>
<?PHP $sql = $bdd->query("SELECT * FROM gabcms_sitedefan ORDER BY id DESC");
 while($a = $sql->fetch()) {
?>
        <tr class="bas">
            <td class="bas"><?PHP echo $a['url']; ?></td>
            <td class="bas"><?PHP echo $a['nom']; ?></td>
            <td class="bas"><a href="?sup=<?PHP echo $a['id']; ?>" onclick="return confirm('Es-tu certain de supprimer ce site fan ?')">Supprimer</a></td>
        </tr>
<?PHP } ?>
    </tbody>
</table>
</body>
</html>