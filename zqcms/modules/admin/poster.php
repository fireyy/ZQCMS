<?php 
defined('IN_ZQCMS') or exit('Permission deiened');
zq_core::load_sys_class('admin','',0);

class poster extends admin {
	private $pdb, $s_db;
	function __construct() {
		parent::__construct();
		$this->pdb = zq_core::load_model('poster_model');
	}
	
	/**
	 * 广告列表
	 */
	public function init() {
		$page = max($_GET['page'], 1);
		$infos = $this->pdb->listinfo('', '`id` ASC', $page);
		$pages = $this->pdb->pages;
		include $this->admin_tpl('poster_list');
	}
	
	/**
	 * 添加广告
	 */
	public function add() {
		if (isset($_POST['dosubmit'])) {
			$poster = $this->check($_POST['poster']);
			$poster['addtime'] = SYS_TIME;
			$poster['content'] = addslashes($poster['content']);
			$poster['default'] = $poster['content'];
			$id = $this->pdb->insert($poster, true);
			if ($id) {
				$this->create_js($id);
				showMsg("添加成功", 'index.php?m=admin&c=poster');
			} else {
				showMsg("添加失败", 'index.php?m=admin&c=poster');
			}
		}else{
			include $this->admin_tpl('poster_add');
		}
	}
	
	/**
	 * 广告修改
	 */
	public function edit() {
		$_GET['id'] = intval($_GET['id']);
		if (!$_GET['id']) showMsg('非法参数', HTTP_REFERER);
		if (isset($_POST['dosubmit'])) {
			$poster = $this->check($_POST['poster']);
			$this->pdb->update($poster, array('id'=>$_GET['id']));
			$this->create_js(intval($_GET['id']));
			showMsg("修改成功", 'index.php?m=admin&c=poster');
		} else {
			
			$info = $this->pdb->get_one(array('id'=>$_GET['id']));
			include $this->admin_tpl('poster_edit');
		}
	}
	
	/**
	 * 广告排序
	 */
	public function listorder() {
		if (isset($_POST['listorder']) && is_array($_POST['listorder'])) {
			$listorder = $_POST['listorder'];
			foreach ($listorder as $k => $v) {
				
				$this->pdb->update(array('listorder'=>$v), array('id'=>$k));
			}
		}
		showMsg('操作成功', HTTP_REFERER);
	}

	/**
	 * 广告预览
	 */
	public function preview() {
		$_GET['id'] = intval($_GET['id']);
		if (!$_GET['id']) showMsg('非法参数', HTTP_REFERER);
		$info = $this->pdb->get_one(array('id'=>$_GET['id']));
		include $this->admin_tpl('poster_preview');
	}

	/**
	 * 刷新广告缓存
	 */
	public function ref_cache() {
		$infos = $this->pdb->select();
		foreach ($infos as $info) {
			delcache('poster_'.$info['sign'], 'commons');
		}
		showMsg('广告缓存刷新成功', HTTP_REFERER);
	}
	
	/**
	 * 生成广告js文件
	 * @param intval $id 广告版位ID
	 * @return boolen 成功返回true
	 */
	private function create_js($id = 0) {
		$info = $this->pdb->get_one(array('id'=>$id));
		delcache('poster_'.$info['sign'], 'commons');
		return true;
	}
	
	/**
	 * 启用、停用广告。此方法不真正执行操作，调用真正的操作方法
	 * @param intval $id 广告ID
	 */
	public function public_approval() {
		if (!isset($_POST['id']) || !is_array($_POST['id'])) {
			showMsg('非法参数', HTTP_REFERER);
		} else {
			array_map(array($this, _approval), $_POST['id']);
			showMsg('操作成功', HTTP_REFERER);
		}
	}
	
	private function _approval($id = 0) {
		$id = intval($id);
		if (!$id) return false;
		$_GET['passed'] = intval($_GET['passed']);
		$this->pdb->update(array('disabled'=>$_GET['passed'] ), array('id'=>$id));
		return true;
	}
	
	/**
	 * 删除广告 此方法不真正执行删除操作，调用真正的删除操作方法
	 * @param invtal $id 广告ID
	 */
	public function delete() {
		if (!isset($_POST['id']) || !is_array($_POST['id'])) {
			showMsg('非法参数', HTTP_REFERER);
		} else {
			array_map(array($this, _del), $_POST['id']);
			showMsg('操作成功', HTTP_REFERER);
		}
	}
	
	/***
	 * 广告删除
	 */
	private function _del($id = 0) {
		$id = intval($id);
		if (!$id) return false;
		$this->pdb->delete(array('id'=>$id));
		return true;
	}
	
	/**
	 * 检查广告属性信息
	 * @param array $data
	 * return array
	 */
	private function check($data) {
		if (!isset($data['name']) || empty($data['name'])) showMsg("广告名称不能为空", HTTP_REFERER);
		if (!isset($data['content']) || empty($data['content'])) showMsg("广告代码未填写", HTTP_REFERER);
		$data['startdate'] = $data['startdate'] ? strtotime($data['startdate']) : SYS_TIME;
		$data['enddate'] = $data['enddate'] ? strtotime($data['enddate']) : strtotime('next month', $data['startdate']);
		if($data['startdate']>=$data['enddate']) $data['enddate'] = strtotime('next month', $data['startdate']);
		return $data;
	}
	
}
?>