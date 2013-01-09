<?php
/**
 * ZQCMS入口
 *
 */

define('ZQCMS_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);

include ZQCMS_PATH."/zqcms/core.php";

// check install
if(!file_exists(ZQCMS_PATH."install/lock.txt")){
  //install
  header("Location: install/index.php");
}else{
  //run a app
  zq_core::Run();
}
?>
