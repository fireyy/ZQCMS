<?php

/**
	Helpers
*/
function random($length = 16) {
	$pool = str_split('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', 1);
	$value = '';

	for ($i = 0; $i < $length; $i++)  {
		$value .= $pool[mt_rand(0, 61)];
	}

	return $value;
}

function is_real_writable($path) {
	// can we write a config file?
	// note: on win the only way to really test is to try and write a new file to disk.
	if(@file_put_contents(rtrim($path, '/') . '/test.php', '<?php //test') === false) {
		return false;
	}

	unlink($path.'/test.php');

	return true;
}

function array_get($arr, $key, $default = false) {
	if(is_array($key)) {
		$data = array();

		foreach($key as $k) {
			$data[$k] = isset($arr[$k]) ? $arr[$k] : $default;
		}

		return $data;
	}

	return isset($arr[$key]) ? $arr[$key] : $default;
}

function get($key, $default = false) {
	return array_get($_GET, $key, $default);
}

function post($key, $default = false) {
	return array_get($_POST, $key, $default);
}

function is_post() {
	return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function render($file, $data = array()) {
	extract($data, EXTR_SKIP);
	require PATH . 'views/' . $file . '.php';
}

function redirect($action) {
	header('Location: index.php?' . http_build_query(array('action' => $action)));
}

function _sql_execute($sql,$r_tablepre = '',$s_tablepre = 'zq_') {
    $sqls = _sql_split($sql,$r_tablepre,$s_tablepre);
	if(is_array($sqls))
    {
		foreach($sqls as $sql)
		{
			if(trim($sql) != '')
			{
				mysql_query($sql);
			}
		}
	}
	else
	{
		mysql_query($sqls);
	}
	return true;
}

function _sql_split($sql,$r_tablepre = '',$s_tablepre='zq_') {
	
	if($r_tablepre != $s_tablepre) $sql = str_replace($s_tablepre, $r_tablepre, $sql);
	$sql = str_replace("\r", "\n", $sql);
	$ret = array();
	$num = 0;
	$queriesarray = explode(";\n", trim($sql));
	unset($sql);
	foreach($queriesarray as $query)
	{
		$ret[$num] = '';
		$queries = explode("\n", trim($query));
		$queries = array_filter($queries);
		foreach($queries as $query)
		{
			$str1 = substr($query, 0, 1);
			if($str1 != '#' && $str1 != '-') $ret[$num] .= $query;
		}
		$num++;
	}
	return $ret;
}