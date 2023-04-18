<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
	
	include("./config.php");
	$pagename = "Recrutements &raquo; Depôt de candidature";
	$pageid = "recrut";
	
if(!isset($_SESSION['username']))
	{
		Redirect("".$url."/index");
	}
$sql = $bdd->query("SELECT * FROM gabcms_config WHERE id = '1'");
$cof = $sql->fetch(PDO::FETCH_ASSOC);
$id = Secu($_GET['id']);

$info = $bdd->query("SELECT * FROM gabcms_recrutement WHERE id = '".$id."'");
$i = $info->fetch();
			$date_but = date('d/m/Y', $i['date_butoire']);
			
if(isset($_POST['cv']) && isset($_POST['age'])) {
   $cv = Secu($_POST['cv']);
   $age = Secu($_POST['age']);
      if($i['date_butoire'] >= $nowtime && $age != "" && $cv != "") {
			$insertn1 = $bdd->prepare("INSERT INTO gabcms_recrutement_dossier (id_recrut, pseudo, date, age, cv) VALUES (:id, :pseudo, :date, :age, :cv)");
                $insertn1->bindValue(':id', $id);
                $insertn1->bindValue(':pseudo', $user['username']);
                $insertn1->bindValue(':date', FullDate('full'));
                $insertn1->bindValue(':age', $age);
                $insertn1->bindValue(':cv', addslashes($_POST['cv']));
            $insertn1->execute();
		    $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-green\"> 
              Ta candidature a bien été prise en compte, et sera traîtée en même temps que les autres postulants
            </div> 
        </div> 
</div>";
			} else if($cv == "" && $age == "") {
			$affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
               Merci de renseigner les champs vides.
            </div> 
        </div> 
</div>";
			} else if($age == "") {
			$affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
               Merci de renseigner ton âge
            </div> 
        </div> 
</div>";
			} else if($cv == "") {
			$affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
               Merci de marquer quelque chose dans ton CV
            </div> 
        </div> 
</div>";
			} else if($i['date_butoire'] < $nowtime) {
			$affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
               La date butoire est dépassée.
            </div> 
        </div> 
</div>";
			} else {
			$affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
               Une erreur est survenue.
            </div> 
        </div>  
</div>";
		} 
	}
			$correct = $bdd->query("SELECT * FROM gabcms_postes_noms WHERE id = '".$i['poste']."'");
			$caz = $correct->fetch();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head> 
<meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
<title><?PHP echo $sitename;?> &raquo; <?PHP echo $pagename;?></title> 
 
<script type="text/javascript"> 
var andSoItBegins = (new Date()).getTime();
var ad_keywords = "";
document.habboLoggedIn = true;
var habboName = "<?PHP echo $user['username'];?>";
var habboReqPath = "<?PHP echo $url;?>";
var habboStaticFilePath = "<?PHP echo $imagepath;?>";
var habboImagerUrl = "http://www.habbo.com/habbo-imaging/";
var habboPartner = "";
var habboDefaultClientPopupUrl = "<?PHP echo $url;?>/client";
window.name = "habboMain";
if (typeof HabboClient!= "undefined") { HabboClient.windowName = "uberClientWnd"; }
</script> 



<link rel="shortcut icon" href="<?PHP echo $imagepath;?>favicon.ico" type="image/vnd.microsoft.icon" /> 
<script src="<?PHP echo $imagepath;?>static/js/libs2.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath;?>static/js/visual.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath;?>static/js/libs.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath;?>static/js/common.js" type="text/javascript"></script>
<script type="text/javascript" src="<?PHP echo $imagepath;?>editor/ckeditor.js"></script>
<script type="text/javascript" src="<?PHP echo $imagepath;?>editor/config.js"></script>
<script src="<?PHP echo $imagepath;?>static/js/fullcontent.js" type="text/javascript"></script>

<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/style.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/buttons.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/boxes.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/tooltips.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/personal.css" type="text/css" />
<script src="<?PHP echo $imagepath;?>static/js/habboclub.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/minimail.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/myhabbo/control.textarea.css" type="text/css" />
<script src="<?PHP echo $imagepath;?>static/js/minimail.js" type="text/javascript"></script>

 

<meta name="description" content="<?PHP echo $description;?>" /> 
<meta name="keywords" content="<?PHP echo $keyword;?>" />  
<!--[if IE 8]>
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/ie8.css" type="text/css" />
<![endif]--> 
<!--[if lt IE 8]>
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/ie.css" type="text/css" />
<![endif]--> 
<!--[if lt IE 7]>
<link rel="stylesheet" href="<?PHP echo $imagepath;?>v2/styles/ie6.css" type="text/css" />
<script src="<?PHP echo $imagepath;?>static/js/pngfix.js" type="text/javascript"></script>
<script type="text/javascript">
try { document.execCommand('BackgroundImageCache', false, true); } catch(e) {}
</script>
 
<style type="text/css"> 
body { behavior: url(http://www.habbo.com/js/csshover.htc); }
</style>
<![endif]--> 
<meta name="build" content="<?PHP echo $build;?> >> <?PHP echo $version;?>" /> 
</head>
<body id="news" class=" "> 
<div id="overlay"></div> 
<!-- MENU -->
<?PHP include("./template/header.php");?>
<!-- FIN MENU -->
<div id="container"> 
	<div id="content" style="position: relative" class="clearfix"> 
		<div id="column1" class="column"> 
			<div class="habblet-container ">		
				<div class="cbb clearfix blue "> 
					<h2 class="title">Informations 
					</h2> 
				<div id="article-archive">		
Poste à pourvoir: <b><?PHP echo Secu($caz['nom_M']); ?></b><br/><br/>
Date de publication: <b><?PHP echo Secu($i['date']); ?></b><br/><br/>
Date butoire: <b><?PHP echo Secu($date_but); ?></b><br/><br/>
Nombre de postulant: <b><?php $req = "SELECT COUNT(*) AS id FROM gabcms_recrutement_dossier WHERE id_recrut = '".$id."'";
$query = $bdd->query($req);
$nb_inscrit = $query->fetch();
echo Secu($nb_inscrit['id']);
?></b>
<?PHP if(isset($affichage)) { echo "<br/>".$affichage.""; }?>
</div> 
	</div> 
		</div> 
			<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script> 
				</div> 
			<div id="column2" class="column"> 
		<div class="habblet-container ">		
	<div class="cbb clearfix green"><h2 class="title">Depot de candidature - <?PHP echo $caz['nom_M'];?></h2>
<div class="box-content"> 
<?PHP
if($cof['aff_aidmotiv'] == '1') {
$modif_aide = "<a href=\"".$imagepath."v2/images/LettreMotivation.png\" target=\"_blank\">Aide motivation</a><br/><br/>";
}
if($cof['aff_aidmotiv'] == '2') {
$modif_aide = "";
}
$search = $bdd->query("SELECT pseudo FROM gabcms_recrutement_dossier WHERE id_recrut = '".$id."' AND pseudo = '".$user['username']."'");
$ok = $search->fetch();
if($i['date_butoire'] >= $nowtime && $ok['pseudo'] != $user['username']) { ?><span style="color:#FF0000;">Sachez que vous ne pourrez rien modifier après que votre candidature est été envoyée.</span><br/><br/>
<?PHP echo $modif_aide; ?>
<form name="editor" method="post" action="#">
<td width='100' class='tbl'><b>Age:</b><br/></td>
<td width='80%' class='tbl'>
<label><input type="radio" name="age" value="- 12 ans" <?php if (isset($_POST['age']) && $_POST['age']=="- 12 ans") echo 'checked="checked"';?> />- de 12 ans</label> 
<label><input type="radio" name="age" value="12 - 14 ans" <?php if (isset($_POST['age']) && $_POST['age']=="12 - 14 ans") echo 'checked="checked"';?> />12 - 14 ans</label> 
<label><input type="radio" name="age" value="14 - 16 ans" <?php if (isset($_POST['age']) && $_POST['age']=="14 - 16 ans") echo 'checked="checked"';?> />14 - 16 ans</label> 
<label><input type="radio" name="age" value="16 - 18 ans" <?php if (isset($_POST['age']) && $_POST['age']=="16 - 18 ans") echo 'checked="checked"';?> />16 - 18 ans</label> 
<label><input type="radio" name="age" value="+ 18 ans" <?php if (isset($_POST['age']) && $_POST['age']=="+ 18 ans") echo 'checked="checked"';?> />+ 18 ans</label> 
<br/><br/> 
<td width='100' class='tbl'><b>Lettre de motivation:</b><br/></td>
<textarea name='cv' rows="5" cols="50" id="editor1"><?php
 if (isset($_POST["cv"])) {
 echo htmlspecialchars($_POST["cv"],ENT_QUOTES);
 }
?></textarea>
<script>CKEDITOR.replace( 'editor1', { toolbar: 'Recrutements' });</script><br/>
<input type='submit' name='submit' value='Exécuter' class='submit'></form>
<?PHP }
if($i['date_butoire'] < $nowtime) { ?>
<center><span style="color:#FF0000;"><b>La date butoire est dépassée!</b></span><br/><a href="<?PHP echo $url ?>/recrutement">Revenir à la page de recrutement</a></center>
<?PHP }
if($ok['pseudo'] == $user['username']) { ?>
<center>Vous avez déjà postuler, vous ne pouvez pas postulé deux fois au même poste.<br/><a href="<?PHP echo $url; ?>/recrutement">Revenir à la page de recrutement</a></center> 
<?PHP } ?>
</div> 
	</div>
		</div>
			</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script> 
</div> </div>
<!-- FOOTER -->
<?PHP include("./template/footer.php");?>
<!-- FIN FOOTER -->
<script type="text/javascript"> 
HabboView.run();
</script>
</body> 
</html>