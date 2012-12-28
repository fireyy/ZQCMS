<?php
defined("IN_ZQCMS") or exit("Permission deiened");

class index {
    public function __construct() {
	$this->db = zq_core::load_model('kaice_model');
    }

    //内容页
    public function show() {
	ShowMsg("404","-1");
    }

    //列表页面
    public function lists() {
  $title = "";
  $where = array();
  $time = strtotime("today");
  $begin_date = mktime(0, 0, 0, date("m", $time), date("d", $time), date("Y", $time));
  $end_date   = mktime(0, 0, 0, date("m", $time), date("d", $time) + 1, date("Y", $time));
  $where[] = "test_date >= $begin_date AND test_date < $end_date";
  
  $title = getTypeName($this->db->typeid);
  $where = join(" and ", $where);
  $lists = $this->db->select($where, '*', '0,100', 'test_date desc');
  $num = count($lists);
  if($num < 100){
    $lists2 = $this->db->select('', '*', "$num,".(100-$num), 'test_date desc');
  }
  register_template_data('lists', array_merge($lists,$lists2));
  register_template_data('items', $this);
  register_template_data('title', $title);
  register_template_data('today', date("Y-m-d",time()));
	return template('kaice', 'list');
    }
}
?>
