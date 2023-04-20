<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("./config.php");
$pagename = "Hôtel";

if (!isset($_SESSION['username'])) {
  Redirect($url . "/index");
}

$sql = $bdd->query("SELECT nitro_client FROM gabcms_client WHERE id = '1'");
$client = $sql->fetch(PDO::FETCH_ASSOC);
$sql2 = $bdd->query("SELECT * FROM gabcms_config WHERE id = '1'");
$cof = $sql2->fetch(PDO::FETCH_ASSOC);

$ssoTicket = "BBSTR-" . GenerateRandom("sso");
$updateSSO = $bdd->prepare("UPDATE users SET auth_ticket = ? WHERE id = ?");
$updateSSO->execute([$ssoTicket, $user['id']]);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

  <title><?PHP echo $sitename; ?> &raquo; <?PHP echo $pagename; ?></title>
  <script src="https://unpkg.com/@ruffle-rs/ruffle"></script>

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
    if (typeof HabboClient != "undefined") {
      HabboClient.windowName = "uberClientWnd";
    }
  </script>



  <link rel="shortcut icon" href="<?PHP echo $imagepath; ?>favicon.ico" type="image/vnd.microsoft.icon" />
  <script src="<?PHP echo $imagepath; ?>static/js/libs2.js" type="text/javascript"></script>
  <script src="<?PHP echo $imagepath; ?>static/js/visual.js" type="text/javascript"></script>
  <script src="<?PHP echo $imagepath; ?>static/js/libs.js" type="text/javascript"></script>
  <script src="<?PHP echo $imagepath; ?>static/js/common.js" type="text/javascript"></script>

  <script src="<?PHP echo $imagepath; ?>static/js/fullcontent.js" type="text/javascript"></script>
  <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/style.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
  <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/buttons.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
  <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/boxes.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
  <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/tooltips.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
  <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/habboclient.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
  <link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/habboflashclient.css<?php echo '?'.mt_rand(); ?>" type="text/css" />

  <meta name="description" content="<?PHP echo $description; ?>" />
  <meta name="keywords" content="<?PHP echo $keyword; ?>" />

  <!--[if IE 8]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/ie8.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<![endif]-->
  <!--[if lt IE 8]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/ie.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<![endif]-->
  <!--[if lt IE 7]>
<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/ie6.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
<script src="<?PHP echo $imagepath; ?>static/js/pngfix.js" type="text/javascript"></script>
<script type="text/javascript">
try { document.execCommand('BackgroundImageCache', false, true); } catch(e) {}
</script>
 
<style type="text/css">
body { behavior: url(http://www.habbo.co.uk/js/csshover.htc); }
</style>
<![endif]-->
  <link rel="stylesheet" href="<?PHP echo $imagepath; ?>static/styles/news.css<?php echo '?'.mt_rand(); ?>" type="text/css" />
  <script src="<?PHP echo $imagepath; ?>static/js/news.js" type="text/javascript"></script>
  <meta name="build" content="<?PHP echo $build; ?> >> <?PHP echo $version; ?>" />

</head>
<?PHP if ($cof['etat_client'] == '1' || $cof['etat_client'] == '3' && $cof['si3_debut'] < $nowtime && $cof['si3_fin'] < $nowtime) { ?>

  <body id="client" class="flashclient">
    <iframe src="<?= ClientNitro() . $ssoTicket ?>" width="100%" height="100%" frameborder="0" scrolling="no"></iframe>
    <script type="text/javascript">
      $('content').show();
    </script>
    <noscript>
      <div style="width: 400px; margin: 20px auto 0 auto; text-align: center">
        <p>If you are not automatically redirected, please <a href="/client/nojs">click here</a></p>
      </div>
    </noscript>
    </div>
    </div>
    <div id="content" class="client-content"></div>
    </div>
    <div style="display: none">

      <script language="JavaScript" type="text/javascript">
        setTimeout(function() {
          HabboCounter.init(600);
        }, 20000);
      </script>
    </div>
    <script type="text/javascript">
      RightClick.init("flash-wrapper", "flash-container");
    </script>
    <script type="text/javascript">
      if (!$(document.body).hasClassName('process-template')) {
        Rounder.init();
      }
    </script>


  </body>
<?PHP } elseif ($cof['etat_client'] == '2' || $cof['etat_client'] == '3' && $cof['si3_debut'] <= $nowtime && $cof['si3_fin'] >= $nowtime) { ?>

  <body id="popup" class="process-template client_error">
    <div id="tooltip"></div>
    <div id="container">
      <div id="content">
        <div id="process-content" class="centered-client-error">
          <div id="column1" class="column">

            <div class="habblet-container ">
              <div class="cbb clearfix v3_darkblue_glow ">

                <h2 class="title">Fermé
                </h2>
                <script type="text/javascript">
                  if (typeof HabboClient != "undefined") {
                    HabboClient.forceReload = true;
                  }
                </script>

                <div class="box-content">
                  <div class="info-client_error-text">
                    <p>Oops, l'hôtel a été fermé par un fondateur de <?PHP echo $sitename; ?>. Actuellement, tu peux disposer du service client pour être au courant des nouveautés ou alors de voir si un article a été poster.</p>
                    <p>Clique <a onclick="openOrFocusHabbo(this); return false;" target="client" href="<?PHP echo $url; ?>/service_client/">ici</a> pour continuer. Nous sommes désolés de ce désagrément.</p>
                  </div>
                  <div class="retry-enter-hotel">
                    <div class="hotel-open">
                      <a id="enter-hotel-open-image" class="open" href="<?PHP echo $url; ?>/service_client/" target="client" onclick="HabboClient.openOrFocus(this); return false;">
                        <div class="hotel-open-image-splash"></div>
                        <div class="hotel-image hotel-open-image"></div>
                      </a>
                      <div class="hotel-open-button-content">
                        <a class="open" href="<?PHP echo $url; ?>/moi" target="_blank" onclick="HabboClient.openOrFocus(this); return false;">REVENIR SUR LE SITE</a>
                        <span class="open"></span>
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


          </div>
          <script type="text/javascript">
            HabboView.run();
          </script>
          <div id="column2" class="column">
          </div>
          <!--[if lt IE 7]>
<script type="text/javascript">
Pngfix.doPngImageFix();
</script>
<![endif]-->
        </div>
      </div>
    </div>

  </body>
<?PHP } ?>

</html>