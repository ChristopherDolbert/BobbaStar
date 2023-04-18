<?PHP
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|

#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
	$nowtime = time();

@session_start();
            ini_set('display_errors', 1);
	@include("./includes/SQL.php");
	@include("../includes/SQL.php");
	@include("./includes/CMS.php");
	@include("../includes/CMS.php");
	@include("./includes/Function.php");
	@include("../includes/Function.php");

error_reporting(E_ALL); ini_set('display_errors', '1');

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