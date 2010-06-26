<?php
/**
*
* @package phpBB3 Advertisement Management
* @version $Id$
* @copyright (c) 2008 EXreaction, Lithium Studios
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

$versions = array(
	'0.7.0'		=> array(
		'table_add'	=> array(
			array('phpbb_ads', array(
				'COLUMNS'		=> array(
					'ad_id'			=> array('UINT', NULL, 'auto_increment'),
					'ad_name'		=> array('VCHAR', ''),
					'ad_code'		=> array('TEXT_UNI', ''),
					'ad_views'		=> array('UINT', 0),
					'ad_priority'	=> array('TINT:1', 5),
					'ad_enabled'	=> array('BOOL', 1),
					'all_forums'	=> array('BOOL', 0),
				),
				'PRIMARY_KEY'	=> 'ad_id',
			)),

			array('phpbb_ads_forums', array(
				'COLUMNS'		=> array(
					'ad_id'			=> array('UINT', 0),
					'forum_id'		=> array('UINT', 0),
				),
				'KEYS'			=> array(
					'ad_forum'		=> array('INDEX', array('ad_id', 'forum_id')),
				),
			)),

			array('phpbb_ads_groups', array(
				'COLUMNS'		=> array(
					'ad_id'			=> array('UINT', 0),
					'group_id'		=> array('UINT', 0),
				),
				'KEYS'			=> array(
					'ad_group'		=> array('INDEX', array('ad_id', 'group_id')),
				),
			)),

			array('phpbb_ads_in_positions', array(
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
			)),

			array('phpbb_ads_positions', array(
				'COLUMNS'		=> array(
					'position_id'	=> array('UINT', NULL, 'auto_increment'),
					'lang_key'		=> array('TEXT_UNI', ''),
				),
				'PRIMARY_KEY'	=> 'position_id',
			)),
		),

		'permission_add'	=> array('a_ads'),

		'module_add'		=> array(
			array('acp', 'ACP_BOARD_CONFIGURATION', array('module_basename' => 'ads')),
		),

		'config_add'		=> array(
			array('ads_enable', 1),
			array('ads_rules_forums', 1),
			array('ads_rules_groups', 1),
		),

		'custom'			=> 'ads_install',
	),
	'1.0.0'		=> array(),
	'1.0.1'		=> array(
		'table_column_add'	=> array(
			array('phpbb_ads', 'ad_clicks', array('UINT', 0)),
		),

		'config_add'		=> array(
			array('ads_count_clicks', 1),
			array('ads_count_views', 1),
			array('ads_accurate_views', 0),
		),
	),
	'1.0.2'		=> array(),
	'1.0.3'		=> array(),
	'1.0.4'		=> array(
		'table_column_add'	=> array(
			array('phpbb_ads', 'ad_note', array('MTEXT_UNI', '')),
			array('phpbb_ads', 'ad_time', array('TIMESTAMP', 0)),
			array('phpbb_ads', 'ad_time_end', array('TIMESTAMP', 0)),
		),

		'config_add'		=> array(
			array('ads_last_cron', 0, true),
		),
	),
	'1.0.5'		=> array(),
	'1.0.6'		=> array(),
	'1.0.7'		=> array(),
	'1.0.8'		=> array(
		'table_column_add'	=> array(
			array('phpbb_ads', 'ad_view_limit', array('UINT', 0)),
			array('phpbb_ads', 'ad_click_limit', array('UINT', 0)),
		),
	),
	'1.0.9'		=> array(
		'config_add'	=> array(
			array('ads_group', 0),
		),
		'table_column_add'	=> array(
			array('phpbb_ads', 'ad_owner', array('UINT', 0)),
			array('phpbb_users', 'ad_owner', array('BOOL', 0)),
		),
	),
	'1.0.10'	=> array(
		'table_column_update'	=> array(
			array('phpbb_ads', 'ad_views', array('BINT', 0)),
			array('phpbb_ads', 'ad_view_limit', array('BINT', 0)),
			array('phpbb_ads', 'ad_clicks', array('BINT', 0)),
			array('phpbb_ads', 'ad_click_limit', array('BINT', 0)),
		),

		'table_index_add'		=> array(
			array('phpbb_ads', 'ad_priority'),
			array('phpbb_ads', 'ad_enabled'),
			array('phpbb_ads', 'ad_owner'),
		),

		'cache_purge'	=> array(
			'template',
		),
	),
);

function ads_install($action, $version)
{
	global $db, $table_prefix;

	if ($action != 'install')
	{
		return;
	}

	// Insert the default positions
	$positions = array('ABOVE_HEADER', 'BELOW_HEADER', 'ABOVE_POSTS', 'BELOW_POSTS', 'AFTER_FIRST_POST', 'AFTER_EVERY_POST', 'ABOVE_FOOTER', 'BELOW_FOOTER');
	foreach ($positions as $position)
	{
		$db->sql_query('INSERT INTO ' . $table_prefix . 'ads_positions ' . $db->sql_build_array('INSERT', array('lang_key' => $position)));
	}
}

?>