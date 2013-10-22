<?php
/*
 * Project:		EQdkp-Plus
 * License:		Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:		2009
 * Date:		$Date$
 * -----------------------------------------------------------------------
 * @author		$Author$
 * @copyright	2006-2011 EQdkp-Plus Developer Team
 * @link		http://eqdkp-plus.com
 * @package		eqdkp-plus
 * @version		$Rev$
 * 
 * $Id$
 */

if ( !defined('EQDKP_INC') ){
	header('HTTP/1.0 404 Not Found');exit;
}
$english_array = array(
	'classes' => array(
		0	=> 'Unknown',
		1	=> 'Death Knight',
		2	=> 'Druid',
		3	=> 'Hunter',
		4	=> 'Mage',
		5	=> 'Paladin',
		6	=> 'Priest',
		7	=> 'Rogue',
		8	=> 'Shaman',
		9	=> 'Warlock',
		10	=> 'Warrior',
		11	=> 'Monk'
	),
	'races' => array(
		'Unknown',
		'Gnome',
		'Human',
		'Dwarf',
		'Night Elf',
		'Troll',
		'Undead',
		'Orc',
		'Tauren',
		'Draenei',
		'Blood Elf',
		'Worgen',
		'Goblin',
		'Pandaren'
	),
	'factions' => array(
		'alliance' => 'Alliance',
		'horde' => 'Horde'
	),
	'roles' => array(
		1 => array(2, 5, 6, 8, 11),
		2 => array(1, 2, 5, 10, 11),
		3 => array(2, 3, 4, 6, 8, 9),
		4 => array(1, 2, 5, 7, 8, 10, 11)
	),
	'professions' => array(
		'trade_alchemy'					=> 'Alchemy',
		'trade_blacksmithing'			=> 'Blacksmithing',
		'trade_engraving'				=> 'Enchanting',
		'trade_engineering'				=> 'Engineering',
		'trade_herbalism'				=> 'Herbalism',
		'inv_inscription_tradeskill01'	=> 'Inscription',
		'inv_misc_gem_01'				=> 'Jewelcrafting',
		'trade_leatherworking'			=> 'Leatherworking',
		'inv_pick_02'					=> 'Mining',
		'inv_misc_pelt_wolf_01'			=> 'Skinning',
		'trade_tailoring'				=> 'Tailoring',
	),
	'lang' => array(
		'wow'			=> 'World of Warcraft',
		'plate'			=> 'Plate',
		'cloth'			=> 'Cloth',
		'leather'		=> 'Leather',
		'mail'			=> 'Mail',
		'tier_token'	=> 'Token: ',
		'talents_tt_1'	=> 'Primary Talent',
		'talents_tt_2'	=> 'Secondary Talent',
		'talents'		=> array(
			1	=> array('Blood','Frost','Unholy'),
			2	=> array('Balance','Feral','Guardian','Restoration'),
			3	=> array('Beast Mastery','Marksmanship','Survival'),
			4	=> array('Arcane','Fire','Frost'),
			5	=> array('Holy','Protection','Retribution'),
			6	=> array('Discipline','Holy','Shadow'),
			7	=> array('Assassination','Combat','Subtlety'),
			8	=> array('Elemental','Enhancement','Restoration'),
			9	=> array('Affliction','Demonology','Destruction'),
			10	=> array('Arms','Fury','Protection'),
			11	=> array('Brewmaster','Mistweaver','Windwalker'),
		),
		'role1' => 'Healer',
		'role2' => 'Tank',
		'role3' => 'Range-DD',
		'role4' => 'Melee',
		
		// Profile information
		'uc_prof_professions'			=> 'Professions',
		'skills'						=> 'Specialization',
		'corevalues'					=> 'Core Attributes',
		'values'						=> 'Attributes',

		// Profile information
		'uc_achievements'				=> 'Achievements',
		'uc_bosskills'					=> 'Boss Kills',
		'uc_bar_rage'					=> 'Rage',
		'uc_bar_energy'					=> 'Energy',
		'uc_bar_mana'					=> 'Mana',
		'uc_bar_focus'					=> 'Focus',
		'uc_bar_runic-power'			=> 'Runic Power',

		'uc_skill1'						=> 'Talents 1',
		'uc_skill2'						=> 'Talents 2',

		'pv_tab_profiles'				=> 'External Profiles',
		'pv_tab_talents'				=> 'Specialization',

		'uc_guild'						=> 'Guild',
		'uc_bar_health'					=> 'Health',
		'uc_bar_2value'					=> 'Value of the second bar',
		'uc_bar_2name'					=> 'Name of the second bar',

		'uc_gender'						=> 'Gender',
		'uc_male'						=> 'Male',
		'uc_female'						=> 'Female',
		'uc_faction'					=> 'Faction',
		'uc_faction_help'				=> 'The ingame faction',
		'uc_fact_horde'					=> 'Horde',
		'uc_fact_alliance'				=> 'Alliance',

		'uc_prof1_value'				=> 'Level of the first profession',
		'uc_prof1_name'					=> 'Name of the first profession',
		'uc_prof2_value'				=> 'Level of the second profession',
		'uc_prof2_name'					=> 'Name of the second profession',

		'uc_achievement_tab_default'	=> 'Ungruppiert',
		'uc_achievement_tab_classic'	=> 'Classic',
		'uc_achievement_tab_bc'			=> 'Burning Crusade',
		'uc_achievement_tab_wotlk'		=> 'Wrath of the Lich King',
		'uc_achievement_tab_cataclysm'	=> 'Cataclysm',
		'uc_achievement_tab_mop'		=> 'Mists of Pandaria',
		
		'challenge'						=> 'Challenge Mode',
		'challenge_title'				=> 'Challenge Mode Leaderboards',
		'off_realm_toon'				=> 'This character seems to be not in your guild. As the challenges are Battle-Realm based, could be foreign characters in this list.',
		

		// Profile Admin area
		'pk_tab_fs_wowsettings'			=> 'WoW Settings',
		'importer_head_txt'				=> 'battle.net Importer',
		'uc_servername_help'			=> 'Name of your realmserver (e.g. Mal\'Ganis)',
		'uc_update_all'					=> 'Update from battle.net',
		'uc_update_all_help'			=> 'Update all profile information with data from the battle.net\'s profiler',
		'uc_importer_cache'				=> 'Reset importer cache',
		'uc_importer_cache_help'		=> 'Delete all the cached data of the import class.',
		'uc_import_guild'				=> 'Import guild from battle.net',
		'uc_import_guild_help'			=> 'Import all members of a guild from battle.net',
		'uc_server_loc'					=> 'Server location',
		'uc_server_loc_help'			=> 'The location of the WoW Server',
		'uc_data_lang'					=> 'Language of the data',
		'uc_data_lang_help'				=> 'In which language should the data be fetched from external website?',
		'uc_error_head'					=> 'ERROR',
		'uc_error_noserver'				=> 'There is no server saved in the global settings. The server is required for fetching external data. Please report it to an administrator.',
		
		// Armory Import
		#'uc_armory_loc'					=> 'Realmserver\'s location',
		"uc_updat_armory" 				=> "Refresh from armory",
		'uc_charname'					=> 'Character\'s name',
		'uc_servername'					=> 'Server\'s name',
		'uc_charfound'					=> "The character <b>%1\$s</b> has been found in the armory.",
		'uc_charfound2'					=> "This character was updated on <b>%1\$s</b>.",
		'uc_charfound3'					=> 'ATTENTION: Importing will overwrite the existing data!',
		'uc_armory_imported'			=> 'Charakter successfully imported',
		'uc_armory_updated'				=> 'Charakter successfully updated',
		'uc_armory_impfailed'			=> 'Charakter not imported',
		'uc_armory_updfailed'			=> 'Charakter not updated',
		'uc_armory_impfail_reason'		=> 'Reason:',
		'uc_armory_impduplex'			=> 'Charakter is already in the database',

		// guild importer
		'uc_class_filter'				=> 'Only member of the class',
		'uc_class_nofilter'				=> 'No filter',
		'uc_guild_name'					=> 'Name of the guild',
		'uc_filter_name'				=> 'Filter',
		'uc_level_filter'				=> 'All characters with a level higher than',
		'uc_rank_filter1a'				=> 'greater or equal',
		'uc_rank_filter1b'				=> 'equal',
		'uc_rank_filter'				=> 'Rank',
		'uc_imp_noguildname'			=> 'The name of the guild has not been given.',
		'uc_gimp_loading'				=> 'Importing guild members, please wait...',
		'uc_massupd_loading'			=> 'Characters are updated, please wait...',
		'uc_gimp_header_fnsh'			=> 'The import of the guild members was finished. Imported Data: Name of the character, race, class and level. To update the other data, please run the battle.net updater.',
		'uc_cupdt_header_fnsh'			=> 'The character was successfully updated. The window can now be closed.',
		'uc_importcache_cleared'		=> 'The cache of the importer was successfully cleared.',
		'uc_startdkp'					=> 'Set Start-DKP',
		'uc_startdkp_adjreason'			=> 'Start-DKP',
		'uc_delete_chars_onimport'		=> 'Delete Chars that have left the guild',

		'uc_noprofile_found'			=> 'No profile found',
		'uc_profiles_complete'			=> 'Profiles updated successfully',
		'uc_notyetupdated'				=> 'No new data (inactive character)',
		'uc_notactive'					=> 'This character will be skipped because it is set to inactive',
		'uc_error_with_id'				=> 'Error with this character\'s id, it has been left out',
		'uc_notyourchar'				=> 'ATTENTION: You currently try to import a character that already exists in the database but is not owned by you. For security reasons, this action is not permitted. Please contact an administrator for solving this problem or try to use another character name.',
		'uc_lastupdate'					=> 'Last Update',

		'uc_prof_import'				=> 'import',
		'uc_import_forw'				=> 'continue',
		'uc_imp_succ'					=> 'The data has been imported successfully',
		'uc_upd_succ'					=> 'The data has been updated successfully',
		'uc_imp_failed'					=> 'An error occured while updating the data. Please try again.',

		'base'							=> 'Attributes',
		'strength'						=> 'Strength',
		'agility'						=> 'Agility',
		'stamina'						=> 'Stamina',
		'intellect'						=> 'Intellect',
		'spirit'						=> 'Spirit',

		'melee'							=> 'Melee',
		'mainHandDamage'				=> 'Main Hand Damage',
		'mainHandDps'					=> 'DPS',
		'mainHandSpeed'					=> 'Main Hand Speed',
		'power'							=> 'Attack Power',
		'hasteRating'					=> 'Haste rating',
		'hitPercent'					=> 'Hit rating',
		'critChance'					=> 'Crit rating',
		'expertise'						=> 'Expertise rating',
		'mastery'						=> 'Mastery rating',

		'range'							=> 'Ranged',
		'damage'						=> 'Damage',
		'rangedDps'						=> 'DPS',
		'rangedSpeed'					=> 'Speed',

		'spell'							=> 'Spell',
		'spellpower'					=> 'Spell Power',
		'spellHit'						=> 'Hit rating ',
		'spellCrit'						=> 'Crit rating',
		'spellPen'						=> 'Spell Penetration',
		'manaRegen'						=> 'Mana Regeneration',
		'combatRegen'					=> 'Combat Regeneration',

		'defenses'						=> 'Defense',
		'armor'							=> 'Armor',
		'dodge'							=> 'Dodge',
		'parry'							=> 'Parry',
		'block'							=> 'Block',
		'pvpresil'						=> 'PVP-Resilience',
		'pvppower'						=> 'PVP-Power',
		'all'							=> 'All Attributes',

		'achievements'					=> 'Achievements',
		'achievement_points'			=> 'Achievement points',
		'total'							=> 'Total',
		'health'						=> 'Health',
		'last5achievements'				=> '5 most recent achievements',

		'charnewsfeed'					=> 'Last activities',
		'charnf_achievement'			=> 'Earned the achievement %s for %s points.',
		'charnf_achievement_hero'		=> 'Earned the feat of strength %s.',
		'charnf_item'					=> 'Obtained %s',
		'charnf_bosskill'				=> '%s %s',
		'charnf_criteria'				=> 'Completed step %s of achievement %s.',
		'avg_itemlevel'					=> 'Average item level',
		'avg_itemlevel_equiped'			=> 'Equiped item level',

		// bossprogress
		'bossprogress_normalruns'		=> '%sx normal',
		'bossprogress_heroicruns'		=> '%sx heroic',

		'wotlk'           				=> 'Wrath of the Lich King',
		'cataclysm'       				=> 'Cataclysm',
		'burning_crusade'				=> 'Burning Crusade',
		'classic'						=> 'Classic',
		
		'mop_mogushan_10'				=> 'Mogu\'shan Vaults (10)',
		'mop_mogushan_25'				=> 'Mogu\'shan Vaults (25)',
		'mop_heartoffear_10'			=> 'Heart of Fear (10)',
		'mop_heartoffear_25'			=> 'Heart of Fear (25)',
		'mop_endlessspring_10'			=> 'Terrace of Endless Spring (10)',
		'mop_endlessspring_25'			=> 'Terrace of Endless Spring (25)',
		'mop_throneofthunder_10'		=> 'Throne of Thunder (10)',
		'mop_throneofthunder_25'		=> 'Throne of Thunder (25)',
		'mop_siegeoforgrimmar'			=> 'Siege of Orgrimmar',

		'char_news'						=> 'Char News',
		'no_armory'						=> 'The data for this char could not be loaded. The battle.net API returned an error: "%s".',
		'no_realm'						=> 'To use the whole functionality please enter a valid World of Warcraft game server name in administrator settings.',

		'guildachievs_total_completed'	=> 'Total Completed',
		'latest_guildachievs'			=> 'Recently Earned',
		'guildnews'						=> 'Guildnews',
		'news_guildCreated'				=> 'The guild was founded.',
		'news_itemLoot'					=> '%1$s obtained %2$s',
		'news_itemPurchase'				=> '%1$s purchased item %2$s',
		'news_guildLevel'				=> 'The guild reached level %s.',
		'news_guildAchievement'			=> 'The guild earned the achievement %1$s for %2$s points.',
		'news_playerAchievement'		=> '%1$s earned the achievement %2$s for %3$s points.',

		'not_assigned'					=> 'Not assigned',
		'empty'							=> 'Empty',
		'major_glyphs'					=> 'Major Glyphs',
		'minor_glyphs'					=> 'Minor Glyphs',

	),

	'realmlist' => array(
		"Aerie Peak",
		"Agamaggan",
		"Aggra (Português)",
		"Aggramar",
		"Ahn'Qiraj",
		"Al'Akir",
		"Alonsus",
		"Anachronos",
		"Arathor",
		"Argent Dawn",
		"Aszune",
		"Auchindoun",
		"Azjol-Nerub",
		"Azuremyst",
		"Balnazzar",
		"Blade's Edge",
		"Bladefist",
		"Bloodfeather",
		"Bloodhoof",
		"Bloodscalp",
		"Boulderfist",
		"Bronze Dragonflight",
		"Bronzebeard",
		"Burning Blade",
		"Burning Legion",
		"Burning Steppes",
		"Chamber of Aspects",
		"Chromaggus",
		"Crushridge",
		"Daggerspine",
		"Darkmoon Faire",
		"Darksorrow",
		"Darkspear",
		"Deathwing",
		"Defias Brotherhood",
		"Dentarg",
		"Doomhammer",
		"Draenor",
		"Dragonblight",
		"Dragonmaw",
		"Drak'thul",
		"Dunemaul",
		"Earthen Ring",
		"Emerald Dream",
		"Emeriss",
		"Eonar",
		"Executus",
		"Frostmane",
		"Frostwhisper",
		"Genjuros",
		"Ghostlands",
		"Grim Batol",
		"Hakkar",
		"Haomarush",
		"Hellfire",
		"Hellscream",
		"Jaedenar",
		"Karazhan",
		"Kazzak",
		"Khadgar",
		"Kilrogg",
		"Kor'gall",
		"Kul Tiras",
		"Laughing Skull",
		"Lightbringer",
		"Lightning's Blade",
		"Magtheridon",
		"Mazrigos",
		"Moonglade",
		"Nagrand",
		"Neptulon",
		"Nordrassil",
		"Outland",
		"Quel'Thalas",
		"Ragnaros",
		"Ravencrest",
		"Ravenholdt",
		"Runetotem",
		"Saurfang",
		"Scarshield Legion",
		"Shadowsong",
		"Shattered Halls",
		"Shattered Hand",
		"Silvermoon",
		"Skullcrusher",
		"Spinebreaker",
		"Sporeggar",
		"Steamwheedle Cartel",
		"Stormrage",
		"Stormreaver",
		"Stormscale",
		"Sunstrider",
		"Sylvanas",
		"Talnivarr",
		"Tarren Mill",
		"Terenas",
		"Terokkar",
		"The Maelstrom",
		"The Sha'tar",
		"The Venture Co",
		"Thunderhorn",
		"Trollbane",
		"Turalyon",
		"Twilight's Hammer",
		"Twisting Nether",
		"Vashj",
		"Vek'nilash",
		"Wildhammer",
		"Xavius",
		"Zenedar",
	),
);
?>