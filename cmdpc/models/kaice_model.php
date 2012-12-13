<?php
//开测数据模型
class kaice_model extends model {
    public function __construct(){
	global $_CONFIG;
	$this->db_config = $_CONFIG["dbs"];
	$this->db_setting = 'default';
	$this->table_name = "addonkaice";

	parent::__construct();
    }
}
?>
