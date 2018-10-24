<?php

//部门管理控制器

namespace Admin\Controller;
//use Think\Controller;

class DeptController extends CommonController {

	//部门列表管理
	public function showList(){
		$deptModel=M('Dept');

		//自联查询上级部门名称
		$data=$deptModel->alias('t1')->field('t1.*,t2.name as parentname')->join('left join oa_dept as t2 on t1.pid=t2.id')->order('sort asc')->select();
		
		// //获取上级部门
		// foreach ($data as $k => $v) {
		// 	if ($v['pid'] > 0) {
		// 		$parentName=$deptModel->field('name')->find($v['pid']);
		// 		$data[$k]['parentName'] = $parentName['name'];
		// 	}	
		// }
		//载入文件实现无限极分类
		load('@/tree');
		$data=getTree($data);
		$this->assign('data',$data);
		$this->display();
	}

	//部门添加
	public function add(){
		$deptModel=D('Dept');
		
		if(IS_POST){
			if($deptModel->create()){
				if($deptModel->add()){
					$this->success('添加成功',U('showList'));
					exit;
				}
			}
			$this->error($deptModel->getError());
		}else{
			//获取上级部门数据
			$parentData=$deptModel->where('pid=0')->select();
			$this->assign('parentData',$parentData);
			$this->display();
		}
			
	}

	//部门编辑
	public function edit(){
		$deptModel=D('Dept');
		if(IS_POST){
			if($deptModel->create(I('post.'),2)){
			   if($deptModel->save()!== false){
			   		//更新成功
			   		$this->success('更新成功！',U('showList'));
			   		exit;
			   }	
			}
			$this->error($deptModel->getError());
		}else{
			$id=I('get.id');
			if(!$id){
				$this->error('参数错误，请重试！');
				exit;
			}

			//获取全部部门信息 *需去掉自身
			$result=$deptModel->field('id,name')->where("id != $id")->select();
			$this->assign('result',$result);

			//获取编辑数据
			$editData=$deptModel->find($id);
			$this->assign('editData',$editData);
			$this->display();
		}
	}

	//部门删除操作
	public function del(){
		$ids=I('get.ids');
		$deptModel=D('Dept');
		if($deptModel->delete($ids)){
			//删除成功
			$this->ajaxReturn(array('status'=>1));
			exit;
		}
		$this->ajaxReturn(array('status'=>0));
	}
}