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
}
?>
