<?php
defined('IN_ZQCMS') or exit('Permission denied.'); 
/**
 * digg处理ajax文件
 */
$action = $_GET['action'];
$poster = $action."post";

if($_GET['type'] && $_GET['id']) {
	$type = $_GET['type'];
    $db = zq_core::load_model($type.'_model');
	$id = $_GET['id'];
    $r = $db->get_one(array('id'=>$id));  
    if(!$r) return false;
    $views = $r[$poster] + 1;
    echo $views;
    $sql = array($poster=>$views,'lastpost'=>time());
    return $db->update($sql, array('id'=>$id));
}

?>