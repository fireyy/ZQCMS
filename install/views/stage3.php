<?php render('layout/header'); ?>

<div class="content">
	<?php render('layout/nav'); ?>

	<div class="article">
		<h1>设置您的站点</h1>

		<p>自定义站点信息，建议您输入站点简介。当然之后也可以通过后台来更改。</p>
	</div>

	<form method="post" action="<?php echo rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'); ?>/index.php?action=stage3" autocomplete="off">
		<fieldset>

			<?php echo Messages::read(); ?>

			<p>
				<label>
					<strong>站点名称</strong>
					<span>在页面 <code>&lt;title&gt;</code> 里显示.</span>
				</label>

				<input name="site_name" value="<?php echo post('site_name', 'ZQCMS'); ?>">
			</p>

			<p>
				<label>
					<strong>站点简介</strong>
					<span>简短的介绍您的站点.</span>
				</label>

				<textarea name="site_description"><?php echo post('site_description', 'ZQCMS, 为游戏玩家提供网游新服表、网游开服表、网页游戏开服表、网页游戏大全、游戏激活码等服务。'); ?></textarea>
			</p>

			<p>
				<label>
					<strong>安装目录</strong>
					<span>在根目录安装时不必理会.</span>
				</label>

				<input name="site_indexurl" value="<?php echo post('site_indexurl', dirname(dirname($_SERVER['REQUEST_URI']))); ?>">
			</p>

			<p>
				<label>
					<strong>网站主题</strong>
					<span>选择网站主题.</span>
				</label>
			<select name="theme">
				<option value="default">Default</option>
			</select></p>
		</fieldset>

		<div class="options">
			<button type="submit">下一步 &raquo;</button>
			<div class="test"></div>
		</div>
	</form>
</div>

<?php render('layout/footer'); ?>