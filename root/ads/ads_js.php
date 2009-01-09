<?php
/**
*
* @package phpBB3 Advertisement Management
* @version $Id: ads.php 72 2008-12-04 21:36:26Z exreaction@gmail.com $
* @copyright (c) 2008 EXreaction, Lithium Studios
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/*
* Notes:
*  Accurate ad views does not work when linking to this file to show the ads.
*  The URL should look something like:
*   http://lithiumstudios.org/ads/ads.php?p=position_id&f=forum_id&u=user_id
*  The Javascript code should look like this:
*	<script src="http://lithiumstudios.org/ads/ads.php?p=position_id&f=forum_id&u=user_id"></script>
*
* Be warned that this won't work with certain advertisements (like ones that already output via javascript such as Adsense).
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
require($phpbb_root_path . 'ads/constants.' . $phpEx);
require($phpbb_root_path . 'includes/db/' . $dbms . '.' . $phpEx);
require($phpbb_root_path . 'includes/functions.' . $phpEx);
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
	echo 'document.write(\'' . 	$ads[$position_id] . '\')';
}

garbage_collection();
exit_handler();

?>