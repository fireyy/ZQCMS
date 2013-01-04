<?php
defined('IN_ZQCMS') or exit('Permission denied.'); 
/**
 * digg处理ajax文件
 */
$db = '';
$action = $_GET['action'];
$poster = $action."post";
if($_GET['type'] && $_GET['id']) {
	$type = $_GET['type'];
  
  $db = zq_core::load_model($type.'_model');
	$id = $_GET['id'];
  
  hits($id);
}


/**
 * 获取评价数量
 * @param $hitsid
 */
function get_count($hitsid) {
	global $db, $poster;
    $r = $db->get_one(array('id'=>$hitsid));  
    if(!$r) return false;	
	return $r;	
}

/**
 * 评价次数统计
 * @param $hitsid
 */
function hits($hitsid) {
	global $db, $poster;
	$r = get_count($hitsid);
	if(!$r) return false;
	$views = $r[$poster] + 1;
  echo $views;
	$sql = array($poster=>$views,'lastpost'=>time());
  return $db->update($sql, array('id'=>$hitsid));
}

?>