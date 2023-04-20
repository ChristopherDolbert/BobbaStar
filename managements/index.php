<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");
$pagename = "Administration";

if (!isset($_SESSION['username'])) {
    Redirect("" . $url . "/index");
    exit();
}
if ($user['rank'] < 5) {
    Redirect("" . $url . "/managements/acces_interdit");
    exit();
}
if ($user['rank'] > 8) {
    Redirect("" . $url . "/managements/acces_interdit");
    exit();
}

if ($user['rank'] == 8 && $user['gender'] == 'M') {
    $rank_modif = "fondateur";
}
if ($user['rank'] == 7 && $user['gender'] == 'M') {
    $rank_modif = "manager";
}
if ($user['rank'] == 6 && $user['gender'] == 'M') {
    $rank_modif = "administrateur";
}
if ($user['rank'] == 5 && $user['gender'] == 'M') {
    $rank_modif = "modérateur";
}
if ($user['rank'] == 8 && $user['gender'] == 'F') {
    $rank_modif = "fondatrice";
}
if ($user['rank'] == 7 && $user['gender'] == 'F') {
    $rank_modif = "manager";
}
if ($user['rank'] == 6 && $user['gender'] == 'F') {
    $rank_modif = "administratrice";
}
if ($user['rank'] == 5 && $user['gender'] == 'F') {
    $rank_modif = "modératrice";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?PHP echo $sitename; ?> &raquo; <?PHP echo $pagename; ?></title>

    <link rel="shortcut icon" href="<?PHP echo $imagepath; ?>favicon.ico" type="image/vnd.microsoft.icon" />
    <link rel="stylesheet" href="css/layout.css<?php echo '?'.mt_rand(); ?>" type="text/css" media="screen" />
    <!--[if lt IE 9]>
        <link rel="stylesheet" href="css/ie.css<?php echo '?'.mt_rand(); ?>" type="text/css" media="screen" />
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    <script src="js/jquery-1.5.2.min.js" type="text/javascript"></script>
    <script src="js/hideshow.js" type="text/javascript"></script>
    <script src="js/jquery.tablesorter.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/jquery.equalHeight.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".tablesorter").tablesorter();
        });
        $(document).ready(function() {

            //When page loads...
            $(".tab_content").hide(); //Hide all content
            $("ul.tabs li:first").addClass("active").show(); //Activate first tab
            $(".tab_content:first").show(); //Show first tab content

            //On Click Event
            $("ul.tabs li").click(function() {

                $("ul.tabs li").removeClass("active"); //Remove any "active" class
                $(this).addClass("active"); //Add "active" class to selected tab
                $(".tab_content").hide(); //Hide all tab content

                var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
                $(activeTab).fadeIn(); //Fade in the active ID content
                return false;
            });

        });
    </script>
    <script type="text/javascript">
        $(function() {
            $('.column').equalHeight();
        });
    </script>
</head>

<body>
    <header id="header">
        <hgroup>
            <h1 class="site_title">
                <div style="width: 61px; height: 93px; margin-bottom:-15px; margin-top:-5px; margin-left: -5px; float: left; background: url(<?php echo $avatarimage; ?><?PHP echo $user['look']; ?>&action=wav&direction=2&head_direction=2&gesture=sml&size=big&img_format=gif);"></div>
            </h1>
            <h2 class="section_title">Administration</h2>
            <div class="btn_view_site"><a href="<?PHP echo $url; ?>/moi">Aller sur le site</a></div>
        </hgroup>
    </header> <!-- end of header bar -->

    <section id="secondary_bar">
        <div class="user">
            <p>Salut <b><?PHP echo $user['username']; ?></b>, tu es <span style="color: #666;"><b><?PHP echo $rank_modif; ?></b></span></p>
        </div>
        <div class="breadcrumbs_container">
            <article class="breadcrumbs"><a href="#">Administration</a>
                <div class="breadcrumb_divider"></div> <a class="current">Tableau de bord</a>
            </article>
        </div>
    </section><!-- end of secondary bar -->

    <aside id="sidebar" class="column">
        <?PHP if ($user['rank'] == 8) { ?>
            <h3><img src="<?PHP echo $url ?>/managements/images/bouton-adm/1.png" /></h3>
            <ul class="toggle">
                <li>- Absences</li>
                <li><a href="traite_absence" target="main">Traiter des demandes (<b><?php $req = "SELECT COUNT(*) AS id FROM gabcms_absence_staff WHERE etat = 0";
                                                                                    $query = $bdd->query($req);
                                                                                    $nb_inscrit = $query->fetch();
                                                                                    echo $nb_inscrit['id'];
                                                                                    ?></b> en attente)</a></li>
                <li>- Configuration</li>
                <li><a href="cof" target="main">Configuration générale</a></li>
                <li><a href="client" target="main">Configurer le client</a></li>
                <li><a href="act_client" target="main">Configurer l'état de l'hôtel</a></li>
                <li><a href="aff_upload" target="main">Afficher les images uploadés</a></li>
                <?PHP $nb_rank = $bdd->query("SELECT COUNT(*) AS nb FROM users WHERE rank = 8");
                $rankhuit = $nb_rank->fetch();
                if ($rankhuit['nb'] >= '2') { ?><li><a href="act_logs" target="main">Vider les logs (<b><?php $req = "SELECT COUNT(*) AS id FROM gabcms_stafflog_delete WHERE etat < 2";
                                                                                                                            $query = $bdd->query($req);
                                                                                                                            $nb_inscrit = $query->fetch();
                                                                                                                            echo $nb_inscrit['id'];
                                                                                                                            ?></b> en attente)</a></li><?PHP } ?>
                <li>- Grades</li>
                <li><a href="rank" target="main">Rank des utilisateurs</a></li>
                <li><a href="derank" target="main">Dérank des utilisateurs</a></li>
                <li><a href="add_poste" target="main">Attribué un poste</a></li>
                <li><a href="trouv_poste" target="main">Déstitué un poste</a></li>
                <li><a href="act_fonction" target="main">Modifier une fonction</a></li>
                <li>- Postes</li>
                <li><a href="act_poste_categorie" target="main">Actions sur une catégorie</a></li>
                <li><a href="act_poste_nom" target="main">Actions sur un poste</a></li>
                <li>- Recrutements</li>
                <li><a href="create_recrut" target="main">Ouvrir une session</a></li>
                <li><a href="act_recrut" target="main">Action sur une session</a></li>
                <li><a href="traite_recrut" target="main">Traiter une session (<b><?php $req = "SELECT COUNT(*) AS id FROM gabcms_recrutement WHERE date_butoire <= " . $nowtime . " AND etat != 2";
                                                                                    $query = $bdd->query($req);
                                                                                    $nb_inscrit = $query->fetch();
                                                                                    echo $nb_inscrit['id'];
                                                                                    ?></b> en attente)</a></li>
            </ul>
        <?PHP }
        if ($user['rank'] >= 7) { ?><h3><img src="<?PHP echo $url ?>/managements/images/bouton-adm/5.png" /></h3>
            <ul class="toggle">
                <li>- Dossier</li>
                <li><a href="act_averto" target="main">Actions sur les avertissement</a></li>
                <li><a href="add_dossier" target="main">Ajouter un avis sur un dossier</a></li>
                <li>- Configuration</li>
                <li><a href="maintenance" target="main">Configurer la maintenance</a></li>
                <li><a href="act_messageheader" target="main">Configurer le message dans le header</a></li>
                <li><a href="act_prix_clubs" target="main">Configurer les prix d'achats</a></li>
                <li>- Newsletter</li>
                <li><a href="act_newsletter" target="main">Configurer les textes</a></li>
                <li><a href="envoi_newsletter" target="main">Envoyer une newsletter</a></li>
                <li>- Badge shop</li>
                <li><a href="act_badgeshop" target="main">Gestion des badges en vente</a></li>
                <li>- Clubs</li>
                <li><a href="act_badges_clubs" target="main">Modifier les badges donnés</a></li>
                <li>- Bureau des staffs</li>
                <li><a href="act_bureau" target="main">Modifier le bloc-notes</a></li>
                <li><a href="rappelbureau" target="main">Modifier les rappels</a></li>
                <li>- Notes de service</li>
                <li><a href="create_nds" target="main">Créer une note de service</a></li>
                <li><a href="act_nds" target="main">Action sur une note de service</a></li>
                <li>- Forum</li>
                <li><a href="act_forum_categorie" target="main">Actions sur une catégorie</a></li>
                <li><a href="act_forum_sous_categorie" target="main">Actions sur une sous catégorie</a></li>
                <li>- Staff en test</li>
                <li><a href="add_test" target="main">Staff en test</a></li>
            </ul>
        <?PHP }
        if ($user['rank'] >= 6) { ?><h3><img src="<?PHP echo $url ?>/managements/images/bouton-adm/2.png" /></h3>
            <ul class="toggle">
                <li>- Gestion</li>
                <li><a href="act_anim" target="main">Gestion des animations</a></li>
                <li><a href="act_sdf" target="main">Gestion des fansites</a></li>
                <li>- Article</li>
                <li><a href="create_article" target="main">Crée un article</a></li>
                <li><a href="act_article" target="main">Actions sur un article</a></li>
                <li>- Événement</li>
                <li><a href="create_event" target="main">Crée un événement</a></li>
                <li><a href="act_event" target="main">Actions sur un événement</a></li>
                <li>- Événement avec lien</li>
                <li><a href="create_evenlien" target="main">Crée un événement</a></li>
                <li><a href="act_evenlien" target="main">Actions sur un événement</a></li>
                <li>- Divers</li>
                <li><a href="look_transactions" target="main">Transactions des utilisateurs</a></li>
                <li><a href="add_jetons" target="main">Crée des codes jetons</a></li>
                <li><a href="delete_alert" target="main">Traiter les suppressions (<b><?php $req = "SELECT COUNT(*) AS id FROM gabcms_demande";
                                                                                        $query = $bdd->query($req);
                                                                                        $nb_inscrit = $query->fetch();
                                                                                        echo $nb_inscrit['id'];
                                                                                        ?></b> en attente)</a></li>
            </ul>
        <?PHP }
        if ($user['rank'] >= 5) { ?><h3><img src="<?PHP echo $url ?>/managements/images/bouton-adm/3.png" /></h3>
            <ul class="toggle">
                <li>- Alerte</li>
                <li><a href="useralert" target="main">Envoyer une alerte</a></li>
                <li><a href="traite_alert" target="main">Demander la suppression</a></li>
                <li>- Tchat</li>
                <li><a href="messages" target="main">Donner des messages</a></li>
                <li><a href="delete_message" target="main">Enlever des messages</a></li>
                <li><a href="act_messages" target="main">Supprimer touts les messages</a></li>
                <li><a href="look_messages" target="main">Nombres de messages</a></li>
                <li><a href="delete_tchat" target="main">Actions sur un tchat</a></li>
                <li><a href="delete_tchatstaff" target="main">Actions sur un stafftchat</a></li>
                <li><a href="tchat" target="main">Envoyer une alerte sur le tchat</a></li>
                <li>- Modération</li>
                <li><a href="banuser" target="main">Bannir des utilisateurs</a></li>
                <li><a href="debanuser" target="main">Débannir des utilisateurs</a></li>
                <li><a href="disabled" target="main">Désactiver des comptes</a></li>
                <li><a href="enabled" target="main">Re-activer des comptes</a></li>
                <li><a href="iptool" target="main">Traque multi compte</a></li>
                <li><a href="look_up" target="main">Trouver une adresse IP</a></li>
                <li><a href="banip" target="main">Bannir IP</a></li>
                <li><a href="debanip" target="main">Débannir IP</a></li>
            </ul><?PHP } ?><h3><img src="<?PHP echo $url ?>/managements/images/bouton-adm/4.png" /></h3>
        <ul class="toggle">
            <li><a href="upload.php" target="_blank">Uploadeur d'images</a></li>
            <li><a href="act_users" target="main">Modifier des données sur des utilisateurs</a></li>
            <li><a href="create_absence" target="main">Signaler son absence</a></li>
            <li><a href="info" target="main">Utilisateur info</a></li>
            <li><a href="filter" target="main">Filtre des mots</a></li>
            <li><a href="aff_dossiers" target="main">Voir les dossiers</a></li>
            <li><a href="logs" target="main">Les logs des staffs</a></li>
        </ul>

        <footer>
            <hr />
            <p><strong>Copyright &copy; 2012-<?PHP echo date('Y'); ?></strong></p>
            <p>Page basée sur une template en partage libre - Modifiée par l'équipe de GabCMS</p>
        </footer>
    </aside><!-- end of sidebar -->
    <section id="main" class="column">
        <?php $req = "SELECT COUNT(*) AS id FROM gabcms_test_staff WHERE etat = 0 AND date_fin <= " . $nowtime . " AND tuteur = " . $user['id'] . "";
        $query = $bdd->query($req);
        $nb_inscrit = $query->fetch();
        if ($nb_inscrit['id'] != "0") {
        ?>
            <h4 class="alert_info"><a href="avis_test_tuteur" target="main">- Donner son avis (tuteur) sur un test &raquo;</a></h4>
            <?PHP }
        $req = "SELECT COUNT(*) AS id FROM gabcms_test_staff WHERE etat = 1 AND date_fin <= " . $nowtime . " AND tuteur != " . $user['id'] . "";
        $query = $bdd->query($req);
        $nb_inscrit = $query->fetch();
        if ($nb_inscrit['id'] != "0") {
            if ($user['rank'] == "8") {
            ?>
                <h4 class="alert_info"><a href="avis_test_dir" target="main">- Donner son avis (direction) sur un test &raquo;</a></h4>
        <?PHP }
        } ?>
        <article class="module width_full">
            <header>
                <h3>Administration</h3>
            </header>
            <div class="module_content">
                <iframe src="logs" height="610" width="100%" frameborder="0" name="main" id="main"></iframe>
            </div>
        </article><!-- end of styles article -->
        <div class="spacer"></div>
    </section>


</body>

</html>