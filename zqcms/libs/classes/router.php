<?php
class Router {
    /**
     * m Module
     * c Controller
     * a Action
     * 此为固定参数, 之后的参数都自动的
     * 比如首页 即 /
     *     游戏    /game.html=1  /games-page-tag-theme-effect-0-0-0.html 
     *     资讯    /article.html=1 /articles.html
     */
    public function __construct() {
    }

    //public static function Start() {
    //    $result = self::page_init();
    //    if (!$result) {
    //        exit("Action does not exist.");
    //    }
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
    
    /**
     * 加载控制器
     */
    public function load_controller($filename = '', $module = '') {
	//chdir(ROOT_PATH."controllers");
	//$controllers_list = glob("*.php");
	//if (!isset($t)) {
	//    return;
	//}
	//list($type, $action) = explode("=", $t);

	//$controller_file = $type.".php";
	//if (!isset(self::$controllers[$controller_file])) {
	//    if (in_array($controller_file, $controllers_list)) {
	//	$loadfile = ROOT_PATH . "controllers/$controller_file";
	//	if (is_file($loadfile)) {
	//	    try{
	//		require_once $loadfile;
	//	    }catch (Exception $e){
	//		echo $e->getMessage();
	//	    }

	//	    $className = "{$type}_controller";
	//	    $controller = new $className($action);
	//	    if ($controller) {
	//		self::$controllers[$controller_file] = $controller;
	//	    }
	//	} 
	//    }
	//}
	//return self::$controllers[$controller_file];
    }
}
?>
