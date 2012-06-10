<?php
// +----------------------------------------------------------------------
// | MyfCMS 闵益飞内容管理系统 [ 中国首家完全免费开源的PHPCMS ]
// +----------------------------------------------------------------------
// | Copyright (c) 2012 http://www.minyifei.cn All rights reserved.
// +----------------------------------------------------------------------
// | 交流论坛：http://bbs.minyifei.cn
// +----------------------------------------------------------------------

import("ORG.Util.Page");// 导入分页类
class CommentAction extends MyfAction{
	
	public function main(){
		$service = new MyfService();
		$pageCount = 10;
		$p = $_REQUEST["p"];
		if(empty($p)){
			$p = 1;
		}
		$arctitle = $_REQUEST["arctitle"];
		$filter ="";
		if(!empty($arctitle)){
			$filter = "arctitle like '%".$arctitle."%'";
		}
		$comments = $service->find_comment_by_page($p,$pageCount,$filter);
		$this->assign("comments",$comments);
		$count = $service->count_comment($filter);
		$page = new Page($count,$pageCount);
		$page_show = $page->show();
		$this->assign("page",$page_show);
		
		$this->assign("arctitle",$arctitle);
		
		$this->display();
	}
	
	public function update_handler(){
		$id = $_REQUEST["id"];
		$service = new MyfService();
		$rowid = $service->change_comment_state($id);
		if($rowid>0){
			$script_name = $_SERVER["SCRIPT_NAME"];
			$this->success("审核通过",$script_name."?m=Comment&a=main");
		}else{
			$this->error("审核失败");
		}
	}
	
	public function delete(){
		$ids = $_REQUEST["commentid"];
		$ids = implode(",",$ids);
		$service = new MyfService();
		$rowid = $service->delete_comments($ids);
		if($rowid>0){
			$script_name = $_SERVER["SCRIPT_NAME"];
			$this->success("删除成功",$script_name."?m=Comment&a=main");
		}else{
			$this->error("删除失败");
		}
	}
	
	
	public function delete_handler(){
		$id = $_REQUEST["id"];
		$service = new MyfService();
		$rowid = $service->delete_comment($id);
		if($rowid>0){
			$script_name = $_SERVER["SCRIPT_NAME"];
			$this->success("评论删除成功",$script_name."?m=Comment&a=main");
		}else{
			$this->error("评论删除失败");
		}
	}
	
}

?>