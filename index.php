<?php
/**
 * ZQCMS入口
 *
 */

define('ZQCMS_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);

include ZQCMS_PATH."/zqcms/router.php";

//run a app
Router::Start();
?>
