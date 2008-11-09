<?php
/**
*
* @package phpBB3 Advertisement Management
* @version $Id$
* @copyright (c) 2008 EXreaction, Lithium Studios
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

if (!defined('ADS_TABLE'))
{
	global $table_prefix;

	define('ADS_TABLE',					$table_prefix . 'ads');
	define('ADS_FORUMS_TABLE',			$table_prefix . 'ads_forums');
	define('ADS_GROUPS_TABLE',			$table_prefix . 'ads_groups');
	define('ADS_IN_POSITIONS_TABLE',	$table_prefix . 'ads_in_positions');
	define('ADS_POSITIONS_TABLE',		$table_prefix . 'ads_positions');
}
?>