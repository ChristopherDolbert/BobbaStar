<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
$nowtime = time();

@session_start();
@include("./includes/SQL.php");
@include("../includes/SQL.php");
@include("../../includes/SQL.php");
@include("./includes/CMS.php");
@include("../includes/CMS.php");
@include("../../includes/CMS.php");
@include("./includes/Function.php");
@include("../includes/Function.php");
@include("../../includes/Function.php");

if (function_exists('date_default_timezone_set')) {
	@date_default_timezone_set('Europe/Paris');
}

if (isset($_SESSION['username'])) {
	$username = Secu($_SESSION['username']);
	$stmt = $bdd->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
	$stmt->execute(['username' => $_SESSION['username']]);
	$row = $stmt->rowCount();

	if ($row > 0) {
		$user = $stmt->fetch(PDO::FETCH_ASSOC);
		$stmt = $bdd->prepare("UPDATE users SET ip_current = :ip_address WHERE id = :user_id");
		$stmt->execute(['ip_address' => $_SERVER["REMOTE_ADDR"], 'user_id' => $user['id']]);
		IsHCMember($user['id']);
	} else {
		session_destroy();
		Redirect($url);
		exit();
	}
}


$maintid = "1";
$sqlss = $bdd->query("SELECT * FROM gabcms_maintenance WHERE id = '1'");
$c = $sqlss->fetch(PDO::FETCH_ASSOC);
$query = $bdd->prepare("SELECT * FROM bans WHERE ip = ?");
$query->execute([$_SERVER['REMOTE_ADDR']]);
$data = $query->fetch(PDO::FETCH_ASSOC);
$ban = array();
if ($data) {
	$ban[] = $data['value'];
}
$ip = $_SERVER['REMOTE_ADDR'];
if (in_array($ip, $ban)) {
	Redirect("" . $url . "/banip");
}
if (isset($_SESSION['username'])) {
	$sql = $bdd->prepare("SELECT * FROM bans WHERE user_id = :user_id");
	$sql->execute(array('user_id' => $user['id']));
	$b = $sql->fetch(PDO::FETCH_ASSOC);
	$now = time();
	if ($b && $now < $b['ban_expire']) {
		$expire = date('d/m/Y H:i', $b['ban_expire']);
		Redirect($url . "/banned");
	}
}




#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|          Sécurité            #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

foreach ($_GET as $getSearchs) {
	$getSearch = explode(" ", $getSearchs);
	foreach ($getSearch as $k => $v) {
		$v = trim(strip_tags($v)); // Nettoyer les valeurs d'entrée et éviter les failles XSS
		if (preg_match('/\b(?:insert|union|select|null|count|from|like|drop|table|where|column|tables|information_schema|or)\b/i', $v)) {
			exit; // Utiliser des expressions régulières pour détecter les motifs d'injection plutôt que d'utiliser un tableau de chaînes
		}
	}
}
