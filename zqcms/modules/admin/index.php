<?php
defined('IN_ZQCMS') or exit('Permission deiened');
zq_core::load_sys_class('admin','',0);

class index extends admin {
	public function __construct() {
    parent::__construct();
	}
	
	public function init () {
		$userid = $_SESSION['userid'];
		$admin_username = param::get_cookie('admin_username');
		include $this->admin_tpl('index');
	}

	public function public_main() {
	
		$admin_username = param::get_cookie('admin_username');
		$userid = $_SESSION['userid'];
		$r = $this->db->get_one(array('userid'=>$userid));
		$logintime = $r['lastlogintime'];
		$loginip = $r['lastloginip'];
		include $this->admin_tpl('main');
	}

}
?>