<?php

function getURL($item) {
  return "#";
}
register_template_plugin("modifier", "zqurl", "getURL");

function getGameURL($game_id) {
  return "#";
}

function getTypeLink($type) {
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
register_template_plugin("function", "get_kaice_list", "get_kaice_list");

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

function get_gallery_list($params, $template){
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
register_template_plugin("function", "get_gallery_list", "get_gallery_list");

?>