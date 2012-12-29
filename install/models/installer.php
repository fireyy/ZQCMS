<?php

class Installer {

	/**
		测试系统安装需求
	*/
	public static function compat_check() {
		$compat = array();

		// php
    if(version_compare(PHP_VERSION, '5.3.0', '<')) set_magic_quotes_runtime(0);
		if(version_compare(PHP_VERSION, '5.2.0', '<')) {
			$compat[] = '<strong>Anchor requires PHP 5.2 or newer.</strong><br>
				<em>Your current environment is running PHP ' . PHP_VERSION . '</em>';
		}
    #TODO 环境检测
    $sp_testdirs = array(
        '/',
        '/caches/*',
        '/html/*',
        '/install',
        '/uploads/*'
    );
    
		return $compat;
	}

	/**
		数据库导入
	*/
	private static function install_schema() {
		$data = $_SESSION;
    $tablepre = $data['db']['tablepre'];
    
    $sql = file_get_contents('assets/sql/zqcms.sql');    
    
		$lnk = mysql_connect($data['db']['host'], $data['db']['user'], $data['db']['pass']) or die ('Not connected : ' . mysql_error());
		$version = mysql_get_server_info();

		if($version > '4.1') {
			mysql_query("SET NAMES 'utf8'");
		}
			
		if($version > '5.0') {
			mysql_query("SET sql_mode=''");
		}
												
		if(!@mysql_select_db($data['db']['name'])){
			@mysql_query("CREATE DATABASE ".$data['db']['name']);
			if(@mysql_error()) {
				echo 1;exit;
			} else {
				mysql_select_db($data['db']['name']);
			}
		}    

		try {
      // 导入数据表结构
			_sql_execute($sql,$tablepre);

			// 更新站点信息
      $uppp = array("site_name","site_description","site_basehost","site_indexurl","auth_key","valid_key");
      foreach ($uppp as $key => $value) {
        _sql_execute("UPDATE `".$tablepre."options` SET `value`='".$data['site'][$value]."' WHERE `name`='$value';", $tablepre);
      }

			// 创建管理员
      _sql_execute("INSERT INTO ".$tablepre."admin (`name`,`passwd`,`email`) VALUES ('".$data['user']['username']."','".md5($data['user']['passwd'])."','".$data['user']['email']."')", $tablepre);

		} catch(PDOException $e) {
			Messages::add($e->getMessage());
		}
	}

	/**
		写入配置文件
	*/
	private static function install_config() {
		$errors = array();
		$data = $_SESSION;
    $config_path = "../caches/configs/";
		$template = file_get_contents($config_path.'database.sample.php');
    $sys_template = file_get_contents($config_path.'system.sample.php');

		$index_page = 'index.php';
		$path_url = $data['site']['site_indexurl'];
    if(!empty($_SERVER['HTTP_HOST'])){
      $base_url = 'http://'.$_SERVER['HTTP_HOST'];
    }else{
      $base_url = "http://".$_SERVER['SERVER_NAME'];
    }
    $_SESSION['site']['site_basehost'] = $base_url;
    $auth_key = chr(mt_rand(ord('A'),ord('Z'))).chr(mt_rand(ord('a'),ord('z'))).chr(mt_rand(ord('A'),ord('Z'))).chr(mt_rand(ord('A'),ord('Z'))).chr(mt_rand(ord('a'),ord('z'))).mt_rand(1000,9999).chr(mt_rand(ord('A'),ord('Z')));
    $_SESSION['site']['auth_key'] = $auth_key;

		$search = array(
			"'hostname' => '~hostname~'",
			"'database' => '~database~'",
			"'username' => '~username~'",
			"'password' => ''",
      "'tablepre' => '~tablepre~'"
		);
    $sys_search = array(
      "'site_name' => '~site_name~'",
			"'site_indexurl' => '~site_indexurl~'",
			"'site_basehost' => '~site_basehost~'",
			"'auth_key' => '~auth_key~'",
      'valid_key' => '~valid_key~',
      "'site_description' => '~site_description~'"
    );
		$replace = array(
			"'hostname' => '" . $data['db']['host'] . "'",
      "'database' => '" . $data['db']['name'] . "'",
			"'username' => '" . $data['db']['user'] . "'",
			"'password' => '" . $data['db']['pass'] . "'",
      "'tablepre' => '" . $data['db']['tablepre'] . "'",
		);
    $sys_replace = array(
			// apllication paths
      "'site_name' => '". $data['site']['site_name'] ."'",
			"'site_indexurl' => '". $path_url ."'",
			"'site_basehost' => '". $base_url ."'",
			"'auth_key' => '" . $auth_key . "'",
      "'valid_key' => '". $data['site']['valid_key'] ."'",
      "'site_description' => '". $data['site']['site_description'] ."'"
    );
		$database = str_replace($search, $replace, $template);
    $system = str_replace($sys_search, $sys_replace, $sys_template);

		if(is_real_writable($config_path)) {
			if(file_put_contents($config_path.'database.php', $database)) {
				// chmod config file to 0640 to be sure
				chmod($config_path.'database.php', 0640);
			}
			if(file_put_contents($config_path.'system.php', $system)) {
				// chmod config file to 0640 to be sure
				chmod($config_path.'system.php', 0640);
			}
		}
	}
  
	/**
		在CMDP上注册站点
	*/
  private static function register_site() {
		$errors = array();
		$data = $_SESSION;
    //发送valid key
    $post_data = array(
    	'webUrl' => $data['site']['site_basehost'],
    	'validKey' => $data['site']['valid_key'],
    	'pushTimes' => 3,
    	'webName' => $data['site']['site_name'],
    	'versionNum' => ZQCMS_VERSION
    );

    if (function_exists("curl_init")) {
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
    	curl_setopt($ch, CURLOPT_URL, "http://www.dbplay.com/DataSave_addTCmdpWebsite");
    	curl_setopt($ch, CURLOPT_POST, true);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
    	$response = curl_exec($ch);
    	$response_info = curl_getinfo($ch);
    	$erno = curl_errno($ch);
    	$er = curl_error($ch);
    	curl_close($ch);
    }else{
    	$opts = array(
    	    "http" => array(
    		'method' => 'POST',
    		'header' => 'Content-Type: application/json\r\nAccept: application/json\r\n',
    		'content' => json_encode($post_data)
    	    )
    	);
    	$context = stream_context_create($opts);
    	file_get_contents('http://www.dbplay.com/DataSave_addTCmdpWebsite', false, $context);
    }
  }

	/**
		执行数据库导入和配置更新
	*/
	private static function run() {
		// create a application key
		$_SESSION['key'] = random(32);

		// 导入数据库
		static::install_schema();

		// 写入配置文件
		static::install_config();
    
		// 在CMDP上注册站点
		static::register_site();

		return true;
	}

	/**
		安装步骤
	*/
	public static function stage1() {
		$_SESSION = array('lang' => post('language'));
		return true;
	}

	public static function stage2() {
		$post = post(array('host', 'user', 'pass', 'name', 'tablepre'));
    $tablepre = $post["tablepre"];

		if(empty($post['host'])) {
			$errors[] = '请输入数据库主机地址';
		}

		if(empty($post['name'])) {
			$errors[] = '请输入数据库名';
		}

		// 测试数据库连接
		if(empty($errors)) {
      
  		if(@mysql_connect($post['host'], $post['user'], $post['pass'])) {
    		$server_info = mysql_get_server_info();
    		if($server_info < '4.0') {
    		  $errors[] = "数据库版本低于Mysql 4.0，无法安装ZQCMS，请升级数据库版本！";
    		}else{
      		if($version > '4.1') {
      			mysql_query("SET NAMES 'utf8'");
      		}
			
      		if($version > '5.0') {
      			mysql_query("SET sql_mode=''");
      		}
      		if(!mysql_select_db($post['name'])) {
      			if(!@mysql_query("CREATE DATABASE `".$post['name']."`")) {
          		$errors[] = "成功连接数据库，但是指定的数据库不存在并且无法自动创建，请先通过其他方式建立数据库！";
      			}
      		}
    		}
  		}else{
  		  $errors[] = "无法连接数据库服务器，请检查配置！";
  		}
		}

		if(isset($errors) && count($errors)) {
			Messages::add($errors);
			return false;
		}

		// save and continue
		$_SESSION['db'] = $post;

		return true;
	}

	public static function stage3() {
		$post = post(array('site_name', 'site_description', 'site_indexurl', 'theme'));

		if(empty($post['site_name'])) {
			$errors[] = '请输入站点名称';
		}

		if(empty($post['site_indexurl'])) {
			$errors[] = '请输入站点安装目录，如果是根目录请输入 <code>/</code>';
		}

		if(isset($errors) && count($errors)) {
			Messages::add($errors);
			return false;
		}
    
    $valid_key = substr(sha1(fetch_salt(16).md5(time())), 0, 32);
    $post["valid_key"] = $valid_key;
    
		// save and continue
		$_SESSION['site'] = $post;

		return true;
	}

	public static function stage4() {
		$errors = array();

		$post = post(array('username', 'email', 'password', 'confirm_password'));

		if(empty($post['username'])) {
			$errors[] = '请输入您的用户名';
		}

		if(filter_var($post['email'], FILTER_VALIDATE_EMAIL) === false) {
			$errors[] = '请输入电子邮箱，当您忘记密码时，可以用于取回密码';
		}
    
		if($post['password'] != $post['confirm_password']) {
			$errors[] = '两次输入的密码不一致，请重新确认';
		}

		$bad_passwords = array('','password', 123456, 12345678, 'qwerty', 'abc123', 'monkey', 1234567, 'letmein', 'trustno1', 'dragon', 'baseball', 111111, 'iloveyou', 'master', 'sunshine', 'ashley', 'bailey', 'passw0rd', 'shadow', 123123, 654321, 'superman', 'qazwsx', 'michael', 'Football');

		if(in_array($post['password'], $bad_passwords)) {
			$errors[] = '过于简单的密码会让您的站点变得不够安全';
		}

		//  hunter2
		if($post['password'] == 'hunter2') {
			$errors[] = '&ldquo;See, when YOU type hunter2, it shows to us as *******&rdquo;';
		}

		if(isset($errors) && count($errors)) {
			Messages::add($errors);
			return false;
		}

		// save and continue
		$_SESSION['user'] = $post;

		return static::run();
	}

}