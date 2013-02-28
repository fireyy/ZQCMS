  <?php if($_GET["c"] != "database"): ?>
	<div id="sidebar">
		<?php if($_GET["c"] == "index" && $_GET["a"] != "login"): ?>
      <h2>快捷操作</h2>
      <p></p>
      <ul>
        <li><a href="?m=admin&c=database&a=export">数据库备份</a></li>
        <li><a href="?m=admin&c=database&a=import">数据库恢复</a></li>
      </ul>
    <?php endif ?>
		<?php if($_GET["c"] == "setting"): ?>
      <h2>说明</h2>
      <p>填写完整的信息有助于推广您的网站，利于搜索引擎索引站点页面。</p>
    <?php endif ?>
		<?php if($_GET["c"] == "update"): ?>
      <h2>说明</h2>
      <p>点击检测更新来获取新版本，如更新过程中发生问题，可以到<a href="http://bbs.zqcms.com" target="_blank">ZQCMS交流论坛</a>发帖求助。</p>
    <?php endif ?>
		<?php if($_GET["c"] == "profile"): ?>
      <h2>说明</h2>
      <p>请尽量选择强密码，并保存好您的密码。有关强密码，请看 <a href="http://zh.wikipedia.org/wiki/%E5%AF%86%E7%A0%81%E5%BC%BA%E5%BA%A6">密码强度</a></p>
    <?php endif ?>
	</div>
  <?php endif ?>
	<div id="bottom">
		<small>Powered by ZQCMS</small>
    <em>ZQCMS</em>
	</div>
	</body>
</html>
