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
* @package module_install
*/
class acp_ads_info
{
	function module()
	{
		return array(
			'filename'	=> 'acp_ads',
			'title'		=> 'ACP_ADVERTISEMENT_MANAGEMENT',
			'version'	=> '1.0.0',
			'modes'		=> array(
				'default'		=> array('title' => 'ACP_ADVERTISEMENT_MANAGEMENT', 'auth' => 'acl_a_ads', 'cat' => array('ACP_BOARD_CONFIGURATION')),
			),
		);
	}

	function install()
	{
	}

	function uninstall()
	{
	}
}

?>