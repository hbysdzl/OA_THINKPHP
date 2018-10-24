<?php
//公文管理控制器

namespace Admin\Controller;
//use Think\Controller;

class DocController extends CommonController {


	//公文列表
	public function showList(){

		$docModel=D('Doc');
		$docList=$docModel->select();
		$this->assign('docList',$docList);
		$this->display();
	}

	//公文添加
	public function add(){

		if(IS_POST){
			$postData=I('post.');
			$fileData=$_FILES['file'];

			$docModel=D('Doc');
			$result=$docModel->saveData($postData,$fileData);
			if($result){
				$this->success('添加成功！',U('showList'));
			}else{
				$this->error($docModel->getError());
			}
		}else{
			$this->display();
		}
	}

	//公文编辑
	public function edit(){
		$docModel=D('Doc');
		if(IS_POST){
			$post=I('post.');
			$file=$_FILES['file'];
			$result=$docModel->saveUpdate($post,$file);
			if($result!==false){
				$this->success('修改成功！',U('showList'));
			}else {
				$this->error($docModel->getError());
			}
		}else{

			$id=I('get.id');
			$editData=$docModel->find($id);
			$this->assign('editData',$editData);
			$this->display();
		}
	}

	//公文删除
	public function del() {
		$id=I('get.id');
		$DocModel=D('Doc');
		if($DocModel->delete($id)){
			$this->ajaxReturn(array('status'=>1));
			exit;
		}

		$this->ajaxReturn(array('status'=>0,'error'=>$DocModel->getError()));
	}

	//公文附件下载
	public function download() {

		$id=I('get.id');
		$DocModel=D('Doc');
		$data=$DocModel->find($id);

		//下载文件
		$file = WORK_PATH.$data['filepath'];
		header("Content-type: application/octet-stream");
		header('Content-Disposition: attachment; filename="' . basename($file) . '"');
		header("Content-Length: ". filesize($file));
		readfile($file);
	}

	//查看公文内容
	public function showContent(){
		$id=I('get.id');
		$DocModel=D('Doc');
		$result=$DocModel->field('content')->find($id);

		//还原被转义的字符输出
		echo htmlspecialchars_decode($result['content']);
	}
}