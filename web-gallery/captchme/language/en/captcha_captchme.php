<?php
/**
*
* captchme [English]
*
* @package language
* @version $Id$
* @copyright (c) 2009 phpBB Group
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
	'CAPTCHME_LANG'				=> 'en',
	'CAPTCHME_NOT_AVAILABLE'		=> 'In order to use Captch Me, you must create an account on <a href="http://www.google.com/captchme">www.google.com/captchme</a>.',
	'CAPTCHA_CAPTCHME'				=> 'Captch Me',
	'CAPTCHME_INCORRECT'			=> 'The visual confirmation code you submitted was incorrect',

	'CAPTCHME_PUBLIC'				=> 'Public Captch Me key',
	'CAPTCHME_PUBLIC_EXPLAIN'		=> 'Your public Captch Me key. Keys can be obtained on <a href="http://www.google.com/captchme">www.google.com/captchme</a>.',
	'CAPTCHME_PRIVATE'				=> 'Private Captch Me key',
	'CAPTCHME_PRIVATE_EXPLAIN'		=> 'Your private Captch Me key. Keys can be obtained on <a href="http://www.google.com/captchme">www.google.com/captchme</a>.',
    'CAPTCHME_AUTHKEY'              => 'Authentication Captch Me key',
    'CAPTCHME_AUTHKEY_EXPLAIN'      => 'Your authentication Captch Me key. Keys can be obtained on <a href="http://www.google.com/captchme">www.google.com/captchme</a>.',
    'CAPTCHME_LANG'              => 'Captch Me module language ',
    'CAPTCHME_LANG_EXPLAIN'         => 'You can explicity specify the language of the module Captch Me.',
    'CAPTCHME_FORMAT'              => 'Format of the Captch Me module ',
    'CAPTCHME_FORMAT_EXPLAIN'         => 'You can explicity specify the format of the module Captch Me.',
    'CAPTCHME_THEME'              => 'Captch Me module theme ',
    'CAPTCHME_THEME_EXPLAIN'         => 'You can explicity specify the theme of the module Captch Me.',
    'CAPTCHME_TITRE'              => 'Captch Me title ',
    'CAPTCHME_TITRE_EXPLAIN'         => 'You can explicity specify if the title of the module is displayed or not.',
    'CAPTCHME_INSTRUCTION'              => 'Captch Me module instruction ',
    'CAPTCHME_INSTRUCTION_EXPLAIN'         => 'You can explicity specify if the instruction of the module is displayed or not.',
    'CAPTCHME_CLASSIC'              =>  'Classic',
    'CAPTCHME_WIDE'              =>  'Wide',
    'CAPTCHME_GRAY'              =>  'Gray',
    'CAPTCHME_WHITE'              =>  'White',
    'CAPTCHME_SHOW'              =>  'Show',
    'CAPTCHME_HIDE'              =>  'Hide',
    'CAPTCHME_FRENCH'              =>  'French',
    'CAPTCHME_ENGLISH'              =>  'English',
    'CAPTCHME_SPANISH'              =>  'Spanish',
    'CAPTCHME_WEBUSER'              =>  'Web User',
	'CAPTCHME_EXPLAIN'				=> 'In an effort to prevent automatic submissions, we require that you answered the question displayed into the text field underneath.',
));

?>
