<?php 
/**
 *  poster.php 广告JS调用方式
 *
 */
define('ZQCMS_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);
include ZQCMS_PATH.'zqcms/core.php';
$param = zq_core::load_sys_class('param');

if(isset($_GET["id"])) $id = $_GET["id"];
if(!isset($id)) die(' Request Error! ');
$cacheName = 'poster_'.$id;

$cache = getcacheinfo($cacheName,'commons');
if( isset($nocache) || !file_exists($cache["filepath"]) || time() - $cache["filemtime"] > 36000 )
{
    $db = zq_core::load_model('poster_model');
    $row = $db->get_one(array('sign'=>$id));
    $adbody = '';
    $ntime = time();
    if($ntime > $row['enddate'] || $ntime < $row['startdate']) {
        $adbody = $row['default'];
    } else {
        $adbody = $row['content'];
    }
    $adbody = stripslashes($adbody);
    $adbody = str_replace("\r", "\\r",$adbody);
    $adbody = str_replace("\n", "\\n",$adbody);
    if(strpos($adbody, "<script") === false){
        $adbody = "<!--\r\ndocument.write(\"{$adbody}\");\r\n-->\r\n";
    }else{
        $adbody = str_replace('\"', '"',$adbody);
        $adbody = str_replace("\'", "'",$adbody);
        $count = preg_match('/src=(["\'])(.*?)\1/', $adbody, $match);
        //print_r($match);
        if ($count === FALSE){
            $adbody = "<!--\r\ndocument.write(\"{$adbody}\");\r\n-->\r\n";
        }else{
            $adbody = "<!--\r\ndocument.write(\"<scr\"+\"ipt type='text/javascript' src='{$match[2]}'></scr\"+\"ipt>\");\r\n-->\r\n";
        }
    }
    
    setcache($cacheName,$adbody,'commons');
}else{
    $adbody = getcache($cacheName,'commons');
}
echo $adbody;

?>