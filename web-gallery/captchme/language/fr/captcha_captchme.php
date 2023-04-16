<?php
/**
*
* captchme [French]
*
* @package language
* @version $Id$
* @copyright (c) 2009 phpBB Group, (c) 2009 phpBB.fr
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

$lang = array_merge($lang, array(
	'CAPTCHME_LANG'				=> 'fr',
	'CAPTCHME_NOT_AVAILABLE'		=> 'Avant de pouvoir utiliser Captch Me, vous devez créer un compte sur <a href="http://www.captchme.com">www.captchme.com/</a>.',
	'CAPTCHA_CAPTCHME'				=> 'Captch Me',
	'CAPTCHME_INCORRECT'			=> 'Le code de confirmation visuelle que vous avez saisi est incorrect',

	'CAPTCHME_PUBLIC'				=> 'Clé publique de Captch Me ',
	'CAPTCHME_PUBLIC_EXPLAIN'		=> 'Votre clé publique de Captch Me. Les clés peuvent être obtenues sur <a href="http://www.captchme.com">www.captchme.com/</a>.',
	'CAPTCHME_PRIVATE'				=> 'Clé privée de Captch Me ',
	'CAPTCHME_PRIVATE_EXPLAIN'		=> 'Votre clé privée de Captch Me. Les clés peuvent être obtenues sur <a href="http://www.captchme.com">www.captchme.com/</a>.',
    'CAPTCHME_AUTHKEY'              => 'Clé d\'authentification de Captch Me ',
    'CAPTCHME_AUTHKEY_EXPLAIN'      => 'Votre clé d\'authentification de Captch Me. Les clés peuvent être obtenues sur <a href="http://www.captchme.com">www.captchme.com/</a>.',
    'CAPTCHME_LANG'                   => 'Langue d\'affichage du module Captch Me ',
    'CAPTCHME_LANG_EXPLAIN'         => 'Vous pouvez spécifier explicitement la langue d\'affichage du module Captch Me.',
    'CAPTCHME_FORMAT'              => 'Format d\'affichage du module Captch Me ',
    'CAPTCHME_FORMAT_EXPLAIN'         => 'Vous pouvez spécifier explicitement le format d\'affichage du module Captch Me.',
    'CAPTCHME_THEME'              => 'Thème d\'affichage du module Captch Me',
    'CAPTCHME_THEME_EXPLAIN'         => 'Vous pouvez spécifier explicitement le thème d\'affichage du module Captch Me.',
    'CAPTCHME_TITRE'              => 'Affichage du titre du module Captch Me ',
    'CAPTCHME_TITRE_EXPLAIN'         => 'Vous pouvez choisir d\'afficher ou non le titre du module Captch Me.',
    'CAPTCHME_INSTRUCTION'              => 'Affichage des instructions Captch Me ',
    'CAPTCHME_INSTRUCTION_EXPLAIN'         => 'Vous pouvez choisir d\'afficher ou non les instruction du module Captch Me.',
    'CAPTCHME_CLASSIC'              =>  'Classic',
    'CAPTCHME_WIDE'              =>  'Wide',
    'CAPTCHME_GRAY'              =>  'Gris',
    'CAPTCHME_WHITE'              =>  'Blanc',
    'CAPTCHME_SHOW'              =>  'Afficher',
    'CAPTCHME_HIDE'              =>  'Masquer',
    'CAPTCHME_FRENCH'              =>  'Français',
    'CAPTCHME_ENGLISH'              =>  'Anglais',
    'CAPTCHME_SPANISH'              =>  'Espagnol',
    'CAPTCHME_WEBUSER'              =>  'Internaute',
	'CAPTCHME_EXPLAIN'				=> 'Dans un effort de prévention luttant contre les actions automatisées, nous vous demandons de bien vouloir répondre à la question affichée dans le champ de texte ci-dessous.',
));

?>
