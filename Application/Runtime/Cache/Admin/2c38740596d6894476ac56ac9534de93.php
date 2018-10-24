<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="/Public/Admin/css/base.css" />
<link rel="stylesheet" href="/Public/Admin/css/info-mgt.css" />
<link rel="stylesheet" href="/Public/Admin/css/WdatePicker.css" />
<title>移动办公自动化系统</title>
<style type='text/css'>
	table tr .id{ width:63px; text-align: center;}
	table tr .name{ width:118px; padding-left:17px;}
	table tr .nickname{ width:63px; padding-left:17px;}
	table tr .dept_id{ width:63px; padding-left:13px;}
	table tr .sex{ width:63px; padding-left:13px;}
	table tr .birthday{ width:80px; padding-left:13px;}
	table tr .tel{ width:113px; padding-left:13px;}
	table tr .email{ width:160px; padding-left:13px;}
	table tr .addtime{ width:160px; padding-left:13px;}
	table tr .operate{ padding-left:13px;}
</style>
</head>

<body>
<div class="title"><h2>公文管理</h2></div>
<div class="table-operate ue-clear">
	<a href="/index.php/Admin/Doc/add" class="add">添加</a>
    <a href="javascript:;" class="del">删除</a>
    <a href="javascript:;" class="edit">编辑</a>
    <a href="javascript:;" class="count">统计</a>
    <a href="javascript:;" class="check">审核</a>
</div>
<div class="table-box">
	<table>
    	<thead>
        	<tr>
        		<th class="id"><input type="checkbox" id="check" /></th>
            	<th class="id">序号</th>
                <th class="name">标题</th>
				<th class="file">附件</th>
                <th class="content">作者</th>
				<th class="addtime">添加时间</th>
                <th class="operate">操作</th>
            </tr>
        </thead>
        <tbody>
        	<?php if(is_array($docList)): $i = 0; $__LIST__ = $docList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><tr>
        		<td class="id"><input type="checkbox" class="check" value="<?php echo ($vol["id"]); ?>" /></td>
            	<td class="id"><?php echo ($i); ?></td>
                <td class="name"><?php echo ($vol["title"]); ?></td>
				<td class="file"><?php echo ($vol["filename"]); if($vol["hasfile"] == 1): ?>&nbsp&nbsp&nbsp
					<a href="<?php echo U('download?id='.$vol['id']);?>">下载附件</a><?php endif; ?>
				</td>
                <td class="content"><?php echo ($vol["author"]); ?></td>
                <td class="addtime"><?php echo (date("Y-m-d H:i" ,$vol["addtime"])); ?></td>
                <td class="operate">
                	<a href ='javascript:;' class="show" id="<?php echo ($vol["id"]); ?>" data-title="<?php echo ($vol["title"]); ?>">查看</a>&nbsp|&nbsp
                	<a href ='<?php echo U('edit?id='.$vol[id]);?>'>编辑</a>  
                </td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
</div>
<div class="pagination ue-clear">
	<div class="pagin-list">
		<?php echo ($page); ?>
	</div>
	<div class="pxofy">共 <?php echo ($count); ?> 条记录</div>
</div>
</body>
<script type="text/javascript" src="/Public/Admin/js/jquery.js"></script>
<script type="text/javascript" src="/Public/Admin/js/common.js"></script>
<script type="text/javascript" src="/Public/Admin/js/WdatePicker.js"></script>
<script type="text/javascript" src="/Public/common/layer/layer.js"></script>
<script type="text/javascript" src="/Public/Admin/js/del/del.js"></script>
<script type="text/javascript">
$(".select-title").on("click",function(){
	$(".select-list").hide();
	$(this).siblings($(".select-list")).show();
	return false;
})
$(".select-list").on("click","li",function(){
	var txt = $(this).text();
	$(this).parent($(".select-list")).siblings($(".select-title")).find("span").text(txt);
})

$("tbody").find("tr:odd").css("backgroundColor","#eff6fa");

showRemind('input[type=text], textarea','placeholder');

//查看公文
$('.show').on('click',function(){
	var id=$(this).attr('id');
	var title=$(this).attr('data-title');
	//iframe层
	layer.open({
	type: 2,
	title: title,
	shadeClose: true,
	shade: 0.3,
	area: ['750px', '80%'],
	content: '<?php echo U('showContent','',false);?>/id/'+id //iframe的url
	});
});

//删除操作
oa_del('Doc');
</script>
</html>