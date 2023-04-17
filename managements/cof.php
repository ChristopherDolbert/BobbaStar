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
	
	if($user['rank'] < 8) {
	Redirect("".$url."/managements/acces_neg");
	exit();
	}
	if($user['rank'] > 8) {              
	Redirect("".$url."/managements/acces_neg");
	exit();
	}	
	if(isset($_POST['news']) || isset($_POST['flux']) || isset($_POST['forum']) || isset($_POST['tchat']) || isset($_POST['img_sdf']) || isset($_POST['aff_aidmotiv'])) {
   $nb_news = Secu($_POST['news']);
   $nb_flux = Secu($_POST['flux']);
   $nb_tchat = Secu($_POST['tchat']);
   $nb_com = Secu($_POST['forum']);
   $aff_aidmotiv = Secu($_POST['aff_aidmotiv']);
   $img_sdf = Secu($_POST['img_sdf']);
      if($nb_news != "" && $nb_flux != "" && $nb_tchat != "" && $nb_com != "" && $nb_com != "0" && $nb_news != "0" && $nb_flux != "0" && $nb_tchat != "0" && $img_sdf != "" && $aff_aidmotiv != "") {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a mis à jour les <b>modifications générales</b>');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
        $bdd->query("UPDATE gabcms_config SET nb_com = '".$nb_com."', img_sdf = '".$img_sdf."', aff_aidmotiv = '".$aff_aidmotiv."', nb_tchat = '".$nb_tchat."', nb_news = '".$nb_news."', nb_flux = '".$nb_flux."' WHERE id = 1");
	  echo '<h4 class="alert_success">Tes informations sont maintenant disponible sur le site.</h4>';
	  } else {
	  echo '<h4 class="alert_error">Merci de marquer une information valide (pas en dessous de 1).</h4>';
	  }
  }
$sql = $bdd->query("SELECT * FROM gabcms_config WHERE id = '1'");
$cof = $sql->fetch(PDO::FETCH_ASSOC);
?>
<link rel="stylesheet" href="css/contenu.css" type="text/css" media="screen" /><body>
<span id="titre">Configuration générale</span><br/>
Modifie les données sur le nombre de news, flux, tchat affiché par page. Saches que tu ne dois pas mettre un nombre égal ou inférieur à 0. <br/><br/>
<script type="text/javascript" src="editeur_html/jscripts/tiny_mce/tiny_mce.js"></script>
 <form name='editor' method='post' action="?do=cof">
<td width='100' class='tbl'><b>Nombre de news à afficher :</b><br/></td>
<td width='80%' class='tbl'><input type='text' name='news' value="<?PHP echo $cof['nb_news']; ?>" class='text' style='width: 240px' maxlength="2"><br/></td>
<br/>
<td width='100' class='tbl'><b>Nombre de Flux à afficher :</b><br/></td>
<td width='80%' class='tbl'><input type='text' name='flux' value="<?PHP echo $cof['nb_flux']; ?>" class='text' style='width: 240px' maxlength="2"><br/></td>
<br/>
<td width='100' class='tbl'><b>Nombre de tchat par page :</b><br/></td>
<td width='80%' class='tbl'><input type='text' name='tchat' value="<?PHP echo $cof['nb_tchat']; ?>" class='text' style='width: 240px' maxlength="2"><br/></td>
<br/>
<td width='100' class='tbl'><b>Nombre de commentaire par page sur le forum :</b><br/></td>
<td width='80%' class='tbl'><input type='text' name='forum' value="<?PHP echo $cof['nb_com']; ?>" class='text' style='width: 240px' maxlength="2"><br/></td>
<br/>
<td width='100' class='tbl'><b>Afficher <a href="<?PHP echo $imagepath; ?>v2/images/LettreMotivation.png" target="_blank">l'aide motivation</a> :</b><br/></td>
<label><input type="radio" name="aff_aidmotiv" value="1" <?PHP if($cof['aff_aidmotiv'] == "1") { ?> checked="checked" <?PHP } ?> />Oui</label> 
<label><input type="radio" name="aff_aidmotiv" value="2" <?PHP if($cof['aff_aidmotiv'] == "2") { ?> checked="checked" <?PHP } ?> />Non</label><br/>
<br/>
<td width='100' class='tbl'><b>Image a afficher dans la page site de fan :</b><br/></td>
<label><input type="radio" name="img_sdf" value="1" <?PHP if($cof['img_sdf'] == "1") { ?> checked="checked" <?PHP } ?> /><img alt="1" src="<?PHP echo $imagepath; ?>images/sitedefan/habbo_friends1.png" style="height:128px; width:150px" /></label> 
<label><input type="radio" name="img_sdf" value="2" <?PHP if($cof['img_sdf'] == "2") { ?> checked="checked" <?PHP } ?> /><img alt="2" src="<?PHP echo $imagepath; ?>images/sitedefan/habbo_friends2.png" style="height:128px; width:150px" /></label> 
<label><input type="radio" name="img_sdf" value="3" <?PHP if($cof['img_sdf'] == "3") { ?> checked="checked" <?PHP } ?> /><img alt="3" src="<?PHP echo $imagepath; ?>images/sitedefan/habbo_friends3.png" style="height:128px; width:150px" /></label> 
<br/>
<td align='center' colspan='2' class='tbl'>
<input type='submit' name='submit' value='Exécuter' class='submit'></form>
</tr>
<br/>
</body>
</html>