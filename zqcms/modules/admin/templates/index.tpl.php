<?php include "header.php"; ?>
<h1>概况</h1>

<a id="updateNotify" href="?m=admin&c=update&autocheck=1" class="notification notice" style="display: none;"></a>

<div class="content">
	<ul class="list">
	  <li>
	    <strong>ZQCMS版本：</strong>
      <i class="status"><?php echo ZQCMS_VERSION; ?></i>
	  </li>
	  <li>
      <strong>服务器软件：</strong>
      <span><?php echo $sysinfo['web_server']; ?></span>
	  </li>
	  <li>
      <strong>服务器操作系统：</strong>
      <i class="status"><?php echo $sysinfo['os']; ?></i>
	  </li>
	  <li>
	    <strong>PHP版本：</strong>
      <i class="status"><?php echo $sysinfo['phpv']; ?></i>
	  </li>
	  <li>
	    <strong>MYSQL版本：</strong>
      <i class="status"><?php echo $sysinfo['mysqlv']; ?></i>
	  </li>
	</ul>
</div>
<script type="text/javascript">
$(function(){
  $.ajax({
      url: '?m=admin&c=update&a=checkUpdate',
      type: 'POST',
      data: {"chk":1},
      dataType: 'json',
      success: function(data){
        if(data && data.status == "success"){
          $("#updateNotify").html("发现新版本："+data.ver+" 可用，请点击更新").show();
        }
      }
  });
});
</script>
<?php include "footer.php"; ?>