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

if(!defined('EQDKP_INC')){
	header('HTTP/1.0 404 Not Found');exit;
}

$lang = array(
	'hide_tour_info'		=> '<a href="javascript&#58;window&#46;location&#46;search&#61;mmocms_sid&#43;&#39;&#38;tour&#61;step_%d&#39&#59;">Du hast die EQdkp Plus Tour übersprungen oder abgebrochen, klicken um die Tour zu starten.</a><br /><br /><a href="javascript&#58;window&#46;location&#46;search&#61;mmocms_sid&#43;&#39;&#38;tour&#61;hide&#39&#59;">Hier klicken, um diese Meldung zukünftig auszublenden.</a>',
	'tour_step_completed'	=> '<h1>Gratulation, ..sekunde</h1><span>Sie werden nun weitergeleitet zum nächsten Abschnit</span>',
	
	//Step 0 - Start
	'step_0_title'	=> 'Die Einführung',
	'step_0_0_text'	=> '
		Herzlich Willkommen zur EQdkp Plus Tour!
		<br />Diese Tour zeigt dir in einfachen Schritten, welche Punkte & Funktionen für dich wichtig sind.
		<br /><br /> ...viel Spaß ;)',
	
	//Step 1 - Settings
	'step_1_title'	=> 'Einstellungen',
	'step_1_0_text'	=> '
		Auf dieser Seite kannst du diverse Haupteinstellungen rund um dein EQdkp Plus tätigen.
		<br /><br />Du findest hier Einstellungen wie z.B.
		<br /><i class="fa fa-caret-right"></i> Spiel-Einstellungen
		<br /><i class="fa fa-caret-right"></i> Email-Einstellungen
		<br /><i class="fa fa-caret-right"></i> Registrierungs-Einstellungen
		<br /><br /><i class="fa fa-blind">&nbsp Administration > Einstellungen</i>',
	'step_1_1_text'	=> '
		Und wirst du hier nicht fündig oder möchtest andere Einstellungen tätigen kannst du über dieses Menü durch alle Administrationsseiten navigieren.
		<br /><br /><i class="fa fa-blind">&nbsp Administration > Einstellungen</i>',
	
	//Step 2 - Tables
	'step_2_title'	=> 'Tabellen & Punktesysteme',
	'step_2_0_text'	=> '
		Hier kannst du auswählen welches Punktesystem du möchtest und dieses bearbeiten.
		<br /><br />Bearbeitest du ein Layout hast du darüber hinaus die Möglichkeit verschiedene Tabellen nach deinen Wünschen anzupassen.
		<br />In jedem Tab kannst du für die jeweilige Seite festlegen, welche Spalten der jeweiligen Tabelle angezeigt werden sollen.
		<br /><br /><i class="fa fa-blind">&nbsp Portal > Tabellen & Punktesystem verwalten</i>',
	
	//Step 3 - Extensions
	'step_3_title'	=> 'Erweiterungen',
	'step_3_0_text'	=> '
		Erweiterungen wie Plugins, Styles,.. , erhöhen die Funktionalität deines EQdkp Plus und machen es einzigartig.
		<br />Hier siehst du nach Kategorie sortiert, alle geprüften Erweiterungen aus unserem Repository.
		<br /><br /><i class="fa fa-blind">&nbsp Erweiterungen > Erweiterungen verwalten</i>',
	
	//Step 4 - Portallayout
	'step_4_title'	=> 'Portallayout',
	'step_4_0_text'	=> '
		Mit Portalmodulen kannst du dir verschiedenste Sachen in deinem Portal anzeigen, z.B.
		<br /><br /><i class="fa fa-caret-right"> Teamspeak / Voiceserver
		<br /><i class="fa fa-caret-right"></i> Wer ist Online
		<br /><i class="fa fa-caret-right"></i> Nächste & Letzte (Raids, Geburtstage,...)
		<br /><i class="fa fa-caret-right"></i> Wetter
		<br /><i class="fa fa-caret-right"></i> Newsletter / RSS Feeds
		<br /><i class="fa fa-caret-right"></i> Spiel spezifisches
		<br /><br /><i class="fa fa-blind">&nbsp Portal > Portallayout verwalten</i>',
	'step_4_1_text'	=> '
		Möchtest du z.b. in der Artikelkategorie <span class="small">`Kalender`</span> nur die Portalmodule <span class="small">`...`</span> angezeigen <span class="small">(unabhängig deiner anderen Seiten)</span>?
		<br /><br />So kannst du hier weitere Layouts erstellen, welche dann in den Artikelkategorie-Einstellungen ausgewählt werden können.
		<br /><br />Auch kannst du in den Haupteinstellungen ein anderes Standart-Layout definieren für Desktop & Mobil Nutzer.
		<br /><br /><i class="fa fa-blind">&nbsp Portal > Portallayout verwalten</i>',
	
	//Step 5 - Users
	'step_5_title'	=> 'Benutzer',
	'step_5_0_text'	=> '
		Hier kannst du Benutzer verwalten, z.B. freischalten wenn einer nach der Registrierung noch inaktiv ist.
		<br /><br />Damit sich ein Benutzer für einen Raid anmelden kann oder DKP-Punkte bekommen kann, musst du ihm hier einen Charakter zuweisen.
		<br /><br />Auch kannst du hier die Berechtigungen eines Benutzers verwalten, d.h. ihm Rechte zuweisen, welche Aufgaben er im EQdkp Plus ausführen darf.
		<br />Dies kann entweder geschehen, indem du den Benutzer in Benutzergruppen unterbringst, oder ihm individuelle Rechte zuweist.
		<br /><br />Welche Rechte ein Gast hat, kannst du über die Benutzergruppe "Gäste" festlegen.
		<br ><br >Mehr Informationen zum Thema Berechtigungen findest du in <a href="'.EQDKP_WIKI_URL.'/Benutzergruppen" target="_blank">diesem Wiki-Artikel</a>.
		<br /><br /><i class="fa fa-blind">&nbsp Benutzer > Benutzer verwalten</i>',
	
	//Step 6 - Usergroups
	'step_6_title'	=> 'Benutzergruppenrechte',
	'step_6_0_text'	=> '
		Um mehrere Benutzer bestimmte Rechte wie z.b.
		<br /><br /><i class="fa fa-caret-right"></i> Kalendereinträge erstellen
		<br /><i class="fa fa-caret-right"></i> Raids & Korrekturen erstellen
		<br /><i class="fa fa-caret-right"></i> Artikel schreiben
		<br /><br />so eignet es sich die Benutzer einer Gruppe zuzuweisen und die Rechte hier einzustellen.
		<br /><br /><i class="fa fa-blind">&nbsp Benutzer > Benutzergruppen verwalten</i>',
	'step_6_1_text'	=> '
		Eine Übersicht welche Benutzergruppen derzeit welche Rechte besitzen, kannst du hier einsehen.
		<br /><br /><i class="fa fa-blind">&nbsp Benutzer > Benutzergruppen verwalten</i>',
	'step_6_2_text'	=> '
		Und um bestehende Benutzergruppen zuverwalten z.b.
		<br /><br /><i class="fa fa-caret-right"></i> Standartgruppe ändern
		<br /><i class="fa fa-caret-right"></i> Rechte der Gruppe ändern
		<br /><i class="fa fa-caret-right"></i> Benutzer hinzufügen
		<br /><i class="fa fa-caret-right"></i> Gruppenleiter ernennen
		<br /><br />kannst du dies hier tun.
		<br /><br /><i class="fa fa-blind">&nbsp Benutzer > Benutzergruppen verwalten</i>',
	
	//Step 7 - Raids
	'step_7_title'	=> 'Raids',
	'step_7_0_text'	=> '
		Um Charakteren DKP-Punkte zuzuweisen, verwendest du in der Regel Raids.
		<br />In einem Raid gibst du das Datum, das Event, den DKP-Wert und natürlich die Teilnehmer des Raids an, also die Charaktere, denen die DKP-Punkte gutgeschrieben werden sollen.
		<br /><br />Desweiteren kannst du hier auch die Items an die Charaktere vergeben und ihnen die entsprechenden DKP-Punkte wieder abziehen. Auch individuelle Korrekturen sind möglich.
		<br /><br />Mehr Informationen zum Thema "Punktevergabe" findest du in <a href="'.EQDKP_WIKI_URL.'/How_to_Benutzung_EQdkp_Plus" target="_blank">diesem Wiki-Artikel</a>
		<br /><br /><i class="fa fa-blind">&nbsp Raids > Raids verwalten</i>',
	
	//Step 8 - Articles
	'step_8_title'	=> 'Artikel & Seiten',
	'step_8_0_text'	=> '
		Mit Artikel kannst du vieles realisieren: News, Gildeninfos oder auch Blogs.
		<br >Mit einem umfangreichen Editor und dem Medien-Manager bleiben beim Erstellen der Artikel keine Wünsche offen.
		<br ><br >Doch nicht nur das - du kannst hier auch Gildenregeln erstellen, die jeder Benutzer bei der Registrierung bestätigen muss.
		<br /><br /><i class="fa fa-blind">&nbsp Portal > Artikel verwalten</i>',
	
	//Step 9 - Backup
	'step_9_title'	=> 'Sicherung',
	'step_9_0_text'	=> '
		Jeder kennt das Problem - der PC geht kaputt, und die Sicherung wurde vergessen.
		<br /><br />Dies kann nicht mehr vorkommen!
		<br /><br />Nicht nur, dass man nun auch Backups wiederherstellen kann, sondern es ist auch möglich, automatisiert Backups erstellen zu lassen. Die Optionen hierfür findet ihr unter dem Menüpunkt "Zeitgesteuerte Aufgaben verwalten"
		<br /><br />Mehr Informationen zum Thema "Sicherung" findest du in <a href="'.EQDKP_WIKI_URL.'/Sicherung" target="_blank">diesem Wiki-Artikel</a>
		<br /><br /><i class="fa fa-blind">&nbsp Wartung > Sicherung</i>',
	
	//Step 10 - End
	'step_10_title'	=> 'Tour abschließen',
	'step_10_0_text'=> '
		Vielen Dank, dass du diese Tour durch das EQdkp Plus mitgemacht hast.
		<br /><br />Solltest du noch Fragen haben, kannst du
		<br /><i class="fa fa-caret-right"></i> in unserem <a href="'.EQDKP_WIKI_URL.'" target="_blank">Wiki</a> nachlesen
		<br /><i class="fa fa-caret-right"></i> oder unser <a href="'.EQDKP_BOARD_URL.'" target="_blank">Forum</a> besuchen.
		<br /><br />Du kannst diese Tour jederzeit wiederholen, in dem du auf der Startseite des Adminbereiches in den Tab "Support" gehst.
		<br /><br />Viel Spaß wünscht das gesamte EQdkp Plus Team',
	
	
	
);
?>