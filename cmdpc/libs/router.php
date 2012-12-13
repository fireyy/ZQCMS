<?php
class Router {
    private static $controllers = array();
    public static function Start() {
	$result = self::page_init();
	if (!$result) {
	    self::error_404();
	}
    }

    public static function header_200() {
	header('HTTP/1.0 200 OK');
	exit;
    }

    public static function bad_request() {
	header('HTTP/1.0 400 Bad Request');
	exit;
    }

    public static function forbidden() {
	header('HTTP/1.0 403 Forbidden');
	exit;
    }

    public static function error_404() {
	header('HTTP/1.0 404 Not Found');
	exit;
    }

    public static function no_method() {
	header('HTTP/1.0 405 Method Not Allowed');
	exit;
    }

    public static function error_page($message) {
	header('HTTP/1.0 403 Forbidden');
	exit;
    }


    private static function page_init() {
	if (!empty($_GET['q'])){
	    self::get_normal_path(trim($_GET['q'], '/'));
	    return true;
	}else{
	    if (count($_GET) == 0){
		return true;
	    }
	    return false;
	}
    }

    public static function arg($index = null, $path = null) {
	static $arguments;
	if (!isset($path)){
	    $path = $_GET["q"];
	}
	if (!isset($arguments[$path])){
	    $arguments[$path] = explode("/", $path);
	}

	if (!isset($index)){
	    return $arguments[$path];
	}
	if (isset($arguments[$path][$index])){        
	    return $arguments[$path][$index];
	}
    }

    public static function query_string($index = null) {
	$tmp = $_REQUEST;
	array_shift($tmp);
	$args = array();
	foreach ($tmp as $k=>$v){
	    if (!isset($v)){
		$args[$k] = true;
	    }else{
		$args[$k] = $v;
	    }
	}

	if (!isset($index)){
	    return $args;
	}

	if (isset($args[$index])){
	    return $args[$index];
	}
    }
    
    /**
     * 从push获取JSON数据
     * 在API接口上, 这些数据只能使用post方法
     */
    public static function getJSON() {
	//-H "Accept: application/json" -H "Content-type: application/json"
	$jsons = new Services_JSON();
	if ($_SERVER["CONTENT_TYPE"] == "application/json") {
	    $data = file_get_contents("php://input");
	    if (!empty($data) && is_string($data)) {
	        //{"a" : 12}, from browser, it will get {\"a\": 12}. so we need remove slashes
	        $json = $jsons->decode(stripcslashes($data));
	        if ($json == null) {
	            return false;
	        }
	        return $json;
	    }
	}
	return false;
    }

    private static function get_normal_path($path) {
	global $_GLOBAL;
	list($t) = self::arg();
	$controller = self::get_controller($t);
    }
    
    //load control file
    public static function get_controller($t = null) {
	chdir(ROOT_PATH."controllers");
	//$controllers_list = scandir(ROOT_PATH . "controllers");
	$controllers_list = glob("*.php");
	if (!isset($t)) {
	    return;
	}
	list($type, $action) = explode("=", $t);

	$controller_file = $type.".php";
	if (!isset(self::$controllers[$controller_file])) {
	    if (in_array($controller_file, $controllers_list)) {
		$loadfile = ROOT_PATH . "controllers/$controller_file";
		if (is_file($loadfile)) {
		    try{
			require_once $loadfile;
		    }catch (Exception $e){
			echo $e->getMessage();
		    }

		    $className = "{$type}_controller";
		    $controller = new $className($action);
		    if ($controller) {
			self::$controllers[$controller_file] = $controller;
		    }
		} 
	    }
	}
	return self::$controllers[$controller_file];
    }
}
?>
