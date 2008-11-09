<?php
/**
*
* @package phpBB3 Advertisement Management
* @version $Id$
* @copyright (c) 2008 EXreaction, Lithium Studios
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

if (!defined('IN_PHPBB') || !isset($ads_version))
{
	exit;
}

// We are setting this again because it seems some people have problems uploading all files
// When update time comes and the new update file is not uploaded, the version in the database is set to the version in the ads/functions.php file which may differ from the version of this file.
$ads_version = '1.0.7';

include($phpbb_root_path . 'umif/umif.' . $phpEx);
$umif = new $umif;

if (!$umif->config_exists('ads_version'))
{
	$umif->table_add(ADS_TABLE, array(
		'COLUMNS'		=> array(
			'ad_id'			=> array('UINT', NULL, 'auto_increment'),
			'ad_time'		=> array('TIMESTAMP', 0),
			'ad_time_end'	=> array('TIMESTAMP', 0),
			'ad_name'		=> array('VCHAR', ''),
			'ad_code'		=> array('TEXT_UNI', ''),
			'ad_views'		=> array('UINT', 0),
			'ad_clicks'		=> array('UINT', 0),
			'ad_priority'	=> array('TINT:1', 5),
			'ad_enabled'	=> array('BOOL', 1),
			'all_forums'	=> array('BOOL', 0),
			'ad_note'		=> array('MTEXT_UNI', ''),
		),
		'PRIMARY_KEY'	=> 'ad_id',
	));

	$umif->table_add(ADS_FORUMS_TABLE, array(
		'COLUMNS'		=> array(
			'ad_id'			=> array('UINT', 0),
			'forum_id'		=> array('UINT', 0),
		),
		'KEYS'			=> array(
			'ad_forum'		=> array('INDEX', array('ad_id', 'forum_id')),
		),
	));

	$umif->table_add(ADS_GROUPS_TABLE, array(
		'COLUMNS'		=> array(
			'ad_id'			=> array('UINT', 0),
			'group_id'		=> array('UINT', 0),
		),
		'KEYS'			=> array(
			'ad_group'		=> array('INDEX', array('ad_id', 'group_id')),
		),
	));

	$umif->table_add(ADS_IN_POSITIONS_TABLE, array(
		'COLUMNS'		=> array(
			'ad_id'			=> array('UINT', 0),
			'position_id'	=> array('UINT', 0),
			'ad_priority'	=> array('TINT:1', 5),
			'ad_enabled'	=> array('BOOL', 1),
			'all_forums'	=> array('BOOL', 0),
		),
		'KEYS'			=> array(
			'ad_position'	=> array('INDEX', array('ad_id', 'position_id')),
			'ad_priority'	=> array('INDEX', 'ad_priority'),
			'ad_enabled'	=> array('INDEX', 'ad_enabled'),
			'all_forums'	=> array('INDEX', 'all_forums'),
		),
	));

	$umif->table_add(ADS_POSITIONS_TABLE, array(
		'COLUMNS'		=> array(
			'position_id'	=> array('UINT', NULL, 'auto_increment'),
			'lang_key'		=> array('TEXT_UNI', ''),
		),
		'PRIMARY_KEY'	=> 'position_id',
	));

	$umif->permission_add('a_ads', true);

	$umif->module_add('acp', 'ACP_BOARD_CONFIGURATION', array('module_basename' => 'ads'));

	// Insert the default positions
	$positions = array('ABOVE_HEADER', 'BELOW_HEADER', 'ABOVE_POSTS', 'BELOW_POSTS', 'AFTER_FIRST_POST', 'AFTER_EVERY_POST', 'ABOVE_FOOTER', 'BELOW_FOOTER');
	foreach ($positions as $position)
	{
		$db->sql_query('INSERT INTO ' . ADS_POSITIONS_TABLE . ' ' . $db->sql_build_array('INSERT', array('lang_key' => $position)));
	}

	$umif->config_add('ads_enable', 1);
	$umif->config_add('ads_rules_forums', 1);
	$umif->config_add('ads_rules_groups', 1);
	$umif->config_add('ads_count_clicks', 1);
	$umif->config_add('ads_count_views', 1);
	$umif->config_add('ads_accurate_views', 0);
	$umif->config_add('ads_last_cron', 0, true);
	$umif->config_add('ads_version', $ads_version);
	
	$umif->cache_purge();
}
else
{
	// No breaks!
	switch ($config['ads_version'])
	{
		case '0.7.0' :
		case '1.0.0' :
			$db_tool->sql_column_add(ADS_TABLE, 'ad_clicks', array('UINT', 0));
			$umif->config_add('ads_count_clicks', 1);
			$umif->config_add('ads_count_views', 1);
			$umif->config_add('ads_accurate_views', 0);
		case '1.0.1' :
		case '1.0.2' :
		case '1.0.3' :
			$db_tool->sql_column_add(ADS_TABLE, 'ad_note', array('MTEXT_UNI', ''));
			$db_tool->sql_column_add(ADS_TABLE, 'ad_time', array('TIMESTAMP', 0));
			$db_tool->sql_column_add(ADS_TABLE, 'ad_time_end', array('TIMESTAMP', 0));
			$umif->config_add('ads_last_cron', 0, true);
		case '1.0.4' :
		case '1.0.5' :
		case '1.0.6' :
	}

	$umif->config_update('ads_version', $ads_version);

	$umif->cache_purge();
}
?>