<?php
// +----------------------------------------------------------------------
// | MyfCMS 闵益飞内容管理系统 [ 中国首家完全免费开源的PHPCMS ]
// +----------------------------------------------------------------------
// | Copyright (c) 2012 http://www.minyifei.cn All rights reserved.
// +----------------------------------------------------------------------
// | 交流论坛：http://bbs.minyifei.cn
// +----------------------------------------------------------------------

/**
 * 页面静态化类
 */
import("ORG.Util.Page");// 导入分页类
header("Content-type: text/html; charset=utf-8");
class HtmlAction extends MyfAction {
	
	public function index(){
		
		$dir = dirname(dirname(dirname(__FILE__)))."/";
		
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
		
		// //生成首页
		$themes = C("MYFCMS_THEMES");
		foreach ($themes as $key => $value) {
			$templateFile = "./Tpl/".$value."/Index/index.html";
			$filename = "index";
			$arcfix = "";
			if($value=="3g"){
				$filename = "3g";
				$arcfix = "g";
			}else if($value == "touch"){
				$filename = "touch";
				$arcfix = "t";
			}
			
			$this->assign("arcfix",$arcfix);
			$this->buildHtml($filename,$dir,$templateFile);
		}
		
		$m_sys = M("sys");
		$d_sys = $m_sys->where("id<3")->select();
		$h = "";
		foreach ($d_sys as $key => $value) {
			$h.=$value["value"];
		}
		$this->success("首页生成完成 ",$h);	
	}
	
	public function archive(){
		$typeid = $_REQUEST['typeid'];
		$startId = $_REQUEST["startId"];
		$endId = $_REQUEST["endId"];
		$id = $_REQUEST["id"];
		if(empty($id)){
			$where = "";
			if($typeid!=0){
				$typeids = "0";
				$m_type = M("arctype");
				$arctypes = $m_type->field("id")->where("(id=".$typeid." or topid=".$typeid.") and typepro!=2")->select();
				foreach ($arctypes as $key => $value) {
					$typeids.=",".$value["id"];
				}
				$where = "typeid in(".$typeids.")";
			}else{
				$where = "0=0 ";
				if(!empty($startId)){
					$where.=" and id>=".$startId;
				}
				if(!empty($endId)){
					$where.= " and id<=".$endId;
				}
			}
			
			$res = array();
			$num = 0;
			$m_arc = M("archives");
			$arcs = $m_arc->field("id,title")->where($where)->select();
			foreach ($arcs as $key => $value) {
				$id = $value["id"];
				$title = $value["title"];
				$this->_archives($id);
				$num++;
				$res[] = $title;
			}
			$res[] = $num." 篇文章生成完成！";
			dump($res);
		}else{
			$this->_archives($id);
			echo "over";
		}
		
	}
	
	public function lists(){
		$id = $_REQUEST['id'];
		$upnext = $_REQUEST['upnext'];
		$res = array();
		$num = 0;
		$where = "";
		if($id==0){
			$where = "typepro!=2";
		}else{
			if($upnext==1){
				$where = "(id=".$id." or topid=".$id.") and typepro!=2";
			}else{
				$where = "id=".$id." and typepro!=2";
			}
		}
		$m_type = M("arctype");
		$arctypes = $m_type->where($where)->select();
		foreach ($arctypes as $key => $value) {
			$id = $value["id"];
			$this->_list("list_html",$id);
			$res[]="成功生成【".$value["typename"]."】";
			$num++;
		}
		$res[] = $num." 个栏目生成完毕！";
		dump($res);
	}
	
	
}

?>