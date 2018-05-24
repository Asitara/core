<?php
/*	Project:	EQdkp-Plus
 *	Package:	Language File
 *	Link:		http://eqdkp-plus.eu
 *
 *	Copyright (C) 2006-2016 EQdkp-Plus Developer Team
 *
 *	This program is free software: you can redistribute it and/or modify
 *	it under the terms of the GNU Affero General Public License as published
 *	by the Free Software Foundation, either version 3 of the License, or
 *	(at your option) any later version.
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU Affero General Public License for more details.
 *
 *	You should have received a copy of the GNU Affero General Public License
 *	along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

if ( !defined('EQDKP_INC') ){
	header('HTTP/1.0 404 Not Found');exit;
}

$lang = array(
	//Global
	'click2show' => '(klicken, um anzuzeigen)',
	'maintenance_mode' => 'Wartungsbereich',
	'task_manager' => 'Task-Manager',
	'admin_acp' => 'Administration',
	'activate_info'	=> '<h1>Wartungsmodus aktivieren</h1><br />Im Wartungsbereich Deines EQdkps kannst du z.B. dein System aktualisieren und Daten von einer älteren Version des EQdkps importieren. <br />Ein Update oder Import ist nur möglich, wenn sich dein System im Wartungsmodus befindet und anderen Benutzern die Anmeldung verweigert, um Probleme zu verhindern.<br /><br />Grund, der den Benutzern angezeigt werden soll (optional):<br/>',
	'activate_mmode'	=> 'Wartungsmodus aktivieren',
	'deactivate_mmode'	=> 'Wartungsmodus beenden',
	'leave_mmode'	=> 'Abbrechen',
	'home' => 'Home',
	'no_leave' => 'Deaktivieren des Wartungsmodus nicht möglich, solang notwendige Aufgaben ausgeführt werden müssen.',
	'no_leave_accept' => 'Zurück zur Aufgabenübersicht',

	//Maintenance page
	'maintenance_message' => '<b>Das EQdkp Plus-System befindet sich gerade im Wartungsmodus.</b> Eine Anmeldung ist zur Zeit nur für Administratoren möglich.',
	'reason'	=> '<br /><b>Grund:</b> ',
	'admin_login'		=> 'Administrator-Login',
	'login'		=> 'Anmelden',
	'username' => 'Benutzer',
	'password' => 'Passwort',
	'remember_password' => 'Passwort merken?',
	'invalid_login_warning' => 'Fehlerhafte Anmeldung! Bitte überprüfe deinen Benutzernamen und dein Passwort. Nur Administratoren ist es erlaubt, sich anzumelden.',

	//Task manager
	'is_necessary' => 'Notwendig?',
	'is_applicable' => 'Anwendbar?',
	'name' => 'Name',
	'version' => 'Version',
	'author' => 'Autor',
	'link' => 'Aufgabe ausführen',
	'description' => 'Beschreibung',
	'type' => 'Aufgaben-Typ',
	'yes' => 'Ja',
	'no' => 'Nein',
	'click_me' => 'Aufgabe ausführen',
	'mmode_info' => 'Dein System befindet sich momentan im Wartungsmodus und verweigert normalen Benutzern den Zugriff, bis du den Wartungsmodus beendet hast.',
	'necessary_tasks' => 'Notwendige Aufgaben',
	'applicable_tasks' => 'Nicht notwendige/bereits ausgeführte Aufgaben',
	'not_applicable_tasks' => 'Nicht-Ausführbare Aufgaben',
	'no_nec_tasks' => 'Keine Aufgaben notwendig.',
	'nec_tasks' => 'Folgende Aufgaben sind notwendig, bitte führe sie aus, um das System auf den aktuellsten Stand zu bringen.',
	'nec_tasks_available' => 'Bitte führe die notwendigen Tasks aus, um das System auf den aktuellesten Stand zu bringen',
	'applicable_warning' => 'Diese Aufgabe ist nicht notwendig! Ein Ausführen kann Datenverlust zur Folge haben! Führe diese Aufgabe nur aus, wenn du dir absolut sicher bist!',
	'executed_tasks'	=> 'Folgende Aktionen wurden für die Aufgabe "%s" ausgeführt',
	'stepend_info'		=> 'Die Aufgabe wurde beendet. Das EQdkp Plus befindet sich aber noch im Wartungsmodus, damit du alles durchtesten kannst. Erst nachdem der Wartungsmodus beendet ist, können sich Benutzer wieder anmelden.',

	//pfh-errors
	'mmode_pfh_error' => 'Es sind einige Fehler aufgetreten. Du musst die Fehler beheben, um den Maintenance-Mode zu deaktivieren.',
	"lib_cache_notwriteable" => "In den Ordner \"data\" kann nicht geschrieben werden. Bitte gib ihm CHMOD 777!",

	//Task types
	'fix' => 'Fix',
	'update' => 'Update',
	'import' => 'Import',
	'plugin_update' => 'Plugin-Update',
	'worker' => 'Worker',

	//Task page
	'unknown_task_warning' => 'Unbekannter Task!',
	'application_warning' => 'Konnte Aufgabe aufgrund eines Applikations-Fehlers nicht ausführen!',
	'dependency_warning' => 'Dieser Task ist von anderen abhängig. Führe diese zuerst aus!',
	'start_here' => 'Beginne hier!',

	//Sql-Updates
	'following_updates_necessary' => 'Die folgenden Aktualisierungen sind notwendig: ',
	'start_update' => 'Führe alle notwendigen Updates aus!',
	'only_this_update' => 'Führe nur dieses Update aus: ',
	'start_single_update' => 'Update ausführen',

	//Splash
	'splash_welcome'	=> 'Willkommen im Wartungsbereich deines EQdkp Plus-Systems!',
	'splash_desc' 		=> 'Hier kannst du dein EQdkp aktualisieren, und ältere Versionen von EQdkp Plus importieren.',
	'splash_new'		=> 'Dir ist EQdkp Plus neu? Du hast noch nie DKP-Punkte vergeben oder Raids eingetragen? Lerne nun einige Funktionen des EQdkp Plus kennen.',
	'start_tour'		=> 'Tour starten',
	"splash_quickstart" => 'Du willst schnell mit dem EQdkp Plus loslegen, ohne erst alles umständlich einzustellen? Lege mit dem Schnellstart-Assistenten innerhalb von 5 Minuten los.',
	"splash_start_quickstart" => "Starte den Schnellstart-Assistenten",
	"splash_close" 		=> 'Fenster schließen',
	"splash_close_info" => 'Natürlich kannst du die Tour und alle Einstellungen jederzeit später erledigen. Wenn du das EQdkp Plus bereits kennst, schließe einfach dieses Fenster.',
		

	//Backup
	'backup'			=> 'Datenbank-Backup',
	'backup_note'		=> 'Ein Datenbank-Backup wurde erfolgreich unter %s erstellt.',
		
	'support_eqdkplus'	=> 'So ein Projekt wie EQdkp Plus kann natürlich nur existieren, wenn wir für die ganze Mühe, Zeit und Liebe, die wir in EQdkp Plus stecken, auch wieder etwas zurückbekommen. Dies ist auf vielfältige Weise möglich:
						<ul>
							<li><i class="fa fa-puzzle-piece"></i> <a href="http://eqdkp-plus.eu/repository/">Veröffentliche ein Plugin oder Template, damit alle EQdkp Plus Benutzer was davon haben</a></li>
							<li><i class="fa fa-comments"></i> <a href="http://eqdkp-plus.eu/forum/">Unterstütze uns in unserem Forum</a></li>
							<li><i class="fa fa-cogs"></i> <a href="http://eqdkp-plus.eu/de/entwicklung.html">Beteilige dich aktiv an der Weiterentwicklung von EQdkp Plus</a></li>
							<li><i class="fa fa-usd"></i> <a href="http://eqdkp-plus.eu/de/spenden.html">Unterstützte uns finanziell, damit wir euch weiterhin unsere Services anbieten können</a></li>
						</ul>
		
						Also wenn ihr EQdkp Plus genauso liebt wie wir, denkt doch mal darüber nach, uns zu unterstützen!',
);
?>