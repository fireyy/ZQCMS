<?php
defined('IN_ZQCMS') or exit('Permission deiened');
zq_core::load_sys_class('admin','',0);

class urlrule extends admin {
	function __construct() {
		parent::__construct();
		$this->urlrule_db = zq_core::load_model('option_model');
	}
	
	function init () {
		$infos = $this->urlrule_db->select(array("group"=>"1"));
		//$this->public_cache_urlrule();
		include $this->admin_tpl('urlrule_list');
	}
	
	function edit() {
		if(isset($_POST['dosubmit'])) {
			$urlruleid = intval($_GET['urlruleid']);
			$this->urlrule_db->update($_POST['info'],array('id'=>$urlruleid));
			//$this->public_cache_urlrule();
			showMsg("更新成功", "?m=admin&c=urlrule");
		} else {
			$urlruleid = $_GET['urlruleid'];
			$r = $this->urlrule_db->get_one(array('id'=>$urlruleid));
			extract($r);
			include $this->admin_tpl('urlrule_edit');
		}
	}
	/**
	 * 更新URL规则
	 */
	public function public_cache_urlrule() {
		$datas = $this->urlrule_db->select(array("group"=>"1"));
		$search = $replace = array();
		foreach($datas as $key=>$r) {
			$search[] = "~".$r["name"]."~";
			$replace[] = $r["value"];
		}
		$config_path = ZQCMS_PATH."caches/configs/";
		$template = file_get_contents($config_path.'router.sample.php');
		$router = str_replace($search, $replace, $template);
		if(file_put_contents($config_path.'router.php', $router)) {
			chmod($config_path.'router.php', 0640);
		}

		showMsg("更新成功", "?m=admin&c=urlrule");
	}
	private function write_web_server_rules() {
		//
	}
}
?>