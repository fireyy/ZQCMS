<?php
defined("IN_ZQCMS") or exit("Permission denied.");
zq_core::load_sys_class("model", '', 0);

class game_info_model extends model {
    public $table_name = "";

    public function __construct() {
	$this->db_config = zq_core::load_config('database');
	$this->setting = 'default';
	$this->table_name = 'game_info';

	parent::__construct();
    }

    public function addGameInfo($data) {
	$info = $this->get_one(array('guid' => $data->guid));
	if (is_array($info) && !empty($info)) {
	    return $this->updateGameInfo($data);
	}

	$insert_data = array(
	    'guid' => $data->guid,
	    'title' => $data->title,
	    'value' => base64_decode($data->content),
	    "game_id" => $data->gameId
	);
	    
	return $this->insert($insert_data);
    }

    public function deleteGameInfo($guid) {
	$info = $this->get_one(array('guid' => $guid));
	if (is_array($info) && !empty($info)) {
	    $this->delete(array('guid'=>$guid));
	}
    }

    public function updateGameInfo($data) {

    }
}
?>
