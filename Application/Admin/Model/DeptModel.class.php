<?php
//部门管理模型
namespace Admin\Model;
use Think\Model;

class DeptModel extends Model{

	//自动验证规则
	protected $_validate  =   array(
			array('name','require','部门名称不得为空！',0,'regex'),
			array('name','','部门名称已存在','0','unique',1),
			array('sort','require','排序不得为空！','0','regex'),
			array('sort','number','排序需为数字组成','0','regex'),
			array('remark','require','备注不得为空','0','regex')
		);

	
}