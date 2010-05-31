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
*	<script src="http://lithiumstudios.org/ads/ads_js.php?p=position_id&f=forum_id&u=user_id"></script>
*
* Be warned that this won't work with certain advertisements (like ones that already output via javascript such as Adsense).
*/

$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : '../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);

define('OUTPUT_ADS_JS', true);

require($phpbb_root_path . 'ads/ads.' . $phpEx);