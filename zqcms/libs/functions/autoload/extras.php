<?php

function getURL($item) {
    if ($item && $item["typeid"]) {
	$typedb = zq_core::load_model('type_model');
	$typeinfo = $typedb->get_one(array('id'=>$item["typeid"]));
	$model_name = $typeinfo['name'];
	// article show id page

	//m c a
	$url = array();
	$url['m'] = $model_name;
	$url['c'] = 'index';
	$url['a'] = 'show';

	$url['id'] = $item['id'];

	$url = http_build_query($url);
	return 'index.php?' . $url;
    }
    return '#';
}
register_template_plugin("modifier", "zqurl", "getURL");

function getGameURL($game_id) {
  return "#";
}

function getTypeLink($type,$tagname) {
  return "#";
}

function getArticleThumb() {
  return "#";
}
register_template_plugin("modifier", "zqthumb", "getArticleThumb");

function get_today_kaifu_count() {
  $db = zq_core::load_model("kaifu_model");

  $time = strtotime('today');
  $begin_date = mktime(0, 0, 0, date("m", $time), date("d", $time), date("Y", $time));
  $end_date   = mktime(0, 0, 0, date("m", $time), date("d", $time) + 1, date("Y", $time));
  $sql = "test_date >= $begin_date AND test_date < $end_date";
  $count = $db->count($sql);
  return $count;
}

function get_today_kaice_count() {
  $db = zq_core::load_model("kaice_model");

  $time = strtotime('today');
  $begin_date = mktime(0, 0, 0, date("m", $time), date("d", $time), date("Y", $time));
  $end_date   = mktime(0, 0, 0, date("m", $time), date("d", $time) + 1, date("Y", $time));
  $sql = "test_date >= $begin_date AND test_date < $end_date";
  $count = $db->count($sql);
  return $count;
}

function get_gift_count(){
  $db = zq_core::load_model("gift_model");
  $count = $db->count();
  return $count;
}

function get_game_count(){
  $db = zq_core::load_model("game_model");
  $count = $db->count();
  return $count;
}

function get_game_list($params, $template){
  $db = zq_core::load_model("game_model");
  $where = array();
  $limit = "";
  $orderby = "";
  if (isset($params['flag'])){
    $flag = $params['flag'];
    if(!preg_match('#,#', $flag)){
      $where[] = "FIND_IN_SET('$flag', flag)>0";
    }else{
      $flags = explode(',', $flag);
      foreach($flags as $flag) {
        if(trim($flag)=='') continue;
        $where[] = "FIND_IN_SET('$flag', flag)>0";
      }
    }
  }
  if (isset($params['tag'])){
    $tag = explode(",", $params['tag']);
    for ($i=0; $i < count($tag); $i++) { 
      $tag[$i] = "game_tag = '".trim($tag[$i])."'";
    }
    $where[] = join(" or ",$tag);
  }
  if (isset($params['theme'])){
    $theme = explode(",", $params['theme']);
    for ($i=0; $i < count($theme); $i++) { 
      $theme[$i] = "game_theme = '".trim($theme[$i])."'";
    }
    $where[] = join(" or ",$theme);
  }
  if (isset($params['orderby'])){
    $orderby = $params['orderby'];
  }
  if (isset($params['orderway'])){
    if($orderby!="") $orderby .= " ".$params['orderway'];
  }
  if (isset($params['limit'])){
    $limit = $params['limit'];
  }
  $where = join(" and ", $where);
  $data = $db->select($where, '*', $limit, $orderby);
  if (isset($params['assign'])) {
  	$template->assign($params['assign'], $data);
  }
}
register_template_plugin("function", "get_game_list", "get_game_list");

function get_recomm_kaifu_list($params, $template){
  $db = zq_core::load_model("kaifu_model");
  $where = array();
  $limit = "";
  $orderby = "";
  if (isset($params['flag'])){
    $flag = $params['flag'];
    if(!preg_match('#,#', $flag)){
      $where[] = "FIND_IN_SET('$flag', flag)>0";
    }else{
      $flags = explode(',', $flag);
      foreach($flags as $flag) {
        if(trim($flag)=='') continue;
        $where[] = "FIND_IN_SET('$flag', flag)>0";
      }
    }
  }
  if (isset($params['orderby'])){
    $orderby = $params['orderby'];
  }
  if (isset($params['orderway'])){
    if($orderby!="") $orderby .= " ".$params['orderway'];
  }
  if (isset($params['limit'])){
    $limit = $params['limit'];
  }
  $where = join(" and ", $where);
  $time = strtotime('today');
  $begin_date = mktime(0, 0, 0, date("m", $time), date("d", $time), date("Y", $time));
  $where .= " and test_date >= $begin_date";
  $data = $db->select($where, '*', $limit, $orderby);
  if (isset($params['assign'])) {
  	$template->assign($params['assign'], $data);
  }
}
register_template_plugin("function", "get_recomm_kaifu_list", "get_recomm_kaifu_list");

function get_kaifu_list($params, $template){
  $db = zq_core::load_model("kaifu_model");
  $where = array();
  $limit = "";
  $orderby = "";
  if (isset($params['flag'])){
    $flag = $params['flag'];
    if(!preg_match('#,#', $flag)){
      $where[] = "FIND_IN_SET('$flag', flag)>0";
    }else{
      $flags = explode(',', $flag);
      foreach($flags as $flag) {
        if(trim($flag)=='') continue;
        $where[] = "FIND_IN_SET('$flag', flag)>0";
      }
    }
  }
  if (isset($params['orderby'])){
    $orderby = $params['orderby'];
  }
  if (isset($params['orderway'])){
    if($orderby!="") $orderby .= " ".$params['orderway'];
  }
  if (isset($params['limit'])){
    $limit = $params['limit'];
  }
  if(isset($params['day'])){
    $time = strtotime($params['day']);
    $begin_date = mktime(0, 0, 0, date("m", $time), date("d", $time), date("Y", $time));
    $end_date   = mktime(0, 0, 0, date("m", $time), date("d", $time) + 1, date("Y", $time));
    $where[] = "test_date >= $begin_date AND test_date < $end_date";
  }
  $where = join(" and ", $where);
  $data = $db->select($where, '*', $limit, $orderby);
  if (isset($params['assign'])) {
  	$template->assign($params['assign'], $data);
  }
}
register_template_plugin("function", "get_kaifu_list", "get_kaifu_list");

function get_kaice_list($params, $template){
  $db = zq_core::load_model("kaice_model");
  $where = array();
  $limit = "";
  $orderby = "";
  if (isset($params['flag'])){
    $flag = $params['flag'];
    if(!preg_match('#,#', $flag)){
      $where[] = "FIND_IN_SET('$flag', flag)>0";
    }else{
      $flags = explode(',', $flag);
      foreach($flags as $flag) {
        if(trim($flag)=='') continue;
        $where[] = "FIND_IN_SET('$flag', flag)>0";
      }
    }
  }
  if (isset($params['orderby'])){
    $orderby = $params['orderby'];
  }
  if (isset($params['orderway'])){
    if($orderby!="") $orderby .= " ".$params['orderway'];
  }
  if (isset($params['limit'])){
    $limit = $params['limit'];
  }
  if(isset($params['day'])){
    $time = strtotime($params['day']);
    $begin_date = mktime(0, 0, 0, date("m", $time), date("d", $time), date("Y", $time));
    #$end_date   = mktime(0, 0, 0, date("m", $time), date("d", $time) + 1, date("Y", $time));
    $where[] = "test_date >= $begin_date";
  }
  $where = join(" and ", $where);
  $data = $db->select($where, '*', $limit, $orderby);
  if (isset($params['assign'])) {
  	$template->assign($params['assign'], $data);
  }
}
register_template_plugin("function", "get_kaice_list", "get_kaice_list");

function get_gift_list($params, $template){
  $db = zq_core::load_model("gift_model");
  $where = array();
  $limit = "";
  $orderby = "";
  if (isset($params['flag'])){
    $flag = $params['flag'];
    if(!preg_match('#,#', $flag)){
      $where[] = "FIND_IN_SET('$flag', flag)>0";
    }else{
      $flags = explode(',', $flag);
      foreach($flags as $flag) {
        if(trim($flag)=='') continue;
        $where[] = "FIND_IN_SET('$flag', flag)>0";
      }
    }
  }
  if (isset($params['orderby'])){
    $orderby = $params['orderby'];
  }
  if (isset($params['orderway'])){
    if($orderby!="") $orderby .= " ".$params['orderway'];
  }
  if (isset($params['limit'])){
    $limit = $params['limit'];
  }
  if(isset($params['day'])){
    $time = strtotime($params['day']);
    $begin_date = mktime(0, 0, 0, date("m", $time), date("d", $time), date("Y", $time));
    #$end_date   = mktime(0, 0, 0, date("m", $time), date("d", $time) + 1, date("Y", $time));
    $where[] = "send_date >= $begin_date";
  }
  $where = join(" and ", $where);
  $data = $db->select($where, '*', $limit, $orderby);
  if (isset($params['assign'])) {
  	$template->assign($params['assign'], $data);
  }
}
register_template_plugin("function", "get_gift_list", "get_gift_list");

function get_article_list($params, $template){
  $db = zq_core::load_model("article_model");
  $where = array();
  $limit = "";
  $orderby = "";
  if (isset($params['flag'])){
    $flag = $params['flag'];
    if(!preg_match('#,#', $flag)){
      $where[] = "FIND_IN_SET('$flag', flag)>0";
    }else{
      $flags = explode(',', $flag);
      foreach($flags as $flag) {
        if(trim($flag)=='') continue;
        $where[] = "FIND_IN_SET('$flag', flag)>0";
      }
    }
  }
  if (isset($params['orderby'])){
    $orderby = $params['orderby'];
  }
  if (isset($params['orderway'])){
    if($orderby!="") $orderby .= " ".$params['orderway'];
  }
  if (isset($params['limit'])){
    $limit = $params['limit'];
  }
  $where = join(" and ", $where);
  $data = $db->select($where, '*', $limit, $orderby);
  if (isset($params['assign'])) {
  	$template->assign($params['assign'], $data);
  }
}
register_template_plugin("function", "get_article_list", "get_article_list");

function get_articles_byTagName($params, $template){
  $db = zq_core::load_model("article_model");
  $where = array();
  $limit = "";
  $orderby = "";
  if (isset($params['flag'])){
    $flag = $params['flag'];
    if(!preg_match('#,#', $flag)){
      $where[] = "FIND_IN_SET('$flag', flag)>0";
    }else{
      $flags = explode(',', $flag);
      foreach($flags as $flag) {
        if(trim($flag)=='') continue;
        $where[] = "FIND_IN_SET('$flag', flag)>0";
      }
    }
  }
  if (isset($params['noflag'])){
    $noflag = $params['noflag'];
    if(!preg_match('#,#', $noflag)){
      $where[] = "FIND_IN_SET('$noflag', flag)<1";
    }else{
      $noflags = explode(',', $noflag);
      foreach($noflags as $noflag) {
        if(trim($noflag)=='') continue;
        $where[] = "FIND_IN_SET('$noflag', flag)<1";
      }
    }
  }
  if (isset($params['orderby'])){
    $orderby = $params['orderby'];
  }
  if (isset($params['orderway'])){
    if($orderby!="") $orderby .= " ".$params['orderway'];
  }
  if (isset($params['limit'])){
    $limit = $params['limit'];
  }
  if (isset($params['tagname'])){
    $ids = getIdsByTagname($params["tagname"],"*",$db->typeid);
    #print_r($ids);
    $ids = join(",", $ids);
    $where[] = "id in ($ids)";
  }
  $where = join(" and ", $where);
  $data = $db->select($where, '*', $limit, $orderby);
  if (isset($params['assign'])) {
  	$template->assign($params['assign'], $data);
  }
}
register_template_plugin("function", "get_articles_byTagName", "get_articles_byTagName");

function get_gallery_list($params, $template){
  $db = zq_core::load_model("gallery_model");
  $where = array();
  $limit = "";
  $orderby = "";
  if (isset($params['flag'])){
    $flag = $params['flag'];
    if(!preg_match('#,#', $flag)){
      $where[] = "FIND_IN_SET('$flag', flag)>0";
    }else{
      $flags = explode(',', $flag);
      foreach($flags as $flag) {
        if(trim($flag)=='') continue;
        $where[] = "FIND_IN_SET('$flag', flag)>0";
      }
    }
  }
  if (isset($params['orderby'])){
    $orderby = $params['orderby'];
  }
  if (isset($params['orderway'])){
    if($orderby!="") $orderby .= " ".$params['orderway'];
  }
  if (isset($params['limit'])){
    $limit = $params['limit'];
  }
  $where = join(" and ", $where);
  $data = $db->select($where, '*', $limit, $orderby);
  if (isset($params['assign'])) {
  	$template->assign($params['assign'], $data);
  }
}
register_template_plugin("function", "get_gallery_list", "get_gallery_list");

?>
