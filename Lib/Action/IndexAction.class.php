<?php
// +----------------------------------------------------------------------
// | MyfCMS 闵益飞内容管理系统 [ 中国首家完全免费开源的PHPCMS ]
// +----------------------------------------------------------------------
// | Copyright (c) 2012 http://www.minyifei.cn All rights reserved.
// +----------------------------------------------------------------------
// | 交流论坛：http://bbs.minyifei.cn
// +----------------------------------------------------------------------

header("Content-Type:text/html; charset=utf-8");
class IndexAction extends Action {
	
    public function index(){
		
    	$pd = array("position"=>"首页");
		
		if(C("MYFCMS_URLTYPE")=="static"){
			$pd["searchurl"] = '__APP__/Search/';
		}else{
			$pd["searchurl"] = '__APP__/index.php?m=Search&a=index';
		}
		//当前模版
		$moban = $_COOKIE["think_template"];
		if(empty($moban)){
			$pd["moban"] = "default";
		}else{
			$pd["moban"] = $moban;
		}
		
		$this->assign("myfcms",$pd);
    	$this->display();
    }
}