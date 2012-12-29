<?php render('layout/header'); ?>

<div class="content">
	<?php render('layout/nav'); ?>

	<div class="article">
		<h1>数据库信息</h1>

		<p>ZQCMS 需要 MySQL 数据库的支持，您需要填写以下 MySQL 数据库信息。如果您不了解这些是什么，请联系您的 主机空间提供商 或者到 <a href="http://bbs.zqcms.com">ZQCMS 支持论坛</a> 发帖求助。</p>
	</div>

	<form method="post" action="<?php echo rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'); ?>/index.php?action=stage2" autocomplete="off">

		<fieldset>
			<?php echo Messages::read(); ?>

			<p><label><strong>数据库主机</strong>
			<span class="info">一般为 <code>localhost</code>.</span></label>
			<input name="host" value="<?php echo post('host', 'localhost'); ?>"></p>

			<p><label><strong>数据库用户</strong>
			<span class="info">自定义.</span></label>
			<input name="user" value="<?php echo post('user', 'root'); ?>"></p>

			<p><label><strong>数据库密码</strong>
			<span class="info">数据库用户对应的密码.</span></label>
			<input name="pass" value="<?php echo post('pass'); ?>"></p>

			<p><label><strong>数据库名称</strong>
			<span class="info">自定义.</span></label>
			<input name="name" value="<?php echo post('name', 'zqcms'); ?>"></p>
      
			<p><label><strong>数据表前缀</strong>
			<span class="info">自定义.</span></label>
			<input name="tablepre" value="<?php echo post('tablepre', 'zq_'); ?>"></p>
		</fieldset>

		<div class="options">
			<button type="submit">下一步 &raquo;</button>
			<div class="test"></div>
		</div>
	</form>
</div>

<?php render('layout/footer'); ?>