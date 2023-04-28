<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

# Nombre de fonctions: 14 #
if ($pagename != "Starters" && isset($_SESSION['username']) && $_SESSION['noob'] == "Oui") {
	Redirect($url . "/starter_room");
}

// Validate the langauge
$language_path = "./" . $language . "index.php";
$language_path_2 = "../" . $language . "index.php";
$valid_language = file_exists($language_path) || file_exists($language_path_2);
$language = ($valid_language) ? $language : "en";

function smileys($texte)
{
	$texte = stripslashes($texte);
	$smileys = array(
		";)" => '<img src="./web-gallery/smileys/clindoeil.gif" alt=";)" title=";)"/>',
		":$" => '<img src="./web-gallery/smileys/embarrase.gif" alt=":$" title=":$"/>',
		":o" => '<img src="./web-gallery/smileys/etonne.gif" alt=":o" title=":o"/>',
		":)" => '<img src="./web-gallery/smileys/happy.gif" alt=":)" title=":)"/>',
		":x" => '<img src="./web-gallery/smileys/icon_silent.png" alt=":x" title=":x"/>',
		":p" => '<img src="./web-gallery/smileys/langue.gif" alt=":p" title=":p"/>',
		":'(" => '<img src="./web-gallery/smileys/sad.gif" alt=":\'(" title=":\'("/>',
		":D" => '<img src="./web-gallery/smileys/veryhappy.gif" alt=":D" title=":D"/>',
		":jap:" => '<img src="./web-gallery/smileys/jap.png" alt=":jap:" title=":jap:"/>',
		"8)" => '<img src="./web-gallery/smileys/cool.gif" alt="8)" title="8)"/>',
		":rire:" => '<img src="./web-gallery/smileys/rire.gif" alt=":rire:" title=":rire:"/>',
		":evil:" => '<img src="./web-gallery/smileys/icon_evil.gif" alt=":evil:" title=":evil:"/>',
		":twisted:" => '<img src="./web-gallery/smileys/icon_twisted.gif" alt=":twisted:" title=":twisted:"/>',
		":rool:" => '<img src="./web-gallery/smileys/roll.gif" alt=":rool:" title=":rool:"/>',
		":|" => '<img src="./web-gallery/smileys/neutre.gif" alt=":|" title=":|"/>',
		":suspect:" => '<img src="./web-gallery/smileys/suspect.gif" alt=":suspect:" title=":suspect:"/>',
		":no:" => '<img src="./web-gallery/smileys/no.gif" alt=":no:" title=":no:"/>',
		":coeur:" => '<img src="./web-gallery/smileys/coeur.gif" alt=":coeur:" title=":coeur:"/>',
		":hap:" => '<img src="./web-gallery/smileys/hap.gif" alt=":hap:" title=":hap:" />',
		":bave:" => '<img src="./web-gallery/smileys/bave.gif" alt=":bave:" title=":bave:" />',
		":areuh:" => '<img src="./web-gallery/smileys/areuh.gif" alt=":areuh:" title=":areuh:" />',
		":bandit:" => '<img src="./web-gallery/smileys/bandit.gif" alt=":bandit:" title=":bandit:" />',
		":help:" => '<img src="./web-gallery/smileys/help.gif" alt=":help:" title=":help:" />',
		":buzz:" => '<img src="./web-gallery/smileys/buzz.gif" alt=":buzz:" title=":buzz:" />'
	);
	$texte = str_replace(array_keys($smileys), array_values($smileys), $texte);
	return $texte;
}

function smileystaff($texte)
{
	$texte = stripslashes($texte);
	$in = array(
		";)",
		":$",
		":o",
		":)",
		":x",
		":p",
		":'(",
		":D",
		":jap:",
		"8)",
		":rire:",
		":evil:",
		":twisted:",
		":rool:",
		":|",
		":suspect:",
		":no:",
		":coeur:",
		":hap:",
		":bave:",
		":areuh:",
		":bandit:",
		":help:",
		":buzz:",
		":contrat:",
		":favo:",
		":contre:",
	);
	$out = array(
		'<img src="../web-gallery/smileys/clindoeil.gif" alt=";)" title=";)"/>',
		'<img src="../web-gallery/smileys/embarrase.gif" alt=":$" title=":$"/>',
		'<img src="../web-gallery/smileys/etonne.gif" alt=":o" title=":o"/>',
		'<img src="../web-gallery/smileys/happy.gif" alt=":)" title=":)"/>',
		'<img src="../web-gallery/smileys/icon_silent.png" alt=":x" title=":x"/>',
		'<img src="../web-gallery/smileys/langue.gif" alt=":p" title=":p"/>',
		'<img src="../web-gallery/smileys/sad.gif" alt=":\'(" title=":\'("/>',
		'<img src="../web-gallery/smileys/veryhappy.gif" alt=":D" title=":D"/>',
		'<img src="../web-gallery/smileys/jap.png" alt=":jap:" title=":jap:"/>',
		'<img src="../web-gallery/smileys/cool.gif" alt="8)" title="8)"/>',
		'<img src="../web-gallery/smileys/rire.gif" alt=":rire:" title=":rire:"/>',
		'<img src="../web-gallery/smileys/icon_evil.gif" alt=":evil:" title=":evil:"/>',
		'<img src="../web-gallery/smileys/icon_twisted.gif" alt=":twisted:" title=":twisted:"/>',
		'<img src="../web-gallery/smileys/roll.gif" alt=":rool:" title=":rool:"/>',
		'<img src="../web-gallery/smileys/neutre.gif" alt=":|" title=":|"/>',
		'<img src="../web-gallery/smileys/suspect.gif" alt=":suspect:" title=":suspect:"/>',
		'<img src="../web-gallery/smileys/no.gif" alt=":no:" title=":no:"/>',
		'<img src="../web-gallery/smileys/coeur.gif" alt=":coeur:" title=":coeur:"/>',
		'<img src="../web-gallery/smileys/hap.gif" alt=":hap:" title=":hap:" />',
		'<img src="../web-gallery/smileys/bave.gif" alt=":bave:" title=":bave:" />',
		'<img src="../web-gallery/smileys/areuh.gif" alt=":areuh:" title=":areuh:" />',
		'<img src="../web-gallery/smileys/bandit.gif" alt=":bandit:" title=":bandit:" />',
		'<img src="../web-gallery/smileys/help.gif" alt=":help:" title=":help:" />',
		'<img src="../web-gallery/smileys/buzz.gif" alt=":buzz:" title=":buzz:" />',
		'<img src="../web-gallery/smileys/contrat.gif" alt=":contrat:" title=":contrat:" />',
		'<img src="../web-gallery/smileys/pour.gif" alt=":favo:" title=":favo:" />',
		'<img src="../web-gallery/smileys/contre.gif" alt=":contre:" title=":contre:" />',
	);
	return str_replace($in, $out, $texte);
}

function smileyforum($texte)
{
	$texte = stripslashes($texte);
	$in = array(
		";)",
		":$",
		":o",
		":)",
		":x",
		":p",
		":&#39;(",
		":D",
		":jap:",
		"8)",
		":rire:",
		":evil:",
		":twisted:",
		":rool:",
		":|",
		":suspect:",
		":no:",
		":coeur:",
		":hap:",
		":bave:",
		":areuh:",
		":bandit:",
		":help:",
		":buzz:",
		":contrat:",
		":favo:",
		":contre:",
	);
	$out = array(
		'<img src="../web-gallery/smileys/clindoeil.gif" alt=";)" title=";)"/>',
		'<img src="../web-gallery/smileys/embarrase.gif" alt=":$" title=":$"/>',
		'<img src="../web-gallery/smileys/etonne.gif" alt=":o" title=":o"/>',
		'<img src="../web-gallery/smileys/happy.gif" alt=":)" title=":)"/>',
		'<img src="../web-gallery/smileys/icon_silent.png" alt=":x" title=":x"/>',
		'<img src="../web-gallery/smileys/langue.gif" alt=":p" title=":p"/>',
		'<img src="../web-gallery/smileys/sad.gif" alt=":\'(" title=":\'("/>',
		'<img src="../web-gallery/smileys/veryhappy.gif" alt=":D" title=":D"/>',
		'<img src="../web-gallery/smileys/jap.png" alt=":jap:" title=":jap:"/>',
		'<img src="../web-gallery/smileys/cool.gif" alt="8)" title="8)"/>',
		'<img src="../web-gallery/smileys/rire.gif" alt=":rire:" title=":rire:"/>',
		'<img src="../web-gallery/smileys/icon_evil.gif" alt=":evil:" title=":evil:"/>',
		'<img src="../web-gallery/smileys/icon_twisted.gif" alt=":twisted:" title=":twisted:"/>',
		'<img src="../web-gallery/smileys/roll.gif" alt=":rool:" title=":rool:"/>',
		'<img src="../web-gallery/smileys/neutre.gif" alt=":|" title=":|"/>',
		'<img src="../web-gallery/smileys/suspect.gif" alt=":suspect:" title=":suspect:"/>',
		'<img src="../web-gallery/smileys/no.gif" alt=":no:" title=":no:"/>',
		'<img src="../web-gallery/smileys/coeur.gif" alt=":coeur:" title=":coeur:"/>',
		'<img src="../web-gallery/smileys/hap.gif" alt=":hap:" title=":hap:" />',
		'<img src="../web-gallery/smileys/bave.gif" alt=":bave:" title=":bave:" />',
		'<img src="../web-gallery/smileys/areuh.gif" alt=":areuh:" title=":areuh:" />',
		'<img src="../web-gallery/smileys/bandit.gif" alt=":bandit:" title=":bandit:" />',
		'<img src="../web-gallery/smileys/help.gif" alt=":help:" title=":help:" />',
		'<img src="../web-gallery/smileys/buzz.gif" alt=":buzz:" title=":buzz:" />',
		'<img src="../web-gallery/smileys/contrat.gif" alt=":contrat:" title=":contrat:" />',
		'<img src="../web-gallery/smileys/pour.gif" alt=":favo:" title=":favo:" />',
		'<img src="../web-gallery/smileys/contre.gif" alt=":contre:" title=":contre:" />',
	);
	return str_replace($in, $out, $texte);
}

function Redirect($url)
{
	echo "<SCRIPT LANGUAGE=\"JavaScript\"> document.location.href=\"" . $url . "\" </SCRIPT>";
}

function GabCMSHash($str)
{
	$str = Secu($str);
	$str = password_hash($str, PASSWORD_BCRYPT);
	return $str;
}

function Secu($str)
{
	$str = trim(htmlspecialchars(stripslashes(nl2br($str))));
	return $str;
}

function SecuriseText($str, $avancee = false, $codeforum = false)
{
	$str = stripslashes(nl2br(htmlspecialchars($str)));
	$str = ($avancee) ? stripslashes($str) : $str;
	$str = ($codeforum) ? bbcode_format($str) : $str;
	return $str;
}

function FullDate($str)
{
	$H = date('H');
	$i = date('i');
	$s = date('s');
	$m = date('m');
	$d = date('d');
	$Y = date('Y');
	$j = date('j');
	$n = date('n');

	switch ($str) {
		case "day":
			$str = $j;
			break;
		case "month":
			$str = $m;
			break;
		case "year":
			$str = $Y;
			break;
		case "today":
			$str = $d;
			break;
		case "full":
			$str = date('d/m/Y H:i:s', mktime($H, $i, $s, $m, $d, $Y));
			break;
		case "datehc":
			$str = "" . $d . "/" . $m . "/" . $Y . "";
			break;
		default:
			$str = date('d/m/Y', mktime($m, $d, $Y));
			break;
	}

	return $str;
}

function IsEven($int)
{
	if ($int % 2 == 0) {
		return true;
	} else {
		return false;
	}
}

function TicketRefresh($id)
{
	include('SQL.php');
	$base = "HABBO-" . uniqid() . uniqid() . uniqid();
	$sql = $bdd->prepare("UPDATE users SET auth_ticket = :base WHERE id = :id LIMIT 1");
	$sql->bindValue(':base', $base);
	$sql->bindValue(':id', $id);
	$sql->execute();
	return $base;
}

function GenerateRandom($type = "sso", $length = 0)
{
	switch ($type) {
		case "sso":
			$data = bin2hex(random_bytes(4)) . "-" . bin2hex(random_bytes(2)) . "-" . bin2hex(random_bytes(2)) . "-" . bin2hex(random_bytes(2)) . "-" . bin2hex(random_bytes(6));
			return $data;
			break;
		case "app_key":
			$data = strtoupper(bin2hex(random_bytes(16))) . ".resin-fe-" . bin2hex(random_bytes(1));
			return $data;
			break;
		case "random":
			$data = bin2hex(random_bytes($length));
			return $data;
			break;
		case "random_number":
			$data = rand(0, 9);
			return $data;
			break;
		default:
			return false;
			break;
	}
}

function UpdateSSO($id)
{
	if (isset($_SESSION['username'])) {
		include('SQL.php');
		$myticket = GenerateRandom();
		$sql = $bdd->prepare("UPDATE users SET auth_ticket = :myticket WHERE id = :id");
		$sql->bindValue(':myticket', $myticket, PDO::PARAM_STR);
		$sql->bindValue(':id', $id, PDO::PARAM_INT);
		$sql->execute();
		return $myticket;
	}
}

function Genere_code($size)
{
	$code = "";
	$characters = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
	for ($i = 0; $i < $size; $i++) {
		$code .= ($i % 2) ? strtoupper($characters[array_rand($characters)]) : $characters[array_rand($characters)];
	}
	return $code;
}

function Genere_chiffre($size)
{
	$characters = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);
	for ($i = 0; $i < $size; $i++) {
		$code .= ($i % 2) ? strtoupper($characters[array_rand($characters)]) : $characters[array_rand($characters)];
	}
	return $code;
}

function Genere_lettre($size)
{
	$characters = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
	for ($i = 0; $i < $size; $i++) {
		$code .= ($i % 2) ? strtoupper($characters[array_rand($characters)]) : strtoupper($characters[array_rand($characters)]);
	}
	return $code;
}

function ClientNitro()
{
	include('SQL.php');
	$sql = $bdd->query("SELECT nitro_client FROM gabcms_client WHERE id = '1'");
	$client = $sql->fetch(PDO::FETCH_ASSOC);
	return $client['nitro_client'];
}

function GetConfig()
{
	include('SQL.php');
	$sql = $bdd->query("SELECT * FROM gabcms_config WHERE id = '1'");
	$cof = $sql->fetch(PDO::FETCH_ASSOC);
	return $cof;
}

function Connected($pageid)
{
	include('SQL.php');
	$connected = "";
	$tmp = $bdd->query("SELECT count(id) FROM users WHERE online = '1'");
	$tma = $tmp->fetch(PDO::FETCH_ASSOC);
	if ($tma['count(id)'] < 1) {
		if ($pageid == "index") {
			$connected = "<span class=\"stats-fig\">" . $tma['count(id)'] . "</span> Connecté";
		} else {
			$connected = $tma['count(id)'] . " Connecté";
		}
	} else {
		if ($pageid == "index") {
			$connected = "<span class=\"stats-fig\">" . $tma['count(id)'] . "</span> Connectés";
		} else {
			$connected = $tma['count(id)'] . " Connectés";
		}
	}
	return $connected;
}

function SendMUSData(string $key, $data = null)
{
    include('SQL.php');

    $configSQL = $bdd->query("SELECT * FROM gabcms_client WHERE id = '1'");
    $config = $configSQL->fetch(PDO::FETCH_ASSOC);

    $mus_ip = $config['ip'];
    $mus_port = $config['mus_port'];

    if (!is_numeric($mus_port)) {
        echo "<b>System Error</b><br />Invalid MUS Port!";
        exit;
    }

    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    if ($socket === false) {
        echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
    }
	
    $result = socket_connect($socket, $mus_ip, $mus_port);
    if ($result === false) {
        echo "socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
    }

    $data = json_encode(['key' => $key, 'data' => $data]);

    $request = socket_write($socket, $data, strlen($data));

    if ($request === false) {
        return socket_strerror(socket_last_error($socket));
    }

    $response = socket_read($socket, 2048);

    return json_decode($response);
}


function GiveHC($user_id, $months)
{
	include('SQL.php');
	// Utiliser une instance PDO existante
	$stmt = $bdd->prepare("SELECT * FROM users_club WHERE userid = :userid LIMIT 1");
	$stmt->bindParam(':userid', $user_id, PDO::PARAM_INT);
	$stmt->execute();
	$valid = $stmt->rowCount();

	if ($valid > 0) {
		// Préparer et exécuter les requêtes
		$sql1 = "UPDATE users SET rank = '2' WHERE rank = '1' AND id = :id LIMIT 1";
		$stmt1 = $bdd->prepare($sql1);
		$stmt1->bindParam(':id', $user_id, PDO::PARAM_INT);
		$stmt1->execute();

		$sql2 = "UPDATE users_club SET months_left = months_left + :months WHERE userid = :id LIMIT 1";
		$stmt2 = $bdd->prepare($sql2);
		$stmt2->bindParam(':months', $months, PDO::PARAM_INT);
		$stmt2->bindParam(':id', $user_id, PDO::PARAM_INT);
		$stmt2->execute();

		$sql3 = "SELECT * FROM users_badges WHERE badge_code = 'HC1' AND user_id = :id LIMIT 1";
		$stmt3 = $bdd->prepare($sql3);
		$stmt3->bindParam(':id', $user_id, PDO::PARAM_INT);
		$stmt3->execute();
		$found = $stmt3->rowCount();

		if ($found !== 1) { // No badge. Poor thing.
			// Préparer et exécuter les requêtes
			/*$sql4 = "UPDATE users SET badge_status = '0' WHERE id = :id LIMIT 1";
				$stmt4 = $pdo->prepare($sql4);
				$stmt4->bindParam(':id', $user_id, PDO::PARAM_INT);
				$stmt4->execute();*/

			/*$sql5 = "UPDATE users_badges SET iscurrent = '0' WHERE userid = :id";
				$stmt5 = $pdo->prepare($sql5);
				$stmt5->bindParam(':id', $user_id, PDO::PARAM_INT);
				$stmt5->execute();*/

			$sql6 = "INSERT INTO users_badges (user_id, badge_code) VALUES (:id, 'HC1')";
			$stmt6 = $bdd->prepare($sql6);
			$stmt6->bindParam(':id', $user_id, PDO::PARAM_INT);
			$stmt6->execute();
		}
	} else {
		$m = date('m');
		$d = date('d');
		$Y = date('Y');
		$date = date('d-m-Y', mktime($m, $d, $Y));
		$sql = "INSERT INTO users_club (userid, date_monthstarted, months_expired, months_left) VALUES (:userid, :date_monthstarted, 0, 0)";
		$stmt = $bdd->prepare($sql);
		$stmt->bindParam(':userid', $user_id, PDO::PARAM_INT);
		$stmt->bindParam(':date_monthstarted', $date, PDO::PARAM_STR);
		$stmt->execute();
		GiveHC($user_id, $months);
	}

	/*if (function_exists(SendMUSData) !== true) {
		include('includes/mus.php');
	}
	@SendMUSData('UPRS' . $user_id);
		@SendMUSData('UPRC' . $user_id);*/
}

function HCDaysLeft($my_id)
{
	include('SQL.php');
	// Query for the info we need to calculate
	$query = $bdd->prepare("SELECT months_left,date_monthstarted FROM users_club WHERE userid = :my_id LIMIT 1");
	$query->bindParam(':my_id', $my_id);
	$query->execute();
	$tmp = $query->fetch(PDO::FETCH_ASSOC);
	$valid = $query->rowCount();

	if ($valid > 0) {

		// Récupérer les variables nécessaires à partir du résultat de la requête
		$months_left = $tmp['months_left'];
		$month_started = $tmp['date_monthstarted'];

		// Nous prenons 31 jours pour chaque mois restant, en supposant que chaque mois a 31 jours
		$days_left = $months_left * 31;

		// Séparer le jour, le mois et l'année afin de pouvoir les utiliser avec mktime
		$tmp = explode("-", $month_started);
		$day = $tmp[0];
		$month = $tmp[1];
		$year = $tmp[2];

		// Tout d'abord, créer les dates que nous voulons comparer, effectuer des calculs
		$then = mktime(0, 0, 0, $month, $day, $year);
		$now = time();
		$difference = $now - $then;

		// Si le mois est déjà expiré
		if ($difference < 0) {
			$difference = 0;
		}

		// Effectuer des calculs
		$days_expired = floor($difference / 60 / 60 / 24);

		// $days_expired représente les jours que nous avons déjà gaspillés ce mois-ci
		// 31 jours pour chaque mois ajouté ensemble, moins les jours que nous avons gaspillés dans le mois en cours, est le nombre de jours qu'il nous reste, complètement
		$days_left = $days_left - $days_expired;

		return $days_left;
	} else {
		return 0;
	}
}


function IsHCMember($my_id)
{
	include('SQL.php');
	if (HCDaysLeft($my_id) > 0) {
		return true;
	} else {
		// Make sure that HC members are _not_ rank 2 and that they do not have their gay little badge
		$query = $bdd->prepare("SELECT * FROM users_club WHERE userid = ? LIMIT 1");
		$query->execute(array($my_id));
		$clubrecord = $query->rowCount();

		if ($clubrecord > 0) {
			/*$stmt1 = $bdd->prepare("UPDATE users SET badge_status = '0', hc_before='1' WHERE id = ? LIMIT 1");
			$stmt1->execute([$my_id]);*/

			$stmt1 = $bdd->prepare("UPDATE users_settings SET last_hc_payday = '0' WHERE user_id = ? LIMIT 1");
			$stmt1->execute([$my_id]);

			$stmt2 = $bdd->prepare("UPDATE users SET rank = '1' WHERE id = ? AND rank = '2' LIMIT 1");
			$stmt2->execute([$my_id]);

			$stmt3 = $bdd->prepare("DELETE FROM users_badges WHERE badge_code = 'HC1' OR badge_code = 'HC2' AND user_id = ? LIMIT 1");
			$stmt3->execute([$my_id]);

			$stmt4 = $bdd->prepare("DELETE FROM users_club WHERE userid = ? LIMIT 1");
			$stmt4->execute([$my_id]);

			/*if(function_exists(SendMUSData) !== true){ include('includes/mus.php'); }
            @SendMUSData('UPRS' . $my_id);*/
		}
		return false;
	}
}
