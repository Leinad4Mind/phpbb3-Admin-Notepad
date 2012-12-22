<?php
/**
 *
 * @author WileCoyote office@wu-systems.at
 * @version $Id$
 * @copyright (c) 2009 Waleed Zuberi http://waleed.doubleudesigns.com/
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */

/**
 * @ignore
 */
define('UMIL_AUTO', true);
define('IN_PHPBB', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);

// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup();


if (!file_exists($phpbb_root_path . 'umil/umil_auto.' . $phpEx))
{
	trigger_error('Please download the latest UMIL (Unified MOD Install Library) from: <a href="http://www.phpbb.com/mods/umil/">phpBB.com/mods/umil</a>', E_USER_ERROR);
}

// The name of the mod to be displayed during installation.
$mod_name = 'ADMIN_NOTEPAD';

/*
* The name of the config variable which will hold the currently installed version
* UMIL will handle checking, setting, and updating the version itself.
*/
$version_config_name = 'admin_notepad_version';


// The language file which will be included when installing
$language_file = 'mods/info_acp_admin_notepad';


/*
* Optionally we may specify our own logo image to show in the upper corner instead of the default logo.
* $phpbb_root_path will get prepended to the path specified
* Image height should be 50px to prevent cut-off or stretching.
*/
//$logo_img = 'styles/prosilver/imageset/site_logo.gif';

/*
* The array of versions and actions within each.
* You do not need to order it a specific way (it will be sorted automatically), however, you must enter every version, even if no actions are done for it.
*
* You must use correct version numbering.  Unless you know exactly what you can use, only use X.X.X (replacing X with an integer).
* The version numbering must otherwise be compatible with the version_compare function - http://php.net/manual/en/function.version-compare.php
*/
$versions = array(
	'2.2.0' => array(

		'table_add' => array(
			array('phpbb_admin_notepad', array(
				'COLUMNS' => array(
					'note_id' => array('UINT', NULL, 'auto_increment'),
					'note_subject' => array('XSTEXT_UNI', ''),
					'note_message' => array('MTEXT', ''),
					'note_poster_name' => array('VCHAR', ''),
					'note_poster_id' => array('UINT', 0),
					'note_post_time' => array('TIMESTAMP', 0),
					'note_bbcode_uid' => array('VCHAR:8', ''),
					'note_bbcode_bitfield' => array('VCHAR', ''),
					'note_edit_by' => array('VCHAR', 0),
					'note_edit_by_id' => array('UINT', 0),
					'note_edit_time' => array('TIMESTAMP', 0),
					'note_is_private' => array('TINT:1', 0),
				),

				'PRIMARY_KEY'	=> 'note_id',

				'KEYS'		=> array(
					'poster_id' => array('INDEX', 'note_poster_id'),
				),
			)),

		),

    	'module_add' => array(
    		array('acp', 'ACP_QUICK_ACCESS', array(
                    'module_basename'	=> 'ADMIN_NOTEPAD'),
    		),
        ),
	),

	// Version 2.2.1
	'2.2.1'	=> array(
	),

	// Version 2.2.2
	'2.2.2'	=> array(
	),
);

// Include the UMIL Auto file, it handles the rest
include($phpbb_root_path . 'umil/umil_auto.' . $phpEx);

//Clear cache
$umil->cache_purge(array(
	array(''),
	array('auth'),
	array('template'),
	array('theme'),
));
