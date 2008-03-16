<?php
/**
*
* @package phpBB3 Advertisement Management
* @version $Id$
* @copyright (c) 2008 EXreaction, Lithium Studios
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/

// Debug
//$start_time = microtime();

$ads_version = '0.3.0';

// Stuff required to work with phpBB3.
define('IN_PHPBB', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
require($phpbb_root_path . 'config.' . $phpEx);
require($phpbb_root_path . 'includes/acm/acm_' . $acm_type . '.' . $phpEx);
require($phpbb_root_path . 'includes/cache.' . $phpEx);
require($phpbb_root_path . 'includes/constants.' . $phpEx);
require($phpbb_root_path . 'includes/db/' . $dbms . '.' . $phpEx);
require($phpbb_root_path . 'includes/functions.' . $phpEx);
$cache = new cache();
$db = new $sql_db();
$db->sql_connect($dbhost, $dbuser, $dbpasswd, $dbname, $dbport, false, defined('PHPBB_DB_NEW_LINK') ? PHPBB_DB_NEW_LINK : false);
unset($dbpasswd);
$config = $cache->obtain_config();

// Automatically install or update if required
if (!isset($config['ads_version']) || $config['ads_version'] != $ads_version)
{
	require($phpbb_root_path . 'ads/update.' . $phpEx);
}

if (!$config['ads_enable'])
{
	exit;
}

// Get some variables
$position = request_var('p', 0);
$forum_id = request_var('f', 0);
$user_id = request_var('u', 0); // This will have to be sent with the url, otherwise it would require we initialize a session.  If nothing is sent we will just ignore the groups stuff

// Set some variables up
$ignore_ads = $available_ads = $id_list = array();

if ($user_id)
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
}

$sql = 'SELECT * FROM ' . ADS_TABLE . '
	WHERE ad_position = ' . $position .
	((sizeof($ignore_ads)) ? ' AND ' . $db->sql_in_set('ad_id', $ignore_ads, true) : '');
$result = $db->sql_query($sql);
while ($row = $db->sql_fetchrow($result))
{
	$available_ads[] = $row;

	// A simple way to set Advertisement Priority
	for ($i = 0; $i < $row['ad_priority']; $i++)
	{
		$id_list[] = $row['ad_id'];
	}
}

if (sizeof($available_ads))
{
	$ad_id = $id_list[rand(0, sizeof($id_list) - 1)];
	echo "document.write('" . htmlspecialchars_decode($available_ads[$ad_id]['ad_code']) . "');";
}

// Debug
//echo '<br /><br />' . (microtime() - $start_time);

?>