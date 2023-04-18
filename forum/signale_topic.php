<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");

if(!isset($_SESSION['username']))
	{
		Redirect("".$url."/index");
		exit();
	}

if(isset($_GET['signalement'])) {
$signalement = Secu($_GET['signalement']);
} if(isset($_GET['signale'])) {
$signale = Secu($_GET['signale']);
}

if($user['id'] != "") {
  	if(isset($_GET['signalement'])) {
			$topic = Secu($_POST['topic']);
			$categorie = Secu($_POST['categorie']);
			$raison = addslashes($_POST['raison']);
				$sql = $bdd->query("SELECT * FROM gabcms_forum_topic WHERE id = '".$signalement."'");
				$n = $sql->fetch(PDO::FETCH_ASSOC);
				$sql_signalee = $bdd->query("SELECT * FROM gabcms_forum_sous_categorie WHERE id = '".$n['categorie_forum']."'");
				$signale_a = $sql_signalee->fetch();
				$sqla = $bdd->query("SELECT * FROM users WHERE id = '".$n['user_id']."'");
				$assoc = $sqla->fetch(PDO::FETCH_ASSOC);
			if($topic != "" && $categorie != "" && $raison != "") {
                $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (action, date) VALUES (:action, :date)");
                    $insertn1->bindValue(':action', 'Un topic vient d\'être signalé ('.$n['titre'].')');
                    $insertn1->bindValue(':date', FullDate('full'));
                $insertn1->execute();
                $insertn2 = $bdd->prepare("INSERT INTO gabcms_forum_signalement (value, id_topic, id_categorie, signaler_par, signaler_le, signaler_texte, signaler_ip, etat) VALUES (:value, :topic, :com, :username, :date, :raison, :ip, :etat)");
                    $insertn2->bindValue(':value', 'topic');
                    $insertn2->bindValue(':topic', $topic);
                    $insertn2->bindValue(':com', $categorie);
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
if(isset($_GET['signale'])) {
	$sql = $bdd->query("SELECT * FROM gabcms_forum_topic WHERE id = '".$signale."'");
	$n = $sql->fetch(PDO::FETCH_ASSOC);
}
?>
<link href="<?PHP echo $url ?>/managements/css/contenu.css" rel="stylesheet" type="text/css">
<meta http-equiv="content-type" content="text/html; charset=UTF-8" /><body>
<title>Signaler un topic (<?PHP echo $n['titre'] ?>)</title>
	<?php if(!isset($_GET['signale'])) { ?>

<p><span id="titre">Selectionnes un topic</span><br \>
Merci de sélectionner un topic
	<?php
	} else {
	?>
<p><span id="titre">Signaler un topic</span><br />
Signales un topic indésirable. Tout abus sera puni<br/><br/>
<?PHP
$sql_signale = $bdd->query("SELECT * FROM gabcms_forum_topic WHERE id = '".$signale."'");
$signale_a = $sql_signale->fetch();
$sql_signalez = $bdd->query("SELECT * FROM gabcms_forum_sous_categorie WHERE id = '".$signale_a['categorie_forum']."'");
$signale_b = $sql_signalez->fetch();
	$sqla = $bdd->query("SELECT * FROM users WHERE id = '".$signale_a['user_id']."'");
	$assoc = $sqla->fetch(PDO::FETCH_ASSOC);
?>
Tu es sur le point de signaler le topic (<?PHP echo $signale_a['titre']; ?>) de <b><?PHP echo $assoc['username']; ?></b>.<br/><br/>
<form name='editor' method='post' action="?signalement=<?php echo $signale; ?>">
<td width="100" class="tbl">Topic <b>n°<?PHP echo $signale_a['id']; ?></b> ; Catégorie <b>n°<?PHP echo $signale_b['id']; ?></b><br/></td>
<input type="hidden" name="topic" value="<?PHP echo $signale_a['id']; ?>"><input type="hidden" name="categorie" value="<?PHP echo $signale_b['id']; ?>">
<br/>
<td width='100' class='tbl'><b>Raison :</b><br/></td>
<td width='80%' class='tbl'><textarea name="raison" wrap=discuss rows=3 cols=34 ></textarea><br/><br/></td>
	<input type="submit" value="Signaler" /></form>
<?PHP } ?>
</body>
</html>