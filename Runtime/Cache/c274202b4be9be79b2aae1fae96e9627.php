<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title><?php echo ($myfcms["title"]); ?>-<?php $_result=M("sys")->where("name='cfg_webname'")->select();if($_result) echo $_result[0][value]; ?></title>
		<meta name="description" content="<?php echo (htmlspecialchars($myfcms["description"])); ?>" />
		<meta name="keywords" content="<?php echo ($myfcms["keywords"]); ?>" />
		<meta name="author" content="minyifei" />
		<meta name="viewport" content="width=device-width; initial-scale=1.0" />
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="apple-touch-icon" href="/apple-touch-icon.png" />
		<link type="text/css" rel="stylesheet" href="__MYFCMSPUBLIC__/css/t-main.css" />
	</head>
	<body>
		<div class="main">
			<div class="top">
	<div class="logo">
		<a href="__MYFCMS__/"> <img src="__MYFCMSPUBLIC__/images/t-logo.jpg" /> </a>
	</div>
</div>
<div class="nav-menu">
	<ul>
		<li> 
			<a  <?php if(empty($topchannelid)): ?>class="on"<?php endif; ?>  href="__MYFCMS__/">首页</a>
		</li>
		<?php $urltype="html"; $_result=M('arctype')->field('body',true)->where("1=1  and topid=0")->order("sortrank asc")->select(); if ($_result): $i=0;foreach($_result as $key=>$toptype):++$i;$mod = ($i % 2 );$typepro=$toptype[typepro];if($urltype=="static"):$toptype["typeurl"]="__APP__/$toptype[classname]/$toptype[typedir]-$toptype[methodname].html";elseif($urltype=="html"):$toptype["typeurl"]="__APP__/category/$toptype[typedir]/$arcfix";else:$toptype["typeurl"]="__APP__/index.php?m=$toptype[classname]&a=$toptype[methodname]&id=$toptype[id]";endif;if($typepro==2):$toptype["typeurl"]="$toptype[typedir]";endif;?><li>
			  <a  <?php if(($toptype["id"]) == $topchannelid): ?>class="on"<?php endif; ?>  href="<?php echo ($toptype["typeurl"]); ?>"><?php echo ($toptype["typename"]); ?></a>
			</li><?php endforeach; endif;?>
	</ul>
	<div class="clear"></div>
</div>
			<div class="position">
				<strong>当前位置：</strong>:<?php echo ($myfcms["position"]); ?>
			</div>
			<div class="content">
				<div class="title">
					<h1>
						<?php echo ($myfcms["title"]); ?>
					</h1>
				</div>
				<p class="info">
						时间：<small><?php echo ($myfcms["sendtime"]); ?></small>
						点击：<small><?php echo ($myfcms["click"]); ?>次</small><br/>
						作者：<em><?php echo ($myfcms["writer"]); ?></em>
						来源：<em><?php echo ($myfcms["source"]); ?></em>
					</p>
					<div class="arcbody">
						<?php echo ($myfcms["body"]); ?>
					</div>
					<p class="arcnav">
						上一篇：<?php echo ($myfcms["pre"]); ?><br/>
						下一篇：<?php echo ($myfcms["next"]); ?>
					</p>
			</div>
			<div class="footer">
	<p>
		<a href="?t=default" target="_blank">传统版</a> | <a href="?t=touch" target="_blank">触屏版</a> | <a href="?t=3g" target="_blank">炫彩版</a>
	</p>
	<div class="clear"></div>
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