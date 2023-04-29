<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");
$pagename = "Newsletter";
$pageid = "news";

if (!isset($_SESSION['username']) || $user['rank'] < 10 || $user['rank'] > 11) {
	Redirect("" . $url . "/managements/access_neg");
	exit();
}

if (isset($_GET['do'])) {
	$do = Secu($_GET['do']);
	# Formulaire d'envoi de Newsletter créer par Gabodd pour GabCMS ! #
	if ($do != "") {
		$texte_newsletter = $_POST['texte_newsletter'];
		$titre = $_POST['titre'];
		if ($titre != "" && $texte_newsletter != "") {
			function dater($texte_newsletter)
			{
				$texte = $texte_newsletter;
				$in = array(
					'$date',
				);
				$out = array(
					'' . date("d/m/Y") . '',
				);
				return str_replace($in, $out, $texte);
			}
			$sql_envoi = $bdd->query("SELECT * FROM gabcms_newsletter WHERE id = '1'");
			$envoi_a = $sql_envoi->fetch();
			// Composition du message.
			$fichier_message = dater($envoi_a['newsletter_haut']); // Ajout du haut de la newsletter
			$fichier_message .= '<br/>' . $texte_newsletter . '<br/>'; // Ajout du message créer sur cette page
			$fichier_message .= dater($envoi_a['newsletter_bas']); // Ajout du bas de la newsletter

			// On récupère de la table users les personnes inscrites inscrites.
			$liste_vrac = $bdd->query("SELECT mail FROM users WHERE newsletter = '1'");

			// On définit la liste des inscrits.
			$liste = $mail_newsletter;
			while ($donnees = $liste_vrac->fetch(PDO::FETCH_ASSOC)) {
				$liste .= ","; //On sépare les adresses par une virgule.
				$liste .= $donnees['mail'];
			}
			$message = $fichier_message;
			$destinataire = $liste;
			$okok = $mail_newsletter;
			$objet = $titre; // On définit l'objet qui contient la date.

			// On définit le reste des paramètres.
			$headers  = "MIME-Version: 1.0 \r\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1 \r\n";
			$headers .= "From: Newsletter - " . $sitename . " <" . $mail_newsletter . "> \r\n"; // On définit l'expéditeur.
			$headers .= "Bcc: " . $destinataire . " \r\n"; // On définit les destinataires en copie cachée pour qu'ils ne puissent pas voir les adresses des autres inscrits.

			// On envoie l'e-mail.
			if (mail($okok, $objet, $fichier_message, $headers)) {
				$insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
				$insertn1->bindValue(':pseudo', $user['username']);
				$insertn1->bindValue(':action', 'a envoyé une newsletter aux abonné(e)s <b>(' . addslashes($titre) . ')</b>');
				$insertn1->bindValue(':date', FullDate('full'));
				$insertn1->execute();
				echo '<h4 class="alert_success">La newsletter a été envoyée avec succès</h4>';
			} else {
				echo '<h4 class="alert_error">Une erreur est surevenue</h4>';
			}
		} else {
			echo '<h4 class="alert_error">Le titre ou le texte n\'est pas rempli.</h4>';
		}
	}
}
?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?' . mt_rand(); ?>" type="text/css" media="screen" />

<body>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script src="https://cdn.ckeditor.com/ckeditor5/37.0.1/classic/ckeditor.js"></script>
	<script type="text/javascript" src="<?PHP echo $imagepath; ?>editor/config.js"></script>
	<?PHP
	$sql_modif = $bdd->query("SELECT * FROM gabcms_newsletter WHERE id = '1'");
	$modif_a = $sql_modif->fetch();
	?>
	<span id="titre">Envoyer une newsletter</span><br \>
	Envoyes une newsletter à tous les abonnés à la newsletter de <?PHP echo $sitename; ?>
	<br /><br />
	Actuellement, il y a <b><?php $req = "SELECT COUNT(*) AS total FROM users WHERE newsletter = '1'";
							$query = $bdd->query($req);
							$nb_inscrit = $query->fetch();
							echo $nb_inscrit['total'];
							?></b> inscrits contre <b><?php $req = "SELECT COUNT(*) AS total FROM users WHERE newsletter = '0'";
														$query = $bdd->query($req);
														$nb_inscrit = $query->fetch();
														echo $nb_inscrit['total'];
														?></b> autres qui vont recevoir la newsletter sur leurs adresses mail.
	<br /><br />
	<form name='editor' method='post' action="?do=envoi">
		<td width='100' class='tbl'><b>Titre de ta newsletter :</b><br /></td>
		<td width='80%' class='tbl'><input type="text" name="titre" value="<?php if (!empty($_POST["titre"])) {
																				echo htmlspecialchars($_POST["titre"], ENT_QUOTES);
																			} ?>" class="text" style="width: 240px"><br /></td>
		<br />
		<td width='100' class='tbl'><b>Le corps de ta newsletter : <a href="<?PHP echo $url; ?>/managements/upload" target="_blank">Upload tes images !</a> </b><br /></td>
		<td width='80%' class='tbl'><textarea name="texte_newsletter" wrap="discuss rows=12 cols=154" id="editor1"><?php
																													if (isset($_POST["texte_newsletter"])) {
																														echo htmlspecialchars($_POST["texte_newsletter"], ENT_QUOTES);
																													}
																													?></textarea>
			<script>
				CKEDITOR.replace('editor1', {
					toolbar: 'Newsletter'
				});
			</script>
			<br />
		</td>
		<br />
		<td align='center' colspan='2' class='tbl'>
			<input type='submit' name='submit' value='Envoyer aux abonné(e)s' class='submit'>
	</form>

</body>

</html>