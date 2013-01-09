<?php include "header.php"; ?>

<h1>站点设置</h1>

<?php if(!empty($errors)) echo '<p class="notification error">' . implode('<br>', $errors) . '</p>'; ?>
<?php if(!empty($succ)) echo '<p class="notification success">' . implode('<br>', $succ) . '</p>'; ?>

<div class="content">
  <form method="post" action="?m=admin&c=setting&dosubmit=1" novalidate="">
		
		<fieldset>
			<p>
				<label for="sitename">站点名称:</label>
				<input id="sitename" name="site_name" value="<?php echo $option["site_name"]; ?>">
				
				<em>您的站点名称</em>
			</p>

			<p>
				<label for="description">站点简介:</label>
				<textarea id="description" name="site_description"><?php echo $option["site_description"]; ?></textarea>
				
				<em>一段简短的站点介绍，可用于 <code>meta name="description"</code></em>
			</p>
      
			<p>
				<label for="keywords">站点关键字:</label>
				<input id="site_keywords" name="site_keywords" value="<?php echo $option["site_keywords"]; ?>">
				
				<em>站点关键字，多个用英文逗号分割。用于 <code>meta name="keywords"</code></em>
			</p>

			<p>
				<label for="site_basehost">站点链接:</label>
				<input id="site_basehost" name="site_basehost" value="<?php echo $option["site_basehost"]; ?>">
				
				<em>您站点的链接</em>
			</p>
      
			<p>
				<label for="site_indexurl">安装目录:</label>
				<input id="site_indexurl" name="site_indexurl" value="<?php echo $option["site_indexurl"]; ?>">
				
				<em>站点安装目录，如果在根目录，保持 <code>/</code> 既可</em>
			</p>
      
			<p>
				<label for="site_logo">站点logo:</label>
				<input id="site_logo" name="site_logo" value="<?php echo $option["site_logo"]; ?>">
				
				<em>您站点的logo图片地址</em>
			</p>
      
			<p>
				<label for="site_beian">备案信息:</label>
				<input id="site_beian" name="site_beian" value="<?php echo $option["site_beian"]; ?>">
				
				<em>您站点的备案信息</em>
			</p>
		</fieldset>
			
		<p class="buttons">
			<button type="submit">提交</button>
		</p>
	</form>
</div>

<?php include "footer.php"; ?>