<?php
/**
 * Tag分类总表
 * 只储存tagname, 描述
 *
 */
defined("IN_ZQCMS") or exit("Permission denied.");
zq_core::load_sys_class("model", '', 0);

class tag_model extends model {
    public $table_name = "";

    public function __construct() {
	$this->db_config = zq_core::load_config("database");
	$this->setting = 'default';
	$this->table_name = 'tags';
	parent::__construct();
    }
}


?>
