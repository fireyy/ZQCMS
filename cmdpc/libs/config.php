<?php
date_default_timezone_set("Asia/Shanghai");
define('DAYS', date('Y-m-d', time()));
define('TIMES', time());
define("ROOT_PATH", realpath("./")."/");

define("DEDE_PATH", realpath("../")."/");
define("DEDE_DATA", DEDE_PATH."data/");

require_once ROOT_PATH . "libs/mysql.php";
require_once ROOT_PATH . "libs/functions.php";
require_once ROOT_PATH . "libs/router.php";
require_once ROOT_PATH . "libs/model.php";
require_once ROOT_PATH . "libs/JSON.php";

require_once DEDE_DATA . "common.inc.php";

//global vars
$_GLOBAL = array(
    'dbs' => array()
);

$_CONFIG = array(
    'dbs' => array(
	'default' => array(
	    'hostname' => $cfg_dbhost,
	    'database' => $cfg_dbname,
	    'username' => $cfg_dbuser,
	    'password' => $cfg_dbpwd,
	    'tablepre' => $cfg_dbprefix,
	    'charset' => $cfg_db_language,
	    'type' => 'mysql',
	    'debug' => false,
	    'pconnect' => 0,
	    'autoconnect' => 0
	)
    ),
    'cookie_prefix' => "dm9z",
    //dedecms 网站栏目
    'archtype' => array(
	'kaifu' => 6,
	'kaice' => 8,
	'company' => 9,
	'game' => 10,
	'gallery' => 18,
	'gift' => 11
    ),
    'channel' => array(
	'kaifu' => 17,
	'kaice' => 18,
	'company' => 19,
	'game'  => 20,
	'gift'  => 21,
	'gallery' => 22,
	'article' => 1
    )
);

ini_set('session.cache_expire', 200000);
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 2000000);
ini_set('session.gc_maxlifetime', 200000);
ini_set('session.use_cookies', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.use_trans_sid', 0);

session_start();
?>
