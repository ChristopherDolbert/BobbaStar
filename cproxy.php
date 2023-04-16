
<?php 
include('./config.php');


$key = Secu($_GET['habbletKey']);

if($_GET['redirect']!= ''){

header("LOCATION: http://". $_GET['redirect'] ."");
}
if($_REQUEST['habbletKey'] == "externalLink")
{

?>
<?php
$target = explode('/', $_POST['url']);
$mytarg = array_reverse(explode('/', $_POST['url']));
?>

<?php
}
if($_REQUEST['habbletKey'] == "news")
{
?>
<div class="habblet-container ">		
	<div id="news-habblet-container">
  <div class="title">
    <div class="habblet-close"></div>
    <div>L&#39;info plus vite que la lumi&egrave;re</div>
  </div>
  <div class="content-container">
    <div id="news-articles">
      <ul id="news-articlelist" class="articlelist" style="display: none">
    <?php
	$getnews = $bdd->query("SELECT * FROM gabcms_news WHERE event = '1' ORDER BY id DESC LIMIT 10");
	$i = 0;
	while($news = $getnews->fetch())
	{
		if(($i%2) == 0)
		{
		?>
        <li class="even">
          <div class="news-title"><?php echo $news['title'];?></div>
          <div class="newsitem-date"><?php echo $news['date'];?></div>
          <div id="article-body-text-<?php echo $news['id'];?>" class="article-body-text" style="display: none">
	                <div class="news-summary"><?php echo $news['body'];?></div>
          </div>
		            <b><?php echo $news['auteur'];?></b><br/>
 <br/>
          <div class="clearfix">
            <a href="#" class="article-toggle" id="article-title-<?php echo $news['id'];?>">En savoir plus</a>
          </div>
        </li>
        <?php
		}
		else
		{
		?>
        <li class="odd">
          <div class="news-title"><?php echo $news['title'];?></div>
          <div class="newsitem-date"><?php echo $news['date'];?></div>
          <div id="article-body-text-<?php echo $news['id'];?>" class="article-body-text" style="display: none">
	                <div class="news-summary"><?php echo $news['body'];?></div>
          </div>
		            <b><?php echo $news['auteur'];?></b><br/>
 <br/>
          <div class="clearfix">
            <a href="#" class="article-toggle" id="article-title-<?php echo $news['id'];?>">En savoir plus</a>
          </div>
		  
        </li>
        <?php
		}
		$i++;
	}
	?>
      </ul>
    </div>
  </div>
  <div class="news-footer"></div>
</div>
<script type="text/javascript">    
    L10N.put("news.promo.readmore", "En savoir plus").put("news.promo.close", "Retour");
    News.init(true);
</script>	
	
</div>

<!-- FIN NEWS DESACTIVER -->


<!-- dependencies
<link rel="stylesheet" href="<?php echo $imagepath;?>static/styles/news.css?ncaches" type="text/css" />
<script src="<?php echo $imagepath;?>static/js/news.js?ncaches" type="text/javascript"></script>
-->   


<?php }?>



<?php
$key = Secu($_GET['habbletKey']);

if($_GET['redirect']!= ''){

header("LOCATION: http://". $_GET['redirect'] ."");

}
if($_REQUEST['habbletKey'] == "externalLink")
{

?>
<?php
$target = explode('/', $_POST['url']);
$mytarg = array_reverse(explode('/', $_POST['url']));
?>
<div class="habblet-container ">  
 <div id="external-link-container">
 </br>
<h2><img src="http://images.habbo.com/habboweb/<?php echo $WebBuild;?>/web-gallery/v2/images/registration/warning_sign.png"/> Annonce de s&eacute;curit&eacute;e</h2>
<p>Vous quittez <?php echo $sitename;?>. Pour la s&eacute;curit&eacute; et la confidentialit&eacute; de vos comptes, n&#39;oubliez pas d&#39;entrer votre mot de passe JAMAIS sur un site autre que l&#39;original <?php echo $sitename;?>. Assurez-vous &eacute;galement de t&eacute;l&eacute;charger des programmes &agrave; partir de sites Web fiables.</p>
    <p><strong><?php echo $_POST["url"];?></strong></p>

<p class="clearfix" style="padding: 0">
    <a href="#" class="new-button" onclick="ExternalClickHandler.clickCancel('<?php echo $path;?>/cproxy.php?redirect=<?php echo $_POST["url"];?>', '1'); return false;"><b>Annuler</b><i></i></a>
        <a href="#" class="new-button red-button" onclick="ExternalClickHandler.clickContinue('<?php echo $path;?>/cproxy?redirect=<?php echo $_POST["url"];?>', '1'); return false;"><b>Continuer sur <?php echo $target[0];?></b><i></i></a>
</p>
</div>
 
 
</div>
<!-- dependencies

-->   


  <?php
}
?>


<?php
$key = Secu($_GET['habbletKey']);

if($_GET['redirect']!= ''){

header("LOCATION: http://". $_GET['redirect'] ."");

}
if($_REQUEST['habbletKey'] == "avatars")
{

?>
<?php
$target = explode('/', $_POST['url']);
$mytarg = array_reverse(explode('/', $_POST['url']));
?>
<?php
    $pageid = 'add_avatar';
    $email = $user['mail'];
$users = $bdd->query("SELECT * FROM users WHERE mail = '$email' LIMIT 1");
 $avatar = $_GET['avatar'];
if($avatar == "created") {
$avatar_selected = '<div id="name-suggestions">
                        <div class="available">
                            <p>Votre avatar a été cree avec succès.</p>
                        </div>
                    </div>
';
}
?>

<link rel="stylesheet" href="https://images-eussl.habbo.com/habboweb/<?php echo $WebBuild;?>/web-gallery/static/styles/embed.css" type="text/css" /><script src="https://images-eussl.habbo.com/habboweb/<?php echo $WebBuild;?>/web-gallery/static/js/embed.js" type="text/javascript"></script>
<link rel="stylesheet" href="/styles/local/fr.css" type="text/css" />


<link rel="stylesheet" href="https://images-eussl.habbo.com/habboweb/<?php echo $WebBuild;?>/web-gallery/static/styles/common.css" type="text/css" /><link rel="stylesheet" href="https://images-eussl.habbo.com/habboweb/<?php echo $WebBuild;?>/web-gallery/static/styles/avatarselection.css" type="text/css" />

<div id="container">

    <div id="select-avatar">

	<div class="pick-avatar-container clearfix">

        <div class="title">
    <div class="habblet-close"></div>

            <h1>Choisis ton perso</h1>

        </div>

		<div id="content">

            <div id="user-info">
<?php
if(!empty($user['facebook_id'])) {
$vars = "https://graph.facebook.com/".$user['facebook_id']."/picture";
}elseif(empty($user['facebook_id'])) {
$vars = "https://fbcdn-profile-a.akamaihd.net/static-ak/rsrc.php/v2/yo/r/UlIqmHJn-SK.gif";
}
?>
<img src="<?php echo $vars;?>">


              <div>

                  <div id="name" style="font-size: 11px;">
                    <?php 
			echo substr($user['mail'],0,18)."...";
			
                    ?>
                     </div>

                  <a href="<?php echo $url;?>/moi" target="_blank" id="logout">Retour &agrave; l&#39;h&ocirc;tel</a>

                  <a href="<?php echo $url;?>/profile" target="_blank" id="manage-account">Pr&eacute;f&eacute;rences</a>

              </div>



            </div>

            <div id="first-avatar">
			<?PHP if(isset($avatar_selected)) { echo $avatar_selected; }?>
                    <img src="/avatarimage?figure=<?php echo $user['look'];?>&size=b&direction=2&head_direction=2&gesture=psk" />

                    <div id="first-avatar-info">

                        <div class="first-avatar-name"><?php echo $user['username'];?></div>

                        <div class="first-avatar-lastonline">Derni&egrave;re connexion : <?PHP $connexion = date('d/m/Y H:i:s', $user['last_online']);?><span title="<?php echo $connexion;?>"><?php echo $connexion;?></span></div>

                        <a id="first-avatar-play-link" target="_blank" href="<?php echo $url;?>/check_avatar?name=<?php echo $user['username'];?>">

                            <div class="play-button-container">

                                <div class="play-button"><div class="play-text">Jouer</div></div>

                                <div class="play-button-end"></div>

                            </div>

                        </a>

                    </div>

            </div>

<br /><br />

            <div id="link-new-avatar"><a class="new-button" target="_blank" href="/add_avatar"><b>+ Ajouter</b><i></i></a></div>


<p style="margin: 5px 10px">Tu peux ajouter 15 avatars</p>
            <div class="other-avatars">

                  <ul>

                      <?php
			$userq = $bdd->query("SELECT * FROM users WHERE mail = '$email' ORDER BY last_offline DESC LIMIT 15");
			while($user = $userq->fetch())
			{

				$i++;
	if(IsEven($i)) {
	$oddeven = "odd";
	} else {
	$oddeven = "even";
	}

			echo '
			  <li class="'.$oddeven.'">

                      <img src="/avatarimage?figure='.$user['look'].'&size=s"  alt="'.$user['username'].'" width="33" height="56"/>

                      <div class="avatar-info">

                       
                        <div class="avatar-info-container">

  <div class="avatar-select" style="margin-top:-30px;"><a href="'.$url.'/check_avatar?name='.$user["username"].'"><b>Jouer</b><i></i></a></div>


                          <div class="avatar-name">'.$user['username'].'</div>


	            	      <div class="avatar-lastonline">Derni&egrave;re connexion: <span title="'.$user['last_offline'].'">'.$user['last_offline'].'</span></div>

                        </div>

                      

                      </div>

                    </li>';
			
				
			} 
			?>

		    <a href="#" class="new-button" onclick="Cacher('avatars'); return false;"><b>Quitter</b><i></i></a>	

            </div>

        </div>

    </div>




   <div class="pick-avatar-container-bottom"></div>

  </div>

<!-- dependencies

-->   


  <?php
}
?>
<head>
<body>
