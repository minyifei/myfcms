<?php
// +----------------------------------------------------------------------
// | MyfCMS 闵益飞内容管理系统 [ 中国首家完全免费开源的PHPCMS ]
// +----------------------------------------------------------------------
// | Copyright (c) 2012 http://www.minyifei.cn All rights reserved.
// +----------------------------------------------------------------------
// | 交流论坛：http://bbs.minyifei.cn
// +----------------------------------------------------------------------

/**
 * 
 */
class SysAction extends MyfAction {
	
	public function main(){
		$service = new MyfService();
		$confs = $service->find_all_sys();
		$this->assign("confs",$confs);
		$this->display();
	}
	
	public function update(){
		$cfgs = array();
		foreach($_REQUEST as $key=>$value){
			if(strpos("###".$key,"cfg")){
				$arr = explode("_", $key);
				$cfgs[$arr[1]] = stripslashes($value);
			}			
		}
		$service = new MyfService();
		$service->update_sys($cfgs);
		$this->success("系统参数更新成功",$script_name."?m=Sys&a=main");
	}
	
	public function add(){
		$this->display();
	}
	
	public function add_handler(){
		$data = array();
		$data["name"] = htmlspecialchars($_POST["name"]);
		$data["value"] = stripslashes($_POST["value"]);
		$data["info"] = htmlspecialchars($_POST["info"]);
		$data["valuetype"] = $_POST["valuetype"];
		$service = new MyfService();
		$rowid = $service->add_sys($data);
		if($rowid>0){
			$script_name = $_SERVER["SCRIPT_NAME"];
			$this->success("变量添加成功",$script_name."?m=Sys&a=main");
		}else{
			$this->success("变量添加失败");
		}
	}
	
}


?>