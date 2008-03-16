<?php
/**
*
* @package phpBB3 Advertisement Management
* @version $Id: ads.php 6 2008-03-16 03:45:19Z exreaction@gmail.com $
* @copyright (c) 2008 EXreaction, Lithium Studios
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

/**
* @package acp
*/
class acp_ads
{
	var $u_action;
	var $new_config = array();

	function main($id, $mode)
	{
		global $db, $user, $auth, $template;
		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;

		$user->add_lang('mods/ads');
		$this->tpl_name = 'acp_ads';
		$this->page_title = 'ACP_ADVERTISEMENT_MANAGEMENT';

		$action	= request_var('action', '');
		$submit = (isset($_POST['submit'])) ? true : false;
		$position_id = request_var('p', 0);
		$ad_id = request_var('a', 0);

		$error = array();

		$form_key = 'acp_board';
		add_form_key($form_key);
		if ($submit && !check_form_key($form_key))
		{
			trigger_error($user->lang['FORM_INVALID'] . adm_back_link($this->u_action), E_USER_WARNING);
		}

		// Config Variables
		$config_vars = array(
			'legend1'				=> 'ACP_ADVERTISEMENT_MANAGEMENT_SETTINGS',
			'ads_enable'			=> array('lang' => 'ADS_ENABLE', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false),
		);
		$this->new_config = $config;
		$this->new_config = (isset($_REQUEST['config'])) ? utf8_normalize_nfc(request_var('config', array('' => ''), true)) : $this->new_config;
		validate_config_vars($config_vars, $this->new_config, $error);

		if ($submit && !sizeof($error))
		{
			switch ($action)
			{
				case 'add' :
					$ad_name = request_var('ad_name', '', true);
					$position_name = request_var('position_name', '', true);

					if ($ad_name)
					{
						die('not done yet');
						trigger_error($user->lang['AD_ADD_SUCCESS'] . adm_back_link($this->u_action));
					}
					else
					{
						// Make sure the given position name isn't already in the database.
						$sql = 'SELECT position_id FROM ' . ADS_POSITIONS_TABLE . ' WHERE lang_key = \'' . $db->sql_escape($position_name) . "'";
						$result = $db->sql_query($sql);
						if ($db->sql_fetchrow($result))
						{
							trigger_error($user->lang['POSTITION_ALREADY_EXIST'] . adm_back_link($this->u_action));
						}

						$db->sql_query('INSERT INTO ' . ADS_POSITIONS_TABLE . ' ' . $db->sql_build_array('INSERT', array('lang_key' => $position_name)));

						trigger_error($user->lang['POSTITION_ADD_SUCCESS'] . adm_back_link($this->u_action));
					}
				break;

				default :
					// Config Variables
					foreach ($config_vars as $config_name => $null)
					{
						if (strpos($config_name, 'legend') === false)
						{
							set_config($config_name, $this->new_config[$config_name]);
						}
					}

					trigger_error($user->lang['ADVERTISEMENT_MANAGEMENT_UPDATE_SUCCESS'] . adm_back_link($this->u_action));
				break;
			}
		}
		else
		{
			switch ($action)
			{
				case 'add_ad' :
					die('not done yet');
					$template->assign_vars(array(
						'S_ADD_AD'		=> true,
					));
				break;

				case 'edit' :
					if ($ad_id)
					{
						die('not done yet');
						$template->assign_vars(array(
							'S_EDIT_AD'		=> true,
						));
					}
					else if ($position_id)
					{
						die('not done yet');
						$template->assign_vars(array(
							'S_EDIT_POSITION'		=> true,
						));
					}
				break;

				case 'delete' :
					if ($ad_id)
					{
						die('not done yet');
					}
					else if ($position_id)
					{
						die('not done yet');
					}
				break;

				default :
					$template->assign_vars(array(
						'S_POSITION_LIST'	=> true,
						'S_AD_LIST'			=> true,

						'ERROR'				=> implode('<br />', $error),
					));

					// Positions
					$sql = 'SELECT * FROM ' . ADS_POSITIONS_TABLE . ' ORDER BY lang_key ASC';
					$result = $db->sql_query($sql);
					while ($row = $db->sql_fetchrow($result))
					{
						$template->assign_block_vars('positions', array(
							'POSTITION_ID'		=> $row['position_id'],
							'POSITION_NAME'		=> (isset($user->lang[$row['lang_key']])) ? $user->lang[$row['lang_key']] : $row['lang_key'],

							'U_EDIT'			=> $this->u_action . '&amp;action=edit&amp;p=' . $row['position_id'],
							'U_DELETE'			=> $this->u_action . '&amp;action=delete&amp;p=' . $row['position_id'],
						));
					}

					// Advertisements
					$sql = 'SELECT * FROM ' . ADS_TABLE . ' ORDER BY ad_position ASC, ad_name ASC';
					$result = $db->sql_query($sql);
					while ($row = $db->sql_fetchrow($result))
					{
						$template->assign_block_vars('positions', array(
							'AD_ID'			=> $row['ad_id'],
							'AD_NAME'		=> $row['ad_name'],

							'U_EDIT'		=> $this->u_action . '&amp;action=edit&amp;a=' . $row['ad_id'],
							'U_DELETE'		=> $this->u_action . '&amp;action=delete&amp;a=' . $row['ad_id'],
						));
					}
					
					// Config Variables
					foreach ($config_vars as $config_key => $vars)
					{
						if (!is_array($vars) && strpos($config_key, 'legend') === false)
						{
							continue;
						}

						if (strpos($config_key, 'legend') !== false)
						{
							$template->assign_block_vars('options', array(
								'S_LEGEND'		=> true,
								'LEGEND'		=> (isset($user->lang[$vars])) ? $user->lang[$vars] : $vars)
							);

							continue;
						}

						$type = explode(':', $vars['type']);

						$l_explain = '';
						if ($vars['explain'] && isset($vars['lang_explain']))
						{
							$l_explain = (isset($user->lang[$vars['lang_explain']])) ? $user->lang[$vars['lang_explain']] : $vars['lang_explain'];
						}
						else if ($vars['explain'])
						{
							$l_explain = (isset($user->lang[$vars['lang'] . '_EXPLAIN'])) ? $user->lang[$vars['lang'] . '_EXPLAIN'] : '';
						}

						$template->assign_block_vars('options', array(
							'KEY'			=> $config_key,
							'TITLE'			=> (isset($user->lang[$vars['lang']])) ? $user->lang[$vars['lang']] : $vars['lang'],
							'S_EXPLAIN'		=> $vars['explain'],
							'TITLE_EXPLAIN'	=> $l_explain,
							'CONTENT'		=> build_cfg_template($type, $config_key, $this->new_config, $config_key, $vars),
							)
						);
					}
				break;
			}
		}
	}
}

?>