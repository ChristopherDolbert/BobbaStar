<?php
/**
*
* @package NA
* @version 1.1.1
* @copyright (c) 2013 Captch Me
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (!class_exists('phpbb_default_captcha'))
{
	// we need the classic captcha code for tracking solutions and attempts
	include($phpbb_root_path . 'includes/captcha/plugins/captcha_abstract.' . $phpEx);
}

require_once($phpbb_root_path . 'includes/captcha/plugins/captchme/captchme-lib.php');

/**
* @package NA
*/
class phpbb_captchme extends phpbb_default_captcha
{
	var $captchme_server = 'http://api.captchme.net/';
	var $captchme_server_secure = 'https://api.captchme.net/';

	var $challenge;
	var $response;

	function phpbb_captchme()
	{
		$this->captchme_server = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? $this->captchme_server_secure : $this->captchme_server;
	}

	function init($type)
	{
		global $config, $db, $user;

		$user->add_lang('captcha_captchme');
		parent::init($type);
		$this->challenge = request_var('captchme_challenge_field', '');
		$this->response = request_var('captchme_response_field', '');
	}

	function &get_instance()
	{
		$instance =& new phpbb_captchme();
		return $instance;
	}

	function is_available()
	{
		global $config, $user;
		$user->add_lang('captcha_captchme');
		return (isset($config['captchme_pubkey']) && !empty($config['captchme_pubkey']));
	}

	/**
	*  API function
	*/
	function has_config()
	{
		return true;
	}

	function get_name()
	{
		return 'CAPTCHA_CAPTCHME';
	}

	function get_class_name()
	{
		return 'phpbb_captchme';
	}

	function acp_page($id, &$module)
	{
		global $config, $db, $template, $user;

		$captcha_vars = array(
			'captchme_pubkey'				=> 'CAPTCHME_PUBKEY',
			'captchme_privkey'				=> 'CAPTCHME_PRIVKEY',
            'captchme_authkey'              => 'CAPTCHME_AUTHKEY',
            'captchme_lang'              => 'CAPTCHME_LANG',
            'captchme_format'              => 'CAPTCHME_FORMAT',
            'captchme_theme'              => 'CAPTCHME_THEME',
            'captchme_titre'              => 'CAPTCHME_TITRE',
            'captchme_instruction'              => 'CAPTCHME_INSTRUCTION',

		);

		$module->tpl_name = 'captcha_captchme_acp';
		$module->page_title = 'ACP_VC_SETTINGS';
		$form_key = 'acp_captcha';
		add_form_key($form_key);

		$submit = request_var('submit', '');

		if ($submit && check_form_key($form_key))
		{
			$captcha_vars = array_keys($captcha_vars);
			foreach ($captcha_vars as $captcha_var)
			{
				$value = request_var($captcha_var, '');
				if ($value)
				{
					set_config($captcha_var, $value);
				}
			}

			add_log('admin', 'LOG_CONFIG_VISUAL');
			trigger_error($user->lang['CONFIG_UPDATED'] . adm_back_link($module->u_action));
		}
		else if ($submit)
		{
			trigger_error($user->lang['FORM_INVALID'] . adm_back_link($module->u_action));
		}
		else
		{
			foreach ($captcha_vars as $captcha_var => $template_var)
			{
				$var = (isset($_REQUEST[$captcha_var])) ? request_var($captcha_var, '') : ((isset($config[$captcha_var])) ? $config[$captcha_var] : '');
				$template->assign_var($template_var, $var);
			}

			$template->assign_vars(array(
				'CAPTCHA_PREVIEW'	=> $this->get_demo_template($id),
				'CAPTCHA_NAME'		=> $this->get_class_name(),
				'U_ACTION'			=> $module->u_action,
			));

		}
	}


	function get_template()
	{
		global $config, $user, $template;

		if ($this->is_solved())
		{
			return false;
		}
		else
		{
			$explain = $user->lang(($this->type != CONFIRM_POST) ? 'CONFIRM_EXPLAIN' : 'POST_CONFIRM_EXPLAIN', '<a href="mailto:' . htmlspecialchars($config['board_contact']) . '">', '</a>');
            $template->assign_vars(array(
				    'CAPTCHME_SERVER'			=> $this->captchme_server,
				    'CAPTCHME_PUBKEY'			=> isset($config['captchme_pubkey']) ? $config['captchme_pubkey'] : '',
				    'CAPTCHME_PRIVKEY'           => isset($config['captchme_privkey']) ? $config['captchme_privkey'] : '',
                    'CAPTCHME_AUTHKEY'           => isset($config['captchme_authkey']) ? $config['captchme_authkey'] : '',
                    'CAPTCHME_LANG'           => isset($config['captchme_lang']) ? $config['captchme_lang'] : '',
                    'CAPTCHME_FORMAT'           => isset($config['captchme_format']) ? $config['captchme_format'] : '',
                    'CAPTCHME_THEME'           => isset($config['captchme_theme']) ? $config['captchme_theme'] : '',
                    'CAPTCHME_TITRE'           => isset($config['captchme_titre']) ? $config['captchme_titre'] : '',
                    'CAPTCHME_INSTRUCTION'           => isset($config['captchme_instruction']) ? $config['captchme_instruction'] : '',
                    'CAPTCHME_ERRORGET'		    => '',
				    'S_CAPTCHME_AVAILABLE'		=> $this->is_available(),
				    'S_CONFIRM_CODE'			=> true,
				    'S_TYPE'					=> $this->type,
				    'L_CONFIRM_EXPLAIN'			=> $explain,
                    ));
            return 'captcha_captchme.html';
		}
	}

	function get_demo_template($id)
	{
		return $this->get_template();
	}

	function get_hidden_fields()
	{
		$hidden_fields = array();

		// this is required for posting.php - otherwise we would forget about the captcha being already solved
		if ($this->solved)
		{
			$hidden_fields['confirm_code'] = $this->code;
		}
		$hidden_fields['confirm_id'] = $this->confirm_id;
		return $hidden_fields;
	}

	function uninstall()
	{
		$this->garbage_collect(0);
	}

	function install()
	{
		return;
	}

	function validate()
	{
        if (!parent::validate())
		{
			return false;
		}
		else
		{
            return $this->captchme_check_answer();
		}
	}


    function captchme_check_answer(){

        global $config, $user;

        $captchme_response = captchme_verify($config['captchme_privkey'], $this->challenge, $this->response, $user->ip, $config['captchme_authkey']);

        if ($captchme_response->is_valid == '1'){
            $this->solved = true;
            return false;
        }
        else{
            return $user->lang['CAPTCHME_INCORRECT'];
        }

    }
}

?>
