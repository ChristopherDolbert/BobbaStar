<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

# Nombre de fonctions: 14 #

function smileys($texte)
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
	);
	$out = array(
		'<img src="./web-gallery/smileys/clindoeil.gif" alt=";)" title=";)"/>',
		'<img src="./web-gallery/smileys/embarrase.gif" alt=":$" title=":$"/>',
		'<img src="./web-gallery/smileys/etonne.gif" alt=":o" title=":o"/>',
		'<img src="./web-gallery/smileys/happy.gif" alt=":)" title=":)"/>',
		'<img src="./web-gallery/smileys/icon_silent.png" alt=":x" title=":x"/>',
		'<img src="./web-gallery/smileys/langue.gif" alt=":p" title=":p"/>',
		'<img src="./web-gallery/smileys/sad.gif" alt=":\'(" title=":\'("/>',
		'<img src="./web-gallery/smileys/veryhappy.gif" alt=":D" title=":D"/>',
		'<img src="./web-gallery/smileys/jap.png" alt=":jap:" title=":jap:"/>',
		'<img src="./web-gallery/smileys/cool.gif" alt="8)" title="8)"/>',
		'<img src="./web-gallery/smileys/rire.gif" alt=":rire:" title=":rire:"/>',
		'<img src="./web-gallery/smileys/icon_evil.gif" alt=":evil:" title=":evil:"/>',
		'<img src="./web-gallery/smileys/icon_twisted.gif" alt=":twisted:" title=":twisted:"/>',
		'<img src="./web-gallery/smileys/roll.gif" alt=":rool:" title=":rool:"/>',
		'<img src="./web-gallery/smileys/neutre.gif" alt=":|" title=":|"/>',
		'<img src="./web-gallery/smileys/suspect.gif" alt=":suspect:" title=":suspect:"/>',
		'<img src="./web-gallery/smileys/no.gif" alt=":no:" title=":no:"/>',
		'<img src="./web-gallery/smileys/coeur.gif" alt=":coeur:" title=":coeur:"/>',
		'<img src="./web-gallery/smileys/hap.gif" alt=":hap:" title=":hap:" />',
		'<img src="./web-gallery/smileys/bave.gif" alt=":bave:" title=":bave:" />',
		'<img src="./web-gallery/smileys/areuh.gif" alt=":areuh:" title=":areuh:" />',
		'<img src="./web-gallery/smileys/bandit.gif" alt=":bandit:" title=":bandit:" />',
		'<img src="./web-gallery/smileys/help.gif" alt=":help:" title=":help:" />',
		'<img src="./web-gallery/smileys/buzz.gif" alt=":buzz:" title=":buzz:" />',
	);
	return str_replace($in, $out, $texte);
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
	$str = Secu(password_hash($str, PASSWORD_BCRYPT));
	return $str;
}

function Secu($str)
{
	$str = htmlspecialchars(stripslashes(nl2br(trim($str))));
	return $str;
}

function SecuriseText($str, $avancee = false, $codeforum = false)
{
	if ($avancee == true) {
		return stripslashes($str);
	}
	$str = stripslashes(nl2br(htmlspecialchars($str)));
	if ($codeforum == true) {
		$str = bbcode_format($str);
	}
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
	$base = "HABBO-";

	for ($i = 1; $i <= 3; $i++) : {
			$base = $base . rand(0, 99);
			$base = uniqid($base);
		}
	endfor;
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
			$data = GenerateRandom("random", 8) . "-" . GenerateRandom("random", 8) . "-" . GenerateRandom("random", 8) . "-" . GenerateRandom("random", 8) . "-" . GenerateRandom("random", 12);
			return $data;
			break;
		case "app_key":
			$data = strtoupper(GenerateRandom("random", 32)) . ".resin-fe-" . GenerateRandom("random_number", 1);
			return $data;
			break;
		case "random":
			$data = "";
			$possible = "0123456789abcdef";
			$i = 0;
			while ($i < $length) {
				$char = substr($possible, mt_rand(0, strlen($possible) - 1), 1);
				$data .= $char;
				$i++;
			}
			return $data;
			break;
		case "random_number":
			$data = "";
			$possible = "0123456789";
			$i = 0;
			while ($i < $length) {
				$char = substr($possible, mt_rand(0, strlen($possible) - 1), 1);
				$data .= $char;
				$i++;
			}
			return $data;
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
