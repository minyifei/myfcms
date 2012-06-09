<?php
// +----------------------------------------------------------------------
// | MyfCMS 闵益飞内容管理系统 [ 中国首家完全免费开源的PHPCMS ]
// +----------------------------------------------------------------------
// | Copyright (c) 2012 http://www.minyifei.cn All rights reserved.
// +----------------------------------------------------------------------
// | 交流论坛：http://bbs.minyifei.cn
// +----------------------------------------------------------------------


header("Content-Type:text/html; charset=utf-8");
import("@.Service.MyfService");
import("ORG.Util.Image");

class LoginAction extends Action {
	//登陆
	public function index(){
		$this->display();
	}
	
	/**
	 * 登录验证
	 */
	public function login_in(){
		$verify = $_REQUEST["verify"];
		if(md5($verify)!=$_SESSION["verify"]){
			$this->error("验证码错误！");
		}else{
			$userid = $_POST["userid"];
			$pwd = $_POST["pwd"];
			if(!isset($userid) || !isset($pwd)){
				$this->error("用户名和密码不能为空！");
			}else{
				$service = new MyfService();
				$user = $service->check_user_login($userid,$pwd);
				if($user){
					session("myfcms_user",$user);
					$script_name = $_SERVER["SCRIPT_NAME"];
					$this->success("登录成功！",$script_name);
				}else{
					$this->error("用户名或密码错误！");
				}
			}
		}
	}
	
	/**
	 * 退出
	 */
	public function out(){
		session("myfcms_user",null);
		$this->success("已经退出系统！",$script_name."?m=Login&a=index");
	}
	
	/**
	 * 生产验证码
	 */
	public function verify(){
		Image::buildImageVerify();
	}
	
}

?>