<?php include "header.php"; ?>

<h1>在线更新 <button id="checkupdate" type="button">检测更新</button></h1>

<div class="content">
  <ul class="list">
	  <li>
	    <strong>当前版本：</strong>
      <i id="current_ver" class="status"><?php echo ZQCMS_VERSION; ?></i>
	  </li>
  </ul>
  <ul id="download_progress" class="list"></ul>
</div>
<script type="text/javascript">
(function(window, $){
  var progress_div = $('#download_progress'), files, files_length = 0, _count = 0, _successCount=0, _failureCount=0,list_table, errors={"error1":"您的已经是最新版本", "error2":"检测失败，请重试"}, autocheck='<?php echo $autocheck; ?>';
  $(document).ready(function(){
      $("#checkupdate").click(checkUpdate);
      $(".retry").live("click", function(){
        $(this).hide();
        f = $(this).attr("data-files");
        download_file(f);
      });
      if(autocheck == '1') $("#checkupdate").click();
  });
  
  function checkUpdate(){
    $("#checkupdate").attr("disabled",1).text("检测中...");
    $("#download_progress").html("").append("<li><strong>正在为您检测是否有新版本...</strong><i class='status'></i></li>");
    window.onbeforeunload = function(e) {
      return "系统正在更新中，请不要刷新或者关闭此页面";
    };
    $.ajax({
        url: '?m=admin&c=update&a=checkUpdate',
        type: 'GET',
        error: function(){
          window.onbeforeunload = null;
          $("#checkupdate").removeAttr("disabled").text("检测更新");
          $("#download_progress").append("<li><strong>"+errors["error2"]+"</strong><i class='status'></i></li>");
        },
        success: function(data){
          if(data == "error1" || data == "error2"){
            window.onbeforeunload = null;
            $("#checkupdate").removeAttr("disabled").text("检测更新");
            $("#download_progress").append("<li><strong>"+errors[data]+"</strong><i class='status'></i></li>");
          }else{
            $("#checkupdate").text("更新中...");
            arr = eval(data);
            $("#download_progress").append("<li><strong>发现新版本: "+arr[0]+"</strong><i class='status'>更新中...</i></li>");
            files = arr[1];
            files_length = files.length;
            _count = 0;
            _successCount=0;
            _failureCount=0;
            if (files_length > 0) {
              $("#download_progress").append("<li><strong>开始下载需要更新的文件</strong><i class='status'></i></li>");
              download_file(files.shift());
            }
          }
        }
    });
  }

  function download_file(f) {
    if (!f) { 
        return; 
    }
    if($("#tid_"+_successCount).length > 0){
      $("#tid_"+_successCount).removeClass('undone').html('正在下载');
    }else{
      $("#download_progress").append("<li><strong>"+f+"</strong><i id='tid_"+_successCount+"' class='status'>正在下载</i></li>");
    }
    $.ajax({
        url: '?m=admin&c=update&a=downFile',
        type: 'POST',
        data: {filename: f, _id : 'tid_' + _successCount},
        dataType: 'json',
        success: function(data){
        	var tid = data['tid'];
          _failureCount = 0;
        	if (data && data['status'] == 'success') {
        	    $("#"+tid).html('下载成功').addClass('done');
        	    _successCount++;
              //_count++;
          }else if (data && data['status'] == 'failure'){
        	    $("#"+tid).html('下载失败 <input type="button" class="retry" data-files="'+f+'" value="重试" />').addClass('undone');
        	    _failureCount++;
              
        	    //window.onbeforeunload = null;
        	    //progress_div.append('<p class="undone">下载出错，请尝试重新更新。</p>');
              //$("#checkupdate").removeAttr("disabled").text("检测更新");
        	}else {

        	}
        	var filename = files.shift();
        	if (!!filename && _failureCount == 0){
        	    download_file(filename);
        	}else{
        	    if (_failureCount == 0 && _successCount == files_length) {
        	        download_sqls();
        	    }else {
        	    }
        	}
        }
    });
  }
		    
  function download_sqls(){
    $("#download_progress").append("<li><strong>检测需要更新的数据</strong><i id='sqlver' class='status done'></i></li>");
    progress_div.append("<h3></h3>");
    $.ajax({
        url: '?m=admin&c=update&a=downSQL',
        type: 'POST',
        dataType: 'json',
        success: function(data){
        	if (data.status == "success") {
            if(data.count){
              $("#sqlver").html("下载完成");
            }else{
              $("#sqlver").html("无需下载");
            }
            _apply_update();
        	}
        }
    })
  }

  function _apply_update() {
    $("#download_progress").append("<li><strong>正在应用升级</strong><i class='status'></i></li>");
    $.ajax({
      url: '?m=admin&c=update&a=applyUpgrade',
      type: 'POST',
      dataType: 'json',
      success: function(data){
        window.onbeforeunload = null;
        $("#checkupdate").removeAttr("disabled").text("检测更新");
        if(data.status == "success"){
          $("#download_progress").append("<li><strong>版本："+data["vmsg"]+"</strong><i class='status done'>更新成功</i></li>");
          $("#current_ver").html(data["ver"]);
      	  //window.location="?m=admin&c=index";
        }else{
          $("#download_progress").append("<li><strong>版本："+data["vmsg"]+"</strong><i class='status undone'>更新失败</i></li>");
        }
      }
    })
  }

		
})(window,jQuery);

</script>
<?php include "footer.php"; ?>