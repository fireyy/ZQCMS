<?php include "header.php"; ?>

<h1>后台登录</h1>

<?php if(!empty($errors)) echo '<p class="notification error">' . implode('<br>', $errors) . '</p>'; ?>

<div class="content">

	<form method="post" action="index.php?m=admin&c=index&a=login&dosubmit=1">		
		<fieldset>
			
			<p>
			    <label for="user">用户:</label>
			    <input autocapitalize="off" name="username" id="user" value="<?php if(!empty($username)) echo $username; ?>">
			</p>
			
			<p>
    			<label for="pass">密码:</label>
    			<input type="password" name="password" id="pass">
    			
    			<em><a href="#">忘记密码？</a></em>
			</p>

			<p class="buttons">
			    <button type="submit">登录</button>
			    <a href="/">返回站点</a>
			</p>
		</fieldset>
	</form>

</div>

<?php include "footer.php"; ?>