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
    <?php if($_GET["c"] == "urlrule"): ?>
      <h2>开启伪静态步骤</h2>
      <p>如有问题，可以到<a href="http://bbs.zqcms.com" target="_blank">ZQCMS交流论坛</a>发帖求助。</p>
      <ul>
        <li>配置或修改伪静态规则</li>
        <li><a href="?m=admin&c=urlrule&a=public_cache_urlrule">生成伪静态缓存</a></li>
        <li>在 <a href="?m=admin&c=setting">站点设置</a> 页面修改 ”URL伪静态“ 为 <strong>开启</strong></li>
      </ul>
    <?php endif ?>
	</div>
  <?php endif ?>
	<div id="bottom">
		<small>Powered by ZQCMS</small>
    <em>ZQCMS</em>
	</div>
	</body>
</html>
