<?php

//知识管理模型
namespace Admin\Model;
use Think\Model;

class KnowledgeModel extends Model {

	//添加数据并生成缩略图
	public function addData($post,$file) {

		if($file['error']==0){
			$cfg=array(
					'rootPath'      =>  WORK_PATH . UPLOAD_PATH, //保存根路径
				);
			$uploadModel = new \Think\Upload($cfg);
			$info=$uploadModel->uploadOne($file);
			if(!$info){
				$this->error=$uploadModel->getError();
				return false;
			}

			$post['picture'] = UPLOAD_PATH.$info['savepath'].$info['savename'];

			//生成缩略图
			$imgModel = new \Think\Image();
			$imgModel -> open(WORK_PATH.$post['picture']);
			$imgModel->thumb(100,100)->save(WORK_PATH.UPLOAD_PATH.$info['savepath'].'sm_'.$info['savename']);
			$post['thumb'] = UPLOAD_PATH.$info['savepath'].'sm_'.$info['savename'];
			$post['addtime'] =  time();
			return $this->add($post);
		}
	}

	//更新数据生成缩略图
	public function saveData($post,$file) {

		if ($file['error']==0) {
			$cfg = array('rootPath'      =>  WORK_PATH . UPLOAD_PATH,); //保存根路径
			$uploadModel = new \Think\Upload($cfg);
			$info = $uploadModel->uploadOne($file);
			if(!$info){
				$this->error=$uploadModel->getError();
				return false;
			}
			//先将硬盘图片删除
			$oldUrl=$this->field('thumb,picture')->find($post['id']);
			unlink(WORK_PATH.$oldUrl['picture']);
			unlink(WORK_PATH.$oldUrl['thumb']);

			$post['picture'] = UPLOAD_PATH.$info['savepath'].$info['savename'];

			//生成缩略图
			$imgModel = new \Think\Image();
			$imgModel->open(WORK_PATH.$post['picture']);
			$imgModel->thumb(100,100)->save(WORK_PATH.UPLOAD_PATH.$info['savepath'].'sm_'.$info['savename']);
			$post['thumb'] = UPLOAD_PATH.$info['savepath'].'sm_'.$info['savename'];
			return $this->save($post);
		}
	}


	//删除之前
	public function _before_delete($options) {
		//将硬盘上的图片删除
		$imgPath = $this->field('picture,thumb')->select($options['where']['id']);
		foreach ($imgPath as $k => $v) {
			foreach ($v as $k1 => $v1) {
				unlink(WORK_PATH.$v1);
			}	
		}
	} 
}