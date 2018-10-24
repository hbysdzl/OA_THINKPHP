<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>查查邮件</title>
	<style>
		a{
			display: block;
			width: 50px;
			height: 30px;
			border: 1px solid #ccc;
			text-align: center;
			line-height: 30px;
			text-decoration: none;
			color: #000;
		}
		.file,.content {
			border: 1px solid #ccc;
			padding: 10px;
			margin-top: 20px;
		}
	</style>
</head>
<body>
	<div><a href="<?php echo U('send?from_id='.$result['from_id']);?>">回复</a></div>
	<div>
		<h5>发件人：<?php echo ($result["truename"]); ?></h5>
		<h5>标题: <?php echo ($result["title"]); ?></h5>
		<h5>时间：<?php echo (date("Y-m-d H:i",$result["addtime"])); ?></h5>
		<h5>收件人：<?php echo (session('truename')); ?></h5>
		<div class="file">
			<h5>附件：<?php echo ($result["filename"]); ?></h5>
			<img src="<?php echo ($result["file"]); ?>" alt="">
		</div>
		<div class="content">
			<h5>内容</h5>
			<div>
				<?php echo ($result["content"]); ?>
			</div>
		</div>
	</div>
</body>
</html>