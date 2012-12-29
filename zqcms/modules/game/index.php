<?php
defined("IN_ZQCMS") or exit("Permission deiened");

class index {
    public function __construct() {
	$this->db = zq_core::load_model('game_model');
    }

    //内容页
    public function show() {
	$id = intval($_GET['id']);
	if(isset($id) && !empty($id)){
	    $game = $this->db->get_one(array(
		"id" => $id
	    ));
	    register_template_data('game', $game);
	    return template('game', 'content');
	}else{
	    ShowMsg("未找到对应的游戏！","-1");
	}
    }

    //列表页面
    public function lists() {
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
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
	switch ($gamesort) {
	    case 1:
		$orderby = "pubdate";
		break;
	    case 2:
		#TODO 按开服量排序
		$orderby = "pubdate";
		break;
	    case 3:
		$orderby = "goodpost";
		break;
	    case 4:
		$orderby = "scores/scorecount";
		break;
	    default:
		$orderby = "pubdate";
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
