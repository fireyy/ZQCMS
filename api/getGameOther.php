<?php
defined('IN_ZQCMS') or exit('Permission denied.'); 
/**
 * TODO 获取游戏新开服和礼包信息
 */
$callbak111 = $_GET["callback"];
$gameids = $_GET["gid"];
$data = array(
  "status" => true,
  "msg" => array()
);
if(!empty($gameids)){
  $gameids = urldecode($gameids);
  $gameids = explode(",", $gameids);
  $gift_db = zq_core::load_model('gift_model');
  $kaifu_db = zq_core::load_model('kaifu_model');
  foreach ($gameids as $game_id) {
    $tmp = array(
      "id" => $game_id,
      "gift" => "",
      "newserver" => "",
      "down" => ""
    );
    $time = strtotime('today');
    $begin_date = mktime(0, 0, 0, date("m", $time), date("d", $time)-5, date("Y", $time));
    $gift_where = "game_id=$game_id and send_date > $begin_date";
    $kaifu_where = "game_id=$game_id and test_date > $begin_date";
    $r_gift = $gift_db->get_one($gift_where);
    if($r_gift){
      $tmpurl = getTypeLink("gift");
      $tmp["gift"] = "<a href='".$tmpurl."'></a>";
    }
    $r_kaifu = $kaifu_db->get_one($kaifu_where);
    if($r_kaifu){
      $arrss = array("action"=>"serverlist",'{$game_id}'=>$game_id);
      $tmpurl = getTypeLink("kaifu","",$arrss);
      $tmp["newserver"] = "<a href='".$tmpurl."'></a>";
    }
    $data["msg"][] = $tmp;
  }
}
echo $callbak111."(".json_encode($data).")";

?>