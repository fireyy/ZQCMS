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
	$now = time();

	$game_name = empty($_GET['game_name']) ? '' : $_GET['game_name'];
	$oper_name = empty($_GET['oper_name']) ? '' : $_GET['oper_name'];

	$year = isset($_GET['year']) ? $_GET['year'] : date('Y', $now);
	$month = isset($_GET['month']) ? $_GET['month'] : date('m', $now);
	$day = isset($_GET['day']) ? $_GET['day'] : date('d', $now);

	echo $this->db->getYearAndMonthKaifuCount($year, $month);
	/*
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
	*/

	//register_template_data('lists', $lists);
	//register_template_data('items', $this);
	//register_template_data('title', $title);
	register_template_data('year', $year);
	register_template_data('month', $month);
	register_template_data('day', $day);

	return template('kaifu', 'list');
    }
}
?>
