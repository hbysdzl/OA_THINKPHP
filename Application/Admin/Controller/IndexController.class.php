<?php
//后台首页控制器
namespace Admin\Controller;
//use Think\Controller;

Class IndexController extends CommonController {

	public function index(){
		$userIp=$this->getAddr();
		$this->assign('userIp',$userIp);
		$this->display();
	}

	public function main(){
		$this->display();
	}

	//用户iP及物理地址
	private function getAddr(){
		$ip=get_client_ip();
		$IpModel = new \Org\Net\IpLocation('qqwry.dat');
		$addr=$IpModel->getlocation($ip);
		$addr=$this->array_iconv('gbk','utf-8',$addr);

		$addr=explode(',',$addr);
		return $addr; 
	}

	//字符集转码
	//iconv php字符集转码函数
	//var_export 将数组拼接为字符串
	private function array_iconv($in_charset,$out_charset,$arr) {
		return iconv($in_charset,$out_charset,implode(',',$arr));
	}
}  