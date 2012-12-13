<?php
/**
 * 广告界面Model
 */
class advert_model extends model {
    public function __construct(){
	global $_CONFIG;
	$this->db_config = $_CONFIG["dbs"];
	$this->db_setting = 'default';
	$this->table_name = "myad";

	parent::__construct();
    }
}

?>
