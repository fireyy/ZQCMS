<?php
/**
 * 主框架入口
 */
define("IN_ZQCMS", true);

//zqcms path
define("ZQ_PATH", dirname(__FILE__).DIRECTORY_SEPARATOR);
if (!defined("ZQCMS_PATH")){
    define("ZQCMS_PATH", ZQ_PATH."..".DIRECTORY_SEPARATOR);
}

//CACHE 
define("CACHE_PATH", ZQCMS_PATH.'caches'.DIRECTORY_SEPARATOR);

//current site url
define("SITE_URL", (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ''));

//define referer
define("HTTP_REFERER", (isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : ''));

// load common func and class
zq_core::auto_load_func();

class zq_core {
    /**
     * Create an app and run
     */
    public static function Run() {
	//$result = self::page_init();
	//if (!$result) {
	//    self::error_404();
	//}
    }

    public function load_sys_func($func, $path = '') {
	return self::_load_func($func, $path);
    }

    public function auto_load_func($path = '') {
	return self::_auto_load_func($path);
    }

    /**
     * 加载php类文件
     * @param string $classname 类名
     * @param string $path 指定类的路径
     * @param boolean $initialize 是否初始化
     */
    private function _load_class($classname, $path = '', $initialize=true) {
	static $classes = array();
	//类文件名全部小写化.
	$file_name = strtolower($classname);
	if (empty($path)) {
	    $path = "libs" . DIRECTORY_SEPARATOR . "classes";
	}
	$key = md5($path.DIRECTORY_SEPARATOR.$file_name);
	if (isset($classes[$key])) {
	    if (!empty($classes[$key])) {
		return $classes[$key];
	    } else {
		return true;
	    }
	}
	if (file_exists(ZQ_PATH.$path.DIRECTORY_SEPARATOR.$file_name)) {
	    include ZQ_PATH.$path.DIRECTORY_SEPARATOR.$file_name;
	    if ($initialize) {
		$classes[$key] = new $classname;
	    } else {
		$classes[$key] = true;
	    }
	    return $classes[$key];
	} else {
	    return false;
	}
    }

    /**
     * 加载函数库
     * @param $func 需要加载的函数名
     * @param $path 指定的函数库路径
     */
    private static function _load_func($func, $path='') {
	static $funcs = array();
	if (empty($path)) {
	    $path = "libs" . DIRECTORY_SEPARATOR . "functions";
	}
	$path .= DIRECTORY_SEPARATOR . $func . ".php";
	$key = md5($path);
	if (isset($funcs[$key])) {
	    return true;
	}
	if (file_exists(ZQ_PATH.$path)) {
	    include ZQ_PATH.$path;
	} else {
	    $funcs[$key] = false;
	    return false;
	}
	$funcs[$key] = true;
	return true;
    }

    /**
     * 自动加载函数库
     *
     */
    private static function _auto_load_func($path='') {
	if (empty($path)) {
	    $path = "libs" . DIRECTORY_SEPARATOR . "functions" . DIRECTORY_SEPARATOR . "autoload";
	}
	$path .= DIRECTORY_SEPARATOR . "*.php";
	$files = glob(ZQ_PATH.$path);
	if (!empty($files) && is_array($files)) {
	    foreach ($files as $f) {
		include $f;
	    }
	}
    }

    /**
     * 加载读取配置文件
     * @param string $file 需要加载的配置文件名
     * @param string $key 需要获取的配置key
     * @param string $default 如无法获取到, 即自动返回此默认值
     * @param boolean $reload 强制重载配置
     */
    public static function load_config($file, $key='', $default='', $reload=false) {
	static $configs = array();
	if ($reload || !isset($configs[$file])) {
	    $file_path = CACHE_PATH . "configs" . DIRECTORY_SEPARATOR . $file . ".php";
	    if (file_exists($file_path)) {
		$configs[$file] = include $file_path;
	    }
	}

	if (empty($key))  {
	    return $configs[$file];
	}elseif (isset($configs[$file][$key])) {
	    return $configs[$file][$key];
	} else {
	    return $default;
	}
    }

    //public static function header_200() {
    //    header('HTTP/1.0 200 OK');
    //    exit;
    //}

    //public static function bad_request() {
    //    header('HTTP/1.0 400 Bad Request');
    //    exit;
    //}

    //public static function forbidden() {
    //    header('HTTP/1.0 403 Forbidden');
    //    exit;
    //}

    //public static function error_404() {
    //    header('HTTP/1.0 404 Not Found');
    //    exit;
    //}

    //public static function no_method() {
    //    header('HTTP/1.0 405 Method Not Allowed');
    //    exit;
    //}

    //public static function error_page($message) {
    //    header('HTTP/1.0 403 Forbidden');
    //    exit;
    //}


    //private static function page_init() {
    //    if (!empty($_GET['q'])){
    //        self::get_normal_path(trim($_GET['q'], '/'));
    //        return true;
    //    }else{
    //        if (count($_GET) == 0){
    //    	return true;
    //        }
    //        return false;
    //    }
    //}

    //public static function arg($index = null, $path = null) {
    //    static $arguments;
    //    if (!isset($path)){
    //        $path = $_GET["q"];
    //    }
    //    if (!isset($arguments[$path])){
    //        $arguments[$path] = explode("/", $path);
    //    }

    //    if (!isset($index)){
    //        return $arguments[$path];
    //    }
    //    if (isset($arguments[$path][$index])){        
    //        return $arguments[$path][$index];
    //    }
    //}

    //public static function query_string($index = null) {
    //    $tmp = $_REQUEST;
    //    array_shift($tmp);
    //    $args = array();
    //    foreach ($tmp as $k=>$v){
    //        if (!isset($v)){
    //    	$args[$k] = true;
    //        }else{
    //    	$args[$k] = $v;
    //        }
    //    }

    //    if (!isset($index)){
    //        return $args;
    //    }

    //    if (isset($args[$index])){
    //        return $args[$index];
    //    }
    //}
    //
    //private static function get_normal_path($path) {
    //    global $_GLOBAL;
    //    list($t) = self::arg();
    //    $controller = self::get_controller($t);
    //}
    //
    ////load control file
    //public static function get_controller($t = null) {
    //    chdir(ROOT_PATH."controllers");
    //    $controllers_list = glob("*.php");
    //    if (!isset($t)) {
    //        return;
    //    }
    //    list($type, $action) = explode("=", $t);

    //    $controller_file = $type.".php";
    //    if (!isset(self::$controllers[$controller_file])) {
    //        if (in_array($controller_file, $controllers_list)) {
    //    	$loadfile = ROOT_PATH . "controllers/$controller_file";
    //    	if (is_file($loadfile)) {
    //    	    try{
    //    		require_once $loadfile;
    //    	    }catch (Exception $e){
    //    		echo $e->getMessage();
    //    	    }

    //    	    $className = "{$type}_controller";
    //    	    $controller = new $className($action);
    //    	    if ($controller) {
    //    		self::$controllers[$controller_file] = $controller;
    //    	    }
    //    	} 
    //        }
    //    }
    //    return self::$controllers[$controller_file];
    //}
}
?>
