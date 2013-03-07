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
        $requestM = isset($_GET['m']) ? $_GET['m'] : '';

        if($requestM != ""){
            $param = zq_core::load_sys_class('param');
            define("ROUTE_M", $param->route_m());
            define("ROUTE_C", $param->route_c());
            define("ROUTE_A", $param->route_a());
        }else{
            $router = zq_core::load_sys_class('Alloy_Router');
            require CACHE_PATH .DIRECTORY_SEPARATOR. 'configs/router.php';
            $requestUrl = isset($_GET['u']) ? $_GET['u'] : '/';
            $request = zq_core::load_sys_class('Request');
            $requestMethod = $request->method();
            $params = $router->match($requestMethod, $requestUrl);
            // $_GET and $_POST
            $_GET = $params;
            // Set matched params back on request object
            $request->setParams($params);
            $request->route = $router->matchedRoute()->name();

            // Required params
            if(isset($params['module']) && isset($params['controller']) && isset($params['action'])) {
                $request->module = $params['module'];
                $request->controller = $params['controller'];
                $request->action = $params['action'];
                //设定 m, c, a
                define("ROUTE_M", $request->module);
                define("ROUTE_C", $request->controller);
                define("ROUTE_A", $request->action);
            } else {
                exit('Params does not exist.');
            }
        }
	//起动页面
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
