<?php
/**
*
* @package phpBB3 Advertisement Management
* @version $Id$
* @copyright (c) 2008 EXreaction
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @ignore
*/
define('IN_PHPBB', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : '../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);
require($phpbb_root_path . 'ads/constants.' . $phpEx);

// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup('mods/info_acp_ads');

// Display a login box if they are not logged in
if (!$user->data['is_registered'])
{
  login_box();
}

if (!file_exists($phpbb_root_path . 'umil/umil_frontend.' . $phpEx))
{
	trigger_error('Please download the latest UMIL (Unified MOD Install Library) from: <a href="http://www.phpbb.com/mods/umil/">phpBB.com/mods/umil</a>', E_USER_ERROR);
}

include($phpbb_root_path . 'umil/umil_frontend.' . $phpEx);
$umil = new umil_frontend('ACP_ADVERTISEMENT_MANAGEMENT', true);

// Check after initiating UMIL.
if ($user->data['user_type'] != USER_FOUNDER)
{
  trigger_error('FOUNDERS_ONLY');
}

if ($umil->confirm_box(true))
{
	include($phpbb_root_path . 'ads/versions.' . $phpEx);

	$umil->run_actions('uninstall', $versions, 'ads_version');
}
else
{
	$umil->display_stages(array('CONFIRM', 'UNINSTALL'));

	$umil->confirm_box(false, 'UNINSTALL');
}

$umil->done();
?>