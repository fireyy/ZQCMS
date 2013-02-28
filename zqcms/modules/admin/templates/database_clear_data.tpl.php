<?php
defined('IN_ADMIN') or exit('No permission resources.');
include "header.php"; ?>

<h1>数据库清理</h1>
<p class="notification error">
    数据库清理是一个危险操作，请谨慎操作！
</p>
<div class="content content-ext">
    <?php include "setting_nav.php"; ?>
<div class="table-list">
<form method="post" id="myform" name="myform" >
<fieldset>
    <legend>模型选择</legend>
    <em>请选择要清理的数据模型</em>
    <?php 
if(is_array($infos)){
    foreach($infos as $info){
        if(in_array($info['name'], $models)) {
?>
    <p>
        <label><input type="checkbox" name="model[]" value="<?php echo $info['name']; ?>" class="auto"> <?php echo $info['title']; ?></label>
        <input type="text" name="<?php echo $info['name']; ?>_date" class="date_time" value="">
        <em>请选择一个时间点</em>
    </p>
<?php
        }
    }
}
?>
</fieldset>
<p class="buttons">
    <input type="hidden" name="dosubmit" value="1">
    <button type="submit">提交</button>
</p>
</form>
</div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('.date_time').Zebra_DatePicker({
            format:'Y-m-d'
        });
    });
</script>
<?php include "footer.php"; ?>