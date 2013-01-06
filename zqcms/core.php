<?php
/**
 * 主框架入口
 */
define("IN_ZQCMS", true);

date_default_timezone_set("Asia/Shanghai");
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

define('UPDATE_TMP', CACHE_PATH.'update/source');

$ver = CACHE_PATH.'update/ver.txt';
$fp = fopen($ver, 'r');
$ver = @fread($fp, filesize($ver));
fclose($fp);
define('ZQCMS_VERSION', $ver);

// load common func and class
zq_core::load_sys_func("globals");
zq_core::load_sys_func("globals");
zq_core::auto_load_func();
//设定网站配置

register_template_data("site_config", zq_core::load_config("system"));

/**
 * 
 */
class zq_core {
    /**
     * Create an app and run
     */
    public static function Run() {
	return self::load_sys_class('Router');
    }

    /**
     * 加载系统自带的类
     */
    public static function load_sys_class($classname, $path = '', $initialize = true) {
	return self::_load_class($classname, $path, $initialize);
    }

    /**
     * 加载数据模型
     */
    public static function load_model($classname) {
	return self::_load_class($classname, 'models');
    }

    public static function load_sys_func($func, $path = '') {
	return self::_load_func($func, $path);
    }

    public static function auto_load_func($path = '') {
	return self::_auto_load_func($path);
    }

    /**
     * 加载php类文件
     * @param string $classname 类名
     * @param string $path 指定类的路径
     * @param boolean $initialize 是否初始化
     */
    private static function _load_class($classname, $path = '', $initialize=true) {
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

	if (file_exists(ZQ_PATH.$path.DIRECTORY_SEPARATOR.$file_name.".php")) {
	    include ZQ_PATH.$path.DIRECTORY_SEPARATOR.$file_name.".php";
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
}
?>
