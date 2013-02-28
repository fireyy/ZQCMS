<?php include "header.php"; ?>

<h1>添加广告<a class="button" href="?m=admin&c=poster">返回</a></h1>

<?php if(!empty($errors)) echo '<p class="notification error">' . implode('<br>', $errors) . '</p>'; ?>
<?php if(!empty($succ)) echo '<p class="notification success">' . implode('<br>', $succ) . '</p>'; ?>

<div class="content">
<form method="post" action="?m=admin&c=poster&a=add" id="myform">
<fieldset>
    <p>
        <label for="sign">标识：</label>
        <input type="text" name="poster[sign]" id="sign">
        <em>标识必须唯一</em>
    </p>
    <p>
        <label for="name">标题：</label>
        <input type="text" name="poster[name]" id="name">
    </p>
    <p>
        <label for="startdate">开始时间：</label>
        <input type="text" name="poster[startdate]" id="startdate">
        <em>格式：2012-07-05 12:00:00</em>
    </p>
    <p>
        <label for="enddate">结束时间：</label>
        <input type="text" name="poster[enddate]" id="enddate">
        <em>格式：2012-07-05 12:00:00</em>
    </p>
    <p>
        <label for="poster_content">广告代码：</label>
        <textarea name="poster[content]" id="poster_content" cols="50"
            rows="6"></textarea>
    </p>
</fieldset>
<p class="buttons">
    <button type="submit" name="dosubmit">提交</button>
</p>
</form>
</div>
<?php include "footer.php"; ?>