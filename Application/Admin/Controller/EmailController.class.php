<?php

//邮件管理控制器
namespace Admin\Controller;
//use Think\Controller;

class EmailController extends CommonController {

	//发送邮件
	public function send() {

		if(IS_POST){
			$emailModel = D('Email');
			$postData = I('post.');
			$fileData = $_FILES['file'];
			$result = $emailModel->sendData($postData,$fileData);
			if($result){
				$this->success('发送成功！',U('sendBox'));
			}
		}else {
			$from_id = I('get.from_id');
			$this->assign('from_id',$from_id);
			//获取收件人数据 除自己本身
			$toList = M('User')->field('id,truename')->where('id!='.session('admin_id'))->select();
			$this->assign('toList',$toList);
			$this->display();
		}
	}

	//发件箱
	public function sendBox(){

		//获取数据
		$emailModel = D('Email');
		$sendData = $emailModel->field('t1.*,t2.truename')->alias('t1')->join('left join oa_user as t2 on t1.to_id=t2.id')->where('t1.from_id='.session('admin_id'))->select();
		//dump($sendData);
		$this->assign('sendData',$sendData);
		$this->display();
	}


	//收件箱
	public function recBox() {

		//获取当前用户的邮件数据
		$emailModel = D('Email');
		$recData = $emailModel->alias('t1')->field('t1.*,t2.truename')->join('left join oa_user as t2 on t1.from_id=t2.id')->where('t1.to_id='.session('admin_id'))->select();

		$this->assign('recData',$recData);
		$this->display();
	}

	//发件箱的删除
	public function del(){
		if(IS_AJAX){
			$id = I('get.id');
			$EmailModel = D('Email');
			$result=$EmailModel->where(array('id'=>array('eq',$id),'from_id'=>array('eq',session('admin_id'))))->delete();
			if($result){
				echo json_encode(array('status'=>1));
				exit;
			}
			 echo json_encode(array('status'=>0));
		}
	}

	//邮件的查看
	public function view (){
		$id = I('get.id');
		$emailModel = D('Email');
		$where =array(
				't1.id'=> $id,
				'to_id' => session('admin_id')
			); 
		$result = $emailModel->field('t1.*,t2.truename')->alias('t1')->join('left join oa_user as t2 on t1.from_id=t2.id')->where($where)->find();
		$this->assign('result',$result);

		//设置为已读状态
		$where =array(
				'id'=> $id,
				'to_id' => session('admin_id')
			); 
		if ($result['is_read'] == 0) {
			$emailModel->where($where)->setField('is_read',1);
		}
		$this->display();
	}

	//附件下载
	public function download(){
		$id = I('get.id');
		$fileUrl = D('Email')->field('file')->where('to_id='.session('admin_id'))->find($id);
		$file = WORK_PATH . $fileUrl['file'];
		//开始下载
		header("Content-type: application/octet-stream");
		header('Content-Disposition: attachment; filename="' . basename($file) . '"');
		header("Content-Length: ". filesize($file));
		readfile($file);
	}

	//收件箱的删除
	public function recDel() {
		if (IS_AJAX) {
			$id = I('get.id');
			$emailModel = D('Email');
			$result = $emailModel->where('to_id='.session('admin_id'))->delete($id);
			if ($result) {
				echo json_encode(array('status'=>1));
				exit;
			}
			echo json_encode(array('status'=>0));
		}
	}

	//获取未读邮件数量
	public function getEmailCount() {
		if(IS_AJAX){
			$emailModel = D('Email');
			$where = array(
					'is_read' => 0,
					'to_id'   => session('admin_id')
 				);
			$count = $emailModel->where($where)->count();
			echo $count;
		}
	}
}