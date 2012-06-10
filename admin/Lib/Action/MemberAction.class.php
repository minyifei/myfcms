<?php
// +----------------------------------------------------------------------
// | MyfCMS 闵益飞内容管理系统 [ 中国首家完全免费开源的PHPCMS ]
// +----------------------------------------------------------------------
// | Copyright (c) 2012 http://www.minyifei.cn All rights reserved.
// +----------------------------------------------------------------------
// | 交流论坛：http://bbs.minyifei.cn
// +----------------------------------------------------------------------

import("ORG.Util.Page");// 导入分页类
class MemberAction extends MyfAction{
	
	public function main(){
		$service = new MyfService();
		$pageCount = 20;
		$p = $_REQUEST["p"];
		if(empty($p)){
			$p = 1;
		}
		$loginid = $_REQUEST["loginid"];
		$filter ="";
		if(!empty($loginid)){
			$filter = "loginid like '%".$loginid."%'";
		}
		$members = $service->find_member_by_page($p,$pageCount,$filter);
		$this->assign("members",$members);
		
		$count = $service->count_member($filter);
		$page = new Page($count,$pageCount);
		$page_show = $page->show();
		$this->assign("page",$page_show);
		
		$this->assign("loginid",$loginid);
		
		$this->display();
	}
	
	public function add(){
		$this->display();
	}
	
	public function add_handler(){
		$data = array();
		$data["loginid"] = $_POST["userid"];
		$data["username"] = $_POST["uname"];
		$data["pwd"] = md5("myf_".$_POST["pwd"]);
		$data["email"] = $_POST["email"];
		$data["face"] = rand(1,12);
		$service = new MyfService();
		if($service->find_is_member_used($userid)){
			$this->error("该会员登录名已经被使用！");
		}else{
			$rowid = $service->add_member($data);
			if($rowid>0){
				$script_name = $_SERVER["SCRIPT_NAME"];
				$this->success("会员添加成功",$script_name."?m=Member&a=main");
			}else{
				$this->error("会员添加失败");
			}
		}
		
	}
	
	public function update(){
		$id = $_REQUEST["id"];
		$service = new MyfService();
		$member = $service->find_member_by_id($id);
		$this->assign("member",$member);
		$this->display();
	}
	
	public function update_handler(){
		$data["username"] = $_POST["uname"];
		$pwd =  $_POST["pwd"];
		if(!empty($pwd)){
			$data["pwd"] = md5("myf_".$_POST["pwd"]);
		}
		$data["email"] = $_POST["email"];
		$id = $_REQUEST["id"];
		$service = new MyfService();
		$rowid = $service->update_member($id, $data);
		if($rowid>0){
			$script_name = $_SERVER["SCRIPT_NAME"];
			$this->success("会员资料修改成功",$script_name."?m=Member&a=main");
		}else{
			$this->error("会员资料修改失败");
		}
	}
	
	
	public function delete_handler(){
		$id = $_REQUEST["id"];
		$service = new MyfService();
		$rowid = $service->delete_member($id);
		if($rowid>0){
			$script_name = $_SERVER["SCRIPT_NAME"];
			$this->success("会员删除成功",$script_name."?m=Member&a=main");
		}else{
			if($rowid==-1){
				$this->error("初始管理员不能被删除");
			}else{
				$this->error("用户删除失败");
			}
			
		}
	}
	
}

?>