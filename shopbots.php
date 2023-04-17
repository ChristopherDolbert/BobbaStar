<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|           GabCMS - Site Web et Content Management System               #|
#|         Copyright © 2012-2014 - Gabodd Tout droits réservés.           #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

	include("./config.php");
	$pagename = "Vente de bots";
	$pageid = "shopbots";
	
if(!isset($_SESSION['username']))
	{
		Redirect("".$url."/index");
	}
	
$cof_prix = $bdd->query("SELECT * FROM gabcms_config_prix WHERE id = '1'");
$cp = $cof_prix->fetch();

if(isset($_GET['buy'])) {
	$do = Secu($_GET['buy']);
	if($do == "1") {
	   if ($user['jetons'] >= $cp['bots']){
	       if(isset($_POST['text']) && isset($_POST['missions']) && isset($_POST['roomid']) && ($_POST['nom'])) {
            $text = Secu($_POST['text']);
            $motto = Secu($_POST['missions']);
            $room_id = Secu($_POST['roomid']);
            $nom_bot = Secu($_POST['nom']);
	           $userrooms2 = $bdd->query("SELECT * FROM rooms WHERE id = '".$room_id."' AND owner = '".$user['username']."'");
                        if($userrooms2->rowCount() == 0)
                        {
                                $affichage = "<div id=\"purse-redeem-result\"> 
                        <div class=\"redeem-error\"> 
                            <div class=\"rounded rounded-red\">Tu n'as pas d'appart.</div> 
                        </div> 
                </div>";
                        } else {
                    $userrooms = $bdd->query("SELECT * FROM rooms WHERE owner = '".$user['username']."'");
                        if($userrooms->rowCount() == 0)
                        {
                                $affichage = "<div id=\"purse-redeem-result\"> 
                        <div class=\"redeem-error\"> 
                            <div class=\"rounded rounded-red\">Tu n'as pas d'appart, va vite t'en créer un!</div> 
                        </div> 
                </div>";
                        } else {
                    if(strlen($text) > 100){
                            $affichage = "<div id=\"purse-redeem-result\"> 
                        <div class=\"redeem-error\"> 
                            <div class=\"rounded rounded-red\">La phrase de ton bot est trop longue</div> 
                        </div> 
                </div>";
                            } else {
                    if(strlen($motto) > 38){
                            $affichage = "<div id=\"purse-redeem-result\"> 
                        <div class=\"redeem-error\"> 
                            <div class=\"rounded rounded-red\">La mission de ton bot est trop longue</div> 
                        </div> 
                </div>";
                            } else {
                    if(strlen($nom_bot) < 3){
                            $affichage = "<div id=\"purse-redeem-result\"> 
                        <div class=\"redeem-error\"> 
                            <div class=\"rounded rounded-red\">Le nom de ton bot est trop court</div> 
                        </div> 
                </div>";
                            }  else {
                if (strlen($nom_bot) > 25){
                $affichage = "<div id=\"purse-redeem-result\"> 
                        <div class=\"redeem-error\"> 
                            <div class=\"rounded rounded-red\"> 
                              Le nom de ton bot est trop long
                            </div> 
                        </div> 
                </div><br/>";
                } else {
                $jetons = $cp['bots'];
                        $insertn1 = $bdd->prepare("INSERT INTO bots (name, room_id, motto, ai_type, look, walk_mode, rotation, x, y, z, min_x, max_x, min_y, max_y) VALUES (:name, :room, :motto, :type, :look, :mode, :zero, :zero, :zero, :zero, :zero, :zero, :zero, :zero);");
                            $insertn1->bindValue(':name', $nom_bot);
                            $insertn1->bindValue(':room', $room_id);
                            $insertn1->bindValue(':motto', $motto);
                            $insertn1->bindValue(':type', 'generic');
                            $insertn1->bindValue(':look', $user['look']);
                            $insertn1->bindValue(':mode', 'freeroam');
                            $insertn1->bindValue(':zero', '0');
                        $insertn1->execute();
                            $id = $bdd->lastInsertId();
                            $bot_id = $id;
                        $insertn2 = $bdd->prepare("INSERT INTO bots_speech (bot_id, text, shout) VALUES (:bot, :text, :zero);");
                            $insertn2->bindValue(':bot', $bot_id);
                            $insertn2->bindValue(':text', $text);
                            $insertn2->bindValue(':zero', '0');
                        $insertn2->execute();
                            $bdd->query("UPDATE users SET jetons = jetons - '".$jetons."' WHERE username = '".$user['username']."'");
                        $insertn3 = $bdd->prepare("INSERT INTO gabcms_transaction (user_id, produit, prix, gain, date) VALUES (:userid, :produit, :prix, :gain, :date)");
                            $insertn3->bindValue(':userid', $user['id']);    
                            $insertn3->bindValue(':produit', 'Achat bots');
                            $insertn3->bindValue(':prix', $jetons);
                            $insertn3->bindValue(':gain', '-');
                            $insertn3->bindValue(':date', FullDate('full'));
                        $insertn3->execute();
                       $affichage = "<div id=\"purse-redeem-result\"> 
                        <div class=\"redeem-error\"> 
                            <div class=\"rounded rounded-green\"> 
                               Ton bot a été crée! Va vite voir dans ton appart!
                            </div> 
                        </div>
                </div><br/>";
                }
                    }
                    }
                    }
                        }
                        }
           }
        } else {
        $affichage = "<div id=\"purse-redeem-result\"> 
                <div class=\"redeem-error\"> 
                    <div class=\"rounded rounded-red\"> 
                       Tu n'as pas assez de jetons!<br/><a href=\"".$url."/jetons\">Clique ici pour en acheter.</a>
                    </div> 
                </div> 
        </div><br/>";
       }
	}
}
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
<script src="<?PHP echo $imagepath;?>js/tooltip.js" type="text/javascript"></script>
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

<body id="home" class=" "> 
<div id="tooltip"></div>
<div id="overlay"></div> 
<!-- MENU -->
<?PHP include("./template/header.php");?>
<!-- FIN MENU -->

<div id='container'>
<div id='content'>
<div id='column1' class='column'>
           
<div class="habblet-container ">		
						<div class="cbb clearfix blue">
	
							<h2 class="title">Boutique de bots
							</h2>
						 <div class="box-content">
					<center>
			<form action="?buy=1" method="post" id="profileForm"> 
<div style="float:left;"><img src="https://avatar.myhabbo.fr/?figure=<?php echo $user['look'];?>&action=std&gesture=srp&direction=3&head_direction=2&size=1&img_format=gif" /></div>
<b>Nom de ton bot :</b> <input type="text" name="nom" size="25" maxlength="25" value="" id="avatarmotto" />
<br/><br/>
<b>Mission du bot :</b> <input type="text" name="missions" size="38" maxlength="38" value="" id="avatarmotto" />
<br/><br/>
<b>Phrase du bot :</b> <input type="text" name="text" size="50" maxlength="200" value="" id="avatarmotto" />
<br/><br/>
<b>Appart du bot :</b> <?php
		$userrooms = $bdd->query("SELECT * FROM rooms WHERE owner = '".$user['username']."'");
		if($userrooms->rowCount() == 0)
		{
			echo '<strong>Tu n\'as pas d\'appart, vas vite t\'en créer un!</strong>';
		}
		else {
		echo "<SELECT NAME='roomid' onChange='FocusObjet()'>"; 
		while($userroom = $userrooms->fetch())
		{
		echo "<OPTION VALUE='$userroom[0]'>$userroom[2]</OPTION>\n"; 
		}
		echo "</SELECT>"; 
		}
?>
<br/><br/><input type="submit" name="bots" value="Créer mon bot" />
</form>
				<font color="#6699FF"><h3><u><b>Prix: <?PHP echo $cp['bots'] ?> jetons</b></u></h3></font></center>		
			</div>
		</div>
	</div>
</div>

<div id="column2" class="column">
    <div class="habblet-container">        
        <div class="cbb clearfix green ">                                                 
            <h2 class='title'>Ton porte monnaie</h2>
                <div id="purse-habblet">       
                    <ul>
                        <li class="even icon-purse-jetons">
                            <div>Vous avez actuellement:</div>
                            <span class="purse-balance-amount"><?PHP echo $user['jetons'];?> Jetons</span>
                        </li>
                        <li class="odd">
                           <div class="box-content">
                                Tu as un code promo de jetons ? <a href="<?PHP echo $url; ?>/code_promo">Clique ici pour l'utiliser</a>
                                <?PHP if(isset($affichage)) { echo "<br/>".$affichage.""; }?>
                           </div>
                        </li>
                    </ul>
                </div>
        </div>
	</div>
		<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>                            
</div>
<div id="column2" class="column">
                <div class="habblet-container ">        
                        <div class="cbb clearfix brown ">     
  <h2 class="title">Comment le faire apparaître ?</h2>
<div class="box-content">
Entre dans ton appartement où tu as créé ton bot et entre les commandes suivantes:<br/>
- <b>:update_bots</b><br/>- <b>:unload</b> <br/><br/>(Si la commande <b>:update_bots</b> ne marche pas demande à un staff de le faire pour toi)

</div>
                    </div>
                </div>
                <script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>         
</div>
                             
</div>
<script type="text/javascript">
HabboView.run();
</script>    
                </div>
               
	<!--[if lt IE 7]>
<script type="text/javascript">
Pngfix.doPngImageFix();
</script>
<![endif]--> 
<!-- FOOTER -->
<?PHP include("./template/footer.php");?>
<!-- FIN FOOTER -->
<div style="clear: both;"></div>

<script type="text/javascript"> 
HabboView.run();

</script>
</body> 
</html> 