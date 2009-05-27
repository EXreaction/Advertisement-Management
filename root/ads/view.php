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

$sql = 'SELECT * FROM ' . ADS_TABLE . ' WHERE ad_id = ' . $ad_id;
$result = $db->sql_query($sql);
$row = $db->sql_fetchrow($result);
$db->sql_freeresult($result);

if ($row)
{
	$db->sql_query('UPDATE ' . ADS_TABLE . ' SET ad_views = ad_views + 1 WHERE ad_id = ' . $row['ad_id']);

	if ($row['ad_view_limit'] != 0 && ($row['ad_views'] + 1) >= $row['ad_view_limit'])
	{
		$db->sql_query('UPDATE ' . ADS_TABLE . ' SET ad_enabled = 0 WHERE ad_id = ' . $row['ad_id']);
		$db->sql_query('UPDATE ' . ADS_IN_POSITIONS_TABLE . ' SET ad_enabled = 0 WHERE ad_id = ' . $row['ad_id']);
	}
}

$db->sql_close();

// Make sure the browser does not cache this
header('Content-type: text/html; charset=UTF-8');
header('Cache-Control: private, no-cache="set-cookie"');
header('Expires: 0');
header('Pragma: no-cache');

exit('1');

?>