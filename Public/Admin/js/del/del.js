function  oa_del(url_del) {
	//复选框批量选中
	$('#check').on('click',function(){
		if($(this).attr('checked')){
			$('.check').attr('checked','checked');
		}else{
			$('.check').removeAttr('checked');
		}
	});

	//获取所有选中的复选框执行删除
	$('.del').on('click',function(){
		var obj=$('td > :checkbox:checked');
		if(obj.length == 0){
			alert('请选择需要删除的数据');
			return false;
		}
		if(confirm('确定要执行该操作吗？')){
			var ids='';
			for(var i=0;i<obj.length;i++){
				ids+=obj[i].value+',';
			}
			var ids=ids.substr(0,ids.length-1);

			//ajax删除
			$.ajax({
				type: "get",
				url: "/index.php/Admin/"+url_del+"/del/id/"+ids,
				dataType: "json",
				success:function(msg){
					if(msg.status==1){
						layer.alert('删除成功！', {
  							icon: 1,
						})

						obj.parent().parent().remove();
					}else{
						layer.alert(msg.error, {
  							icon: 2,
						})
					}
				}
			});
		}
	});
}