<?php
class gallery_model extends model 
{
	public function __construct()
	{
		global $_CONFIG;
		$this->db_config = $_CONFIG["dbs"];
		$this->db_setting = 'default';
		$this->table_name = 'addongallery';
		
		parent::__construct();
	}
}
?>
