<?php
// +----------------------------------------------------------------------
// | MyfCMS 闵益飞内容管理系统 [ 中国首家完全免费开源的PHPCMS ]
// +----------------------------------------------------------------------
// | Copyright (c) 2012 http://www.minyifei.cn All rights reserved.
// +----------------------------------------------------------------------
// | 交流论坛：http://bbs.minyifei.cn
// +----------------------------------------------------------------------

import("ORG.Util.Page");// 导入分页类
/**
 * 文章搜索列表页
 */
class SearchAction extends Action {
	
	public function index(){
		//频道编号
		$tid = htmlspecialchars($_REQUEST["tid"]);
		$keyword = htmlspecialchars($_REQUEST["keyword"]);
		
		$where = '1=1';
		if(!empty($tid) && $tid!=0){
			$where .= ' and typeid='.$tid;
		}
		
		if(!empty($keyword)){
			$where .= " and title like '%".$keyword."%'";
		}
		
		//第几页
		$p = $_REQUEST["p"];
		if(empty($p)){
			$p = 1;
		}
		$this->assign("p",$p);
		
		$this->assign("where",$where);
		$this->assign("keyword",$keyword);
		
		$search = array("searchkeyword"=>$keyword);
		if(C("MYFCMS_URLTYPE")=="static"){
			$search["searchurl"] = '__APP__/Search/';
		}else{
			$search["searchurl"] = '__APP__/index.php?m=Search&a=index';
		}
		$search["position"] = '<a href="__APP__/">首页</a><span class="split"> » </span>搜索';
		
		//当前模版
		$moban = $_COOKIE["think_template"];
		if(empty($moban)){
			$search["moban"] = "default";
		}else{
			$search["moban"] = $moban;
		}
		
		$this->assign("myfcms",$search);
		$this->display();
	}
	
	
}


?>