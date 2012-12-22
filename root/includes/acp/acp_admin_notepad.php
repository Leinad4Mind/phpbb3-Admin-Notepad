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
* 
* todo:
* - list for selective mass deletion of acp notes
*/

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
* @package acp
*/
class acp_admin_notepad
{
	var $u_action;
	var $new_config;

	function main($id, $mode)
	{
		global $db, $user, $template;
		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;

		$error = $notify = array();
		
		include($phpbb_root_path . 'includes/message_parser.'.$phpEx);
		$user->add_lang('posting');
		
		// confirm type (for deleting) is set when confirm_box is made false
		$confirm_type = request_var('confirm_type', 'default');

		$msg_box_options = '';
			
		$sql = 'SELECT note_id, note_subject, note_message, note_poster_id, note_is_private
			FROM ' . ADMIN_NOTEPAD_TABLE . '
			ORDER BY note_id DESC';
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			if (($row['note_is_private'] && $row['note_poster_id'] == $user->data['user_id']) || !$row['note_is_private'])
			{
			    $msg_box_options .= '<option value="' . $row['note_id'] . '">' . $row['note_subject'] . "</option>\n";
			}
		}
		$db->sql_freeresult($result);
				
		$s_delete_all = ($msg_box_options) ? true : false;
		$msg_box_options = '<select name="read_msg">' . $msg_box_options . '</select>';
			
		$template->assign_vars(array(
			'PREVIOUS_MSG_BOX_OPTIONS'	=> $msg_box_options,
			'U_ADMIN_NOTEPAD'			=> $this->u_action,
			'S_ENABLE_DROPDOWN'			=> $s_delete_all,
		));

		$this->tpl_name      = 'acp_admin_notepad';
		$this->page_title    = 'ADMIN_NOTEPAD';
		
		include_once($phpbb_root_path . 'includes/functions_display.' . $phpEx);
		display_custom_bbcodes();
		
		// var for direct access to a note
		$msg_id = request_var('msg_id', 0);
		
		// check if user is requesting a post directly
		if ($msg_id)
		{
			$sql = 'SELECT *
				FROM ' . ADMIN_NOTEPAD_TABLE . '
				WHERE note_id = ' . $msg_id;

			$results = $db->sql_query($sql);
			$row     = $db->sql_fetchrow($results);
			$db->sql_freeresult($results);
			
			// if requested message does not exist, print error message
			if (!isset($row))
			{
				trigger_error($user->lang['NOT_EXIST'] . adm_back_link($this->u_action), E_USER_WARNING);
			}
			
			// if requested message is private to another admin, spit 'does not exist' error
			if ($row['note_is_private'] && $row['note_poster_id'] != $user->data['user_id'] )
			{
				trigger_error($user->lang['NOT_EXIST'] . adm_back_link($this->u_action), E_USER_WARNING);
			}
			
			$flags = (($config['allow_bbcode']) ? 1 : 0) + (($config['allow_smilies']) ? 2 : 0) + ((true) ? 4 : 0);
			$message = generate_text_for_display($row['note_message'], $row['note_bbcode_uid'], $row['note_bbcode_bitfield'], $flags);
			
			// make 'edited by' smarter
			$edited_by = ($row['note_edit_by_id'] == $row['note_poster_id']) ? $user->lang['THE_AUTHOR'] : (($row['note_edit_by_id'] == $user->data['user_id']) ? $user->lang['YOU'] : $row['note_edit_by']);
			
			// get user color
			$colour = 'SELECT user_colour FROM ' . USERS_TABLE . '
				WHERE user_id = ' . $row['note_poster_id'];
			$colour_results = $db->sql_query($colour);
			$poster_colour	= $db->sql_fetchfield('user_colour');
			$db->sql_freeresult($colour_results);
			
			$template->assign_vars(array(
				'S_NOTEPAD_READ'	=> true,
				'MSG_ID'			=> $msg_id,
				'POSTER'			=> get_username_string('full', $row['note_poster_id'], $row['note_poster_name'], $poster_colour),
				'POST_TIME'			=> $user->format_date($row['note_post_time']),
				'S_EDITED'			=> ($row['note_edit_time'] != '0') ? true : false,
				'EDITED_BY'			=> $edited_by,
				'EDITED_BY_ID'		=> $row['note_edit_by_id'],
				'EDITED_TIME'		=> $user->format_date($row['note_edit_time']),
				'NOTEPAD_SUBJECT'	=> '<a href="' . $this->u_action . '&amp;msg_id=' . $row['note_id'] . '" title="' . $user->lang['DIRECT_LINK'] . '">' . $row['note_subject'] . '</a>',
				'NOTEPAD_TEXT'		=> $message,
				'S_IS_AUTHOR'		=> ($user->data['user_id'] == $row['note_poster_id']) ? true : false,
				'S_IS_PRIV'			=> ($row['note_is_private']) ? true : false,
			));
		}
			
		/* if the user wants to read a message */
		if (isset($_REQUEST['read']))
		{
			// get requested message id
			$selected_msg = request_var('read_msg', 0);

			$sql = 'SELECT *
				FROM ' . ADMIN_NOTEPAD_TABLE . '
				WHERE note_id =' . $selected_msg;

			$results = $db->sql_query($sql);
			$row     = $db->sql_fetchrow($results);
			$db->sql_freeresult($results);
			
			// if requested message is private to another admin, spit 'does not exist' error
			if ($row['note_is_private'] && $row['note_poster_id'] != $user->data['user_id'])
			{
				trigger_error($user->lang['NOT_EXIST'] . adm_back_link($this->u_action), E_USER_WARNING);
			}
			
			$flags = (($config['allow_bbcode']) ? 1 : 0) + (($config['allow_smilies']) ? 2 : 0) + ((true) ? 4 : 0);
			$message = generate_text_for_display($row['note_message'], $row['note_bbcode_uid'], $row['note_bbcode_bitfield'], $flags);
			
			// make 'edited by' smarter
			$edited_by = ($row['note_edit_by_id'] == $row['note_poster_id']) ? $user->lang['THE_AUTHOR'] : (($row['note_edit_by_id'] == $user->data['user_id']) ? $user->lang['YOU'] : $row['note_edit_by']);

			// get user color
			$colour = 'SELECT user_colour FROM ' . USERS_TABLE . '
				WHERE user_id = ' . $row['note_poster_id'];
			$colour_results = $db->sql_query($colour);
			$poster_colour	= $db->sql_fetchfield('user_colour');
			$db->sql_freeresult($colour_results);
			
			$template->assign_vars(array(
				'S_NOTEPAD_READ'	=> true,
				'MSG_ID'			=> $selected_msg,
				'POSTER'			=> get_username_string('full', $row['note_poster_id'], $row['note_poster_name'], $poster_colour),
				'POST_TIME'			=> $user->format_date($row['note_post_time']),
				'S_EDITED'			=> ($row['note_edit_time'] != '0') ? true : false,
				'EDITED_BY'			=> $edited_by,
				'EDITED_BY_ID'		=> $row['note_edit_by_id'],
				'EDITED_TIME'		=> $user->format_date($row['note_edit_time']),
				'NOTEPAD_SUBJECT'	=> '<a href="' . $this->u_action . '&amp;msg_id=' . $row['note_id'] . '" title="' . $user->lang['DIRECT_LINK'] . '">' . $row['note_subject'] . '</a>',
				'NOTEPAD_TEXT'		=> $message,
				'S_IS_AUTHOR'		=> ($user->data['user_id'] == $row['note_poster_id']) ? true : false,
				'S_IS_PRIV'			=> ($row['note_is_private']) ? true : false,
			));
		}

		/* if the user wants to edit an existing message */
		else if (isset($_REQUEST['edit']))
		{
			// get requested message id
			$selected_msg = request_var('read_msg', 0);

			$sql = 'SELECT note_id, note_subject, note_message, note_bbcode_uid, note_bbcode_bitfield, note_is_private, note_poster_id
				FROM ' . ADMIN_NOTEPAD_TABLE . '
				WHERE note_id = ' . $selected_msg;
			$results = $db->sql_query($sql);
			$row = $db->sql_fetchrow($results);
			$db->sql_freeresult($result);
			
			// if requested message is private to another admin, spit 'does not exist' error
			if ($user->data['user_id'] != $row['note_poster_id'] && $row['note_is_private'])
			{
				trigger_error($user->lang['NOT_EXIST'] . adm_back_link($this->u_action), E_USER_WARNING);
			}
			
			decode_message($row['note_message'], $row['note_bbcode_uid']);

			$template->assign_vars(array(
				'MSG_ID'			=> $row['note_id'],
				'SUBJECT'			=> $row['note_subject'],
				'MESSAGE'			=> $row['note_message'],
				'S_EDIT_MSG'		=> true,
				'S_NOTEPAD_READ'	=> false,
				'S_IS_PRIV_CHK'		=> ($row['note_is_private']) ? true : false,
				'S_IS_AUTHOR'		=> ($user->data['user_id'] == $row['note_poster_id']) ? true : false,
			));
		}

		/* save edited message */
		else if (isset($_REQUEST['save-edited']))
		{
			$id = request_var('msg_id', 0);
			$subject = utf8_normalize_nfc(request_var('subject', '', true));
			$message = utf8_normalize_nfc(request_var('message', '', true));
			
			// $make_priv = request_var('make_private', '0');
			$make_priv = isset($_REQUEST['make_private']) ? true : false; 
	
			if (!$subject)
			{
				trigger_error($user->lang['INFO_NO_SUBJECT'] . adm_back_link($this->u_action));
			}
			else if (!$message)
			{
				trigger_error($user->lang['INFO_NO_MESSAGE'] . adm_back_link($this->u_action));
			}
			
			$uid = $bitfield = $options = ''; 
			
			generate_text_for_storage($subject, $uid, $bitfield, $options, false, false, true);
			generate_text_for_storage($message, $uid, $bitfield, $options, true, true, true);

			$edited_by = $user->data['username'];
			$edited_by_id = $user->data['user_id'];
			$edited_time = time();
	                
			$save_edited_sql = array(
				'note_subject'			=> $subject,
				'note_message'			=> $message,
				'note_bbcode_uid'		=> $uid,
				'note_bbcode_bitfield'	=> $bitfield,
				'note_edit_by'			=> $edited_by,
				'note_edit_by_id'		=> $edited_by_id,
				'note_edit_time'		=> $edited_time,
				'note_is_private'		=> $make_priv,
			);
				
			$sql = 'UPDATE ' . ADMIN_NOTEPAD_TABLE . ' SET ' . $db->sql_build_array('UPDATE', $save_edited_sql) . ' WHERE note_id=' . $id . ' LIMIT 1';
			$db->sql_query($sql);
			
			trigger_error($user->lang['INFO_EDIT_DONE'] . adm_back_link($this->u_action . '&amp;msg_id=' . $id));
		}

		/* save a new message */
		else if (isset($_REQUEST['add']))
		{
			$id = request_var('msg_id', 0);
			$subject = utf8_normalize_nfc(request_var('subject', '', true));
			$message = utf8_normalize_nfc(request_var('message', '', true));
			
			$make_priv = isset($_REQUEST['make_private']) ? true : false;

			if (!$message)
			{
				trigger_error($user->lang['INFO_NO_MESSAGE'] . adm_back_link($this->u_action));
			}
			
			$uid = $bitfield = $options = ''; 
			
			generate_text_for_storage($subject, $uid, $bitfield, $options, false, false, false);
			generate_text_for_storage($message, $uid, $bitfield, $options, true, true, true);
                    
			$save_new_sql = array(
				'note_subject'			=> ($subject) ? $subject : $user->lang['UNTITLED'],
				'note_message'			=> $message,
				'note_poster_name'		=> $user->data['username'],
				'note_poster_id'		=> $user->data['user_id'],
				'note_post_time'		=> time(),
				'note_bbcode_uid'		=> $uid,
				'note_bbcode_bitfield'	=> $bitfield,
				'note_is_private'		=> $make_priv,
			);
					
			$sql = 'INSERT INTO ' . ADMIN_NOTEPAD_TABLE . ' ' . $db->sql_build_array('INSERT', $save_new_sql);
			$db->sql_query($sql);
	   
			trigger_error($user->lang['INFO_SAVE_DONE'] . adm_back_link($this->u_action . '&amp;msg_id=' . $db->sql_nextid()));
		}

		/* if the user wants to delete a message */
		else if (isset($_REQUEST['delete']))
		{
			$note_id = request_var('read_msg', 0);
			confirm_box(false, $user->lang['DELETE_CONFIRM'], build_hidden_fields(array(
				'delete_id' => $note_id,
				'confirm_type' => 'single' )
			));
		}
			
		/* if user wants to delete *all* messages */
		else if (isset($_REQUEST['delete-all']))
		{
			confirm_box(false, $user->lang['DELETE_ALL_CONFIRM'], build_hidden_fields(array('confirm_type' => 'all')));
		}
		
		// if confirmed, check whats going on
		if (confirm_box(true))
		{
			// confirm deletion of selected message
			if ($confirm_type == 'single')
			{
				$delete_id = request_var('delete_id', 0);
				
				// fetch is_private data for message being deleted
				// just to be safe
				$sql = 'SELECT note_poster_id, note_is_private
					FROM ' . ADMIN_NOTEPAD_TABLE . '
					WHERE note_id = ' . $delete_id;
				$results = $db->sql_query($sql);
				$row = $db->sql_fetchrow($results);
				
				// if message being deleted is private to another admin, spit 'does not exist' error
				if ($user->data['user_id'] != $row['note_poster_id'] && $row['note_is_private'])
				{
					trigger_error($user->lang['NOT_EXIST'] . adm_back_link($this->u_action), E_USER_WARNING);
				}
				$db->sql_freeresult($results);
           
				// add a Log entry when deleting a message
				// if note is not private, fetch subject for log
				if (!$row['note_is_private'])
				{ 
					// get subject of deleted message
					$getsubj = 'SELECT note_subject
						FROM ' . ADMIN_NOTEPAD_TABLE . '
						WHERE note_id = ' . $delete_id;
					$getsubj = $db->sql_query($getsubj);
					$subject = $db->sql_fetchfield('note_subject'); 

					$db->sql_freeresult($getsubj);
				}
					
				$sql = 'DELETE FROM ' . ADMIN_NOTEPAD_TABLE . '
					WHERE note_id = ' . $delete_id . ' LIMIT 1';
				$results = $db->sql_query($sql);

				// if note was not private, then add log
				if (!$row['note_is_private'])
				{
					add_log('admin', 'ADMIN_NOTEPAD_LOG_DELETE_MSG', $subject);
				}
	
				trigger_error($user->lang['INFO_DELETE_DONE'] . adm_back_link($this->u_action));
			}

			// confirmed that all messages should be deleted
			else if ($confirm_type == 'all')
			{
				// delete any public notes OR any notes which are private to the deleter
				// thanks to A_Jelly_Doughnut for the SQL
				$sql = 'DELETE FROM ' . ADMIN_NOTEPAD_TABLE . '
					WHERE note_is_private = 0
					OR (note_poster_id = ' . $user->data['user_id'] . '
					AND note_is_private = 1)';
				$result = $db->sql_query($sql);
	                
				add_log('admin', 'ADMIN_NOTEPAD_LOG_DELETE_ALL');
				trigger_error($user->lang['INFO_DELETES_DONE'] . adm_back_link($this->u_action));
			}
			
			// variable was not passed, so theres some error
			else if ($confirm_type == 'default')
			{
				trigger_error($user->lang['ACP_NOTEPAD_ERROR'] . adm_back_link($this->u_action), E_USER_ERROR);
			}
		}	
	}
}

?>