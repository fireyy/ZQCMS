<?php
defined("IN_ZQCMS") or exit("Permission deiened");

class index {
    public function __construct() {
	$this->db = zq_core::load_model('article_model');
    }

    //资讯首页页
    public function index() {
    	$article_tags = zq_core::load_config("article_tag");
    	$tag_list = array(1,2,3,4,5,6);
    	$title = getTypeName($this->db->typeid);
    	register_template_data('tag_list', $tag_list);
    	register_template_data('article_tags', $article_tags);
		register_template_data('items', $this);
		register_template_data('title', $title);
		return template('article', 'index');
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
		    "game_id" => $article['game_id']
		));
		$game["url"] = getURL($game);
        $article_tags = zq_core::load_config("game_tag");
        $show_tags = array("game_tag","game_theme","game_effect");
        foreach ($show_tags as $key => $value) {
            $game[$value."_index"] = array_search($game[$value], $article_tags[$value]);
        }
		register_template_data('game', $game);
	    }
	    return template('article', 'content');
	}else{
	    ShowMsg("未找到对应的文章！","-1");
	}
    }

    //列表页面
    public function lists() {
	$page = empty($_GET['page']) ? 1 : $_GET['page'];
	$tag = empty($_GET['tag']) ? '' : $_GET['tag'];
	$game_id = empty($_GET['game_id']) ? '' : $_GET['game_id'];
	$title = "";
	$where = array();
	if(isset($tag) && !empty($tag)){
		$article_tags = zq_core::load_config("article_tag");
		$tag = $article_tags[$tag];
	    $ids = getIdsByTagname($tag, '*', $this->db->typeid);

	    $ids = join(",", $ids);
	    $where[] = "id in ($ids)";
	    $title = $tag;
	}else{
	    $title = getTypeName($this->db->typeid);
	}
	if(isset($game_id) && !empty($game_id)){
	    $where[] = "game_id = $game_id";
	}
	$where = join(" and ", $where);
	list($urlrule, $array) = getURLrule($this->db->typeid, $_GET);
	$lists = $this->db->listinfo($where,'pubdate DESC', $page, 20, '', 5, $urlrule, $array);
	$game_db = zq_core::load_model('game_model');
	foreach ($lists as $key => $value) {
	    if(!empty($value["game_id"])){
		$tmp = $game_db->get_one(array(
		    "game_id" => $value["game_id"]
		));
		$lists[$key]["game_name"] = $tmp["game_name"];
		$lists[$key]["game_url"] = getURL($tmp);
	    }
	}
	register_template_data('lists', $lists);
	register_template_data('pages', $this->db->pages);
	register_template_data('items', $this);
	register_template_data('title', $title);
	return template('article', 'list');
    }
}
?>
