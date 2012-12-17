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

function uses(){
    $args = func_get_args();
    foreach ($args as $file){
	require_once(ROOT_PATH."models/". strtolower($file).'_model.php');
    }
}

?>
