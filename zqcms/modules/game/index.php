<?php
defined("IN_ZQCMS") or exit("Permission deiened");

class index {
    private $MAX_KAIFUS = 10;
    public function __construct() {
	$this->db = zq_core::load_model('game_model');
    }

    private function getKaifuInfo($game, $timesql, $orderway='ASC') {
	$now = mktime(0, 0, 0);
	$last_now = mktime(23, 59, 59);

	$data = $this->kaifu_db->select(
	    "game_id = {$game['game_id']} AND $timesql",
	    '*',
	    '0, 10',
	    "test_date {$orderway}"
	);

	for ($i = 0; $i < count($data); $i++) {
	    $company_id = $data[$i]['oper_id'];
	    if (empty($company_id)) {
		continue;
	    }

	    if (empty($this->kaifus[$company_id])) {
		$company = $this->company_db->get_one(array('company_id'=>$company_id));
		if (!empty($company)) {
		    $company['url'] = getURL($company);

		    $this->kaifus[$company_id] = array(
			'company' => $company,
			'oper_short_name' => $data[$i]['oper_short_name'],
			'url' => $data[$i]['register_url'],
			'kaifu' => array(
			    'y' => array(),
			    'n' => array(),
			    't' => array()
			)   
		    );
		}
	    }

	    if (!empty($this->kaifus[$company_id])) {
		$currentTestDate = $data[$i]["test_date"];

		//开始插入数据
		if ($currentTestDate >= $now && $currentTestDate <= $last_now) {
		    $this->kaifus[$company_id]['kaifu']['n'][] = $data[$i];
		}

		//最近的一条
		if (empty($this->kaifus[$company_id]['kaifu']['y'])) {
		    if ($currentTestDate < $now) {
			$this->kaifus[$company_id]['kaifu']['y'][] = $data[$i];
		    } else {
			$r = $this->kaifu_db->get_one(
			    "oper_id={$company_id} AND game_id={$game['game_id']} AND test_date < {$currentTestDate}", '*', 'test_date DESC'
			);
			if (!empty($r)) {
			    $this->kaifus[$company_id]['kaifu']['y'][] = $r;
			}
		    }
		}

		//后一条
		if (empty($this->kaifus[$company_id]['kaifu']['t'])) {
		    if ($currentTestDate > $last_now) {
			$this->kaifus[$company_id]['kaifu']['t'][] = $data[$i];
		    } else {
			$r = $this->kaifu_db->get_one(
			    "oper_id={$company_id} AND game_id={$game['game_id']} AND test_date > {$data[$i]['test_date']}", '*', 'test_date ASC'
			);
			if (!empty($r)) {
			    $this->kaifus[$company_id]['kaifu']['t'][] = $r;
			}
		    }
		}
	    }
	}
    }

    //内容页
    public function show() {
	$id = intval($_GET['id']);
	if(isset($id) && !empty($id)){
	    $game = $this->db->get_one(array(
		"id" => $id
	    ));
	    
	    if (empty($game)) {
		ShowMsg("未找到对应的游戏！","-1");
		return;
	    }

	    //获得游戏的运营商数量
	    $rdb = zq_core::load_model('game_company_model');
	    $company_count = $rdb->count(array('game_id' => $game['game_id']));
	    $game['company_count'] = $company_count;

	    $this->kaifus = array();

	    //获取开服信息
	    $this->kaifu_db = zq_core::load_model('kaifu_model');
	    $this->company_db = zq_core::load_model('company_model');
	    

	    $now = mktime(0, 0, 0);
	    $last_now = mktime(23, 59, 59);
	    $this->getKaifuInfo($game, "test_date >= {$now} AND test_date <= {$last_now}");

	    if (count(array_keys($this->kaifus)) < $this->MAX_KAIFUS) {
		$this->getKaifuInfo($game, "test_date < {$now} AND oper_id not in (".join(",", array_keys($this->kaifus)).")", "DESC");
	    }

	    if (count(array_keys($this->kaifus)) < $this->MAX_KAIFUS) {
		$this->getKaifuInfo($game, "test_date > {$last_now} AND oper_id not in (".join(",", array_keys($this->kaifus)).")", "ASC");
	    }
print_r($this->kaifus);
	    register_template_data('kaifus', $this->kaifus);
	    register_template_data('game', $game);
	    return template('game', 'content');
	} else {
	    ShowMsg("未找到对应的游戏！","-1");
	}
    }

    //列表页面
    public function lists() {
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	$tag_name = isset($_GET['tag']) ? $_GET['tag'] : '';
	$filters = array("game_tag", "game_theme", "game_status", "game_effect", "test_status");
	$gamesort = isset($_GET['gamesort']) ? $_GET['gamesort'] : 1;
  $game_pinyin = isset($_GET['game_pinyin']) ? $_GET['game_pinyin'] : '';
	$title = "";
	$orderby = "";
	$where = array();
	$title = getTypeName($this->db->typeid);
	foreach ($filters as $key => $value) {
	    $tag = $_GET[$value];
	    if(isset($tag) && !empty($tag)){
		$where[] = "$value = '".$tag."'";
		$title = $tag."_".$title;
	    }
	}
	if(!empty($tag_name)){
	    $ids = getIdsByTagname($tag_name,"*",$this->db->typeid);
	    $ids = join(",", $ids);
	    $where[] = "id in ($ids)";
	    $title = $tag_name."_".$title;
	}
  if(!empty($game_pinyin)){
      $where[] = "pinyin LIKE '".strtolower($game_pinyin)."%'";
  }
	switch ($gamesort) {
	case 1:
	    $orderby = "pubdate DESC";
	    break;
	case 2:
	    $orderby = "kaifu_count DESC";
	    break;
	case 3:
	    $orderby = "goodpost DESC";
	    break;
	case 4:
	    $orderby = "scores/scorecount DESC";
	    break;
	default:
	    $orderby = "pubdate DESC";
	    break;
	}

	$where = join(" and ", $where);
	$lists = $this->db->listinfo($where, $orderby, $page, 56);


	register_template_data('lists', $lists);
	register_template_data('pages', $this->db->pages);
	register_template_data('items', $this);
	register_template_data('title', $title);
	register_template_data('gamesort', $gamesort);
	return template('game', 'list');
    }
}
?>
