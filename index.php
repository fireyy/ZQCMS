<?php
/**
 * ZQCMS入口
 *
 */

define('ZQ_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);

include ZQ_PATH."/zqcms/router.php";

//run a app
Router::Start();
?>
