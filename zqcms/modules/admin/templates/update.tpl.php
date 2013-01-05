<?php include "header.php"; ?>

<h1>在线更新 <button id="checkupdate" type="button">检测更新</button></h1>

<p id="updateMsg" class="notification"></p>

<div class="content">
  <div id="download_progress"></div>
</div>
<script type="text/javascript"	src="<?php echo ZQ_PATH_ADMIN.'assets/js/jquery.js'; ?>"></script>
<script type="text/javascript">
(function(window, $){
  var progress_div = $('#download_progress'), files, files_length = 0, _count = 0, _successCount=0, _failureCount=0,list_table, errors={"error1":"当前没用可用的更新", "error2":"没发现可用的文件列表信息，可能是官方服务器存在问题，请稍后再尝试！"};
  $(document).ready(function(){
      //checkUpdate();
      $("#checkupdate").click(checkUpdate);
      $(".retry").live("click", function(){
        //$(this).hide();
        f = $(this).attr("data-files");
        download_file(f);
      });
  });
  
  function checkUpdate(){
    $("#checkupdate").attr("disabled",1).text("检测中...");
    $("#updateMsg").addClass("notice").html("正在为您检测是否有新版本...");
    $("#download_progress").html("");
    window.onbeforeunload = function(e) {
      return "系统正在更新中，请不要刷新或者关闭此页面";
    };
    $.ajax({
        url: '?m=admin&c=update&a=checkUpdate',
        type: 'GET',
        error: function(){
          window.onbeforeunload = null;
          $("#checkupdate").removeAttr("disabled").text("检测更新");
          $("#updateMsg").removeClass("notice").addClass("success").html(errors["error2"]);
        },
        success: function(data){
          if(data == "error1" || data == "error2"){
            window.onbeforeunload = null;
            $("#checkupdate").removeAttr("disabled").text("检测更新");
            $("#updateMsg").addClass("notice").html(errors[data]);
          }else{
            $("#checkupdate").text("更新中...");
            arr = eval(data);
            $("#updateMsg").html("发现新版本: "+arr[0]+"，正在更新中...");
            files = arr[1];
            files_length = files.length;
            _count = 0;
            _successCount=0;
            _failureCount=0;
            if (files_length > 0) {
              progress_div.append("<h3>开始下载需要更新的文件</h3>");
              list_table = $("<table class='table' cellspacing='0'/>").appendTo(progress_div);
              $('<thead><tr><th width="80%">文件名</th><th width="20%">状态</th></tr></thead>').appendTo(list_table);
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
      var tr = $('<tr/>').appendTo(list_table);
      $('<td/>').html(f).appendTo(tr);
      var td = $('<td/>').attr('id', 'tid_'+_successCount).html('正在下载').appendTo(tr);
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
        	    $("#"+tid).html('下载失败 <span class="retry" data-files="'+f+'">重试</span>').addClass('undone');
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
    progress_div.append("<h3>开始下载需要更新的SQL</h3>");
    $.ajax({
        url: '?m=admin&c=update&a=downSQL',
        type: 'POST',
        dataType: 'json',
        success: function(data){
        	if (data.status == "success") {
            if(data.count){
              progress_div.append("<p class='done'>下载完成</p>");
            }else{
              progress_div.append("<p class='done'>无需下载</p>");
            }
            _apply_update();
        	}
        }
    })
  }

  function _apply_update() {
    progress_div.append("<h3>正在应用升级</h3>");
    $.ajax({
      url: '?m=admin&c=update&a=applyUpgrade',
      type: 'POST',
      dataType: 'json',
      success: function(data){
        window.onbeforeunload = null;
        $("#checkupdate").removeAttr("disabled").text("检测更新");
        if(data.status == "success"){
          progress_div.append("<p class='done'>版本："+data["ver"]+" 更新成功</p>");
          $("#updateMsg").removeClass("notice").addClass("success").html("成功更新到版本");
      	  //window.location="?m=admin&c=index";
        }else{
          progress_div.append("<p class='undone'>版本："+data["ver"]+" 更新失败</p>");
        }
      }
    })
  }

		
})(window,jQuery);

</script>
<?php include "footer.php"; ?>