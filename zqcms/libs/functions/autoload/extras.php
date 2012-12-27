<?php

function getURL($item) {
  return "#";
}
register_template_plugin("modifier", "zqurl", "getURL");

function get_today_kaifu_count() {
  $db = zq_core::load_model("kaifu_model");

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
  if (isset($params['hot'])){
    $where[] = "flag in ('f')";
  }
  if (isset($params['theme'])){
    $arr = explode(",", $params['theme']);
    for ($i=0; $i < count($arr); $i++) { 
      $arr[$i] = "game_theme = '".$arr[$i]."'";
    }
    $where[] = join(" or ",$arr);
  }
  if (isset($params['limit'])){
    $limit = $params['limit'];
  }
  $where = join(" and ", $where);
  $data = $db->select($where, '*', $limit);
  if (isset($params['assign'])) {
  	$template->assign($params['assign'], $data);
  }
}
register_template_plugin("function", "get_game_list", "get_game_list");

?>