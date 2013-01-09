<?php
/**
 * ZQCMS入口
 *
 */

define('ZQCMS_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);

include ZQCMS_PATH."/zqcms/core.php";

// check install
if(file_exists(CACHE_PATH."configs/database.php")){
  //run a app
  zq_core::Run();
}else{
  //install
  header("Location: install/index.php");
}
?>
