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

define('EQDKP_INC', true);
define('IN_ADMIN', true);
$eqdkp_root_path = './../';
include_once($eqdkp_root_path.'common.php');

class Manage_Multidkp extends page_generic {

	public function __construct(){
		$handler = array(
			'save' => array('process' => 'save', 'check' => 'a_event_add', 'csrf'=>true),
			'save_sort' => array('process' => 'save_sort', 'check' => 'a_event_add', 'csrf'=>true),
			'upd'	=> array('process' => 'update', 'csrf'=>false),
		);
		parent::__construct('a_event_', $handler);
		$this->process();
	}

	public function save() {
		$mdkp_id = $this->in->get('mdkp_id',0);
		$mdkp = $this->get_post();
		if($mdkp) {
			if($mdkp_id) {
				$retu = $this->pdh->put('multidkp', 'update_multidkp', array($mdkp_id, $mdkp['name'], $mdkp['desc'], $mdkp['events'], $mdkp['itempools'], $mdkp['no_attendance']));
			} else {
				$retu = $this->pdh->put('multidkp', 'add_multidkp', array($mdkp['name'], $mdkp['desc'], $mdkp['events'], $mdkp['itempools'], $mdkp['no_attendance']));
			}
			if(!$retu) {
				$message = array('title' => $this->user->lang('save_nosuc'), 'text' => $mdkp['name'], 'color' => 'red');
			} else {
				$message = array('title' => $this->user->lang('save_suc'), 'text' => $mdkp['name'], 'color' => 'green');
			}
		}
		$this->display($message);
	}

	public function save_sort(){
		$arrSort = $this->in->getArray("sort", "int");

		$this->pdh->put('multidkp', 'save_sort', array($arrSort));


		$message = array('title' => $this->user->lang('success'),'text' => $this->user->lang('save_suc'), 'color' => 'green');
		$this->display($message);
	}

	public function delete() {
		$mdkp_id = $this->in->get('id',0);
		if($mdkp_id) {
			$name = $this->pdh->get('multidkp', 'name', $mdkp_id);
			if(!$this->pdh->put('multidkp', 'delete_multidkp', array($mdkp_id))) {
				$message = array('title' => $this->user->lang('del_nosuc'), 'text' => $name, 'color' => 'red');
			} else {
				$message = array('title' => $this->user->lang('del_suc'), 'text' => $name, 'color' => 'green');
			}
		}
		$this->display($message);
	}

	public function update($message=false) {
		$mdkp_id = $this->in->get('id',0);
		$mdkp = array('events' => array(), 'itempools' => array(), 'no_attendance' => array());
		if($message) {
			$this->core->messages($message);
			$this->pdh->process_hook_queue();
			$mdkp = $this->get_post(true);
		} else {
			$mdkp['name'] = $this->pdh->get('multidkp', 'name', array($mdkp_id));
			$mdkp['desc'] = $this->pdh->get('multidkp', 'desc', array($mdkp_id));
			$mdkp['events'] = array_merge($this->pdh->get('multidkp', 'event_ids', array($mdkp_id, true)), $this->pdh->get('multidkp', 'event_ids', array($mdkp_id)));
			$mdkp['itempools'] = $this->pdh->get('multidkp', 'itempool_ids', array($mdkp_id));
			$mdkp['no_attendance'] = array_diff($this->pdh->get('multidkp', 'event_ids', array($mdkp_id)), $this->pdh->get('multidkp', 'event_ids', array($mdkp_id, true)));
		}

		//events
		$events = $this->pdh->aget('event', 'name', 0, array($this->pdh->sort($this->pdh->get('event', 'id_list'), 'event', 'name')));
		$sel_events = $this->pdh->aget('event', 'name', 0, array($this->pdh->sort($mdkp['events'], 'event', 'name')));
		
		//itempools
		$itempools = $this->pdh->aget('itempool', 'name', 0, array($this->pdh->sort($this->pdh->get('itempool', 'id_list'), 'itempool', 'name')));

		$this->confirm_delete($this->user->lang('confirm_delete_multi').'<br />'.$mdkp['name']);
		$this->tpl->assign_vars(array(
			'NAME'					=> $mdkp['name'],
			'DESC'					=> $mdkp['desc'],
			'EVENT_SEL'				=> (new hmultiselect('events', array('options' => $events, 'value' => $mdkp['events'], 'width' => 300, 'filter' => true)))->output(),
			'ITEMPOOL_SEL'			=> (new hmultiselect('itempools', array('options' => $itempools, 'value' => $mdkp['itempools'], 'width' => 300)))->output(),
			'NO_ATT_SEL'			=> (new hmultiselect('no_atts', array('options' => $sel_events, 'value' => $mdkp['no_attendance'], 'width' => 300, 'filter' => true)))->output(),
			'MDKP_ID'				=> $mdkp_id,
		));

		$this->core->set_vars([
			'page_title'		=> $this->user->lang('manmdkp_title'),
			'template_file'		=> 'admin/manage_multidkp_add.html',
			'page_path'			=> [
				['title'=>$this->user->lang('menu_admin_panel'), 'url'=>$this->root_path.'admin/'.$this->SID],
				['title'=>$this->user->lang('manmdkp_title'), 'url'=>$this->root_path.'admin/manage_multidkp.php'.$this->SID],
				['title'=>(($mdkp_id)?$mdkp['name']:$this->user->lang('Multi_addkonto')), 'url'=>' '],
			],
			'display'			=> true
		]);
	}

	public function display($messages=false) {
		if($messages) {
			$this->pdh->process_hook_queue();
			$this->core->messages($messages);
		}

		$order = $this->in->get('sort','0.0');
		$red = 'RED'.str_replace('.', '', $order);
		$mdkp_ids = $this->pdh->get('multidkp', 'id_list');
		$mdkp = array();
		foreach($mdkp_ids as $id)
		{
			$mdkp[$id]['sortid'] = $this->pdh->get('multidkp', 'sortid', $id);
			$mdkp[$id]['name'] = $this->pdh->get('multidkp', 'name', $id);
			$mdkp[$id]['desc'] = $this->pdh->get('multidkp', 'desc', $id);
			$mdkp[$id]['events'] = $this->pdh->aget('event', 'name', 0, array($this->pdh->get('multidkp', 'event_ids', $id)));
			$mdkp[$id]['no_atts'] = $this->pdh->get('multidkp', 'no_attendance', array($id));
			$ip_ids = $this->pdh->get('multidkp', 'itempool_ids', $id);
			$mdkp[$id]['itempools'] = $this->pdh->aget('itempool', 'name', 0, array(((is_array($ip_ids)) ? $ip_ids : array())));
		}

		$sort_ids = get_sortedids($mdkp, explode('.', $order), array('sortid', 'name', 'desc'));
		foreach($sort_ids as $id) {
			$event_string = array();
			foreach($mdkp[$id]['events'] as $eid => $event) {
				$event_string[] = "<span class='".((in_array($eid, $mdkp[$id]['no_atts'])) ? 'negative' : 'positive')."'>".$event."</span>";
			}
			$this->tpl->assign_block_vars('multi_row', array(
				'ID'		=> $id,
				'NAME'		=> $mdkp[$id]['name'],
				'DESC'		=> $mdkp[$id]['desc'],
				'EVENTS'	=> implode(', ', $event_string),
				'ITEMPOOLS'	=> implode(', ', $mdkp[$id]['itempools']),
			));
		}
		$this->tpl->assign_vars(array(
			'SID'	=> $this->SID,
			$red 	=> '_red',
			'LISTMULTI_COUNT'	=> count($sort_ids),
		));

		$this->tpl->add_js("
			$(\"#multidkpsort tbody\").sortable({
				cancel: '.not-sortable, input, tr th.footer, th',
				cursor: 'pointer',
			});
		", "docready");

		$this->core->set_vars([
			'page_title'		=> $this->user->lang('manmdkp_title'),
			'template_file'		=> 'admin/manage_multidkp.html',
			'page_path'			=> [
				['title'=>$this->user->lang('menu_admin_panel'), 'url'=>$this->root_path.'admin/'.$this->SID],
				['title'=>$this->user->lang('manmdkp_title'), 'url'=>' '],
			],
			'display'			=> true
		]);
	}

	private function get_post($norefresh=false) {
		$mdkp['name'] = $this->in->get('name','');
		$mdkp['desc'] = $this->in->get('desc','');
		$mdkp['events'] = $this->in->getArray('events','int');
		if(!$mdkp['name']) {
			$missing[] = $this->user->lang('Multi_kontoname_short');
		}
		if(!$mdkp['desc']) {
			$missing[] = $this->user->lang('description');
		}
		if(!$mdkp['events']) {
			$missing[] = $this->user->lang('events');
		}
		if(isset($missing) AND !$norefresh) {
			$this->update(array('title' => $this->user->lang('missing_values'), 'text' => implode(', ', $missing), 'color' => 'red'));
		}
		$mdkp['itempools'] = $this->in->getArray('itempools','int');
		$mdkp['no_attendance'] = $this->in->getArray('no_atts', 'int');
		return $mdkp;
	}
}
registry::register('Manage_Multidkp');
?>