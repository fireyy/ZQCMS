<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>ZQCMS</title>

		<link rel="stylesheet" href="<?php echo ZQ_PATH_ADMIN.'assets/css/admin.css'; ?>">
		<link rel="stylesheet" href="<?php echo ZQ_PATH_ADMIN.'assets/css/popup.css'; ?>">

		<script src="<?php echo ZQ_PATH_ADMIN.'assets/js/lib.js'; ?>"></script>
		<script src="<?php echo ZQ_PATH_ADMIN.'assets/js/helpers.js'; ?>"></script>
		<script src="<?php echo ZQ_PATH_ADMIN.'assets/js/popup.js'; ?>"></script>
		<script>var Base_url = '';</script>
	</head>
	<body>

		<div id="top">
			<a id="logo" href="#">
				<img src="<?php echo ZQ_PATH_ADMIN.'assets/img/logo.png'; ?>" alt="ZQCMS">
			</a>

			<?php if($_SESSION['userid']): ?>
			<div class="nav">
				<ul>
          <li<?php if($_GET['c']=='index') echo ' class="active"'; ?>><a href="?m=admin&c=index">概况</a></li>
          <li<?php if($_GET['c']=='setting') echo ' class="active"'; ?>><a href="?m=admin&c=setting">站点设置</a></li>
          <li<?php if($_GET['c']=='update') echo ' class="active"'; ?>><a href="?m=admin&c=update">在线升级</a></li>
          <li<?php if($_GET['c']=='profile') echo ' class="active"'; ?>><a href="?m=admin&c=profile">用户信息</a></li>
				</ul>
			</div>

			<p>欢迎 <strong><?php echo param::get_cookie('admin_username'); ?></strong>. 
			<a href="?m=admin&c=index&a=logout">注销</a>
      <a href="/">网站首页</a>
			<?php endif; ?>
		</div>

