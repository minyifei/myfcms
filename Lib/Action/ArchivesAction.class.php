<?php
// +----------------------------------------------------------------------
// | MyfCMS 闵益飞内容管理系统 [ 中国首家完全免费开源的PHPCMS ]
// +----------------------------------------------------------------------
// | Copyright (c) 2012 http://www.minyifei.cn All rights reserved.
// +----------------------------------------------------------------------
// | 交流论坛：http://bbs.minyifei.cn
// +----------------------------------------------------------------------

/**
 * 文章内容页
 */
import("ORG.Util.Image");
class ArchivesAction extends MyfAction {
	
	/**
	 * 增加好评数或差评、点击数
	 */
	public function myfcms_set_archive_info(){
		$id = $_REQUEST["id"];
		$type = $_REQUEST["type"];
		$m_arc = M("archives");
		$res = array("msg"=>"success");
		$rows = 0;
		if($type=="good"){
			$rows = $m_arc->where("id=".$id)->setInc("goodpost");
		}else if($type=="bad"){
			$rows = $m_arc->where("id=".$id)->setInc("badpost");
		}else if($type=="click"){
			$rows = $m_arc->where("id=".$id)->setInc("click");
		}
		if($rows<=0){
			$res = array("msg"=>"error");
		}
		echo json_encode($res);
	}
	
	/**
	 * 获取文章的好评数和差评数、点击数、评论数
	 */
	public function myfcms_get_archive_info(){
		$id = $_REQUEST["id"];
		$m_arc = M("archives");
		$data = $m_arc->field("id,goodpost,badpost,click,commentcount")->find($id);
		echo json_encode($data);
	}
	
	/**
	 * 增加评论
	 */
	public function myfcms_archive_comment(){
		$res = array();
		$verify = $_REQUEST["code"];
		if(md5($verify)!=$_SESSION["verify"]){
			$res["msg"] = "验证码错误,".$_SESSION["verify"]."---".md5($verify)."---".$verify."--".$_SESSION["myfcms_code"];
			$res["code"] = 0;
		}else{
			$id = $_REQUEST["id"];
			$username = htmlspecialchars($_REQUEST["username"]);
			$email = htmlspecialchars($_REQUEST["email"]);
			$url = htmlspecialchars($_REQUEST["url"]);
			$body = htmlspecialchars($_REQUEST["comment"]);
			$arctitle = $_REQUEST["arctitle"];
			$ip = $_SERVER["REMOTE_ADDR"];
			if(empty($url)){
				$url = "./";
			}
			$data = array(
				"arcid"=>$id,
				"username"=>$username,
				"ip"=>$ip,
				"posttime"=>date("Y-m-d H:i:s"),
				"body"=>$body,
				"state"=>C("MYFCMS_COMMENT_STATE"),
				"agent"=>$_SERVER["HTTP_USER_AGENT"],
				"url"=>$url,
				"email"=>$email
			);
			$m_arc = M("archives");
			$rows = $m_arc->where("id=".$id)->setInc("commentcount");
			if($rows>0){
				$arctitle = $m_arc->where('id='.$id)->getField('title');
				$data["arctitle"] = $arctitle;
				$m_comment = M("comment");
				
				$d = $m_comment->field("id,face")->where("ip='".$ip."'")->find();
				if($d){
					$data["face"] = $d["face"];
				}else{
					$data["face"] = rand(1,12);
				}
				$rowid = $m_comment->add($data);
				if($rowid>0){
					$data["id"] = $rowid;
					$res["msg"] = "评论添加成功";
					$res["code"] = 1;
					$res["data"] = $data;
					//生成html
					if(C("MYFCMS_URLTYPE")=="html"){
						$this->_archives($id);
					}
				}else{
					$res["msg"] = "数据插入失败";
					$res["code"] = 0;
				}
			}else{
				$res["msg"] = "文章评论数更新失败";
				$res["code"] = 0;
			}
		}
		echo json_encode($res);		
	}
	
	public function index(){
		$this->_archives();
		$this->display();
	}
	
	/**
	 * 生产验证码
	 */
	public function myfcms_verify(){
		Image::buildImageVerify();
	}
	
}


?>