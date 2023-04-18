<?php
ob_start();
session_start();
include('config.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(!trim($_POST['email'])){
		echo'Typ een email in!<br>';
	}else
	if(!trim($_POST['pass'])){
		echo'Typ wachtwoord in!<br>';
	}else{
		$tel = mysql_query("SELECT * FROM users WHERE email = '".mysql_real_escape_string($_POST['email'])."' AND wachtwoord = '".md5(mysql_real_escape_string($_POST['pass']))."' ");
		if(mysql_num_rows($tel) == 1){
		$fetch = mysql_fetch_assoc($tel);
			$_SESSION['id'] = $fetch['id'];
			header("Location: index.php");
		}else{
			echo"<script>alert('Onjuiste gegevens');</script>";
		}
	}
}
?>
<form method="POST">
	<table>
		<tr>
			<td>Email:</td>
			<td><input type="text" name="email"></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input type="password" name="pass"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="sub" value="Verzend!"></td>
		</tr>
	</table>
</form>