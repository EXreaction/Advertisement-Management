<?php
/**
*
* @package phpBB3 Advertisement Management
* @version $Id$
* @copyright (c) 2008 EXreaction, Lithium Studios
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/*
* Notes:
*  Accurate ad views does not work when linking to this file to show the ads.
*  The URL should look something like:
*   lithiumstudios.org/ads/ads.php?p=position_id&f=forum_id&u=user_id
*/

$position_id = (int) (isset($_GET['p'])) ? $_GET['p'] : 0;
$forum_id = (int) (isset($_GET['f'])) ? $_GET['f'] : 0;
$user_id = (int) (isset($_GET['u'])) ? $_GET['u'] : 0;

if (!$position_id)
{
	exit;
}

define('IN_PHPBB', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : '../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);

require($phpbb_root_path . 'config.' . $phpEx);
require($phpbb_root_path . 'includes/acm/acm_' . $acm_type . '.' . $phpEx);
require($phpbb_root_path . 'includes/cache.' . $phpEx);
require($phpbb_root_path . 'includes/constants.' . $phpEx);
require($phpbb_root_path . 'includes/db/' . $dbms . '.' . $phpEx);

$cache		= new cache();
$db			= new $sql_db();

// Connect to DB
$db->sql_connect($dbhost, $dbuser, $dbpasswd, $dbname, $dbport, false, defined('PHPBB_DB_NEW_LINK') ? PHPBB_DB_NEW_LINK : false);

// We do not need this any longer, unset for safety purposes
unset($dbpasswd);

// Grab global variables, re-cache if necessary
$config = $cache->obtain_config();

if (!$config['ads_enable'])
{
	exit;
}

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
$ads = $ignore_ads = $forum_ads = $available_ads = $id_list = array();

if ($config['ads_rules_groups'])
{
	$sql = 'SELECT a.ad_id FROM ' . ADS_GROUPS_TABLE . ' a, ' . USER_GROUP_TABLE . ' ug
		WHERE ug.user_pending = 0
		AND ug.user_id = ' . $user_id . '
		AND a.group_id = ug.group_id';
	$result = $db->sql_query($sql, 300); // Cache this data for 5 minutes
	while ($row = $db->sql_fetchrow($result))
	{
		$ignore_ads[] = $row['ad_id'];
	}
	$db->sql_freeresult($result);
}

if ($config['ads_rules_forums'])
{
	$sql = 'SELECT ad_id FROM ' . ADS_FORUMS_TABLE . '
		WHERE forum_id = ' . $forum_id;
	$result = $db->sql_query($sql, 300); // Cache this data for 5 minutes
	while ($row = $db->sql_fetchrow($result))
	{
		$forum_ads[] = $row['ad_id'];
	}
	$db->sql_freeresult($result);
}

$sql = 'SELECT ad_id, ad_priority FROM ' . ADS_IN_POSITIONS_TABLE . '
	WHERE ad_enabled = 1
	AND position_id = ' . $position_id .
	((sizeof($forum_ads)) ? ' AND (all_forums = 1 OR ' . $db->sql_in_set('ad_id', $forum_ads) . ')' : (($config['ads_rules_forums']) ? ' AND all_forums = 1' : '')) .
	((sizeof($ignore_ads)) ? ' AND ' . $db->sql_in_set('ad_id', $ignore_ads, true) : '');
$result = $db->sql_query($sql);

while ($row = $db->sql_fetchrow($result))
{
	// A simple way to set Advertisement Priority
	for ($i = 0; $i < $row['ad_priority']; $i++)
	{
		$available_ads[] = $row['ad_id'];
	}
}
$db->sql_freeresult($result);

if (sizeof($available_ads))
{
	$ad_id = $available_ads[rand(0, (sizeof($available_ads) - 1))];

	$sql = 'SELECT ad_id, ad_code FROM ' . ADS_TABLE . '
		WHERE ad_id = ' . $ad_id;
	$result = $db->sql_query($sql);
	$row = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);

	$code = htmlspecialchars_decode($row['ad_code']);
	$code = ($config['ads_count_clicks']) ? str_replace(array('{COUNT_CLICK}', '{COUNT_CLICKS}'), ' onclick="countAdClick(' . $ad_id . ');"', $code) : $code;
	//$code = ($config['ads_accurate_views']) ? '<img src="' . $phpbb_root_path . 'images/spacer.gif" onload="countAdView(' . $ad_id . ');" />' . $code : $code;

	echo $code;

	if ($config['ads_count_views'] || $config['ads_accurate_views'])
	{
		$db->sql_query('UPDATE ' . ADS_TABLE . ' SET ad_views = ad_views + 1 WHERE ad_id = ' . $ad_id);
	}
}

?>