<?php
defined('IN_ZQCMS') or exit('Permission denied.'); 
/**
 * 评分处理ajax文件
 */
$db = '';
if($_POST['id'] && $_POST['score']) {
  $id = $_POST['id'];
	$score = intval($_POST['score']);
  
  $db = zq_core::load_model('game_model');
	$row = $db->get_one(array('id'=>$id));
	if(!$row) return false;
  
  $scorecount = intval($row['scorecount']) + 1;
  $scores = intval($row['scores']) + $score;

	$sql = array("scorecount"=>$scorecount,'scores'=>$scores,'lastpost'=>time());
  $db->update($sql, array('id'=>$id));
  $score = trim(sprintf("%4.2f", $scores / $scorecount));
  
  echo $score;
}

?>