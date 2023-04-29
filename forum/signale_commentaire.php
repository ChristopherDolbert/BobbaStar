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

$signalement = Secu($_GET['signalement']);
$signale = Secu($_GET['signale']);

if($user['id'] != "") {
  	if($signalement != "") {
			$topic = Secu($_POST['topic']);
			$commentaire = Secu($_POST['commentaire']);
			$raison = addslashes($_POST['raison']);
				if($topic != "" && $commentaire != "" && $raison != "") {
                    $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (action, date) VALUES (:action, :date)");
                    $insertn1->bindValue(':action', 'Un commentaire vient d\'être signalé');
                    $insertn1->bindValue(':date', FullDate('full'));
                    $insertn1->execute();
                    $insertn2 = $bdd->prepare("INSERT INTO gabcms_forum_signalement (value, id_topic, id_commentaire, signaler_par, signaler_le, signaler_texte, signaler_ip, etat) VALUES (:value, :topic, :com, :username, :date, :raison, :ip, :etat)");
                    $insertn2->bindValue(':value', 'commentaire');
                    $insertn2->bindValue(':topic', $topic);
                    $insertn2->bindValue(':com', $commentaire);
                    $insertn2->bindValue(':username', $user['username']);
                    $insertn2->bindValue(':date', FullDate('full'));
                    $insertn2->bindValue(':raison', $raison);
                    $insertn2->bindValue(':ip', $user['ip_last']);
                    $insertn2->bindValue(':etat', '0');
                    $insertn2->execute();
	  echo '<h4 class="alert_success">Le signalement a bien eu lieu</h4>';
	  } else {
	  echo '<h4 class="alert_error">Une erreur est survenue</h4>';
	  }
  }
}
?>
<link href="<?PHP echo $url ?>/managements/css/contenu.css" rel="stylesheet" type="text/css">
<meta http-equiv="content-type" content="text/html; charset=UTF-8" /><body>
<title>Signaler un commentaire </title>
	<?php if ($signale == "") { ?>
<p><span id="titre">Selectionnes un commentaire</span><br \>
Merci de sélectionner un commentaire
	<?php
	} else {
	?>
<p><span id="titre">Signaler un commentaire</span><br />
Signales un commentaire indésirable. Tout abus sera puni<br/><br/>
<?PHP
$sql_signale = $bdd->query("SELECT * FROM gabcms_forum_commentaires WHERE id = '".$signale."'");
$signale_a = $sql_signale->fetch();
$sql_signalez = $bdd->query("SELECT * FROM gabcms_forum_topic WHERE id = '".$signale_a['id_topic']."'");
$signale_b = $sql_signalez->fetch();
	$sqla = $bdd->query("SELECT * FROM users WHERE id = '".$signale_a['user_id']."'");
	$assoc = $sqla->fetch(PDO::FETCH_ASSOC);
?>
Tu es sur le point de signaler le commentaire de <b><?PHP echo $assoc['username']; ?></b>.<br/><br/>
<form name='editor' method='post' action="?signalement=<?php echo $signale; ?>">
<td width="100" class="tbl">Topic <b>n°<?PHP echo $signale_b['id']; ?></b> ; Commentaire <b>n°<?PHP echo $signale_a['id']; ?></b><br/></td>
<input type="hidden" name="topic" value="<?PHP echo $signale_b['id']; ?>"><input type="hidden" name="commentaire" value="<?PHP echo $signale_a['id']; ?>">
<br/>
<td width='100' class='tbl'><b>Raison :</b><br/></td>
<td width='80%' class='tbl'><textarea name="raison" wrap=discuss rows=3 cols=34 ></textarea><br/><br/></td>
	<input type="submit" value="Signaler" /></form>
<?PHP } ?>
</body>
</html>