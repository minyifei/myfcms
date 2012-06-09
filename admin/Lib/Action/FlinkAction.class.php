<?php
// +----------------------------------------------------------------------
// | MyfCMS 闵益飞内容管理系统 [ 中国首家完全免费开源的PHPCMS ]
// +----------------------------------------------------------------------
// | Copyright (c) 2012 http://www.minyifei.cn All rights reserved.
// +----------------------------------------------------------------------
// | 交流论坛：http://bbs.minyifei.cn
// +----------------------------------------------------------------------

import("@.Utils.UploadImage");

class FlinkAction extends MyfAction{
	public function main(){
		$service = new MyfService();
		$links = $service->find_all_flink();
		$this->assign("links",$links);
		$this->display();
	}
	
	public function add(){
		$this->display();
	}
	
	public function add_handler(){
		$data = array();
		$data["url"] = $_REQUEST["url"];
		$data["webname"] = $_REQUEST["webname"];
		$data["sortrank"] = $_REQUEST["sortrank"];
		$data["msg"] = $_REQUEST["description"];
		$data["logo"] = $_REQUEST["logo"];
		$data["dtime"] =date("Y-m-d H:i:s");
		$service = new MyfService();
		$linkId = $service->add_flink($data);
		if($linkId>0){
			$script_name = $_SERVER["SCRIPT_NAME"];
			$this->success("链接添加成功",$script_name."?m=Flink&a=main");
		}else{
			$this->success("链接添加失败");
		}
	}
	
	public function update(){
		$id = $_REQUEST["id"];
		$service = new MyfService();
		$link = $service->find_flink_by_id($id);
		$this->assign("link",$link);
		$this->display();
	}
	
	public function update_handler(){
		$data = array();
		$data["url"] = $_REQUEST["url"];
		$data["webname"] = $_REQUEST["webname"];
		$data["sortrank"] = $_REQUEST["sortrank"];
		$data["msg"] = $_REQUEST["description"];
		$data["logo"] = $_REQUEST["logo"];
		$id = $_REQUEST["id"];
		$service = new MyfService();
		$rows = $service->update_flink($id, $data);
		if($rows>0){
			$script_name = $_SERVER["SCRIPT_NAME"];
			$this->success("链接更新成功",$script_name."?m=Flink&a=main");
		}else{
			$this->error("链接更新失败");
		}
	}
	
	public function delete(){
		$id = $_REQUEST["id"];
		$service = new MyfService();
		$rows = $service->delete_flink($id);
		if($rows>0){
			$script_name = $_SERVER["SCRIPT_NAME"];
			$this->success("链接删除成功",$script_name."?m=Flink&a=main");
		}else{
			$this->error("链接删除失败");
		}
	}
	
	public function deletes(){
		$ids = $_REQUEST["linkId"];
		$service = new MyfService();
		$rows = 0;
		foreach ($ids as $key => $value) {
			$r = $service->delete_flink($value);
			if($r>0){
				$rows++;
			}
		}
		if($rows>0){
			$script_name = $_SERVER["SCRIPT_NAME"];
			$this->success("链接删除成功",$script_name."?m=Flink&a=main");
		}else{
			$this->error("链接删除失败");
		}
	}
	
	/**
	 * 上传logo
	 */
	public function uploadpic(){
		$upload = new UploadImage("file","Uploads/Flinks");
		$newName = $upload->newName();
		$upload->upload($newName);
		$html = "<script>parent.callback('".$upload->UpFile()."')</script>";
		echo $html;
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
		$service->update_flink_sortrank($sortranks);
		$script_name = $_SERVER["SCRIPT_NAME"];
		$this->success("链接顺序更新成功",$script_name."?m=Flink&a=main");
	}
}

?>