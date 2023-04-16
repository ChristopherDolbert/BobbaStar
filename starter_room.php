<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|           GabCMS - Site Web et Content Management System               #|
#|         Copyright © 2012-2014 - Gabodd Tout droits réservés.           #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

	include("./config.php");

	$bdd->query("INSERT INTO rooms (id,caption,owner,description,model_name,wallpaper,floor) VALUES ('".Genere_chiffre(10)."','Appart de ".$user['username']."','".$user['username']."','".$user['username']." est arrivé sur l\'hôtel !','model_c','1801','610')");
	$sql = $bdd->query("SELECT * FROM rooms WHERE owner = '".$user['username']."' LIMIT 0,1");
	while($room = $sql->fetch()) {
	$bdd->query("INSERT INTO items (room_id,id,base_item,x,y,z,rot) VALUES ('".$room['id']."','".Genere_chiffre(10)."','1064','7','8','0','0')");
	$bdd->query("INSERT INTO items (room_id,id,base_item,x,y,z,rot) VALUES ('".$room['id']."','".Genere_chiffre(10)."','1070','7','7','0','4')");
	$bdd->query("INSERT INTO items (room_id,id,base_item,x,y,z,rot) VALUES ('".$room['id']."','".Genere_chiffre(10)."','1088','5','9','0','2')");
	$bdd->query("UPDATE users SET home_room = '".$room['id']."' WHERE username = '".$user['username']."'"); 
	}
	Redirect("".$url."/client");
?>