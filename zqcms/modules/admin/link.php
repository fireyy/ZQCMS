<?php
defined('IN_ZQCMS') or exit('Permission deiened');
zq_core::load_sys_class('admin','',0);

class link extends admin {
	function __construct() {
		parent::__construct();
		$this->M = new_html_special_chars(getcache('link', 'commons'));
		$this->db = zq_core::load_model('link_model');
	}

	public function init() {
 		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$infos = $this->db->listinfo($where,$order = 'listorder DESC,linkid DESC',$page, $pages = '15');
		$pages = $this->db->pages;
		include $this->admin_tpl('link_list');
	}
	 
	//添加友情链接
 	public function add() {
 		$errors = array();
    	$succ = array();
 		if(isset($_POST['dosubmit'])) {
			$_POST['link']['addtime'] = SYS_TIME;
			if(empty($_POST['link']['name'])) {
				$errors[] = "网站名称必填";
			} else {
				$_POST['link']['name'] = safe_replace($_POST['link']['name']);
			}
			if ($_POST['link']['logo']) {
				$_POST['link']['logo'] = safe_replace($_POST['link']['logo']);
			}
			if(empty($errors)){
				$data = new_addslashes($_POST['link']);
				$linkid = $this->db->insert($data,true);
				if($linkid) {
					$succ[] = "添加成功";
					//更新附件状态
					// if(zq_core::load_config('system','attachment_stat') & $_POST['link']['logo']) {
					// 	$this->attachment_db = zq_core::load_model('attachment_model');
					// 	$this->attachment_db->api_update($_POST['link']['logo'],'link-'.$linkid,1);
					// }
				}
			}
		}
		include $this->admin_tpl('link_add');
	}
	
	/**
	 * 说明:异步更新排序 
	 * @param  $optionid
	 */
	public function listorder_up() {
		$result = $this->db->update(array('listorder'=>'+=1'),array('linkid'=>$_GET['linkid']));
		if($result){
			echo 1;
		} else {
			echo 0;
		}
	}
	
	//更新排序
 	public function listorder() {
		if(isset($_POST['dosubmit'])) {
			foreach($_POST['listorders'] as $linkid => $listorder) {
				$linkid = intval($linkid);
				$this->db->update(array('listorder'=>$listorder),array('linkid'=>$linkid));
			}
			showMsg("操作成功",HTTP_REFERER);
		} 
	}
 
	public function edit() {
		if(isset($_POST['dosubmit'])){
 			$linkid = intval($_GET['linkid']);
			if($linkid < 1) return false;
			if(!is_array($_POST['link']) || empty($_POST['link'])) return false;
			if((!$_POST['link']['name']) || empty($_POST['link']['name'])) return false;
			$this->db->update($_POST['link'],array('linkid'=>$linkid));
			//更新附件状态
			// if(zq_core::load_config('system','attachment_stat') & $_POST['link']['logo']) {
			// 	$this->attachment_db = zq_core::load_model('attachment_model');
			// 	$this->attachment_db->api_update($_POST['link']['logo'],'link-'.$linkid,1);
			// }
			showMsg("操作成功",'?m=admin&c=link');
			
		}else{
			//解出链接内容
			$info = $this->db->get_one(array('linkid'=>$_GET['linkid']));
			if(!$info) showMsg("链接不存在");
			extract($info); 
 			include $this->admin_tpl('link_edit');
		}

	}

	/**
	 * 删除友情链接  
	 * @param	intval	$sid	友情链接ID，递归删除
	 */
	public function delete() {
  		if((!isset($_GET['linkid']) || empty($_GET['linkid'])) && (!isset($_POST['linkid']) || empty($_POST['linkid']))) {
			showMsg("参数非法", HTTP_REFERER);
		} else {
			if(is_array($_POST['linkid'])){
				foreach($_POST['linkid'] as $linkid_arr) {
 					//批量删除友情链接
					$this->db->delete(array('linkid'=>$linkid_arr));
					//更新附件状态
					// if(zq_core::load_config('system','attachment_stat')) {
					// 	$this->attachment_db = zq_core::load_model('attachment_model');
					// 	$this->attachment_db->api_delete('link-'.$linkid_arr);
					// }
				}
				showMsg("操作成功",'?m=admin&c=link');
			}else{
				$linkid = intval($_GET['linkid']);
				if($linkid < 1) return false;
				//删除友情链接
				$result = $this->db->delete(array('linkid'=>$linkid));
				//更新附件状态
				// if(zq_core::load_config('system','attachment_stat')) {
				// 	$this->attachment_db = zq_core::load_model('attachment_model');
				// 	$this->attachment_db->api_delete('link-'.$linkid);
				// }
				if($result){
					showMsg("操作成功",'?m=admin&c=link');
				}else {
					showMsg("操作失败",'?m=admin&c=link');
				}
			}
			//showMsg("操作成功", HTTP_REFERER);
		}
	}
	
 	//启用友情链接
 	public function check(){
		if((!isset($_GET['linkid']) || empty($_GET['linkid'])) && (!isset($_POST['linkid']) || empty($_POST['linkid']))) {
			showMsg("参数非法", HTTP_REFERER);
		} else { 
			$linkid = intval($_GET['linkid']);
			if($linkid < 1) return false;
			$result = $this->db->update(array('passed'=>1),array('linkid'=>$linkid));
			if($result){
				showMsg("操作成功",'?m=admin&c=link');
			}else {
				showMsg("操作失败",'?m=admin&c=link');
			}
			 
		}
	}

	//禁用友情链接
	public function uncheck(){
		if((!isset($_GET['linkid']) || empty($_GET['linkid'])) && (!isset($_POST['linkid']) || empty($_POST['linkid']))) {
			showMsg("参数非法", HTTP_REFERER);
		} else { 
			$linkid = intval($_GET['linkid']);
			if($linkid < 1) return false;
			$result = $this->db->update(array('passed'=>0),array('linkid'=>$linkid));
			if($result){
				showMsg("操作成功",'?m=admin&c=link');
			}else {
				showMsg("操作失败",'?m=admin&c=link');
			}
			 
		}
	}
	
	/**
	 * 说明:对字符串进行处理
	 * @param $string 待处理的字符串
	 * @param $isjs 是否生成JS代码
	 */
	function format_js($string, $isjs = 1){
		$string = addslashes(str_replace(array("\r", "\n"), array('', ''), $string));
		return $isjs ? 'document.write("'.$string.'");' : $string;
	}
 
 
	
}
?>