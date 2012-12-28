<?php
defined("IN_ZQCMS") or exit("Permission deiened");

class index {
    public function __construct() {
	$this->db = zq_core::load_model('article_model');
    }

    //内容页
    public function show() {
	$id = intval($_GET['id']);
  if(isset($id) && !empty($id)){
    $article = $this->db->get_one(array(
      "id" => $id
    ));
  	register_template_data('article', $article);
    if(!empty($article['game_id'])){
      $game_db = zq_core::load_model('game_model');
      $game = $game_db->get_one(array(
        "id" => $article['game_id']
      ));
      $game["url"] = getURL($game);
      register_template_data('game', $game);
    }
  	return template('article', 'content');
  }else{
    ShowMsg("未找到对应的文章！","-1");
  }
    }

    //列表页面
    public function lists() {
	$page = $_GET['page'];
  if(empty($page)) $page = 1;
  $tag = $_GET['tag'];
  $game_id = $_GET['game_id'];
  $title = "";
  $where = array();
  if(isset($tag) && !empty($tag)){
    $ids = getIdsByTagname($params["tagname"],"*",$db->typeid);
    #print_r($ids);
    $ids = join(",", $ids);
    $where[] = "id in ($ids)";
    $title = $tag;
  }else{
    #$title = $this->db->getTypeName();
  }
  if(isset($game_id) && !empty($game_id)){
    $where[] = "game_id = $game_id";
  }
  $where = join(" and ", $where);
  $lists = $this->db->listinfo($where,'', $page);
  register_template_data('lists', $lists);
  register_template_data('pages', $this->db->pages);
  register_template_data('items', $this);
	return template('article', 'list');
    }
}
?>
