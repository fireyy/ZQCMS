<?php
/**
 * 关系表
 * 与tag_taxonomy进行关联,
 * 内容id / typeid 联合唯一
 *
 */
defined("IN_ZQCMS") or exit("Permission denied.");
zq_core::load_sys_class("model", '', 0);

class tag_relationship_model extends model {
    public $table_name = "";
    public function __construct() {
	$this->db_config = zq_core::load_config("database");
	$this->setting = 'default';
	$this->table_name = 'tag_relationships';
	parent::__construct();
    }
}
?>
