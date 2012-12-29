<?php
/**
 * 返回经addslashes处理过的字符串或数组
 * @param $string 需要处理的字符串或数组
 * @return mixed
 */
function new_addslashes($string){
    if(!is_array($string)) return addslashes($string);
    foreach($string as $key => $val) $string[$key] = new_addslashes($val);
    return $string;
}

/**
 * 返回经stripslashes处理过的字符串或数组
 * @param $string 需要处理的字符串或数组
 * @return mixed
 */
function new_stripslashes($string) {
    if(!is_array($string)) return stripslashes($string);
    foreach($string as $key => $val) $string[$key] = new_stripslashes($val);
    return $string;
}

/**
 * 返回经htmlspecialchars处理过的字符串或数组
 * @param $obj 需要处理的字符串或数组
 * @return mixed
 */
function new_html_special_chars($string) {
    if(!is_array($string)) return htmlspecialchars($string);
    foreach($string as $key => $val) $string[$key] = new_html_special_chars($val);
    return $string;
}
/**
 * 安全过滤函数
 *
 * @param $string
 * @return string
 */
function safe_replace($string) {
    $string = str_replace('%20','',$string);
    $string = str_replace('%27','',$string);
    $string = str_replace('%2527','',$string);
    $string = str_replace('*','',$string);
    $string = str_replace('"','&quot;',$string);
    $string = str_replace("'",'',$string);
    $string = str_replace('"','',$string);
    $string = str_replace(';','',$string);
    $string = str_replace('<','&lt;',$string);
    $string = str_replace('>','&gt;',$string);
    $string = str_replace("{",'',$string);
    $string = str_replace('}','',$string);
    $string = str_replace('\\','',$string);
    return $string;
}



/**
 * 过滤ASCII码从0-28的控制字符
 * @return String
 */
function trim_unsafe_control_chars($str) {
    $rule = '/[' . chr ( 1 ) . '-' . chr ( 8 ) . chr ( 11 ) . '-' . chr ( 12 ) . chr ( 14 ) . '-' . chr ( 31 ) . ']*/';
    return str_replace ( chr ( 0 ), '', preg_replace ( $rule, '', $str ) );
}

/**
 * 格式化文本域内容
 *
 * @param $string 文本域内容
 * @return string
 */
function trim_textarea($string) {
    $string = nl2br ( str_replace ( ' ', '&nbsp;', $string ) );
    return $string;
}

/**
 * 将文本格式成适合js输出的字符串
 * @param string $string 需要处理的字符串
 * @param intval $isjs 是否执行字符串格式化，默认为执行
 * @return string 处理后的字符串
 */
function format_js($string, $isjs = 1) {
    $string = addslashes(str_replace(array("\r", "\n", "\t"), array('', '', ''), $string));
    return $isjs ? 'document.write("'.$string.'");' : $string;
}

/**
 * 获取当前页面完整URL地址
 */
function get_url() {
    $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
    $php_self = $_SERVER['PHP_SELF'] ? safe_replace($_SERVER['PHP_SELF']) : safe_replace($_SERVER['SCRIPT_NAME']);
    $path_info = isset($_SERVER['PATH_INFO']) ? safe_replace($_SERVER['PATH_INFO']) : '';
    $relate_url = isset($_SERVER['REQUEST_URI']) ? safe_replace($_SERVER['REQUEST_URI']) : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.safe_replace($_SERVER['QUERY_STRING']) : $path_info);
    return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
}
/**
 * 字符截取 支持UTF8/GBK
 * @param $string
 * @param $length
 * @param $dot
 */
function str_cut($string, $length, $dot = '...') {
    $strlen = strlen($string);
    if($strlen <= $length) return $string;
    $string = str_replace(array(' ','&nbsp;', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), array('∵',' ', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'), $string);
    $strcut = '';
    if(strtolower(zq_core::load_config('system', 'charset')) == 'utf-8') {
	$length = intval($length-strlen($dot)-$length/3);
	$n = $tn = $noc = 0;
	while($n < strlen($string)) {
	    $t = ord($string[$n]);
	    if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
		$tn = 1; $n++; $noc++;
	    } elseif(194 <= $t && $t <= 223) {
		$tn = 2; $n += 2; $noc += 2;
	    } elseif(224 <= $t && $t <= 239) {
		$tn = 3; $n += 3; $noc += 2;
	    } elseif(240 <= $t && $t <= 247) {
		$tn = 4; $n += 4; $noc += 2;
	    } elseif(248 <= $t && $t <= 251) {
		$tn = 5; $n += 5; $noc += 2;
	    } elseif($t == 252 || $t == 253) {
		$tn = 6; $n += 6; $noc += 2;
	    } else {
		$n++;
	    }
	    if($noc >= $length) {
		break;
	    }
	}
	if($noc > $length) {
	    $n -= $tn;
	}
	$strcut = substr($string, 0, $n);
	$strcut = str_replace(array('∵', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'), array(' ', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), $strcut);
    } else {
	$dotlen = strlen($dot);
	$maxi = $length - $dotlen - 1;
	$current_str = '';
	$search_arr = array('&',' ', '"', "'", '“', '”', '—', '<', '>', '·', '…','∵');
	$replace_arr = array('&amp;','&nbsp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;',' ');
	$search_flip = array_flip($search_arr);
	for ($i = 0; $i < $maxi; $i++) {
	    $current_str = ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
	    if (in_array($current_str, $search_arr)) {
		$key = $search_flip[$current_str];
		$current_str = str_replace($search_arr[$key], $replace_arr[$key], $current_str);
	    }
	    $strcut .= $current_str;
	}
    }
    return $strcut.$dot;
}

/**
 * 获取请求ip
 *
 * @return ip地址
 */
function ip() {
    if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
	$ip = getenv('HTTP_CLIENT_IP');
    } elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
	$ip = getenv('HTTP_X_FORWARDED_FOR');
    } elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
	$ip = getenv('REMOTE_ADDR');
    } elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
	$ip = $_SERVER['REMOTE_ADDR'];
    }
    return preg_match ( '/[\d\.]{7,15}/', $ip, $matches ) ? $matches [0] : '';
}

/**
 * 产生随机字符串
 *
 * @param    int        $length  输出长度
 * @param    string     $chars   可选的
 * @return   string     字符串
 */
function random($length, $chars = '0123456789') {
    $hash = '';
    $max = strlen($chars) - 1;
    for($i = 0; $i < $length; $i++) {
	$hash .= $chars[mt_rand(0, $max)];
    }
    return $hash;
}

/**
 * 将字符串转换为数组
 *
 * @param	string	$data	字符串
 * @return	array	返回数组格式，如果，data为空，则返回空数组
 */
function string2array($data) {
    if($data == '') return array();
    @eval("\$array = $data;");
    return $array;
}
/**
 * 将数组转换为字符串
 *
 * @param	array	$data		数组
 * @param	bool	$isformdata	如果为0，则不使用new_stripslashes处理，可选参数，默认为1
 * @return	string	返回字符串，如果，data为空，则返回空
 */
function array2string($data, $isformdata = 1) {
    if($data == '') return '';
    if($isformdata) $data = new_stripslashes($data);
    return addslashes(var_export($data, TRUE));
}

/**
 * 转换字节数为其他单位
 *
 *
 * @param	string	$filesize	字节大小
 * @return	string	返回大小
 */
function sizecount($filesize) {
    if ($filesize >= 1073741824) {
	$filesize = round($filesize / 1073741824 * 100) / 100 .' GB';
    } elseif ($filesize >= 1048576) {
	$filesize = round($filesize / 1048576 * 100) / 100 .' MB';
    } elseif($filesize >= 1024) {
	$filesize = round($filesize / 1024 * 100) / 100 . ' KB';
    } else {
	$filesize = $filesize.' Bytes';
    }
    return $filesize;
}

/**
* 字符串加密、解密函数
*
*
* @param	string	$txt		字符串
* @param	string	$operation	ENCODE为加密，DECODE为解密，可选参数，默认为ENCODE，
* @param	string	$key		密钥：数字、字母、下划线
* @param	string	$expiry		过期时间
* @return	string
*/
function sys_auth($string, $operation = 'ENCODE', $key = '', $expiry = 0) {
    $key_length = 4;
    $key = md5($key != '' ? $key : zq_core::load_config('system', 'auth_key'));
    $fixedkey = md5($key);
    $egiskeys = md5(substr($fixedkey, 16, 16));
    $runtokey = $key_length ? ($operation == 'ENCODE' ? substr(md5(microtime(true)), -$key_length) : substr($string, 0, $key_length)) : '';
    $keys = md5(substr($runtokey, 0, 16) . substr($fixedkey, 0, 16) . substr($runtokey, 16) . substr($fixedkey, 16));
    $string = $operation == 'ENCODE' ? sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$egiskeys), 0, 16) . $string : base64_decode(substr($string, $key_length));

    $i = 0; $result = '';
    $string_length = strlen($string);
    for ($i = 0; $i < $string_length; $i++){
	$result .= chr(ord($string{$i}) ^ ord($keys{$i % 32}));
    }
    if($operation == 'ENCODE') {
	return $runtokey . str_replace('=', '', base64_encode($result));
    } else {
	if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$egiskeys), 0, 16)) {
	    return substr($result, 26);
	} else {
	    return '';
	}
    }
}

/**
 * 生成sql语句，如果传入$in_cloumn 生成格式为 IN('a', 'b', 'c')
 * @param $data 条件数组或者字符串
 * @param $front 连接符
 * @param $in_column 字段名称
 * @return string
 */
function to_sqls($data, $front = ' AND ', $in_column = false) {
    if($in_column && is_array($data)) {
	$ids = '\''.implode('\',\'', $data).'\'';
	$sql = "$in_column IN ($ids)";
	return $sql;
    } else {
	if ($front == '') {
	    $front = ' AND ';
	}
	if(is_array($data) && count($data) > 0) {
	    $sql = '';
	    foreach ($data as $key => $val) {
		$sql .= $sql ? " $front `$key` = '$val' " : " `$key` = '$val' ";
	    }
	    return $sql;
	} else {
	    return $data;
	}
    }
}

/**
 * 生成随机字符串
 * @param string $lenth 长度
 * @return string 字符串
 */
function create_randomstr($lenth = 4) {
    return random($lenth, '123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ');
}

/**
 * Function dataformat
 * 时间转换
 * @param $n INT时间
 */
function dataformat($n) {
    $hours = floor($n/3600);
    $minite	= floor($n%3600/60);
    $secend = floor($n%3600%60);
    $minite = $minite < 10 ? "0".$minite : $minite;
    $secend = $secend < 10 ? "0".$secend : $secend;
    if($n >= 3600){
	return $hours.":".$minite.":".$secend;
    }else{
	return $minite.":".$secend;
    }

}


function preprocessFilter($filter){
    if (gettype($filter) == "array"){
	return $filter;
    }else{
	$filters = explode(";", $filter);
	$list = array();
	foreach ($filters as $filter){
	    list($key, $val) = explode("=", $filter);
	    $list[$key] = $val;
	}
	return $list;
    }
}

/**
 * 模板调用
 * @param $module 这个模板所在的模块. 模板是按照模块目录分放的
 * @param $template 需要调用的模板
 * @param $style 需要调用的样式
 *
 */
function template($module, $template, $style = '', $output=true) {
    $TEMPLATE_CACHE_PATH = CACHE_PATH . "cache_template" . DIRECTORY_SEPARATOR;
    $TEMPLATE_PATH = ZQ_PATH. "templates" . DIRECTORY_SEPARATOR;
    $USER_TEMPLATE_PATH = ZQCMS_PATH."templates".DIRECTORY_SEPARATOR;

    $module = str_replace("/", DIRECTORY_SEPARATOR, $module);
    if (!empty($style) && preg_match('/[a-z0-9\-_]+/is', $style)) {
    } elseif (empty($style) && zq_core::load_config('system', "style")) {
	$style = zq_core::load_config('system', 'style');
    }else {
	$style = 'default';
    }

    if (!$style) {
	$style = 'default';
    }
    //Configure Smarty
    zq_core::load_sys_class("smarty", 'libs'.DIRECTORY_SEPARATOR."smarty", 0);
    $smarty = new Smarty();
    $smarty->setCompileDir($TEMPLATE_CACHE_PATH."compiles".DIRECTORY_SEPARATOR);
    $smarty->setConfigDir($TEMPLATE_CACHE_PATH."configs".DIRECTORY_SEPARATOR);
    $smarty->setCacheDir($TEMPLATE_CACHE_PATH."caches".DIRECTORY_SEPARATOR);

    //load zqcms plugin for smarty
    $smarty->addPluginsDir(ZQ_PATH."libs".DIRECTORY_SEPARATOR."plugins");

    //$smarty->debugging = true;

    //先去尝试读取用户定义的模板
    if (file_exists($USER_TEMPLATE_PATH.$style.DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.$template.".html")) {
	$smarty->setTemplateDir($USER_TEMPLATE_PATH.$style);
	register_template_data("style_dir", DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR.$style);
    } else {
	$smarty->setTemplateDir($TEMPLATE_PATH.$style);
	register_template_data("style_dir", DIRECTORY_SEPARATOR."zqcms".DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR.$style);
    }
    $path = $module.DIRECTORY_SEPARATOR.$template.".html";
    if ($smarty->templateExists($path)) {
	//将所有的变量 全部传给模板
	//$this->caching = Smarty::CACHING_LIFETIME_CURRENT;
	//templateExists()
	//$smarty->setCaching(Smarty::CACHING_LIFETIME_CURRENT);
	//$smarty->setCompileCheck(false);
	if ($output) {
	    //向模板中注册全局变量
	    $values = register_template_data(false, false, false, true);
	    foreach ($values as $k => $v) {
		$smarty->assign($k, $v);
	    }

	    $functions = register_template_plugin(false, false, false, true);
	    foreach ($functions as $k => $function) {
		$smarty->registerPlugin($function['type'], $function['name'], $function['callback']);
	    }

	    $smarty->display($path);
	    //clean cache
	    return true;
	} else {
	    return $smarty->fetch($path);
	}
    }
}

/**
 * 注册变量到模板中
 * @param string $key 模板需要调用的key
 * @param mixed $value 变量值
 * @param boolean $update 是否需要更新此变量
 * @param boolean $get_values 取出所有已经注册的变量
 */
function register_template_data($key, $value, $update = true, $get_values=false) {
    static $registered_template_data = array();

    if ($get_values) {
	return $registered_template_data;
    }

    if (isset($registered_template_data[$key]) && !$update) {
	return $registered_template_data[$key];
    }

    $registered_template_data[$key] = $value;
    //print_r($registered_template_data);
    return $registered_template_data;
}

/**
 * 注册函数到模板中
 * @param string type 类型 (function, block, compiler, modifier)
 *
 *  function  直接可以在模板中调用此函数 比如date_now  {date_now}  每个函数都会有两个固定的值
 *    $params, $smarty    $params 所有的参数都会在得到比如 {date_now format='Y-M-d'}，  $smarty 全局模板类。 
 *  block  块函数  注册成一个标签。用来引用内部大量的文字 {typelist} <a href='~~link~~'></a>  {/typelist}
 *     每个注册中的函数一共包含有5个参数  具体可以看plugins目录下的block.zq_typelist.php
 *
 *  modifier 修饰器  调用方式{$var|ss}  其中ss就是调用的函数   这里的ss 是我们注册进去的stripslashes
 * @param string name 在smarty模板中的函数名
 * @param string function 回调函数 
 */
function register_template_plugin($type, $name, $callback, $get_values=false) {
    static $registered_template_plugins = array();

    if ($get_values) {
	return $registered_template_plugins;
    }

    $key = $type.$name;

    if (isset($registered_template_plugins[$key])) {
	throw "This $type $name has registered";
	//return $registered_template_plugins[$key];	
	return;
    }

    $registered_template_plugins[$key] = array(
	'type' => $type,
	'name' => $name,
	'callback' => $callback
    );

    return $registered_template_plugins;
}


function getFlag($flag) {
    $s = "";
    switch ($flag) {
	case 0:
	    $s = "";
	    break;
	case 1:
	    $s = "h";
	    break;
	case 2:
	    $s = "c";
	    break;
	case 3:
	    $s = "f";
	    break;
	case 4:
	    $s = 'a';
	    break;
	case 5:
	    $s = "s";
	    break;
	case 6:
	    $s = "b";
	    break;
	default:
	    $s = "";
	    break;
    }
    return $s;
}

function getFlags($flags) {
    $flags = explode(",", $flags);
    $f = array();
    for ($c = 0; $c < count($flags); $c++) {
	$flag = trim($flags[$c]);
	$f[] = getFlag($flag);
    }

    return join(",", $f);
}

/**
 * 分页函数
 *
 * @param $totalCount 数据总数
 * @param $currentPage 当前页数
 * @param $pagesize 每页显示数量
 * @param $urlrule URL规则
 * @param $array 需要传递的数据 
 *
 * @return 
 */
function pages($totalCount, $currentPage, $pagesize=20, $urlrule='', $array=array(), $setpages=10) {
    //加载URL rule
    if ($urlrule == '') {
	$urlrule = page_url_par('page={$page}');
    }
    $html = "";
    if ($totalCount > $pagesize) {
	$page = $setpages + 1;
	$offset = ceil($setpages / 2 - 1);
	$totalPages = ceil($totalCount / $pagesize);
	
	$from = $currentPage - $offset;
	$to = $currentPage + $offset;
	$more = 0;
	if ($page >= $totalPages) {
	    $from = 2;
	    $to = $totalPages - 1;
	} else {
	    if ($from <= 1) {
		$to = $page - 1;
		$from = 2;
	    } elseif ($to >= $totalPages) {
		$from = $totalPages - ($page - 2);
		$to = $totalPages - 1;
	    }
	    $more = 1;
	}
	$html = '<div class="pages"><span class="page_count">当前第 '. $currentPage .' 页 / 共 '. $totalPages .' 页</span>';

	if ($currentPage > 0) {
	    if ($currentPage == $totalPages) {
	        $html .= '<span class="first"><a href="'.pageurl($urlrule, 1, $array).'">到首页</a></span>';
	    }
	    if ($currentPage > 1) {
		$html .= '<span class="prev"><a href="'.pageurl($urlrule, $currentPage-1, $array).'">上一页</a></span>';
	    }

	    if ($currentPage == 1) {
	        $html .= '<strong>1</strong>';
	    } elseif ($currentPage <= 6) {
	        $html .= '<a href="'.pageurl($urlrule, 1, $array).'">1</a>';
	    }
	}
	for ($i = $from; $i <= $to; $i++) {
	    if ($i == $currentPage) {
	        $html .= '<strong>'.$i.'</strong>';
	    }else{
	        $html .= '<a href="'.pageurl($urlrule, $i, $array).'">'.$i.'</a>';
	    }
	
	}
	if ($currentPage < $totalPages) {
	    $html .= '<span class="next"><a href="'.pageurl($urlrule, $currentPage+1, $array).'">下一页</a></span>';

	    if ($currentPage < $totalPages && $more) {
	        $html .= '<span class="last"><a href="'.pageurl($urlrule, $totalPages, $array).'">到末页</a></span>';
	    }

	} elseif ($currentPage == $totalPages) {
	    $html .= '<strong>'.$totalPages.'</strong>';
	}
	$html .= "</div>";
    }
    return $html;
}

/**
 * 返回页面路径
 * @param $urlrule 分页规则
 * @param $currentPage 当前页
 * @param $array 需要传递的数据
 *
 * @return 完成的url
 */
function pageurl($urlrule, $currentPage, $array=array()) {
    $findme = array('{$page}');
    $replaceme = array($currentPage);

    if (is_array($array)) {
	foreach ($array as $k => $v) {
	    $findme[] = $k;
	    $replaceme[] = $v;
	}
    }
    $url = str_replace($findme, $replaceme, $urlrule);

    return $url;
}

function page_url_par($par, $url = '') {
    if ($url == '') {
	$url = get_url();
    }
    $pos = strpos($url, '?');

    if ($pos === false) {
	$url .= '?'.$par;
    } else {
	$querystring = substr(strstr($url, '?'), 1);
	parse_str($querystring, $pars);
	$query_array = array();
	foreach ($pars as $k => $v) {
	    if ($k != 'page') {
		$query_array[$k] = $v;
	    }
	}
	$querystring = http_build_query($query_array).'&'.$par;
	$url = substr($url, 0, $pos) . '?' . $querystring;
    }
    return $url;
}
?>
