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
/**
 * myfcms基础Action
 */
class MyfAction extends Action {
	
	public $loginUser = null;
	
	Public function _initialize(){
		$this->loginUser = $this->check_login();
	}
	
	/**
	 * 验证用户是否登录
	 */
	public function check_login(){
		$myfcms_user = session("myfcms_user");
		if(empty($myfcms_user)){
			$script_name = $_SERVER["SCRIPT_NAME"];
			$this->error("身份非法，请先登录",$script_name."?m=Login&a=index");
		}else{
			return $myfcms_user;
		}	
	}
	
		
}


?>