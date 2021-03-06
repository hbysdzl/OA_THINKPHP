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
<div class="title"><h2>收件箱</h2></div>
<div class="table-operate ue-clear">
    <a href="javascript:;" class="del">删除</a>
    <a href="javascript:;" class="edit">编辑</a>
    <a href="javascript:;" class="check">审核</a>
</div>
<div class="table-box">
	<table>
    	<thead>
        	<tr>
            	<th class="id">序号</th>
                <th class="name">发件人</th>
				<th class="name">标题</th>
                <th class="file">附件</th>
				<th class="addtime">发送时间</th>
                <th class="status">状态</th>
                <th class="operate">操作</th>
            </tr>
        </thead>
        <tbody>
            <?php if(is_array($recData)): $i = 0; $__LIST__ = $recData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><tr>
            	<td class="id"><?php echo ($i); ?></td>
                <td class="name"><?php echo ($vol["truename"]); ?></td>
                <td class="name"><?php echo ($vol["title"]); ?></td>
				<td class="file"><?php echo ($vol["filename"]); ?><noempty name="vol.filename">&nbsp&nbsp&nbsp<a href="/index.php/Admin/Email/download/id/<?php echo ($vol["id"]); ?>">【下载附件】</a></noempty></td>
                <td class="addtime"><?php echo (date("Y-m-d H:i",$vol["addtime"])); ?></td>
                <td class="status"><?php if($vol["is_read"] == 0): ?><span style="color: red">未读</span><?php else: ?><span style="color: #ccc">已读</span><?php endif; ?></td>
                <td class="operate">
                	<a href ='javascript:;' class="view" id="<?php echo ($vol["id"]); ?>" data_title="<?php echo ($vol["title"]); ?>" is_res="<?php echo ($vol["is_read"]); ?>" >查看</a>&nbsp|&nbsp
                    <a href ='javascript:;' class="del" id="<?php echo ($vol["id"]); ?>">删除</a>  
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

//邮件查看
$('.view').on('click',function(){
    var id = $(this).attr('id');
    var is_res = $(this).attr('is_res');
    layer.open({
      type: 2,
      area: ['70%', '80%'],
      fixed: false, //不固定
      maxmin: true,
      content: '/index.php/Admin/Email/view/id/'+id,
      end:function(){
            if (is_res == 0) {
                 window.location.href = location.href;
            }
      }
    });
});

//邮件删除
$('.del').on('click',function(){
    var id = $(this).attr('id');
    var _this=$(this);
    $.get('/index.php/Admin/Email/recDel/id/'+id,function(msg){
        if(msg.status==1){
            layer.alert('删除成功', {
                icon: 1,
                skin: 'layer-ext-moon',
                end:function(){
                    _this.parent().parent().remove();
                } 
            })
        }else{
            layer.alert('操作失败', {
                icon: 2,
                skin: 'layer-ext-moon' 
            })
        }
    },'json');
});
</script>
</html>