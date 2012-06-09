<?php
// +----------------------------------------------------------------------
// | MyfCMS 闵益飞内容管理系统 [ 中国首家完全免费开源的PHPCMS ]
// +----------------------------------------------------------------------
// | Copyright (c) 2012 http://www.minyifei.cn All rights reserved.
// +----------------------------------------------------------------------
// | 交流论坛：http://bbs.minyifei.cn
// +----------------------------------------------------------------------

header("Content-type: text/html; charset=utf-8");
import('@.Utils.Snoopy');
import('@.Utils.WebCrawl');
import('@.Utils.SimpleDom');
import("ORG.Util.Page");// 导入分页类
/**
 * 采集相关
 */
class CollectAction extends MyfAction {
	
	public function main(){
		$service = new MyfService();
		$p = $_REQUEST["p"];
		if(empty($p)){
			$p=1;
		}
		$pagecount = 20;
			//组织分页
		$count = $service->count_conode();
		$page = new Page($count,$pageCount);
		$page_show = $page->show();
		$this->assign("page",$page_show);
		
		$list = $service->find_conode_by_page($page);
		$this->assign("list",$list);
		$this->display();
	}
	
	public function add(){
		$this->display();
	}
	
	public function add_handler(){
		$url = $_REQUEST["listurl"];
		$conurl = $_REQUEST["conurl"];
		$start_str = stripslashes($_REQUEST["liststart"]);
		$end_str = stripslashes($_REQUEST["listend"]);
		$link_include_str = stripslashes($_REQUEST["linkinc"]);
		$link_not_include_str = stripslashes($_REQUEST["linknot"]);
		$title_start = stripslashes($_REQUEST["title_start"]);
		$title_end = stripslashes($_REQUEST["title_end"]);
		$keyword_start = stripslashes($_REQUEST["keyword_start"]);
		$keyword_end = stripslashes($_REQUEST["keyword_end"]);
		$desc_start = stripslashes($_REQUEST["desc_start"]);
		$desc_end = stripslashes($_REQUEST["desc_end"]);
		$source_start = stripslashes($_REQUEST["source_start"]);
		$source_end = stripslashes($_REQUEST["source_end"]);
		$time_start = stripslashes($_REQUEST["time_start"]);
		$time_end = stripslashes($_REQUEST["time_end"]);
		$con_start = stripslashes($_REQUEST["content_start"]);
		$con_end = stripslashes($_REQUEST["content_end"]);
		$filter = $_REQUEST["filter"];
		$data = array();
		$data["name"] = htmlspecialchars($_REQUEST["name"]);
		$data["listurl"] = $url;
		$data["liststart"] = $start_str;
		$data["listend"] = $end_str;
		$data["linkinc"] = $link_include_str;
		$data["linknot"] = $link_not_include_str;
		$data["titlestart"] = $title_start;
		$data["titleend"] = $title_end;
		$data["keywordstart"] = $keyword_start;
		$data["keywordend"] = $keyword_end;
		$data["descstart"] = $desc_start;
		$data["descend"] = $desc_end;
		$data["sourcestart"] = $source_start;
		$data["sourceend"] = $source_end;
		$data["timestart"] = $time_start;
		$data["timeend"] = $time_end;
		$data["contstart"]  = $con_start;
		$data["contend"] = $con_end;
		$data["filterstr"] = implode(",",$filter);;
		$data["conurl"] = $conurl;
		
		$service = new MyfService();
		$rowid = $service->add_conode($data);
		if($rowid>0){
			$script_name = $_SERVER["SCRIPT_NAME"];
			$this->success("采集节点添加成功",$script_name."?m=Collect&a=main");
		}else{
			$this->error("采集节点添加失败");
		}
	}

	public function update(){
		$id = $_REQUEST["id"];
		$service = new MyfService();
		$node = $service->find_conode_by_id($id);
		$this->assign("node",$node);
		//过滤条件
		$filter = "###".$node["filterstr"];
		if(strpos($filter, "div_r")>0){
			$this->assign("div_r","true");
		}
		if(strpos($filter, "div_l")>0){
			$this->assign("div_l","true");
		}
		if(strpos($filter, "a")>0){
			$this->assign("a","true");
		}
		if(strpos($filter, "js")>0){
			$this->assign("js","true");
		}
		if(strpos($filter, "iframe")>0){
			$this->assign("iframe","true");
		}
		if(strpos($filter, "style")>0){
			$this->assign("style","true");
		}
		
		$this->display();
	}
	
	public function update_handler(){
		$id = $_REQUEST["id"];
		$url = $_REQUEST["listurl"];
		$conurl = $_REQUEST["conurl"];
		$start_str = stripslashes($_REQUEST["liststart"]);
		$end_str = stripslashes($_REQUEST["listend"]);
		$link_include_str = stripslashes($_REQUEST["linkinc"]);
		$link_not_include_str = stripslashes($_REQUEST["linknot"]);
		$title_start = stripslashes($_REQUEST["title_start"]);
		$title_end = stripslashes($_REQUEST["title_end"]);
		$keyword_start = stripslashes($_REQUEST["keyword_start"]);
		$keyword_end = stripslashes($_REQUEST["keyword_end"]);
		$desc_start = stripslashes($_REQUEST["desc_start"]);
		$desc_end = stripslashes($_REQUEST["desc_end"]);
		$source_start = stripslashes($_REQUEST["source_start"]);
		$source_end = stripslashes($_REQUEST["source_end"]);
		$time_start = stripslashes($_REQUEST["time_start"]);
		$time_end = stripslashes($_REQUEST["time_end"]);
		$con_start = stripslashes($_REQUEST["content_start"]);
		$con_end = stripslashes($_REQUEST["content_end"]);
		$filter = $_REQUEST["filter"];
		$data = array();
		$data["name"] = htmlspecialchars($_REQUEST["name"]);
		$data["listurl"] = $url;
		$data["liststart"] = $start_str;
		$data["listend"] = $end_str;
		$data["linkinc"] = $link_include_str;
		$data["linknot"] = $link_not_include_str;
		$data["titlestart"] = $title_start;
		$data["titleend"] = $title_end;
		$data["keywordstart"] = $keyword_start;
		$data["keywordend"] = $keyword_end;
		$data["descstart"] = $desc_start;
		$data["descend"] = $desc_end;
		$data["sourcestart"] = $source_start;
		$data["sourceend"] = $source_end;
		$data["timestart"] = $time_start;
		$data["timeend"] = $time_end;
		$data["contstart"]  = $con_start;
		$data["contend"] = $con_end;
		$data["filterstr"] = implode(",",$filter);
		$data["conurl"] = $conurl;
		
		$service = new MyfService();
		$rowid = $service->update_conode($id, $data);
		if($rowid>0){
			$script_name = $_SERVER["SCRIPT_NAME"];
			$this->success("采集节点更新成功",$script_name."?m=Collect&a=main");
		}else{
			$this->error("采集节点更新失败");
		}
	}

	/**
	 * 采集节点
	 */
	public function do_collect(){
		$id = $_REQUEST["id"];
		$service = new MyfService();
		$node = $service->find_conode_by_id($id);
		$this->assign("node",$node);
		$this->display();
	}
	
	/**
	 * 采集列表
	 */
	public function do_collect_handler(){
		$id = $_REQUEST["id"];
		$pn = $_REQUEST["npid"];
		$service = new MyfService();
		$node = $service->find_conode_by_id($id);
		$msg = array("code"=>0,"info"=>"采集失败");
		
		if($pn==0){//下载种子网址的未下载内容
			$cohtmls = $service->find_cohtml_by_nodeid_nofrished($id);
			if($cohtmls && count($cohtmls)>0){
				$arcs = array();
				foreach ($cohtmls as $key => $value) {
					$d = array("href"=>$value["url"],"title"=>"种子编号：".$value["id"],"hid"=>$value["id"]);
					$arcs[] = $d;
				}
				$msg["code"] = 1;
				$msg["info"] = $arcs;
			}
		}else{
			
			if($pn==-1){//重新下载
				$service->delete_cohtml_by_nodeid($id);
			}
			
			if($node){
				$url = $node["listurl"];
				$start_str = $node["liststart"];
				$end_str = $node["listend"];
				$link_include_str = $node["linkinc"];
				$link_not_include_str = $node["linknot"];
				$webCrawl = new WebCrawl($url);
				$res = $webCrawl->getWebContent();
				$listContent = $this->get_str($res, $start_str, $end_str);
				$links = $this->get_links($listContent,$link_include_str,$link_not_include_str,$url);
				
				$now = date("Y-m-d H:i:s");
				//更新最后采集时间
				$ndata = array("lasttime"=>$now);
				$service->update_conode($id, $ndata);
				
				if($links && count($links)>0){
					$arcs = array();
					foreach ($links as $key => $value) {
						$data = array();
						$data["nid"] = $node["id"];
						$data["nname"] = $node["name"];
						$data["url"] = $value["href"];
						$data["createtime"] = $now;
						$hid = $service->add_cohtml($data);
						if($hid>0){
							$value["hid"] = $hid;
							$arcs[] = $value;
						}
					}
					$msg["code"] = 1;
					$msg["info"] = $arcs;
				}
			}
		}
		echo json_encode($msg);
		
	}

	/**
	 * 采集内容
	 */
	public function collect_cohtml_handler(){
		$id = $_REQUEST["hid"];
		$service = new MyfService();
		$cohtml = $service->find_cohtml_by_id($id);
		$nid = $cohtml["nid"];
		$conode = $service->find_conode_by_id($nid);
		$url = $cohtml["url"];
		$arc = array();
		$webCrawl = new WebCrawl($url);
		$res = $webCrawl->getWebContent();
		$msg = array("code"=>0,"info"=>"采集失败");
		if($res){
			$title_start = $conode["titlestart"];
			$title_end = $conode["titleend"];
			$keyword_start = $conode["keywordstart"];
			$keyword_end = $conode["keywordend"];
			$desc_start = $conode["descstart"];
			$desc_end = $conode["descend"];
			$source_start = $conode["sourcestart"];
			$source_end = $conode["sourceend"];
			$time_start = $conode["timestart"];
			$time_end = $conode["timeend"];
			$con_start = $conode["contstart"];
			$con_end = $conode["contend"];
			$filter = explode(",",$conode["filterstr"]);
			
			$info = $webCrawl->getWebinfo();
			$arc["title"] = $this->get_str($res, $title_start, $title_end);
			//关键字
			if(!empty($keyword_start) && empty($keyword_end)){
				$arc["keywords"] = $keyword_start;
			}elseif(!empty($keyword_start) && !empty($keyword_end)){
				$arc["keywords"] = $this->get_str($res, $keyword_start, $keyword_end);
			}elseif(empty($keyword_start) && empty($keyword_end)){
				$arc["keywords"] = $info["keywords"];
			}
			//描述
			if(!empty($desc_start) && empty($desc_end)){
				$arc["description"] = $desc_start;
			}elseif(!empty($desc_start) && !empty($desc_end)){
				$arc["description"] = $this->get_str($res, $desc_start, $desc_end);
			}elseif(empty($desc_start) && empty($desc_end)){
				$arc["description"] = $info["desc"];
			}
			//来源
			if(!empty($source_start) && empty($source_end)){
				$arc["source"] = $source_start;
			}elseif(!empty($source_start) && !empty($source_end)){
				$arc["source"] = $this->get_str($res, $source_start, $source_end);
			}
			//时间
			if(!empty($time_start) && empty($time_end)){
				$arc["sendtime"] = $time_start;
			}elseif(!empty($time_start) && !empty($time_end)){
				$arc["sendtime"] = $this->get_str($res, $time_start, $time_end);
			}elseif(empty($time_start) && empty($time_end)){
				$arc["sendtime"] = date("Y-m-d H:s:i");
			}
			//内容
			$content = $this->get_str($res, $con_start, $con_end);
			$content = $this->get_content($content, $url);
			$content = $this->filter_str($content,$filter);
			$content=str_replace("\n","",$content);
			$content=str_replace("\r","",$content);
			$content=str_replace("\r\n","",$content);
			$arc["body"] = addslashes($content);
			$arc["isdown"] = 1;
			
			$rowid = $service->update_cohtml($id, $arc);
			if($rowid>0){
				$msg["code"] = 1;
				$msg["info"] = "内容成功采集";
			}			
		}
		echo json_encode($msg);
	}

	public function do_export(){
		$id = $_REQUEST["id"];
		$service = new MyfService();
		$node = $service->find_conode_by_id($id);
		$this->assign("node",$node);
		
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
	
	public function do_export_handler(){
		$id = $_REQUEST["id"];	
		$typeid = $_POST["typeid"];
		$np = $_POST["np"];
		$service = new MyfService();
		$arctype = $service->find_arctype_by_id($typeid);
		if(!empty($typeid) && $arctype){
			if($arctype["typepro"]==1){
				$this->error("封面栏目不允许添加文章！");
				return;
			}
		}
		
		$filter = "nid=".$id." and isexport=0 and isdown=1";
		$isFilterTitle = false;
		if($np==-1){
			$filter = "nid=".$id." and isdown=1";
		}else{
			$isFilterTitle = true;
		}
		
		$cohtml_d = $service->find_cohtml_filter($filter);
		$acount = 0;
		foreach ($cohtml_d as $key => $value) {
			$d = array();
			$d["typeid"] = $typeid;
			$d["title"] = htmlspecialchars($value["title"]);
			$d["keywords"] = htmlspecialchars($value["keywords"]);
			$d["description"] = $value["description"];
			$d["source"] = htmlspecialchars($value["source"]);
			$d["sendtime"] = $value["sendtime"];
			$d["body"] = $value["body"];
			$d["typename"] = $arctype["typename"];
			$d["adminid"] = $this->loginUser["id"];
			$d["adminname"] = $this->loginUser["uname"];
			
			$isOk = true;
			if($isFilterTitle){
				$where = "title='".$d["title"]."'";
				$count = $service->count_archives($where);
				if($count>0){
					$isOk = false;
				}
			}
			
			if($isOk){
				$aid = $service->add_archives($d);
				if($aid>0){
					$acount++;
					$dh = array("isexport"=>1);
					$did = $value["id"];
					$service->update_cohtml($did, $dh);
				}
			}
		}
		$msg = "共有[".$acount."]篇文章导入成功!";
		$script_name = $_SERVER["SCRIPT_NAME"];
		$this->success($msg,$script_name."?m=Collect&a=main");		
	}
	
	/**
	 * 删除采集节点
	 */
	public function delete_handler(){
		$id = $_REQUEST["id"];
		$service = new MyfService();
		$rowid = $service->delete_conode($id);
		if($rowid>0){
			$service->delete_cohtml_by_nodeid($id);
		}
		$msg = "节点删除成功！";
		$script_name = $_SERVER["SCRIPT_NAME"];
		$this->success($msg,$script_name."?m=Collect&a=main");
	}
	
	/**
	 * 清空采集节点数据
	 */
	public function cleardata(){
		$id = $_REQUEST["id"];
		$service = new MyfService();
		$service->delete_cohtml_by_nodeid($id);
		$msg = "节点数据已经清空！";
		$script_name = $_SERVER["SCRIPT_NAME"];
		$this->success($msg,$script_name."?m=Collect&a=main");
	}
	
	
	/**
	 * 测试列表页链接采集
	 */
	public function test_list_handler(){
		$links = $this->get_param_links();
		dump($links);
	}
	
	/**
	 * 测试获取内容
	 */
	public function test_Content(){
		$url = $_REQUEST["url"];
		dump($url);
		$webCrawl = new WebCrawl($url);
		$res = $webCrawl->getWebContent();
		dump($res);
	}
	
	/**
	 * 测试内容采集
	 */
	public function test_arc_handler(){
		$arc = $this->get_archive_info();
		dump($arc);
	}
	
	/**
	 * 获取列表页文章链接
	 */
	public function get_param_links(){
		$url = $_REQUEST["listurl"];
		$start_str = stripslashes($_REQUEST["liststart"]);
		$end_str = stripslashes($_REQUEST["listend"]);
		$link_include_str = stripslashes($_REQUEST["linkinc"]);
		$link_not_include_str = stripslashes($_REQUEST["linknot"]);
		$webCrawl = new WebCrawl($url);
		$res = $webCrawl->getWebContent();
		$links = null;
		if($res){
			$listContent = $this->get_str($res, $start_str, $end_str);
			$links = $this->get_links($listContent,$link_include_str,$link_not_include_str,$url);
		}
		return $links;
	}
	
	/**
	 * 获取内容信息
	 */
	public function get_archive_info(){
		$url = $_REQUEST["conurl"];
		$title_start = stripslashes($_REQUEST["title_start"]);
		$title_end = stripslashes($_REQUEST["title_end"]);
		$keyword_start = stripslashes($_REQUEST["keyword_start"]);
		$keyword_end = stripslashes($_REQUEST["keyword_end"]);
		$desc_start = stripslashes($_REQUEST["desc_start"]);
		$desc_end = stripslashes($_REQUEST["desc_end"]);
		$source_start = stripslashes($_REQUEST["source_start"]);
		$source_end = stripslashes($_REQUEST["source_end"]);
		$time_start = stripslashes($_REQUEST["time_start"]);
		$time_end = stripslashes($_REQUEST["time_end"]);
		$con_start = stripslashes($_REQUEST["content_start"]);
		$con_end = stripslashes($_REQUEST["content_end"]);
		$filter = $_REQUEST["filter"];
		
		$arc = array();
		$webCrawl = new WebCrawl($url);
		$res = $webCrawl->getWebContent();
		if($res){
			$info = $webCrawl->getWebinfo();
			$arc["title"] = $this->get_str($res, $title_start, $title_end);
			//关键字
			if(!empty($keyword_start) && empty($keyword_end)){
				$arc["keywords"] = $keyword_start;
			}elseif(!empty($keyword_start) && !empty($keyword_end)){
				$arc["keywords"] = $this->get_str($res, $keyword_start, $keyword_end);
			}elseif(empty($keyword_start) && empty($keyword_end)){
				$arc["keywords"] = $info["keywords"];
			}
			//描述
			if(!empty($desc_start) && empty($desc_end)){
				$arc["description"] = $desc_start;
			}elseif(!empty($desc_start) && !empty($desc_end)){
				$arc["description"] = $this->get_str($res, $desc_start, $desc_end);
			}elseif(empty($desc_start) && empty($desc_end)){
				$arc["description"] = $info["desc"];
			}
			//来源
			if(!empty($source_start) && empty($source_end)){
				$arc["source"] = $source_start;
			}elseif(!empty($source_start) && !empty($source_end)){
				$arc["source"] = $this->get_str($res, $source_start, $source_end);
			}
			//时间
			if(!empty($time_start) && empty($time_end)){
				$arc["sendtime"] = $time_start;
			}elseif(!empty($time_start) && !empty($time_end)){
				$arc["sendtime"] = $this->get_str($res, $time_start, $time_end);
			}elseif(empty($time_start) && empty($time_end)){
				$arc["sendtime"] = date("Y-m-d H:s:i");
			}
			//内容
			$content = $this->get_str($res, $con_start, $con_end);
			$content = $this->get_content($content, $url);
			$arc["content"] = $this->filter_str($content,$filter);
		}
		return $arc;
	}
	
	
	public function add_node(){
		$webCrawl = new WebCrawl($url);
		$res = $webCrawl->getWebContent();
		$start_str = '<div class="block article_list">';
		$end_str = '</ul>';
		$listContent = $this->get_str($res, $start_str, $end_str);
		$link_include_str = null;
		$link_not_include_str = "list.php";
		$links = $this->get_links($listContent,$link_include_str,$link_not_include_str,$url);
		dump($links);
	}
	
	public function add_content(){
		$url = "http://www.chinaz.com/manage/2012/0514/251534.shtml";
		$url = "http://www.chinaz.com/website/2012/0221/236308.shtml";
		$webCrawl = new WebCrawl($url);
		$res = $webCrawl->getWebContent();
		$archive = array();
		$title_start_str = "<title>";
		$title_end_str = "</title>";
		$title = $this->get_str($res, $title_start_str, $title_end_str);
		$archive["title"] = $title;
		$sendtime_start_str = '<span class="article-published">';
		$sendtime_end_str = '</span>';
		$sendtime = $this->get_str($res, $sendtime_start_str, $sendtime_end_str);
		$archive["sendtime"] = $sendtime;
		$source_start_str = '<span class="article-source">';
		$source_end_str = '</span>';
		$source = $this->get_str($res, $source_start_str, $source_end_str);
		$archive["source"] = $source;
		$con_start_str = '<div class="content cont-detail fs-small" id="ctrlfscont">';
		$con_end_str ='</div>';
		$content = $this->get_str($res, $con_start_str, $con_end_str);
		$archive["content"] = $this->filter_str($content);
		dump($archive);
		dump($res);
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
	
	/**
	 * 过滤字符串
	 */
	private function filter_str($str,$filter=array()){
		if(in_array("div_r", $filter)){
			$div_str = '</div>';
			$str = str_replace($div_str, "", $str);
		}
		if(in_array("div_l",$filter)){
			$div_l_str = '/<div(?:.*?)>/is';
			$str = preg_replace($div_l_str, "", $str);
		}
		if(in_array("a",$filter)){
			$a_pat='/<a(?:.*?)>(.*?)<\/a>/is';
			$str = preg_replace($a_pat,'',$str);
		}
		if(in_array("js",$filter)){
			$js_pat ='/<script(?:.*?)>(.*?)<\/script>/is';
			$str = preg_replace($js_pat,'',$str);
		}
		if(in_array("iframe",$filter)){
			$iframe_pat ='/<iframe(?:.*?)>(.*?)<\/iframe>/is';
			$str = preg_replace($iframe_pat,'',$str);
		}
		if(in_array("style",$filter)){
			$style_pat ='/<style(?:.*?)>(.*?)<\/style>/is';
			$str = preg_replace($style_pat,'',$str);
		}
		return $str;
	}
	
	/**
	 * 获取内容，补全图片链接
	 */
	private function get_content($str,$uri){
		$dom = new SimpleDom();
		$html = $dom->str_get_html($str);
		if($html){
			$snoopy = new Snoopy();
			$imgs = $html->find('img');
			for($i=0;$i<count($imgs);$i++){
				$e = $imgs[$i];
				$src = $e->getAttribute("src");
				$srco = $snoopy->_expandlinks($src, $uri);
				$str = str_replace($src, $srco, $str);
			}
		}
		return $str;
	}
	
	/**
	 * 获取链接
	 */
	private function get_links($str,$include_str=null,$not_include_str=null,$uri=null){
		$dom = new SimpleDom();
		$html = $dom->str_get_html($str);
		if($html){
			$snoopy = new Snoopy();
			$as = $html->find('a');
			$links = array();
			for($i=0;$i<count($as);$i++){
				$e = $as[$i];
				$link = array();
				$href = null;
				$text = $e->innertext();
				if(empty($include_str)){
					$href = $e->getAttribute("href");
				}else{
					$href = $e->getAttribute("href");
					if(strpos("######".$href,$include_str)<1){
						$href = null;
					}
				}
				if(!empty($not_include_str) && !empty($href)){
					if(strpos("######".$href,$not_include_str)>0 || strpos("######".$text,$not_include_str)>0){
						$href = null;
					}
				}
				
				if(!empty($href)){
					if(empty($uri)){
						$link["href"] = $href;
					}else{
						$link["href"] = $snoopy->_expandlinks($href, $uri);
					}
					$link["title"] = $e->innertext();
					$links[] = $link;	
				}
			}    
			return $links;
		}else{
			return null;
		}
		
	}
	
	 // 计算中文字符串长度
	private	function utf8_strlen($string = null) {
		// 将字符串分解为单元
		preg_match_all("/./us", $string, $match);
		// 返回单元个数
		return count($match[0]);
	}
	
	public function test_a(){
		$service = new MyfService();
		$arc = $service->find_archives_by_id(1);
		dump($arc);
		
		$cohtml = $service->find_cohtml_by_id(314);
		$body= $cohtml["body"];
		$body=str_replace("\n","",$body);
		$body=str_replace("\r","",$body);
		$body=str_replace("\r\n","",$body);
		$cohtml = $body;
		dump($cohtml);
	}
}


?>