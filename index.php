<?php
/**
 * ZQCMS入口
 *
 */

define('ZQCMS_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);

include ZQCMS_PATH."/zqcms/core.php";

//run a app
core::Run();
?>
