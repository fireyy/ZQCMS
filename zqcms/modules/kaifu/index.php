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

	list($month_kaifu_count, $kaifu_data) = $this->db->getYearAndMonthKaifuCount($year, $month);
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
	register_template_data('month_kaifu_count', $month_kaifu_count);
	register_template_data('kaifu_data', $kaifu_data);
	
	$maxday_list = array(
	    1 => 31,
	    2 => ((($y % 400 == 0) || (($y % 4 == 0) && ($y % 100 != 0))) ? 29 : 28),
	    3 => 31,
	    4 => 30,
	    5 => 31,
	    6 => 30,
	    7 => 31,
	    8 => 31,
	    9 => 30,
	    10 => 31,
	    11 => 30,
	    12 => 31
	);
	register_template_data('maxday_list', $maxday_list);

	return template('kaifu', 'list');
    }
}
?>
