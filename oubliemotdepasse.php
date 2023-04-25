<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|

#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("./config.php");
include("./locale/$language/login.php");
$pagename = "Mot de passe oublié ?";
$pageid = "index";

# Formulaire pour demander un nouveau mot de passe #
if (isset($_GET['demande'])) {
	$demande = Secu($_GET['demande']);
	if ($demande == "rempli") {
		if (isset($_POST['email'])) {
			$email = Secu($_POST['email']);
			if (isset($_POST['pseudo'])) {
				$pseudo = Secu($_POST['pseudo']);
				$verif_user = $bdd->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
				$verif_user->execute([$pseudo]);
				$row = $verif_user->rowCount();
				if ($row > 0) {
					$user = $verif_user->fetch(PDO::FETCH_ASSOC);
					$verif_mail = $bdd->prepare("SELECT * FROM users WHERE id = ? AND mail = ? LIMIT 1");
					$verif_mail->execute([$user['id'], $email]);
					$row_mail = $verif_mail->rowCount();
					if ($row_mail > 0) {
						$code = "" . Genere_code(8) . "-" . Genere_code(8) . "-" . Genere_code(8) . "-" . Genere_code(8) . "";
						$lien = "&u=" . $user['username'] . "&e=" . $email . "&c=" . Genere_code(8) . "";
						$insertusera = $bdd->prepare("INSERT INTO gabcms_motdepasse_oublier (user_id, email, code, lien, ip, utilise) VALUES (:user_id, :email, :code, :lien, :ip, :utilise)");
						$insertusera->bindValue(':user_id', $user['id']);
						$insertusera->bindValue(':email', $email);
						$insertusera->bindValue(':code', $code);
						$insertusera->bindValue(':lien', $lien);
						$insertusera->bindValue(':ip', $_SERVER["REMOTE_ADDR"]);
						$insertusera->bindValue(':utilise', '1');
						$insertusera->execute();
						$fichier_message = '<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bonjour <b>' . $user['username'] . '</b>,</div>
<div>&nbsp;</div>
<div>Tu as demandé que ton mot de passe soit changé. Ta demande a été accepté, pour cela, voici les étapes :</div>
<ol>
	<li>Clique sur le lien ci-contre : <a href="' . $url . '/oubliemotdepasse?changement=nok' . $lien . '">ici</a></li>
	<li>Copie dans l&#39;emplacement prévu le code qui te sera fourni en bas de ce MP.</li>
	<li>Recopie un nouveau mot de passe, et hop, &ccedil;a sera bon !</li>
</ol>
<div>Voici le code : <b>' . $code . '</b></div>
<div>&nbsp;</div>
<div><span style="color:#FF0000"><strong>Attention, le code est utilisable qu&#39;une fois.</strong></span></div>
<div>&nbsp;</div>
<div style="text-align: right;">Cordialement, l&#39;équipe de ' . $sitename . '</div>
<div>&nbsp;</div>
<div>&nbsp;</div>
<div><sub>Demande effectuée le ' . FullDate('full') . ' &agrave; l&#39;adresse IP suivante : <i>' . $_SERVER["REMOTE_ADDR"] . '</i></sub></div>'; //On ajoute les infos au message
						// On définit la liste des inscrits.
						$message = $fichier_message;
						$destinataire = $email;

						$objet = "Changement de mot de passe (oublie) - " . $sitename . ""; // On définit l'objet qui contient la date.

						// On définit le reste des paramètres.
						$headers  = "MIME-Version: 1.0 \r\n";
						$headers .= "Content-type: text/html; charset=utf-8 \r\n";
						$headers .= "From: Contact - " . $sitename . " <" . $mail . "> \r\n"; // On définit l'expéditeur.

						// On envoie l'e-mail.
						mail($destinataire, $objet, $fichier_message, $headers);
						$affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-green\"> 
              Ta demande a été enregistrée avec succès. Tu as reçu un mail dans lequel tout te sera expliqué. Penses à vérifier dans ta boite spam.
            </div> 
        </div> 
</div>";
					} else {
						$affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
              L'email et l'utilisateur ne correspondent pas
            </div> 
        </div> 
</div>";
					}
				} else {
					$affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
              L'utilisateur n'existe pas
            </div> 
        </div> 
</div>";
				}
			} else {
				$affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
              Le pseudo n'a pas été renseigné
            </div> 
        </div> 
</div>";
			}
		} else {
			$affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
              L'email n'a pas été renseigné
            </div> 
        </div> 
</div>";
		}
	} else {
		$affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
              Le lien du formulaire n'est pas le bon
            </div> 
        </div> 
</div>";
	}
}

# Formulaire pour modifier son mot de passe #
if (isset($_GET['changement'])) {
	$changement = Secu($_GET['changement']);
	if ($changement == 'ok') {
		if (isset($_GET['u']) && isset($_GET['e']) && isset($_GET['c'])) {
			$u = Secu($_GET['u']);
			$e = Secu($_GET['e']);
			$c = Secu($_GET['c']);
			$lien_concret = "&u=" . $u . "&e=" . $e . "&c=" . $c . "";
			if (isset($_POST['code']) && isset($_POST['bean_repassword']) && isset($_POST['bean_password'])) {
				$code = Secu($_POST['code']);
				$motdepasse = password_hash($_POST['bean_password'], PASSWORD_BCRYPT);
				$remotdepasse = $_POST['bean_repassword'];
				if (password_verify($remotdepasse, $motdepasse)) {
					if (strlen($motdepasse) >= 6) {
						$verif_mdp = $bdd->prepare("SELECT * FROM gabcms_motdepasse_oublier WHERE code = ? AND lien = ? LIMIT 1");
						$verif_mdp->execute([$code, $lien_concret]);
						$row_mdp = $verif_mdp->rowCount();
						if ($row_mdp > 0) {
							$mdpo = $verif_mdp->fetch(PDO::FETCH_ASSOC);
							if ($mdpo['utilise'] == '1') {
								if ($mdpo['ip'] == $_SERVER['REMOTE_ADDR']) {
									if ($mdpo['lien'] == $lien_concret) {
										if ($mdpo['code'] == $code) {
											$update_mdp = $bdd->prepare("UPDATE users SET password = ? WHERE username = ? AND mail = ? LIMIT 1");
											$update_mdp->execute([$motdepasse, $u, $e]);
											$set_use = $bdd->prepare("UPDATE gabcms_motdepasse_oublier SET utilise = '2' WHERE id = ? LIMIT 1");
											$set_use->execute([$mdpo['id']]);
											$affichage = "<div id=\"purse-redeem-result\"> 
                                        <div class=\"redeem-error\"> 
                                        <div class=\"rounded rounded-green\"> 
                                        Ton nouveau mot de passe à bien été modifié, reconnecte-toi!
                                        </div> 
                                        </div> 
                                        </div>";
										} else {
											$affichage = "<div id=\"purse-redeem-result\"> 
                                    <div class=\"redeem-error\"> 
                                    <div class=\"rounded rounded-red\"> 
                                    Le code ne correspond pas au code fourni dans le mail. Votre demande a été clôturé, merci d'en recréer une autre.
                                    </div> 
                                    </div> 
                                    </div>";
											$set_use = $bdd->prepare("UPDATE gabcms_motdepasse_oublier SET utilise = '2' WHERE id = ?");
											$set_use->execute([$mdpo['id']]);
										}
									} else {
										$affichage = "<div id=\"purse-redeem-result\"> 
                                <div class=\"redeem-error\"> 
                                <div class=\"rounded rounded-red\"> 
                                Le lien ne correspond pas au lien fourni dans le mail. Votre demande a été clôturé, merci d'en recréer une autre.
                                </div> 
                                </div> 
                                </div>";
										$set_use = $bdd->prepare("UPDATE gabcms_motdepasse_oublier SET utilise = '2' WHERE id = ?");
										$set_use->execute([$mdpo['id']]);
									}
								} else {
									$affichage = "<div id=\"purse-redeem-result\"> 
                            <div class=\"redeem-error\"> 
                            <div class=\"rounded rounded-red\"> 
                            L'ip ne correspond pas à l'adresse IP du demandeur de base. Votre demande a été clôturé, merci d'en recréer une autre.
                            </div> 
                            </div> 
                            </div>";
									$set_use = $bdd->prepare("UPDATE gabcms_motdepasse_oublier SET utilise = '2' WHERE id = ?");
									$set_use->execute([$mdpo['id']]);
								}
							} else {
								$affichage = "<div id=\"purse-redeem-result\"> 
                        <div class=\"redeem-error\"> 
                        <div class=\"rounded rounded-red\"> 
                        Cette demande est clotûrée. Merci d'en recréer une autre.
                        </div> 
                        </div> 
                        </div>";
							}
						} else {
							$affichage = "<div id=\"purse-redeem-result\"> 
                    <div class=\"redeem-error\"> 
                    <div class=\"rounded rounded-red\"> 
                    Cette demande n'existe pas.
                    </div> 
                    </div> 
                    </div>";
						}
					} else {
						$affichage = "<div id=\"purse-redeem-result\"> 
                    <div class=\"redeem-error\"> 
                    <div class=\"rounded rounded-red\"> 
                    Ton mot de passe est trop court
                    </div> 
                    </div> 
                    </div>";
					}
				} else {
					$affichage = "<div id=\"purse-redeem-result\"> 
                <div class=\"redeem-error\"> 
                <div class=\"rounded rounded-red\"> 
                Les mots de passe ne correspondent pas
                </div> 
                </div> 
                </div>";
				}
			} else {
				$affichage = "<div id=\"purse-redeem-result\"> 
            <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-red\"> 
            Tous les champs requis ne sont pas remplis.
            </div> 
            </div> 
            </div>";
			}
		} else {
			$affichage = "<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
        <div class=\"rounded rounded-red\"> 
        Le lien n'est pas complet.
        </div> 
        </div> 
        </div>";
		}
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?PHP echo $sitename; ?><?PHP echo $description; ?></title>

	<script type="text/javascript">
		var andSoItBegins = (new Date()).getTime();
	</script>
	<link rel="shortcut icon" href="<?PHP echo $imagepath; ?>v2/favicon.ico" type="image/vnd.microsoft.icon" />
	<script src="<?PHP echo $imagepath; ?>static/js/libs2.js" type="text/javascript"></script>
	<script src="<?PHP echo $imagepath; ?>static/js/landing.js" type="text/javascript"></script>
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/style.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/buttons.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/boxes.css<?php echo '?' . mt_rand(); ?>" type="text/css" />
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/tooltips.css<?php echo '?' . mt_rand(); ?>" type="text/css" />

	<script src="<?PHP echo $imagepath; ?>js/local/com.js" type="text/javascript"></script>
	<link rel="stylesheet" href="<?PHP echo $imagepath; ?>v2/styles/process.css<?php echo '?' . mt_rand(); ?>" type="text/css" />



	<meta name="description" content="Join the world's largest virtual hangout where you can meet and make friends. Design your own rooms, collect cool furniture, throw parties and so much more! Create your FREE Retro today!" />
	<meta name="keywords" content="Retro, virtual, world, join, groups, forums, play, games, online, friends, teens, collecting, social network, create, collect, connect, furniture, virtual, goods, sharing, badges, social, networking, hangout, safe, music, celebrity, celebrity visits, cele" />

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
body { behavior: url(<?PHP echo $imagepath; ?>js/csshover.htc); }
</style>
<![endif]-->
	<meta name="build" content="<?PHP echo $sitename; ?> <?PHP echo $version; ?>" />
</head>

<body id="landing" class="process-template">

	<div id="overlay"></div>

	<div id="container">
		<div class="cbb process-template-box clearfix">
			<div id="content">
				<div id="header" class="clearfix">
					<h1><a href="index.php"></a></h1>
					<ul class="stats">
						<li class="stats-online"><span class="stats-fig"><?PHP $tmp = $bdd->query("SELECT count(id) FROM users WHERE online = '1'");
																			$tma = $tmp->fetch(PDO::FETCH_ASSOC);
																			echo $tma['count(id)']; ?></span> Connectés</li>
					</ul>
				</div>
				<div id="process-content">
					<div class="left-column">

						<?php if (!empty($affichage)) { ?>
							<p><?php echo "<div align='center'><b>" . $affichage . "</b></div>"; ?></p>
						<?php } ?>

						<?PHP if (!isset($_GET['changement']) && !isset($_GET['u']) && !isset($_GET['e']) && !isset($_GET['c'])) { ?>
							<div class="cbb clearfix">
								<h2 class="title">Etape 1/2 - Renseignements divers</h2>
								<div class="box-content">

									<p>
										Il semblerait que tu ne trouves plus ton mot de passe ?<br /><br />
										Ne t'inquiètes pas, <?PHP echo $sitename; ?> gère tout, il suffit que tu fournisses ton pseudo et ton adresse email. Si ils correspondent, tu recevras un mail, avec un lien et un code a entré. Ce code est utilisable une fois, ne te trompe pas.<br />
										<i>NB : Si ton IP lors de cette demande ne correspond pas à l'IP que tu fournis dans le formulaire du mail, ta requête sera refusée d'office.</i>
									</p>

									<div class="clear"></div>

									<form action="?demande=rempli" method="post" id="forgottenpw-form">
										<p>
											<label for="pseudo">Nom d'utilisateur</label>
											<input type="text" name="pseudo" id="pseudoe" value="" required />
										</p>

										<p>
											<label for="email">E-mail</label>
											<input type="text" name="email" id="email" value="" required />
										</p>

										<p>
											<input type="submit" id="envoyer" value="Envoyer" class="submit process-button" id="forgottenpw-submit">
										</p>
									</form>
								</div>
							</div>

						<?php } elseif (isset($_GET['changement']) && isset($_GET['u']) && isset($_GET['e']) && isset($_GET['c'])) { ?>
							<div class="cbb clearfix">
								<h2 class="title">Etape 2/2 - Changement de mot de passe</h2>
								<div class="box-content">

									<p> Si tu es arrivé ici, c'est que tu as reçu le mail. Dans le formulaire ci-contre, merci de renseigner ton code ainsi que ton nouveau mot de passe.</p>

									<div class="clear"></div>

									<form id="forgottenpw-form" action="?changement=ok&u=<?PHP echo $_GET['u']; ?>&e=<?PHP echo $_GET['e']; ?>&c=<?PHP echo $_GET['c']; ?>" method="post">
										<p>
											<label for="code">Code</label>
											<input type="text" name="code" id="code" value="" required />
										</p>

										<p>
											<label for="bean_password">Nouveau mot de passe</label>
											<input type="password" name="bean_password" id="bean_password" value="" required />
										</p>

										<p>
											<label for="bean_repassword">Confirmer le mot de passe</label>
											<input type="password" name="bean_repassword" id="bean_repassword" value="" required />
										</p>

										<p>
											<input class="submit process-button" id="forgottenpw-submit" type="submit" id="envoyer" class="new-button fill" value="Réinitialiser le mot de passe">
										</p>
										<input type="hidden" value="default" name="origin" />
									</form>
								</div>
							</div>
						<?php } ?>

					</div>


					<div class="right-column">

						<div class="cbb clearfix">
							<h2 class="title"><?php echo $locale['forgot_false_alarm']; ?></h2>
							<div class="box-content">
								<p><?php echo $locale['forgot_false_alarm_content']; ?></p>
								<p><a href="index.php"><?php echo $locale['forgot_back']; ?> &raquo;</a></p>
							</div>
						</div>

					</div>

					<!-- FOOTER -->
					<?PHP include("./template/footer.php"); ?>
					<!-- FIN FOOTER -->
				</div>


			</div>

			<script type="text/javascript">
				HabboView.run();
			</script>
		</div>
	</div>


</body>

</html>