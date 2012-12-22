<?php
/**
*
* info_acp_admin_notepad [English]
*
* @package language
* @version $Id: info_acp_inactive_users.php 10-10-2009 20:52:37 Waleed $
* @copyright (c) 2009 Waleed Zuberi http://waleed.doubleudesigns.com/
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* DO NOT CHANGE
*/
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// ACP Notepad MOD 2.2.2
$lang = array_merge($lang, array(
	'ACP_NOTEPAD_ERROR'	=> 'I could not understand which note you want to delete from the ACP Notepad. Please go back and try again.',

	'ADMIN_NOTEPAD'                => 'ACP Notepad',
	'ADMIN_NOTEPAD_TITLE'          => 'ACP Notepad 2.2.2',
	'ADMIN_NOTEPAD_EXPLAIN'        => 'Welcome to the ACP Notepad. You can use this module to save notes for yourself to read later, or for other Administrators. To make private notes, which only you will be able to read, just check the box labeled ‘Make this note private’ when saving or editing a message in the fields below. <br /> <br />The dropdown box below shows previous messages (newest first) and you can choose to read or delete them. You can edit previous entries by opening the note and clicking on <em>Edit</em> in the reading pane. You can save new messages by filling in the form below and clicking <em>Save new</em>.<br /><br />Note that messages once deleted cannot be restored.',
	'ADMIN_NOTEPAD_SUBJECT'        => 'Subject',
	'ADMIN_NOTEPAD_MESSAGE'        => 'Message',
	'ADMIN_NOTEPAD_PREVIOUS_MSG'   => 'Previous Messages (newest first):',
	'ADMIN_NOTEPAD_DELETE'         => 'Delete',
	'ADMIN_NOTEPAD_DELETE_ALL'     => 'Delete all',
	'ADMIN_NOTEPAD_EDIT'           => 'Edit',
	'ADMIN_NOTEPAD_READ'           => 'Read',
	'ADMIN_NOTEPAD_SAVE'           => 'Save new',
	'ADMIN_NOTEPAD_SAVE_EDITED'    => 'Save edited',
	'ADMIN_NOTEPAD_LOG_DELETE_MSG' => '<b>Deleted message</b> from ACP Notepad titled<br />&#187; %s',
	'ADMIN_NOTEPAD_LOG_DELETE_ALL' => '<b>Deleted all messages</b> from the ACP Notepad',

	'DELETE_ALL_CONFIRM'   => 'Are you sure you want to delete all messages from the ACP Notepad? This will permanently delete all public notes and any notes that you may have set as private.',
	'DELETE_CONFIRM'       => 'Are you sure you want to delete the selected message from the ACP Notepad?',
	'DIRECT_LINK'          => 'direct link to this post',

	'EDITED_BY'            => 'Edited by',

	'INFO_SAVE_DONE'       => 'Message saved successfully',
	'INFO_DELETE_DONE'     => 'Message deleted successfully',
	'INFO_DELETES_DONE'    => 'All messages were deleted from the ACP Notepad successfully',
	'INFO_EDIT_DONE'       => 'Message edited successfully',
	'INFO_NO_SUBJECT'      => 'No subject was entered.',
	'INFO_NO_MESSAGE'      => 'No message was entered.',

	'MAKE_PRIV'        => 'Make this note private (only visible to you)',

	'NONE_FOUND'       => '<p><em>No previously saved messages found.</em> You can create a new note below.</p>',
	'NOT_EXIST'        => 'The requested message does not exist.',
	'NOTIFY_PRIV'      => '<strong>NOTE:</strong> This message is set as private, and only you may see it.',

	'ON'               => 'on',

	'POSTED_BY'        => 'Posted by',
	'THE_AUTHOR'       => ' the author',
	'UNTITLED'         => 'Untitled',
	'YOU'              => 'you',
));

?>