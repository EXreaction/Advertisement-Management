<?php
/**
*
* @package phpBB3 Advertisement Management
* @version $Id$
* @copyright (c) 2008 EXreaction, Lithium Studios
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

// We need to have an ad_id
$ad_id = (isset($_GET['a'])) ? (int) $_GET['a'] : 0;
if ($ad_id <= 0)
{
	exit('0');
}

define('IN_PHPBB', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : '../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
require($phpbb_root_path . 'config.' . $phpEx);
require($phpbb_root_path . 'includes/constants.' . $phpEx);
require($phpbb_root_path . 'ads/constants.' . $phpEx);
require($phpbb_root_path . 'includes/db/' . $dbms . '.' . $phpEx);
$db = new $sql_db();

$db->sql_connect($dbhost, $dbuser, $dbpasswd, $dbname, $dbport, false, defined('PHPBB_DB_NEW_LINK') ? PHPBB_DB_NEW_LINK : false);
unset($dbpasswd);

$db->sql_query('UPDATE ' . ADS_TABLE . ' SET ad_views = ad_views + 1 WHERE ad_id = ' . $ad_id);

$db->sql_close();

exit('1');

?>