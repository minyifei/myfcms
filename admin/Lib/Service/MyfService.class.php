<?php
// +----------------------------------------------------------------------
// | MyfCMS 闵益飞内容管理系统 [ 中国首家完全免费开源的PHPCMS ]
// +----------------------------------------------------------------------
// | Copyright (c) 2012 http://www.minyifei.cn All rights reserved.
// +----------------------------------------------------------------------
// | 交流论坛：http://bbs.minyifei.cn
// +----------------------------------------------------------------------



import("@.Dao.MyfDao");
import("@.Utils.File");

class MyfService{
	
	/**
	 * 获取所有栏目列表
	 */
	public function find_all_arctype(){
		$dao = new MyfDao();
		//查询所有栏目
		$d_arctypes = $dao->find_all_arctype();
		$top_arctypes = $this->select_arctype($d_arctypes, 0);
		foreach($top_arctypes as $key =>$value){
			$topid = $value["id"];
			$top_arctypes[$key]["childs"] = $this->select_arctype($d_arctypes, $topid);
		}
		return $top_arctypes;
	}
	
	/**
	 * 查询子栏目
	 */
	public function find_arctype_by_topid($topid){
		$dao = new MyfDao();
		return $dao->find_all_arctype("topid=".$topid);
	}
	
	
	public function find_arctype_by_id($id){
		$dao = new MyfDao();
		return $dao->find_arctype_by_id($id);
	}
	
	/**
	 * 栏目筛选数据
	 */
	private function select_arctype($arr,$topid){
		$res = array();
		foreach($arr as $key=>$d){
			if($d["topid"]==$topid){
				$res[] = $d;
			}
		}
		return $res;
	}
	/**
	 * 添加栏目
	 */
	public function add_arctype($data){
		$dao = new MyfDao();
		$rowid = $dao->add_arctype($data);
		if($rowid>0){
			if($data["methodname"]!="index"){
				$dir = dirname(dirname(dirname(dirname(__FILE__))));
				$filename = $dir."/Lib/Action/MyfAction.class.php";
				$methodname = $data["methodname"];
				$classname = $data["classname"];
				$typename = $data["typename"];
				$file = new File();
				$content = $file->read($filename);
				//增加方法
				if(strrpos($content, "public function ".$methodname."()")<1){
					$method = '
	/*'.$methodname.'-start*/
	public function '.$methodname.'(){
		$name = $this->getActionName();
		$this->_base($name);
		$this->display();
	}
	/*'.$methodname.'-end*/
	
	/*new method*/
					';
					$content = str_replace("/*new method*/", $method, $content);
					$isok = $file->write($filename, $content);
					//如果成功添加模版
					if($isok){
						$mname = "-列表页";
						if($classname=="Cover"){
							$mname = "-列表封面页";
						}
						$themes = array("default","3g","2g","touch");
						foreach ($themes as $key => $value) {
							$d = array("pathname"=>$classname,"filename"=>$methodname,"theme"=>$value,"themetype"=>1,"info"=>$value."-".$typename.$mname."模版","content"=>"");
							$newFilename = $dir.'/Tpl/'.$value."/".$classname."/".$methodname.".html";
							$file->write($newFilename, $methodname);
							$dao->add_moban($d);
							if($classname=="List"){
								$d = array("pathname"=>"Archives","filename"=>$methodname,"theme"=>$value,"themetype"=>1,"info"=>$value."-".$typename."-内容页模版","content"=>"");
								$newArcName = $dir.'/Tpl/'.$value."/Archives/".$methodname.".html";
								$file->write($newArcName, $methodname);
								$dao->add_moban($d);
							}
						}
					}										
				}
			}
		}
		return $rowid;
	}
	
	/**
	 * 删除栏目
	 */
	public function delete_arctype($id){
		$dao = new MyfDao();
		$d = $dao->find_arctype_by_id($id);
		$rows = $dao->delete_arctype($id);
		if($rows>0){
			//删除模版
			$filename = $d["methodname"];
			if($filename!="index"){
				$rowids = $dao->delete_moban_by_filename($filename);
				if($rowids>0){
					$namestart = "/*".$filename."-start*/";
					$nameend = "/*".$filename."-end*/";
					$len = strlen($nameend);
					$file = new File();
					$dir = dirname(dirname(dirname(dirname(__FILE__))));
					$filename = $dir."/Lib/Action/MyfAction.class.php";
					$content = $file->read($filename);
					
					$start = strripos($content,$namestart);
					if($start){
						$end = strripos($content,$nameend);
						if($end){
							$len = ($end-$start)+$len;
							$c = substr($content,$start,$len);
							$content = str_replace($c, "", $content);
							$file->write($filename, $content);
						}
					}
				}
			}
		}
		return $rows;
	}
	
	/**
	 * 更新栏目
	 */
	public function update_arctype($id,$data){
		$dao = new MyfDao();
		$rowid = $dao->update_arctype($id, $data);
		if($rowid>0){
			$typename = $data["typename"];
			if(!empty($typename)){
				$d = array("typename"=>$typename);
				$dao->update_archives_by_typeid($id,$d);
			}
		}
		return $rowid;
	}
	
	/**
	 * 更新栏目排序
	 */
	public function update_arctype_sortrank($data){
		$dao = new MyfDao();
		foreach ($data as $key => $value) {
			$d = array("sortrank"=> $value);
			$dao->update_arctype($key, $d);
		}
	}
	
	/**
	 * 添加文章
	 */
	public function add_archives($data){
		if(empty($data["flag"])){
			$data["flag"]="";
		}
		$dao = new MyfDao();
		return $dao->add_archives($data);
	}
	
	/**
	 * 更新文章
	 */
	public function update_archives($id,$data){
		if(empty($data["flag"])){
			$data["flag"]="";
		}
		$dao = new MyfDao();
		return $dao->update_archives($id, $data);
	}
	
	/**
	 * 删除文章
	 */
	public function delete_archive($id){
		$dao = new MyfDao();
		return $dao->delete_archive($id);
	}
	
	/**
	 * 批量删除文章
	 */
	public function delete_archives($ids){
		$dao = new MyfDao();
		return $dao->delete_archives($ids);
	}
	
	/**
	 * 批量修改文章属性
	 */
	public function update_archives_pro($ids,$data){
		$dao = new MyfDao();
		return $dao->update_archives_pro($ids, $data);
	}
	
	/**
	 * 分页获取文章列表内容
	 */
	public function find_archives_by_page($page,$pageCount=20,$filter=""){
		$dao = new MyfDao();
		$list = $dao->find_archives_by_page($page, $pageCount,$filter);
		foreach ($list as $key => $value) {
			$flagnames = "";
			$flag = $value["flag"];
			if(!empty($flag)){
				$flags = explode(",",$flag);
				if(in_array("h", $flags)){
					$flagnames .= "头条 ";
				}
				if(in_array("c", $flags)){
					$flagnames .= "推荐 ";
				}
				if(in_array("f", $flags)){
					$flagnames .= "幻灯 ";
				}
				if(in_array("a", $flags)){
					$flagnames .= "特荐 ";
				}
				if(in_array("s", $flags)){
					$flagnames .= "滚动 ";
				}
				if(in_array("b", $flags)){
					$flagnames .= "加粗 ";
				}
				if(in_array("p", $flags)){
					$flagnames .= "图片 ";
				}
			}
			if(!empty($flagnames)){
				$list[$key]["flagnames"] = trim($flagnames);
			}
		}		
		return $list;
	}
	
	/**
	 * 获取文章总数
	 */
	public function count_archives($filter=""){
		$dao = new MyfDao();
		return $dao->count_archives($filter);
	}
	
	/**
	 * 获取文章的详细内容
	 */
	public function find_archives_by_id($id){
		$dao = new MyfDao();
		return $dao->find_archives_by_id($id);
	}
	
	/**
	 * 添加链接
	 */
	public function add_flink($data){
		$dao = new MyfDao();
		return $dao->add_flink($data);
	}
	
	/**
	 * 更新链接
	 */
	public function update_flink($id,$data){
		$dao = new MyfDao();
		return $dao->update_flink($id, $data);
	}
	
	/**
	 * 删除链接
	 */
	public function delete_flink($id){
		$dao = new MyfDao();
		return $dao->delete_flink($id);
	}
	
	/**
	 * 查询所有链接
	 */
	public function find_all_flink(){
		$dao = new MyfDao();
		return $dao->find_all_flink();
	}
	
	/**
	 * 查询一个链接
	 */
	public function find_flink_by_id($id){
		$dao = new MyfDao();
		return $dao->find_flink_by_id($id);
	}
	
	/**
	 * 更新链接排序
	 */
	public function update_flink_sortrank($data){
		$dao = new MyfDao();
		foreach ($data as $key => $value) {
			$d = array("sortrank"=> $value);
			$dao->update_flink($key, $d);
		}
	}
	
	
	public function add_user($data){
		$data["createtime"] = date("Y-m-d H:i:s");
		$dao = new MyfDao();
		return $dao->add_admin($data);
	}
	
	public function delete_user($id){
		if($id==1){
			return -1;//初始管理员不能删除
		}else{
			$dao = new MyfDao();
			return $dao->delete_admin($id);
		}
	}
	
	public function update_user($id,$data){
		$dao = new MyfDao();
		return $dao->update_admin($id, $data);
	}
	
	public function find_all_admin(){
		$dao = new MyfDao();
		return $dao->find_all_admin();
	}
	
	public function find_admin_by_id($id){
		$dao = new MyfDao();
		return $dao->find_admin_by_id($id);
	}
	
	/**
	 * 管理员登录名是否被使用
	 */
	public function find_is_userid_used($userid){
		$isusered = true;
		$dao = new MyfDao();
		if($dao->count_admin_userid($userid)>0){
			$isusered = true;
		}else{
			$isusered = false;
		}
		return $isusered;
	}
	
	public function check_user_login($userid,$pwd){
		$dao = new MyfDao();
		$user = $dao->find_admin_by_userid($userid);
		if($user){
			if($user["pwd"]==md5($pwd)){
				return $user;
			}else{
				return null;
			}
		}else{
			return null;
		}
	}
	
	public function add_sys($data){
		$dao = new MyfDao();
		return $dao->add_sys($data);
	}
	
	public function update_sys($cfgs){
		$dao = new MyfDao();
		foreach ($cfgs as $key => $value) {
			$d = array("value"=>$value);
			$dao->update_sys($key, $d);
		}
	}
	
	public function find_all_sys(){
		$dao = new MyfDao();
		return $dao->find_all_sys();
	}
	
	public function find_sys_by_id($id){
		$dao = new MyfDao();
		return $dao->find_sys_by_id($id);
	}
	
	/**
	 * 管理员数
	 */
	public function count_admin(){
		$dao = new MyfDao();
		return $dao->count_admin();
	}
	
	/**
	 * 最新10条文章
	 */
	public function find_last_top_archives(){
		$dao = new MyfDao();
		return $dao->find_archives_by_page(1,10);
	}
	
	
	/**
	 * 添加模版
	 */
	public function add_moban($data,$dir){
		$dao = new MyfDao();
		$data["updatetime"] = date("Y-m-d H:i:s");
		$mid = $dao->add_moban($data);
		$msg = array("code"=>0,"info"=>"");
		if($mid>0){
			$filename = $dir."/Tpl/".$data["theme"]."/".$data["pathname"]."/".$data["filename"].".html";
			$file = new File();
			$content = $data["content"];
			$isok = $file->write($filename, $content);
			if($isok){
				$msg = array("code"=>1,"info"=>"模版保存成功！");
			}else{
				$msg["info"] = "模版文件保存失败！";
				//如果失败删除
				$dao->delete_moban($mid);
			}
		}else{
			$msg["info"] = "模版数据库保存失败！";
		}
		return $msg;
	}
	
	/**
	 * 删除模版
	 * @dir cms系统所在根目录
	 */
	public function delete_moban($id,$dir){
		$dao = new MyfDao();
		$data = $dao->find_moban_by_id($id);
		$msg = array("code"=>0,"info"=>"");
		if($data){
			$filename = $dir."/Tpl/".$data["theme"]."/".$data["pathname"]."/".$data["filename"].".html";
			$file = new File();
			$isdel = $file->delete($filename);
			if($isdel){
				$dao->delete_moban($id);
				$msg = array("code"=>1,"info"=>"模版删除成功！");
			}else{
				$msg["info"] = "模版文件删除失败！";
			}
		}else{
			$msg["info"] = "未找到指定模版文件！";
		}	
		return $msg;	
	}
	
	/**
	 * 更像模版
	 */
	public function update_moban($id,$data,$dir){
		$dao = new MyfDao();
		$filename = $dir."/Tpl/".$data["theme"]."/".$data["pathname"]."/".$data["filename"].".html";
		$file = new File();
		$msg = array("code"=>0,"info"=>"");
		$d = $dao->find_moban_by_id($id);
		if($d){
			//如果模版名称发生变化，先删除，再增加
			if($d["filename"]!=$data["filename"]){
				$filenamed = $dir."/Tpl/".$data["theme"]."/".$data["pathname"]."/".$d["filename"].".html";
				$isdel = $file->delete($filenamed);
			}
			$isupdate =$file->write($filename, $data["content"]);
			if($isupdate){
				$data["updatetime"] = date("Y-m-d H:i:s");
				$dao->update_moban($id, $data);
				$msg = array("code"=>1,"info"=>"模版更新成功！");
			}else{
				$msg["info"] = "模版文件更新失败！";
			}
		}else{
			$msg["info"] = "更新的模版文件不存在！";
		}
		
		return $msg;
	}
	
	/**
	 * 读取一条模版
	 */
	public function find_moban_by_id($id){
		$dao = new MyfDao();
		return $dao->find_moban_by_id($id);
	}
	
	/**
	 * 获取指定主题的所有模版
	 */
	public function find_all_moban($theme){
		$dao = new MyfDao();
		return $dao->find_all_moban($theme);
	}
	
	/**
	 * 添加采集节点
	 */
	public function add_conode($data){
		$data["createtime"] = date("Y-m-d H:i:s");
		$dao = new MyfDao();
		return $dao->add_conode($data);
	}
	
	/**
	 * 删除采集节点
	 */
	public function delete_conode($id){
		$dao = new MyfDao();
		return $dao->delete_conode($id);
	}
	
	/**
	 * 更新采集节点
	 */
	public function update_conode($id,$data){
		$dao = new MyfDao();
		return $dao->update_conode($id, $data);
	}
	
	/**
	 * 分页获取采集节点
	 */
	public function find_conode_by_page($page,$pageCount=20){
		$dao = new MyfDao();
		return $dao->find_conode_by_page($page,$pageCount);
	}
	
	/**
	 * 获取指定采集节点的详细内容
	 */
	public function find_conode_by_id($id){
		$dao = new MyfDao();
		return $dao->find_conode_by_id($id);
	}
	
	/**
	 * 采集节点记录数
	 */
	public function count_conode(){
		$dao = new MyfDao();
		return $dao->count_conode();
	}
	
	/**
	 * 添加采集内容
	 */
	public function add_cohtml($data){
		$data["createtime"] = date("Y-m:d H:i:s");
		$dao = new MyfDao();
		$nid = $data["nid"];
		$coid = $dao->add_cohtml($data);
		if($coid>0){
			$dao->add_conode_arccount($nid);
		}
		return $coid;
	}
	
	/**
	 * 删除采集内容
	 */
	public function delete_cohtml($id){
		$dao = new MyfDao();
		return $dao->delete_cohtml($id);
	}
	
	/**
	 * 更新采集内容
	 */
	public function update_cohtml($id,$data){
		$dao = new MyfDao();
		return $dao->update_cohtml($id, $data);
	}
	
	/**
	 * 根据节点编号分页获取采集内容
	 */
	public function find_cohtml_by_nodeid($nid,$page,$pageCount=20){
		$dao = new MyfDao();
		return $dao->find_cohtml_by_nodeid($nid, $page,$pageCount);
	}
	
	/**
	 * 获取指定节点编号的采集内容总数
	 */
	public function count_cohtml_by_nodeid($nid){
		$dao = new MyfDao();
		return $dao->count_cohmtl_by_nodeid($nid);
	}
	
	/**
	 * 获取指定采集内容的详细信息
	 */
	public function find_cohtml_by_id($id){
		$dao = new MyfDao();
		return $dao->find_cohtml_by_id($id);
	}
	
	public function find_cohtml_by_nodeid_nofrished($nid){
		$dao = new MyfDao();
		return $dao->find_cohtml_by_nodeid_nofrished($nid);
	}
	
	/**
	 * 删除指定节点下的文章，并将文章数清零
	 */
	public function delete_cohtml_by_nodeid($nid){
		$dao = new MyfDao();
		$rowids = $dao->delete_cohtml_by_nodeid($nid);
		if($rowids>0){
			$d= array("arccount"=>0);
			$dao->update_conode($nid, $d);
		}
		return $rowids;
	}
	
	public function find_cohtml_filter($filter){
		$dao = new MyfDao();
		return $dao->find_cohtml_filter($filter);
	}
	
	public function add_member($data){
		$dao = new MyfDao();
		$data["createtime"] = date("Y-m:d H:i:s");
		return $dao->add_member($data);
	}
	
	public function update_member($id,$data){
		$dao = new MyfDao();
		return $dao->update_member($id, $data);
	}
	
	public function delete_member($id){
		$dao = new MyfDao();
		return $dao->delete_member($id);
	}
	
	public function find_member_by_page($page,$pageCount=20,$filter=""){
		$dao = new MyfDao();
		$datas = $dao->find_member_by_page($page,$pageCount,$filter);
		foreach ($datas as $key => $value) {
			$face = $value["face"];
			$datas[$key]["face"] = "__APP__/uploads/Member/".$face.".jpg";
		}
		return $datas;
	}
	
	public function find_member_by_id($id){
		$dao = new MyfDao();
		return $dao->find_member_by_id($id);
	}
	
	public function find_is_member_used($loginid){
		$dao = new MyfDao();
		return $dao->find_is_member_used($loginid);
	}
	
	public function count_member($filter=""){
		$dao = new MyfDao();
		return $dao->count_member($filter);
	}
	
	public function find_comment_by_page($page,$pageCount=20,$filter=""){
		$dao = new MyfDao();
		return $dao->find_comment_by_page($page,$pageCount,$filter);
	}
	
	public function count_comment($filter=""){
		$dao = new MyfDao();
		return $dao->count_comment($filter);
	}
	
	public function delete_comment($id){
		$dao = new MyfDao();
		return $dao->delete_comment($id);
	}
	
	public function delete_comments($ids){
		$dao = new MyfDao();
		return $dao->delete_comments($ids);
	}
	
	public function change_comment_state($id,$state=1){
		$dao = new MyfDao();
		return $dao->change_comment_state($id,$state);
	}
}

?>