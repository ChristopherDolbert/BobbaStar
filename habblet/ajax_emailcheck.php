<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

include("../config.php");

$email = Secu($_POST['email']);
$email_check = preg_match("/^[a-z0-9_\.-]+@([a-z0-9]+([\-]+[a-z0-9]+)*\.)+[a-z]{2,7}$/i", $email);

$sql = $bdd->prepare("SELECT id FROM users WHERE mail = ? LIMIT 1");
$sql->execute([$email]);
$tmp = $sql->rowCount();

if ($tmp >= 1) {
	echo "register.message.invalid_email";
} elseif(strlen($email) < 6){
	echo "register.message.invalid_email";
} elseif($email_check !== 1){
	echo "register.message.invalid_email";
} else {
	header("X-JSON: \"emailOk\"");
	echo "register.message.email_chars_ok";
}

