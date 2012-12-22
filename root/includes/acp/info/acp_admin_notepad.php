<?php
/** 
*
* acp_admin_notepad
* 
* @package acp
* @version $Id: acp_inactive_users.php 10-10-2009 20:52:37 Waleed $
* @copyright (c) 2009 Waleed Zuberi http://waleed.doubleudesigns.com/
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
* @package module_install
*/
class acp_admin_notepad_info
{
	function module()
	{
		return array(
			'filename'	=> 'acp_admin_notepad',
			'title'		=> 'ADMIN_NOTEPAD',
			'version'	=> '2.2.2',
			'modes'		=> array(
				'main'		=> array('title' => 'ADMIN_NOTEPAD', 'auth' => '', 'cat' => 'ADMIN_NOTEPAD')
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