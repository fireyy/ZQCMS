<?php
defined("IN_ZQCMS") or exit("Permission denied.");

class url {
    private $urlrules, $html_root;
    public function __construct() {
	$this->urlrules = zq_core::load_config('router');
	$this->html_root = zq_core::load_config('system', 'html_root');
    }

    /**
     * 内容页面URL 
     * @param $id 内容id
     * @param $page CurrentPage
     * @param $typeid 内容模型id
     * @param $time 增加时间
     * @param $prefix 前缀
     * @param $data 数据
     */
    public function show($id, $page = 0, $typeid, $time = 0, $prefix='', $data='', $array=array()) {
	$page = max($page, 1);
	$typedb = zq_core::load_model('type_model');
	$typeinfo = $typedb->get_one(array('id'=>$typeid));
	$type_name = $typeinfo['name'];
	$urlrules = $this->urlrules[$type_name];
	if (empty($urlrules)) {
	    $urlrules = array();
	}
	if (empty($urlrules['content'])) {
	    //DEFAULT content url
	    $urlrules['content'] = 'index.php?m='.$type_name.'&c=index&a=show&id={$id}&page={$page}';
	}
	$urlrules_arr = explode("|", $urlrules['content']);
	if ($page == 1) {
	    $urlrule = $urlrules_arr[0];
	} else {
	    $urlrule = isset($urlrules_arr[1]) ? $urlrules_arr[1] : $urlrules_arr[0];
	}
	if (!$time) {
	    $time = time();
	}

	$year = date("y", $time);
	$month = date('m', $time);
	$day = date("d", $time);

	// url规则的额外一些数据 比如 {$gamesort} {}
	$keys = array(
	    '{$id}', '{$page}', '{$year}', '{$month}', '{$day}'
	);
	$values = array(
	    $id, $page, $year, $month, $day
	);
	
	if (!empty($array) && is_array($array)) {
	    $extra_keys = array_keys($array);
	    $extra_values = array_values($array);

	    $extra_url = array();
	    for ($i = 0; $i < count($extra_keys); $i++) {
		$extra_key = $extra_keys[$i];
		if (preg_match('/^{\$(.+)}$/', $extra_key, $m)) {
		    if (!in_array($extra_key, $keys)) {
			$extra_url[$m[1]] = $extra_key;
			$keys[] = $extra_key;
			$values[] = $extra_values[$i];
		    }
		}
	    }
	    if (!empty($extra_url)) {
		$connect_sharp = '';
		if (strpos($urlrule, "?")) {
		    $connect_sharp = '&';
		} else {
		    $connect_sharp = '?';
		}
		$extra_url = http_build_query($extra_url);
		//反转义
		$urlrule .= $connect_sharp.urldecode($extra_url);
	    }
	}

	$urls = str_replace($keys, $values, $urlrule);
	$url_arr = array();
	//静态
	//动态
	$url_arr[0] = $url_arr[1] = $urls;

	if ($data) {
	    $url_arr['data'] = $data;
	}

	if ($array) {
	    $url_arr['array'] = $array;
	}

	return $url_arr;
    }

    /**
     * 分类列表页面url
     */
    public function typeurl($typeid, $page=1, $array=array()) {
	$typedb = zq_core::load_model('type_model');
	$typeinfo = $typedb->get_one(array('id'=>$typeid));
	$type_name = $typeinfo['name'];
	$urlrules = $this->urlrules[$type_name];

	if (empty($urlrules)) {
	    $urlrules = array();
	}
  if(isset($array["action"])){
    $urlrules[$array["action"]] = 'index.php?m='.$type_name.'&c=index&a='.$array["action"].'&page={$page}';
    $urlrules_arr = explode("|", $urlrules[$array["action"]]);
  }else{
  	if (empty($urlrules['list'])) {
  	    //DEFAULT content url
  	    $urlrules['list'] = 'index.php?m='.$type_name.'&c=index&a=lists&page={$page}';
  	}
    $urlrules_arr = explode("|", $urlrules['list']);
  }

	if ($page == 1) {
	    $urlrule = $urlrules_arr[0];
	} else {
	    $urlrule = isset($urlrules_arr[1]) ? $urlrules_arr[1] : $urlrules_arr[0];
	}

	$keys = array(
	    '{$page}'
	);
	$values = array(
	    $page
	);
	
	if (!empty($array) && is_array($array)) {
	    $extra_keys = array_keys($array);
	    $extra_values = array_values($array);

	    $extra_url = array();
	    for ($i = 0; $i < count($extra_keys); $i++) {
		$extra_key = $extra_keys[$i];
		if (preg_match('/^{\$(.+)}$/', $extra_key, $m)) {
		    if (!in_array($extra_key, $keys)) {
			$extra_url[$m[1]] = $extra_key;
			$keys[] = $extra_key;
			$values[] = $extra_values[$i];
		    }
		}
	    }
	    if (!empty($extra_url)) {
		$connect_sharp = '';
		if (strpos($urlrule, "?")) {
		    $connect_sharp = '&';
		} else {
		    $connect_sharp = '?';
		}
		$extra_url = http_build_query($extra_url);
		//反转义
		$urlrule .= $connect_sharp.urldecode($extra_url);
	    }
	}
	$urls = str_replace($keys, $values, $urlrule);

	$url_arr = array();
	//静态
	//动态
	$url_arr[0] = $url_arr[1] = $urls;

	if ($data) {
	    $url_arr['data'] = $data;
	}

	if ($array) {
	    $url_arr['array'] = $array;
	}
	
	return $url_arr;
    }
}

?>
