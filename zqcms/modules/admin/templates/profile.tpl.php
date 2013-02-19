<?php include "header.php"; ?>

<h1>用户</h1>

<?php if(!empty($errors)) echo '<p class="notification error">' . implode('<br>', $errors) . '</p>'; ?>
<?php if(!empty($succ)) echo '<p class="notification success">' . implode('<br>', $succ) . '</p>'; ?>

<div class="content">
    <?php include "setting_nav.php"; ?>
	<form method="post" action="?m=admin&c=profile">
    <fieldset>
      <legend><?php echo $admin_username; ?></legend>
      
      <em>修改管理员信息</em>
			<p>
				<label for="password">密码:</label>
				<input id="password" type="password" name="password">
				
				<em>留空则不修改</em>
			</p>
			
			<p>
				<label for="email">电子邮箱:</label>
				<input id="email" name="email" value="<?php echo $email; ?>">

				<em>管理员的电子邮箱地址，取回密码时使用。</em>
			</p>
    </fieldset>
    <p class="buttons">
      <input type="hidden" name="dosubmit" value="1">
			<button type="submit">提交</button>
		</p>
	</form>
</div>

<?php include "footer.php"; ?>