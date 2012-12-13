<?php
//礼包点卡模型
class gift_model extends model 
{
    public function __construct()
    {
	global $_CONFIG;	
	$this->db_config = $_CONFIG["dbs"];
	$this->de_setting = 'default';
	$this->table_name = "addongift";

	parent::__construct();
    }
}
?>
