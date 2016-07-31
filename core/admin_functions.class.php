<?php
/*	Project:	EQdkp-Plus
 *	Package:	EQdkp-plus
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

if(!class_exists('admin_functions')) {
class admin_functions extends gen_class {
	public static $shortcuts = array('puf' => 'urlfetcher');

	public function resolve_ip($strIP){
		$out = false;
		if(strlen($strIP)){
			$return = $this->puf->fetch("http://www.geoplugin.net/php.gp?ip=".$this->in->get('ip_resolve'));
			if ($return){
				$unserialized = @unserialize($return);
				if ($unserialized){
					$out = array(
						'city' 			=> $unserialized['geoplugin_city'],
						'regionName'	=> $unserialized['geoplugin_regionName'],
						'countryName'	=> $unserialized['geoplugin_countryName'],
					);

					if (!strlen($out['countryName'])) $out = false;
				}
			}
		}
		
		return $out;
	}
	
	/**
	 * Resolve the User Browser
	 *
	 * @param string $member
	 * @return string
	 */
	function resolve_browser($string){
		$string = sanitize($string);
		if( preg_match("/opera/i",$string)){
			return "<div class=\"coretip-left browser-icon opera\" data-coretip=\"".$string."\"><i class=\"fa fa-lg fa-opera\"></i></div>";
		}else if( preg_match("/msie/i",$string)){
			return "<div class=\"coretip-left browser-icon ie\" data-coretip=\"".$string."\"><i class=\"fa fa-lg fa-internet-explorer\"></i></div>";
		}else if( preg_match("/edge/i",$string)){
			return "<div class=\"coretip-left browser-icon edge\" data-coretip=\"".$string."\"><i class=\"fa fa-lg fa-edge\"></i></div>";
		}else if( preg_match("/chrome/i", $string)){
			return "<div class=\"coretip-left browser-icon chrome\" data-coretip=\"".$string."\"><i class=\"fa fa-lg fa-chrome\"></i></div>";
		}else if( preg_match("/konqueror/i",$string)){
			return "<div class=\"coretip-left\" data-coretip=\"".$string."\">Konqueror</div>";
		}else if( preg_match("/safari/i",$string) ){
			return "<div class=\"coretip-left browser-icon safari\" data-coretip=\"".$string."\"><i class=\"fa fa-lg fa-safari\"></i></div>";
		}else if( preg_match("/lynx/i",$string) ){
			return "<span class=\"coretip-left\" data-coretip=\"".$string."\">Lynx</span>";
		}else if( preg_match("/mozilla/i",$string) ){
			return "<div class=\"coretip-left browser-icon firefox\" data-coretip=\"".$string."\"><i class=\"fa fa-lg fa-firefox\"></i></div>";
		}else if( preg_match("/w3m/i",$string) ){
			return "<span class=\"coretip-left\" data-coretip=\"".$string."\">w3m</span>";
		}else{
			return "<i class=\"fa fa-question-circle fa-lg fa-fw coretip-left\" data-coretip=\"".$string."\"></i>";
		}
	}
	
	/**
	 * Resolve the EQDKP Page the user is surfing on..
	 *
	 * @param string $member
	 * @return string
	 */
	function resolve_eqdkp_page($strPage){

		$matches = explode('&', $strPage);
		$strPath = $matches[0];

		if (strlen($strPath)){
			$strQuery = (isset($matches[1])) ? $matches[1] : "";
			$arrQuery = array();
			parse_str($strQuery, $arrQuery);
			$arrFolder = explode('/', $strPath);
			$strOut = "";
			
			// Prefixes for Admin, Plugins, Maintenance
			switch($arrFolder[0]){
				case 'admin' : $strPrefix = registry::fetch('user')->lang('menu_admin_panel').': ';
				break;
				case 'plugins' : $strPrefix = registry::fetch('user')->lang('pi_title').': '; $strOut = ((registry::fetch('user')->lang($arrFolder[1])) ? registry::fetch('user')->lang($arrFolder[1]) : ucfirst($arrFolder[1]));
				break;
				case 'maintenance' : $strPrefix = registry::fetch('user')->lang('maintenance'); $strOut = " ";
				break;
				case 'portal': $strPrefix = registry::fetch('user')->lang('portal').': '; $strOut = ((registry::fetch('user')->lang($arrFolder[1])) ? registry::fetch('user')->lang($arrFolder[1]) : ucfirst($arrFolder[1]));
				break;
				default: $strPrefix = '';
			}
			
			// Resolve Admin Pages
			if ($arrFolder[0] == "admin"){
				// First, some admin pages without menu entry
				switch($strPath){
					case 'admin/info_php':
						$strOut = '<a href="'.$this->root_path.'admin/info_php.php'.$this->SID.'">PHP-Info</a>';
					break;
					
					case 'admin/manage_articles':
						$strOut = '<a href="'.$this->root_path.'admin/manage_articles.php'.$this->SID.'&amp;'.$strQuery.'">'.$this->user->lang('manage_articles').'</a>';
					break;
					
					case 'admin/manage_styles':
						$strOut = '<a href="'.$this->root_path.'admin/manage_styles.php'.$this->SID.'&amp;'.$strQuery.'">'.$this->user->lang('styles_title').'</a>';
					break;
					
					case 'admin':
					case 'admin/index':
						$strOut = registry::fetch('user')->lang('menu_admin_panel');
						$strPrefix = "";
					break;
				}
				
				// Now check if there is an menu entry
				if($strOut == ""){
					$admin_menu = $this->adminmenu(false);
					$result = search_in_array($strPath.".php".$this->SID, $admin_menu);
					if ($result){
						$arrMenuEntry = arraykey_for_array($result, $admin_menu);
						if ($arrMenuEntry) $strOut = '<a href="'.$this->root_path.$arrMenuEntry['link'].'">'.$arrMenuEntry['text'].'</a>';
					}
				}
			}
			
			// Resolve Frontend Page
			if ($strOut == "" && $strPrefix == ""){
				$intArticleID = $intCategoryID = 0;
				
				$arrPath = array_reverse($arrFolder);

				// Suche Alias in Artikeln
				$intArticleID = $this->pdh->get('articles', 'resolve_alias', array(str_replace(".html", "", utf8_strtolower($arrPath[0]))));
				if (!$intArticleID){
					// Suche Alias in Kategorien
					$intCategoryID = $this->pdh->get('article_categories', 'resolve_alias', array(str_replace(".html", "", utf8_strtolower($arrPath[0]))));
					
					// Suche in Artikeln mit nächstem Index, denn könnte ein dynamischer Systemartikel sein
					if (!$intCategoryID && isset($arrPath[1])) {
						$intArticleID = $this->pdh->get('articles', 'resolve_alias', array(str_replace(".html", "", utf8_strtolower($arrPath[1]))));
					}
				}

				if ($intArticleID){
					$strOut = $this->user->lang('article').': <a href="'.$this->controller_path.$this->pdh->get('articles', 'path', array($intArticleID)).'">'.$this->pdh->get('articles', 'title', array($intArticleID)).'</a>';
				} elseif($intCategoryID) {
					$strOut = $this->user->lang('category').': <a href="'.$this->server_path.$this->pdh->get('article_categories', 'path', array($intCategoryID)).'">'.$this->pdh->get('article_categories', 'name', array($intCategoryID)).'</a>';
				} elseif (register('routing')->staticRoute($arrPath[0]) || register('routing')->staticRoute($arrPath[1])) {
					$strPageObject = register('routing')->staticRoute($arrPath[0]);
					if (!$strPageObject) {
						$strPageObject = register('routing')->staticRoute($arrPath[1]);
					}
					
					if ($strPageObject){

						$strID = str_replace("-", "", strrchr(str_replace(".html", "", $arrPath[0]), "-"));
						$arrMatches = array();
						$myVar = false;
						preg_match_all('/[a-z]+|[0-9]+/', $strID, $arrMatches, PREG_PATTERN_ORDER);
						if (isset($arrMatches[0]) && count($arrMatches[0])){
							if (count($arrMatches[0]) == 2){
								$myVar = $arrMatches[0][1];
							}
						}
						if (strlen($strID) && count($arrMatches[0]) != 2) $myVar = $strID;
						
						switch($strPageObject){
							case 'settings': $strOut = registry::fetch('user')->lang('settings_title');
								break;
							case 'login': $strOut = registry::fetch('user')->lang('login_title');
								break;
							case 'mycharacters': $strOut = registry::fetch('user')->lang('manage_members_titl');
								break;
							case 'search': $strOut = registry::fetch('user')->lang('search');
								break;
							case 'register': $strOut = registry::fetch('user')->lang('register_title');
								break;
							case 'addcharacter': $strOut = registry::fetch('user')->lang('uc_edit_char');
								break;
							case 'editarticle': $strOut = $this->user->lang('manage_articles');
								if (isset($arrQuery['aid']) && $arrQuery['aid']) $strOut .= ': <a href="'.$this->controller_path.$this->pdh->get('articles', 'path', array($arrQuery['aid'])).'">'.$this->pdh->get('articles', 'title', array($arrQuery['aid'])).'</a>';
								break;
							case 'user': $strOut = $this->user->lang('user');
								if ($myVar) $strOut .= ': <a href="'.$this->server_path.sanitize($strPage).'">'.$this->pdh->get('user', 'name', array($myVar)).'</a>';
								break;
							case 'usergroup': $strOut = $this->user->lang('usergroup');
								if ($myVar) $strOut .= ': <a href="'.$this->server_path.sanitize($strPage).'">'.$this->pdh->get('user_groups', 'name', array((int)$myVar)).'</a>';
								break;
							case 'rss': $strOut = "RSS";
								break;
							case 'wrapper': {
								if($arrFolder[1] == "board" || $arrFolder[1] == "boardregister" || $arrFolder[1] == "lostpassword") {
									$strOut = '<a href="'.$this->routing->build('External', 'Board').'">'.$this->user->lang('forum').'</a>';
								} elseif($myVar) {
									$strOut = $this->user->lang('viewing_wrapper').': <a href="'.$this->routing->build('External', $this->pdh->get('links', 'name', array(intval($myVar))), intval($myVar)).'">'.$this->pdh->get('links', 'name', array(intval($myVar))).'</a>';
								} else {
									$strOut = $this->user->lang('viewing_wrapper');
								}
							}
								break;
							case 'tag': $strOut .= $this->user->lang('tag').': <a href="'.$this->routing->build('tag', sanitize($arrFolder[1])).'">'.sanitize($arrFolder[1]).'</a>';
								break;
						}
					}
				} else {
					// Some special frontend pages
					switch($strPath){
						case "api":
						case "exchange": $strOut = registry::fetch('user')->lang('viewing_exchange');
						break;
					}
				}
				
			}
		}
		
		if ($strOut == '') $strOut = '<span style="font-style:italic;">'.$this->user->lang('unknown').'</span>';
		return $strPrefix.$strOut;
	}
	
	public function adminmenu($blnShowBadges = true, $coreUpdates="", $extensionUpdates="", $blnShowFavorites=false){
		$admin_menu = array(
			'members' => array(
				'icon'	=> 'fa-user fa-lg fa-fw',
				'name'	=> $this->user->lang('chars'),
				1		=> array('link' => 'admin/manage_members.php'.$this->SID,			'text' => $this->user->lang('manage_members'),	'check' => 'a_members_man',	'icon'	=> 'fa-user fa-lg fa-fw'),
				2		=> array('link' => 'admin/manage_items.php'.$this->SID,			'text' => $this->user->lang('manitems_title'),	'check' => 'a_item_',		'icon' => 'fa-gift fa-lg fa-fw'),
				3		=> array('link' => 'admin/manage_adjustments.php'.$this->SID,		'text' => $this->user->lang('manadjs_title'),		'check' => 'a_indivadj_',	'icon' => 'fa-tag fa-lg fa-fw'),
				4		=> array('link' => 'admin/manage_ranks.php'.$this->SID,			'text' => $this->user->lang('manrank_title'),		'check' => 'a_members_man',	'icon' => 'fa-flag fa-lg fa-fw'),
				5		=> array('link' => 'admin/manage_profilefields.php'.$this->SID,	'text' => $this->user->lang('manage_pf_menue'),	'check' => 'a_config_man',	'icon' => 'fa-sitemap fa-lg fa-fw'),
				6		=> array('link' => 'admin/manage_roles.php'.$this->SID,			'text' => $this->user->lang('rolemanager'),		'check' => 'a_config_man',	'icon' => 'fa-beer fa-lg fa-fw'),
				7		=> array('link' => 'admin/manage_auto_points.php'.$this->SID,		'text' => $this->user->lang('manage_auto_points'),'check' => 'a_config_man',	'icon' => 'fa-magic fa-lg fa-fw'),
			),
			'users' => array(
				'icon'	=> 'fa-group fa-lg fa-fw',
				'name'	=> $this->user->lang('users'),
				1		=> array('link' => 'admin/manage_users.php'.$this->SID,			'text' => $this->user->lang('manage_users'),		'check' => 'a_users_man',	'icon' => 'fa-user fa-lg fa-fw'),
				2		=> array('link' => 'admin/manage_user_groups.php'.$this->SID,		'text' => $this->user->lang('manage_user_groups'),'check' => array('OR', array('a_usergroups_man', 'a_usergroups_grpleader')),	'icon' => 'fa-group fa-lg fa-fw'),
				3		=> array('link' => 'admin/manage_user_profilefields.php'.$this->SID,	'text' => $this->user->lang('manage_userpf'),	'check' => 'a_users_profilefields',	'icon' => 'fa-sitemap fa-lg fa-fw'),
				4		=> array('link' => 'admin/manage_maintenance_user.php'.$this->SID,'text' => $this->user->lang('maintenanceuser_user'),'check' => 'a_maintenance','icon' => 'fa-user-md fa-lg fa-fw'),
				5		=> array('link' => 'admin/manage_massmail.php'.$this->SID,'text' => $this->user->lang('massmail'),'check' => 'a_users_massmail','icon' => 'fa fa-envelope fa-lg fa-fw'),
			),
			'extensions' => array(
				'name'	=> $this->user->lang('extensions').(($blnShowBadges) ? $extensionUpdates : ''),
				'icon' => 'fa-cogs fa-lg fa-fw',
				1		=> array('link' => 'admin/manage_extensions.php'.$this->SID,		'text' => $this->user->lang('extension_repo'),'check' => 'a_extensions_man',	'icon' => 'fa-cogs fa-lg fa-fw'),
			),
			'portal'	=> array(
				'icon'	=> 'fa-home fa-lg fa-fw',
				'name'	=> $this->user->lang('portal'),
				1		=> array('link' => 'admin/manage_portal.php'.$this->SID,			'text' => $this->user->lang('portalmanager'),		'check' => 'a_extensions_man',	'icon' => 'fa-columns fa-lg fa-fw'),
				2		=> array('link' => 'admin/manage_article_categories.php'.$this->SID,'text' => $this->user->lang('manage_articles'),		'check' => array('OR', array('a_articles_man', 'a_article_categories_man')),	'icon' => 'fa-file-text fa-lg fa-fw'),
				3		=> array('link' => 'admin/manage_pagelayouts.php'.$this->SID,		'text' => $this->user->lang('page_manager'),		'check' => 'a_config_man',	'icon' => 'fa-table fa-lg fa-fw'),
				4		=> array('link' => 'admin/manage_menus.php'.$this->SID,				'text' => $this->user->lang('manage_menus'),		'check' => 'a_config_man',	'icon' => 'fa-list fa-lg fa-fw'),
				5		=> array('link' => 'admin/manage_notifications.php'.$this->SID,		'text' => $this->user->lang('manage_notifications'),'check' => 'a_config_man',	'icon' => 'fa-bell fa-lg fa-fw'),
			),
			'raids'	=> array(
				'icon'	=> 'fa-trophy fa-lg fa-fw',
				'name'	=> $this->user->lang('raids'),
				1		=> array('link' => 'admin/manage_raids.php'.$this->SID,			'text' => $this->user->lang('manage_raids'),		'check' => 'a_raid_add',	'icon' => 'fa-trophy fa-lg fa-fw'),
				2		=> array('link' => 'admin/manage_events.php'.$this->SID,			'text' => $this->user->lang('manevents_title'),	'check' => 'a_event_upd',	'icon' => 'fa-key fa-lg fa-fw'),
				3		=> array('link' => 'admin/manage_multidkp.php'.$this->SID,		'text' => $this->user->lang('manmdkp_title'),		'check' => 'a_event_upd',	'icon' => 'fa-gavel fa-lg fa-fw'),
				4		=> array('link' => 'admin/manage_itempools.php'.$this->SID,		'text' => $this->user->lang('manitempools_title'),'check' => 'a_event_upd',	'icon' => 'fa-tags fa-lg fa-fw'),
				5		=> array('link' => 'admin/manage_raid_groups.php'.$this->SID,		'text' => $this->user->lang('manage_raid_groups'),'check' => array('OR', array('a_raidgroups_man', 'a_raidgroups_grpleader')),	'icon' => 'fa-users fa-lg fa-fw'),
				6		=> array('link' => 'admin/manage_export.php'.$this->SID,		'text' => $this->user->lang('manexport_title'),'check' => 'a_',	'icon' => 'fa-share-square-o fa-lg fa-fw'),
			),
			'calendar'	=> array(
				'icon'	=> 'fa-calendar fa-lg fa-fw',
				'name'	=> $this->user->lang('calendars'),
				1		=> array('link' => 'admin/manage_calendars.php'.$this->SID,		'text' => $this->user->lang('manage_calendars'),	'check' => 'a_calendars_man',	'icon' => 'fa-calendar fa-lg fa-fw'),
				2		=> array('link' => 'admin/manage_calevents.php'.$this->SID,		'text' => $this->user->lang('manage_calevents'),	'check' => 'a_cal_event_man',	'icon' => 'fa-clock-o fa-lg fa-fw'),
			),
			'general' => array(
				'icon'	=> 'fa-wrench fa-lg fa-fw',
				'name'	=> $this->user->lang('general_admin'),
				1		=> array('link' => 'admin/manage_settings.php'.$this->SID,		'text' => $this->user->lang('configuration'),		'check' => 'a_config_man',	'icon' => 'fa-wrench fa-lg fa-fw'),
				2		=> array('link' => 'admin/manage_logs.php'.$this->SID,			'text' => $this->user->lang('view_logs'),			'check' => 'a_logs_view',	'icon' => 'fa-book fa-lg fa-fw'),
				3		=> array('link' => 'admin/manage_tasks.php'.$this->SID,			'text' => $this->user->lang('mantasks_title'),		'check' => array('OR', array('a_users_man', 'a_members_man')),	'icon' => 'fa-tasks fa-lg fa-fw'),
				4		=> array('link' => 'admin/manage_bridge.php'.$this->SID,		'text' => $this->user->lang('manage_bridge'),	'check' => 'a_config_man',	'icon' => 'fa-link fa-lg fa-fw'),
				5		=> array('link' => 'admin/manage_crons.php'.$this->SID,			'text' => $this->user->lang('manage_cronjobs'),		'check' => 'a_config_man',	'icon' => 'fa-clock-o fa-lg fa-fw'),
				6		=> array('link' => 'admin/manage_media.php'.$this->SID,			'text' => $this->user->lang('manage_media'),		'check' => 'a_files_man',	'icon' => 'fa-picture-o fa-lg fa-fw'),
			),
			'maintenance' => array(
				'icon'	=> 'fa-cog fa-lg fa-fw',
				'name'	=> $this->user->lang('menu_maintenance').(($blnShowBadges) ? $coreUpdates : ''),
				1		=> array('link' => 'maintenance/'.$this->SID,		'text' => $this->user->lang('maintenance'),		'check' => 'a_maintenance',	'icon' => 'fa-cog fa-lg fa-fw'),
				2		=> array('link' => 'admin/manage_live_update.php'.$this->SID,		'text' => $this->user->lang('liveupdate'),		'check' => 'a_maintenance',	'icon' => 'fa fa-refresh fa-lg fa-fw'),
				3		=> array('link' => 'admin/manage_backup.php'.$this->SID,			'text' => $this->user->lang('backup'),			'check' => 'a_backup',		'icon' => 'fa-floppy-o fa-lg fa-fw'),
				4		=> array('link' => 'admin/manage_reset.php'.$this->SID,			'text' => $this->user->lang('reset'),				'check' => 'a_config_man',	'icon' => 'fa-retweet fa-lg fa-fw'),
				5		=> array('link' => 'admin/manage_cache.php'.$this->SID,			'text' => $this->user->lang('pdc_manager'),		'check' => 'a_config_man',	'icon' => 'fa-briefcase fa-lg fa-fw'),
				6		=> array('link' => 'admin/info_database.php'.$this->SID,			'text' => $this->user->lang('mysql_info'),		'check' => 'a_config_man',	'icon' => 'fa-database fa-lg fa-fw'),
			),
		);
		
		// Now get plugin hooks for the menu
		$admin_menu = (is_array($this->pm->get_menus('admin'))) ? array_merge_recursive($admin_menu, array('extensions'=>$this->pm->get_menus('admin'))) : $admin_menu;

		// Now get the admin-favorites
		if($blnShowFavorites){
			$favs_array = array();
			if($this->config->get('admin_favs')) {
				$favs_array = $this->config->get('admin_favs');
			}
			$admin_menu['favorits']['icon'] = 'fa-star fa-lg fa-fw';
			$admin_menu['favorits']['name'] = $this->user->lang('favorits');
			//Style Management
			$admin_menu['favorits'][1] = array(
				'link'	=> 'admin/manage_extensions.php'.$this->SID.'&tab=1',
				'text'	=> $this->user->lang('styles_title'),
				'check'	=> 'a_extensions_man',
				'icon'	=> 'fa-paint-brush fa-lg fa-fw',
			);
				
			$i = 2;
			if (is_array($favs_array) && count($favs_array) > 0){
				foreach ($favs_array as $fav){
					$items = explode('|', $fav);
					$adm = $admin_menu;
					foreach ($items as $item){
						$latest = $adm;
						$adm = (isset($adm[$item])) ? $adm[$item] : false;
					}
					if (isset($adm['link'])){
						$admin_menu['favorits'][$i] = array(
							'link'	=> $adm['link'],
							'text'	=> $adm['text'].((count($items) == 3) ? ' ('.$latest['name'].')': ''),
							'check'	=> $adm['check'],
							'icon'	=> $adm['icon'],
						);
					}
					$i++;
				}
			} else {  // If there are no links, point to the favorites-management
				$admin_menu['favorits'][2] = array(
					'link'	=> 'admin/manage_menus.php'.$this->SID.'&tab=1',
					'text'	=> $this->user->lang('manage_menus'),
					'check'	=> 'a_config_man',
					'icon'	=> 'fa-list fa-lg fa-fw',
				);
			}
		}
		
		#######################################################################################################################
		#######################################################################################################################
		#######################################################################################################################
		//TODO: we need to check the core_update & extension_update badges, we will not have <span>1</span><span>2</span>
		//TODO: favorites will be added to the link-arrays via 'favorite'=> true-false  ..and then we check if isset(array['favorite'])
		
		$admin_menu = array(
			'system'=> array(
				'icon'=> 'fa-wrench fa-lg fa-fw',
				'text'=> $this->user->lang('adminmenu_system').(($blnShowBadges) ? $extensionUpdates : ''),
				'check'=> '',
				'sub_menu'=> array(
					'settings'=> array(
						'icon'=> '',
						'text'=> $this->user->lang('adminmenu_configuration'),
						'check'=> 'a_config_man',
						'links'=> array([
							'link'=> 'admin/manage_settings.php'.$this->SID,
							'icon'=> '',
							'text'=> $this->user->lang('adminmenu_general'),
							'check'=> '',
						],[
							'link'=> 'admin/manage_settings.php'.$this->SID.'#fragment-user',
							'icon'=> '',
							'text'=> $this->user->lang('adminmenu_users'),
							'check'=> '',
						],[
							'link'=> 'admin/manage_settings.php'.$this->SID.'#fragment-game',
							'icon'=> '',
							'text'=> $this->user->lang('adminmenu_game'),
							'check'=> '',
						],[
							'link'=> 'admin/manage_bridge.php'.$this->SID,
							'icon'=> '',
							'text'=> $this->user->lang('adminmenu_manage_bridge'),
							'check'=> '',
						]),
					),
					'extensions'=> array(
						'icon'=> '',
						'text'=> $this->user->lang('adminmenu_extensions').(($blnShowBadges) ? $extensionUpdates : ''),
						'check'=> 'a_extensions_man',
						'links'=> array([
							'link'=> 'admin/manage_extensions.php'.$this->SID,
							'icon'=> '',
							'text'=> $this->user->lang('adminmenu_manage_extensions'),
							'check'=> '',
						]),
					),
					'maintenance'=> array(
						'icon'=> '',
						'text'=> $this->user->lang('adminmenu_maintenance'),
						'check'=> '',
						'links'=> array([
							'link'=> 'maintenance/'.$this->SID,
							'icon'=> '',
							'text'=> $this->user->lang('adminmenu_maintenance_area'),
							'check'=> 'a_maintenance',
						],[
							'link'=> 'admin/manage_live_update.php'.$this->SID,
							'icon'=> '',
							'text'=> $this->user->lang('adminmenu_update'),
							'check'=> 'a_maintenance',
						],[
							'link'=> 'admin/manage_backup.php'.$this->SID,
							'icon'=> '',
							'text'=> $this->user->lang('adminmenu_backup'),
							'check'=> 'a_backup',
						],[
							'link'=> 'admin/manage_reset.php'.$this->SID,
							'icon'=> '',
							'text'=> $this->user->lang('adminmenu_reset'),
							'check'=> 'a_config_man',
						],[
							'link'=> 'admin/info_database.php'.$this->SID,
							'icon'=> '',
							'text'=> $this->user->lang('adminmenu_database'),
							'check'=> 'a_config_man',
						],[
							'link'=> 'admin/manage_cache.php'.$this->SID,
							'icon'=> '',
							'text'=> $this->user->lang('adminmenu_cache'),
							'check'=> 'a_config_man',
						],[
							'link'=> 'admin/manage_crons.php'.$this->SID,
							'icon'=> '',
							'text'=> $this->user->lang('adminmenu_cronjobs'),
							'check'=> 'a_config_man',
						],[
							'link'=> 'admin/manage_logs.php'.$this->SID,
							'icon'=> '',
							'text'=> $this->user->lang('adminmenu_logs'),
							'check'=> 'a_logs_view',
						],[
							'link'=> 'admin/manage_tasks.php'.$this->SID,
							'icon'=> '',
							'text'=> $this->user->lang('adminmenu_manage_tasks'),
							'check'=> array('OR', ['a_users_man', 'a_members_man']),
						]),
					),
				),
			),
			'users'=> array(
				'icon'=> 'fa-group fa-lg fa-fw',
				'text'=> $this->user->lang('adminmenu_users'),
				'check'=> '',
				'sub_menu'=> array(
					'user'=> array(
						'icon'=> '',
						'text'=> $this->user->lang('adminmenu_users'),
						'check'=> 'a_users_man',
						'links'=> array([
							'link'=> 'admin/manage_users.php'.$this->SID,
							'icon'=> '',
							'text'=> $this->user->lang('adminmenu_manage_user'),
							'check'=> '',
							'sub_links'=> array([
								'link'=> 'admin/manage_users.php'.$this->SID.'&add_user',
								'icon'=> 'fa-plus',
								'text'=> $this->user->lang('adminmenu_add_user'),
								'check'=> '',
							]),
						]),
					),
					'user_groups'=> array(
						'icon'=> '',
						'text'=> $this->user->lang('adminmenu_user_groups'),
						'check'=> array('OR', array('a_usergroups_man', 'a_usergroups_grpleader')),
						'links'=> array([
							'link'=> 'admin/manage_user_groups.php'.$this->SID,
							'icon'=> '',
							'text'=> $this->user->lang('adminmenu_manage_user_groups'),
							'check'=> '',
							'sub_links'=> array([
								'link'=> 'admin/manage_user_groups.php'.$this->SID.'&add_user_group',
								'icon'=> 'fa-plus',
								'text'=> $this->user->lang('adminmenu_add_user_group'),
								'check'=> '',
							]),
						]),
					),
					'maintenance_user'=> array(
						'icon'=> '',
						'text'=> $this->user->lang('adminmenu_maintenance_user'),
						'check'=> 'a_maintenance',
						'links'=> array([
							'link'=> 'admin/manage_maintenance_user.php'.$this->SID,
							'icon'=> '',
							'text'=> $this->user->lang('adminmenu_manage_maintenance_user'),
							'check'=> '',
						]),
					),
					'profilefields'=> array(
						'icon'=> '',
						'text'=> $this->user->lang('adminmenu_profilefields'),
						'check'=> 'a_users_profilefields',
						'links'=> array([
							'link'=> 'admin/manage_user_profilefields.php'.$this->SID,
							'icon'=> '',
							'text'=> $this->user->lang('adminmenu_manage_profilefields'),
							'check'=> '',
							'sub_links'=> array([
								'link'=> 'admin/manage_user_profilefields.php'.$this->SID.'&add_profilefield',
								'icon'=> 'fa-plus',
								'text'=> $this->user->lang('adminmenu_add_profilefield'),
								'check'=> '',
							]),
						]),
					),
					'mass_mail'=> array(
						'icon'=> '',
						'text'=> $this->user->lang('adminmenu_mass_mail'),
						'check'=> 'a_users_massmail',
						'links'=> array([
							'link'=> 'admin/manage_massmail.php'.$this->SID,
							'icon'=> '',
							'text'=> $this->user->lang('adminmenu_send_mass_mail'),
							'check'=> '',
						]),
					),
					'notifications'=> array(
						'icon'=> '',
						'text'=> $this->user->lang('adminmenu_notifications'),
						'check'=> 'a_config_man',
						'links'=> array([
							'link'=> 'admin/manage_notifications.php'.$this->SID,
							'icon'=> '',
							'text'=> $this->user->lang('adminmenu_manage_notifications'),
							'check'=> '',
						]),
					),
				),
			),
			'content'=> array(
				'icon'=> 'fa-file-text fa-lg fa-fw',
				'text'=> $this->user->lang('adminmenu_content'),
				'check'=> '',
				'sub_menu'=> array(
					'articles'=> array(
						'icon'=> '',
						'text'=> $this->user->lang('adminmenu_articles'),
						'check'=> array('OR', ['a_articles_man', 'a_article_categories_man']),
						'links'=> array([
							'link'=> 'admin/manage_articles.php'.$this->SID,
							'icon'=> '',
							'text'=> $this->user->lang('adminmenu_manage_articles'),
							'check'=> '',
						]),
					),
					'calendar'=> array(
						'icon'=> '',
						'text'=> $this->user->lang('adminmenu_calendar'),
						'check'=> array('OR', ['a_calendars_man', 'a_cal_events_man']),
						'links'=> array([
							'link'=> 'admin/manage_calendars.php'.$this->SID,
							'icon'=> '',
							'text'=> $this->user->lang('adminmenu_manage_calendars'),
							'check'=> 'a_calendars_man',
						],[
							'link'=> 'admin/manage_calevents.php'.$this->SID,
							'icon'=> '',
							'text'=> $this->user->lang('adminmenu_manage_calevents'),
							'check'=> 'a_cal_events_man',
						]),
					),
					'media'=> array(
						'icon'=> '',
						'text'=> $this->user->lang('adminmenu_media'),
						'check'=> 'a_files_man',
						'links'=> array([
							'link'=> 'admin/manage_media.php'.$this->SID,
							'icon'=> '',
							'text'=> $this->user->lang('adminmenu_manage_media'),
							'check'=> '',
						]),
					),
				),
			),
			'apperance'=> array(
				'icon'=> 'fa-desktop fa-lg fa-fw',
				'text'=> $this->user->lang('adminmenu_apperance'),
				'check'=> '',
				'sub_menu'=> array(
					'portal'=> array(
						'icon'=> '',
						'text'=> $this->user->lang('adminmenu_portal'),
						'check'=> 'a_extensions_man',
						'links'=> array([
							'link'=> 'admin/manage_portal.php'.$this->SID,
							'icon'=> '',
							'text'=> $this->user->lang('adminmenu_portallayout'),
							'check'=> '',
						],[
							'link'=> 'admin/manage_portal.php'.$this->SID,
							'icon'=> '',
							'text'=> $this->user->lang('adminmenu_portalboxes'),
							'check'=> '',
						]),
					),
					'styles'=> array(
						'icon'=> '',
						'text'=> $this->user->lang('adminmenu_styles'),
						'check'=> 'a_extensions_man',
						'links'=> array([
							'link'=> 'admin/manage_styles.php'.$this->SID,
							'icon'=> '',
							'text'=> $this->user->lang('adminmenu_manage_styles'),
							'check'=> '',
						]),
					),
					'menus'=> array(
						'icon'=> '',
						'text'=> $this->user->lang('adminmenu_menus'),
						'check'=> 'a_config_man',
						'links'=> array([
							'link'=> 'admin/manage_menus.php'.$this->SID,
							'icon'=> '',
							'text'=> $this->user->lang('adminmenu_manage_menus'),
							'check'=> '',
						]),
					),
					'table_points'=> array(
						'icon'=> '',
						'text'=> $this->user->lang('adminmenu_table_points'),
						'check'=> 'a_config_man',
						'links'=> array([
							'link'=> 'admin/manage__pagelayouts.php'.$this->SID,
							'icon'=> '',
							'text'=> $this->user->lang('adminmenu_manage_table_points'),
							'check'=> '',
						]),
					),
				),
			),
			'characters'=> array(
				'icon'=> 'fa-user fa-lg fa-fw',
				'text'=> $this->user->lang('adminmenu_characters'),
				'check'=> '',
				'sub_menu'=> array(
					'members'=> array(
						'icon'=> '',
						'text'=> $this->user->lang('adminmenu_members'),
						'check'=> 'a_members_man',
						'links'=> array([
							'link'=> 'admin/manage_members.php'.$this->SID,
							'icon'=> '',
							'text'=> $this->user->lang('adminmenu_manage_members'),
							'check'=> '',
							'sub_links'=> array([
								'link'=> 'admin/manage_members.php'.$this->SID,
								'icon'=> 'fa-plus',
								'text'=> $this->user->lang('adminmenu_add_member'),
								'check'=> '',
							]),
						]),
					),
					'ranks'=> array(
						'icon'=> '',
						'text'=> $this->user->lang('adminmenu_ranks'),
						'check'=> 'a_members_man',
						'links'=> array([
							'link'=> 'admin/manage_ranks.php'.$this->SID,
							'icon'=> '',
							'text'=> $this->user->lang('adminmenu_manage_ranks'),
							'check'=> '',
							'sub_links'=> array([
								'link'=> 'admin/manage_ranks.php'.$this->SID,
								'icon'=> 'fa-plus',
								'text'=> $this->user->lang('adminmenu_add_rank'),
								'check'=> '',
							]),
						]),
					),
					'profilefields'=> array(
						'icon'=> '',
						'text'=> $this->user->lang('adminmenu_profilefields'),
						'check'=> 'a_config_man',
						'links'=> array([
							'link'=> 'admin/manage_profilefields.php'.$this->SID,
							'icon'=> '',
							'text'=> $this->user->lang('adminmenu_manage_profilefields'),
							'check'=> '',
							'sub_links'=> array([
								'link'=> 'admin/manage_profilefields.php'.$this->SID,
								'icon'=> 'fa-plus',
								'text'=> $this->user->lang('adminmenu_add_profilefield'),
								'check'=> '',
							]),
						]),
					),
					'roles'=> array(
						'icon'=> '',
						'text'=> $this->user->lang('adminmenu_roles'),
						'check'=> 'a_config_man',
						'links'=> array([
							'link'=> 'admin/manage_roles.php'.$this->SID,
							'icon'=> '',
							'text'=> $this->user->lang('adminmenu_manage_roles'),
							'check'=> '',
							'sub_links'=> array([
								'link'=> 'admin/manage_roles.php'.$this->SID,
								'icon'=> 'fa-plus',
								'text'=> $this->user->lang('adminmenu_add_role'),
								'check'=> '',
							]),
						]),
					),
				),
			),
			'raids_points'=> array(
				'icon'=> 'fa-trophy fa-lg fa-fw',
				'text'=> $this->user->lang('adminmenu_raids_points'),
				'check'=> 'a_config_man',
				'sub_menu'=> array(
					'raids'=> array(
						'icon'=> '',
						'text'=> $this->user->lang('adminmenu_raids'),
						'check'=> 'a_raid_add',
						'links'=> array([
							'link'=> 'admin/manage_raids.php'.$this->SID,
							'icon'=> '',
							'text'=> $this->user->lang('adminmenu_manage_raids'),
							'check'=> '',
							'sub_links'=> array([
								'link'=> 'admin/manage_raids.php'.$this->SID,
								'icon'=> 'fa-plus',
								'text'=> $this->user->lang('adminmenu_add_raid'),
								'check'=> '',
							]),
						]),
					),
					'items'=> array(
						'icon'=> '',
						'text'=> $this->user->lang('adminmenu_items'),
						'check'=> 'a_item_',
						'links'=> array([
							'link'=> 'admin/manage_items.php'.$this->SID,
							'icon'=> '',
							'text'=> $this->user->lang('adminmenu_manage_items'),
							'check'=> '',
							'sub_links'=> array([
								'link'=> 'admin/manage_items.php'.$this->SID,
								'icon'=> 'fa-plus',
								'text'=> $this->user->lang('adminmenu_add_item'),
								'check'=> '',
							]),
						]),
					),
					'adjustments'=> array(
						'icon'=> '',
						'text'=> $this->user->lang('adminmenu_adjustments'),
						'check'=> 'a_indivadj_',
						'links'=> array([
							'link'=> 'admin/manage_adjustments.php'.$this->SID,
							'icon'=> '',
							'text'=> $this->user->lang('adminmenu_manage_adjustments'),
							'check'=> '',
							'sub_links'=> array([
								'link'=> 'admin/manage_adjustments.php'.$this->SID,
								'icon'=> 'fa-plus',
								'text'=> $this->user->lang('adminmenu_add_adjustment'),
								'check'=> '',
							]),
						]),
					),
					'auto_points'=> array(
						'icon'=> '',
						'text'=> $this->user->lang('adminmenu_auto_points'),
						'check'=> 'a_config_man',
						'links'=> array([
							'link'=> 'admin/manage_auto_points.php'.$this->SID,
							'icon'=> '',
							'text'=> $this->user->lang('adminmenu_manage_auto_points'),
							'check'=> '',
						]),
					),
					'events'=> array(
						'icon'=> '',
						'text'=> $this->user->lang('adminmenu_events'),
						'check'=> 'a_event_upd',
						'links'=> array([
							'link'=> 'admin/manage_events.php'.$this->SID,
							'icon'=> '',
							'text'=> $this->user->lang('adminmenu_manage_events'),
							'check'=> '',
							'sub_links'=> array([
								'link'=> 'admin/manage_events.php'.$this->SID,
								'icon'=> 'fa-plus',
								'text'=> $this->user->lang('adminmenu_add_event'),
								'check'=> '',
							]),
						]),
					),
					'pools'=> array(
						'icon'=> '',
						'text'=> $this->user->lang('adminmenu_pools'),
						'check'=> '',
						'links'=> array([
							'link'=> 'admin/_____.php'.$this->SID,
							'icon'=> '',
							'text'=> 'MDKP?'.$this->user->lang('adminmenu_manage_pools'),
							'check'=> '',
							'sub_links'=> array([
								'link'=> 'admin/_____.php'.$this->SID,
								'icon'=> 'fa-plus',
								'text'=> $this->user->lang('adminmenu_add_pool'),
								'check'=> '',
							]),
						]),
					),
					'itempools'=> array(
						'icon'=> '',
						'text'=> $this->user->lang('adminmenu_itempools'),
						'check'=> 'a_event_upd',
						'links'=> array([
							'link'=> 'admin/manage_itempools.php'.$this->SID,
							'icon'=> '',
							'text'=> $this->user->lang('adminmenu_manage_itempools'),
							'check'=> '',
							'sub_links'=> array([
								'link'=> 'admin/manage_itempools.php'.$this->SID,
								'icon'=> 'fa-plus',
								'text'=> $this->user->lang('adminmenu_add_itempool'),
								'check'=> '',
							]),
						]),
					),
					'raid_groups'=> array(
						'icon'=> '',
						'text'=> $this->user->lang('adminmenu_raid_groups'),
						'check'=> array('OR', ['a_raidgroups_man', 'a_raidgroups_grpleader']),
						'links'=> array([
							'link'=> 'admin/manage_raid_groups.php'.$this->SID,
							'icon'=> '',
							'text'=> $this->user->lang('adminmenu_manage_raid_groups'),
							'check'=> '',
							'sub_links'=> array([
								'link'=> 'admin/manage_raid_groups.php'.$this->SID,
								'icon'=> 'fa-plus',
								'text'=> $this->user->lang('adminmenu_add_raid_group'),
								'check'=> '',
							]),
						]),
					),
					'export'=> array(
						'icon'=> '',
						'text'=> $this->user->lang('adminmenu_export'),
						'check'=> 'a_',
						'links'=> array([
							'link'=> 'admin/manage_export.php'.$this->SID,
							'icon'=> '',
							'text'=> $this->user->lang('adminmenu_exporting'),
							'check'=> '',
						]),
					),
				),
			),
		);
		
		// Now get plugin hooks for the menu
		if(is_array($this->pm->get_menus('admin'))) $admin_menu = array_merge_recursive($admin_menu, $this->pm->get_menus('admin'));
		/* How to Build your Plugin Array:
			// You can add your own sub_menu, sub_menu category, links and sub_links or extend exist sub_menu
			// If you extend a menu-item then you can't edit the icon, check, etc for this menu-item
			// Else feel free to choose your own icon, sub_menu category, or any other
				
				return array(
					'system'=> array(
						'sub_menu'=> array(			#<-- this is pre-defined
							'settings'=> array(
								'links'=> array([	#<-- this is pre-defined
									'link'=> 'plugins/my_plugin/admin/manage_settings.php'.$this->SID,
									'icon'=> 'fa-cog',
									'text'=> $this->user->lang('adminmenu_general'),
									'check'=> 'a_my_plugin_config',
									'sub_links'=>array(	#<-- this is pre-defined
										[...],
										[...],
									)
								],
								[... my other link ...],
								),
							),
						),
					),
				);
		*/
		
		$blnRemoveUnknown = false;
		$arrAdminFavs = $this->config->get('admin_favs');
		foreach($arrAdminFavs as $strCategory => $arr_category){
			if(isset($admin_menu[$strCategory])){
				foreach($arr_category['sub_menu'] as $strSubCategory => $arr_sub_category){
					if(isset($admin_menu[$strCategory]['sub_menu'][$strSubCategory])){
						foreach($arr_sub_category['links'] as $intLinkID => $arrLink){
							if(isset($admin_menu[$strCategory]['sub_menu'][$strSubCategory]['links'][$intLinkID])){
								$admin_menu[$strCategory]['sub_menu'][$strSubCategory]['links'][$intLinkID]['fav'] = true;
							}else{
								$blnRemoveUnknown = true; unset($arrAdminFavs[$strCategory]['sub_menu'][$strSubCategory]['links'][$intLinkID]);
							}
						}
					}else{
						$blnRemoveUnknown = true; unset($arrAdminFavs[$strCategory]['sub_menu'][$strSubCategory]);
					}
				}
			}else{
				$blnRemoveUnknown = true; unset($arrAdminFavs[$strCategory]);
			}
		}
		if($blnRemoveUnknown) $this->config->set('admin_favs', serialize($arrAdminFavs));
		
		
		#d($this->config->get('admin_favs'));
		#$this->config->set('admin_favs', null);
		
		return $admin_menu;
	}
	
	public function setAdminTooltip()
	{
		$admin_menu = $this->adminmenu(false, "", "", true);

		// Add favorites to template vars
		foreach (array_slice($admin_menu['favorits'], 2) as $fav)
		{
			$this->tpl->assign_block_vars('admin_tooltip', array(
				'LINK' => $fav['link'],
				'TEXT' => $fav['text'],
				'ICON' => $fav['icon'],
			));
		}
	}
}
}
?>
