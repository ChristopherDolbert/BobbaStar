<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|           GabCMS - Site Web et Content Management System               #|
#|         Copyright © 2012-2015 - Gabodd Tout droits réservés.           #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

	include("./config.php");
	$pagename = "Clubs";
	$pageid = "clubs";
	
if(!isset($_SESSION['username']))
	{
		Redirect("".$url."/index");
	}
	
$cof_prix = $bdd->query("SELECT * FROM gabcms_config_prix WHERE id = '1'");
$cp = $cof_prix->fetch();

if(isset($_GET['do'])) {
	$do = Secu($_GET['do']);
		if($do == "vipclub") {
			$prix_ticket = Secu($_POST['transaction_vip']); 
			if($user['jetons'] >= $cp['vipclub'] && $user['id'] != "" && $prix_ticket == $cp['vipclub']) {
				if($user['rank'] < '4') {
                $bdd->query("UPDATE users SET jetons = jetons - ".$cp['vipclub'].", rank = '2', vip = '1', credits = credits + 30000, activity_points = activity_points + 30000 WHERE id = '".$user['id']."'");
$insert_badge = $bdd->query("SELECT * FROM gabcms_config_badges WHERE club = '1'");
                while($i = $insert_badge->fetch()) {		
                    $bdd->query("INSERT INTO user_badges(user_id, badge_id) VALUES ('".$user['id']."', '".$i['badge_id']."')");
                }
            $insertn1 = $bdd->prepare("INSERT INTO gabcms_transaction (user_id, produit, prix, gain, date) VALUES (:userid, :produit, :prix, :gain, :date)");
                $insertn1->bindValue(':userid', $user['id']);    
                $insertn1->bindValue(':produit', 'Achat VIP Club');
                $insertn1->bindValue(':prix', $cp['vipclub']);
                $insertn1->bindValue(':gain', '-');
                $insertn1->bindValue(':date', FullDate('full'));
            $insertn1->execute();
            $insertn2 = $bdd->prepare("INSERT INTO gabcms_alertes (userid,sujet,alerte,par,date,look,action) VALUES (:userid, :sujet, :alerte, :par, :date, :look, :action)");
                $insertn2->bindValue(':userid', $user['id']);
                $insertn2->bindValue(':sujet', 'VIP club');
                $insertn2->bindValue(':alerte', 'Bonjour '.$user['username'].',<br/><br/>Tu viens de t\'abonner au <b>VIP club</b> pour seulement <b>'.$cp['vipclub'].' jetons</b>. Ces jetons ont été retirés de ton porte-feuille.<br/><br/>Profites bien de tes avantages !');
                $insertn2->bindValue(':par', 'Système');
                $insertn2->bindValue(':date', FullDate('full'));
                $insertn2->bindValue(':look', 'hr-828-45.lg-285-64.ch-215-110.hd-180-2.sh-290-62.he-1607-');
                $insertn2->bindValue(':action', '0');
            $insertn2->execute();
            $insertn3 = $bdd->prepare("INSERT INTO gabcms_management (user_id,message,auteur,date,look) VALUES (:userid, :message, :auteur, :date, :look)");
                $insertn3->bindValue(':userid', $user['id']);
                $insertn3->bindValue(':message', 'Une alerte vient de t\'être envoyée au sujet du VIP CLUB. Merci d\'aller la lire au <b>PLUS VITE</b> en <a href=\"'.$url.'/alerts\">cliquant ici</a> !');
                $insertn3->bindValue(':auteur', 'Système');
                $insertn3->bindValue(':date', FullDate('full'));
                $insertn3->bindValue(':look', 'hr-828-45.lg-285-64.ch-215-110.hd-180-2.sh-290-62.he-1607-');
            $insertn3->execute();
			$affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-green\"> 
              Bien jou&eacute;! Ta demande d'abonnement &agrave; &eacute;t&eacute; accept&eacute;! Tu fais maintenant partie du <b>VIP CLUB</b>!
            </div> 
        </div> 
</div>";
			} else {
			$affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
               Tu n'as pas le rank requis pour adhérer au groupe.
            </div> 
        </div> 
</div>";
			} } else {
			$affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
               Tu n'as pas assez de jetons pour adh&eacute;rer au VIP CLUB!
            </div> 
        </div> 
</div>";
			}
		}

        if($do == "staffclub") {
			$prix_ticket_staff = Secu($_POST['transaction_staff']); 
			if($user['jetons'] >= $cp['staffclub'] && $user['id'] != "" && $prix_ticket_staff == $cp['staffclub']) {
				if($user['rank'] < '4') {
			         $bdd->query("UPDATE users SET jetons = jetons - ".$cp['staffclub'].", rank = '3', vip = '1', credits = credits + 50000, activity_points = activity_points + 50000 WHERE id = '".$user['id']."'");
                        $insert_badge = $bdd->query("SELECT * FROM gabcms_config_badges WHERE club = '2'");
                         while($i = $insert_badge->fetch()) {		
                        $bdd->query("INSERT INTO user_badges (user_id,badge_id) VALUES ('".$user['id']."','".$i['badge_id']."')");
                        }
                $ewui = $bdd->prepare("INSERT INTO messenger_friendships (user_one_id,user_two_id) VALUES (:one, :two)");
                    $ewui->bindValue(':one', '1');
                    $ewui->bindValue(':two', $user['id']);
                $ewui->execute();
                $ewai = $bdd->prepare("INSERT INTO messenger_friendships (user_one_id,user_two_id) VALUES (:one, :two)");
                    $ewai->bindValue(':two', '1');
                    $ewai->bindValue(':one', $user['id']);
                $ewai->execute();
                $insertn1 = $bdd->prepare("INSERT INTO gabcms_transaction (user_id, produit, prix, gain, date) VALUES (:userid, :produit, :prix, :gain, :date)");
                    $insertn1->bindValue(':userid', $user['id']);    
                    $insertn1->bindValue(':produit', 'Achat STAFF Club');
                    $insertn1->bindValue(':prix', $cp['staffclub']);
                    $insertn1->bindValue(':gain', '-');
                    $insertn1->bindValue(':date', FullDate('full'));
                $insertn1->execute();
                $insertn2 = $bdd->prepare("INSERT INTO gabcms_alertes (userid,sujet,alerte,par,date,look,action) VALUES (:userid, :sujet, :alerte, :par, :date, :look, :action)");
                    $insertn2->bindValue(':userid', $user['id']);
                    $insertn2->bindValue(':sujet', 'STAFF club');
                    $insertn2->bindValue(':alerte', 'Bonjour '.$user['username'].',<br/><br/>Tu viens de t\'abonner au <b>STAFF club</b> pour seulement <b>'.$cp['staffclub'].' jetons</b>. Ces jetons ont été retirés de ton porte-feuille.<br/><br/>Profites bien de tes avantages !');
                    $insertn2->bindValue(':par', 'Système');
                    $insertn2->bindValue(':date', FullDate('full'));
                    $insertn2->bindValue(':look', 'hr-828-45.lg-285-64.ch-215-110.hd-180-2.sh-290-62.he-1607-');
                    $insertn2->bindValue(':action', '0');
                $insertn2->execute();
                $insertn3 = $bdd->prepare("INSERT INTO gabcms_management (user_id,message,auteur,date,look) VALUES (:userid, :message, :auteur, :date, :look)");
                    $insertn3->bindValue(':userid', $user['id']);
                    $insertn3->bindValue(':message', 'Une alerte vient de t\'être envoyée au sujet du STAFF CLUB. Merci d\'aller la lire au <b>PLUS VITE</b> en <a href=\"'.$url.'/alerts\">cliquant ici</a> !');
                    $insertn3->bindValue(':auteur', 'Système');
                    $insertn3->bindValue(':date', FullDate('full'));
                    $insertn3->bindValue(':look', 'hr-828-45.lg-285-64.ch-215-110.hd-180-2.sh-290-62.he-1607-');
                $insertn3->execute();
		   $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-green\"> 
              Bien jou&eacute;! Ta demande d'abonnement &agrave; &eacute;t&eacute; accept&eacute;! Tu fais maintenant partie du <b>STAFF CLUB</b>!
            </div> 
        </div> 
</div>";
			} else {
			$affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
               Tu n'as pas le rank requis pour adhérer au groupe.
            </div> 
        </div> 
</div>";
			} } else {
			$affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
               Tu n'as pas assez de points pour adh&eacute;rer au <b>STAFF CLUB</b>!
            </div> 
        </div> 
</div>";
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
var habboImagerUrl = "http://www.habbo.co.uk/habbo-imaging/";
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
 
<link rel="stylesheet" href="<?PHP echo $url;?>/web-gallery/static/styles/cbs2credits.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $url;?>/web-gallery/static/styles/newcredits.css" type="text/css" />
<script src="<?PHP echo $imagepath;?>static/js/cbs2credits.js" type="text/javascript"></script>


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

<div class="habblet-container" id="okt" style="float:left; width: 770px;">		
<div class="cbb clearfix orange ">
<div class="campaign-banner-vip">
    <div style="padding-top: 5px;"></div>
    <div class="campaign-banner-monsterplant-header-container-left">
        <div class="campaign-banner-monsterplant-header-mid">
            <div class="campaign-banner-monsterplant-header-inner"></div>
        </div>
    </div>
    <div class="campaign-banner-monsterplant-header-container-right">
        <div class="campaign-banner-monsterplant-info-mid">
        </div>
    </div> 
	

	
    <div class="campaign-banner-monsterplant-status-line-container">

	
</div>
</div>
               
            <div class="method-group phone clearfix   cbs2">
<?PHP if(isset($affichage)) { echo "".$affichage."<br/><br/>"; }?>
<div class="method idx0 m-smsma nosmallprint">
    
    <div class="method-content">
    <h2><font color="#263778">VIP CLUB</font></h2><div class="top"><div></div></div>
        <div class="summary clearfix">
            <ol>
<div>Le VIP Club, c'est un club auquel, tu peux avoir certains avantages! <br/><br/>Il te permet d'avoir plus de commandes, plus de mobis,<br/>donc de mieux découvrir <?PHP echo $sitename;?><br/><br/>Chaque star de <?PHP echo $sitename;?> est passée par le fameux VIP Club, <br/>alors n'attends plus... Rejoins le.
<br/><h3><b><br/>
<img src="<?PHP echo $imagepath;?>v2/images/attention.gif"> PRIX = <?PHP echo $cp['vipclub'] ?> JETONS</b></h3></div></ol>     
<form name="editor" method="post" action="?do=vipclub"><input type="hidden" name="transaction_vip" value="<?PHP echo $cp['vipclub'] ?>" /><center><input type="submit" name="submit" value="Adhérer au VIP CLUB" /></center> </form>
                                        <div style="float: right; padding: 0 15px 15px 0; ">
                                <br/>

</p>
                            </div>
        </div>
    </div>
                    <div class="price">
                        <div>
                            <div>
            <br/><div class="pricepoint-price-container"><font color="#5D658C">PROMO</font></div>
			 <div class="pricepoint-amount-container">
               <img src="<?PHP echo $imagepath;?>v2/images/divers/ACH_VipClub12.gif">
            </div>
                            </div>
                        </div>
                    </div>

<div class="bottom"><div></div></div></div>

<div class="method idx0 m-smsma nosmallprint">
    
    <div class="method-content">
        <h2><font color="#263778">AVANTAGES</font></h2><div class="top"><div></div></div>

        <div class="summary clearfix">
<ol><div>
• <?php $req = "SELECT COUNT(*) AS id FROM gabcms_config_badges WHERE club = '1'";
$query = $bdd->query($req);
$nb_inscrit = $query->fetch();
echo $nb_inscrit['id'];
?> badges dans l'inventaire<br/>
• 30 000 crédits & pixels en plus<br/>
• Accès aux rares VIP du catalogue<br/>
• Accès aux apparts complets<br/>
• Nouveaux étages au navigateur <br/>
• Commande :pull (tirer)<br/>
• Commande :push (pousser)<br/>
• Commande :mimic<br/>
• Commande :moonwalk<br/><br/>
<b>Les badges offerts :</b><br/>
<?PHP
$sql = $bdd->query("SELECT * FROM gabcms_config_badges WHERE club = '1'");
 while($a = $sql->fetch()) {
?>
<img title="<?php echo $a['badge_id']; ?>" src="<?PHP echo $swf_badge ?><?php echo $a['badge_id']; ?>.gif" border="0" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)"/>&nbsp;&nbsp;
<?PHP } ?>
</div>

<div style="float: right; padding: 0 15px 15px 0; ">
<br/>

                           </div></div></div>

<div class="price">
                        <div>
                            <div>
                                
           
            
            <br/><div class="pricepoint-price-container"><font color="#5D658C">K-DO</font></div>
			 <div class="pricepoint-amount-container">
            <img src="<?PHP echo $imagepath;?>v2/images/divers/ACH_GiftGiver4.gif">
            </div>
                            </div>
                        </div>
                    </div>
					</ol>

<div class="bottom">
<div>
</div>
</div>
</div>

</div>
</div></div>

<div class="habblet-container" id="okt" style="float:left; width: 770px;">		
<div class="cbb clearfix orange ">
<div class="campaign-banner-vip">
    <div style="padding-top: 5px;"></div>
    <div class="campaign-banner-monsterplant-header-container-left">
        <div class="campaign-banner-monsterplant-header-mid">
            <div class="campaign-banner-monsterplant-header-inner"></div>
        </div>
    </div>
    <div class="campaign-banner-monsterplant-header-container-right">
        <div class="campaign-banner-monsterplant-info-mid">
        </div>
    </div> 
    <div class="campaign-banner-monsterplant-status-line-container">

</div>
</div>
            <div class="method-group phone clearfix   cbs2">
<div class="method idx0 m-smsma nosmallprint">
    
    <div class="method-content">
    <h2><font color="#B02863">STAFF CLUB</font></h2><div class="top"><div></div></div>
        <div class="summary clearfix">
            <ol>
<div>Le STAFF club, c'est le plus grand <br/>et le plus fun club de l'hôtel.<br/><br/>Ce Club est <b>PAYANT</b>, car il permet d'avoir d'incroyables avantages, <br/>des commandes et des mobis... comme de vrais Staffs!<br/><br/>De plus, le staff club permet un avantage certain lors des recrut'...<br/>Alors n'attends plus... Adhères-y!
<br/><h3><b><br/><img src="<?PHP echo $imagepath;?>v2/images/attention.gif"> PRIX = <?PHP echo $cp['staffclub'] ?> JETONS</b></h3></ol>     
<form name="editor" method="post" action="?do=staffclub"><input type="hidden" name="transaction_staff" value="<?PHP echo $cp['staffclub'] ?>" /><center><input type="submit" name="submit" value="Adhérer au STAFF CLUB" /></center> </form>
                                        <div style="float: right; padding: 0 15px 15px 0; ">
                                <br/>
</p>
                            </div>
        </div>
    </div>
                    <div class="price">
                        <div>
                            <div>
            <br/><div class="pricepoint-price-container"><font color="#90536D">PROMO</font></div>
			 <div class="pricepoint-amount-container">
               <img src="<?PHP echo $imagepath;?>v2/images/divers/ADM.gif">
            </div>
                            </div>
                        </div>
                    </div>
<div class="bottom"><div></div></div></div>

<div class="method idx0 m-smsma nosmallprint">
    
    <div class="method-content">
        <h2><font color="#B02863">AVANTAGES</font></h2><div class="top"><div></div></div>

        <div class="summary clearfix">



<ol><div>
• <?php $req = "SELECT COUNT(*) AS id FROM gabcms_config_badges WHERE club = '2'";
$query = $bdd->query($req);
$nb_inscrit = $query->fetch();
echo $nb_inscrit['id'];
?> badges en plus dans l'inventaire<br/>
• 50 000 crédits & pixels en plus<br/>
• Extras Rares STAFF du catalogue<br/>
• Accès aux apparts complets<br/>
• Toutes les commandes VIP<br/>
• Avantage aux recrutements<br/>
• Commande :setspeed<br/>
• Commande :userinfo<br/><br/>
<b>Les badges offerts :</b><br/>
<?PHP
$sql = $bdd->query("SELECT * FROM gabcms_config_badges WHERE club = '2'");
 while($a = $sql->fetch()) {
?>
<img title="<?php echo $a['badge_id']; ?>" src="<?PHP echo $swf_badge ?><?php echo $a['badge_id']; ?>.gif" border="0" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)"/>&nbsp;&nbsp;
<?PHP } ?>
</div>

<div style="float: right; padding: 0 15px 15px 0; ">
<br/>

                           </div></div></div>

<div class="price">
                        <div>
                            <div>
                                
           
            
            <br/><div class="pricepoint-price-container"><font color="#90536D">K-DO</font></div>
			 <div class="pricepoint-amount-container">
            <img src="<?PHP echo $imagepath;?>v2/images/divers/ACH_GiftGiver5.gif">
            </div>
                            </div>
                        </div>
                    </div>
					</ol>

<div class="bottom">
<div>
</div>
</div>
</div>

</div>
</div></div>


<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>


<script type="text/javascript">
HabboView.run();
</script>
              

    
<!--[if lt IE 7]>
<script type="text/javascript">
Pngfix.doPngImageFix();
</script>
<![endif]--> 
<!-- FOOTER -->
</div></div></div></div>
<?PHP include("./template/footer.php");?>		

<div style="clear: both;"></div>

 
<script type="text/javascript"> 
HabboView.run();

</script>


</body> 
</html> 

