<?php 
/**
 *  index.php API 入口
 *
 */
define('ZQCMS_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);
include ZQCMS_PATH.'zqcms/core.php';
$param = zq_core::load_sys_class('param');

$op = isset($_GET['op']) && trim($_GET['op']) ? trim($_GET['op']) : exit('Operation can not be empty');
if (isset($_GET['callback']) && !preg_match('/^[a-zA-Z_][a-zA-Z0-9_]+$/', $_GET['callback']))  unset($_GET['callback']);
if (!preg_match('/([^a-z_]+)/i',$op) && file_exists(ZQCMS_PATH.'api/'.$op.'.php')) {
	include ZQCMS_PATH.'api/'.$op.'.php';
} else {
	exit('API handler does not exist');
}
?>