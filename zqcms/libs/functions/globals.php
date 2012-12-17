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
    zq_core::load_sys_class("smarty", 'libs'.DIRECTORY_SEPARATOR."smarty", 0);
    $smarty = new Smarty();
    

    if (!$style) {
	$style = 'default';
    }
    //Configure Smarty
    //$smarty->setTemplateDir('/web/www.example.com/guestbook/templates/');
    //$smarty->setCompileDir('/web/www.example.com/guestbook/templates_c/');
    //$smarty->setConfigDir('/web/www.example.com/guestbook/configs/');
    //$smarty->setCacheDir('/web/www.example.com/guestbook/cache/');
    //$this->caching = Smarty::CACHING_LIFETIME_CURRENT;
    //templateExists()
    //$smarty->setCaching(Smarty::CACHING_LIFETIME_CURRENT);
    //$smarty->setCompileCheck(false);
}

template('conetent', 'index');
?>
