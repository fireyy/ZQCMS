<?php
defined("IN_ZQCMS") or exit("Permission denied.");
zq_core::load_sys_class("model", '', 0);

class game_model extends model {
    public $table_name = "";

    public function __construct() {
	$this->db_config = zq_core::load_config('database');
	$this->setting = 'default';
	$this->table_name = 'games';
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

	$insert_data = array(
	    'guid' => $data->guid,
	    'flag' => getFlags($data->isTop),
	    'game_name' => trim($data->gameName),
	    'shorttitle' => trim($data->gameName),
	    'color' => $data->fontColor,
	    'description'=> $data->gameDescription,
	    'source' => $data->copyFrom,
	    'click' => rand(0, 500),
	    'rank' => time(),
	    'pubdate' => time(),
	    'senddate' => time(),
	    'lastpost' => time(),
	    'game_tag' => $data->gameTag,
	    'game_thumb'=>$data->gameThumb,
	    'game_effect' => $data->gameEffect,
	    'game_theme' => $data->gameTheme,
	    'game_status' => trim($data->gameStatus),
	    'test_status' => trim($data->testStatus),
	    'offical_url' => trim($data->officalUrl),
	    'oper_short_name' => trim($data->operShortName),
	    'dev_short_Name' => trim($data->devShortName),
	    'pub_short_name' => trim($data->pubShortName),
	    'game_avatar' => trim($data->gameAvatar),
	    'dev_id' => $data->devId,
	    'oper_id' => $data->operId,
	    'pub_id' => $data->pubId,
	    'pinyin' => $data->pinyin,
	    "game_id" => $data->id
	);
	
	$aid = $this->insert($insert_data, true);
	//update tag
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
    public function deleteGame($guid) {
	$info = $this->get_one(array('guid' => $guid));
	if (is_array($info) && !empty($info)) {
	    $id = $info["id"];

	    $this->delete(array('id'=>$id));

	    //delete tag
	}
    }

    /**
     * 更新游戏
     */
    public function updateGame($data) {

    }
}
?>
