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
* Send the following variables
*
* $position_id
* $forum_id
* $user_id
*/
$position_id = (int) (isset($position_id)) ? $position_id : ((isset($_GET['p'])) ? $_GET['p'] : 0);
$forum_id = (int) (isset($forum_id)) ? $forum_id : ((isset($_GET['f'])) ? $_GET['f'] : 0);
$user_id = (int) (isset($user_id)) ? $user_id : ((isset($_GET['u'])) ? $_GET['u'] : 0);

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
require($phpbb_root_path . 'ads/constants.' . $phpEx);
require($phpbb_root_path . 'includes/db/' . $dbms . '.' . $phpEx);
require($phpbb_root_path . 'ads/functions.' . $phpEx);

$cache = new cache();
$db = new $sql_db();

// Connect to DB
$db->sql_connect($dbhost, $dbuser, $dbpasswd, $dbname, $dbport, false, defined('PHPBB_DB_NEW_LINK') ? PHPBB_DB_NEW_LINK : false);

// We do not need this any longer, unset for safety purposes
unset($dbpasswd);

// Grab global variables, re-cache if necessary
$config = $cache->obtain_config();

$ads = get_ads($user_id, $forum_id, false);

if (isset($ads[$position_id]))
{
	echo $ads[$position_id];
}

$cache->unload();
$db->sql_close();

(empty($config['gzip_compress'])) ? @flush() : @ob_flush();

exit;