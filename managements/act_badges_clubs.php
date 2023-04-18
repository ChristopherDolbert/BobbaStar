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
	
	if($user['rank'] < 7) {
	Redirect("".$url."/managements/acces_neg");
	exit();
	}
	if($user['rank'] > 8) {              
	Redirect("".$url."/managements/acces_neg");
	exit();
	}	

if(isset($_GET['do'])) {
    if($do == 'ajouter') {
    $do = Secu($_GET['do']);
    if(isset($_POST['club']) || isset($_POST['badge_id'])) {
       $club = Secu($_POST['club']);
       $badge_id = Secu($_POST['badge_id']);
    if($club == '1') { $modif_club = 'VIP Club'; }
    if($club == '2') { $modif_club = 'STAFF Club'; }
          if($badge_id != "" && $club != "") {
            $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
                $insertn1->bindValue(':pseudo', $user['username']);
                $insertn1->bindValue(':action', 'a ajouté un badge pour le <b>'.$modif_club.'</b> ('.$badge_id.')');
                $insertn1->bindValue(':date', FullDate('full'));
            $insertn1->execute(); 
            $insertn2 = $bdd->prepare("INSERT INTO gabcms_config_badges (club, badge_id, date, pseudo, ip) VALUES (:club, :badge, :date, :pseudo, :ip)");
                $insertn2->bindValue(':club', $club);
                $insertn2->bindValue(':badge', $badge_id);
                $insertn2->bindValue(':date', FullDate('full'));
                $insertn2->bindValue(':pseudo', $user['username']);
                $insertn2->bindValue(':ip', $user['ip_last']);
            $insertn2->execute();
          echo '<h4 class="alert_success">Tu viens d\'ajouter le badge <b>'.$badge_id.'</b> pour les adhérants au <b>'.$modif_club.'</b></h4>';
          } else {
          echo '<h4 class="alert_error">Merci de remplir tous les champs vides.</h4>';
          }
      }
    }
}

if(isset($_GET['sup'])) {
$sup = Secu($_GET['sup']);
	$info = $bdd->query("SELECT * FROM gabcms_config_badges WHERE id = '".$sup."'");
	$i = $info->fetch(PDO::FETCH_ASSOC);
		if($i['club'] == '1') { $modifier_club = 'VIP Club'; }
		elseif($i['club'] == '2') { $modifier_club = 'STAFF Club'; };
			if($sup != "") {
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a supprimé un badge qui était pour le <b>'.$modifier_club.'</b> ('.$i['badge_id'].')');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
		$bdd->query("DELETE FROM gabcms_config_badges WHERE id = '".$sup."'");
			echo '<h4 class="alert_success">Tu viens de supprimer le badge <b>'.$i['badge_id'].'</b> qui était pour les adhérants au <b>'.$modifier_club.'</b></h4>';
			} else {
			echo '<h4 class="alert_error">Merci de remplir tous les champs vides.</h4>';
		}
}
?>

<link rel="stylesheet" href="css/contenu.css" type="text/css" media="screen" /><body>
<span id="titre">Badges pour les clubs</span><br/>
Ajoute, modifie ou supprime un badge qui devrait être donné pour un club.
 <br/><br/>
 <script type="text/javascript" src="editeur_html/jscripts/tiny_mce/tiny_mce.js"></script>
<form name='editor' method='post' action="?do=ajouter">
<b>ID du badge qui sera donné :</b><br/>
<input type="text" placeholder="Exemple : Badge MRG01..." name="badge_id" value="" class="text" size="25" maxlength="25"><br/><br/>
<b>Club pour le quel le badge sera donné :</b><br/>
<select name="club" id="lenght" class="select">
	<option value="">-- Choisis ton club --</option>
	<option value="1">VIP Club</option>
	<option value="2">STAFF Club</option>
</select><br/><br/>
<input type='submit' name='submit' value='Ajouter' class='submit'></form>
<hr/>
<table>
    <tbody>
        <tr class="haut">
            <td class="haut">Badge ID</td>
            <td class="haut">Club</td>
            <td class="haut">Créer par</td>
            <td class="haut">Date</td>
            <td class="haut">IP</td>
            <td class="haut">Actions</td>
        </tr>
<?php
 $i = 0;
 $sql = $bdd->query("SELECT * FROM gabcms_config_badges ORDER BY club DESC");
 while($a = $sql->fetch()) {
if($a['club'] == '1') { $modifier_club = 'VIP Club'; }
if($a['club'] == '2') { $modifier_club = 'STAFF Club'; }
?>
        <tr class="bas">
            <td class="bas"><img src="<?PHP echo $swf_badge; echo Secu($a['badge_id']); ?>.gif" /><br/>(<?PHP echo Secu($a['badge_id']); ?>)</td>
            <td class="bas"><?PHP echo $modifier_club; ?></td>
            <td class="bas"><?PHP echo Secu($a['pseudo']); ?></td>
            <td class="bas"><?PHP echo Secu($a['date']); ?></td>
            <td class="bas"><?PHP echo Secu($a['ip']); ?></td>
            <td class="bas"><a href="?sup=<?PHP echo Secu($a['id']); ?>" onclick="return confirm(\'Êtes-vous certain de supprimer ce badge ?\')">Supprimer</a></td>
        </tr>
<?PHP } ?>
    </tbody>
</table>
</body>
</html>