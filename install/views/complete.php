<?php render('layout/header'); ?>

<div class="content small">

	<h1>感谢您的安装！</h1>

	<?php echo Messages::read(); ?>
	
	<p>恭喜您!已成功安装 ZQCMS. 您现在可以:</p>

	<p class="options">
	
		<a href="../admin" class="button">登录网站后台 &raquo;</a> 
	
		<a href="../" class="right">访问网站首页 &raquo;</a>
	</p>
  
	<p>或者访问 ZQCMS 官方网站:</p>

	<p class="options">
	
		<a href="http://zqcms.com" class="button" target="_blank">官方网站</a> 
	  <a href="http://bbs.zqcms.com" class="button" target="_blank">交流论坛</a> 
	</p>
  
</div>

<?php render('layout/footer'); ?>