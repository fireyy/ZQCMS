<?php
defined("IN_ZQCMS") or exit("Permission denied.");
zq_core::load_sys_class("model", '', 0);

class type_model extends model {
    public $table_name = "";

    public function __construct() {
	$this->db_config = zq_core::load_config("database");
	$this->setting = 'default';
	$this->table_name = 'types';
	parent::__construct();
    }

    public function getTypeIdByTableName($table_name) {
	if (isset($table_name)) {
	    //自动去除table_prefix
	    $table_name = str_replace($this->table_prefix, '', $table_name);
	    $result = $this->get_one(array('table_name'=>$table_name));
	    if (!empty($result) && is_array($result)) {
		return $result["id"];
	    }
	}
    }
}
?>
