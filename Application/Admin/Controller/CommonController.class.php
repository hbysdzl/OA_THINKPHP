<?php

//后台公共控制器
namespace Admin\Controller;
use Think\Controller;

class CommonController extends Controller {

	//构造方法
	public function __construct(){
		parent::__construct(); //调用父类的构造方法

		//判断用户是否处于登录状态
		$loginStatus = session('admin_id');  
		if(empty($loginStatus)){  //***empty方法不可用任何其它函数的返回值作为参数****
			
			//编写js实现顶部跳转
			$loginUrl = U('Public/login');
			echo "<script>top.location.href='$loginUrl'</script>";
			exit;
		}

		//RBAC权限管理
		$role_id = session('role_id');
		$rbac_role_auths = C('RBAC_ROLE_AUTHS');
		$UserAuth = $rbac_role_auths[$role_id];
		//当前访问的控制器及方法 并转为小写
		$Controller = strtolower(CONTROLLER_NAME);
		$action = strtolower(ACTION_NAME);
		
		if($role_id > 1){
			//非超级管理员
			if ($Controller !== "index") {
				if(!in_array($Controller.'/'.$action, $UserAuth) && !in_array($Controller.'/*', $UserAuth)){
					$this->error('无执行权限');
					exit;
				}
			}
			
		}
	}


	//空操作  子类自动调用
	public function _empty() {
		$this->display('Empty/error');
	}
}