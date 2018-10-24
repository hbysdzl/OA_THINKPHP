<?php

//系统空操作控制器
namespace Admin\Controller;
use Think\Controller;

class EmptyController extends Controller {

	//空的操作方法
	public function _empty(){
		
		$this->display('Empty/error');
	}
}