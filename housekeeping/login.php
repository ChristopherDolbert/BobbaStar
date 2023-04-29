<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

require_once('../config.php');

if ($hkzone !== true) {
	header("Location: index.php?throwBack=true");
	exit;
}

if (isset($_SESSION['id'])) {
	header("Location: index.php?loginThrowBack=true");
	exit;
}

$pagename = "Login";

if (isset($_POST['username'])) {
	$form_name = Secu($_POST['username']);
	$form_pass = Secu($_POST['password']);

	$stmt = $bdd->prepare("SELECT id,username,password FROM users WHERE username = :username AND rank > 5 LIMIT 1");
	$stmt->bindParam(':username', $form_name);
	$stmt->execute();

	$valid = $stmt->rowCount();
	$row = $stmt->fetch();

	if (empty($form_name) || empty($form_pass)) {
		$msg = "Vos identifiants sont requis";
	} else {
		if ($valid > 0 && password_verify($form_pass, $row['password'])) {
			$_SESSION['acp'] = true;
			$_SESSION['hkusername'] = $row['username'];
			$_SESSION['hkpassword'] = $form_pass;

			$my_id = $row['id'];

			// Log them in on the site as well if needed
			if (!isset($_SESSION['username'])) {
				$_SESSION['username'] = $row['username'];
				$_SESSION['password'] = $form_pass;
			}

			header("Location: index.php?p=dashboard");
			$stmt = $bdd->prepare("INSERT INTO system_stafflog (action,message,note,userid,targetid,timestamp) VALUES (:action,:message,:note,:userid,:targetid,:timestamp)");
			$stmt->execute(array(':action' => 'Housekeeping', ':message' => $row['username'] . " authenticated from " . $_SERVER['REMOTE_ADDR'], ':note' => 'login.php', ':userid' => $my_id, ':targetid' => '', ':timestamp' => time()));

			exit;
		} else {
			$msg = "Mot de passe invalide";
		}
	}

	if (isset($notify_logout)) {
		if ($notify_logout == true) {
			$msg = "Déconnexion du panneau de gestion réussie";
		} elseif (!isset($_SESSION['acp'])) {
			$msg = "Session d'administration non trouvée";
		}
	}
}

include('subheader.php');

?>

<body style='background-image:url(&#039;images/blank.gif&#039;)'>
	<div id='loading-layer' style='display:none'>
		<div id='loading-layer-shadow'>
			<div id='loading-layer-inner'>
				<img src='./images/loading_anim.gif' style='vertical-align:middle' border='0' alt='Loading...' /><br />
				<span style='font-weight:bold' id='loading-layer-text'>Loading Data. Please Wait...</span>
			</div>
		</div>
	</div>
	<div id='ipdwrapper'><!-- IPDWRAPPER -->
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<div align='center'>
			<div style='width:500px'>
				<div class='outerdiv' id='global-outerdiv'><!-- OUTERDIV -->
					<table cellpadding='0' cellspacing='8' width='100%' id='tablewrap'>
						<tr>
							<td id='rightblock'>
								<div>
									<form id='loginform' action='index.php?p=login&do=submit' method='post'>
										<input type='hidden' name='qstring' value='' />
										<table width='100%' cellpadding='0' cellspacing='0' border='0'>
											<tr>
												<td width='200' class='tablerow1' valign='top' style='border:0px;width:200px'>
													<div style='text-align:center;padding-top:20px'>
														<img src='./images/acp-login-lock.gif' alt='Housekeeping' border='0' />
													</div>
													<br />
													<div class='desctext' style='font-size:10px'>
														<div align='center'><strong>Bienvenue sur l'interface de gestion</strong></div>
														<br />
														<div style='font-size:9px;color:gray'>Cette page est r�server a la team de <?php echo $shortname; ?> si tu ne fait pas partie de la team de <?php echo $shortname; ?> identifiez-vous.<br /><br />Si vous avait oublier votre mot de passe <a href='../forgot.php'>cliquer ici</a> Ou conctacter l'administrateur</div>
													</div>
												</td>
												<td width='300' style='width:300px' valign='top'>
													<table width='100%' cellpadding='5' cellspacing='0' border='0'>
														<tr>
															<td colspan='2' align='center'>
																<br />
																<img src='./images/holocms-logo.png' alt='BioCMS'>
																<div style='font-weight:bold;color:red'><?php if (isset($msg)) {
																											echo $msg;
																										} ?></div><br />
															</td>
														</tr>
														<tr>
															<td align='right'><strong>Nom</strong></td>
															<td><input style='border:1px solid #AAA' type='text' size='20' name='username' id='namefield' value='<?php if (!isset($_POST['username'])) {
																																									} else {
																																										echo htmlentities($_POST['username'], ENT_QUOTES);
																																									} ?>' /></td>
														</tr>
														<tr>
															<td align='right'><strong>Mot de passe</strong></td>
															<td><input style='border:1px solid #AAA' type='password' size='20' name='password' value='' /></td>
														</tr>
														<tr>
															<td colspan='2' align='center'><input type='submit' style='border:1px solid #AAA' value='Valider' /></td>
														</tr>
														<tr>
															<td colspan='2'><br />

															</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>
									</form>

								</div>
							</td>
						</tr>
					</table>
				</div><!-- / OUTERDIV -->

			</div>
		</div>
		<script type='text/javascript'>
			/*
			if (top.location != self.location) {
				top.location = self.location
			}

			try {
				window.onload = function() {
					document.getElementById('namefield').focus();
				}
			} catch (error) {
				alert(error);
			}

			*/
		</script>