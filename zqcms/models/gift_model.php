<?php
defined("IN_ZQCMS") or exit("Permission denied.");
zq_core::load_sys_class("model", '', 0);

class gift_model extends tag {
    public $table_name = "";

    public function __construct() {
	$this->db_config = zq_core::load_config("database");
	$this->setting = 'default';
	$this->table_name = 'gifts';
	parent::__construct();
	
	$type_model = zq_core::load_model('type_model');
	$this->typeid = $type_model->getTypeIdByTableName($this->table_name);
    }

    public function addGift($data) {
	$info = $this->get_one(array('guid' => $data->guid));
	if (is_array($info) && !empty($info)) {
	    return $this->updateGame($data);
	}

	$insert_data = array(
	    'guid' => $data->guid,
	    'typeid' => $this->typeid,
	    'title' => $data->giftTitle,
	    'shorttitle' => $data->giftTitle,
	    'flag' => getFlags($data->isTop),
	    'color' => $data->fontColor,
	    'click' => rand(0, 500),
	    'source' => $data->copyFrom,
	    'rank' => time(),
	    'pubdate' => time(),
	    'senddate' => time(),
	    'lastpost' => time(),
	    'game_name' => $data->gameName,
	    'game_id' => $data->gameId
	    'oper_short_name' => $data->operShortName,
	    'server_name' => $data->serverName,
	    'send_date' => $data->sendDate / 1000,
	    'get_url' => $data->getUrl,
	    'gift_id' => $data->giftId,
	    'oper_id' => $data->operId,
	    'gift_type' => $data->giftType
	);

    }

    public function deleteGift($guid) {

    }

    public function updateGift($data) {

    }
}


?>

