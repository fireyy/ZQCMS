<?php
//开服数据模型
class kaifu_model extends model {
    public function __construct(){
	global $_CONFIG;
	$this->db_config = $_CONFIG["dbs"];
	$this->db_setting = 'default';
	$this->table_name = "addonkaifu";

	parent::__construct();
    }
}
?>
