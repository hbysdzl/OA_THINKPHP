<?php

//公文管理模型

namespace Admin\Model;
use Think\Model;

class DocModel extends Model {

	public function saveData($data,$file){

		//处理附件上传
		$cfg=array(
				 'rootPath'      => WORK_PATH.UPLOAD_PATH, //保存根路径
			);
		$uploadModel = new \Think\Upload($cfg);
		$rel = $uploadModel->uploadOne($file);
		if(!$rel){
			//获取错误信息
			$this->error=$uploadModel->getError();
			return false;
		}
		
		$data['filepath'] = UPLOAD_PATH.$rel['savepath'].$rel['savename'];
		$data['filename'] = $rel['name'];
		$data['hasfile'] = 1;
		$data['addtime'] = time();
		return  $this->add($data);
	}

	//数据更新方法
	public function saveUpdate($post,$file) {
		
		if($file['error']==0){
			$cfg=array(
					'rootPath'  =>   WORK_PATH.UPLOAD_PATH,  //文件上传路径
				);

			$uploadModel = new \Think\Upload($cfg);
			$info=$uploadModel->uploadOne($file);
			
			if($info){
				//先将原有的文件从硬盘删除
				$old_file = $this->field('filepath')->find($post['id']);
				$oldPath = WORK_PATH.$old_file['filepath'];
				unlink($oldPath);

				//更新字段
				$post['filepath'] = UPLOAD_PATH.$info['savepath'].$info['savename'];
				$post['filename'] = $info['name'];  //原始文件名
				$post['hasfile'] = 1;
			}

			return $this->save($post);

		}
	}
}