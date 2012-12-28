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
	$t = isset($_GET['t']) ? $_GET['t'] : 0;

	list($month_kaifu_count, $kaifu_data) = $this->db->getYearAndMonthKaifuCount($year, $month);

	//if ($t > 0) {
	//    $today = false;
	//}

	switch ($t) {
	    case 1:
		$begin_date = mktime(9, 0, 0, $month, $day, $year);
		$end_date   = mktime(12, 59, 0, $month, $day, $year);
		break;
	    case 3:
		$begin_date = mktime(9, 0, 0, $month, $day, $year);
		$end_date   = mktime(10, 59, 0, $month, $day, $year);
		break;
	    case 4:
		$begin_date = mktime(11, 0, 0, $month, $day, $year);
		$end_date   = mktime(12, 59, 0, $month, $day, $year);
		break;
	    case 5:
		$begin_date = mktime(13, 0, 0, $month, $day, $year);
		$end_date   = mktime(18, 59, 0, $month, $day, $year);
		break;
	    case 6:
		$begin_date = mktime(13, 0, 0, $month, $day, $year);
		$end_date   = mktime(14, 59, 0, $month, $day, $year);
		break;
	    case 7:
		$begin_date = mktime(15, 0, 0, $month, $day, $year);
		$end_date   = mktime(16, 59, 0, $month, $day, $year);
		break;
	    case 8:
		$begin_date = mktime(16, 0, 0, $month, $day, $year);
		$end_date   = mktime(18, 59, 0, $month, $day, $year);
		break;
	    case 9:
		$begin_date = mktime(19, 0, 0, $month, $day, $year);
		$end_date   = mktime(22, 59, 0, $month, $day, $year);
		break;
	    case 10:
		$begin_date = mktime(19, 0, 0, $month, $day, $year);
		$end_date   = mktime(20, 59, 0, $month, $day, $year);
		break;
	    case 11:
		$begin_date = mktime(21, 0, 0, $month, $day, $year);
		$end_date   = mktime(22, 59, 0, $month, $day, $year);
		break;
	    case 0:
	    default:
		$begin_date = mktime(0, 0, 0, $month, $day, $year);
		$end_date   = mktime(0, 0, 0, $month, $day+1, $year);
	}

	$title = "";
	$where = array();
	$title = getTypeName($this->db->typeid);
	if(isset($begin_date) && !empty($end_date)){
	    $where[] = "test_date >= $begin_date AND test_date < $end_date";
	}
	$where = join(" and ", $where);
	$lists = $this->db->select($where, '*', '', 'test_date DESC');

	register_template_data('lists', $lists);
	register_template_data('items', $this);
	register_template_data('title', $title);
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
