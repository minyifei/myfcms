<?php
// +----------------------------------------------------------------------
// | MyfCMS 闵益飞内容管理系统 [ 中国首家完全免费开源的PHPCMS ]
// +----------------------------------------------------------------------
// | Copyright (c) 2012 http://www.minyifei.cn All rights reserved.
// +----------------------------------------------------------------------
// | 交流论坛：http://bbs.minyifei.cn
// +----------------------------------------------------------------------


/**
 * 模版管理
 */
class MobanAction extends MyfAction {
	
	public function main(){
		$theme = $_REQUEST["theme"];
		if(empty($theme)){
			$theme = "default";
		}
		$name = "默认模版管理";
		if($theme=="3g"){
			$name = "3G模版管理";
		}elseif($theme == "2g"){
			$name = "简版模版管理";
		}elseif($theme=="touch"){
			$name = "触屏模版管理";
		}
		$this->assign("name",$name);
		$service = new MyfService();
		$data = $service->find_all_moban($theme);
		$this->assign("list",$data);	
		
		//随机验证码
		$code = rand(0,150);
		session("moban_code",$code);
		$this->assign("code",$code);	
		
		$this->assign("theme",$theme);		
		$this->display();
	}
	
	public function add(){
		$theme = $_REQUEST["theme"];
		if(empty($theme)){
			$theme = "default";
		}
		$name = "默认模版管理";
		if($theme=="3g"){
			$name = "3G模版管理";
		}elseif($theme == "2g"){
			$name = "简版模版管理";
		}elseif($theme=="touch"){
			$name = "触屏模版管理";
		}
		$this->assign("name",$name);
		$this->assign("theme",$theme);
		$this->display();
	}
	
	public function add_handler(){
		$dir = dirname(dirname(dirname(dirname(__FILE__))));
		$data["filename"] =$_POST["filename"];
		$data["theme"] = $_POST["theme"];
		$data["content"] = stripslashes($_POST["content"]);
		$data["pathname"] = $_POST["pathname"];
		$data["info"] = $_POST["info"];
		$service = new MyfService();
		$msg = $service->add_moban($data, $dir);
		if($msg["code"]==1){
			$script_name = $_SERVER["SCRIPT_NAME"];
			$this->success("模版添加成功",$script_name."?m=Moban&a=main&theme=".$data["theme"]);
		}else{
			$this->error($msg["info"]);
		}
	}
	
	public function update(){
		$id = $_REQUEST["id"];
		$theme = $_REQUEST["theme"];
		if(empty($theme)){
			$theme = "default";
		}
		$name = "默认模版管理";
		if($theme=="3g"){
			$name = "3G模版管理";
		}elseif($theme == "2g"){
			$name = "简版模版管理";
		}elseif($theme=="touch"){
			$name = "触屏模版管理";
		}
		$this->assign("name",$name);
		$service = new MyfService();
		$moban = $service->find_moban_by_id($id);
		
		$this->assign("moban",$moban);
		$this->assign("theme",$theme);
		
		//随机验证码
		$code = rand(0,150);
		session("moban_code",$code);
		$this->assign("code",$code);
		
		$this->display();
	}
	
	public function update_handler(){
		$scode = session("moban_code");
		$code = $_REQUEST["code"];
		if($scode!=$code){
			$this->error("验证码失效，更新失败!");
		}else{
			$dir = dirname(dirname(dirname(dirname(__FILE__))));
			$data["filename"] =$_POST["filename"];
			$data["theme"] = $_POST["theme"];
			$data["content"] = stripslashes($_POST["content"]);
			$data["pathname"] = $_POST["pathname"];
			$data["info"] = $_POST["info"];
			$id = $_POST["id"];
			$service = new MyfService();
			$msg = $service->update_moban($id, $data, $dir);
			if($msg["code"]==1){
				$script_name = $_SERVER["SCRIPT_NAME"];
				$this->success("模版更新成功",$script_name."?m=Moban&a=main&theme=".$data["theme"]);
			}else{
				$this->error($msg["info"]);
			}
		}		
	}
	
	public function delete(){
		$scode = session("moban_code");
		$code = $_REQUEST["code"];
		if($scode!=$code){
			$this->error("验证码失效，删除失败");
		}else{
			$service = new MyfService();
			$dir = dirname(dirname(dirname(dirname(__FILE__))));
			$id = $_REQUEST["id"];
			$msg = $service->delete_moban($id, $dir);
			if($msg["code"]==1){
				$script_name = $_SERVER["SCRIPT_NAME"];
				$this->success("模版删除成功",$script_name."?m=Moban&a=main&theme=".$data["theme"]);
			}else{
				$this->error($msg["info"]);
			}
		}
	}
}
?>