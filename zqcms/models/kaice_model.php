<?php
defined("IN_ZQCMS") or exit("Permission denied.");
zq_core::load_sys_class("model", '', 0);

class kaice_model extends model {
    public $table_name = "";

    public function __construct() {
	$this->db_config = zq_core::load_config("database");
	$this->setting = 'default';
	$this->table_name = 'kaices';
	parent::__construct();

	$type_model = zq_core::load_model('type_model');
	$this->typeid = $type_model->getTypeIdByTableName($this->table_name);
    }

    public function addKaice($data) {
	$info = $this->get_one(array('guid' => $data->guid));
	if (is_array($info) && !empty($info)) {
	    return $this->updateKaice($data);
	}

	$insert_data = array(
	    'guid' => $data->guid,
	    'typeid' => $this->typeid,
	    'title' => $data->gameName,
	    'shorttitle' => $data->gameName,
	    'flag' => getFlags($data->isTop),
	    'color' => $data->fontColor,
	    'click' => rand(0, 500),
	    'source' => $data->copyFrom,
	    'rank' => time(),
	    'pubdate' => time(),
	    'senddate' => time(),
	    'lastpost' => time(),
	    'game_name' => $data->gameName,
	    'game_tag' => $data->gameTag,
	    'game_id' => $data->gameId,
	    'oper_short_name' => $data->operShortName,
	    'dev_short_name' => $data->devShortName,
	    'server_name' => $data->serverName,
	    'test_date' => $data->testDate / 1000,
	    'register_url' => $data->registerUrl,
	    'data_type' => $data->dataType,
	    'pub_short_name' => $data->pubShortName,
	    'test_status' => $data->testStatus,
	    'get_url' => $data->getUrl,
	    'bbs_url' => $data->bbsUrl,
	    'gift_id' => $data->giftId,
	    'oper_id' => $data->operId
	);

	$aid = $this->insert($insert_data, true);
	return $aid;
    }

    public function deleteKaice($guid) {

    }

    public function updateKaice($data) {

    }
}


?>
