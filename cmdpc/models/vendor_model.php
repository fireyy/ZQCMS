<?php
//厂商数据模型
class vendor_model extends model {
    public function __construct(){
	global $_CONFIG;
	$this->db_config = $_CONFIG["dbs"];
	$this->db_setting = 'default';
	$this->table_name = "addoncompany";

	parent::__construct();
    }
}
?>
