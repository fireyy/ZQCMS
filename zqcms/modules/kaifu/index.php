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
    $today = false;
	$game_name = empty($_REQUEST['game_name']) ? '' : $_REQUEST['game_name'];
	$oper_name = empty($_REQUEST['oper_name']) ? '' : $_REQUEST['oper_name'];

	$year = isset($_GET['year']) ? $_GET['year'] : date('Y', $now);
	$month = isset($_GET['month']) ? $_GET['month'] : date('m', $now);
	$day = isset($_GET['day']) ? $_GET['day'] : date('d', $now);
	$t = isset($_GET['t']) ? $_GET['t'] : 0;

	list($month_kaifu_count, $kaifu_data) = $this->db->getYearAndMonthKaifuCount($year, $month);

	if ($year == date('Y', $now) && $month == date('m', $now) && $day == date('d', $now) && $t == 0) {
	    $today = true;
	}

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
		$begin_date = mktime(17, 0, 0, $month, $day, $year);
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
    if($today){
        #获取今天当前时段的数据
        $hour = date('H', $now);
        $begin_date = mktime($hour, 0, 0, $month, $day, $year);
        $end_date   = mktime($hour+1, 0, 0, $month, $day, $year);
    }

	$title = "";
	$where = array();
	$title = getTypeName($this->db->typeid);
	if(!empty($game_name)){
	    $where[] = "game_name LIKE '%".$game_name."%'";
	}
	if(!empty($oper_name)){
	    $where[] = "oper_short_name LIKE '%".$oper_name."%'";
	}
    $where_nodate = $where;
    if(isset($begin_date) && !empty($end_date)){
        $where[] = "test_date >= $begin_date AND test_date < $end_date";
    }
	$where = join(" and ", $where);
	$lists = $this->db->select($where, '*', '', 'test_date ASC');
    if($today){
        #获取今天当前时段之后的数据
        $where2 = $where_nodate;
        $begin_date = mktime($hour+1, 0, 0, $month, $day, $year);
        $end_date   = mktime(23, 59, 0, $month, $day, $year);
        $where2[] = "test_date >= $begin_date AND test_date < $end_date";
        $where2 = join(" and ", $where2);
        $lists2 = $this->db->select($where2, '*', '', 'test_date ASC');
        #获取今天当前时段之前的数据
        $where3 = $where_nodate;
        $begin_date = mktime(0, 0, 0, $month, $day, $year);
        $end_date   = mktime($hour-1, 59, 0, $month, $day, $year);
        $where3[] = "test_date >= $begin_date AND test_date < $end_date";
        $where3 = join(" and ", $where3);
        $lists3 = $this->db->select($where3, '*', '', 'test_date DESC');
        #合并生成今天的所有数据
        $lists = array_merge($lists,$lists2,$lists3);
    }

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
    
    public function serverlist(){
      $page = isset($_GET['page']) ? $_GET['page'] : 1;
    	$game_id = empty($_REQUEST['game_id']) ? '' : $_REQUEST['game_id'];
    	$oper_name = empty($_REQUEST['oper_name']) ? '' : $_REQUEST['oper_name'];
      $game_name = "";
      
    	$where = array();
    	$title = getTypeName($this->db->typeid);
      
    	#TODO 排序：今日排在最前
      
    	if(!empty($game_id)){
          $game_db = zq_core::load_model('game_model');
          $game_name = $game_db->get_one(array(
      		  "game_id" => $game_id
      	  ));
          $game_name = $game_name["game_name"];
    	    $where[] = "game_id = '$game_id'";
          $title = $game_name.$title;
    	}
    	if(!empty($oper_name)){
    	    $where[] = "oper_short_name = '$oper_name'";
          $title = $oper_name.$title;
    	}
    	$where = join(" and ", $where);
        list($urlrule, $array) = getURLrule($this->db->typeid, $_GET, "serverlist");
    	$lists = $this->db->listinfo($where, "test_date DESC", $page, 45, '', 5, $urlrule, $array);

    	register_template_data('lists', $lists);
    	register_template_data('items', $this);
    	register_template_data('title', $title);
      register_template_data('game_name', $game_name);
    	register_template_data('pages', $this->db->pages);
      
      return template('kaifu', 'serverlist');
    }
}
?>
