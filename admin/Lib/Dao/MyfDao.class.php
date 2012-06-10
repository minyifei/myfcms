<?php
// +----------------------------------------------------------------------
// | MyfCMS 闵益飞内容管理系统 [ 中国首家完全免费开源的PHPCMS ]
// +----------------------------------------------------------------------
// | Copyright (c) 2012 http://www.minyifei.cn All rights reserved.
// +----------------------------------------------------------------------
// | 交流论坛：http://bbs.minyifei.cn
// +----------------------------------------------------------------------


class MyfDao{
	
	/**
	 * 添加栏目
	 */
	public function add_arctype($data){
		$m_arctype = M("arctype");
		return $m_arctype->add($data);
	}
	
	/**
	 * 更新栏目
	 */
	public function update_arctype($id,$data){
		$m_arctype = M("arctype");
		return $m_arctype->where("id=".$id)->save($data);
	}
	
	/**
	 * 删除栏目，如果该栏目下有文章不能被删除
	 */
	public function delete_arctype($id){
		$m_arctype = M("arctype");
		$m_archives = M("archives");
		$count = $m_archives->where("typeid=".$id)->count();
		$child_count = $m_arctype->where("topid=".$id)->count();
		if($count>0 || $child_count>0){
			return null;
		}else{
			return $m_arctype->delete($id);
		}
	}
	
	/**
	 * 查询所有的栏目
	 */
	public function find_all_arctype($filter=""){
		$m_arctype = M("arctype");
		return $m_arctype->field("body",true)->where($filter)->order("sortrank asc")->select();
	}
	
	/**
	 * 查询制定编号的栏目信息
	 */
	public function find_arctype_by_id($id){
		$m_arctype = M("arctype");
		return $m_arctype->find($id);
	}
	
	/**
	 * 添加文章
	 */
	public function add_archives($data){
		$m_archives = M("archives");
		return $m_archives->add($data);
	}
	
	/**
	 * 更新文章
	 */
	public function update_archives($id,$data){
		$m_archives = M("archives");
		return $m_archives->where("id=".$id)->save($data);
	}
	
	/**
	 * 批量更新栏目名称
	 */
	public function update_archives_by_typeid($typeid,$data){
		$m_archives = M("archives");
		return $m_archives->where("typeid=".$typeid)->save($data);
	}
	
	/**
	 * 删除文章
	 */
	public function delete_archive($id){
		$m_archives = M("archives");
		return $m_archives->delete($id);
	}
	
	/**
	 * 批量删除文章
	 */
	public function delete_archives($ids){
		$m_archives = M("archives");
		$map['id']  = array('in',$ids);
		return $m_archives->where($map)->delete();
	}
	
	/**
	 * 批量更改属性
	 */
	public function update_archives_pro($ids,$data){
		$m_archives = M("archives");
		$map['id']  = array('in',$ids);
		return $m_archives->where($map)->save($data);
	}
	
	/**
	 * 文章总数
	 */
	public function count_archives($filter=""){
		$m_archives = M("archives");
		return $m_archives->where($filter)->count();
	}
	
	/**
	 * 分页获取文章基本信息
	 */
	public function find_archives_by_page($page,$pageCount=20,$filter="",$order="id desc"){
		$m_archives = D("Archives");
		$start = ($page-1)*$pageCount;
		return $m_archives->relation(true)->field("body",true)->where($filter)->order($order)->limit($start.",".$pageCount)->select();
	}
	
	/**
	 * 获取文章详细信息
	 */
	public function find_archives_by_id($id){
		$m_archives = M("archives");
		return $m_archives->find($id);
	}
	
	/**
	 * 添加系统参数
	 */
	public function add_sys($data){
		$m_sys = M("sys");
		return $m_sys->add($data);
	}
	
	/**
	 * 更新系统参数
	 */
	public function update_sys($id,$data){
		$m_sys = M("sys");
		return $m_sys->where("id=".$id)->save($data);
	}
	
	/**
	 * 删除系统参数 
	 */
	public function delete_sys($id){
		$m_sys = M("sys");
		return $m_sys->delete($id);
	}
	
	/**
	 * 查询所有的系统参数
	 */
	public function find_all_sys(){
		$m_sys = M("sys");
		return $m_sys->select();
	}
	
	/**
	 * 查询指定编号的系统参数
	 */
	public function find_sys_by_id($id){
		$m_sys = M("sys");
		return $m_sys->find($id);
	}
	
	/**
	 * 添加管理员
	 */
	public function add_admin($data){
		$m_admin = M("admin");
		return $m_admin->add($data);
	}
	
	/**
	 * 删除管理员
	 */
	public function delete_admin($id){
		$m_admin = M("admin");
		return $m_admin->delete($id);
	}
	
	/**
	 * 更新管理员
	 */
	public function update_admin($id,$data){
		$m_admin = M("admin");
		return $m_admin->where("id=".$id)->save($data);
	}
	
	/**
	 * 查询所有管理员
	 */
	public function find_all_admin(){
		$m_admin = M("admin");
		return $m_admin->select();
	}
	
	public function count_admin(){
		$m_admin = M("admin");
		return $m_admin->count();
	}
	
	/**
	 * 查询指定管理员
	 */
	public function find_admin_by_id($id){
		$m_admin = M("admin");
		return $m_admin->find($id);
	}
	
	/**
	 * 根据登录名查询用户
	 */
	public function find_admin_by_userid($userid){
		$m_admin = M("admin");
		$condition['userid'] = $userid;
		$data = $m_admin->where($condition)->select();
		if($data && count($data)>0){
			return $data[0];
		}else{
			return null;
		}
	}
	
	/**
	 * 查询用户登录id是否被使用
	 */
	public function count_admin_userid($userid){
		$m_admin = M("admin");
		return $m_admin->where("userid='".$userid."'")->count();
	}
	
	/**
	 * 添加友情链接
	 */
	public function add_flink($data){
		$m_flink = M("flink");
		return $m_flink->add($data);
	}
	
	/**
	 * 更新友情链接
	 */
	public function update_flink($id,$data){
		$m_flink = M("flink");
		return $m_flink->where("id=".$id)->save($data);
	}
	
	/**
	 * 删除友情链接
	 */
	public function delete_flink($id){
		$m_flink = M("flink");
		return $m_flink->delete($id);
	}
	
	/**
	 * 查询所有友情链接
	 */
	public function find_all_flink(){
		$m_flink = M("flink");
		return $m_flink->order("sortrank asc")->select();
	}
	
	/**
	 * 查询指定编号的友情链接
	 */
	public function find_flink_by_id($id){
		$m_flink = M("flink");
		return $m_flink->find($id);
	}
	
	/**
	 * 添加模版
	 */
	public function add_moban($data){
		$m_moban = M("moban");
		return $m_moban->add($data);
	}
	
	/**
	 * 删除模版
	 */
	public function delete_moban($id){
		$m_moban = M("moban");
		return $m_moban->where("id=".$id.' and themetype=0')->delete();
	}
	
	/**
	 * 批量删除模版
	 */
	public function delete_moban_by_filename($filename){
		$m_moban = M("moban");
		return $m_moban->where("filename='".$filename."'")->delete();
	}
	
	/**
	 * 更新模版
	 */
	public function update_moban($id,$data){
		$m_moban = M("moban");
		return $m_moban->field("body",true)->where("id=".$id)->save($data);
	}
	
	/**
	 * 根据主题找到旗下所有模版
	 */
	public function find_all_moban($theme){
		$m_moban = M("moban");
		return $m_moban->where("theme='".$theme."'")->select();
	}
	
	/**
	 * 根据编号查找模版
	 */
	public function find_moban_by_id($id){
		$m_moban = M("moban");
		return $m_moban->find($id);
	}
	
	/**
	 * 计算记录数
	 */
	public function count_moban_by_where($where){
		$m_moban = M("moban");
		return $m_moban->where($where)->count();
	}
	
	/**
	 * 添加采集节点
	 */
	public function add_conode($data){
		$m_node = M("co_node");
		return $m_node->add($data);
	}
	
	/**
	 * 删除采集节点
	 */
	public function delete_conode($id){
		$m_node = M("co_node");
		return $m_node->delete($id);
	}
	
	/**
	 * 修改采集节点
	 */
	public function update_conode($id,$data){
		$m_node = M("co_node");
		return $m_node->where("id=".$id)->save($data);
	}
	
	/**
	 * 节点种子数递增
	 */
	public function add_conode_arccount($id){
		$m_node = M("co_node");
		return $m_node->where('id='.$id)->setInc('arccount',1); 
	}
	
	/**
	 * 分页获取采集节点
	 */
	public function find_conode_by_page($page,$pageCount=20){
		$start = ($page-1)*$pageCount;
		$m_node = M("co_node");
		return $m_node->field(array("id","name","lasttime","createtime","arccount"))->order("id desc")->limit($start.",".$pageCount)->select();
	}
	
	/**
	 * 采集节点总数
	 */
	public function count_conode(){
		$m_node = M("co_node");
		return $m_node->count();
	}
	
	/**
	 * 根据编号查询采集节点详情
	 */
	public function find_conode_by_id($id){
		$m_node = M("co_node");
		return $m_node->find($id);
	}
	
	/**
	 * 添加采集内容
	 */
	public function add_cohtml($data){
		$m_html = M("co_html");
		return $m_html->add($data);
	}
	
	/**
	 * 更新采集内容
	 */
	public function update_cohtml($id,$data){
		$m_html = M("co_html");
		return $m_html->where("id=".$id)->save($data);
	}
	
	/**
	 * 删除采集内容
	 */
	public function delete_cohtml($id){
		$m_html = M("co_html");
		return $m_html->delete($id);
	}
	
	/**
	 * 删除指定栏目下的所有采集文章
	 */
	public function delete_cohtml_by_nodeid($nid){
		$m_html = M("co_html");
		return $m_html->where("nid=".$nid)->delete();
	}
	
	/**
	 * 分页查询节点下的采集文章
	 */
	public function find_cohtml_by_nodeid($nid,$page,$pageCount=20){
		$m_html = M("co_html");
		$start = ($page-1)*$pageCount;
		return $m_html->field("body",true)->where("nid=".$nid)->order("id desc")->limit($start.",".$pageCount)->select();
	}
	
	/**
	 * 查询指定节点下未采集的种子
	 */
	public function find_cohtml_by_nodeid_nofrished($nid){
		$m_html = M("co_html");
		return $m_html->field("body",true)->where("nid=".$nid." and isdown=0")->order("id desc")->select();
	}
	
	/**
	 * 搜索种子
	 */
	public function find_cohtml_filter($filter=""){
		$m_html = M("co_html");
		return $m_html->where($filter)->select();
	}
	
	/**
	 * 获取采集节点的文章总数
	 */
	public function count_cohmtl_by_nodeid($nid){
		$m_html = M("co_html");
		return $m_html->where("nid=".$nid)->count();
	}
	
	/**
	 * 获取采集文章的详细信息
	 */
	public function find_cohtml_by_id($id){
		$m_html = M("co_html");
		return $m_html->find($id);
	}
	
	/**
	 * 添加会员
	 */
	public function add_member($data){
		$m_member = M("member");
		return $m_member->add($data);
	}
	
	/**
	 * 更新会员资料
	 */
	public function update_member($id,$data){
		$m_member = M("member");
		return $m_member->where("id=".$id)->save($data);
	}
	
	/**
	 * 删除会员
	 */
	public function delete_member($id){
		$m_member = M("member");
		return $m_member->delete($id);
	}
	
	/**
	 * 分页获取会员
	 */
	public function find_member_by_page($page,$pageCount=20,$filter=""){
		$m_member = M("member");
		$start = ($page-1)*$pageCount;
		return $m_member->where($filter)->order("id desc")->limit($start.",".$pageCount)->select();
	}
	
	/**
	 * 获取会员总数
	 */
	public function count_member($filter=""){
		$m_member = M("member");
		return $m_member->where($filter)->count();
	}
	
	public function find_is_member_used($loginid){
		$m_member = M("member");
		$count = $m_member->where("loginid='".$loginid."'")->count();
		if($count>0){
			return true;
		}else{
			return false;
		}
	}
	
	public function find_member_by_id($id){
		$m_member = M("member");
		return $m_member->find($id);
	}
	
	/**
	 * 分页获取评论信息
	 */
	public function find_comment_by_page($page,$pageCount=20,$filter=""){
		$m_comment = D("Comment");
		$start = ($page-1)*$pageCount;
		return $m_comment->relation(true)->where($filter)->order("id desc")->limit($start.",".$pageCount)->select();
	}
	
	/**
	 * 获取评论总数
	 */
	public function count_comment($filter=""){
		$m_comment = M("comment");
		return $m_comment->where($filter)->count();
	}
	
	public function delete_comment($id){
		$m_comment = M("comment");
		return $m_comment->delete($id);
	}
	
	public function delete_comments($ids){
		$m_comment = M("comment");
		return $m_comment->where("id in(".$ids.")")->delete();
	}
	
	public function change_comment_state($id,$state=1){
		$m_comment = M("comment");
		$d = array("state"=>$state);
		return $m_comment->where("id=".$id)->save($d);
	}
}

?>