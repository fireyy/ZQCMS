<?php
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
function template($module, $template, $style = '') {
    $TEMPLATE_CACHE_PATH = CACHE_PATH . "cache_template" . DIRECTORY_SEPARATOR;
    $TEMPLATE_PATH = ZQCMS_PATH . "templates" . DIRECTORY_SEPARATOR;
    $USER_TEMPLATE_PATH = ZQ_PATH."templates".DIRECTORY_SEPARATOR;
    
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
    
    //先去尝试读取用户定义的模板
    if (file_exists($USER_TEMPLATE_PATH.$style.DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.$template.".html")) {
	$smarty->setTemplateDir($USER_TEMPLATE_PATH.$style);
    } else {
	$smarty->setTemplateDir($TEMPLATE_PATH.$style);
    }

    //$this->caching = Smarty::CACHING_LIFETIME_CURRENT;
    //templateExists()
    //$smarty->setCaching(Smarty::CACHING_LIFETIME_CURRENT);
    //$smarty->setCompileCheck(false);

    print_r($smarty);
}

template('game', 'page');
?>
