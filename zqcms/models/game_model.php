<?php
defined("IN_ZQCMS") or exit("Permission denied.");
zq_core::load_sys_class("model", '', 0);

class game_model extends model {
    public $table_name = "";

    public function __construct() {
	$this->db_config = zq_core::load_config('database');
	$this->setting = 'default';
	$this->table_name = 'game';
	parent::__construct();
    }

    /**
     * 获得当前游戏的数量
     */
    public function getTotalCount() {
	return $this->count();
    }

    /**
     * 活得游戏分数
     */
    public function getGoodAndBadPost($id) {
	$result = $this->get_one(array("id"=>$id), "goodpost, badpost");

	return $result;
    }

    /**
     * 增加一个游戏
     *
     * @param object $data
     */
    public function addGame($data) {
	$info = $this->get_one(array('guid' => $data->guid));
	if (is_array($info) && !empty($info)) {
	    return $this->updateGame($data);
	}
	
	//现在所有的数据都会在这里插入
	// game_tag  category
	// effect
	// theme
	// status
	// test_status
    }

    /**
     * 删除一个游戏
     */
    public function deleteGame() {

    }

    /**
     * 删除一个游戏
     */
    public function updateGame() {

    }
}
?>
