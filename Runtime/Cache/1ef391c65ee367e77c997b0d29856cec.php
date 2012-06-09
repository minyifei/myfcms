<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title><?php echo ($myfcms["typename"]); ?>-<?php $_result=M("sys")->where("name='cfg_webname'")->select();if($_result) echo $_result[0][value]; ?></title>
		<meta name="description" content="<?php $_result=M("sys")->where("name='cfg_description'")->select();if($_result) echo $_result[0][value]; ?>" />
		<meta name="keywords" content="<?php $_result=M("sys")->where("name='cfg_keywords'")->select();if($_result) echo $_result[0][value]; ?>" />
		<meta name="author" content="minyifei.cn" />
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="apple-touch-icon" href="/apple-touch-icon.png" />
		<link type="text/css" rel="stylesheet" href="__MYFCMSPUBLIC__/css/main.css" />
	</head>
	<body>
		<div class="top">
	<div class="header">
		<div class="logo">
			<a href="__MYFCMS__/"> <img src="__MYFCMSPUBLIC__/images/logo.jpg" /> </a>
		</div>
		<div class="search">
			<form action="<?php echo ($myfcms["searchurl"]); ?>" method="get">
				<ul>
					<li>
						<select name="tid" class="searchsel">
							<option value="0"> 选择栏目 </option>
							<?php $urltype="static"; $_result=M('arctype')->field('body',true)->where("1=1  and topid=0")->order("sortrank asc")->select(); if ($_result): $i=0;foreach($_result as $key=>$toptype):++$i;$mod = ($i % 2 );$typepro=$toptype[typepro];if($urltype!="static"):$toptype["typeurl"]="__APP__/index.php?m=$toptype[classname]&a=$toptype[methodname]&id=$toptype[id]";else:$toptype["typeurl"]="__APP__/$toptype[classname]/$toptype[typedir]-$toptype[methodname].html";endif;if($typepro==2):$toptype["typeurl"]="$toptype[typedir]";endif; if(($toptype["protype"] == 0) OR ($toptype["protype"] == 1) ): ?><option value="<?php echo ($toptype["id"]); ?>"> <?php echo ($toptype["typename"]); ?> </option><?php endif; endforeach; endif;?>
						</select>
					</li>
					<li>
						<input name="keyword" id="search-keyword" onblur="if(value ==''){value='请输入关键字'}" onclick="if(this.value=='请输入关键字')this.value=''" onmouseover="this.focus()" value="请输入关键字" size="20" class="searchtxt">
					</li>
					<li>
						<input type="submit" class="searchbtn" value="搜索" />
					</li>
					<li>
					<li class="search_text">
						| 热门: <a href="<?php echo ($myfcms["searchurl"]); ?>?keyword=国内">国内</a>&nbsp;<a href="<?php echo ($myfcms["searchurl"]); ?>?keyword=国际">国际</a>&nbsp;
					</li>
					</li>
				</ul>
			</form>
		</div>
	</div>
	<div class="nav">
		<div class="nav-menu">
			<div class="nav-one">
				<ul>
					<li <?php if(empty($topchannelid)): ?>class="on"<?php endif; ?> > 
						<a href="__MYFCMS__/">首页</a>
					</li>
					<?php $urltype="static"; $_result=M('arctype')->field('body',true)->where("1=1  and topid=0")->order("sortrank asc")->select(); if ($_result): $i=0;foreach($_result as $key=>$toptype):++$i;$mod = ($i % 2 );$typepro=$toptype[typepro];if($urltype!="static"):$toptype["typeurl"]="__APP__/index.php?m=$toptype[classname]&a=$toptype[methodname]&id=$toptype[id]";else:$toptype["typeurl"]="__APP__/$toptype[classname]/$toptype[typedir]-$toptype[methodname].html";endif;if($typepro==2):$toptype["typeurl"]="$toptype[typedir]";endif;?><li <?php if(($toptype["id"]) == $topchannelid): ?>class="on"<?php endif; ?> >
						  <a href="<?php echo ($toptype["typeurl"]); ?>"><?php echo ($toptype["typename"]); ?></a>
						</li><?php endforeach; endif;?>
				</ul>
				<div class="clear"></div>
			</div>
			<div class="nav-two">
				<ul>
					<?php $urltype="static"; $_result=M('arctype')->field('body',true)->where("1=1  and topid=$topchannelid")->order("sortrank asc")->select(); if ($_result): $i=0;foreach($_result as $key=>$toptype):++$i;$mod = ($i % 2 );$typepro=$toptype[typepro];if($urltype!="static"):$toptype["typeurl"]="__APP__/index.php?m=$toptype[classname]&a=$toptype[methodname]&id=$toptype[id]";else:$toptype["typeurl"]="__APP__/$toptype[classname]/$toptype[typedir]-$toptype[methodname].html";endif;if($typepro==2):$toptype["typeurl"]="$toptype[typedir]";endif;?><li <?php if(($toptype["id"]) == $myfcms["id"]): ?>class="on"<?php endif; ?> >
						  <a href="<?php echo ($toptype["typeurl"]); ?>"><?php echo ($toptype["typename"]); ?></a>
						</li><?php endforeach; endif;?>
					<?php if(empty($topchannelid)): ?><li>欢迎使用MyfCMS系统，中国首家完全免费开源的phpcms系统!</li><?php endif; ?>
				</ul>
				<div class="clear"></div>
			</div>
		</div>
	</div>
</div>
		<div class="banner">
			<img src="__MYFCMSPUBLIC__/images/banner.jpg" />
		</div>
		<div class="main">
			<div class="position">
				<strong>当前位置：</strong>:<?php echo ($myfcms["position"]); ?>
			</div>
			<div class="list-left">
				<div class="content">
					<div class="title">
						<h1>
							<?php echo ($myfcms["typename"]); ?>
						</h1>
					</div>
					<div class="arcbody">
						<?php echo ($myfcms["body"]); ?>
					</div>
				</div>
			</div>
			<div class="list-right">
				<div class="list-sidebar">
					<h2>热门文章</h2>
					<ul>
						<?php $urltype="static"; $_result=D('Archives')->relation(true)->field('body',true)->where("1=1")->order("click desc")->limit("10")->select(); if ($_result): $i=0;foreach($_result as $key=>$vo):++$i;$mod = ($i % 2 ); $arctype=$vo[Arctype];$typedir=$vo[Arctype][typedir];if($urltype!="static"):$vo["arcurl"]="__APP__/index.php?m=Archives&a=$arctype[methodname]&id=$vo[id]";$vo["typeurl"]="__APP__/index.php?m=$arctype[classname]&a=$arctype[methodname]&id=$vo[typeid]";else:$vo["arcurl"]="__APP__/$typedir/$arctype[methodname]-$vo[id].html";$vo["typeurl"]="__APP__/$arctype[classname]/$typedir-$arctype[methodname].html";endif; ?><li>
			                 <a href="<?php echo ($vo["arcurl"]); ?>" title="<?php echo ($vo["title"]); ?>"><?php echo ($vo["title"]); ?></a> 
			                </li><?php endforeach; endif;?>
					</ul>
				</div>
				<div class="list-sidebar">
					<h2>随机文章</h2>
					<ul>
						<?php $urltype="static"; $_result=D('Archives')->relation(true)->field('body',true)->where("1=1")->order("rand()")->limit("10")->select(); if ($_result): $i=0;foreach($_result as $key=>$vo):++$i;$mod = ($i % 2 ); $arctype=$vo[Arctype];$typedir=$vo[Arctype][typedir];if($urltype!="static"):$vo["arcurl"]="__APP__/index.php?m=Archives&a=$arctype[methodname]&id=$vo[id]";$vo["typeurl"]="__APP__/index.php?m=$arctype[classname]&a=$arctype[methodname]&id=$vo[typeid]";else:$vo["arcurl"]="__APP__/$typedir/$arctype[methodname]-$vo[id].html";$vo["typeurl"]="__APP__/$arctype[classname]/$typedir-$arctype[methodname].html";endif; ?><li>
			                 <a href="<?php echo ($vo["arcurl"]); ?>" title="<?php echo ($vo["title"]); ?>"><?php echo ($vo["title"]); ?></a> 
			                </li><?php endforeach; endif;?>
					</ul>
				</div>
			</div>
			<div class="clear"></div>
			<div class="footer">
	<p>
		<a href="?t=default" target="_blank">传统版</a> | <a href="?t=touch" target="_blank">触屏版</a> | <a href="?t=3g" target="_blank">炫彩版</a>
	</p>
	<p class="powered">
		Powered by <a href="http://www.minyifei.cn" title="闵益飞内容管理系统（MyfCMS），中国首家完全开源免费的PHPCMS系统！" target="_blank"><strong>MyfCMS v1.1</strong></a> © 2012 <a href="http://www.minyifei.cn/" target="_blank">minyifei.cn</a> Inc.
		<br>
	</p>
	<p>
		Copyright © 2012 MYFCMS. 版权所有&nbsp;&nbsp;
		<br/>
		All Rights Reserved.
	</p>
</div>
		</div>
		
	</body>
</html>