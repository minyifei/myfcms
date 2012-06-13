<?php
// +----------------------------------------------------------------------
// | MyfCMS 闵益飞内容管理系统 [ 中国首家完全免费开源的PHPCMS ]
// +----------------------------------------------------------------------
// | Copyright (c) 2012 http://www.minyifei.cn All rights reserved.
// +----------------------------------------------------------------------
// | 交流论坛：http://bbs.minyifei.cn
// +----------------------------------------------------------------------


header("Content-Type:text/html; charset=utf-8");

/**
 * 初始化
 */
class InstallAction extends Action {
	
	public function index(){
		$script_name = $_SERVER["SCRIPT_NAME"];
		$indexurl = str_replace("/index.php", "", $script_name); 
		$this->assign("indexurl",$indexurl);
		$this->display();
	}
	
	public function check(){
		$dbhost = $_REQUEST["dbhost"];
		$dbport = $_REQUEST["dbport"];
		$dbname = $_REQUEST["dbname"];
		$dbuser = $_REQUEST["dbuser"];
		$dbpwd = $_REQUEST["dbpwd"];
		$res = array("msg"=>"");		
		$conn = mysql_connect($dbhost.":".$dbport,$dbuser,$dbpwd);
		$db = mysql_select_db($dbname,$conn);
		if($db){
			$res["msg"] = "数据库连接成功！";
			mysql_close($conn);
		}else{
			$res["msg"] = "数据库连接<font style='color:red'>失败</font>！";
		}
		echo json_encode($res);
	}
	
	public function step(){
		$dbhost = $_REQUEST["dbhost"];
		$dbport = $_REQUEST["dbport"];
		$dbname = $_REQUEST["dbname"];
		$dbuser = $_REQUEST["dbuser"];
		$dbpwd = $_REQUEST["dbpwd"];
		$userid = $_REQUEST["userid"];
		$pwd = md5($_REQUEST["pwd"]);
		$webname = $_REQUEST["webname"];
		$email = $_REQUEST["adminemail"];
		$basehost = $_REQUEST["basehost"];
		$indexurl = $_REQUEST["indexurl"];
		$now  = date("Y-m-d H:i:s");
		
		$msg = null;
		if(empty($userid)){
			$msg = "管理员用户名不能为空！";
		}
		if(empty($pwd)){
			$msg = "管理员密码不能为空！";
		}
		if(empty($webname)){
			$msg = "网站名称不能为空！";
		}
		if(empty($email)){
			$msg = "管理员邮箱不能为空！";
		}
		if(empty($basehost)){
			$msg = "网站网址不能为空！";
		}
		if(!empty($msg)){
			$this->error($msg);
		}
	
		$conn = mysql_connect($dbhost.":".$dbport,$dbuser,$dbpwd);
		mysql_select_db($dbname,$conn);
		if($conn){
			$path = dirname(dirname(dirname(__FILE__)));
			$table_sql = "
				DROP TABLE IF EXISTS `myf_admin`;
				DROP TABLE IF EXISTS `myf_archives`;
				DROP TABLE IF EXISTS `myf_arctype`;
				DROP TABLE IF EXISTS `myf_flink`;
				DROP TABLE IF EXISTS `myf_moban`;
				DROP TABLE IF EXISTS `myf_sys`;
				DROP TABLE IF EXISTS `myf_co_html`;
				DROP TABLE IF EXISTS `myf_co_node`;
				DROP TABLE IF EXISTS `myf_comment`;
				DROP TABLE IF EXISTS `myf_member`;
				
				CREATE TABLE `myf_admin` (
				  `id` int(11) NOT NULL auto_increment,
				  `userid` varchar(30) NOT NULL COMMENT '登陆名',
				  `pwd` varchar(32) NOT NULL COMMENT '密码',
				  `uname` varchar(30) default NULL COMMENT '笔名',
				  `email` varchar(50) NOT NULL COMMENT '邮件',
				  `logintime` datetime default NULL COMMENT '登陆时间',
				  `loginip` varchar(20) default NULL COMMENT '上次登陆ip',
				  `createtime` datetime default NULL COMMENT '创建时间',
				  PRIMARY KEY  (`id`),
				  UNIQUE KEY `userid` (`userid`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='系统管理员用户表';
				
				CREATE TABLE `myf_archives` (
				  `id` int(11) NOT NULL auto_increment,
				  `typeid` int(11) NOT NULL COMMENT '栏目编号',
				  `typename` varchar(50) default NULL COMMENT '栏目名称',
				  `flag` varchar(50) default NULL COMMENT '自定义属性',
				  `click` int(11) NOT NULL default '0' COMMENT '点击数',
				  `title` varchar(255) NOT NULL COMMENT '标题',
				  `color` char(7) default NULL COMMENT '文章标题颜色',
				  `writer` varchar(50) default NULL COMMENT '作者名称',
				  `source` varchar(50) default NULL COMMENT '文章来源',
				  `litpic` varchar(150) default NULL COMMENT '文章缩略图',
				  `keywords` varchar(255) default NULL COMMENT '文章关键字',
				  `description` varchar(500) default NULL COMMENT '文章描述',
				  `sendtime` datetime NOT NULL COMMENT '发布时间',
				  `goodpost` int(11) NOT NULL default '0' COMMENT '好评数',
				  `badpost` int(11) NOT NULL default '0' COMMENT '差评数',
				  `adminid` int(11) default NULL COMMENT '添加文章管理员编号',
				  `adminname` varchar(30) default NULL COMMENT '添加文章管理员笔名',
				  `body` text COMMENT '文章内容',
				  `ishtml` tinyint(4) NOT NULL default '0' COMMENT '是否生成html',
				  `commentcount` int(11) NOT NULL default '0' COMMENT '评论数',
				  PRIMARY KEY  (`id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文章表';				
				
				CREATE TABLE `myf_arctype` (
				  `id` int(11) NOT NULL auto_increment,
				  `topid` int(11) NOT NULL default '0' COMMENT '顶级栏目编号',
				  `sortrank` smallint(6) NOT NULL default '50' COMMENT '栏目排序',
				  `typename` varchar(50) NOT NULL COMMENT '栏目名称',
				  `typedir` varchar(50) NOT NULL COMMENT '目录地址',
				  `arcnamerule` varchar(50) default NULL COMMENT '文章页命名规则',
				  `listnamerule` varchar(50) default NULL COMMENT '列表页命名规则',
				  `classname` varchar(50) NOT NULL COMMENT '类名',
				  `methodname` varchar(50) NOT NULL COMMENT '方法名称',
				  `keywords` varchar(255) default NULL COMMENT '关键字',
				  `seotitle` varchar(255) default NULL COMMENT 'seo标题',
				  `description` varchar(500) default NULL COMMENT '栏目描述',
				  `typepro` smallint(6) NOT NULL default '0' COMMENT '栏目属性,0-最终列表页，1-频道封面，2-外部链接',
				  `body` text COMMENT '栏目内容',
				  PRIMARY KEY  (`id`),
				  UNIQUE KEY `typedir` (`typedir`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='栏目表';
				
				CREATE TABLE `myf_flink` (
				  `id` int(11) NOT NULL auto_increment,
				  `sortrank` smallint(6) NOT NULL default '50',
				  `url` varchar(150) NOT NULL COMMENT '连接地址',
				  `webname` varchar(50) NOT NULL COMMENT '网站名称',
				  `msg` varchar(255) default NULL COMMENT '网站简介',
				  `logo` varchar(150) default NULL COMMENT '网站logo地址',
				  `dtime` datetime default NULL COMMENT '连接时间',
				  PRIMARY KEY  (`id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='友情链接表';
				
				CREATE TABLE `myf_moban` (
				  `id` int(11) NOT NULL auto_increment,
				  `pathname` varchar(50) NOT NULL COMMENT '模板上级目录名称',
				  `filename` varchar(100) NOT NULL COMMENT '模板文件名称，不带.html',
				  `theme` varchar(50) NOT NULL COMMENT '模板主题',
				  `updatetime` datetime default NULL COMMENT '模板更新时间',
				  `themetype` int(11) NOT NULL default '0' COMMENT '类型，0-用户自定义模板，1-系统自带模板',
				  `info` varchar(50) default NULL COMMENT '模板描述',
				  `content` text COMMENT '模板内容',
				  PRIMARY KEY  (`id`),
				  UNIQUE KEY `pathname` (`pathname`,`filename`,`theme`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='模板表';
				
				CREATE TABLE `myf_sys` (
				  `id` int(11) NOT NULL auto_increment,
				  `name` varchar(50) NOT NULL COMMENT '参数名',
				  `value` varchar(500) NOT NULL COMMENT '值',
				  `info` varchar(255) default NULL COMMENT '变量说明',
				  `valuetype` enum('text','string') NOT NULL default 'string',
				  PRIMARY KEY  (`id`),
				  UNIQUE KEY `un_name` USING BTREE (`name`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='系统参数表';
				
				CREATE TABLE `myf_co_node` (
				  `id` int(11) NOT NULL auto_increment,
				  `name` varchar(50) NOT NULL COMMENT '节点名称',
				  `listurl` varchar(225) NOT NULL COMMENT '列表页网址',
				  `liststart` varchar(225) NOT NULL COMMENT '列表页开始HTML',
				  `listend` varchar(225) NOT NULL COMMENT '列表页结束HTML',
				  `linkinc` varchar(100) default NULL COMMENT '列表文章链接必须包含的字符串',
				  `linknot` varchar(100) default NULL COMMENT '列表文章链接不能包含的字符串',
				  `conurl` varchar(255) default NULL COMMENT '内容预览网址',
				  `lasttime` datetime default NULL COMMENT '最后采集时间',
				  `titlestart` varchar(225) NOT NULL COMMENT '标题开始HTML',
				  `titleend` varchar(225) NOT NULL COMMENT '标题结束HTML',
				  `keywordstart` varchar(225) default NULL COMMENT '关键字开始HTML',
				  `keywordend` varchar(225) default NULL COMMENT '关键字结束HMTL',
				  `descstart` varchar(225) default NULL COMMENT '摘要开始',
				  `descend` varchar(225) default NULL COMMENT '摘要结束',
				  `sourcestart` varchar(225) default NULL COMMENT '来源开始',
				  `sourceend` varchar(225) default NULL COMMENT '来源结束',
				  `timestart` varchar(225) default NULL COMMENT '时间开始',
				  `timeend` varchar(225) default NULL COMMENT '时间结束',
				  `contstart` varchar(225) NOT NULL COMMENT '内容开始',
				  `contend` varchar(225) NOT NULL COMMENT '内容结束',
				  `filterstr` varchar(100) default NULL COMMENT '内容过滤',
				  `createtime` datetime default NULL COMMENT '记录创建时间',
				  `arccount` int(11) NOT NULL default '0' COMMENT '总共采集数',
				  PRIMARY KEY  (`id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文章采集节点表';

				CREATE TABLE `myf_co_html` (
				  `id` int(11) NOT NULL auto_increment,
				  `nid` int(11) NOT NULL COMMENT '采集节点编号',
				  `nname` varchar(50) default NULL COMMENT '节点名称',
				  `url` varchar(225) NOT NULL COMMENT '内容网址',
				  `title` varchar(225) default NULL COMMENT '标题',
				  `keywords` varchar(225) default NULL COMMENT '关键字',
				  `description` varchar(225) default NULL COMMENT '描述',
				  `source` varchar(100) default NULL COMMENT '来源',
				  `sendtime` datetime default NULL COMMENT '发布时间',
				  `body` text COMMENT '内容',
				  `createtime` datetime default NULL,
				  `isdown` smallint(6) NOT NULL default '0' COMMENT '0-未采集，1-已经采集',
				  `isexport` smallint(6) NOT NULL default '0' COMMENT '是否已经导出',
				  PRIMARY KEY  (`id`),
				  UNIQUE KEY `nid` (`nid`,`url`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='采集内容表';
				
				CREATE TABLE `myf_member` (
				  `id` int(11) NOT NULL auto_increment,
				  `loginid` varchar(30) NOT NULL COMMENT '用户登录名',
				  `pwd` varchar(32) NOT NULL,
				  `username` varchar(50) default NULL COMMENT '用户名',
				  `email` varchar(50) default NULL,
				  `face` varchar(150) default NULL,
				  `createtime` datetime default NULL COMMENT '创建时间',
				  PRIMARY KEY  (`id`),
				  UNIQUE KEY `loginid` (`loginid`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8;
				
				CREATE TABLE `myf_comment` (
				  `id` int(11) NOT NULL auto_increment,
				  `arcid` int(11) NOT NULL COMMENT '对应文章编号',
				  `arctitle` varchar(200) default NULL COMMENT '文章标题 ',
				  `username` varchar(100) NOT NULL default '匿名' COMMENT '用户名',
				  `memberid` int(11) default '0' COMMENT '用户编号',
				  `ip` varchar(100) default NULL COMMENT '评论者ip',
				  `posttime` datetime default NULL COMMENT '评论时间',
				  `body` varchar(500) default NULL COMMENT '评论内容',
				  `state` int(11) default NULL COMMENT '评论状态，0-未通过，1-通过',
				  `agent` varchar(300) default NULL COMMENT '用户客户端信息',
				  `url` varchar(200) default NULL COMMENT '发布者网站',
				  `email` varchar(100) default NULL,
				  `face` int(11) NOT NULL default '1',
				  PRIMARY KEY  (`id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8;
				
				INSERT INTO `myf_sys` VALUES (1, 'cfg_basehost', '".$basehost."', '站点根目录', 'string');
				INSERT INTO `myf_sys` VALUES (2, 'cfg_indexurl', '".$indexurl."', '网页主页链接', 'string');
				INSERT INTO `myf_sys` VALUES (3, 'cfg_webname', '".$webname."', '网站名称', 'string');
				INSERT INTO `myf_sys` VALUES (4, 'cfg_powerby', 'Copyright © 2012 MyfCMS. 闵益飞内容管理系统 版权所有', '网站版权信息', 'text');
				INSERT INTO `myf_sys` VALUES (5, 'cfg_keywords', 'myfcms,飞跃内容管理系统', '站点默认关键字', 'string');
				INSERT INTO `myf_sys` VALUES (6, 'cfg_description', '', '站点描述', 'text');
				INSERT INTO `myf_sys` VALUES (7, 'cfg_beian', '', '网站备案号', 'string');
				
				INSERT INTO `myf_admin` VALUES (1, '".$userid."', '".$pwd."', '管理员', '".$email."', NULL, NULL, '".$now."');
				
				INSERT INTO `myf_moban` VALUES (1, 'Index', 'index', 'default', '2012-5-25 22:34:14', 1, '默认首页模板', '');
				INSERT INTO `myf_moban` VALUES (8, 'Index', 'index', 'touch', '2012-5-26 12:10:22', 1, '触屏首页模板', '');
				INSERT INTO `myf_moban` VALUES (9, 'List', 'index', 'touch', '2012-5-26 12:12:12', 1, '触屏列表页', '');
				INSERT INTO `myf_moban` VALUES (10, 'Cover', 'index', 'touch', '2012-5-26 12:14:06', 1, '触屏封面页', '');
				INSERT INTO `myf_moban` VALUES (11, 'Search', 'index', 'touch', '2012-5-26 08:08:28', 1, '触屏搜索页', '');
				INSERT INTO `myf_moban` VALUES (12, 'Archives', 'index', 'touch', '2012-5-26 07:57:23', 1, '触屏内容页', '');
				INSERT INTO `myf_moban` VALUES (13, 'Index', 'index', '3g', '2012-5-26 18:59:58', 1, '3G首页', '');
				INSERT INTO `myf_moban` VALUES (14, 'List', 'index', '3g', '2012-5-26 19:09:39', 1, '3G列表页', '');
				INSERT INTO `myf_moban` VALUES (15, 'Cover', 'index', '3g', '2012-5-26 19:11:33', 1, '3G列表封面页', '');
				INSERT INTO `myf_moban` VALUES (16, 'Search', 'index', '3g', '2012-5-26 19:25:41', 1, '3G搜索列表页', '');
				INSERT INTO `myf_moban` VALUES (17, 'Archives', 'index', '3g', '2012-5-26 19:19:12', 1, '3G文章内容页', '');
				INSERT INTO `myf_moban` VALUES (18, 'List', 'index', '2g', '2012-5-10 07:01:20', 1, '简版列表页', '2g list');
				INSERT INTO `myf_moban` VALUES (19, 'Search', 'index', '2g', '2012-5-10 07:01:47', 1, '简版搜索列表页', '2g search');
				INSERT INTO `myf_moban` VALUES (20, 'Cover', 'index', '2g', '2012-5-10 07:02:16', 1, '简版封面列表页', '简版 cover');
				INSERT INTO `myf_moban` VALUES (21, 'Archives', 'index', '2g', '2012-5-10 07:03:14', 1, '简版内容页', '简版 archive');
				INSERT INTO `myf_moban` VALUES (23, 'Single', 'index', '2g', '2012-5-9 21:05:22', 1, '简版栏目单页模板', '');
				INSERT INTO `myf_moban` VALUES (24, 'Single', 'index', '3g', '2012-5-26 19:21:56', 1, '3G栏目单页模板', '');
				INSERT INTO `myf_moban` VALUES (25, 'Single', 'index', 'touch', '2012-5-26 08:02:57', 1, '触屏栏目单页模板', '');
				INSERT INTO `myf_moban` VALUES (22, 'Public', 'top', 'default', '2012-5-25 22:14:21', 0, '顶部模板', '');
				INSERT INTO `myf_moban` VALUES (3, 'List', 'index', 'default', '2012-5-25 07:42:54', 1, '默认列表页', '');
				INSERT INTO `myf_moban` VALUES (26, 'Single', 'index', 'default', '2012-5-25 22:02:15', 1, '默认栏目单页模板', '');
				INSERT INTO `myf_moban` VALUES (4, 'Archives', 'index', 'default', '2012-5-25 08:04:47', 1, '默认内容页', '');
				INSERT INTO `myf_moban` VALUES (5, 'Search', 'index', 'default', '2012-5-25 08:21:51', 1, '默认搜索列表页', '');
				INSERT INTO `myf_moban` VALUES (6, 'Cover', 'index', 'default', '2012-5-24 21:59:01', 1, '默认列表封面页', '');
				INSERT INTO `myf_moban` VALUES (7, 'Index', 'index', '2g', '2012-5-9 22:53:17', 1, '简版首页模板', '');
				INSERT INTO `myf_moban` VALUES (27, 'Public', 'footer', 'default', '2012-5-24 21:09:14', 0, '底部', '');
				INSERT INTO `myf_moban` VALUES (28, 'Public', 'top', 'touch', '2012-5-26 07:39:11', 0, '顶部菜单', '');
				INSERT INTO `myf_moban` VALUES (29, 'Public', 'footer', 'touch', '2012-5-26 07:38:17', 0, '底部版权', '');
				INSERT INTO `myf_moban` VALUES (30, 'Public', 'top', '3g', '2012-5-26 19:00:53', 0, '3g顶部菜单', '');
				INSERT INTO `myf_moban` VALUES (31, 'Public', 'footer', '3g', '2012-5-26 18:59:32', 0, '3g底部版权', '');
								
			";
			mysql_query("SET NAMES utf8");
			$explode = explode(";",$table_sql);
		 	foreach ($explode as $key=>$value){
		    	if(!empty($value)){
		    		if(trim($value)){
			    		echo $key."-------->".$value."<br/>";
			    		$result = mysql_query($value.";");
		    		}
		    	}
		  	}
			mysql_close($conn);
			 
			$dbconfig = "<?php ";
			$dbconfig .= "return array(";
			$dbconfig .= "'URL_MODEL'=>2,";
		    $dbconfig .= "'DB_TYPE'=>'mysql',";
		    $dbconfig .= "'DB_HOST'=>'".$dbhost."',";
		    $dbconfig .= "'DB_NAME'=>'".$dbname."',";
		    $dbconfig .= "'DB_USER'=>'".$dbuser."',";
		    $dbconfig .= "'DB_PWD'=>'".$dbpwd."',";
		    $dbconfig .= "'DB_PORT'=>'".$dbport."',";
		    $dbconfig .= "'DB_PREFIX'=>'myf_',";
			$dbconfig .= "); ?>";
			 
			 $filename = $path."/config.php";
			 $isok = $this->write($filename, $dbconfig);
			 if($isok){
			 	$script_name = $_SERVER["SCRIPT_NAME"];
				$this->success("第一步初始化完成,进入下一步",$script_name."?m=Install&a=step2");    
			 }else{
			 	$this->error("系统初始化失败！");
			 }
			
		}else{
			$this->error("数据库链接失败!");
		}
	}

	public function step2(){
		$path = dirname(dirname(dirname(__FILE__)));
		$m_moban = M("moban");
		$ds = $m_moban->select();
		foreach($ds as $key=>$vo){
			$d = array("content"=>$this->getMobanContent($path, $vo["theme"], $vo["pathname"],$vo["filename"]));
			$id = $vo['id'];
			$m_moban->where("id=".$id)->save($d);
		}
		
		$script_name = $_SERVER["SCRIPT_NAME"];
		$dir = dirname(__FILE__);
		$oldname = $dir."/InstallAction.class.php";
		$newname = $dir."/over.php";
		rename($oldname,$newname); 
		$url = str_replace("index.php", "admin/index.php?m=Login&a=index", $script_name); 
	 	$this->success("初始化完成！",$url);
	}

	public function getMobanContent($dir,$theme,$moban,$method=""){
		$filename = $dir."/Tpl/".$theme."/".$moban."/index.html";
		if(!empty($method)){
			$filename = $dir."/Tpl/".$theme."/".$moban."/".$method.".html";
		}
			
		return $this->read($filename);
	}

	//写文件
	public function write($filename,$content){
		@$fp = fopen($filename, "w");
		if(!$fp){
			return false;
		}else{
			fwrite($fp, $content);
			fclose($fp);
			return true;
		}
	}
	
	/**
	 * 读取文件内容
	 */
	public function read($filename){
		@$fp = fopen($filename, "r");
		if(!$fp){
			return null;
		}else{
			$content = fread($fp, filesize($filename));
			fclose($fp);
			return $content;
		}
	}
}


?>