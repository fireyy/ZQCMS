<div class="nav">
	<div class="logo">
		<img src="<?php echo rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'); ?>/assets/img/logo.png">
	</div>

	<ul>
    <?php $action = empty($_GET["action"]) ? "" : $_GET["action"]; ?>
    <li<?php if($action=="stage2") {?> class="selected"<?php } ?>><i class="icon-spanner"></i>数据库信息</li>
		<li<?php if($action=="stage3") {?> class="selected"<?php } ?>><i class="icon-pencil"></i>站点信息</li>
		<li<?php if($action=="stage4") {?> class="selected"<?php } ?>><i class="icon-user"></i>管理员账号</li>
	</ul>

	<p>您正在安装 ZQCMS <?php echo ZQCMS_VERSION; ?></p>
</div>