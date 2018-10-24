<?php

//邮件管理模型

namespace Admin\Model;
use Think\Model;

class EmailModel extends Model {

	//发送邮件数据保存及上传附件
	public function sendData($post,$file) {
		if($file['error'] == 0){

			$cfg =  array('rootPath'      =>  WORK_PATH.UPLOAD_PATH );//保存根路径
			$uploadModel = new \Think\Upload($cfg);
			$info = $uploadModel->uploadOne($file);

			if(!$info){
				$this->error = $uploadModel->getError();
				return;
			}

			$post['file'] = UPLOAD_PATH.$info['savepath'].$info['savename'];
			$post['hasfile'] = 1;
			$post['filename'] = $info['name'];

		}
		$post['from_id'] = session('admin_id');
		$post['addtime'] = time();

		return $this->add($post);
	}

	//删除之前将附件从硬盘上删除
	public function _before_delete($options) {

		$imgPath = $this->field('file')->find($options['where']['id']);
		$imgPath = WORK_PATH.$imgPath['file'];
		unlink($imgPath);
	}

}