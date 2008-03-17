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

/**
* Setup Advertisements
*
* Grabs an advertisement for each available position and outputs it to the template.
*/
function setup_ads()
{
	global $cache, $config, $db, $phpbb_root_path, $phpEx, $template, $user;

	$ads_version = '1.0.0';

	// Automatically install or update if required
	if (!isset($config['ads_version']) || $config['ads_version'] != $ads_version)
	{
		require($phpbb_root_path . 'ads/update.' . $phpEx);
	}

	if (!$config['ads_enable'])
	{
		return;
	}

	// Set some variables up
	$ads = $ignore_ads = $available_ads = $id_list = array();

	if ($config['ads_rules_groups'])
	{
		$sql = 'SELECT a.ad_id FROM ' . ADS_GROUPS_TABLE . ' a, ' . USER_GROUP_TABLE . ' ug
			WHERE ug.user_pending = 0
			AND ug.user_id = ' . $user->data['user_id'] . '
			AND a.group_id = ug.group_id';
		$result = $db->sql_query($sql, 300); // Cache this data for 5 minutes
		while ($row = $db->sql_fetchrow($result))
		{
			$ignore_ads[] = $row['ad_id'];
		}
		$db->sql_freeresult($result);
	}

	if ($config['ads_rules_forums'] && request_var('f', 0))
	{
		$forum_ads = array();
		$sql = 'SELECT ad_id FROM ' . ADS_FORUMS_TABLE . '
			WHERE forum_id = ' . request_var('f', 0);
		$result = $db->sql_query($sql, 300); // Cache this data for 5 minutes
		while ($row = $db->sql_fetchrow($result))
		{
			$forum_ads[] = $row['ad_id'];
		}
		$db->sql_freeresult($result);

		$sql = 'SELECT ad_id, position_id, ad_priority FROM ' . ADS_IN_POSITIONS_TABLE . '
			WHERE ad_enabled = 1
			AND (ad_max_views = 0 OR ad_views < ad_max_views)' . 
			((sizeof($forum_ads)) ? ' AND (all_forums = 1 OR ' . $db->sql_in_set('ad_id', $forum_ads) . ')' : ' AND all_forums = 1') .
			((sizeof($ignore_ads)) ? ' AND ' . $db->sql_in_set('ad_id', $ignore_ads, true) : '');
	}
	else
	{
		$sql = 'SELECT ad_id, position_id, ad_priority FROM ' . ADS_IN_POSITIONS_TABLE . '
			WHERE ad_enabled = 1
			AND (ad_max_views = 0 OR ad_views < ad_max_views)' .
			((sizeof($ignore_ads)) ? ' AND ' . $db->sql_in_set('ad_id', $ignore_ads, true) : '');
	}
	$result = $db->sql_query($sql);
	while ($row = $db->sql_fetchrow($result))
	{
		// A simple way to set Advertisement Priority
		for ($i = 0; $i < $row['ad_priority']; $i++)
		{
			if (!isset($available_ads[$row['position_id']]))
			{
				$available_ads[$row['position_id']] = array();
			}

			$available_ads[$row['position_id']][] = $row['ad_id'];
		}
	}
	$db->sql_freeresult($result);

	if (sizeof($available_ads))
	{
		foreach ($available_ads as $position_id => $ary)
		{
			$id_list[] = $available_ads[$position_id] = $ary[rand(0, sizeof($ary) - 1)];
		}

		$sql = 'SELECT * FROM ' . ADS_TABLE . '
			WHERE ' . $db->sql_in_set('ad_id', array_unique($id_list));
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			$ads[$row['ad_id']] = $row;
		}
		$db->sql_freeresult($result);

		foreach ($available_ads as $position_id => $ad_id)
		{
			$template->assign_vars(array(
				'ADS_' . $position_id		=> htmlspecialchars_decode($ads[$ad_id]['ad_code']),
			));
		}

		$db->sql_query('UPDATE ' . ADS_TABLE . ' SET ad_views = ad_views + 1 WHERE ' . $db->sql_in_set('ad_id', array_unique($id_list)));
		$db->sql_query('UPDATE ' . ADS_IN_POSITIONS_TABLE . ' SET ad_views = ad_views + 1 WHERE ' . $db->sql_in_set('ad_id', array_unique($id_list)));
	}
}
?>