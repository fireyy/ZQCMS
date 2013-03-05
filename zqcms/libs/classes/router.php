<?php
require 'alloy/router.php';
require 'alloy/router/route.php';

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
	//设定 m, c, a
	//起动页面
        $router = new Alloy\Router();
        $params = $router->match('GET', $url);
	$param = zq_core::load_sys_class('param');
	define("ROUTE_M", $param->route_m());
	define("ROUTE_C", $param->route_c());
	define("ROUTE_A", $param->route_a());
	$this->run();
    }

    private function run() {
	$controller = $this->load_controller();
	if (method_exists($controller, ROUTE_A)) {
	    if (preg_match('/^[_]/i', ROUTE_A)) {
		exit('You are visiting the action is to protect the private action');
	    } else {
		call_user_func(array($controller, ROUTE_A));
	    }
	} else {
	    exit('Action does not exist.');
	}
    }

    /**
     * 加载控制器
     */
    public function load_controller($filename = '', $module = '') {
	if (empty($filename)) $filename = ROUTE_C;
	if (empty($m)) $m = ROUTE_M;
	$loadfile = ZQ_PATH.'modules'.DIRECTORY_SEPARATOR.$m.DIRECTORY_SEPARATOR.$filename.".php";
	if (file_exists($loadfile)) {
	    $className = strtolower($filename);
	    include $loadfile;
	    if (class_exists($className)) {
		return new $className;
	    } else {
		exit('Controller does not exists');
	    }
	} else {
	    exit("Controller does not exists");
	}
    }
}
?>
