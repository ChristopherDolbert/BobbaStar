<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("./config.php");
$pagename = "Club HC";
$pageid = "clubhc";
$rawname = $user['username'];
$my_id = $user['id'];

if (!isset($_SESSION['username'])) {
    Redirect($url . "/index");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title><?PHP echo $sitename; ?> &raquo; <?PHP echo $pagename; ?></title>
    <script src="https://unpkg.com/@ruffle-rs/ruffle"></script>
    <script>
        window.RufflePlayer = window.RufflePlayer || {};
        window.RufflePlayer.config = {
            // Start playing the content automatically, without audio if the browser in use does not allow audio to autoplay
            "autoplay": "on",
            // Do not show an overlay to unmute the content while it plays; when the content area receives its first interaction, it will unmute
            "unmuteOverlay": "hidden",
            // Do not show a splash screen before the content loads; the content area will remain blank until Ruffle fully loads the content
            "splashScreen": false,
        }
    </script>

    <script type="text/javascript">
        var andSoItBegins = (new Date()).getTime();
        var ad_keywords = "";
        document.habboLoggedIn = true;
        var habboName = "<?PHP echo $user['username']; ?>";
        var habboReqPath = "<?PHP echo $url; ?>/";
        var habboStaticFilePath = "<?PHP echo $imagepath; ?>";
        var habboImagerUrl = "<?PHP echo $avatarimage; ?>";
        var habboPartner = "";
        var habboDefaultClientPopupUrl = "<?PHP echo $url; ?>/client";
        window.name = "habboMain";
        if (typeof HabboClient != "undefined") {
            HabboClient.windowName = "uberClientWnd";
        }
    </script>



    <link rel="shortcut icon" href="<?PHP echo $imagepath; ?>favicon.ico" type="image/vnd.microsoft.icon" />
    <script src="<?PHP echo $imagepath; ?>static/js/libs2.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/visual.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/libs.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/common.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>js/tooltip.js" type="text/javascript"></script>

    <script src="<?PHP echo $imagepath; ?>static/js/fullcontent.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/style.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/buttons.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/boxes.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/tooltips.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/personal.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
    <script src="<?PHP echo $imagepath; ?>static/js/habboclub.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/minimail.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/myhabbo/control.textarea.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
    <script src="<?PHP echo $imagepath; ?>static/js/minimail.js" type="text/javascript"></script>
    <script src="<?PHP echo $imagepath; ?>static/js/settings.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/settings.css<?php echo '?' . mt_rand(); ?>" type="text/css" />


    <meta name="description" content="<?PHP echo $description; ?>" />
    <meta name="keywords" content="<?PHP echo $keyword; ?>" />
    <!--[if IE 8]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/ie8.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
<![endif]-->
    <!--[if lt IE 8]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/ie.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
<![endif]-->
    <!--[if lt IE 7]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/ie6.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
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
    <div id="tooltip"></div>
    <div id="overlay"></div>
    <!-- MENU -->
    <?PHP include("./template/header.php"); ?>
    <!-- FIN MENU -->

    <?php
    echo "<div id='container'>
	<div id='content'>
		<div id='column1' class='column'>
		<div class='habblet-container '>
						<div class='cbb clearfix hcred '>

							<h2 class='title'>" . $shortname . " Club: deviens un VIP!</h2>
						<div id ='habboclub-products'>
    <div id='habboclub-clothes-container'>
        <div class='habboclub-extra-image'></div>
        <div class='habboclub-clothes-image'></div>
    </div>

    <div class='clearfix'></div>
    <div id='habboclub-furniture-container'>
        <div class='habboclub-furniture-image'></div>
    </div>
</div>


					</div>
				</div>
				<script type='text/javascript'>if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

				<div class='habblet-container '>
						<div class='cbb clearfix lightbrown '>

							<h2 class='title'>Avantages</h2>
						<div id='habboclub-info' class='box-content'>
    <p>" . $shortname . "  Club est le Club tr&eacute;s s&eacute;lect de Habbo - Seule la creme de la creme y est accept&eacute;e et ses membres sont envi&eacute;s dans tout l'h&ocirc;tel</p>
    <h3 class='heading'>1. V&ecirc;tements & accessoires suppl&eacute;mentaires</h3>
    <p class='content habboclub-clothing'>Fais le k&eacute;k&eacute; gr&acirc;ce &agrave; un choix tr&eacute;s &eacute;tendu de v&ecirc;tements, d'accessoires et de coupes de cheveux exclusifs.</p>
    <h3 class='heading'>2. Mobis gratuits</h3>
    <p class='content habboclub-furni'>Chaque mois un nouveau mobi offert!</p>
    <p class='content'>Nb: si tu quittes le Habbo Club et que tu souhaites y revenir un peu plus tard, tu ne red&eacute;marreras pas ton abonnement &agrave; z&eacute;ro mais au moment pr&eacute;cis o&ugrave; tu l'avais quitt&eacute;.</p>
    <h3 class='heading'>3. Formes d'appart exclusives</h3>
    <p class='content'>Des formes d'appart exclusives pour mieux mettre en valeur tes mobis!</p>
    <p class='habboclub-room' />
    <h3 class='heading'>4. Acces prioritaire</h3>
    <p class='content'>Grille la queue avant m&ecirc;me que la salle soit charg&eacute;e et acc&egrave;de en exclusivit&eacute; aux salles r&eacute;serv&eacute;es aux membres HC.</p>
    <h3 class='heading'>5.  Mises &agrave; jour page perso</h3>
    <p class='content'>Rejoins le Habbo Club et dis adieu &agrave; aux banni&egrave;res pub! A toi les widgets et les fonds d'&eacute;cran HC ;)</p>
    <h3 class='heading'>6. Plus d'amis</h3>
    <p class='content habboclub-communicator'>600 personnes! Ca fait un sacr&eacute; paquet d'amis ;)</p>
    <h3 class='heading'>7. Commandes sp&eacute;ciales</h3>
    <p class='content habboclub-commands right'>Sers-toi de la commande :chooser pour voir qui se trouve dans l'appart. Pratique!</p>
    <br />
    <p>Sers-toi de la commande :furni pour conna&icirc;tre les mobis que contient un appart. Tout y est r&eacute;pertori&eacute; m&ecirc;me ce qui est cach&eacute; sous le lit :O


</p>
</div>


					</div>
				</div>
				<script type='text/javascript'>if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

</div>
<div id='column2' class='column'>
				<div class='habblet-container '>
						<div class='cbb clearfix hcred '>

							<h2 class='title'>Mon adh&eacute;sion</h2>
<div id='hc-membership-info' class='box-content'>";
    if (isset($user['id'])) {
        echo "<p>
Tu es";

        if (!IsHCMember($my_id)) {
            echo " pas";
        }

        echo " un membre du " . $shortname . " Club
</p>
<p>";
        if (IsHCMember($my_id)) {
            echo "Tu as " . HCDaysLeft($my_id) . " jours HC";
        } else {
            echo "&nbsp;";
        }
        echo "</p>
</div>";
        if ($user['credits'] == "20" || $user['credits'] > 20) { ?>
            <div id='hc-buy-container' class='box-content'>
                <div id='hc-buy-buttons' class='hc-buy-buttons rounded rounded-hcred'>
                    <form>
                        <table>
                            <tr>
                                <td><a class="new-button fill" onclick="habboclub.buttonClick(1,'<?php echo strtoupper($shortname); ?> CLUB'); return false;" href="#"><b>Acheter 1 mois</b><i></i></a></td>
                                <td>&nbsp;20 Cr&eacute;dits</td>
                            </tr>
                            <tr>
                                <td><a class="new-button fill" onclick="habboclub.buttonClick(3,'<?php echo strtoupper($shortname); ?> CLUB'); return false;" href="#"><b>Acheter 3 mois</b><i></i></a></td>
                                <td>&nbsp;50 Cr&eacute;dits</td>
                            </tr>
                            <tr>
                                <td><a class="new-button fill" onclick="habboclub.buttonClick(6,'<?php echo strtoupper($shortname); ?> CLUB'); return false;" href="#"><b>Acheter 6 mois</b><i></i></a></td>
                                <td>&nbsp;80 Cr&eacute;dits</td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        <?php } else { ?>
            <div id="hc-buy-container" class="box-content">
                <div id="hc-buy-buttons" class="hc-buy-buttons rounded rounded-hcred">
                    <form class="subscribe-form" method="post">
                        <table width="100%">
                            <p class="credits-notice">Pour joindre le <?php echo $shortname; ?> Club, tu dois avoir des cr&eacute;dits. <?php echo $shortname; ?> Club c&ocirc;ute au mininum 20 cr&eacute;dits</p>
                            <a class="new-button fill" href="credits.php"><b>Avoir des sous!</b><i></i></a>
                        </table>
                    </form>
                </div>
            </div>
    <?php }
    } else {
        echo "Merci de te connecter pour voir tes statistiques du " . $shortname . " Club";
    }


    echo "					</div>
				</div>
				<script type='text/javascript'>if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

				<div class='habblet-container '>





				</div>
				<script type='text/javascript'>if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

"; /*				<div class='habblet-container '>
						<div class='cbb clearfix lightbrown '>

							<h2 class='title'>Discount!</h2>
<div class='box-content'>
Hurrah! A major discount on all ".$shortname." Club subscriptions! Buy one on this page now and save up to 15 credits!
</div>


					</div>
				</div>
				<script type='text/javascript'>if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script> */
    echo "

</div>

</div>";
    ?>