<?php
defined("IN_ZQCMS") or exit("Permission denied.");

class url {
    private $urlrules, $html_root;
    public function __construct() {
    	$system_config = zq_core::load_config('system');
    	$this->site_rewrite = $system_config['site_rewrite'];
    	$this->urlBase = $system_config['site_basehost'].$system_config['site_indexurl'];
		$this->request = zq_core::load_sys_class('Request');
		$this->router = zq_core::load_sys_class('Alloy_Router');
		$this->html_root = zq_core::load_config('system', 'html_root');
    }

    public function url($params = array(), $routeName = null, $queryParams = array(), $qsAppend = false) {
    	$urlBase = $this->urlBase;

    	// Detemine what URL is from param types
        if(is_string($params)) {
            $routeName = $params;
            $params = array();
        } elseif(!is_array($params)) {
            throw new Exception("First parameter of URL must be array or string route name");
        }

    	// Is there query string data?
        $queryString = "";
        $request = $this->request;
        if(true === $qsAppend && $request->query()) {
            $queryParams = array_merge($request->query(), $queryParams);
        }
        if(count($queryParams) > 0) {
            // Build query string from array $qsData
            $queryString = http_build_query($queryParams, '', '&amp;');
        } else {
            $queryString = false;
        }
        
        // Get URL from router object by reverse match
        $url = str_replace('%2f', '/', strtolower($this->router->url($params, $routeName)));
        
        // Use query string if URL rewriting is not enabled
        if($this->site_rewrite) {
            $url = $urlBase . $url . (($queryString !== false) ? '?' . $queryString : '');
        } else {
            $url = $urlBase . '?u=' . $url . (($queryString !== false) ? '&amp;' . $queryString : '');
        }
        
        // Return fully assembled URL
        $url = str_replace('///', '/', $url);

        $url_arr = array();
		//静态
		//动态
		$url_arr[0] = $url_arr[1] = $url;
        return $url_arr;
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
		$params = array(
			"id" => $id
		);
		return $this->url($params, $type_name."_show");
    }

    /**
     * 分类列表页面url
     */
    public function typeurl($typeid, $page=1, $array=array()) {
		$typedb = zq_core::load_model('type_model');
		$typeinfo = $typedb->get_one(array('id'=>$typeid));
		$type_name = $typeinfo['name'];
		$routeName = $type_name."_lists";
		if(isset($array["action"]) && !empty($array["action"])){
			$routeName = $type_name."_".$array["action"];
		}
		return $this->url($array, $routeName);
    }
}

?>
