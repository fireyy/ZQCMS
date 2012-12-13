<?php
//添加文章模型
class article_model extends model 
{
	public function __construct()
	{
		global $_CONFIG;
		$this->db_config = $_CONFIG["dbs"];
		$this->db_setting = 'default';
		$this->table_name = 'addonarticle';
		
		parent::__construct();
	}
}
?>
