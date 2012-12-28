<?php
defined("IN_ZQCMS") or exit("Permission denied.");
zq_core::load_sys_class("model", '', 0);

class kaifu_model extends model {
    public $table_name = "";

    public function __construct() {
	$this->db_config = zq_core::load_config('database');
	$this->setting = 'default';
	$this->table_name = 'kaifus';
	parent::__construct();

	$type_model = zq_core::load_model('type_model');
	$this->typeid = $type_model->getTypeIdByTableName($this->table_name);
    }

    public function getYearAndMonthKaifuCount($year, $month) {
	$maxday_list = array(
	    1 => 31,
	    2 => ((($y % 400 == 0) || (($y % 4 == 0) && ($y % 100 != 0))) ? 29 : 28),
	    3 => 31,
	    4 => 30,
	    5 => 31,
	    6 => 30,
	    7 => 31,
	    8 => 31,
	    9 => 30,
	    10 => 31,
	    11 => 30,
	    12 => 31
	);
	$max_day = $maxday_list[$month];
	$r = $this->select(
	    "DATE_FORMAT(FROM_UNIXTIME(test_date), '%c')  = $month",
	    "COUNT(id) as num, DATE_FORMAT(FROM_UNIXTIME(test_date), '%c') as m, DATE_FORMAT(FROM_UNIXTIME(test_date), '%e') as d",
	    '',
	    '',
	    'd',
	    '',
	    false
	);

	$kaifu_count = 0;
	for ($i = 0; $i < count($r); ++$i) {
	    $kaifu_count+=$r[$i]['num'];
	}
	
	return $kaifu_count;
    }

    public function addKaifu($data) {
	$info = $this->get_one(array('guid' => $data->guid));
	if (is_array($info) && !empty($info)) {
	    return $this->updateKaifu($data);
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
	    'gift_id' => $data->giftId,
	    'oper_id' => $data->operId
	);
	
	$aid = $this->insert($insert_data, true);

	return $aid;
    }

    public function deleteKaifu($guid) {

    }

    public function updateKaifu($data) {

    }
}
?>
