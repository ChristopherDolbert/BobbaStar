<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

	include("./config.php");
	$pagename = "Acheter des jetons";
	$pageid = "jetons";
	
if(!isset($_SESSION['username']))
	{
		Redirect("".$url."/index");
	}
$cof_prix = $bdd->query("SELECT * FROM gabcms_config_prix WHERE id = '1'");
$cp = $cof_prix->fetch();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head> 
<meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
<title><?PHP echo $sitename; ?> &raquo; <?PHP echo $pagename; ?></title> 
 
<script type="text/javascript"> 
var andSoItBegins = (new Date()).getTime();
var ad_keywords = "";
document.habboLoggedIn = true;
var habboName = "<?PHP echo $user['username']; ?>";
var habboReqPath = "<?PHP echo $url; ?>";
var habboStaticFilePath = "<?PHP echo $imagepath; ?>";
var habboImagerUrl = "http://www.habbo.com/habbo-imaging/";
var habboPartner = "";
var habboDefaultClientPopupUrl = "<?PHP echo $url; ?>/client";
window.name = "habboMain";
if (typeof HabboClient != "undefined") { HabboClient.windowName = "uberClientWnd"; }
</script> 



<link rel="shortcut icon" href="<?PHP echo $imagepath; ?>favicon.ico" type="image/vnd.microsoft.icon" /> 
<script src="<?PHP echo $imagepath; ?>static/js/libs2.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath; ?>static/js/visual.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath; ?>static/js/libs.js" type="text/javascript"></script>
<script src="<?PHP echo $imagepath; ?>static/js/common.js" type="text/javascript"></script>

<script src="<?PHP echo $imagepath; ?>static/js/fullcontent.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/style.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/buttons.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/boxes.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/tooltips.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/personal.css" type="text/css" />
<script src="<?PHP echo $imagepath; ?>static/js/habboclub.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/minimail.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/myhabbo/control.textarea.css" type="text/css" />
<script src="<?PHP echo $imagepath; ?>static/js/minimail.js" type="text/javascript"></script>

 <link rel="stylesheet" href="<?PHP echo $imagepath; ?>static/styles/cbs2credits.css" type="text/css" />
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>static/styles/newcredits.css" type="text/css" />
<script src="<?PHP echo $imagepath; ?>static/js/cbs2credits.js" type="text/javascript"></script>

<meta name="description" content="<?PHP echo $description; ?>" /> 
<meta name="keywords" content="<?PHP echo $keyword; ?>" />  
<!--[if IE 8]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/ie8.css" type="text/css" />
<![endif]--> 
<!--[if lt IE 8]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/ie.css" type="text/css" />
<![endif]--> 
<!--[if lt IE 7]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/ie6.css" type="text/css" />
<script src="<?PHP echo $imagepath; ?>static/js/pngfix.js" type="text/javascript"></script>
<script type="text/javascript">
try { document.execCommand('BackgroundImageCache', false, true); } catch(e) {}
</script>
 
<style type="text/css">
body { behavior: url(http://www.habbo.com/js/csshover.htc); }
</style>
<![endif]--> 
<meta name="build" content="<?PHP echo $build; ?> >> <?PHP echo $version; ?>" /> 
</head>
	 
<body id="home" class=" "> 
<div id="overlay"></div> 
<!-- MENU -->
<?PHP include("./template/header.php"); ?>
<!-- FIN MENU -->
<div id='container'>
    <div id='content'>
        <div id='column1' class='column'>
            <div class="habblet-container" id="okt" style="float:left; width: 770px;">		
				<div class="cbb clearfix orange ">
				    <h2 class="title">Demande toujours l'autorisation avant d'acheter!</h2>
<style type="text/css">
div.credit-amount-coin {
    width: 26px !important;
}

.method-group.online.bestvalue {
 background-image: url(<?PHP echo $imagepath; ?>v2/images/newcredits/fr_strike_best_value.png);
background-repeat: no-repeat;
}

.price b.from {
  visibility:hidden;
  max-height:1px;
}

.method-group.phone .redeemcode {
    width: 75px!important;
}
.method-group.phone .redeem {
    margin: 0!important;
}
div.phone * a.redeem-submit > b {
    padding: 5px!important;
    width: 55px!important;
}
div.uscashcards  {
    padding-left: 166px!important;
}

</style>
                    <div class="method-group online clearfix  bestvalue  cbs2">
                        <div id="group-content-4854">
                            <div id="price-container">
                                <div id="pricepoints">
<br/><br/>
<input type="radio" name="jetons" checked="checked" value="" ><font size="4px"><b><img src="<?PHP echo $imagepath; ?>v2/images/newcredits/details_coin.png" /> <?PHP echo $cp['achat_jetons'] ?> jetons</b></font></input>
<br/><br/><br/>
<center><a href="<?PHP echo $url; ?>/jetons-buy" onclick="return submitCreditForm($(this).up('form'), 'online', '4854', '');" class="large-button large-green-button"><span><b>Acheter des jetons</b></span><i></i></a><center>
                                <style>
              .textInputt
{
border:2px solid #000;
background-image:linear-gradient(top,#f3f3f3 50%,#d9d9d9 50%);
background-image:-o-linear-gradient(top,#f3f3f3 50%,#d9d9d9 50%);
background-image:-moz-linear-gradient(top,#f3f3f3 50%,#d9d9d9 50%);
background-image:-webkit-linear-gradient(top,#f3f3f3 50%,#d9d9d9 50%);
background-image:-ms-linear-gradient(top,#f3f3f3 50%,#d9d9d9 50%);
box-shadow:0px 0px 4px rgba(0, 0, 0, 0.2), 0px 0px 0px 2px #d9d9d9 inset;
background-color:#d0d0d0;
-webkit-border-radius:4px;
cursor:pointer;
-moz-border-radius:4px;
border-radius:4px;
padding:5px;
font-family:arial,verdana,tahoma;
font-size:20px;
font-weight:bold;
text-shadow: rgba(255, 255, 255, 0.7) 0 1px 0;
color:#000;
height: 47px;
 float: right;

}

          .textInputt:hover
{
background-image:linear-gradient(top,#ffffff 50%,#ebebeb 50%);
background-image:-o-linear-gradient(top,#ffffff 50%,#ebebeb 50%);
background-image:-moz-linear-gradient(top,#ffffff 50%,#ebebeb 50%);
background-image:-webkit-linear-gradient(top,#ffffff 50%,#ebebeb 50%);
background-image:-ms-linear-gradient(top,#ffffff 50%,#ebebeb 50%);
box-shadow:0px 0px 4px rgba(0, 0, 0, 0.2), 0px 0px 0px 1px #ffffff inset;
background-color:#ebebeb;
}

         .textInputt:active
{
background-image:linear-gradient(top,#e1e1e1 50%,#a3a3a3 50%);
background-image:-o-linear-gradient(top,#e1e1e1 50%,#a3a3a3 50%);
background-image:-moz-linear-gradient(top,#e1e1e1 50%,#a3a3a3 50%);
background-image:-webkit-linear-gradient(top,#e1e1e1 50%,#a3a3a3 50%);
background-image:-ms-linear-gradient(top,#e1e1e1 50%,#a3a3a3 50%);
box-shadow:0px 0px 4px rgba(0, 0, 0, 0.2), 0px 0px 0px 2px #a3a3a3 inset;
background-color:#a3a3a3;
}
</style>
  </div>
                            <div id="methods">
                                <ul>
                                            <li><img alt="Carte Bancaire" src="<?PHP echo $imagepath; ?>v2/images/newcredits/partner_logo_credit_card_013.png"/></li>
                                            <li><img alt="Internet+" src="<?PHP echo $imagepath; ?>v2/images/newcredits/partner_button_inetplus_002.png"/></li>
                                            <li><img alt="SMS+" src="<?PHP echo $imagepath; ?>v2/images/newcredits/smsplus.png"/></li>
                                            <li><img alt="Neosurf" src="<?PHP echo $imagepath; ?>v2/images/newcredits/partner_logo_neosurf_002.png"/></li>
                                                   </ul>
                            </div>
                        </div>
                        </div>        
            </div>
<br/><center><a href="<?PHP echo $url; ?>/service_client/contact" class="moreinfo">Poser une question sur les jetons</a></center>
<div class="credits-footer clearfix">
<div class="disclaimer">
    <h3><span>Demande toujours la permission</span></h3>
 Avant d'acheter des jetons, demande toujours la permission &agrave; tes parents! Si tu as une question ou une erreur &agrave; nous rapporter, contacte le <a onclick="openOrFocusHelp(this); return false" target="habbohelp" href="<?PHP echo $url; ?>/service_client/contact">service client de <?PHP echo $sitename; ?></a>.
</div>
<div class="countries">
    <h3>Moyens de paiements</h3>
   <ul>
        <li>depuis</li>
        <li><a href="" class="country" rel="fr">France</a></li>
        <li><a href="" class="country" rel="be">Belgique</a></li>
        <li><a href="" class="country" rel="ch">Suisse</a></li>
        <li><a href="" class="country" rel="ma">Maroc</a></li>
        <li><a href="" class="country" rel="dom">DROM</a></li>
        <li><a href="" class="country" rel="other">autres</a></li>
           </ul>
</div>
</div>
</div>
</div>
</div></div>
</div>
</div>
</div>
                <script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
</div>
<script type="text/javascript">
HabboView.run();
</script>  
  
</div>
<!-- FOOTER -->
<?PHP include("./template/footer.php"); ?>
<!-- FIN FOOTER -->
</body>
</html>