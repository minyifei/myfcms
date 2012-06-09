<?php
// +----------------------------------------------------------------------
// | MyfCMS 闵益飞内容管理系统 [ 中国首家完全免费开源的PHPCMS ]
// +----------------------------------------------------------------------
// | Copyright (c) 2012 http://www.minyifei.cn All rights reserved.
// +----------------------------------------------------------------------
// | 交流论坛：http://bbs.minyifei.cn
// +----------------------------------------------------------------------

import('@.Utils.Snoopy');
import('@.Utils.WebCrawl');

class HtmlAction extends MyfAction {
	
	public function category(){
		$service = new MyfService();
		$arttypes = $service->find_all_arctype();
		//删除跳转栏目
		foreach($arttypes as $key=>$value){
			if($value["typepro"]==2){
				unset($arttypes[$key]);
			}
		}
		$this->assign("arttypes",$arttypes);
		
		$m_sys = M("sys");
		$d_sys = $m_sys->where("id<3")->select();
		$h = "";
		foreach ($d_sys as $key => $value) {
			$h.=$value["value"];
		}
		$url = $h."/index.php?m=Html&a=lists";	
		$this->assign("url",$url);
		
		$this->display();
	}
	
	
	public function archives(){
		$service = new MyfService();
		$arttypes = $service->find_all_arctype();
		//删除跳转栏目
		foreach($arttypes as $key=>$value){
			if($value["typepro"]==2){
				unset($arttypes[$key]);
			}
		}
		$this->assign("arttypes",$arttypes);
		
		$m_sys = M("sys");
		$d_sys = $m_sys->where("id<3")->select();
		$h = "";
		foreach ($d_sys as $key => $value) {
			$h.=$value["value"];
		}
		$url = $h."/index.php?m=Html&a=archive";	
		$this->assign("url",$url);
		
		$this->display();
	}
	
}


?>