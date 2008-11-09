<?php
/**
*
* @package phpBB3 Advertisement Management
* @version $Id$
* @copyright (c) 2008 EXreaction, Lithium Studios
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

include($phpbb_root_path . 'umif/umif_frontend.' . $phpEx);
$umif = new umif_frontend('ACP_ADVERTISEMENT_MANAGEMENT', true);

if ($umif->confirm_box(true))
{
	$umif->display_stages(array('CONFIRM', 'UNINSTALL'), 2);

	$umif->table_remove(ADS_TABLE);

	$umif->table_remove(ADS_FORUMS_TABLE);

	$umif->table_remove(ADS_GROUPS_TABLE);

	$umif->table_remove(ADS_IN_POSITIONS_TABLE);

	$umif->table_remove(ADS_POSITIONS_TABLE);

	$umif->permission_remove('a_ads', true);

	$umif->module_remove('acp', 'ACP_BOARD_CONFIGURATION', 'ACP_ADVERTISEMENT_MANAGEMENT');

	$umif->config_remove('ads_enable');
	$umif->config_remove('ads_rules_forums');
	$umif->config_remove('ads_rules_groups');
	$umif->config_remove('ads_count_clicks');
	$umif->config_remove('ads_count_views');
	$umif->config_remove('ads_accurate_views');
	$umif->config_remove('ads_last_cron');
	$umif->config_remove('ads_version');
	
	$umif->cache_purge();
}
else
{
	$umif->display_stages(array('CONFIRM', 'UNINSTALL'));

	$umif->confirm_box(false, 'UNINSTALL');
}

$umif->done();
?>