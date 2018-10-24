<?php

//职员管理控制器
namespace Admin\Controller;
//use Think\Controller;

class UserController extends CommonController{

	//职员列表
	public function index(){
		$userModel=M('User');

		$count=$userModel->count();
		$pageModel=new \Think\Page($count,2);

		//设置分页文字样式
		$pageModel->setConfig('prev','上一页');
		$pageModel->setConfig('next','下一页');
		$pageModel->setConfig('first','首页');
		$pageModel->setConfig('last','末页');
		$pageModel->rollPage=2;
		$pageModel->lastSuffix=false;
		$pageShow=$pageModel->show();
		//table方法连表查询
		$showList=$userModel->field('t1.*,t2.name as deptname')->table('oa_user as t1,oa_dept as t2')->where('t1.dept_id=t2.id')->limit($pageModel->firstRow,$pageModel->listRows)->select();
		$this->assign('pageShow',$pageShow);
		$this->assign('showList',$showList);
		$this->display();
	}

	//职员的添加
	public function add() {

		if(IS_POST){
			$userModel=M('User');
			if($userModel->create(I('post.'),1)){
				$userModel->addtime=time();
				$userModel->password=md5($userModel->password);
				if($userModel->add()){
					$this->success('添加成功',U('index'));
					exit;
				}
			}
			$this->error($userModel->getError());
		}else {
			//获取部门信息
			$deptModel=M('Dept');
			$data=$deptModel->field('id,name,pid')->select();
			//加载文件
			load('@/tree');
			$data=getTree($data);
			$this->assign('data',$data);
			$this->display();
		}
		
	}

	//职员更新
	public function edit(){
		$userModel=M('User');
		if(IS_POST){
			if($userModel->create(I('post.'),2)){
				if ($userModel->save()!==false) {
					//更新成功
					$this->success('编辑成功',U('index'));
					exit;
				}
			}

			$this->error($userModel->getError());
		}else{
			$id=I('get.id');
			
			$editData=$userModel->find($id);
			$this->assign('editData',$editData);

			//获取部门列表数据
			$deptModel=M('Dept');
			$deptList=$deptModel->field('id,pid,name')->select();

			//加载文件，无限极分类
			load('@/tree');
			$deptList=getTree($deptList);
			$this->assign('deptList',$deptList);
			$this->display();
		}
	}

	//职员删除
	public function del(){
		$ids=I('get.id');
		$userModel=M('User');
		if($userModel->delete($ids)){
			$this->ajaxReturn(array('status'=>1));
			exit;
		}

		$this->ajaxReturn(array('status'=>0));
	}


	//统计
	public function count() {

		//查出部门名称及部门人数
		$model=M();
		$count_num=$model->field('t2.name as deptname,count(*) as deptnum')->table('oa_user as t1,oa_dept as t2')->where('t1.dept_id=t2.id')->group('deptname')->select();
		$str='';
		foreach ($count_num as $k => $v) {
			$str.="['".$v['deptname']."',".$v['deptnum']."],";
		}
		$this->assign('str',$str);
		$this->display();
	}
}	