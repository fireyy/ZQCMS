<?php
defined("IN_ZQCMS") or exit("Permission deiened");

class index {
    public function __construct() {
	$this->db = zq_core::load_model('kaifu_model');
    }

    //内容页
    public function show() {
	    ShowMsg("404","-1");
    }

    //列表页面
    public function lists() {
  $game_name = empty($_GET['game_name']) ? '' : $_GET['game_name'];
  $oper_name = empty($_GET['oper_name']) ? '' : $_GET['oper_name'];
  $date = empty($_GET['date']) ? date("y-m-d",time()) : $_GET['date'];
  $time = empty($_GET['time']) ? '' : $_GET['time'];
  
  $title = "";
  $where = array();
  $title = getTypeName($this->db->typeid);
  if(isset($date) && !empty($date)){
    $begin_date = mktime(0, 0, 0, date("m", $date), date("d", $date), date("Y", $date));
    $end_date   = mktime(0, 0, 0, date("m", $date), date("d", $date) + 1, date("Y", $date));
    $where[] = "test_date >= $begin_date AND test_date < $end_date";
  }
  $where = join(" and ", $where);
  $lists = $this->db->select($where);
  register_template_data('lists', $lists);
  register_template_data('items', $this);
  register_template_data('title', $title);
  register_template_data('date', $date);
  register_template_data('today', date("y-m-d",strtotime('today')));
  register_template_data('yesterday', date("y-m-d",strtotime('yesterday')));
  register_template_data('tomorrow', date("y-m-d",strtotime('tomorrow')));
	return template('kaifu', 'list');
    }
}
?>
