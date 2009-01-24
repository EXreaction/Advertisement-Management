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
	'ADVERTISEMENT_MANAGEMENT_CREDITS'		=> 'Advertisements by <a href="http://www.lithiumstudios.org/">Advertisement Management</a>',

	// Default Positions
	'ABOVE_FOOTER'			=> 'Above Footer',
	'ABOVE_HEADER'			=> 'Above Header',
	'ABOVE_POSTS'			=> 'Above Posts',
	'AFTER_EVERY_POST'		=> 'After Every Post Except First',
	'AFTER_FIRST_POST'		=> 'After First Post',
	'BELOW_FOOTER'			=> 'Below Footer',
	'BELOW_HEADER'			=> 'Below Header',
	'BELOW_POSTS'			=> 'Below Posts',

	// ACP
	'0_OR_NA'									=> '0 or N/A',

	'ACP_ADVERTISEMENT_MANAGEMENT_EXPLAIN'		=> 'Here you can change the Advertisement Management Settings, Add/Remove/Edit Advertisement Positions, and Add/Remove/Edit Advertisements.',
	'ACP_ADVERTISEMENT_MANAGEMENT_SETTINGS'		=> 'Advertisement Management Settings',
	'ADS_ACCURATE_VIEWS'						=> 'Accurate View Counts',
	'ADS_ACCURATE_VIEWS_EXPLAIN'				=> 'Makes counting of Ad Views much more accurate, but increases server load.',
	'ADS_COUNT_CLICKS'							=> 'Count Ad Clicks',
	'ADS_COUNT_CLICKS_EXPLAIN'					=> 'If set to no, advertisement clicks will not be counted (less server load).',
	'ADS_COUNT_VIEWS'							=> 'Count Ad Views',
	'ADS_COUNT_VIEWS_EXPLAIN'					=> 'If set to no, advertisement views will not be counted (less server load).',
	'AD_CREATED'								=> 'Ad Created',
	'ADS_ENABLE'								=> 'Enable Advertisements',
	'ADS_RULES_FORUMS'							=> 'Use Forum Rules for Ads',
	'ADS_RULES_FORUMS_EXPLAIN'					=> 'If enabled, it allows you to control which forums each advertisement is displayed in.  If you do not plan on using this you should set this to no so it uses less resources.',
	'ADS_RULES_GROUPS'							=> 'Use Group Rules for Ads',
	'ADS_RULES_GROUPS_EXPLAIN'					=> 'If enabled, it allows you to control which groups do/don\'t see specific advertisements.  If you do not plan on using this you should set this to no so it uses less resources.',
	'ADS_VERSION'								=> 'Advertisement Management Version',
	'ADVERTISEMENT'								=> 'Advertisement',
	'ADVERTISEMENT_MANAGEMENT_UPDATE_SUCCESS'	=> 'The Advertisement Management settings have been updated successfully!',
	'AD_ADD_SUCCESS'							=> 'Advertisement Added Successfully!',
	'AD_CLICK_LIMIT'							=> 'Ad Clicks Limit',
	'AD_CLICK_LIMIT_EXPLAIN'					=> '0 to disable, otherwise the ad will become disabled after this number of clicks.',
	'AD_CLICKS'									=> 'Ad Clicks',
	'AD_CLICKS_EXPLAIN'							=> 'The current number of clicks for this advertisement (if setup correctly).',
	'AD_CODE'									=> 'Ad Code',
	'AD_CODE_EXPLAIN'							=> 'The Advertisement code you would like shown goes here.  All code should be put in a raw HTML form, BBcodes are not supported.<br /><strong>If you would like to enable the click counter, use the {COUNT_CLICK} in any place where the onclick attribute is allowed (the a tag for example).</strong>',
	'AD_EDIT_SUCCESS'							=> 'Advertisement Edited Successfully!',
	'AD_ENABLED'								=> 'Ad Enabled',
	'AD_ENABLED_EXPLAIN'						=> 'Uncheck to disable this advertisement from displaying.',
	'AD_FORUMS'									=> 'Forum List',
	'AD_FORUMS_EXPLAIN'							=> 'Select the forums where you would like this ad to be displayed.  You may select multiple forums by holding down the CTRL key.',
	'AD_GROUPS'									=> 'Groups',
	'AD_GROUPS_EXPLAIN'							=> 'Select the groups you do <strong>NOT</strong> want this advertisement to be shown to.  You may select multiple groups by holding the CTRL key while clicking more groups.',
	'AD_LIST_NOTICE'							=> 'Ad Clicks will only be available if you used the {COUNT_CLICK} in a place that works with the onclick attribute.',
	'AD_MAX_VIEWS'								=> 'Max Views',
	'AD_MAX_VIEWS_EXPLAIN'						=> 'The maximum views before this advertisement will no longer be shown. <strong>0 means no max limit</strong>.',
	'AD_NAME'									=> 'Ad Name',
	'AD_NAME_EXPLAIN'							=> 'This is only used for your recognition of the ad.',
	'AD_NOT_EXIST'								=> 'The selected advertisement does not exist.',
	'AD_NOTE'									=> 'Ad Notes',
	'AD_NOTE_EXPLAIN'							=> 'Enter any notes for this advertisement if you\'d like.  These notes are not shown anywhere except in the ACP.',
	'AD_POSITIONS'								=> 'Positions',
	'AD_POSITIONS_EXPLAIN'						=> 'Select the positions where you would like this advertisement to show.',
	'AD_PRIORITY'								=> 'Ad Priority',
	'AD_PRIORITY_EXPLAIN'						=> 'The higher the number the more likely the advertisement will be displayed.  For example, an ad with a priority of 2 will be 2x as likely as an ad with a priority of 1 to be shown, 3 would be 3x as likely, etc, etc.',
	'AD_TIME_END'								=> 'Run until',
	'AD_TIME_END_BEFORE_NOW'					=> 'The end time you entered is before the time right now.  Please make sure you are using a strtotime compatible date.',
	'AD_TIME_END_EXPLAIN'						=> 'Enter a valid date to end the advertisement at.  After the entered time the ad will be disabled automatically.  Note that this uses the PHP <a href="http://us2.php.net/manual/en/function.strtotime.php">strtotime</a> function, so be sure to format it correctly or it will not be set.<br /><br /><strong>This end date is not entirely accurate with timezones and such, so exact times should not be relied on.  It is recommended that you plan on an accuracy of within 1 day of the given time.</strong>',
	'AD_VIEW_LIMIT'								=> 'Ad Views Limit',
	'AD_VIEW_LIMIT_EXPLAIN'						=> '0 to disable, otherwise the ad will become disabled after this number of views.',
	'AD_VIEWS'									=> 'Ad Views',
	'AD_VIEWS_EXPLAIN'							=> 'The current number of views of this advertisement.',
	'ALL_FORUMS_EXPLAIN'						=> 'Select to show in all forums and pages.  Note that if this is unchecked the advertisement will not show on non-forum related pages (like the FAQ page for example).',

	'CREATE_AD'									=> 'Create Ad',
	'CREATE_POSITION'							=> 'Create Position',

	'DELETE_AD'									=> 'Delete Advertisement',
	'DELETE_AD_CONFIRM'							=> 'Are you sure you want to remove this advertisement?',
	'DELETE_AD_SUCCESS'							=> 'The advertisement has been successfully deleted!',
	'DELETE_POSITION'							=> 'Delete Position',
	'DELETE_POSITION_CONFIRM'					=> 'Are you sure you want to remove this position?  If you remove a position, any advertisements that were shown in that position will no longer be shown.',
	'DELETE_POSITION_SUCCESS'					=> 'The position has been successfully deleted!',

	'FALSE'										=> 'False',

	'NO_ADS_CREATED'							=> 'No Ads Created',
	'NO_AD_NAME'								=> 'You must set a name for the advertisement.',
	'NO_POSITIONS_CREATED'						=> 'No Positions Created',

	'POSITION'									=> 'Position',
	'POSITION_CODE'								=> 'Position Code',
	'POSITION_EDIT_SUCCESS'						=> 'Position Edited Successfully!',
	'POSITION_NAME'								=> 'Position Name',
	'POSITION_NAME_EXPLAIN'						=> 'The name of the position.',
	'POSITION_NOT_EXIST'						=> 'The selected position does not exist.',
	'POSTITION_ADD_SUCCESS'						=> 'Position Added Successfully!',
	'POSTITION_ALREADY_EXIST'					=> 'You already have a position by that name.',

	'TRUE'										=> 'True',
));

?>