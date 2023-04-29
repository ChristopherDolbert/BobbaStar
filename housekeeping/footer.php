<?php
/*===================================================+
|| # HoloCMS - Website and Content Management System
|+===================================================+
|| # Copyright � 2008 Meth0d. All rights reserved.
|| # http://www.meth0d.org
|+===================================================+
|| # HoloCMS is provided "as is" and comes without
|| # warrenty of any kind. HoloCMS is free software!
|+===================================================*/

if ($hkzone !== true) {
    header("Location: index.php?throwBack=true");
    exit;
}

?>
<div class='copy'>
    <p style="text-align:center"><a href="<?PHP echo $url; ?>" target="_self">Accueil</a> | <a href="<?PHP echo $url; ?>/disclaimer" target="_self">Conditions Générales d'Utilisations</a> | <a href="<?PHP echo $url; ?>/infos" target="_self">Infos CMS</a>
    <p class="copyright" style="text-align:center">
        <?PHP echo $sitename; ?> est un projet indépendant, &agrave; but non lucratif &copy; 2012-2014.<br />
        Habbo est une marque déposée de Sulake Corporation. Tous droits réservés &agrave; leur(s) propriétaire(s) respectif(s).<br />Nous ne sommes pas approuvés, affiliés ou offertes par Sulake Corporation LTD.<br><br><u>&copy; <?PHP echo $version ?></u><br><br>
    </p>
</div>
</body>

</html>