<?php
defined("IN_ZQCMS") or exit("Permission denied.");
zq_core::load_sys_class("model", '', 0);

class hits_model extends model {
	public $table_name = '';
	public function __construct() {
		$this->db_config = zq_core::load_config('database');
		$this->db_setting = 'default';
		$this->table_name = 'hits';
		parent::__construct();
	}
}
?>