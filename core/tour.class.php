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

if(!defined('EQDKP_INC')){
	header('HTTP/1.0 404 Not Found');exit;
}

class tour extends gen_class {
	
	private $cookie			= array();
	private $cookie_time	= 0;
	private $lang			= array();
	private $steps			= array();
	private $step_keys		= array();
	
	public function init(){
		if($this->init_language() && $this->init_steps()){
			$strHandle			= $this->in->get('tour');
			$this->cookie		= unserialize(base64_decode($this->in->getEQdkpCookie('tour')));
			$this->cookie_time	= time() + 3600 * 24 * 30; // 30 Days
			$blnForceExecute	= false;
			$blnRedirect		= false;
			
			if($strHandle) switch($strHandle){
				case 'hide':
					set_cookie('tour', '', 0);
					$this->pdh->put('user', 'hide_tour_info', array($this->user->id));
					$this->user->data['hide_tour_info'] = 1;
					break;
				
				case 'abort':
					if(!$this->cookie['step']) $this->cookie['step'] = 0;
					set_cookie('tour', base64_encode(serialize([
						'step'		=> $this->cookie['step'],
						'step_keys'	=> $this->step_keys,
					])), $this->cookie_time);
					break;
				
				case 'start':
					set_cookie('tour', base64_encode(serialize([
						'step'		=> 0,
						'step_keys'	=> $this->step_keys,
					])), $this->cookie_time);
					$this->cookie['step'] = 0;
					$blnForceExecute = true;
					$blnRedirect = true;
					break;
				
				case 'next':
					$this->cookie['step'] = (is_int($this->cookie['step']))? $this->cookie['step'] + 1 : 0;
					set_cookie('tour', base64_encode(serialize([
						'step'		=> $this->cookie['step'],
						'step_keys'	=> $this->step_keys,
					])), $this->cookie_time);
					$blnForceExecute = true;
					$blnRedirect = true;
					break;
				
				case 'show':
					$blnForceExecute = true;
					break;
				
				default:
					$result = preg_match('/step_(\d+)/', $strHandle, $match);
					if($result && $match[1] >= 0){
						set_cookie('tour', base64_encode(serialize([
							'step'		=> (int)$match[1],
							'step_keys'	=> $this->step_keys,
						])), $this->cookie_time);
						$this->cookie['step'] = (int)$match[1];
						$blnForceExecute = true;
						$blnRedirect = true;
					} break;
			}
			
			if(!$this->user->data['hide_tour_info'] || $blnForceExecute){
				if($blnForceExecute){
					if($this->compare_steps()) $blnRedirect = true;
					$this->execute_step($this->cookie['step'], $blnRedirect);
				}else{
					$this->core->message(sprintf($this->lang['hide_tour_info'], $this->cookie['step']));
				}
			}
		}
		
		return;
	}
	
	private function init_steps(){
		$bottom_right_400 = 'position: fixed;width: 400px;bottom: 90px;right: 30px;';
		
		$arrSteps = array(
			0	=> array(
				'url'	=> 'admin/index.php',
				'check'	=> '',
				'icon'	=> 'fa-flag',
				'title'	=> $this->lang['step_0_title'],
				'sub_steps' => array([
					'marker_js_selector'	=> '#personalAreaUser .admin-tooltip-container',
					'info_box_position'		=> $bottom_right_400,
					'text'					=> $this->lang['step_0_0_text'],
				]),
			),
			1	=> array(
				'url'	=> 'admin/manage_settings.php',
				'check'	=> 'a_config_man',
				'icon'	=> 'fa-wrench',
				'title'	=> $this->lang['step_1_title'],
				'sub_steps' => array([
					'marker_js_selector'	=> '#core_settings',
					'info_box_position'		=> $bottom_right_400,
					'text'					=> $this->lang['step_1_0_text'],
				],[
					'marker_js_selector'	=> '#adminmenu',
					'info_box_position'		=> $bottom_right_400,
					'text'					=> $this->lang['step_1_1_text'],
				]),
			),
			2	=> array(
				'url'	=> 'admin/manage_pagelayouts.php',
				'check'	=> 'a_config_man',
				'icon'	=> 'fa-table',
				'title'	=> $this->lang['step_2_title'],
				'sub_steps' => array([
					'marker_js_selector'	=> '#lm_tabs',
					'info_box_position'		=> $bottom_right_400,
					'text'					=> $this->lang['step_2_0_text'],
				]),
			),
			3	=> array(
				'url'	=> 'admin/manage_extensions.php',
				'check'	=> 'a_extensions_man',
				'icon'	=> 'fa-cogs',
				'title'	=> $this->lang['step_3_title'],
				'sub_steps' => array([
					'marker_js_selector'	=> '#plus_plugins_tab',
					'info_box_position'		=> $bottom_right_400,
					'text'					=> $this->lang['step_3_0_text'],
				]),
			),
			4	=> array(
				'url'	=> 'admin/manage_portal.php',
				'check'	=> 'a_extensions_man',
				'icon'	=> 'fa-columns',
				'title'	=> $this->lang['step_4_title'],
				'sub_steps' => array([
					'marker_js_selector'	=> '#portal_tabs',
					'info_box_position'		=> $bottom_right_400,
					'text'					=> $this->lang['step_4_0_text'],
				],[
					'marker_js_selector'	=> '#layouts .tableHeader',
					'info_box_position'		=> $bottom_right_400,
					'text'					=> $this->lang['step_4_1_text'],
				]),
			),
			5	=> array(
				'url'	=> 'admin/manage_users.php',
				'check'	=> 'a_users_man',
				'icon'	=> 'fa-user',
				'title'	=> $this->lang['step_5_title'],
				'sub_steps' => array([
					'marker_js_selector'	=> 'form[name="post"]',
					'info_box_position'		=> $bottom_right_400,
					'text'					=> $this->lang['step_5_0_text'],
				]),
			),
			6	=> array(
				'url'	=> 'admin/manage_user_groups.php',
				'check'	=> 'a_usergroups_',
				'icon'	=> 'fa-group',
				'title'	=> $this->lang['step_6_title'],
				'sub_steps' => array([
					'marker_js_selector'	=> 'form[name="post"]',
					'info_box_position'		=> $bottom_right_400,
					'text'					=> $this->lang['step_6_0_text'],
				],[
					'marker_js_selector'	=> '#user_group_perms',
					'info_box_position'		=> $bottom_right_400,
					'text'					=> $this->lang['step_6_1_text'],
				],[
					'marker_js_selector'	=> '#user_groups_table',
					'info_box_position'		=> $bottom_right_400,
					'text'					=> $this->lang['step_6_2_text'],
				]),
			),
			7	=> array(
				'url'	=> 'admin/manage_raids.php',
				'check'	=> 'a_raid_',
				'icon'	=> 'fa-trophy',
				'title'	=> $this->lang['step_7_title'],
				'sub_steps' => array([
					'marker_js_selector'	=> '.page-adminmanage_raids form[method="post"]',
					'info_box_position'		=> $bottom_right_400,
					'text'					=> $this->lang['step_7_0_text'],
				]),
			),
			8	=> array(
				'url'	=> 'admin/manage_article_categories.php',
				'check'	=> 'a_articles_man',
				'icon'	=> 'fa-file-text',
				'title'	=> $this->lang['step_8_title'],
				'sub_steps' => array([
					'marker_js_selector'	=> 'form[name="post"]',
					'info_box_position'		=> $bottom_right_400,
					'text'					=> $this->lang['step_8_0_text'],
				]),
			),
			9	=> array(
				'url'	=> 'admin/manage_backup.php',
				'check'	=> 'a_backup',
				'icon'	=> 'fa-floppy-o',
				'title'	=> $this->lang['step_9_title'],
				'sub_steps' => array([
					'marker_js_selector'	=> '#backup_tabs',
					'info_box_position'		=> $bottom_right_400,
					'text'					=> $this->lang['step_9_0_text'],
				]),
			),
			10	=> array(
				'url'	=> 'admin/index.php',
				'check'	=> '',
				'icon'	=> 'fa-flag-checkered',
				'title'	=> $this->lang['step_10_title'],
				'sub_steps' => array([
					'marker_js_selector'	=> '#admininfos_tabs li[aria-controls="fragment-4"]',
					'info_box_position'		=> $bottom_right_400,
					'text'					=> $this->lang['step_10_0_text'],
				]),
			),
		);
		
		foreach($arrSteps as $intStep => $arrStep){
			if(empty($arrStep['check']) || $this->user->check_auth($arrStep['check'], false)){
				$this->steps[]		= $arrStep;
				$this->step_keys[]	= $intStep;
			}
		}
		
		return (count($this->steps) > 2)? true : false;
	}
	
	public function init_language(){
		$strLanguageFile = $this->root_path.'language/'.sanitize($this->user->data['user_lang']).'/lang_tour.php';
		if(file_exists($strLanguageFile)){
			include_once($strLanguageFile);
			$this->lang = $lang;
			return true;
		}
		return false;
	}
	
	public function execute_step($intStep, $blnRedirect){
		if(!$blnRedirect){
			if(!isset($this->steps[$intStep])){
				set_cookie('tour', '', 0);
				$this->pdh->put('user', 'hide_tour_info', array($this->user->id));
				redirect($this->controller_path_plain.$this->SID, false, false, false); die;
			}
			
			$arrStep	= $this->steps[$intStep];
			$strTitle	= $this->lang['tour_step'].' '.($intStep+1).': '.(($arrStep['icon'])?'<i class="fa '.$arrStep['icon'].'"></i> ' : ' ').$arrStep['title'];
			
			$strJS = '
				$("#eqdkp-tour .tour-marker").on("click", function(){
					$("#eqdkp-tour .tour-shadow").animate({
	    				"background-color": "#000",
	  				}, 2000, "swing", function(){
						var match	= /\(([0-9]+)\/[0-9]+\)/.exec( $("#eqdkp-tour .tour-info h3 span").text() );
						
						if(match[1] < '.count($arrStep['sub_steps']).'){
							tour_process_step(match[1]);
						}else{
							$("#eqdkp-tour .tour-marker").attr("style", "top:-10px;left:-10px;width:0px;height:0px;");
							$("#eqdkp-tour .tour-info").hide();
							$("#eqdkp-tour .tour-pagination").hide();
							$("#eqdkp-tour .tour-completed").show();
							
							$("#eqdkp-tour .tour-shadow").animate({
			    				"display": "block",
			  				}, 2000, "swing", function(){
								window.location.search = mmocms_sid+"&tour='.((isset($this->steps[($intStep+1)]))? "next" : "hide").'";
							});
						}
						
						$("#eqdkp-tour .tour-shadow").animate({
		    				"background-color": "transparent",
		  				}, 2000);
					});
				});
				$("#eqdkp-tour .tour-info .tour-hint").on("click", function(event){
					event.preventDefault();
					$("#eqdkp-tour .tour-marker").stop()
						.animate({borderColor: "#F00"}, 1000)
					    .animate({borderColor: "transparent"}, 1000)
					    .animate({borderColor: "#F00"}, 1000)
					    .animate({borderColor: "transparent"}, 1000)
					    .animate({borderColor: "#F00"}, 1000)
					    .animate({borderColor: "transparent"}, 1000);
				});
				var tour_process_step = function(step){
					var steps	= '.json_encode($arrStep['sub_steps']).';
					var marker	= ($(steps[step]["marker_js_selector"]).length > 0)? $(steps[step]["marker_js_selector"]) : $("body");
					
					$("#eqdkp-tour .tour-info > span").html(steps[step]["text"]);
					$("#eqdkp-tour .tour-info > h3 span").text("("+(parseInt(step) + 1)+"/'.count($arrStep['sub_steps']).')");
					$("#eqdkp-tour .tour-info").attr("style", steps[step]["info_box_position"]);
					
					$("#eqdkp-tour .tour-marker").css("top", marker.offset().top - 6+"px");
					$("#eqdkp-tour .tour-marker").css("left", marker.offset().left - 6+"px");
					$("#eqdkp-tour .tour-marker").css("height", marker.height()+6+"px");
					$("#eqdkp-tour .tour-marker").css("width", marker.width()+6+"px");
					
				}; tour_process_step(0);
			';
			
			$strHTML = '
				<div id="eqdkp-tour" data-step-id="'.$intStep.'">
					<div class="tour-marker"></div>
					<div class="tour-info">
						<h3>'.$strTitle.'<span>(1/'.count($arrStep['sub_steps']).')</span></h3>
						<span class="tour-text"></span>
						<a class="tour-hint" href="">'.$this->lang['tour_hint'].'</a>
						<a class="button tour-exit" href="javascript:window.location.search = mmocms_sid+\'&tour=abort\';">'.$this->lang['tour_exit'].'</a>
					</div>
			';
			
			$intActiveStep = $intStep;
			$strHTML .= '<div class="tour-pagination"><ul>';
			foreach($this->steps as $intStep => $arrStep){
				$strHTML .= '<li'.(($intStep < $intActiveStep)?' class="completed"':'').'><span onclick="window.location.search = mmocms_sid+\'&tour=step_'.$intStep.'\';" data-tooltip="'.$arrStep['title'].'">'.($intStep+1).'</span></li>';
			}
			$strHTML .= '</ul></div>
					<div class="tour-shadow"></div>
					<div class="tour-completed" style="display:none;">
						'.((isset($this->steps[($intActiveStep+1)]))? $this->lang['tour_step_completed'] : $this->lang['tour_completed']).'
					</div>
				</div>
			';
			
			$this->tpl->assign_vars(['S_EQDKP_TOUR' => true, 'EQDKP_TOUR' => $strHTML]);
			$this->tpl->add_css('body { pointer-events: none !important; }');
			$this->tpl->add_js($strJS, 'static_docready');
			
		}else{
			redirect($this->steps[$intStep]['url'].$this->SID.'&tour=show', false, false, false); die;
		}
	}
	
	private function compare_steps(){
		if(isset($this->cookie['step_keys']) && ($this->step_keys != $this->cookie['step_keys'])){
			set_cookie('tour', base64_encode(serialize([
				'step'		=> 0,
				'step_keys'	=> $this->step_keys,
			])), $this->cookie_time);
			$this->cookie['step'] = 0;
			
			return true;
		}
	}
}
?>