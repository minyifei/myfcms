<?php
// +----------------------------------------------------------------------
// | MyfCMS 闵益飞内容管理系统 [ 中国首家完全免费开源的PHPCMS ]
// +----------------------------------------------------------------------
// | Copyright (c) 2012 http://www.minyifei.cn All rights reserved.
// +----------------------------------------------------------------------
// | 交流论坛：http://bbs.minyifei.cn
// +----------------------------------------------------------------------


class IndexAction extends MyfAction {
	
    public function index(){
		$service = new MyfService();
		$sys = $service->find_sys_by_id(3);
		$this->assign("sys",$sys);
        $this->display();
    }
	
	public function top(){
		$user = $this->check_login();
		
		$this->assign("user",$user);
		$now = date("Y年m月d日");
		$weekarray=array("日","一","二","三","四","五","六");
		$week = "星期".$weekarray[date("w")];
		$this->assign("now",$now." ".$week);
		
		$m_sys = M("sys");
		$d_sys = $m_sys->where("id<3")->select();
		$h = "";
		foreach ($d_sys as $key => $value) {
			$h.=$value["value"];
		}
		$this->assign("htmlurl",$h."/index.php?m=Html&a=index");
		$this->assign("backhome",$h);
		
		$this->display();
	}
	
	public function left(){
		$m_sys = M("sys");
		$d_sys = $m_sys->where("id<3")->select();
		$h = "";
		foreach ($d_sys as $key => $value) {
			$h.=$value["value"];
		}
		$this->assign("htmlurl",$h."/index.php?m=Html&a=index");
		$this->display();
	}
	
	public function main(){
		$service = new MyfService();
		$arcs = $service->find_last_top_archives();
		$c_admin = $service->count_admin();
		$c_arc = $service->count_archives();
		$this->assign("c_arc",$c_arc);
		$this->assign("c_admin",$c_admin);
		$this->assign("arcs",$arcs);
		$this->assign("version",C("MYFCMS_VERSION"));
		$this->display();
	}
}