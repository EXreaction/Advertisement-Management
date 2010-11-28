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

// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup(array('acp/common', 'mods/ads', 'mods/info_acp_ads'));

$template->set_custom_template($phpbb_root_path . 'ads/style', 'ads');
$template->assign_var('T_TEMPLATE_PATH', $phpbb_root_path . 'ads/style');

// HAX (don't add to the view count every time this page is viewed)
// It doesn't look good to the advertisers since this is the only (in a vanilla install) page that would add to the view count but not display them it is fine
$config['ads_count_views'] = false;

page_header('ACP_ADVERTISEMENT_MANAGEMENT');

$template->assign_vars(array(
	'S_POSITION_LIST'	=> true,
	'S_AD_LIST'			=> true,
	'PAGE_TITLE'		=> $user->lang['ACP_ADVERTISEMENT_MANAGEMENT'],
));

// Advertisements
$ads = array();
$sql = 'SELECT * FROM ' . ADS_TABLE . '
	WHERE ad_owner = ' . $user->data['user_id'] . '
	ORDER BY ad_enabled DESC, ad_time DESC';
$result = $db->sql_query($sql);
while ($row = $db->sql_fetchrow($result))
{
	$ads[$row['ad_id']] = $row;
	$ads[$row['ad_id']]['positions'] = array();
	$ads[$row['ad_id']]['forums'] = array();
}
$db->sql_freeresult($result);

if (sizeof($ads))
{
	// Positions
	$positions = array();
	$sql = 'SELECT position_id, lang_key FROM ' . ADS_POSITIONS_TABLE . ' ORDER BY position_id ASC';
	$result = $db->sql_query($sql);
	while ($row = $db->sql_fetchrow($result))
	{
		$positions[$row['position_id']] = (isset($user->lang[$row['lang_key']])) ? $user->lang[$row['lang_key']] : $row['lang_key'];
	}
	$db->sql_freeresult($result);

	// Forums
	$forums = array();
	$sql = 'SELECT forum_id, forum_name FROM ' . FORUMS_TABLE . ' ORDER BY forum_id ASC';
	$result = $db->sql_query($sql);
	while ($row = $db->sql_fetchrow($result))
	{
		$forums[$row['forum_id']] = $row['forum_name'];
	}
	$db->sql_freeresult($result);

	$sql = 'SELECT * FROM ' . ADS_IN_POSITIONS_TABLE . '
		WHERE ' . $db->sql_in_set('ad_id', array_keys($ads));
	$result = $db->sql_query($sql);
	while ($row = $db->sql_fetchrow($result))
	{
		$ads[$row['ad_id']]['positions'][] = $positions[$row['position_id']];
	}
	$db->sql_freeresult($result);

	$sql = 'SELECT * FROM ' . ADS_FORUMS_TABLE . '
		WHERE ' . $db->sql_in_set('ad_id', array_keys($ads));
	$result = $db->sql_query($sql);
	while ($row = $db->sql_fetchrow($result))
	{
		$ads[$row['ad_id']]['forums'][] = $forums[$row['forum_id']];
	}
	$db->sql_freeresult($result);

	foreach ($ads as $row)
	{
		$ads_in_positions = implode('<br />', $row['positions']);
		$ads_in_forums = implode('<br />', $row['forums']);

		$template->assign_block_vars('ads', array(
			'AD_ID'				=> $row['ad_id'],
			'AD_ENABLED'		=> ($row['ad_enabled']) ? $user->lang['TRUE'] : $user->lang['FALSE'],
			'AD_CODE'			=> $row['ad_code'],
			'AD_CODE_DISPLAY'	=> htmlspecialchars_decode($row['ad_code']),
			'AD_TIME'			=> date('d F Y', $row['ad_time']),
			'AD_TIME_END'		=> ($row['ad_time_end']) ? date('d F Y', $row['ad_time_end']) : 0,
			'AD_VIEW_LIMIT'		=> $row['ad_view_limit'],
			'AD_VIEWS'			=> $row['ad_views'],
			'AD_CLICK_LIMIT'	=> $row['ad_click_limit'],
			'AD_CLICKS'			=> ($row['ad_clicks']) ? $row['ad_clicks'] : $user->lang['0_OR_NA'],
			'AD_IN_POSITIONS'	=> $ads_in_positions,
			'AD_IN_FORUMS'		=> ($row['all_forums']) ? $user->lang['ALL_FORUMS'] : $ads_in_forums,
		));
	}
}

$template->set_filenames(array(
	'body'	=> 'acp_ads.html',
));

page_footer();

?>