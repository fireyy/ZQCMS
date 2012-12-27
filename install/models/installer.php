<?php


class Installer {

	/**
		Check required php modules
	*/
	public static function compat_check() {
		$compat = array();

		// php
		if(version_compare(PHP_VERSION, '5.3.0', '<')) {
			$compat[] = '<strong>Anchor requires PHP 5.3 or newer.</strong><br>
				<em>Your current environment is running PHP ' . PHP_VERSION . '</em>';
		}

		// PDO
		if(class_exists('PDO') === false) {
			$compat[] = '<strong>Anchor requires PDO (PHP Data Objects).</strong><br>
			<em>You can find more about <a href="//php.net/manual/en/book.pdo.php">installing and setting up PHP Data Objects</a>
			on the php.net website</em>';
		} else {
			if(in_array('mysql', PDO::getAvailableDrivers()) === false) {
				$compat[] = '<strong>Anchor requires MySQL PDO Driver.</strong><br>
					<em>You can find more about <a href="//php.net/manual/en/ref.pdo-mysql.php">installing and setting up MySQL PDO Driver</a>
					on the php.net website</em>';
			}
		}

		return $compat;
	}

	/**
		Database install
	*/
	private static function install_schema() {
		$data = $_SESSION;

		$sql = str_replace('[[now]]', time(), file_get_contents('assets/sql/zqcms_db.sql'));

		$dsn = 'mysql:dbname=' . $data['db']['name'] . ';host=' . $data['db']['host'] . ';port=' . $data['db']['port'];
		$dbh = new PDO($dsn, $data['db']['user'], $data['db']['pass']);

		try {
			$dbh->beginTransaction();
			$dbh->exec('SET NAMES `utf8`');
			$dbh->exec($sql);

			// create metadata
			#$sql= "INSERT INTO `meta` (`key`, `value`) VALUES ('sitename', ?), ('description', ?), ('theme', ?);";
			#$statement = $dbh->prepare($sql);
			#$statement->execute(array($data['site']['site_name'], $data['site']['site_description'], $data['site']['theme']));

			// create user account
			$sql= "INSERT INTO `#@__members` (`name`, `passwd`, `salt`, `email`, `jointime`) VALUES (?, ?, ?, ?, ?);";
			$statement = $dbh->prepare($sql);
			$statement->execute(array($data['user']['username'], crypt($data['user']['password'], $_SESSION['key']), $_SESSION['key'], $data['user']['email'], time()));

			$dbh->commit();
		} catch(PDOException $e) {
			Messages::add($e->getMessage());

			// rollback any changes
			if($dbh->inTransaction()) {
				$dbh->rollBack();
			}
		}
	}

	/**
		Try to write config file, if not write to tmp and offer to download
	*/
	private static function install_config() {
		$errors = array();
		$data = $_SESSION;
		$template = file_get_contents('../caches/configs/database.php');
    $sys_template = file_get_contents('../caches/configs/system.php');

		$index_page = 'index.php';
		$path_url = trim($data['site']['site_path'], '/');
    $site_name = $data['site']['site_name'];
    if(!empty($_SERVER['HTTP_HOST'])){
      $base_url = 'http://'.$_SERVER['HTTP_HOST'];
    }else{
      $base_url = "http://".$_SERVER['SERVER_NAME'];
    }

		#if(empty($base_url)) {
		#	$base_url = '/';
		#} else {
		#	$base_url = '/' . $base_url . '/';
		#}

		$search = array(
			"'hostname' => 'localhost'",
			"'port' => '3306'",
			"'username' => 'root'",
			"'password' => ''",
			"'database' => 'zqcms'",
      "'tablepre' => 'zq_'",
			"'charset' => 'utf8'"
		);
    $sys_search = array(
			// apllication paths
      "'site_name' => '智趣CMS'",
			"'site_indexurl' => '/'",
			"'site_basehost' => 'http://cms.dev'",
			"'auth_key' => 'z13a'"
    );
		$replace = array(
			"'hostname' => '" . $data['db']['host'] . "'",
			"'port' => '" . $data['db']['port'] . "'",
			"'username' => '" . $data['db']['user'] . "'",
			"'password' => '" . $data['db']['pass'] . "'",
			"'database' => '" . $data['db']['name'] . "'",
      "'tablepre' => '" . $data['db']['tablepre'] . "'",
			"'charset' => '" . $data['db']['collation'] . "'"
		);
    $sys_replace = array(
			// apllication paths
      "'site_name' => '". $site_name ."'",
			"'site_indexurl' => '". $path_url ."'",
			"'site_basehost' => '". $base_url ."'",
			"'auth_key' => '" . $_SESSION['key'] . "'"
    );
		$database = str_replace($search, $replace, $template);
    $system = str_replace($sys_search, $sys_replace, $sys_template);

		if(is_real_writable('../caches/configs/')) {
			if(file_put_contents('../caches/configs/database.php', $database)) {
				// chmod config file to 0640 to be sure
				chmod('../caches/configs/database.php', 0640);
			}
			if(file_put_contents('../caches/configs/system.php', $system)) {
				// chmod config file to 0640 to be sure
				chmod('../caches/configs/system.php', 0640);
			}
		}

		if(file_exists('../caches/configs/database.php') === false || file_exists('../caches/configs/system.php') === false) {
      $html = "";
      if(file_exists('../caches/configs/database.php') === false){
  			// failed to create config file offer to download it
  			$_SESSION['database'] = database;

  			$html = 'It looks like we could not automatically create your config file for you,
  				please download <code><a href="index.php?action=download&file=database">database.php</a></code> and upload it to your anchor
  				installation to complete the setup.';
      }
      if(file_exists('../caches/configs/system.php') === false){
  			// failed to create config file offer to download it
  			$_SESSION['config'] = $system;

  			$html .= 'It looks like we could not automatically create your config file for you,
  				please download <code><a href="index.php?action=download&file=config">system.php</a></code> and upload it to your anchor
  				installation to complete the setup.';
      }
			Messages::add($html);
		}
	}

	/**
		Put it all together
	*/
	private static function run() {
		// create a application key
		$_SESSION['key'] = random(32);

		// install database
		static::install_schema();

		// check we can create config
		static::install_config();

		return true;
	}

	/**
		Collect and validate
	*/
	public static function stage1() {
		$_SESSION = array('lang' => post('language'));
		return true;
	}

	public static function stage2() {
		$post = post(array('host', 'user', 'pass', 'name', 'port', 'collation'));

		if(empty($post['host'])) {
			$errors[] = 'Please specify a database host';
		}

		if(empty($post['name'])) {
			$errors[] = 'Please specify a database name';
		}

		if(empty($post['port'])) {
			$post['port'] = 3306;
		}

		// test connection
		if(empty($errors)) {
			try {
				$dsn = 'mysql:dbname=' . $post['name'] . ';host=' . $post['host'] . ';port=' . $post['port'];
				new PDO($dsn, $post['user'], $post['pass']);
			} catch(PDOException $e) {
				$errors[] = $e->getMessage();
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
		$post = post(array('site_name', 'site_description', 'site_path', 'theme'));

		if(empty($post['site_name'])) {
			$errors[] = 'Please enter a site name';
		}

		if(empty($post['site_path'])) {
			$errors[] = 'Please specify your site path';
		}

		if(isset($errors) && count($errors)) {
			Messages::add($errors);
			return false;
		}

		// save and continue
		$_SESSION['site'] = $post;

		return true;
	}

	public static function stage4() {
		$errors = array();

		$post = post(array('username', 'email', 'password', 'confirm_password'));

		if(empty($post['username'])) {
			$errors[] = 'Please enter a username';
		}

		if(filter_var($post['email'], FILTER_VALIDATE_EMAIL) === false) {
			$errors[] = 'Please enter a valid email address';
		}

		$bad_passwords = array('password', 123456, 12345678, 'qwerty', 'abc123', 'monkey', 1234567, 'letmein', 'trustno1', 'dragon', 'baseball', 111111, 'iloveyou', 'master', 'sunshine', 'ashley', 'bailey', 'passw0rd', 'shadow', 123123, 654321, 'superman', 'qazwsx', 'michael', 'Football');

		if(in_array($post['password'], $bad_passwords)) {
			$errors[] = 'Come on, you can pick a better password than that.';
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