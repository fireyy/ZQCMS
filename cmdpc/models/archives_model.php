<?php
//文章数据模型
class archives_model extends model {
    public function __construct() {
	global $_CONFIG;
	$this->db_config = $_CONFIG['dbs'];
	$this->db_setting = 'default';
	$this->table_name = 'archives';

	parent::__construct();
    }
}

?>
