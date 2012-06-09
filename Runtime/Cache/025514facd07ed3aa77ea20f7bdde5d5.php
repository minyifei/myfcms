<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title><?php echo ($myfcms["typename"]); ?>-<?php $_result=M("sys")->where("name='cfg_webname'")->select();if($_result) echo $_result[0][value]; ?></title>
		<meta name="description" content="<?php $_result=M("sys")->where("name='cfg_description'")->select();if($_result) echo $_result[0][value]; ?>" />
		<meta name="keywords" content="<?php $_result=M("sys")->where("name='cfg_keywords'")->select();if($_result) echo $_result[0][value]; ?>" />
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
		<?php $urltype="static"; $_result=M('arctype')->field('body',true)->where("1=1  and topid=0")->order("sortrank asc")->select(); if ($_result): $i=0;foreach($_result as $key=>$toptype):++$i;$mod = ($i % 2 );$typepro=$toptype[typepro];if($urltype!="static"):$toptype["typeurl"]="__APP__/index.php?m=$toptype[classname]&a=$toptype[methodname]&id=$toptype[id]";else:$toptype["typeurl"]="__APP__/$toptype[classname]/$toptype[typedir]-$toptype[methodname].html";endif;if($typepro==2):$toptype["typeurl"]="$toptype[typedir]";endif;?><li>
			  <a  <?php if(($toptype["id"]) == $topchannelid): ?>class="on"<?php endif; ?>  href="<?php echo ($toptype["typeurl"]); ?>"><?php echo ($toptype["typename"]); ?></a>
			</li><?php endforeach; endif;?>
	</ul>
	<div class="clear"></div>
</div>
			<div class="position">
				<strong>当前位置：</strong>:<?php echo ($myfcms["position"]); ?>
			</div>
			<div class="list-item blank">
				<h2>
					<a href="javascript:void(0)">最新文章</a>
				</h2>
				<ul>
					<?php  $m_arctype = M("arctype");$child = $m_arctype->where("topid=$topchannelid")->select();$typeids=$topchannelid;if($child):foreach ($child as $kk => $v):$typeids .=",".$v[id];endforeach;endif;$urltype="static"; $_result=D('Archives')->relation(true)->field('body',true)->where("1=1 and typeid in($typeids)")->order("id desc")->limit("10")->select(); if ($_result): $i=0;foreach($_result as $key=>$vo):++$i;$mod = ($i % 2 ); $arctype=$vo[Arctype];$typedir=$vo[Arctype][typedir];if($urltype!="static"):$vo["arcurl"]="__APP__/index.php?m=Archives&a=$arctype[methodname]&id=$vo[id]";$vo["typeurl"]="__APP__/index.php?m=$arctype[classname]&a=$arctype[methodname]&id=$vo[typeid]";else:$vo["arcurl"]="__APP__/$typedir/$arctype[methodname]-$vo[id].html";$vo["typeurl"]="__APP__/$arctype[classname]/$typedir-$arctype[methodname].html";endif; ?><li>
		                 <a href="<?php echo ($vo["arcurl"]); ?>" title="<?php echo ($vo["title"]); ?>" target="_blank"><?php echo (myfsubstr($vo["title"],0,16)); ?></a>&nbsp;<?php echo (date("m-d",strtotime($vo["sendtime"]))); ?> 
		                </li><?php endforeach; endif;?>
				</ul>
			</div>
			 <?php $urltype="static"; $_result=M('arctype')->field('body',true)->where("1=1  and topid=$topchannelid")->order("sortrank asc")->select(); if ($_result): $i=0;foreach($_result as $key=>$childtype):++$i;$mod = ($i % 2 );$typepro=$childtype[typepro];if($urltype!="static"):$childtype["typeurl"]="__APP__/index.php?m=$childtype[classname]&a=$childtype[methodname]&id=$childtype[id]";else:$childtype["typeurl"]="__APP__/$childtype[classname]/$childtype[typedir]-$childtype[methodname].html";endif;if($typepro==2):$childtype["typeurl"]="$childtype[typedir]";endif;?><div class="list-item blank">
					<h2>
						<a href="<?php echo ($childtype["typeurl"]); ?>"><?php echo ($childtype["typename"]); ?></a>
					</h2>
					<ul>
						<?php  $m_arctype = M("arctype");$child = $m_arctype->where("topid=$childtype[id]")->select();$typeids=$childtype[id];if($child):foreach ($child as $kk => $v):$typeids .=",".$v[id];endforeach;endif;$urltype="static"; $_result=D('Archives')->relation(true)->field('body',true)->where("1=1 and typeid in($typeids)")->order("id desc")->limit("8")->select(); if ($_result): $i=0;foreach($_result as $key=>$vo):++$i;$mod = ($i % 2 ); $arctype=$vo[Arctype];$typedir=$vo[Arctype][typedir];if($urltype!="static"):$vo["arcurl"]="__APP__/index.php?m=Archives&a=$arctype[methodname]&id=$vo[id]";$vo["typeurl"]="__APP__/index.php?m=$arctype[classname]&a=$arctype[methodname]&id=$vo[typeid]";else:$vo["arcurl"]="__APP__/$typedir/$arctype[methodname]-$vo[id].html";$vo["typeurl"]="__APP__/$arctype[classname]/$typedir-$arctype[methodname].html";endif; ?><li>
			                 <a href="<?php echo ($vo["arcurl"]); ?>" title="<?php echo ($vo["title"]); ?>" target="_blank"><?php echo (myfsubstr($vo["title"],0,16)); ?></a>&nbsp;<?php echo (date("m-d",strtotime($vo["sendtime"]))); ?> 
			                </li><?php endforeach; endif;?>
					</ul>
				</div><?php endforeach; endif;?>
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