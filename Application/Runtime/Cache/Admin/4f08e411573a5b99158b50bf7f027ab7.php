<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="/Public/Admin/css/base.css" />
<link rel="stylesheet" href="/Public/Admin/css/info-mgt.css" />
<link rel="stylesheet" href="/Public/Admin/css/WdatePicker.css" />
<title>移动办公自动化系统</title>
</head>

<body>
<div class="title"><h2>信息管理</h2></div>
<div class="table-operate ue-clear">
	<a href="<?php echo U('add');?>" class="add">添加</a>
    <a href="javascript:;" class="del">删除</a>
    <a href="javascript:;" class="edit">编辑</a>
    <a href="javascript:;" class="count">统计</a>
    <a href="javascript:;" class="check">审核</a>
</div>
<div class="table-box">
	<table>
    	<thead>
        	<tr>
                <th class="num"><input type="checkbox" id="check" /></th>
            	<th class="num">序号</th>
                <th class="name">部门</th>
                <th class="process">所属部门</th>
                <th class="node">排序</th>
                <th class="time">备注</th>
                <th class="operate">操作</th>
            </tr>
        </thead>
        <tbody>
            <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><tr>
                    <td class="num"><input type="checkbox" class="check" value="<?php echo ($vol["id"]); ?>" /></td>
                	<td class="num"><?php echo ($i); ?></td>
                    <td class="name"><?php echo (str_repeat('-',$vol["level"]*2)); echo ($vol["name"]); ?></td>
                    <td class="process" ><?php if($vol["pid"] == 0): ?>顶级部门<?php else: echo ($vol["parentname"]); endif; ?></td>
                    <td class="node"><?php echo ($vol["sort"]); ?></td>
                    <td class="time"><?php echo ($vol["remark"]); ?></td>
                    <td class="operate"><a href="<?php echo U('edit?id='.$vol['id']);?>">编辑</a></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
</div>
<div class="pagination ue-clear"></div>
</body>
<script type="text/javascript" src="/Public/Admin/js/jquery.js"></script>
<script type="text/javascript" src="/Public/Admin/js/common.js"></script>
<script type="text/javascript" src="/Public/Admin/js/WdatePicker.js"></script>
<script type="text/javascript" src="/Public/Admin/js/jquery.pagination.js"></script>
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

$('.pagination').pagination(100,{
	callback: function(page){
		alert(page);	
	},
	display_msg: true,
	setPageNo: true
});

$("tbody").find("tr:odd").css("backgroundColor","#eff6fa");

showRemind('input[type=text], textarea','placeholder');

//复选框批量选中功能
 $('#check').on('click',function(){
    if($(this).attr('checked')){
        $('.check').attr('checked','checked');
    }else{
        $('.check').removeAttr('checked');
    }
 });

//删除
$('.del').on('click',function(){
    //获取全部被选中的checkbox框
    var idObj=$('td > :checkbox:checked'); //表单及表单属性并且选择器
    if(idObj.length == 0){
        alert('请选择要删除的数据！');
        return false;
    }

    if(confirm('确定执行该操作吗？')){
            var id='';
            for(var i=0;i<idObj.length;i++){
                id+=idObj[i].value+',';
            }
            id=id.substring(0,id.length-1);
            $.ajax({
                type:"get",
                url: "<?php echo U('del','',false);?>/ids/"+id,
                dataType:"json",
                success:function(msg){
                    if(msg.status==1){
                        alert('删除成功');
                        idObj.parent().parent().remove();
                    }else{
                        alert('系统繁忙，请稍后重试！');
                    }
                }

            });
        }    
});

</script>
</html>