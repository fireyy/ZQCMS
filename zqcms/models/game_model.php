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

	$type_model = zq_core::load_model('type_model');
	$this->typeid = $type_model->getTypeIdByTableName($this->table_name);
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
	    'typeid'=>$this->typeid,
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
	    'dev_short_name' => trim($data->devShortName),
	    'pub_short_name' => trim($data->pubShortName),
	    'game_avatar' => trim($data->gameAvatar),
	    'dev_id' => $data->devId,
	    'oper_id' => $data->operId,
	    'pub_id' => $data->pubId,
	    'pinyin' => $data->pinyin,
	    "game_id" => $data->id
	);
	    
	$aid = $this->insert($insert_data, true);

	$game_tag = $data->gameTag;
	if ($game_tag && $aid) {
	    zq_tag($game_tag, $aid, $this->typeid, 'tag');
	}

	$game_theme = $data->gameTheme;
	if ($game_theme && $aid) {
	    zq_tag($game_theme, $aid, $this->typeid, 'tag');
	}

	$game_effect = $data->gameEffect;
	if ($game_effect && $aid) {
	    zq_tag($game_effect, $aid, $this->typeid, 'tag');
	}

	$game_status = $data->gameStatus;
	if ($game_status && $aid) {
	    zq_tag($game_status, $aid, $this->typeid, 'tag');
	}

	/*
	$test_status = $data->testStatus;
	if ($test_status && $aid) {
	    zq_tag($test_status, $aid, $this->typeid, 'tag');
	}
	*/

	return $aid;
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
