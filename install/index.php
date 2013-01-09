<?php

// Define base path
define('PATH', pathinfo(__FILE__, PATHINFO_DIRNAME) . DIRECTORY_SEPARATOR);
define('ZQCMS_PATH', PATH."..".DIRECTORY_SEPARATOR);

$ver_path = ZQCMS_PATH.'caches/update/ver.txt';
$fp = fopen($ver_path, 'r');
$ver_path = @fread($fp, filesize($ver_path));
fclose($fp);

// ZQCMS version
define('ZQCMS_VERSION', $ver_path);
ini_set("session.save_path", ZQCMS_PATH."caches/sessions");

require PATH . 'functions.php';
require PATH . 'models/messages.php';
require PATH . 'models/installer.php';
require PATH . 'controller.php';

// start native session
session_start();

$controller = new Installation_controller;
$method = Installer::compat_check() ? 'compat' : get('action', 'stage1');
$reflector = new ReflectionClass($controller);

if($reflector->hasMethod($method) === false) {
	header("HTTP/1.0 404 Not Found");
	return '';
}

$reflector->getMethod($method)->invoke($controller);