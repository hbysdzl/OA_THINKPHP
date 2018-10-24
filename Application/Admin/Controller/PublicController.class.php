<?php

//后台管理员登录控制器
namespace Admin\Controller;
use Think\Controller;

class PublicController extends Controller {

	//管理员登录
	public function login(){

		if(IS_POST){
			$logiModel=D('Login');
			if($logiModel->field('username,password,code')->create()){
				if(true===$logiModel->login()){
					$this->redirect('Index/index');
					exit;
				}
			}
			$this->error($logiModel->getError());
		}else{
			$this->display();

		}
		
	}

	//输出验证码
	public function captcha(){

		$conf=array(
			 'useImgBg'  =>  false, 
			 'fontSize'  =>  18,              // 验证码字体大小(px)
	         'useCurve'  =>  false,            // 是否画混淆曲线
	         'useNoise'  =>  false,            // 是否添加杂点	
	         'imageH'    =>  0,               // 验证码图片高度
	         'imageW'    =>  120,               // 验证码图片宽度
	         'length'    =>  4,               // 验证码位数
	         'fontttf'   =>  '4.ttf',              // 验证码字体，不设置随机获取
			);
		$veifyModel = new \Think\Verify($conf);
		$veifyModel->entry();

	}

	//用户退出
	public function outLogin(){
		session('admin_id', null);
		session('username', null);
		session('role_id', null);

		$this->success('退出成功！',U('login'));
	}
}