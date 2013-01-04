<?php
defined('IN_ZQCMS') or exit('Permission denied.'); 
/**
 * 点击统计
 */
$db = '';
if($_GET['type'] && $_GET['id']) {
	$type = $_GET['type'];
  
  $db = zq_core::load_model($type.'_model');
	$hitsid = $_GET['id'];
  hits($hitsid);
}


/**
 * 获取点击数量
 * @param $hitsid
 */
function get_count($hitsid) {
	global $db;
    $r = $db->get_one(array('id'=>$hitsid));  
    if(!$r) return false;	
	return $r;	
}

/**
 * 点击次数统计
 * @param $contentid
 */
function hits($hitsid) {
	global $db;
	$r = get_count($hitsid);
	if(!$r) return false;
	$views = $r['click'] + 1;
  echo "$('#hits').html('".$views."');";
	$sql = array('click'=>$views,'lastpost'=>time());
    return $db->update($sql, array('id'=>$hitsid));
}

?>