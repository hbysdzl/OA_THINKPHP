<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="/Public/Admin/css/base.css" />
<link rel="stylesheet" href="/Public/Admin/css/info-reg.css" />
<title>移动办公自动化系统</title>
<style type='text/css'>
	select {
		background: rgba(0, 0, 0, 0) url("/Public/Admin/images/inputbg.png") repeat-x scroll 0 0;
	    border: 1px solid #c5d6e0;
	    height: 28px;
	    outline: medium none;
	    padding: 0 8px;
	    width: 240px;
	}
	.main p input {
		float:none;
	}
</style>
</head>

<body>
<div class="title"><h2>公文起草</h2></div>
<form action="" method="post" enctype="multipart/form-data">
<div class="main">
	<p class="short-input ue-clear">
	<input type="hidden" name="id" value="<?php echo ($editData["id"]); ?>" />
    	<label>标题：</label>
        <input name="title" value="<?php echo ($editData["title"]); ?>" type="text" placeholder="标题..." />
    </p>
	<p class="short-input ue-clear">
    	<label>附件：</label>
        <input name="file" type="file" id="file" onchange="c()" /> 说明：如果需要修改则选择文件，留空则表示不修改
    </p>
    <p class="short-input ue-clear">
    	<img src="<?php echo ($editData["filepath"]); ?>" alt="" style="width: 100px; margin-left: 84px;" id="show">
    </p>
    <p class="short-input ue-clear">
    	<label>作者：</label>
        <input name="author" type="text" value="<?php echo ($editData["author"]); ?>" placeholder="作者..." />
    </p>
    <p class="short-input ue-clear">
    	<label>内容：<script id="editor" name='content' type="text/plain" style="width:800px;height:300px;">
    		<?php echo (htmlspecialchars_decode($editData["content"])); ?>
    	</script></label>
    </p>
</div>
<div class="btn ue-clear">
	<a href="javascript:;" class="confirm" id='btnSubmit'>确定</a>
    <a href="javascript:;" class="clear" id='btnReset'>清空内容</a>
</div>
</form>
</body>
<script type="text/javascript" src="/Public/Admin/js/jquery.js"></script>
<script type="text/javascript" src="/Public/Admin/js/common.js"></script>
<script type="text/javascript" src="/Public/Admin/js/WdatePicker.js"></script>
<!-- 编辑器 start -->
 <script type="text/javascript" charset="utf-8" src="/Public/Admin/ueditor/ueditor.config.js"></script>
 <script type="text/javascript" charset="utf-8" src="/Public/Admin/ueditor/ueditor.all.min.js"> </script>
 <script type="text/javascript" charset="utf-8" src="/Public/Admin/ueditor/lang/zh-cn/zh-cn.js"></script>
<!-- 编辑器 end -->
<script type="text/javascript">
//实例化容器，要求id是容器的id
var ue = UE.getEditor('editor');

$(function(){
	$('#btnSubmit').on('click',function(){
		$('form').submit();
	});
	
	$('#btnReset').on('click',function(){
		$('form')[0].reset();
	});
});	

$(".select-title").on("click",function(){
	$(".select-list").toggle();
	return false;
});
$(".select-list").on("click","li",function(){
	var txt = $(this).text();
	$(".select-title").find("span").text(txt);
});
showRemind('input[type=text], textarea','placeholder');

//上传图片预览
function c () {
	  var r= new FileReader();
	  f=document.getElementById('file').files[0];
	   
	  r.readAsDataURL(f);
	  r.onload=function (e) {
	    document.getElementById('show').src=this.result;
	  };
	}
</script>
</html>