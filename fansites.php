	<?PHP
        #|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
        #|                                                                        #|
        #|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
        #|                                                                        #|
        #|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

        include("./config.php");
        $pagename = "Sites de fans";
        $pageid = "sdf";

        if (!isset($_SESSION['username'])) {
                Redirect("" . $url . "/index");
        }
        $sql = $bdd->query("SELECT * FROM gabcms_config WHERE id = '1'") or die(mysql_error());;
        $cof = $sql->fetch(PDO::FETCH_ASSOC);
        ?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
	                var habboImagerUrl = "http://www.habbo.co.uk/habbo-imaging/";
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
	        <div id="container">
	                <div id="content">
	                        <div id="column11" class="column">
	                                <div class="habblet-container" id="okt" style="float:left; width: 770px;">
	                                        <div class="cbb clearfix orange">
	                                                <h2 class="title">Sites de fan</h2>
	                                                <div class="habblet box-content">
	                                                        <h3>Est-ce que tu gères un site de fan? Dis-le nous et nous l'ajouterons à cette liste!</h3>

	                                                        <img src="<?PHP echo $imagepath; ?>images/sitedefan/habbo_friends<?PHP echo $cof['img_sdf']; ?>.png" ALIGN=RIGHT>

	                                                        <?php
                                                                $sdf = $bdd->query("SELECT * FROM gabcms_sitedefan ORDER BY id DESC");
                                                                if ($sdf->rowCount() == 0) {
                                                                        echo "<i><b>Aucun site officiel</b></i><br/>";
                                                                }

                                                                while ($fds = $sdf->fetch()) {
                                                                ?>
	                                                                <a target="_blank" href="<?PHP echo Secu($fds['url']); ?>" title="<?PHP echo Secu($fds['nom']); ?>" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)"><?PHP echo Secu($fds['url']); ?></a><br />


	                                                        <?PHP } ?>
	                                                        <br /><br />
	                                                        Nous n'avons pas de procédure pour ajouter de nouveaux sites de fans à la liste officielle pour le moment. Lorsque ce sera le cas, nous l'annoncerons sur le site. Si tu souhaites devenir un fansite, contact nous en cliquant <a href="<?PHP echo $url; ?>/service_client/contact.php">ici</a>
	                                                </div>
	                                        </div>
	                                </div>
	                        </div>
	                </div>
	        </div>

	        <script type="text/javascript">
	                if (!$(document.body).hasClassName('process-template')) {
	                        Rounder.init();
	                }
	        </script>
	        <script type="text/javascript">
	                HabboView.run();
	        </script>

	        </div>
	        <!-- FOOTER -->
	        <?PHP include("./template/footer.php"); ?>
	        <!-- FIN FOOTER -->
	</body>

	</html>