<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|           GabCMS - Site Web et Content Management System               #|
#|         Copyright © 2012-2015 - Gabodd Tout droits réservés.           #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
	$nowtime = time();

@session_start();
	@include("./includes/SQL.php");
	@include("../includes/SQL.php");
	@include("./includes/CMS.php");
	@include("../includes/CMS.php");
	@include("./includes/Function.php");
	@include("../includes/Function.php");

if (function_exists('date_default_timezone_set')){
	@date_default_timezone_set('Europe/Paris');
}

	if(isset($_SESSION['username']))
		{
			$username = Secu($_SESSION['username']);
			$sql = $bdd->query("SELECT * FROM users WHERE username = '".$username."' LIMIT 1");
			$row = $sql->rowCount();

			if($row > 0)
				{
					$user = $sql->fetch(PDO::FETCH_ASSOC);
					$bdd->query("UPDATE users SET ip_last = '".$_SERVER["REMOTE_ADDR"]."' WHERE id = '".$user['id']."'");
				}
				else {
				session_destroy();
				Redirect("".$url."");
				exit();
				}
		}
$maintid = "1";
        $sqlss = $bdd->query("SELECT * FROM gabcms_maintenance WHERE id = '1'");
        $c = $sqlss->fetch(PDO::FETCH_ASSOC);
        if($c['activ'] == "Oui") {
            if($user['rank'] < "5"){
                Redirect("".$url."/maintenance");
            }
        }
$query = $bdd->query("SELECT * FROM bans WHERE value = '".$_SERVER['REMOTE_ADDR']."' ");
$data = $query->fetch(PDO::FETCH_ASSOC);
$ban = array($data['value']);
$ip = $_SERVER['REMOTE_ADDR'];
if (in_array($ip, $ban)) {
Redirect("".$url."/banip");
}
if(isset($_SESSION['username']))
		{
$sql = $bdd->query("SELECT * FROM bans WHERE value = '".$username."'");
$b = $sql->fetch(PDO::FETCH_ASSOC);
$stamp_now = $nowtime;
$stamp_expire = $b['expire'];
$expire = date('d/m/Y H:i', $b['expire']);
if($stamp_now < $stamp_expire){
Redirect("".$url."/banned");
}
}


#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|          Sécurité            #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

$injection = 'INSERT|UNION|SELECT|NULL|COUNT|FROM|LIKE|DROP|TABLE|WHERE|COUNT|COLUMN|TABLES|INFORMATION_SCHEMA|OR' ;
    foreach($_GET as $getSearchs){
        $getSearch = explode(" ",$getSearchs);
foreach($getSearch as $k=>$v){
    if(in_array(strtoupper(trim($v)),explode('|',$injection))){
    exit;
        }
    }
}
?>