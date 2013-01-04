<?php
defined('IN_ZQCMS') or exit('Permission deiened');
zq_core::load_sys_class('admin','',0);

class update extends admin {
	public function __construct() {
    parent::__construct();
	}
  
	/**
	 * 在线更新
	 */
	public function init() {
	
		#TODO
		include $this->admin_tpl('update');
	}

}
?>