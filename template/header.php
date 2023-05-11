<?php

/*===================================================+
|| # HoloCMS - Website and Content Management System
|+===================================================+
|| # Copyright &copy; 2008 Meth0d. All rights reserved.
|| # http://www.meth0d.org
|+===================================================+
|| # HoloCMS is provided "as is" and comes without
|| # warrenty of any kind. HoloCMS is free software!
|+===================================================*/

if (!isset($_SESSION['username'])) {
    Redirect($url . "/index");
}

if (empty($body_id)) {
    $body_id = "home";
}

$sql = $bdd->query("SELECT * FROM gabcms_config WHERE id = '1'");
$cof = $sql->fetch(PDO::FETCH_ASSOC);

?>
<?PHP
$message = $bdd->query("SELECT * FROM gabcms_header WHERE id = '1'");
$c = $message->fetch(PDO::FETCH_ASSOC);
if ($c['afficher'] == "Oui") {
?><div style="background-color:#<?PHP echo Secu($c['couleur']); ?>; width: 100%; color:#FFFFFF; padding:5px; margin-left:-10px;"><b><?PHP echo stripslashes($c['message']); ?></b></div>
<?PHP } ?>
<?php if (!empty($user['topbg'])) { ?>
    <style>
        #header-container {
            background-image: url(<?php echo $user['topbg']; ?>);
        }
    </style>
<?php } ?>

<div style="display:block; position:fixed;" title="Contact le service client" onmouseover="tooltip.show(this)" onmouseout="tooltip.hide(this)">
    <a href="<?PHP echo $url; ?>/service_client/"><img src="<?PHP echo $imagepath; ?>v2/images/bouton_sc.png" style="margin-left:10px;margin-top:10px;" /></a>
</div>

<body id="<?php echo $body_id; ?>" class="<?php if (!$user['id']) {
                                                echo "anonymous";
                                            } ?> ">
    <div id="overlay"></div>

    <div id="header-container">
        <div id="header" class="clearfix">
            <h1><a href="<?php echo $url; ?>"></a></h1>
            <div id="subnavi">
                <div id="subnavi-user">
                    <?php if ($user['id']) { ?>
                        <ul>
                            <li id="myfriends"><a href="#"><span>Mes amis</span></a><span class="r"></span></li>
                            <li id="mygroups"><a href="#"><span>Mes clans</span></a><span class="r"></span></li>
                            <li id="myrooms"><a href="#"><span>Mes apparts</span></a><span class="r"></span></li>
                        </ul>
                    <?php } elseif (!$user['id']) { ?>
                        <div class="clearfix">&nbsp;</div>
                        <p>
                        <div id="to-hotel">
                            <a href="client.php" class="new-button green-button" target="client" onclick="HabboClient.openOrFocus(this); return false;"><b>Acc&eacute;der &agrave; <?php echo $shortname; ?></b><i></i></a>
                        </div>
                        </p>
                    <?php } ?>
                    <?php if ($cof['etat_client'] == '1' || $cof['etat_client'] == '3' && $cof['si3_debut'] < $nowtime && $cof['si3_fin'] < $nowtime) { ?>
                        <div id="to-hotel">
                            <a href="client.php" class="new-button green-button" target="client" onclick="HabboClient.openOrFocus(this); return false;"><b>Acc&eacute;der &agrave; <?php echo $shortname; ?></b><i></i></a>
                        </div>
                    <?php } elseif ($cof['etat_client'] == '2') { ?>
                        <div id="hotel-closed-medium"><?php echo $sitename; ?> est ferm&eacute;</div>
                    <?php } ?>
                </div>
                <?php if (!$user['id']) { ?>
                    <div id="subnavi-login">
                        <form action="index.php?anonymousLogin" method="post" id="login-form">
                            <input type="hidden" name="page" value="<?php echo $pageid; ?>" />
                            <ul>
                                <li>
                                    <label for="login-username" class="login-text"><b>Pseudo</b></label>
                                    <input tabindex="1" type="text" class="login-field" name="username" id="login-username" />
                                    <a href="#" id="login-submit-new-button" class="new-button" style="float: left; display:none"><b>Entrer</b><i></i></a>
                                    <input type="submit" id="login-submit-button" value="Sign in" class="submit" />
                                </li>
                                <li>
                                    <label for="login-password" class="login-text"><b>Mot de passe</b></label>
                                    <input tabindex="2" type="password" class="login-field" name="password" id="login-password" />
                                    <input tabindex="3" type="checkbox" name="_login_remember_me" value="true" id="login-remember-me" />
                                    <label for="login-remember-me" class="left">Se souvenir de moi</label>
                                </li>
                            </ul>
                        </form>
                        <div id="subnavi-login-help" class="clearfix">
                            <ul>
                                <li class="register"><a href="forgot.php" id="forgot-password"><span>Pseudo/mot de passe oubli&eacute;</span></a></li>
                                <li><a href="register.php"><span>Inscription gratuite</span></a></li>
                            </ul>
                        </div>
                        <div id="remember-me-notification" class="bottom-bubble" style="display:none;">
                            <div class="bottom-bubble-t">
                                <div></div>
                            </div>
                            <div class="bottom-bubble-c">
                                By selecting 'remember me' you will stay signed in on this computer until you click 'Sign Out'. If this is a public computer please do not use this feature.
                            </div>
                            <div class="bottom-bubble-b">
                                <div></div>
                            </div>
                        </div>
                    </div>
            </div>
            <script type="text/javascript">
                LoginFormUI.init();
                RememberMeUI.init("right");
            </script>
        <?php } else { ?>
            <div id="subnavi-search">
                <div id="subnavi-search-upper">
                    <ul id="subnavi-search-links">
                        <li><a href="<?PHP echo $url; ?>/service_client/" target="habbohelp" onclick="openOrFocusHelp(this); return false">Aide</a></li>
                        <li><a href="logout" class="userlink">D&eacute;connexion</a></li>
                    </ul>
                </div>
                <form name="tag_search_form" action="info" class="search-box clearfix">
                    <a id="search-button" class="new-button search-icon" href="#" onclick="$('search-button').up('form').submit(); return false;"><b><span></span></b><i></i></a>
                    <input type="text" name="tag" id="search_query" placeholder="Pseudo..." class="search-box-query search-box-onfocus" style="float: right" />
                </form>
            </div>
        </div>
        <script type="text/javascript">
            L10N.put("purchase.group.title", "Acheter un clan");
        </script>
    <?php } ?>
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
            <li class="selected"><a href="<?PHP echo $url; ?>/community">Communaut&eacute;</a> <span></span>
            </li>
        <?PHP } else { ?>
            <li class=""><a href="<?PHP echo $url; ?>/community">Communaut&eacute;</a> <span></span>
            </li>
        <?PHP } ?>
        <!-- FIN DU BOUTTON COMMUNAUTE -->
        <!-- BOUTTON SECURITE -->
        <?PHP if ($pageid == "safety" ||  $pageid == "habbo_way") { ?>
            <li class="selected"><a href="<?PHP echo $url; ?>/safety">S&eacute;curit&eacute;</a> <span></span>
            </li>
        <?PHP } else { ?>
            <li class=""><a href="<?PHP echo $url; ?>/safety">S&eacute;curit&eacute;</a> <span></span>
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
        <div class="rounded"><span><strong><?PHP echo Connected("other"); ?></strong></span></div>
    </div>
    </div>
    </div>

    <div id="content-container">

        <div id="navi2-container" class="pngbg">
            <div id="navi2" class="pngbg clearfix">

                <ul>
                    <?PHP if ($pageid == "accueil" || $pageid == "option" || $pageid == "alert" || $pageid == "flux" || $pageid == "dossier" || $pageid == "info" || $pageid == "transactions" || $pageid == "infos") { ?>
                        <?PHP if ($pageid == "accueil") { ?>
                            <li class=" selected">Avatar</li>
                        <?PHP } else { ?>
                            <li class=""><a href="<?PHP echo $url; ?>/moi">Avatar</a></li>
                        <?PHP } ?>
                        <?PHP if ($pageid == "option") { ?>
                            <li class="selected">Préférences</li>
                        <?PHP } else { ?>
                            <li class=""><a href="<?PHP echo $url; ?>/profile">Préférences</a></li>
                        <?PHP } ?>
                        <?PHP if ($pageid == "alert") { ?>
                            <li class=" selected">Alertes</li>
                        <?PHP } else { ?>
                            <li class=""><a href="<?PHP echo $url; ?>/alerts">Alertes</a></li>
                        <?PHP } ?>
                        <?PHP if ($pageid == "flux") { ?>
                            <li class=" selected">Flux</li>
                        <?PHP } else { ?>
                            <li class=""><a href="<?PHP echo $url; ?>/flux">Flux</a></li>
                        <?PHP } ?>

                        <?PHP if ($pageid == "info") { ?>
                            <li class=" selected">Compte</li>
                        <?PHP } else { ?>
                            <li class=""><a href="<?PHP echo $url; ?>/user_profile?tag=<?PHP echo $user['username']; ?>">Compte</a></li>
                        <?PHP } ?>

                        <?PHP if ($user['rank'] >= 4) { ?>
                            <?PHP if ($pageid == "dossier") { ?>
                                <li class=" selected">Dossier</li>
                            <?PHP } else { ?>
                                <li class=""><a href="<?PHP echo $url; ?>/managements/mondossier">Dossier</a></li>
                        <?PHP }
                        } ?>

                        <?PHP if ($pageid == "transactions") { ?>
                            <li class=" selected">Transactions</li>
                        <?PHP } else { ?>
                            <li class=""><a href="<?PHP echo $url; ?>/transactions">Transactions</a></li>
                        <?PHP } ?>

                        <?PHP if ($pageid == "infos") { ?>
                            <li class=" selected">Infos</li>
                        <?PHP } else { ?>
                            <li class=""><a href="<?PHP echo $url; ?>/infos">Infos</a></li>
                        <?PHP } ?>

                    <?PHP } ?>
                    <?PHP if ($pageid == "communaute" || $pageid == "tchat" || $pageid == "articles" || $pageid == "staff" || $pageid == "recrut" || $pageid == "rs" || $pageid == "sdf" || $pageid == "error") { ?>
                        <?PHP if ($pageid == "communaute") { ?>
                            <li class=" selected">Communaut&eacute;</li>
                        <?PHP } else { ?>
                            <li class=""><a href="<?PHP echo $url; ?>/community">Communaut&eacute;</a></li>
                        <?PHP } ?>
                        <?PHP if ($pageid == "articles") { ?>
                            <li class=" selected">Articles</li>
                        <?PHP } else { ?>
                            <li class=""><a href="<?PHP echo $url; ?>/articles">Articles</a></li>
                        <?PHP } ?>
                        <?PHP if ($pageid == "staff") { ?>
                            <li class=" selected">L'&eacute;quipe</li>
                        <?PHP } else { ?>
                            <li class=""><a href="<?PHP echo $url; ?>/lequipe">L'&eacute;quipe</a></li>
                        <?PHP } ?>
                        <?PHP if ($pageid == "recrut") { ?>
                            <li class=" selected">Recrutements</li>
                        <?PHP } else { ?>
                            <li class=""><a href="<?PHP echo $url; ?>/recrutement">Recrutements</a></li>
                        <?PHP } ?>
                        <?PHP if ($pageid == "rs") { ?>
                            <li class=" selected">Réseaux</li>
                        <?PHP } else { ?>
                            <li class=""><a href="<?PHP echo $url; ?>/reseaux">Réseaux</a></li>
                        <?PHP } ?>
                        <?PHP if ($pageid == "sdf") { ?>
                            <li class=" selected">Fansites</li>
                        <?PHP } else { ?>
                            <li class=""><a href="<?PHP echo $url; ?>/fansites">Fansites</a></li>
                        <?PHP } ?>
                        <?PHP if ($pageid == "tchat") { ?>
                            <li class=" selected">Tchat</li>
                        <?PHP } else { ?>
                            <li class=""><a href="<?PHP echo $url; ?>/tchat">Tchat</a></li>
                        <?PHP } ?>
                    <?PHP } ?>
                    <?PHP if ($pageid == "safety" || $pageid == "habbo_way" || $pageid == "videinventaire") { ?>
                        <?PHP if ($pageid == "safety") { ?>
                            <li class=" selected">Conseils de s&eacute;curit&eacute;</li>
                        <?PHP } else { ?>
                            <li class=""><a href="<?PHP echo $url; ?>/safety">Conseils de s&eacute;curit&eacute;</a></li>
                        <?PHP } ?>
                        <?PHP if ($pageid == "habbo_way") { ?>
                            <li class=" selected"><?PHP echo $sitename; ?> attitude</li>
                        <?PHP } else { ?>
                            <li class=""><a href="<?PHP echo $url; ?>/habbo_way"><?PHP echo $sitename; ?> attitude</a></li>
                        <?PHP } ?>
                        <?PHP if ($pageid == "videinventaire") { ?>
                            <li class=" selected">Vider l'inventaire</li>
                        <?PHP } else { ?>
                            <li class=""><a href="<?PHP echo $url; ?>/videinventaire">Vider l'inventaire</a></li>
                        <?PHP } ?>
                    <?PHP } ?>
                    <?PHP if ($pageid == "badgeshop" || $pageid == "achats" || $pageid == "codepromo" || $pageid == "jetons" || $pageid == "clubs" || $pageid == "clubhc" || $pageid == "pixels" || $pageid == "credits") { ?>
                        <?PHP if ($pageid == "jetons") { ?>
                            <li class=" selected">Jetons</li>
                        <?PHP } else { ?>
                            <li class=""><a href="<?PHP echo $url; ?>/jetons">Jetons</a></li>
                        <?PHP } ?>
                        <?PHP if ($pageid == "pixels") { ?>
                            <li class=" selected">Pixels</li>
                        <?PHP } else { ?>
                            <li class=""><a href="<?PHP echo $url; ?>/pixels">Pixels</a></li>
                        <?PHP } ?>
                        <?PHP if ($pageid == "credits") { ?>
                            <li class=" selected">Crédits</li>
                        <?PHP } else { ?>
                            <li class=""><a href="<?PHP echo $url; ?>/credits">Crédits</a></li>
                        <?PHP } ?>
                        <?PHP if ($pageid == "achats") { ?>
                            <li class=" selected">Profil</li>
                        <?PHP } else { ?>
                            <li class=""><a href="<?PHP echo $url; ?>/achats">Profil</a></li>
                        <?PHP } ?>
                        <?PHP if ($pageid == "clubs") { ?>
                            <li class=" selected">Clubs</li>
                        <?PHP } else { ?>
                            <li class=""><a href="<?PHP echo $url; ?>/clubs">Premium</a></li>
                        <?PHP } ?>
                        <?PHP if ($pageid == "badgeshop") { ?>
                            <li class=" selected">Acheter des badges</li>
                        <?PHP } else { ?>
                            <li class=""><a href="<?PHP echo $url; ?>/shopbadge">Acheter des badges</a></li>
                        <?PHP } ?>
                        <?PHP if ($pageid == "clubhc") { ?>
                            <li class=" selected">Devenir HC</li>
                        <?PHP } else { ?>
                            <li class=""><a href="<?PHP echo $url; ?>/club">Devenir HC</a></li>
                        <?PHP } ?>
                        <?PHP if ($pageid == "codepromo") { ?>
                            <li class=" selected">Code</li>
                        <?PHP } else { ?>
                            <li class=""><a href="<?PHP echo $url; ?>/code_promo">Code</a></li>
                        <?PHP } ?>
                    <?PHP } ?>

                    <?PHP if ($pageid == "tchatstaff" || $pageid == "sta" || $pageid == "nds" || $pageid == "bureau" || $pageid == "sc_index") { ?>
                        <?PHP if ($pageid == "bureau") { ?>
                            <li class=" selected">Bureau</li>
                        <?PHP } else { ?>
                            <li class=""><a href="<?PHP echo $url; ?>/managements/bureau">Bureau</a></li>
                        <?PHP } ?>
                        <?PHP if ($pageid == "nds") { ?>
                            <li class=" selected">Notes</li>
                        <?PHP } else { ?>
                            <li class=""><a href="<?PHP echo $url; ?>/managements/nds">Notes</a></li>
                        <?PHP } ?>
                        <?PHP if ($pageid == "sta") { ?>
                            <li class=" selected">Absents</li>
                        <?PHP } else { ?>
                            <li class=""><a href="<?PHP echo $url; ?>/managements/absence">Absents</a></li>
                        <?PHP } ?>
                        <?PHP if ($pageid == "tchatstaff") { ?>
                            <li class=" selected">Tchat</li>
                        <?PHP } else { ?>
                            <li class=""><a href="<?PHP echo $url; ?>/managements/stafftchat">Tchat</a></li>
                        <?PHP } ?>
                        <?PHP if ($pageid == "sc_index") { ?>
                            <li class=" selected">Tickets (<b><?php $req = "SELECT COUNT(*) AS id FROM gabcms_contact WHERE resul != '6' AND resul != '7' AND resul != '8'";
                                                                $query = $bdd->query($req);
                                                                $nb_inscrit = $query->fetch();
                                                                echo $nb_inscrit['id'];
                                                                ?></b>)</li>
                        <?PHP } else { ?>
                            <li class=""><a href="<?PHP echo $url; ?>/managements/sc_index">Tickets (<b><?php $req = "SELECT COUNT(*) AS id FROM gabcms_contact WHERE resul != '6' AND resul != '7' AND resul != '8'";
                                                                                                        $query = $bdd->query($req);
                                                                                                        $nb_inscrit = $query->fetch();
                                                                                                        echo $nb_inscrit['id'];
                                                                                                        ?></b>)</a></li>
                        <?PHP } ?>
                        <?PHP if ($pageid == "admin") { ?>
                            <li style="color:red" class=" selected">Administration</li>
                        <?PHP } else { ?>
                            <li class=""><a style="color:red" href="<?PHP echo $url; ?>/managements/">Administration</a></li>
                        <?PHP } ?>
                    <?PHP } ?>
                </ul>


            </div>
        </div>