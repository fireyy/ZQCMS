<?php include "header.php"; ?>

<h1>添加友情链接<a class="button" href="?m=admin&c=link">返回</a></h1>

<?php if(!empty($errors)) echo '<p class="notification error">' . implode('<br>', $errors) . '</p>'; ?>
<?php if(!empty($succ)) echo '<p class="notification success">' . implode('<br>', $succ) . '</p>'; ?>

<div class="content">
<form action="?m=admin&c=link&a=add" method="post" name="myform" id="myform">
<fieldset>
	<p>
		<label>链接类型：</label>
		<input name="link[linktype]" type="radio" value="1" onclick="$('#logolink').show()" class="auto">
	LOGO链接&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="radio" name="link[linktype]" value="0" checked="checked" onclick="$('#logolink').hide()" class="auto">
	文字链接
	</p>
	<p>
		<label for="link_name">网站名称：</label>
		<input type="text" name="link[name]" id="link_name">
	</p>
	<p>
		<label for="link_url">链 接：</label>
		<input type="text" name="link[url]" id="link_url">
	</p>
	<p id="logolink" style="display: none;">
		<label for="link_logo">LOGO图片：</label>
		<input type="text" name="link[logo]" id="link_logo">
	</p>
	<p>
		<label for="link_introduce">网站介绍：</label>
		<textarea name="link[introduce]" id="introduce" cols="50"
			rows="6"></textarea>
	</p>
	<p>
		<label>推 荐：</label>
		<input name="link[elite]" type="radio" value="1" class="auto">&nbsp;是&nbsp;&nbsp;<input
			name="link[elite]" type="radio" value="0" class="auto" checked>&nbsp;否
	</p>
	<p>
		<label>启 用：</label>
		<input name="link[passed]" type="radio" value="1" class="auto" checked>&nbsp;是&nbsp;&nbsp;<input
			name="link[passed]" type="radio" value="0" class="auto">&nbsp;否
	</p>
</fieldset>
<p class="buttons">
	<input type="hidden" name="forward" value="?m=admin&c=link&a=add">
	<button type="submit" name="dosubmit">提交</button>
</p>
</form>
</div>

<?php include "footer.php"; ?>