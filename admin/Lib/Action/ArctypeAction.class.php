<?php
// +----------------------------------------------------------------------
// | MyfCMS 闵益飞内容管理系统 [ 中国首家完全免费开源的PHPCMS ]
// +----------------------------------------------------------------------
// | Copyright (c) 2012 http://www.minyifei.cn All rights reserved.
// +----------------------------------------------------------------------
// | 交流论坛：http://bbs.minyifei.cn
// +----------------------------------------------------------------------

import("@.Utils.Pinyin");

class ArctypeAction extends MyfAction {
	
	/**
	 * 栏目管理页面
	 */
	public function main(){
		$service = new MyfService();
		$arctypes = $service->find_all_arctype();
		$this->assign("arctypes",$arctypes);
		
		$m_sys = M("sys");
		$d_sys = $m_sys->where("id<3")->select();
		$h = "";
		foreach ($d_sys as $key => $value) {
			$h.=$value["value"];
		}
		$this->assign("weburl",$h);
		
		$this->display();
	}
	
	/**
	 * 添加栏目页面
	 */
	public function add(){
		
		$topid = $_GET["topid"];
		if(empty($topid)){
			$topid = 0;
		}
		$this->assign("topid",$topid);
		$this->display();
	}
	
	/**
	 * 添加栏目处理事件
	 */
	public function add_handler(){
		$data = array();
		$data["typename"] = htmlspecialchars($_POST["typename"]);
		$data["topid"] = $_POST["topid"];
		$data["sortrank"] = $_POST["sortrank"];
		$typepro = $_POST["typepro"];
		$data["typepro"] = $typepro;
		$data["seotitle"] = $_POST["seotitle"];
		$data["keywords"] = $_POST["keywords"];
		$data["description"] = $_POST["description"];
		$typedir = $_POST["typedir"];
		if(!empty($typedir)){
			$data["typedir"] = $typedir;
		}else{
			$pinyin = new Pinyin();
			$names = $pinyin->get_pinyin_array($data["typename"]);
			$data["typedir"] = $names[0];
		}
		$theme = $_POST["theme"];
		$classname = "List";
		if($typepro==2){
			$classname="Jump";
		}elseif($typepro==1){
			$classname = "Cover";
		}elseif($typepro==3){
			$classname = "Single";
			$body = $_POST["editorValue"]; 
			$data["body"] = get_magic_quotes_gpc()?$body:addslashes($body);
		}
		$data["classname"] = $classname;
		
		//theme=1代表自定义模版
		if($theme==1 && $typepro!="2"){
			$data["methodname"] = $data["typedir"];
		}else{
			$data["methodname"] = "index";
		}	
			
		$service = new MyfService();
		$typeid = $service->add_arctype($data);
		if($typeid>0){
			$script_name = $_SERVER["SCRIPT_NAME"];
			$this->success("栏目添加成功",$script_name."?m=Arctype&a=main");
		}else{
			$this->error("栏目添加失败");
		}
	}
	
	/**
	 * 更新栏目页面
	 */
	public function update(){
		$id = $_REQUEST["id"];
		$service = new MyfService();
		$arctype = $service->find_arctype_by_id($id);
		$arctype["body"] = stripcslashes($arctype["body"]);
		$this->assign("arctype",$arctype);
		$this->display();
	}
	
	/**
	 * 更新栏目处理事件
	 */
	public function update_handler(){
		$data = array();
		$data["typename"] = htmlspecialchars($_POST["typename"]);
		$data["topid"] = $_POST["topid"];
		$data["sortrank"] = $_POST["sortrank"];
		$typepro = $_POST["typepro"];
		$data["seotitle"] = $_POST["seotitle"];
		$data["keywords"] = $_POST["keywords"];
		$data["description"] = $_POST["description"];
		$typedir = $_POST["typedir"];
		if(!empty($typedir)){
			$data["typedir"] = $typedir;
		}else{
			$pinyin = new Pinyin();
			$names = $pinyin->get_pinyin_array($data["typename"]);
			$data["typedir"] = $names[0];
		}
		if($typepro==3){
			$body = $_POST["editorValue"];
			$data["body"] = get_magic_quotes_gpc()?$body:addslashes($body);
		}
		$id = $_POST["id"];
		$service = new MyfService();
		$rowid = $service->update_arctype($id, $data);
		if($rowid>0){
			$script_name = $_SERVER["SCRIPT_NAME"];
			$this->success("栏目更新成功",$script_name."?m=Arctype&a=main");
		}else{
			$this->success("栏目更新失败");
		}
	}
	
	/**
	 * 更新排序处理事件
	 */
	public function sort_rank(){
		
		$sortranks = array();
		foreach($_REQUEST as $key=>$value){
			if(strpos("###".$key,"sortrank")){
				$arr = explode("_", $key);
				$sortranks[$arr[1]] = $value;
			}			
		}
		$service = new MyfService();
		$service->update_arctype_sortrank($sortranks);
		$script_name = $_SERVER["SCRIPT_NAME"];
		$this->success("栏目顺序更新成功",$script_name."?m=Arctype&a=main");
	}
	
	/**
	 * 处理删除
	 */
	public function delete_handler(){
		$id = $_REQUEST["id"];
		$service = new MyfService();
		$rowid = $service->delete_arctype($id);
		if($rowid>0){
			$script_name = $_SERVER["SCRIPT_NAME"];
			$this->success("栏目删除成功！",$script_name."?m=Arctype&a=main");
		}else{
			$this->success("栏目删除失败，请确保要删除的栏目没有子栏目并且栏目下没有文章！");
		}
	}
	
}

?>