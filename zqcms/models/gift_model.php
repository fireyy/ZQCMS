<?php
defined("IN_ZQCMS") or exit("Permission denied.");
zq_core::load_sys_class("model", '', 0);

class gift_model extends model {
    public $table_name = "";

    public function __construct() {
	$this->db_config = zq_core::load_config("database");
	$this->setting = 'default';
	$this->table_name = 'gifts';
	parent::__construct();
	
	$type_model = zq_core::load_model('type_model');
	$this->typeid = $type_model->getTypeIdByTableName($this->table_name);
    }

    private function getData($data) {
	return array(
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
	    'game_id' => $data->gameId,
	    'oper_short_name' => $data->operShortName,
	    'server_name' => $data->serverName,
	    'send_date' => $data->sendDate / 1000,
	    'get_url' => $data->getUrl,
	    'gift_id' => $data->giftId,
	    'oper_id' => $data->operId,
	    'gift_type' => $data->giftType
	);
    }

    public function addGift($data) {
	$info = $this->get_one(array('guid' => $data->guid));
	if (is_array($info) && !empty($info)) {
	    return $this->updateGift($data);
	}
	
	$insert_data = $this->getData($data);

	$aid = $this->insert($insert_data, true);

	return $aid;
    }

    public function deleteGift($guid) {
    	$info = $this->get_one(array('guid' => $guid));
		if ($info) {
		    $this->delete(array('id' => $info['id']));
		}
    }

    public function updateGift($data) {
	$info = $this->get_one(array('guid' => $data->guid));
	if (empty($info)) {
	    return $this->addGift($data);
	}

	$update_data = $this->getData($data);
	$this->update($update_data, array('id'=>$info['id']));
	
	return $info['id'];
    }
}


?>

