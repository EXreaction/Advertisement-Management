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
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	// Positions
	'ABOVE_HEADER'		=> 'Above Header',
	'BELOW_HEADER'		=> 'Below Header',
	'ABOVE_POSTS'		=> 'Above Posts',
	'BELOW_POSTS'		=> 'Below Posts',
	'AFTER_FIRST_POST'	=> 'After First Post',
	'AFTER_EVERY_POST'	=> 'After Every Post',
	'ABOVE_FOOTER'		=> 'Above Footer',
	'BELOW_FOOTER'		=> 'Below Footer',

	// ACP
	'ADS_ENABLE'								=> 'Enable Advertisements',
	'ACP_ADVERTISEMENT_MANAGEMENT_EXPLAIN'		=> 'Here you can change the Advertisement Management Settings, Add/Remove/Edit Advertisement Positions, and Add/Remove/Edit Advertisements.',
	'ACP_ADVERTISEMENT_MANAGEMENT_SETTINGS'		=> 'Advertisement Management Settings',
	'ADVERTISEMENT_MANAGEMENT_UPDATE_SUCCESS'	=> 'The Advertisement Management settings have been updated successfully!',

	'CREATE_POSITION'							=> 'Create Position',
	'POSITION_NAME'								=> 'Position Name',
	'NO_POSITIONS_CREATED'						=> 'No Positions Created',
	'POSTITION_ADD_SUCCESS'						=> 'Position Added Successfully!',
	'POSTITION_ALREADY_EXIST'					=> 'You already have a position by that name.',

	'CREATE_AD'									=> 'Create Ad',
	'AD_NAME'									=> 'Ad Name',
	'NO_ADS_CREATED'							=> 'No Ads Created',
	'AD_ADD_SUCCESS'							=> 'Advertisement Added Successfully!',
));

?>