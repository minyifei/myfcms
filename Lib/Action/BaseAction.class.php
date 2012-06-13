<?php
// +----------------------------------------------------------------------
// | MyfCMS 闵益飞内容管理系统 [ 中国首家完全免费开源的PHPCMS ]
// +----------------------------------------------------------------------
// | Copyright (c) 2012 http://www.minyifei.cn All rights reserved.
// +----------------------------------------------------------------------
// | 交流论坛：http://bbs.minyifei.cn
// +----------------------------------------------------------------------


/**
 * 基础类
 */
import("@.Utils.File");
class BaseAction extends Action {
	
	protected function _base($name){
		if($name=="Archives"){
			$this->_archives();
		}else{
			$this->_list();
		}
	}
	
	/**
	 * 列表页基础信息
	 */
	protected function _list($action='',$typeid=''){
		$typedir = htmlspecialchars($_REQUEST["typedir"]);
		$id = htmlspecialchars($_REQUEST["id"]);
		$m_arctype = M("arctype");
		if($typedir && empty($id)){
			$ds = $m_arctype->where("typedir='".$typedir."'")->select();
			if($ds){
				$id = $ds[0]["id"];
			}			
		}
		if(!empty($typeid)){
			$id = $typeid;
		}
		
		$arctype = $m_arctype->find($id);
		$this->assign("selfid",$id);
		$this->assign("self",$arctype);
		
		//当前位置
		$position = '<a href="__APP__/">首页</a><span class="split"> » </span>';
		$topArctype = "";
		if($arctype["topid"]==0){
			$position .= $arctype["typename"];
		}else{
			$topArctype = $m_arctype->find($arctype["topid"]);
			$arctype["topArctype"] = $topArctype;
			if(C("MYFCMS_URLTYPE")=="static"){
				if($topArctype["typepro"]==2){
					$position .= '<a href="'.$topArctype["typedir"].'">'.$topArctype["typename"].'</a><span class="split"> » </span>'.$arctype["typename"];
				}else{
					$position .= '<a href="__APP__/'.$topArctype["classname"].'/'.$topArctype["typedir"].'-'.$topArctype["method"].'.html">'.$topArctype["typename"].'</a><span class="split"> » </span>'.$arctype["typename"];
				}
			}elseif(C("MYFCMS_URLTYPE")=="html"){
				// if($topArctype["typepro"]==2){
					// $position .= '<a href="'.$topArctype["typedir"].'">'.$topArctype["typename"].'</a><span class="split"> » </span>'.$arctype["typename"];
				// }else{
					// $position .= '<a href="__APP__/category/'.$topArctype["typedir"].'/'.$arcfix.'">'.$topArctype["typename"].'</a><span class="split"> » </span>'.$arctype["typename"];
				// }
			}else{
				if($topArctype["typepro"]==2){
					$position .= '<a href="'.$topArctype["typedir"].'">'.$topArctype["typename"].'</a><span class="split"> » </span>'.$arctype["typename"];
				}else{
					$position .= '<a href="__APP__/index.php?m='.$topArctype["classname"].'&a='.$topArctype["methodname"].'&id='.$topArctype["id"].'">'.$topArctype["typename"].'</a><span class="split"> » </span>'.$arctype["typename"];
				}
			}
		}
		$arctype["position"] = $position;
		if(C("MYFCMS_URLTYPE")=="static"){
			$arctype["searchurl"] = '__APP__/Search/';
		}else{
			$arctype["searchurl"] = '__APP__/index.php?m=Search&a=index';
		}
		
		//当前模版
		$moban = $_COOKIE["think_template"];
		if(empty($moban)){
			$arctype["moban"] = "default";
		}else{
			$arctype["moban"] = $moban;
		}
		
		

		$topChannelId = $arctype["topid"];		
		if($arctype["topid"]==0){
			$topChannelId = $arctype["id"];
		}
		
		$this->assign("topchannelid",$topChannelId);
		$this->assign("action",$action);
		
		if(C("MYFCMS_URLTYPE")=="html" && $action=="list_html"){
			$themes = C("MYFCMS_THEMES");
			$totalCount=M("archives")->where("typeid=".$id)->count(); 
			foreach ($themes as $key => $value) {
				$position = '<a href="__APP__/">首页</a><span class="split"> » </span>';
				$arcfix = "";
				if($value=="3g"){
					$arcfix = "g";
					$position = '<a href="__APP__/'.$value.'.html">首页</a><span class="split"> » </span>';
				}elseif($value=="touch"){
					$arcfix = "t";
					$position = '<a href="__APP__/'.$value.'.html">首页</a><span class="split"> » </span>';
				}
				$this->assign("arcfix",$arcfix);
				if(!empty($arcfix)){
					$arcfix.="/";
				}
				//生成静态栏目
				$methodname = $arctype["methodname"];
				$classname = $arctype["classname"];
				$typedir = $arctype["typedir"];
				$templateFile = "./Tpl/".$value."/".$classname."/".$methodname.".html";
				
				//获取模版中的分页
				$file = new File();
				$content = $file->read($templateFile);
				$content = str_replace("'", '""', $content);
				$pageSize = $this->get_str($content, 'pagesize="', '"');
				$pageSize = intval($pageSize);
				if(empty($pageSize)){
					$pageSize = 10;
				}
		    	$totalPage = ceil($totalCount/$pageSize);
				if($arctype["topid"]!=0){
					//位置
					if($topArctype["typepro"]==2){
						$position .= '<a href="'.$topArctype["typedir"].'/'.$arcfix.'">'.$topArctype["typename"].'</a><span class="split"> » </span>'.$arctype["typename"];
					}else{
						$position .= '<a href="__APP__/category/'.$topArctype["typedir"].'/'.$arcfix.'">'.$topArctype["typename"].'</a><span class="split"> » </span>'.$arctype["typename"];
					}
				}else{
					$position .= $arctype["typename"];
				}
				$arctype["position"] = $position;
				$this->assign("myfcms",$arctype);
				
		    	for($i=1;$i<=$totalPage;$i++){
			    	$Page = new Page($totalCount,$pageSize,'','__APP__/category/'.$typedir.'/'.$arcfix,$i);
			    	$show = $Page->show();// 分页显示输出
			    	$this->assign("show",$show);
			    	$this->assign("p",$i);    	
					$res = array("arcfix"=>$arcfix,"p"=>$i);
					// dump($res);
			    	$this->buildHtml($i,"category/".$typedir.'/'.$arcfix,$templateFile);
		    	}    
		    	
				//生成栏目首页
				$i=1;
				$Page = new Page($totalCount,$pageSize,'','__APP__/category/'.$typedir.'/'.$arcfix,$i);
		    	$show = $Page->show();// 分页显示输出
		    	$this->assign("show",$show);
		    	$this->assign("p",$i);    	
		    	$this->buildHtml("index","category/".$typedir.'/'.$arcfix,$templateFile);	
	    	}
		}else{
			//第几页
			$p = $_REQUEST["p"];
			if(empty($p)){
				$p = 1;
			}
			$this->assign("p",$p);
			$this->assign("myfcms",$arctype);
		}
		
	}
	
	/**
	 * 内容页基础信息
	 */
	protected function _archives($aid=''){
		$id = htmlspecialchars($_REQUEST["id"]);
		if(!empty($aid)){
			$id = $aid;
		}
		//获取当前文章
		$m_arc = D("Archives");
		$arc = $m_arc->relation(true)->find($id);
		$arc["body"] = stripslashes($arc["body"]);
		
		//上一篇
		$pre = $m_arc->relation(true)->where("typeid=".$arc["typeid"]." and id<".$arc["id"])->order("id desc")->limit(1)->select();
		if($pre && count($pre)>0){
			$pre = $pre[0];
			$arc["Prearc"] = $pre;
			if(C("MYFCMS_URLTYPE")=="static"){
				$arc["pre"] = '<a href="__APP__/'.$pre["Arctype"]["typedir"].'/'.$pre["Arctype"]["methodname"].'-'.$pre["id"].'.html">'.$pre["title"].'</a>';
			}elseif(C("MYFCMS_URLTYPE")=="html"){
				$arc["pre"] = '<a href="__APP__/archives/'.$pre["id"].'.html">'.$pre["title"].'</a>';
			}else{
				$arc["pre"] = '<a href="__APP__/index.php?m=Archives&a='.$pre["Arctype"]["methodname"].'&id='.$pre["id"].'">'.$pre["title"].'</a>';
			}
		}else{
			$arc["pre"] = "没有了";
		}
		
		//下一篇
		$next = $m_arc->relation(true)->where("typeid=".$arc["typeid"]." and id>".$arc["id"])->limit(1)->select();
		if($next && count($next)>0){
			$next = $next[0];
			$arc["Nextarc"] = $next;
			if(C("MYFCMS_URLTYPE")=="static"){
				$arc["next"] = '<a href="__APP__/'.$next["Arctype"]["typedir"].'/'.$next["Arctype"]["methodname"].'-'.$next["id"].'.html">'.$next["title"].'</a>';
			}elseif(C("MYFCMS_URLTYPE")=="html"){
				$arc["next"] = '<a href="__APP__/archives/'.$next["id"].'.html">'.$next["title"].'</a>';
			}else{
				$arc["next"] = '<a href="__APP__/index.php?m=Archives&a='.$next["Arctype"]["methodname"].'&id='.$next["id"].'">'.$next["title"].'</a>';
			}
		}else{
			$arc["next"] = "没有了";
		}
		
		//位置
		$arctype = $arc["Arctype"];
		$topArctype = array();
		$position = '<a href="__APP__/">首页</a><span class="split"> » </span>';
		if($arctype["topid"]==0){
			if(C("MYFCMS_URLTYPE")=="static"){
				$position .= '<a href="__APP__/'.$arctype["classname"].'/'.$arctype["typedir"].'-'.$arctype["methodname"].'.html">'.$arctype["typename"].'</a><span class="split"> » </span>正文';
			}elseif(C("MYFCMS_URLTYPE")=="html"){
				$position .= '<a href="__APP__/category/'.$arctype["typedir"].'">'.$arctype["typename"].'</a><span class="split"> » </span>正文';
			}else{
				$position .= '<a href="__APP__/index.php?m='.$arctype["classname"].'&a='.$arctype["methodname"].'&id='.$arctype["id"].'">'.$arctype["typename"].'</a><span class="split"> » </span>正文';
			}
		}else{
			$m_arctype = M("arctype");
			$topArctype = $m_arctype->find($arctype["topid"]);
			if(C("MYFCMS_URLTYPE")=="static"){
				$position .= '<a href="__APP__/'.$topArctype["classname"].'/'.$topArctype["typedir"].'-'.$topArctype["methodname"].'.html">'.$topArctype["typename"].'</a><span class="split"> » </span><a href="__APP__/'.$arctype["classname"].'/'.$arctype["typedir"].'-'.$arctype["methodname"].'.html">'.$arctype["typename"].'</a><span class="split"> » </span>正文';
			}elseif(C("MYFCMS_URLTYPE")=="html"){
				$position .= '<a href="__APP__/category/'.$topArctype["typedir"].'/">'.$topArctype["typename"].'</a><span class="split"> » </span><a href="__APP__/category/'.$arctype["typedir"].'/">'.$arctype["typename"].'</a><span class="split"> » </span>正文';
			}else{
				$position .= '<a href="__APP__/index.php?m='.$topArctype["classname"].'&a='.$topArctype["methodname"].'&id='.$topArctype["id"].'">'.$topArctype["typename"].'</a><span class="split"> » </span><a href="__APP__/index.php?m='.$arctype["classname"].'&a='.$arctype["methodname"].'&id='.$arctype["id"].'">'.$arctype["typename"].'</a><span class="split"> » </span>正文';
			}
		}
		$arc["position"] = $position;
		//搜索
		if(C("MYFCMS_URLTYPE")=="static"){
			$arc["searchurl"] = '__APP__/Search/';
		}else{
			$arc["searchurl"] = '__APP__/index.php?m=Search&a=index';
		}
		
		$topChannelId = $arctype["topid"];		
		if($arctype["topid"]==0){
			$topChannelId = $arctype["id"];
		}
		
		$m_sys = M("sys");
		$d_sys = $m_sys->find(1);
		$e_sys = $m_sys->find(2);
		//当前文章URL
		if(C("MYFCMS_URLTYPE")=="static"){
			$arc["arcurl"] = $d_sys["value"].$e_sys["value"].'__APP__/'.$arctype["typedir"]."/".$arctype["methodname"]."-".$arc["id"].".html";
		}else{
			$arc["arcurl"] = $d_sys["value"].$e_sys["value"].'__APP__/index.php?m=Archives&a='.$arctype["methodname"]."&id=".$arc["id"];
		}		
		
		$this->assign("topchannelid",$topChannelId);
		
		// $m_arc->where('id='.$id)->setInc('click',1); 
		
		//当前模版
		$moban = $_COOKIE["think_template"];
		if(empty($moban)){
			$arc["moban"] = "default";
		}else{
			$arc["moban"] = $moban;
		}
		
		$m_comment = M("comment");
		$comments = $m_comment->where("arcid=".$id)->order("id asc")->select();
		$arc["Comments"] = $comments;
		$this->assign("myfcms",$arc);
		
		//如果配置则生成html
		if(C("MYFCMS_URLTYPE")=="html"){
			$id = $_REQUEST["id"];
			if(!empty($aid)){
				$id = $aid;
			}
			//更新html状态
			$d = array("ishtml"=>1);
			$m_arc->where("id=".$id)->save($d);
			//生成3套模版html
			$themes = C("MYFCMS_THEMES");
			foreach ($themes as $key => $value) {
				$templateFile = "./Tpl/".$value."/Archives/".$arctype["methodname"].".html";
				$filename = $id;
				//生成文章列表时使用
				$arcfix = "";
				$position = '<a href="__APP__/">首页</a><span class="split"> » </span>';
				if($value=="3g"){
					$filename = "g".$id;
					$arcfix = "g";
					$position = '<a href="__APP__/'.$value.'.html">首页</a><span class="split"> » </span>';
				}else if($value == "touch"){
					$filename = "t".$id;
					$arcfix = "t";
					$position = '<a href="__APP__/'.$value.'.html">首页</a><span class="split"> » </span>';
				}
				//纠正位置
				if($arctype["topid"]==0){
					$position .= '<a href="__APP__/category/'.$arctype["typedir"].'/'.$arcfix.'">'.$arctype["typename"].'</a><span class="split"> » </span>正文';
				}else{
					$position .= '<a href="__APP__/category/'.$topArctype["typedir"].'/'.$arcfix.'">'.$topArctype["typename"].'</a><span class="split"> » </span><a href="__APP__/category/'.$arctype["typedir"].'/'.$arcfix.'">'.$arctype["typename"].'</a><span class="split"> » </span>正文';
				}
				$arc["position"] = $position;
				//纠正上一篇，下一篇链接
				if($arc["next"]!="没有了"){
					$arc["next"] = '<a href="__APP__/archives/'.$arcfix.$next["id"].'.html">'.$next["title"].'</a>';
				}
				if($arc["pre"]!="没有了"){
					$arc["pre"] = '<a href="__APP__/archives/'.$arcfix.$pre["id"].'.html">'.$pre["title"].'</a>';
				}
				$arc["arcurl"] = $d_sys["value"].$e_sys["value"].'__APP__/archives/'.$arcfix.$arc["id"].".html";
				$this->assign("myfcms",$arc);
				$this->assign("arcfix",$arcfix);
				$this->buildHtml($filename,"archives/",$templateFile);
			}
		}
		
	}

	/**
	 * 截取字符串
	 * @str 源内容
	 * @start_str 起始字符串
	 * @end_str 结束字符串
	 */
	private function get_str($str,$start_str,$end_str){
		$start_pos = strpos($str,$start_str)+strlen($start_str);
		$left_str = substr($str,0,$start_pos);
		$right_str = str_replace($left_str,"",$str); 
		$end_pos = strpos($right_str,$end_str,1);
		$content = substr($right_str,0,$end_pos);
		return $content;
	}
	
}


?>