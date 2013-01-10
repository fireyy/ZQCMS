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

    private function getData($data) {
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
	    'pubdate' => $data->insertTime / 1000,
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
	    'pub_id' => $data->pubId,
	    'pinyin' => $data->pinyin,
	    "game_id" => $data->id
	);

	return $insert_data;
    }

    public function updateGameCompanyRelationship($oper_id, $game_id) {
	$rdb = zq_core::load_model("game_company_model");
	$companydb = zq_core::load_model('company_model');

	$opers = explode(",", $oper_id);
	$game_id = intval($game_id);
	if (!empty($opers) && $game_id) {
	    for ($i = 0; $i < count($opers); $i++) {
		$id = intval(trim($opers[$i]));
		if ($id) {
		    if ($rdb->get_one(array('game_id'=>$game_id, 'company_id' => $id))) {
			continue;
		    } else {
			//绑定一个游戏与厂商
			$rdb->insert(
			    array(
				'game_id' => $game_id,
				'company_id' => $id
			    )
			);
			$companydb->update(array('game_count'=>"+=1"), array('company_id' => $id));
		    }
		}
	    }
	}
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

	$insert_data = $this->getData($data);
	$aid = $this->insert($insert_data, true);

	$this->updateGameCompanyRelationship($data->operId, $data->id);

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


	return $aid;
    }

    /**
     * 删除一个游戏
     */
    public function deleteGame($guid) {
	//$info = $this->get_one(array('guid' => $guid));
	//
	//$rdb = zq_core::load_model("game_company_model");

	//if (is_array($info) && !empty($info)) {
	//    $id = $info["id"];
	//    $this->delete(array('id'=>$id));

	//    $companyids = $rdb->select(array('game_id' => $info['game_id']));
	//    $companydb = zq_core::load_model('company_model');
	//    //更新厂商游戏数量
	//    for ($i = 0; $i < count($companyids); ++$i) {
	//	$companyid = $companyids[$i]['company_id'];
	//	$companydb->update(array('game_count' => '-=1'), array('company_id'=>$companyid));
	//    }

	//    //删除 游戏与厂商的绑定
	//    $rdb->delete(array('game_id' => $info['game_id']));

	//    //删除与之相关的游戏开服数据

	//    //delete tag
	//    zq_tag(false, $aid, $this->typeid, 'tag', 'delete');
	//}
    }

    /**
     * 更新游戏
     */
    public function updateGame($data) {
	$info = $this->get_one(array('guid' => $data->guid));
	if (empty($info)) {
	    return $this->addGame($data);
	}

	$update_data = $this->getData($data);
	$this->update($update_data, array('id'=>$info['id']));

	$this->updateGameCompanyRelationship($data->operId, $data->id);

	$aid = $info['id'];
	
	$game_tag = $data->gameTag;
	if ($game_tag && $aid) {
	    zq_tag($game_tag, $aid, $this->typeid, 'tag', 'update');
	}

	$game_theme = $data->gameTheme;
	if ($game_theme && $aid) {
	    zq_tag($game_theme, $aid, $this->typeid, 'tag', 'update');
	}

	$game_effect = $data->gameEffect;
	if ($game_effect && $aid) {
	    zq_tag($game_effect, $aid, $this->typeid, 'tag', 'update');
	}

	$game_status = $data->gameStatus;
	if ($game_status && $aid) {
	    zq_tag($game_status, $aid, $this->typeid, 'tag', 'update');
	}

	return $info['id'];

    }
}
?>
