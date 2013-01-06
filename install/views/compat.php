<?php render('layout/header'); ?>

<div class="content small">
	<h1>发现了一些问题</h1>

	<p>很抱歉的通知您，在安装之前我们发现了一些问题需要处理，只有解决这些问题，才能继续安装 ZQCMS:</p>

	<ul>
		<?php foreach($compat as $item): ?>
		<li><?php echo $item; ?></li>
		<?php endforeach; ?>
	</ul>

	<p><a class="button" href="<?php echo rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'); ?>/index.php">继续</a></p>
</div>

<?php render('layout/footer'); ?>