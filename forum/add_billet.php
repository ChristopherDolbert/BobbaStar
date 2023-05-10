<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         GabCMS - Site Web et Content Management System                 #|
#|         Copyright © 2013 Gabodd Tout droits réservés.                  #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");
$pagename = "Forum &raquo; Ajouter un topic";
$pageid = "forum";

if (!isset($_SESSION['username'])) {
  Redirect("" . $url . "/index");
}
if (isset($_GET['do'])) {
  $do = Secu($_GET['do']);
}
if (isset($_GET['forum'])) {
  $forum = Secu($_GET['forum']);
}
if (isset($_GET['do'])) {
  if ($do == "create") {
    if (isset($_POST['titre']) || isset($_POST['article'])) {
      $titre = addslashes($_POST['titre']);
      $article = addslashes($_POST['article']);
      $categorie_forum = Secu($_POST['categorie']);
      $sql = $bdd->query("SELECT * FROM gabcms_forum_topic ORDER BY commentaire DESC LIMIT 0,1");
      $a = $sql->fetch();
      $calcul = $a['commentaire'] + 1;
      if ($titre != "" && $article != "" && $categorie_forum != "") {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_forum_topic (categorie_forum,titre,user_id,texte,ip,date,commentaire,etat) VALUES (:categorie, :titre, :userid, :article, :ip, :date, :calcul, :etat)");
        $insertn1->bindValue(':categorie', $categorie_forum);
        $insertn1->bindValue(':titre', $titre);
        $insertn1->bindValue(':userid', $user['id']);
        $insertn1->bindValue(':article', $article);
        $insertn1->bindValue(':ip', $user['ip_last']);
        $insertn1->bindValue(':date', time());
        $insertn1->bindValue(':calcul', $calcul);
        $insertn1->bindValue(':etat', '1');
        $insertn1->execute();
        $com = $bdd->lastInsertId();
        $insertn3 = $bdd->prepare("INSERT INTO gabcms_forum_lu (user_id, id_topic, date) VALUES (:user, :topic, :date)");
        $insertn3->bindValue(':user', $user['id']);
        $insertn3->bindValue(':topic', $com);
        $insertn3->bindValue(':date', FullDate('full'));
        $insertn3->execute();
        $affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-green\"> 
              Le topic vient d'être ajouté.
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
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <title><?PHP echo $sitename; ?>: <?PHP echo $pagename; ?></title>

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
  <script src="<?PHP echo $imagepath; ?>js/tooltip.js" type="text/javascript"></script>
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
  <script src="https://cdn.ckeditor.com/ckeditor5/37.0.1/classic/ckeditor.js"></script>

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


<div id="tooltip"></div>

<body id="news" class=" ">
  <div id="overlay"></div>
  <!-- MENU -->
  <?PHP include("../template/header.php"); ?>
  <!-- FIN MENU -->
  <div id="container">
    <div id="content">
      <div id="column11" class="column">
        <div class="habblet-container">
          <div class="cbb clearfix green">
            <h2 class="title">Les smileys</h2>
            <div class="box-content">
              Pour voir le code qui affiche le smiley, il suffit de passer la souris sur le smiley en question<br /><br />
              <img src="<?PHP echo $imagepath; ?>smileys/clindoeil.gif" alt=";)" title=";)" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
              <img src="<?PHP echo $imagepath; ?>smileys/embarrase.gif" alt=":$" title=":$" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
              <img src="<?PHP echo $imagepath; ?>smileys/etonne.gif" alt=":o" title=":o" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
              <img src="<?PHP echo $imagepath; ?>smileys/happy.gif" alt=":)" title=":)" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
              <img src="<?PHP echo $imagepath; ?>smileys/icon_silent.png" alt=":x" title=":x" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
              <img src="<?PHP echo $imagepath; ?>smileys/langue.gif" alt=":p" title=":p" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
              <img src="<?PHP echo $imagepath; ?>smileys/sad.gif" alt=":\'(" title=":'(" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
              <img src="<?PHP echo $imagepath; ?>smileys/veryhappy.gif" alt=":D" title=":D" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
              <img src="<?PHP echo $imagepath; ?>smileys/jap.png" alt=":jap:" title=":jap:" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
              <img src="<?PHP echo $imagepath; ?>smileys/cool.gif" alt="8)" title="8)" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
              <img src="<?PHP echo $imagepath; ?>smileys/rire.gif" alt=":rire:" title=":rire:" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
              <img src="<?PHP echo $imagepath; ?>smileys/icon_evil.gif" alt=":evil:" title=":evil:" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
              <img src="<?PHP echo $imagepath; ?>smileys/icon_twisted.gif" alt=":twisted:" title=":twisted:" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
              <img src="<?PHP echo $imagepath; ?>smileys/roll.gif" alt=":rool:" title=":rool:" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
              <img src="<?PHP echo $imagepath; ?>smileys/neutre.gif" alt=":|" title=":|" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
              <img src="<?PHP echo $imagepath; ?>smileys/suspect.gif" alt=":suspect:" title=":suspect:" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
              <img src="<?PHP echo $imagepath; ?>smileys/no.gif" alt=":no:" title=":no:" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
              <img src="<?PHP echo $imagepath; ?>smileys/coeur.gif" alt=":coeur:" title=":coeur:" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
              <img src="<?PHP echo $imagepath; ?>smileys/hap.gif" alt=":hap:" title=":hap:" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
              <img src="<?PHP echo $imagepath; ?>smileys/bave.gif" alt=":bave:" title=":bave:" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
              <img src="<?PHP echo $imagepath; ?>smileys/areuh.gif" alt=":areuh:" title=":areuh:" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
              <img src="<?PHP echo $imagepath; ?>smileys/bandit.gif" alt=":bandit:" title=":bandit:" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
              <img src="<?PHP echo $imagepath; ?>smileys/help.gif" alt=":help:" title=":help:" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
              <img src="<?PHP echo $imagepath; ?>smileys/buzz.gif" alt=":buzz:" title=":buzz:" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
              <img src="<?PHP echo $imagepath; ?>smileys/contrat.gif" alt=":contrat:" title=":contrat:" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
              <img src="<?PHP echo $imagepath; ?>smileys/pour.gif" alt=":favo:" title=":favo:" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" />
              <img src="<?PHP echo $imagepath; ?>smileys/contre.gif" alt=":contre:" title=":contre:" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)" /><br /><br />
              <a href="<?PHP echo $url; ?>/forum/">Revenir sur l'acceuil du forum »</a>
            </div>
          </div>
        </div>
        <script type="text/javascript">
          if (!$(document.body).hasClassName('process-template')) {
            Rounder.init();
          }
        </script>
        <div class="habblet-container" id="okt" style="float:left; width: 770px;">
          <div class="cbb clearfix blue">
            <h2 class="title">Ajoute un nouveau billet sur le forum.</h2>
            <div class="habblet box-content">
              <?PHP if (isset($affichage)) {
                echo "<br/>" . $affichage . "";
              } ?>
              <form name='editor' method='post' action="?do=create">
                <td width="100" class="tbl"><b>Titre de ton billet :</b><br /></td>
                <td width="80%" class="tbl"><input type="text" name="titre" value="<?php if (!empty($_POST["titre"])) {
                                                                                      echo htmlspecialchars($_POST["titre"], ENT_QUOTES);
                                                                                    } ?>" class="text" style="width: 240px"><br /><br /></td>
                <td width='100' class='tbl'><b>Catégorie de ton billet :</b><br /></td>
                <select name="categorie" id="pays">
                  <?PHP
                  if ($user['rank'] >= 5) {
                    $sql_a = $bdd->query("SELECT * FROM gabcms_forum_sous_categorie WHERE staff = '1' ORDER BY id DESC");
                    while ($a = $sql_a->fetch()) {
                  ?>
                      <option value="<?PHP echo $a['id'] ?>" <?php if (isset($forum) && $forum == $a['id']) echo 'selected="selected"'; ?>>[STAFF] » <?PHP echo $a['nom'] ?></option>
                  <?PHP }
                  } ?>
                  <?PHP
                  $sql_b = $bdd->query("SELECT * FROM gabcms_forum_sous_categorie WHERE staff = '0' ORDER BY id DESC");
                  while ($b = $sql_b->fetch()) {
                  ?>
                    <option value="<?PHP echo $b['id'] ?>" <?php if (isset($forum) && $forum == $b['id']) echo 'selected="selected"'; ?>>» <?PHP echo $b['nom'] ?></option>
                  <?PHP } ?>
                </select><br /><br />
                <td width='100' class='tbl'><b>Le corps de ton billet :</b><br /></td>
                <td width='80%' class='tbl'><textarea name='article' rows="10" id="editor"><?php
                                                                                            if (isset($_POST["article"])) {
                                                                                              echo htmlspecialchars($_POST["article"], ENT_QUOTES);
                                                                                            }
                                                                                            ?></textarea>
                  <script>
                    ClassicEditor
                      .create(document.querySelector('#editor'))
                      .catch(error => {
                        console.error(error);
                      });
                  </script>
                  <br />
                </td>
                <td align='center' colspan='2' class='tbl'>
                  <input type='submit' name='submit' value='Poster'>
              </form>
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
  <!-- FOOTER -->
  <?PHP include("../template/footer.php"); ?>
  <!-- FIN FOOTER -->
  <script type="text/javascript">
    HabboView.run();
  </script>
</body>

</html>