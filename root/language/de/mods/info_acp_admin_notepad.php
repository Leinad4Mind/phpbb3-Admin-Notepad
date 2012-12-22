<?php
/**
*
* info_acp_admin_notepad [Deutsch - Du]
*
* @package language
* @version $Id: info_acp_inactive_users.php 10-10-2009 20:52:37 WileCoyote $
* @copyright (c) 2012 wu-systems.at http://www.wu-systems.at/
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
	'ACP_NOTEPAD_ERROR'            => 'Es konnte nicht ermittelt werden, welche Notiz aus den Admin Notizen gelöscht werden soll. Bitte gehe zurück und versuche es erneut.',

	'ADMIN_NOTEPAD'                => 'Admin Notizen',
	'ADMIN_NOTEPAD_TITLE'          => 'Admin Notizen 2.2.2',
	'ADMIN_NOTEPAD_EXPLAIN'        => 'Willkommen zu den Admin Notizen. Du kannst dieses Modul verwenden, um für dich selbst Notizen zu speichern oder anderen Administratoren damit Notizen hinterlassen. Diese Notizen können jederzeit eingesehen werden. Um private Notizen zu erstellen, die nur du lesen kannst, aktiviere beim Speichern oder Bearbeiten das Kontrollkästchen "Markiere diese Notiz als privat" in den nachfolgenden Feldern. <br /> <br /> Das Auswahlfeld unterhalb zeigt dir ältere Notizen (neueste zuerst) an und du kannst wählen, ob du diese lesen oder löschen möchtest. Du kannst ältere Einträge bearbeiten, indem Du die Notiz öffnest und im Lesebereich auf <em>Bearbeiten</em> klickst. Du kannst neue Notizen speichern, indem Du das Formular unterhalb ausfüllst und auf <em>Neue Notiz speichern</em> klickst.<br /><br />Beachte, dass Notizen die einmal gelöscht wurden nicht wiederhergestellt werden können.',
	'ADMIN_NOTEPAD_SUBJECT'        => 'Titel',
	'ADMIN_NOTEPAD_MESSAGE'        => 'Notiz',
	'ADMIN_NOTEPAD_PREVIOUS_MSG'   => 'Ältere Notizen (neueste zuerst):',
	'ADMIN_NOTEPAD_DELETE'		   => 'Löschen',
	'ADMIN_NOTEPAD_DELETE_ALL'     => 'Alle löschen',
	'ADMIN_NOTEPAD_EDIT'           => 'Bearbeiten',
	'ADMIN_NOTEPAD_READ'           => 'Lesen',
	'ADMIN_NOTEPAD_SAVE'           => 'Neue Notiz speichern',
	'ADMIN_NOTEPAD_SAVE_EDITED'    => 'Bearbeitete speichern',
	'ADMIN_NOTEPAD_LOG_DELETE_MSG' => '<b>Gelöschte Admin-Notiz</b> mit der Bezeichnung<br />&#187; %s',
	'ADMIN_NOTEPAD_LOG_DELETE_ALL' => '<b>Alle Admin-Notizen</b> gelöscht',

	'DELETE_ALL_CONFIRM'           => 'Bist du sicher, dass du alle Admin-Notizen aus löschen möchtest? Dieser Vorgang wird alle öffentlichen und als privat gekennzeichnete Admin-Notizen löschen.',
	'DELETE_CONFIRM'               => 'Bist du sicher, dass du alle ausgewählten Admin-Notizen löschen möchtest?',
	'DIRECT_LINK'                  => 'direkter Link zu dieser Notiz',

	'EDITED_BY'			=> 'Bearbeitet von',
	'EDITED_BY_AUTHOR'	=> 'Bearbeitet',

	'INFO_SAVE_DONE'		=> 'Notiz erfolgreich gespeichert',
	'INFO_DELETE_DONE'		=> 'Notiz erfolgreich gelöscht',
	'INFO_DELETES_DONE'		=> 'Alle Admin-Notizen wurden erfolgreich gelöscht.',
	'INFO_EDIT_DONE'		=> 'Notiz erfolgreich bearbeitet',
	'INFO_NO_SUBJECT'		=> 'Es wurde kein Titel eingegeben.',
	'INFO_NO_MESSAGE'		=> 'Es wurde keine Notiz eingegeben.',

	'MAKE_PRIV'			=> 'Markiere diese Notiz als privat (nur für dich sichtbar)',

	'NONE_FOUND'		=> '<p><em>Keine älteren Notizen gefunden.</em> Du kannst unterhalb eine neue Notiz erstellen.</p>',
	'NOT_EXIST'			=> 'Die angeforderte Notiz existiert nicht.',
	'NOTIFY_PRIV'		=> '<strong>HINWEIS:</strong> Diese Notiz wurde als privat gekennzeichnet und nur du kannst sie sehen.',

	'ON'				=> 'am',

	'POSTED_BY'			=> 'Erstellt von',
    'THE_AUTHOR'        => ' vom Autor',
	'UNTITLED'			=> 'Unbenannt',
	'YOU'				=> 'Du',
));

?>