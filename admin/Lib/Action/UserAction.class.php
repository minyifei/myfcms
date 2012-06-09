<?php
// +----------------------------------------------------------------------
// | MyfCMS 闵益飞内容管理系统 [ 中国首家完全免费开源的PHPCMS ]
// +----------------------------------------------------------------------
// | Copyright (c) 2012 http://www.minyifei.cn All rights reserved.
// +----------------------------------------------------------------------
// | 交流论坛：http://bbs.minyifei.cn
// +----------------------------------------------------------------------


class UserAction extends MyfAction{
	
	public function main(){
		$service = new MyfService();
		$users = $service->find_all_admin();
		$this->assign("users",$users);
		$this->display();
	}
	
	public function add(){
		$code =  md5(rand(200,5000));
		$this->assign("code",$code);
		session("code",$code);
		$this->display();
	}
	
	public function add_handler(){
		$code = $_REQUEST["code"];
		if($code!=session("code")){
			$this->error("安全验证串错误！");
			return;
		}
		$data = array();
		$data["userid"] = $_POST["userid"];
		$data["uname"] = $_POST["uname"];
		$data["pwd"] = md5($_POST["pwd"]);
		$data["email"] = $_POST["email"];
		$service = new MyfService();
		if($service->find_is_userid_used($userid)){
			$this->success("该用户登录名已经被使用！");
		}else{
			$rowid = $service->add_user($data);
			if($rowid>0){
				$script_name = $_SERVER["SCRIPT_NAME"];
				$this->success("用户添加成功",$script_name."?m=User&a=main");
			}else{
				$this->error("用户添加失败");
			}
		}
		
	}
	
	public function update(){
		$code =  md5(rand(200,5000));
		$this->assign("code",$code);
		session("updatecode",$code);
		
		$id = $_REQUEST["id"];
		$service = new MyfService();
		$user = $service->find_admin_by_id($id);
		$this->assign("user",$user);
		$this->display();
	}
	
	public function update_handler(){
		$code = $_REQUEST["code"];
		if($code!=session("updatecode")){
			$this->error("安全验证串错误！");
			return;
		}
		$data = array();
		$data["uname"] = $_POST["uname"];
		$pwd = $_POST["pwd"];
		if(!empty($pwd)){
			$data["pwd"] = md5($pwd);
		}		
		$data["email"] = $_POST["email"];
		$id = $_POST["id"];
		$service = new MyfService();
		$rowid = $service->update_user($id, $data);
		if($rowid>0){
			$script_name = $_SERVER["SCRIPT_NAME"];
			$this->success("用户修改成功",$script_name."?m=User&a=main");
		}else{
			$this->error("用户修改失败");
		}
	}
	
	public function delete(){
		$code =  md5(rand(200,5000));
		$this->assign("code",$code);
		session("deletecode",$code);
		
		$id = $_REQUEST["id"];
		$service = new MyfService();
		$user = $service->find_admin_by_id($id);
		$this->assign("user",$user);
		$this->display();
	}
	
	public function delete_handler(){
		$code = $_REQUEST["code"];
		if($code!=session("deletecode")){
			$this->error("安全验证串错误！");
			return;
		}
		$id = $_REQUEST["id"];
		$service = new MyfService();
		$rowid = $service->delete_user($id);
		if($rowid>0){
			$script_name = $_SERVER["SCRIPT_NAME"];
			$this->success("用户删除成功",$script_name."?m=User&a=main");
		}else{
			if($rowid==-1){
				$this->error("初始管理员不能被删除");
			}else{
				$this->error("用户修改失败");
			}
			
		}
	}
	
}

?>