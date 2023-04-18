<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
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
?>
<link rel="stylesheet" href="css/contenu.css" type="text/css" media="screen" /><body>
<span id="titre">Transactions des utilisateurs</span><br />
Regardes les transactions des utilisateurs que tu souhaites.<br/><br/>
<form method='post' action="?do=lookup">
<b>Pseudo :</b><br />
<input type="text" name="username" maxlength="50"><br/>
<input type="submit" value="Rechercher">
</form>
<table>
    <tbody>
        <tr class="haut">
            <td class="haut">Produit</td>
            <td class="haut">Prix</td>
            <td class="haut">Date</td>
        </tr>
<?PHP
if(isset($_GET['do'])) {
$do = Secu($_GET['do']);
    if($do == "lookup") {
    $req = $bdd->query("SELECT * FROM users WHERE username = '".$_POST['username']."'");
    $row = $req->rowCount();
    $req_assoc = $req->fetch(PDO::FETCH_ASSOC);	
        if($row > 0) {
            $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
                $insertn1->bindValue(':pseudo', $user['username']);
                $insertn1->bindValue(':action', 'a regardé les transactions de <b>'.$req_assoc['username'].'</b>');
                $insertn1->bindValue(':date', FullDate('full'));
            $insertn1->execute(); 
    echo 'Tu viens d\'effectuer une recherche sur <b>'.$req_assoc['username'].'</b>';
            $transac = $bdd->query("SELECT * FROM gabcms_transaction WHERE user_id = '".$req_assoc['id']."' ORDER BY id DESC");
            while($t = $transac->fetch()) {

    if($t['gain'] == '+') {
    $modif_color = 'green';
    } if($t['gain'] == '-') {
    $modif_color = 'red';
    } 
?>
        <tr class="bas">
            <td class="bas"><?PHP echo $t['produit']; ?></td>
            <td class="bas"><span style="color:<?PHP echo $modif_color; ?>"><b><?PHP echo $t['gain']; echo $t['prix']; ?></b></td>
            <td class="bas"><?PHP echo $t['date']; ?></td>
        </tr>
<?PHP } } else {
echo '<h4 class="alert_error">Le pseudo n\'existe pas</h4>';
} } } ?>
    </tbody>
</table>
</body>
</html>