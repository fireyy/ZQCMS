<?php
defined("IN_ZQCMS") or exit("Permission deiened");

class index {
    public function __construct() {
	$this->db = zq_core::load_model('game_model');
    }

    //内容页
    public function show() {
	$id = intval($_GET['id']);
	$now = mktime(0, 0, 0);
	$last_now = mktime(23, 59, 59);

	if(isset($id) && !empty($id)){
	    $game = $this->db->get_one(array(
		"id" => $id
	    ));
      $maxd = 10;
	    //获得游戏的运营商数量
	    $rdb = zq_core::load_model('game_company_model');
	    $company_count = $rdb->count(array('game_id' => $game['game_id']));
	    $game['company_count'] = $company_count;

	    //获取开服信息
	    $kaifu_db = zq_core::load_model('kaifu_model');
	    $company_db = zq_core::load_model('company_model');

	    $data = $kaifu_db->select(
		"game_id = {$game['game_id']} AND test_date >= {$now} AND test_date <= {$last_now}",
		'oper_id',
		"0, {$maxd}",
		'test_date DESC',
        'oper_id'
	    );
      $countd = count($data);
      if($countd < $maxd){
        $tmp = $maxd - $countd;
  	    $data2 = $kaifu_db->select(
  		"game_id = {$game['game_id']} AND test_date > {$last_now}",
  		'oper_id',
  		"0, {$tmp}",
  		'test_date DESC',
        'oper_id'
  	    );
        $data = array_merge($data, $data2);
        $countd = count($data);
        if($countd < $maxd){
          $tmp = $maxd - $countd;
    	    $data2 = $kaifu_db->select(
    		"game_id = {$game['game_id']} AND test_date < {$now}",
    		'oper_id',
    		"0, {$tmp}",
    		'test_date DESC',
            'oper_id'
    	    );
          $data = array_merge($data, $data2);
        }
      }
      //print_r($data);
	    
	    $kaifus = array();
	    for ($i = 0; $i < count($data); $i++) {
            $company_id = $data[$i]['oper_id'];
            $company = $company_db->get_one(array('company_id'=>$company_id));
            $kaifus[$company_id] = array(
                'company' => $company,
                'kaifu' => array(
                    'y' => array(),
                    'n' => array(),
                    't' => array()
                )
            );
			//如果有的话插入今日数据
            $r = $kaifu_db->select(
                "oper_id={$company_id} AND game_id={$game['game_id']} AND test_date >= {$now} AND test_date <= {$last_now}", '*', 'test_date DESC'
            );
            if (!empty($r)) {
                $kaifus[$company_id]['kaifu']['n'] = $r;
            }
            //如果有的话插入今日之后的数据
            $r = $kaifu_db->get_one(
                "oper_id={$company_id} AND game_id={$game['game_id']} AND test_date > {$last_now}", '*', 'test_date DESC'
            );
            if (!empty($r)) {
                $kaifus[$company_id]['kaifu']['t'] = $r;
            }
            //如果有的话插入今日之前的数据
            $r = $kaifu_db->get_one(
                "oper_id={$company_id} AND game_id={$game['game_id']} AND test_date < $now", '*', 'test_date DESC'
            );
            if (!empty($r)) {
                $kaifus[$company_id]['kaifu']['y'] = $r;
            }
		}
        //print_r($kaifus);
	    register_template_data('kaifus', $kaifus);

	    register_template_data('game', $game);
	    return template('game', 'content');
	}else{
	    ShowMsg("未找到对应的游戏！","-1");
	}
    }

    //列表页面
    public function lists() {
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
  $tag_name = isset($_GET['tag']) ? $_GET['tag'] : '';
	$filters = array("game_tag", "game_theme", "game_status", "game_effect");
	$gamesort = isset($_GET['gamesort']) ? $_GET['gamesort'] : 1;
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
