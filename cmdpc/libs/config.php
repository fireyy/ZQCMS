<?php
date_default_timezone_set("Asia/Shanghai");
define('DAYS', date('Y-m-d', time()));
define('TIMES', time());
define("ROOT_PATH", realpath(".".DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR);
define("ZQCMS_PATH", realpath("..".DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR);

require_once ZQCMS_PATH."zqcms/core.php";
require_once ROOT_PATH . "libs".DIRECTORY_SEPARATOR."functions.php";
require_once ROOT_PATH . "models/service_model.php";
require_once ROOT_PATH . "libs/router.php";

ini_set('session.cache_expire', 200000);
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 2000000);
ini_set('session.gc_maxlifetime', 200000);
ini_set('session.use_cookies', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.use_trans_sid', 0);

session_start();
?>
