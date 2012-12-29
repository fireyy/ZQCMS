<?php
/**
 * 搜索页
 *
 */
define('ZQCMS_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);

include ZQCMS_PATH."/zqcms/core.php";

$stype = $_GET["stype"];
$keys = $_GET["keys"];
$keys = trim($keys);

if (empty($keys) || $keys=="请在此输入要查找的内容") {
    ShowMsg('请在此输入要查找的内容！', '-1');
    exit;
}

$defaultSearchType = "game";

$searchTypeList = array('game', 'article', 'platform');

if (empty($stype)) {
    $stype = $defaultSearchType;
} elseif (!in_array($stype, $searchTypeList)) {
    ShowMsg('搜索类型错误！', '-1');
    exit;
}

if($stype == "game"){
  $game_db = zq_core::load_model('game_model');
  $kaifu_db = zq_core::load_model('kaifu_model');
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	$where = array();
  $where[] = "game_name LIKE '%".$keys."%'";
  
	$where = join(" and ", $where);
	$lists = $game_db->listinfo($where, '', $page, 45);
  foreach ($lists as $key => $value) {
    $lists[$key]["kaifu_count"] = $kaifu_db->count("game_id=".$value["game_id"]);
  }
  $totalResult = count($lists);
	register_template_data('lists', $lists);
	register_template_data('pages', $game_db->pages);
	register_template_data('items', $this);
  register_template_data('keys', $keys);
  register_template_data('totalResult', $totalResult);
	return template('search', 'game');
}

if($stype == "platform"){
  $company_db = zq_core::load_model('company_model');
  $game_db = zq_core::load_model('game_model');
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	$where = array();
  $where[] = "short_name LIKE '%".$keys."%'";
  
	$where = join(" and ", $where);
	$lists = $company_db->listinfo($where, '', $page, 45);
  foreach ($lists as $key => $value) {
    $lists[$key]["game_count"] = $game_db->count("game_id=".$value["game_id"]);
  }
  $totalResult = count($lists);
	register_template_data('lists', $lists);
	register_template_data('pages', $company_db->pages);
	register_template_data('items', $this);
  register_template_data('keys', $keys);
  register_template_data('totalResult', $totalResult);
	return template('search', 'company');
}

if($stype == "article"){
  $article_db = zq_core::load_model('article_model');
  $game_db = zq_core::load_model('game_model');
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	$where = array();
  $where[] = "title LIKE '%".$keys."%'";
  
	$where = join(" and ", $where);
	$lists = $article_db->listinfo($where, '', $page);
  foreach ($lists as $key => $value) {
    if(!empty($value["game_id"])){
      $tmp = $game_db->get_one(array(
 		   "game_id" => $value["game_id"]
 	    ));
      $lists[$key]["game_name"] = $tmp["game_name"];
      $lists[$key]["game_url"] = getURL($tmp);
    }
  }
  $title = "搜索新闻 $keys";
  $totalResult = count($lists);
	register_template_data('lists', $lists);
	register_template_data('pages', $article_db->pages);
	register_template_data('items', $this);
  register_template_data('keys', $keys);
  register_template_data('title', $title);
  register_template_data('totalResult', $totalResult);
	return template('article', 'list');
}

?>
