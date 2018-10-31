<?php
//知识管理控制器

namespace Admin\Controller;
//use Think\Controller;

class KnowledgeController extends CommonController {

	//知识列表
	public function showList() {
		
		//初始化redis缓存
		//S(array('type'=>'redis','host'=>'127.0.0.1','post'=>'6379','prefix'=>'oa_'));
		$redis = new \Redis();
		$redis->connect('127.0.0.1',6379);
		$redis->auth('duanzonglai');
		$res = $redis->get('knowList');
		//获取redis缓存数据
		 if($res){
		 	$data = json_decode($res,true);
		 	$dataList = $data;
		 }else{
		 	$knowlegeModel=D('Knowledge');
			$dataList=$knowlegeModel->order('addtime desc')->select();
		 	//添加redis数据缓存
			// S('knowList',$dataList,1800);
			$data = json_encode($dataList);
			$redis->set('knowList',$data);
			$redis->setTimeout('knowList',3600);
		 }

		$this->assign('dataList' , $dataList);
		$this->display();
	}

	//知识添加
	public function add() {
		
		if(IS_POST){
			$knowlegeModel=D('Knowledge');
			$postData=I('post.');
			$result=$knowlegeModel->addData($postData,$_FILES['thumb']);
			if ($result) {
				$this->success('添加成功@',U('showList'));
				exit;
			}
			$this->error($knowlegeModel->getError());

		}else {
			$this->display();
		}
	}

	//知识编辑
	public function edit() {
		
		$knowlegeModel=D('Knowledge');
		if(IS_POST){
			$postData = I('post.');
			$fileData = $_FILES['thumb'];
			$result = $knowlegeModel->saveData($postData,$fileData);
			if ($result) {
				//更新成功
				$this->success('更新成功！',U('showList'));
				exit;
			}
			$this->error($knowlegeModel->getError());
		}else {
			$id=I('get.id')+0; //将字符串转换为整形
			$editDada=$knowlegeModel->find($id);
			$this->assign('editData',$editDada);
			$this->display();
		}
	}

	//知识删除
	public function del() {
		if(IS_AJAX){
			$id = I('get.id');
			$KnowledgeModel = D('Knowledge');
			if($KnowledgeModel->delete($id)){
				$result=array('status'=>1);
				echo json_encode($result);
				exit;
			}
			//删除失败
			$result = array('status'=>0);
			echo json_encode($result);
		}
	}

	//知识文件下载
	public function download() {
		$id = I('get.id');
		$data=D('Knowledge')->find($id);

		//文件路劲
		$file = WORK_PATH.$data['picture'];
		//开始下载
		header("Content-type: application/octet-stream");
		header('Content-Disposition: attachment; filename="' . basename($file) . '"');
		header("Content-Length: ". filesize($file));
		readfile($file);

	}

	//知识内容查看
	public function viewConent() {
		$id = I('get.id');
		$view=D('Knowledge')->field('content')->find($id);
		echo $view['content'];
	}
}