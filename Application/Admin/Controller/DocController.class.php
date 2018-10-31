<?php
//公文管理控制器

namespace Admin\Controller;
//use Think\Controller;

class DocController extends CommonController {


	//公文列表
	public function showList(){

		//$docModel=D('Doc');
		//$docList=$docModel->select();
		//获取mongodb数据
		$mongo = new \MongoClient("mongodb://root:root@127.0.0.1:27017");
		$db = $mongo->oa_db;
		$docList = $db->oa_doc->find();
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
		if(IS_POST){
			$docModel=D('Doc');
			$post=I('post.');
			$file=$_FILES['file'];
			$result=$docModel->saveUpdate($post,$file);
			
			if($result['ok'] == 1){
				$this->success('修改成功！',U('showList'));
			}else {
				$this->error('系统繁忙，请稍后重试！');
			}
		}else{

			$id=I('get.id');
			//从mongodb获取数据
			$mongo =  new \MongoClient("mongodb://root:root@127.0.0.1:27017");
			$db = $mongo->oa_db;
			$editData = $db->oa_doc->findOne(array('_id'=>new \MongoId("$id")));
			$this->assign('editData',$editData);
			$this->display();
		}
	}

	//公文删除
	public function del() {
		$id=I('get.id');
		//转换为数组
		$idArr = explode(',',$id);
		//从mongodb中删除数据
		$mongo = new \MongoClient("mongodb://root:root@127.0.0.1:27017");
		$db = $mongo->oa_db;
		//获取原附件的路径,将硬盘上的附件删除
		foreach ($idArr as $k => $v) {
			$oldpath = $db->oa_doc->findOne(array('_id'=>new \MongoId("$v")));
			$fileUrl = WORK_PATH.$oldpath['filepath'];
			unlink($fileUrl);

			//从mongodb中删除
			$result = $db->oa_doc->remove(array('_id'=>new \MongoId("$v")));
		}

		if ($result['ok']==1) {
			$this->ajaxReturn(array('status'=>1));
		 	
		}else {
			$this->ajaxReturn(array('status'=>0,'error'=>'系统繁忙，请稍后重试！'));
		}
		
	}

	//公文附件下载
	public function download() {

		$id=I('get.id');
		$mongo = new \MongoClient("mongodb://root:root@127.0.0.1:27017");
		$db = $mongo->oa_db;
		$result = $db->oa_doc->find(array('_id'=>new \MongoId("$id")));
		foreach ($result as  $v) {
			$data = $v['filepath'];
		}
		//下载文件
		$file = WORK_PATH.$data;
		header("Content-type: application/octet-stream");
		header('Content-Disposition: attachment; filename="' . basename($file) . '"');
		header("Content-Length: ". filesize($file));
		readfile($file);
	}

	//查看公文内容
	public function showContent(){
		$id=I('get.id');
		//获取mongodb数据
		$mongo = new \MongoClient("mongodb://root:root@127.0.0.1:27017");
		$db = $mongo->oa_db;
		$result=$db->oa_doc->find(array("_id"=>new \MongoId("$id")));
		//在php中通过_id 在mongodb中查找特定记录：array("_id"=>new MongoId("$id"))
		 foreach ($result as $k => $v) {
			//还原被转义的字符输出
			echo htmlspecialchars_decode($v['content']);
		 }
		
	}
}