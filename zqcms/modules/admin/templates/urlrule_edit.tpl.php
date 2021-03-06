<?php include "header.php"; ?>

<h1>修改伪静态规则<a class="button" href="?m=admin&c=urlrule">返回</a></h1>

<?php if(!empty($errors)) echo '<p class="notification error">' . implode('<br>', $errors) . '</p>'; ?>
<?php if(!empty($succ)) echo '<p class="notification success">' . implode('<br>', $succ) . '</p>'; ?>

<div class="content">
	<?php include "setting_nav.php"; ?>
<form action="?m=admin&c=urlrule&a=edit&urlruleid=<?php echo $id; ?>" method="post" name="myform" id="myform">
<fieldset>
	<legend><?php echo getLangData($name)?></legend>
	<em>配置规则</em>
	<p>
		<label for="urlrule_value">规则：</label>
		<textarea name="info[value]" id="urlrule_value"><?php echo $value;?></textarea>
		<?php if(!empty($description)) { ?>
		<em>必须包含参数：
		<?php
		$description = explode("|", $description);
		foreach ($description as $key => $value) {
			echo "<i class='prefix' data-target='urlrule_value'>$value</i>, ";
		}
		?>
		</em>
		<?php } ?>
	</p>
</fieldset>
<p class="buttons">
	<input type="hidden" name="forward" value="?m=admin&c=link&a=edit">
	<button type="submit" name="dosubmit">提交</button>
</p>
</form>
</div>

<?php include "footer.php"; ?>