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
		
	if($user['rank'] < 5) {
	Redirect("".$url."/managements/acces_neg");
	exit();
	}
	if($user['rank'] > 8) {              
	Redirect("".$url."/managements/acces_neg");
	exit();
	}	
	
if(isset($_GET['do'])) {
 $do = Secu($_GET['do']);
 if($do == "tchat") {
        $insertn2 = $bdd->prepare("INSERT INTO gabcms_tchat (pseudo, message, ip, date, look, rank, alert) VALUES (:user, :msg, :ip, :date, :look, :rank, :alert)");
            $insertn2->bindValue(':user', $user['username']);
            $insertn2->bindValue(':msg', Secu($_POST['message']));
            $insertn2->bindValue(':ip', $user['ip_current']);
            $insertn2->bindValue(':date', FullDate('full'));
            $insertn2->bindValue(':look', $user['look']);
            $insertn2->bindValue(':rank', $user['rank']);
            $insertn2->bindValue(':alert', '1');
        $insertn2->execute();
        $insertn1 = $bdd->prepare("INSERT INTO gabcms_stafflog (pseudo,action,date) VALUES (:pseudo, :action, :date)");
            $insertn1->bindValue(':pseudo', $user['username']);
            $insertn1->bindValue(':action', 'a ajouté une alerte sur le tchat');
            $insertn1->bindValue(':date', FullDate('full'));
        $insertn1->execute(); 
 echo '<h4 class="alert_success">Une alerte a été ajouté sur le tchat</h4>';
 }
}
?>
<link rel="stylesheet" href="css/contenu.css<?php echo '?'.mt_rand(); ?>" type="text/css" media="screen" /><body>
 <script language="javascript" type="text/javascript">
   function insert_texte(texte)
   {
       var ou = document.getElementsByName("message")[0];
       var phrase = texte +" ";
       ou.value += phrase;
       ou.focus();
   }
</script>
<span id="titre">Ajoutes une alerte sur le tchat</span><br />
Ajoutes une alerte sur le chat, elle sera visible en rouge !<br/><br/>
<td width='100' class='tbl'><b>Message :</b><br/></td>
<a href="#" onclick="insert_texte(';)')"><img src="<?PHP echo $imagepath; ?>smileys/clindoeil.gif"/></a>
<a href="#" onclick="insert_texte(':$')"><img src="<?PHP echo $imagepath; ?>smileys/embarrase.gif"/></a>
<a href="#" onclick="insert_texte(':o')"><img src="<?PHP echo $imagepath; ?>smileys/etonne.gif"/></a>
<a href="#" onclick="insert_texte(':)')"><img src="<?PHP echo $imagepath; ?>smileys/happy.gif"/></a>
<a href="#" onclick="insert_texte(':x')"><img src="<?PHP echo $imagepath; ?>smileys/icon_silent.png"/></a>
<a href="#" onclick="insert_texte(':p')"><img src="<?PHP echo $imagepath; ?>smileys/langue.gif"/></a>
<a href="#" onclick="insert_texte(':\'(')"><img src="<?PHP echo $imagepath; ?>smileys/sad.gif"/></a>
<a href="#" onclick="insert_texte(':D')"><img src="<?PHP echo $imagepath; ?>smileys/veryhappy.gif"/></a>
<a href="#" onclick="insert_texte(':jap:')"><img src="<?PHP echo $imagepath; ?>smileys/jap.png"/></a>
<a href="#" onclick="insert_texte('8)')"><img src="<?PHP echo $imagepath; ?>smileys/cool.gif"/></a>
<a href="#" onclick="insert_texte(':rire:')"><img src="<?PHP echo $imagepath; ?>smileys/rire.gif"/></a>
<a href="#" onclick="insert_texte(':evil:')"><img src="<?PHP echo $imagepath; ?>smileys/icon_evil.gif"/></a>
<a href="#" onclick="insert_texte(':twisted:')"><img src="<?PHP echo $imagepath; ?>smileys/icon_twisted.gif"/></a>
<a href="#" onclick="insert_texte(':rool:')"><img src="<?PHP echo $imagepath; ?>smileys/roll.gif"/></a>
<a href="#" onclick="insert_texte(':|')"><img src="<?PHP echo $imagepath; ?>smileys/neutre.gif"/></a>
<a href="#" onclick="insert_texte(':suspect:')"><img src="<?PHP echo $imagepath; ?>smileys/suspect.gif"/></a>
<a href="#" onclick="insert_texte(':no:')"><img src="<?PHP echo $imagepath; ?>smileys/no.gif"/></a>
<a href="#" onclick="insert_texte(':coeur:')"><img src="<?PHP echo $imagepath; ?>smileys/coeur.gif"/></a>
<a href="#" onclick="insert_texte(':hap:')"><img src="<?PHP echo $imagepath; ?>smileys/hap.gif"/></a>
<a href="#" onclick="insert_texte(':bave:')"><img src="<?PHP echo $imagepath; ?>smileys/bave.gif"/></a>
<a href="#" onclick="insert_texte(':areuh:')"><img src="<?PHP echo $imagepath; ?>smileys/areuh.gif"/></a>
<a href="#" onclick="insert_texte(':bandit:')"><img src="<?PHP echo $imagepath; ?>smileys/bandit.gif"/></a>
<a href="#" onclick="insert_texte(':help:')"><img src="<?PHP echo $imagepath; ?>smileys/help.gif"/></a>
<a href="#" onclick="insert_texte(':buzz:')"><img src="<?PHP echo $imagepath; ?>smileys/buzz.gif"/></a>
<form name='editor' method='post' action="?do=tchat">
<td width='80%' class='tbl'><input type='text' name='message' class='text' style='width: 240px'><br/></td>
<br/>
<tr>
<td align='center' colspan='2' class='tbl'>
<input type='submit' name='submit' value='Exécuter' class='submit'></form>
</tr>
</body>
</html>

</tr>