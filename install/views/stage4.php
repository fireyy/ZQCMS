<?php render('layout/header'); ?>

<div class="content">
	<?php render('layout/nav'); ?>

	<div class="article">
		<h1>管理员账号</h1>

		<p>这里将注册一个站点的默认后台管理员账号，之后可以通过该账号登录您的网站后台，进行各种管理操作。</p>
	</div>

	<form method="post" action="<?php echo rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'); ?>/index.php?action=stage4" autocomplete="off">
		<fieldset>

			<?php echo Messages::read(); ?>

			<p>
				<label>
					<strong>用户名</strong>
					<span>登录用户名.</span>
				</label>
				<input name="username" value="<?php echo post('username', 'admin'); ?>">
			</p>

			<p>
				<label>
					<strong>电子邮箱</strong>
					<span>用于取回密码.</span>
				</label>

				<input name="email" value="<?php echo post('email', 'admin@admin.com'); ?>">
			</p>

			<p>
				<label>
					<strong>密码</strong>
					<span>默认密码 <code>admin</code></span>
				</label>
				<input name="password" type="password" value="<?php echo post('password', 'admin'); ?>">
			</p>
      
			<p>
				<label>
					<strong>确认密码</strong>
					<span>请再次输入您的密码.</span>
				</label>
				<input name="confirm_password" type="password" value="<?php echo post('confirm_password', 'admin'); ?>">
			</p>
		</fieldset>

		<div class="options">
			<button type="submit">完成</button>
			<div class="test"></div>
		</div>
	</form>
</div>

<?php render('layout/footer'); ?>