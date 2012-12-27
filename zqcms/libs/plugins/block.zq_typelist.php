<?php
/**
 * ZQCMS PLUGIN
 *
 * ZQCMS 内容模型数据输出
 */

function order_types_data($a, $b) {
    if ($a["order"] == 0) {
	return true;
    }
    if ($b["order"] == 0) {
	return false;
    }
    return $a["order"] > $b["order"];
}

/**
 * @param $params
 * @param $content
 * @param Smarty $smarty
 * @param Boolean $repeat
 *
 * require function getTypeLink
 */
function smarty_block_zq_typelist($params, $content, $smarty, &$repeat, $template) {
    if (isset($content)) {
	$db = zq_core::load_model('type_model');
	$data = $db->select();
	usort($data, 'order_types_data');

	$_template = $content;
	$content = "";

	for ($c = 0; $c < count($data); ++$c) {
	    $modelInfo = $data[$c];
	    
	    if ($modelInfo["ishidden"]) {
		continue;
	    }

	    $currentClass = "";
	    if ($modelInfo["name"] == ROUTE_M && isset($params["currentClass"])) {
	        $currentClass = $params["currentClass"];
	    }

	    $typelink = getTypeLink($modelInfo['id']);
	    $str = str_replace('~name~', $modelInfo['name'], $_template);
	    $str = str_replace('~link~', $typelink, $str);
	    $str = str_replace('~title~', $modelInfo['title'], $str);
	    $str = str_replace('~class~', $currentClass, $str);

	    $content .= $str;
	}

	return $content;
    }
}

?>
