<?php
defined("IN_ZQCMS") or exit("Permission denied.");
zq_core::load_sys_class("model", '', 0);
class link_model extends model {
	function __construct() {
		$this->db_config = zq_core::load_config('database');
		$this->db_setting = 'default';
		$this->table_name = 'links';
		parent::__construct();
	} 
}
?>