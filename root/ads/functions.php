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

require($phpbb_root_path . 'ads/constants.' . $phpEx);

/**
* Setup Advertisements
*
* Grabs an advertisement for each available position and outputs it to the template.
*/
function setup_ads()
{
	global $cache, $config, $db, $phpbb_root_path, $phpEx, $template, $user, $forum_id;

	$user->add_lang('mods/ads');

	// Automatically install or update if required
	if (!isset($config['ads_version']) || $config['ads_version'] != '1.0.8')
	{
		if (!class_exists('umil'))
		{
			if (!file_exists($phpbb_root_path . 'umil/umil.' . $phpEx))
			{
				trigger_error('Please download the latest UMIL (Unified MOD Install Library) from: <a href="http://www.phpbb.com/mods/umil/">phpBB.com/mods/umil</a>', E_USER_ERROR);
			}

			include($phpbb_root_path . 'umil/umil.' . $phpEx);
		}

		$umil = new umil(true);

		include($phpbb_root_path . 'ads/versions.' . $phpEx);

		$umil->run_actions('update', $versions, 'ads_version');
		unset($versions);
	}

	if (!$config['ads_enable'])
	{
		return;
	}

	$forum_id = ($forum_id) ? $forum_id : request_var('f', 0);
	$ads = get_ads($user->data['user_id'], $forum_id);

	if (sizeof($ads))
	{
		foreach ($ads as $position_id => $code)
		{
			$template->assign_vars(array(
				'ADS_' . $position_id		=> $code,
			));
		}

		if (isset($template->_tpldata['.'][0]['ADS_8']))
		{
			$template->_tpldata['.'][0]['ADS_8'] .= '<div class="copyright" style="margin-top: 5px;">' . $user->lang['ADVERTISEMENT_MANAGEMENT_CREDITS'] . '</div>';
		}
		else
		{
			$template->_tpldata['.'][0]['ADS_8'] = '<div class="copyright" style="margin-top: 5px;">' . $user->lang['ADVERTISEMENT_MANAGEMENT_CREDITS'] . '</div>';
		}

		$template->assign_var('ADS_CLICK_FILE', $phpbb_root_path . 'ads/click.' . $phpEx);
		$template->assign_var('ADS_VIEW_FILE', $phpbb_root_path . 'ads/view.' . $phpEx);
	}
}

/**
*  Get ads
*
* @param mixed $user_id
* @param mixed $forum_id
* @param bool $acurate_view_count true will enable the acurate view counts, false will disable them (disable when not within phpBB).
*/
function get_ads($user_id = 1, $forum_id = 0, $acurate_view_count = true)
{
	global $config, $db, $phpbb_root_path;

	$user_id = (int) $user_id;
	$forum_id = (int) $forum_id;

	// A built in cron-like function for disabling ads after they reach their end date.  Runs once every hour
	if ($config['ads_last_cron'] < (time() - 3600))
	{
		$ads_to_disable = array();
		$sql = 'SELECT ad_id FROM ' . ADS_TABLE . '
			WHERE ad_enabled = 1
			AND ad_time_end > 0
			AND ad_time_end < ' . time();
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			$ads_to_disable[] = $row['ad_id'];
		}
		$db->sql_freeresult($result);

		if (sizeof($ads_to_disable))
		{
			$db->sql_query('UPDATE ' . ADS_TABLE . ' SET ad_enabled = 0 WHERE ' . $db->sql_in_set('ad_id', $ads_to_disable));
			$db->sql_query('UPDATE ' . ADS_IN_POSITIONS_TABLE . ' SET ad_enabled = 0 WHERE ' . $db->sql_in_set('ad_id', $ads_to_disable));
		}
		set_config('ads_last_cron', time(), true);
	}

	// Set some variables up
	$ads = $ignore_ads = $forum_ads = $available_ads = $id_list = $return_list = array();

	if ($config['ads_rules_groups'])
	{
		$sql = 'SELECT a.ad_id FROM ' . ADS_GROUPS_TABLE . ' a, ' . USER_GROUP_TABLE . ' ug
			WHERE ug.user_pending = 0
			AND ug.user_id = ' . $user_id . '
			AND a.group_id = ug.group_id';
		$result = $db->sql_query($sql, 60); // Cache this data for 1 minute
		while ($row = $db->sql_fetchrow($result))
		{
			$ignore_ads[] = $row['ad_id'];
		}
		$db->sql_freeresult($result);
	}

	if ($config['ads_rules_forums'] && $forum_id)
	{
		$sql = 'SELECT ad_id FROM ' . ADS_FORUMS_TABLE . '
			WHERE forum_id = ' . (int) $forum_id;
		$result = $db->sql_query($sql, 60); // Cache this data for 1 minute
		while ($row = $db->sql_fetchrow($result))
		{
			$forum_ads[] = $row['ad_id'];
		}
		$db->sql_freeresult($result);
	}

	$sql = 'SELECT ad_id, position_id, ad_priority FROM ' . ADS_IN_POSITIONS_TABLE . '
		WHERE ad_enabled = 1' .
		((sizeof($forum_ads)) ? ' AND (all_forums = 1 OR ' . $db->sql_in_set('ad_id', $forum_ads) . ')' : (($config['ads_rules_forums']) ? ' AND all_forums = 1' : '')) .
		((sizeof($ignore_ads)) ? ' AND ' . $db->sql_in_set('ad_id', $ignore_ads, true) : '');
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
			$id_list[] = $available_ads[$position_id] = $ary[rand(0, (sizeof($ary) - 1))];
		}
		$id_list = array_unique($id_list);

		$sql = 'SELECT ad_id, ad_code, ad_views, ad_view_limit, ad_clicks, ad_click_limit FROM ' . ADS_TABLE . '
			WHERE ' . $db->sql_in_set('ad_id', $id_list);
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			$ads[$row['ad_id']] = $row;

			if ($row['ad_view_limit'] != 0 && ($row['ad_views'] + 1) >= $row['ad_view_limit'])
			{
				$db->sql_query('UPDATE ' . ADS_TABLE . ' SET ad_enabled = 0 WHERE ad_id = ' . $row['ad_id']);
				$db->sql_query('UPDATE ' . ADS_IN_POSITIONS_TABLE . ' SET ad_enabled = 0 WHERE ad_id = ' . $row['ad_id']);
			}
		}
		$db->sql_freeresult($result);

		foreach ($available_ads as $position_id => $ad_id)
		{
			$code = htmlspecialchars_decode($ads[$ad_id]['ad_code']);
			$code = ($config['ads_count_clicks']) ? str_replace(array('{COUNT_CLICK}', '{COUNT_CLICKS}'), ' onclick="countAdClick(' . $ad_id . ');"', $code) : $code;

			if ($acurate_view_count && $config['ads_accurate_views'])
			{
				//$code = '<img src="' . $phpbb_root_path . 'images/spacer.gif" alt="" onload="countAdView(' . $ad_id . ');" />' . $code;
				$code = '<script type="text/javascript" >countAdView(' . $ad_id . ')</script>' . $code;
			}

			$return_list[$position_id] = $code;
		}

		if ($config['ads_count_views'] && !$config['ads_accurate_views'])
		{
			$db->sql_query('UPDATE ' . ADS_TABLE . ' SET ad_views = ad_views + 1 WHERE ' . $db->sql_in_set('ad_id', $id_list));
		}
	}

	return $return_list;
}
?>