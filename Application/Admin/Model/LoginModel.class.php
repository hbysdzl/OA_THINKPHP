<?php
//后台管理员登录模型

namespace Admin\Model;
use Think\Model;

class LoginModel extends Model {
	//定义表名

	// 数据表名（不包含表前缀）
    protected $tableName        =   'user';


    //登录表单验证
    protected $_validate=array(
    	array('username','require','请输入用户名','0','regex'),
    	array('password','require','请输入密码','0','regex'),
    	array('code','require','请输入验证码','0','regex'),
    	array('code','codeVer','验证码错误','0','callback')
    	);

    //验证用户验证码
    protected function codeVer($code){
    	$veifyModel = new \Think\Verify();
    	$result = $veifyModel->check($code);
    	return $result;
    }

    //用户登录
    public function login(){
    	$username=$this->username;
    	$pwd=$this->password;
        //判断密码错误次数
        $redis = new \Redis();
        $redis->connect('127.0.0.1',6379);
        $loginnum = $redis->get($username);
        if ($loginnum>=3) {
            $this->error="账号已锁定";
        }else {
                $user=$this->where(array('username'=>array('eq',$username)))->find();
                if($user){
                    if($user['password'] == md5($pwd)){
                        //登录成功
                        session('admin_id',$user['id']);
                        session('username',$user['username']);
                        session('role_id', $user['role_id']);
                        session('truename',$user['truename']);
                        return true;
                    }else{
                         //记录错误次数
                        $redis->incr($user['username']);
                        //设置有效期
                        $redis->setTimeout($user['username'],60); 
                        //计算剩余的次数
                        $timeNumber = 3 - $redis->get($user['username']);

                        if ($timeNumber <= 0) {
                            $this->error="密码错误，该账号已被锁定！60s后重试";
                        }else{
                            $this->error="密码错误，还剩余".$timeNumber."次登录次数";
                        }
                       
                    }
                }else{
                    $this->error='用户名不存在！';
                    return false;
                }
        }
 
    }
}