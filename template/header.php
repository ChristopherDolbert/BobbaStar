<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|           GabCMS - Site Web et Content Management System               #|
#|         Copyright © 2012-2014 - Gabodd Tout droits réservés.           #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

$sqlss = $bdd->query("SELECT * FROM gabcms_maintenance WHERE id = '1'");
$c = $sqlss->fetch(PDO::FETCH_ASSOC);
if ($c['activ'] == "Oui") {
?><div style="background-color:#FF0000; width: 100%; color:#FFFFFF; padding:5px; margin-left:-10px;"><b>MAINTENANCE EN COURS</b></div>
<?PHP } ?>
<?PHP
$message = $bdd->query("SELECT * FROM gabcms_header WHERE id = '1'");
$c = $message->fetch(PDO::FETCH_ASSOC);
if ($c['afficher'] == "Oui") {
?><div style="background-color:#<?PHP echo Secu($c['couleur']); ?>; width: 100%; color:#FFFFFF; padding:5px; margin-left:-10px;"><b><?PHP echo stripslashes($c['message']); ?></b></div>
<?PHP } ?>
<div style="display:block; position:fixed;" title="Contact le service client" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)">
	<a href="<?PHP echo $url; ?>/service_client/"><img src="<?PHP echo $imagepath; ?>v2/images/bouton_sc.png" style="margin-left:10px;margin-top:10px;" /></a>
</div>
<div id="header-container">
	<div id="header" class="clearfix">
		<h1><a href="<?PHP echo $url; ?>"></a></h1>
		<div id="subnavi">
			<div id="subnavi-user">
			</div>
			<div id="subnavi-search">
				<div id="subnavi-search-upper">
				</div>
			</div>
			<div id="to-hotel">
				<style>
					.header {
						position: absolute;
						width: 175px;
						float: right;
						left: -400px;
						top: -15px;
						height: 15px;
						width: 380px;
						background: #FFFFFF;
						border-radius: 5px;
						padding: 10px;
						margin: 10px auto;
					}
				</style>
				<div class="header">
					<div style="position:absolute;float:right;left:-400px;top:-10px;background-image:url('#');height:36px;width:400px;"></div>
				</div>
				<div style="position:absolute;float:right;left:-390px;top:-5px;height:32px;width:380px;padding-top:2px;">
					<p style="margin-top:9px;padding-left:5px;" class="alignleft"><a href="<?PHP echo $url; ?>/client" target="habbohelp" onclick="openOrFocusHelp(this); return false"><b>Entre sur <?PHP echo $sitename; ?></b></a> |
						<a href="<?PHP echo $url ?>/forum/">Forum</a> |
						<a href="<?PHP echo $url ?>/logout" class="userlink" id="signout">Se déconnecter</a>
					</p>
				</div>
			</div>
		</div>
		<style>
			#header {
				position: relative;
				background: url(./images/subnavibg.png) no-repeat 190px 0;
			}
		</style>
		<ul id="navi">
			<!-- BOUTTON JOUEUR -->
			<?PHP if ($pageid == "accueil" || $pageid == "option" || $pageid == "alert" || $pageid == "flux" || $pageid == "dossier" || $pageid == "info" || $pageid == "transactions") { ?>
				<li class="metab selected"><strong><?PHP echo $user['username']; ?> (<?PHP echo $user['id']; ?> <b><img src="<?PHP echo $imagepath; ?>images/icon_habbo_small.png" style="vertical-align: bottom;"></b>)</strong> <span></span>
				</li>
			<?PHP } else { ?>
				<li class=""><a href="<?PHP echo $url; ?>/moi"><?PHP echo $user['username']; ?> (<?PHP echo $user['id']; ?> <b><img src="<?PHP echo $imagepath; ?>images/icon_habbo_small.png" style="vertical-align: bottom;"></b>)</a> <span></span>
				</li>
			<?PHP } ?>
			<!-- FIN DU BOUTTON JOUEUR -->
			<!-- BOUTTON COMMUNAUTE -->
			<?PHP if ($pageid == "communaute" || $pageid == "tchat" || $pageid == "forum" || $pageid == "articles" || $pageid == "staff" || $pageid == "recrut" || $pageid == "rs" || $pageid == "sdf" || $pageid == "error") { ?>
				<li class="selected"><a href="<?PHP echo $url; ?>/community">Communauté</a> <span></span>
				</li>
			<?PHP } else { ?>
				<li class=""><a href="<?PHP echo $url; ?>/community">Communauté</a> <span></span>
				</li>
			<?PHP } ?>
			<!-- FIN DU BOUTTON COMMUNAUTE -->
			<!-- BOUTTON SECURITE -->
			<?PHP if ($pageid == "safety" ||  $pageid == "habbo_way") { ?>
				<li class="selected"><a href="<?PHP echo $url; ?>/safety">Sécurité</a> <span></span>
				</li>
			<?PHP } else { ?>
				<li class=""><a href="<?PHP echo $url; ?>/safety">Sécurité</a> <span></span>
				</li>
			<?PHP } ?>
			<!-- FIN DU BOUTTON SECURITE -->
			<!-- BOUTTON BOUTIQUE -->
			<?PHP if ($pageid == "badgeshop" || $pageid == "achats" || $pageid == "codepromo" || $pageid == "jetons" || $pageid == "clubs" || $pageid == "shopbots") { ?>
				<li class="selected"><a href="<?PHP echo $url; ?>/jetons">Boutique</a> <span></span>
				</li>
			<?PHP } else { ?>
				<li class=""><a href="<?PHP echo $url; ?>/jetons">Boutique</a> <span></span>
				<?PHP } ?>
				<!-- FIN DU BOUTON BOUTIQUE -->
				<!-- BOUTON MANAGEMENTS -->
				<?PHP if ($user['rank'] >= 5) { ?>
					<?PHP if ($pageid == "tchatstaff" || $pageid == "sta" || $pageid == "nds" || $pageid == "bureau" || $pageid == "acces" || $pageid == "sc_index" || $pageid == "forum_index") { ?>
				<li class="selected"><a href="<?PHP echo $url; ?>/managements/bureau">Managements</a><span></span>
				</li>
			<?PHP } else { ?>
				<li id="tab-register-now" class="tab-register-now"><a href="<?php echo $url; ?>/managements/bureau">Managements</a><span></span></li>
		<?PHP }
				} ?>
		<!-- FIN BOUTTON MANAGEMENTS -->
		</ul>
		<div id="habbos-online">
			<div class="rounded"><span>Il y a <?PHP $tmp = $bdd->query("SELECT count(id) FROM users WHERE online = '1'");
												$tma = $tmp->fetch(PDO::FETCH_ASSOC);
												echo $tma['count(id)']; ?> connectés</span></div>
		</div>
	</div>
</div>
<div id="content-container">
	<div id="navi2-container" class="pngbg">
		<div id="navi2" class="pngbg clearfix">
			<ul>
				<?PHP if ($pageid == "accueil" || $pageid == "option" || $pageid == "alert" || $pageid == "flux" || $pageid == "dossier" || $pageid == "info" || $pageid == "transactions") { ?>
					<?PHP if ($pageid == "accueil") { ?>
						<li class=" selected">Mon avatar</li>
					<?PHP } else { ?>
						<li class=""><a href="<?PHP echo $url; ?>/moi">Mon avatar</a></li>
					<?PHP } ?>
					<?PHP if ($pageid == "option") { ?>
						<li class="selected">Mes Préférences</li>
					<?PHP } else { ?>
						<li class=""><a href="<?PHP echo $url; ?>/profile">Mes Préférences</a></li>
					<?PHP } ?>
					<?PHP if ($pageid == "alert") { ?>
						<li class=" selected">Mes alertes</li>
					<?PHP } else { ?>
						<li class=""><a href="<?PHP echo $url; ?>/alerts">Mes alertes</a></li>
					<?PHP } ?>
					<?PHP if ($pageid == "flux") { ?>
						<li class=" selected">Mes flux</li>
					<?PHP } else { ?>
						<li class=""><a href="<?PHP echo $url; ?>/flux">Mes flux</a></li>
					<?PHP } ?>
					<?PHP if ($pageid == "info") { ?>
						<li class=" selected">Mes infos</li>
					<?PHP } else { ?>
						<li class=""><a href="<?PHP echo $url; ?>/info?pseudo=<?PHP echo $user['username']; ?>">Mes infos</a></li>
					<?PHP } ?>
					<?PHP if ($user['rank'] >= 4) { ?>
						<?PHP if ($pageid == "dossier") { ?>
							<li class=" selected">Mon dossier</li>
						<?PHP } else { ?>
							<li class=""><a href="<?PHP echo $url; ?>/managements/mondossier">Mon dossier</a></li>
					<?PHP }
					} ?>
					<?PHP if ($pageid == "transactions") { ?>
						<li class=" selected">Mes transactions</li>
					<?PHP } else { ?>
						<li class=""><a href="<?PHP echo $url; ?>/transactions">Mes transactions</a></li>
					<?PHP } ?>
				<?PHP } ?>
				<?PHP if ($pageid == "communaute" || $pageid == "tchat" || $pageid == "forum" || $pageid == "articles" || $pageid == "staff" || $pageid == "recrut" || $pageid == "rs" || $pageid == "sdf" || $pageid == "error") { ?>
					<?PHP if ($pageid == "communaute") { ?>
						<li class=" selected">Communauté</li>
					<?PHP } else { ?>
						<li class=""><a href="<?PHP echo $url; ?>/community">Communauté</a></li>
					<?PHP } ?>
					<?PHP if ($pageid == "articles") { ?>
						<li class=" selected">Articles</li>
					<?PHP } else { ?>
						<li class=""><a href="<?PHP echo $url; ?>/articles">Articles</a></li>
					<?PHP } ?>
					<?PHP if ($pageid == "staff") { ?>
						<li class=" selected">L'équipe</li>
					<?PHP } else { ?>
						<li class=""><a href="<?PHP echo $url; ?>/lequipe">L'équipe</a></li>
					<?PHP } ?>
					<?PHP if ($pageid == "recrut") { ?>
						<li class=" selected">Recrutements</li>
					<?PHP } else { ?>
						<li class=""><a href="<?PHP echo $url; ?>/recrutement">Recrutements</a></li>
					<?PHP } ?>
					<?PHP if ($pageid == "rs") { ?>
						<li class=" selected">Réseaux sociaux</li>
					<?PHP } else { ?>
						<li class=""><a href="<?PHP echo $url; ?>/reseaux">Réseaux sociaux</a></li>
					<?PHP } ?>
					<?PHP if ($pageid == "sdf") { ?>
						<li class=" selected">Sites de fan</li>
					<?PHP } else { ?>
						<li class=""><a href="<?PHP echo $url; ?>/fansites">Sites de fan</a></li>
					<?PHP } ?>
					<?PHP if ($pageid == "tchat") { ?>
						<li class=" selected">Tchat</li>
					<?PHP } else { ?>
						<li class=""><a href="<?PHP echo $url; ?>/tchat">Tchat</a></li>
					<?PHP } ?>
					<?PHP if ($pageid == "forum") { ?>
						<li class=" selected">Forum</li>
					<?PHP } else { ?>
						<li class=""><a href="<?PHP echo $url; ?>/forum/">Forum</a></li>
					<?PHP } ?>
				<?PHP } ?>
				<?PHP if ($pageid == "safety" || $pageid == "habbo_way") { ?>
					<?PHP if ($pageid == "safety") { ?>
						<li class=" selected">Conseils de sécurité</li>
					<?PHP } else { ?>
						<li class=""><a href="<?PHP echo $url; ?>/safety">Conseils de sécurité</a></li>
					<?PHP } ?>
					<?PHP if ($pageid == "habbo_way") { ?>
						<li class=" selected"><?PHP echo $sitename; ?> attitude</li>
					<?PHP } else { ?>
						<li class=""><a href="<?PHP echo $url; ?>/habbo_way"><?PHP echo $sitename; ?> attitude</a></li>
					<?PHP } ?>
				<?PHP } ?>
				<?PHP if ($pageid == "badgeshop" || $pageid == "achats" || $pageid == "codepromo" || $pageid == "jetons" || $pageid == "clubs" || $pageid == "shopbots") { ?>
					<?PHP if ($pageid == "jetons") { ?>
						<li class=" selected">Jetons</li>
					<?PHP } else { ?>
						<li class=""><a href="<?PHP echo $url; ?>/jetons">Jetons</a></li>
					<?PHP } ?>
					<?PHP if ($pageid == "achats") { ?>
						<li class=" selected">Achats</li>
					<?PHP } else { ?>
						<li class=""><a href="<?PHP echo $url; ?>/achats">Achats</a></li>
					<?PHP } ?>
					<?PHP if ($pageid == "clubs") { ?>
						<li class=" selected">Clubs</li>
					<?PHP } else { ?>
						<li class=""><a href="<?PHP echo $url; ?>/clubs">Clubs</a></li>
					<?PHP } ?>
					<?PHP if ($pageid == "badgeshop") { ?>
						<li class=" selected">Acheter des badges</li>
					<?PHP } else { ?>
						<li class=""><a href="<?PHP echo $url; ?>/shopbadge">Acheter des badges</a></li>
					<?PHP } ?>
					<?PHP if ($pageid == "shopbots") { ?>
						<li class=" selected">Acheter des bots</li>
					<?PHP } else { ?>
						<li class=""><a href="<?PHP echo $url; ?>/shopbots">Acheter des bots</a></li>
					<?PHP } ?>
					<?PHP if ($pageid == "codepromo") { ?>
						<li class=" selected">Codes promos</li>
					<?PHP } else { ?>
						<li class=""><a href="<?PHP echo $url; ?>/code_promo">Codes promos</a></li>
					<?PHP } ?>
				<?PHP } ?>

				<?PHP if ($pageid == "tchatstaff" || $pageid == "sta" || $pageid == "nds" || $pageid == "bureau" || $pageid == "sc_index" || $pageid == "forum_index") { ?>
					<?PHP if ($pageid == "bureau") { ?>
						<li class=" selected">Bureau des staffs</li>
					<?PHP } else { ?>
						<li class=""><a href="<?PHP echo $url; ?>/managements/bureau">Bureau des staffs</a></li>
					<?PHP } ?>
					<?PHP if ($pageid == "nds") { ?>
						<li class=" selected">Notes de Service</li>
					<?PHP } else { ?>
						<li class=""><a href="<?PHP echo $url; ?>/managements/nds">Notes de Service</a></li>
					<?PHP } ?>
					<?PHP if ($pageid == "sta") { ?>
						<li class=" selected">Les absents</li>
					<?PHP } else { ?>
						<li class=""><a href="<?PHP echo $url; ?>/managements/absence">Les absents</a></li>
					<?PHP } ?>
					<?PHP if ($pageid == "tchatstaff") { ?>
						<li class=" selected">Staff tchat</li>
					<?PHP } else { ?>
						<li class=""><a href="<?PHP echo $url; ?>/managements/stafftchat">Staff tchat</a></li>
					<?PHP } ?>
					<?PHP if ($pageid == "admin") { ?>
						<li class=" selected">Administration</li>
					<?PHP } else { ?>
						<li class=""><a href="<?PHP echo $url; ?>/managements/">Administration</a></li>
					<?PHP } ?>
					<?PHP if ($pageid == "sc_index") { ?>
						<li class=" selected">Centre de Traitement des Aides (<b><?php $req = "SELECT COUNT(*) AS id FROM gabcms_contact WHERE resul != '6' AND resul != '7' AND resul != '8'";
																					$query = $bdd->query($req);
																					$nb_inscrit = $query->fetch();
																					echo $nb_inscrit['id'];
																					?></b> en attente)</li>
					<?PHP } else { ?>
						<li class=""><a href="<?PHP echo $url; ?>/managements/sc_index">Centre de Traitement des Aides (<b><?php $req = "SELECT COUNT(*) AS id FROM gabcms_contact WHERE resul != '6' AND resul != '7' AND resul != '8'";
																															$query = $bdd->query($req);
																															$nb_inscrit = $query->fetch();
																															echo $nb_inscrit['id'];
																															?></b> en attente)</a></li>
					<?PHP } ?>
					<?PHP if ($pageid == "forum_index") { ?>
						<li class=" selected">Traiter les signalements (<b><?php $req = "SELECT COUNT(*) AS id FROM gabcms_forum_signalement WHERE etat != '2'";
																			$query = $bdd->query($req);
																			$nb_inscrit = $query->fetch();
																			echo $nb_inscrit['id'];
																			?></b> en attente)</li>
					<?PHP } else { ?>
						<li class=""><a href="<?PHP echo $url; ?>/managements/forum_index">Traiter les signalements (<b><?php $req = "SELECT COUNT(*) AS id FROM gabcms_forum_signalement WHERE etat != '2'";
																														$query = $bdd->query($req);
																														$nb_inscrit = $query->fetch();
																														echo $nb_inscrit['id'];
																														?></b> en attente)</a></li>
					<?PHP } ?>
					<?PHP if ($user['rank'] == 8) { ?>
						<li class=""><a href="<?PHP echo $url; ?>/managements/info_gabcms">Informations CMS (dernières infos, contacter le service client...)</a></li>
					<?PHP } ?>
				<?PHP } ?>
			</ul>
		</div>
	</div>