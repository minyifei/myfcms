<?php
// +----------------------------------------------------------------------
// | MyfCMS 闵益飞内容管理系统 [ 中国首家完全免费开源的PHPCMS ]
// +----------------------------------------------------------------------
// | Copyright (c) 2012 http://www.minyifei.cn All rights reserved.
// +----------------------------------------------------------------------
// | 交流论坛：http://bbs.minyifei.cn
// +----------------------------------------------------------------------


import("ORG.Util.Page");// 导入分页类
import("@.Utils.UploadImage");

class ArchivesAction extends MyfAction {
	
	/**
	 * 文章列表页
	 */
	public function main(){
		$service = new MyfService();
		$pageCount = 20;
		$p = $_REQUEST["p"];
		if(empty($p)){
			$p = 1;
		}
		
		//关键字搜索
		$keyword = $_REQUEST["keyword"];
		$filter = "1=1";
		if(!empty($keyword)){
			$filter.= " and title like '%".$keyword."%'";
		}
		$typeid = $_REQUEST["typeid"];
		if(!empty($typeid) && $typeid>0){
			$typechild = $service->find_arctype_by_topid($typeid);
			if($typechild){
				$ids = "0";
				foreach($typechild as $key=>$v){
					$ids .= ",".$v["id"];
				}
				$filter.= " and typeid in(".$ids.")";	
			}else{
				$filter.= " and typeid=".$typeid;
			}
		}
		//组织分页
		$count = $service->count_archives($filter);
		$page = new Page($count,$pageCount);
		$page_show = $page->show();
		$this->assign("page",$page_show);
		//文章列表
		$list = $service->find_archives_by_page($p,$pageCount,$filter);
		$this->assign("list",$list);
		
		
		$m_sys = M("sys");
		$d_sys = $m_sys->where("id<3")->select();
		$h = "";
		foreach ($d_sys as $key => $value) {
			$h.=$value["value"];
		}
		$this->assign("weburl",$h);
				
		//栏目
		$arttypes = $service->find_all_arctype();
		//删除跳转栏目
		foreach($arttypes as $key=>$value){
			if($value["typepro"]==2){
				unset($arttypes[$key]);
			}
		}
		$this->assign("arttypes",$arttypes);
		$this->display();
	}
	
	/**
	 * 添加文章页
	 */
	public function add(){
		$service = new MyfService();
		$arttypes = $service->find_all_arctype();
		//删除跳转栏目
		foreach($arttypes as $key=>$value){
			if($value["typepro"]==2){
				unset($arttypes[$key]);
			}
		}
		$this->assign("arttypes",$arttypes);
		$now  = date("Y-m-d H:i:s");
		$this->assign("now",$now);
		$click = rand(1,300);
		$this->assign("click",$click);
		$this->display();
	}
	/**
	 * 保存文章
	 */
	public function add_handler(){
		$data = array();
		$data["title"] = htmlspecialchars($_POST["title"]);
		$flag = $_REQUEST["flags"];
		$data["litpic"] = $_POST["picname"];
		if(!empty($data["litpic"])){
			if(!in_array("p", $flag)){
				$flag[] = "p";
			}
		}
		$data["flag"] = implode(",",$flag);
		$data["keywords"] = $_POST["keywords"];
		$data["color"] = $_POST["color"];
		$data["source"] = $_POST["source"];
		$data["writer"] = $_POST["writer"];
		$data["adminid"] = $this->loginUser["id"];
		$data["adminname"] = $this->loginUser["uname"];
		$typeid = $_POST["typeid"];
		$service = new MyfService();
		if(!empty($typeid)){
			$arctype = $service->find_arctype_by_id($typeid);
			$data["typeid"]=$typeid;
			$data["typename"] = $arctype["typename"];
			if($arctype["typepro"]==1){
				$this->error("封面栏目不允许添加文章！");
				return;
			}
		}
		$data["description"] = $_POST["description"];
		$sendtime = $_POST["sendtime"];
		if(empty($sendtime)){
			$sendtime = date("Y-m-d H:i:s");
		}
		$data["sendtime"] = $sendtime;
		$data["click"] = $_POST["click"];
		$body = $_POST["editorValue"];
		$data["postgood"] = rand(1,50);
		$data["badgood"] = 0;
		$data["commentCount"] = 0;
		$data["body"] = get_magic_quotes_gpc()?$body:addslashes($body);
		$archivesId = $service->add_archives($data);
		if($archivesId>0){
			$script_name = $_SERVER["SCRIPT_NAME"];
			$this->success("文章添加成功",$script_name."?m=Archives&a=main");
		}else{
			$this->error("文章添加失败");
		}
	}

	/**
	 * 修改文章
	 */
	public function update(){
		$id = $_REQUEST["id"];
		$service = new MyfService();
		$archive = $service->find_archives_by_id($id);
		$flag = $archive["flag"];
		$archive["body"] = stripcslashes($archive["body"]);
		$this->assign("arc",$archive);
		if($flag){
			$flags = explode(",",$flag);
			if(in_array("h", $flags)){
				$this->assign("h","h");
			}
			if(in_array("c", $flags)){
				$this->assign("c","c");
			}
			if(in_array("f", $flags)){
				$this->assign("f","f");
			}
			if(in_array("a", $flags)){
				$this->assign("a","a");
			}
			if(in_array("s", $flags)){
				$this->assign("s","s");
			}
			if(in_array("b", $flags)){
				$this->assign("b","b");
			}
			if(in_array("p", $flags)){
				$this->assign("p","p");
			}
		}
		//栏目
		$arttypes = $service->find_all_arctype();
		//删除跳转栏目
		foreach($arttypes as $key=>$value){
			if($value["typepro"]==2){
				unset($arttypes[$key]);
			}
		}
		$this->assign("arttypes",$arttypes);
		$this->display();
	}
	/**
	 * 修改文章处理
	 */
	public function update_handler(){
		$data = array();
		$data["title"] = htmlspecialchars($_POST["title"]);
		$flag = $_REQUEST["flags"];
		$data["litpic"] = $_POST["picname"];
		if(!empty($data["litpic"])){
			if(!in_array("p", $flag)){
				$flag[] = "p";
			}
		}
		$data["flag"] = implode(",",$flag);
		$data["keywords"] = $_POST["keywords"];
		$data["color"] = $_POST["color"];
		$data["source"] = $_POST["source"];
		$data["writer"] = $_POST["writer"];
		$typeid = $_POST["typeid"];
		$service = new MyfService();
		if(!empty($typeid)){
			$arctype = $service->find_arctype_by_id($typeid);
			$data["typeid"]=$typeid;
			$data["typename"] = $arctype["typename"];
			if($arctype["typepro"]==1){
				$this->error("封面栏目不允许添加文章！");
				return;
			}
		}
		$data["description"] = $_POST["description"];
		$sendtime = $_POST["sendtime"];
		if(empty($sendtime)){
			$sendtime = date("Y-m-d H:i:s");
		}
		$data["sendtime"] = $sendtime;
		$data["click"] = $_POST["click"];
		$body = $_POST["editorValue"];
		$data["body"] = get_magic_quotes_gpc()?$body:addslashes($body);
		$id = $_POST["id"];
		$rowid = $service->update_archives($id, $data);
		if($rowid>0){
			$script_name = $_SERVER["SCRIPT_NAME"];
			$this->success("文章更新成功",$script_name."?m=Archives&a=main");
		}else{
			$this->error("文章更新失败");
		}
	}
	
	/**
	 * 上传缩略图
	 */
	public function uploadpic(){
		$upload = new UploadImage("file","Uploads/Arctives");
		$newName = $upload->newName();
		$upload->upload($newName);
		$html = "<script>parent.callback('".$upload->UpFile()."')</script>";
		echo $html;
	}
	
	/**
	 * 简单预览
	 */
	public function view(){
		$id = $_REQUEST["id"];
		$service = new MyfService();
		$arc = $service->find_archives_by_id($id);
		$arc["body"] = stripslashes($arc["body"]);
		$this->assign("arc",$arc);
		$this->display();
	}
	
	/**
	 * 更新文章属性
	 */
	public function update_pro(){
		$id = $_REQUEST["id"];
		$service = new MyfService();
		$archive = $service->find_archives_by_id($id);
		$flag = $archive["flag"];
		$this->assign("arc",$archive);
		if($flag){
			$flags = explode(",",$flag);
			if(in_array("h", $flags)){
				$this->assign("h","h");
			}
			if(in_array("c", $flags)){
				$this->assign("c","c");
			}
			if(in_array("f", $flags)){
				$this->assign("f","f");
			}
			if(in_array("a", $flags)){
				$this->assign("a","a");
			}
			if(in_array("s", $flags)){
				$this->assign("s","s");
			}
			if(in_array("b", $flags)){
				$this->assign("b","b");
			}
			if(in_array("p", $flags)){
				$this->assign("p","p");
			}
		}
		//栏目
		$arttypes = $service->find_all_arctype();
		//删除跳转栏目
		foreach($arttypes as $key=>$value){
			if($value["typepro"]==2){
				unset($arttypes[$key]);
			}
		}
		$this->assign("arttypes",$arttypes);
		$this->display();
	}
	
	/**
	 * 修改文章处理
	 */
	public function update_pro_handler(){
		$data = array();
		$data["title"] = htmlspecialchars($_POST["title"]);
		$flag = $_REQUEST["flags"];
		$data["flag"] = implode(",",$flag);
		$data["keywords"] = $_POST["keywords"];
		$data["source"] = $_POST["source"];
		$data["writer"] = $_POST["writer"];
		$typeid = $_POST["typeid"];
		$service = new MyfService();
		if(!empty($typeid)){
			$arctype = $service->find_arctype_by_id($typeid);
			$data["typeid"]=$typeid;
			$data["typename"] = $arctype["typename"];
			if($arctype["typepro"]==1){
				$this->error("封面栏目不允许添加文章！");
				return;
			}
		}
		$data["description"] = $_POST["description"];
		$id = $_POST["id"];
		$rowid = $service->update_archives($id, $data);
		if($rowid>0){
			$this->success("属性更新成功",$script_name."?m=Archives&a=main");
		}else{
			$this->error("文章更新失败");
		}
	}
	
	/**
	 * 删除文章
	 */
	public function delete(){
		$ids = $_REQUEST["arcid"];
		$service = new MyfService();
		$rows = $service->delete_archives($ids);
		if($rows>0){
			$script_name = $_SERVER["SCRIPT_NAME"];
			$this->success("文章删除成功",$script_name."?m=Archives&a=main");
		}else{
			$this->error("文章删除失败");
		}
	}
	
}


?>
	