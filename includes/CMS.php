<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|           GabCMS - Site Web et Content Management System               #|
#|         Copyright © 2012-2014 - Gabodd Tout droits réservés.           #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

	$date = date('dmY');
	$sitename = "MyHabbo";
	$url = "http://bobbastar.test";
	$description = "&raquo; Créer ton appart, tchat avec des centaines d'utilisateurs et fais-toi de nouveaux amis.";
	$imagepath = "".$url."/web-gallery/"; 
	$keyword = "CMS, GabCMS, Habbo, rétro, jeune, ados, love, kiff, habbo";
	$build = "GabCMS";
	$version = "RELEASE".$date; 
	$swf_badge = "http://images-eussl.habbo.com/c_images/album1584/"; # Met le lien direct vers le dossier des badges de ton site
	$owner = "Gabodd";
	$mail = ""; 
	$mail_newsletter = "";
	$compte_twitter = "GabCMS";
	$compte_facebook = "Gabcms";

   //Config Starpass
   $id_document = 444508; //Identifiant du document starpass
   $id_compte = 248094; /*Id compte starpass pour le récupérer faites installer sur starpass et dans l'étape 2 cherchez
                         $idp=.... après $idp= c'est l'id de votre compte starpass vous n'avez qu'à le prendre.
                       */
	
	# INSCRIPTION (Configuration de l'utilisateur) ÇA NE SERT À RIEN DE TOUCHER! (Sauf les looks bien sûr) #
	$credits = "10000";
	$pixels = "5000";
	$mission = "Bienvenue sur ".$sitename."!";
	$rank = "1";
	$look_boy = "sh-3016-63.ch-215-63.hd-209-8.lg-275-63.hr-831-31";
	$look_girl = "ch-655-63.lg-3006-63-62.hr-3012-33.cc-3008-64-62.sh-3064-63.hd-605-7";
?>