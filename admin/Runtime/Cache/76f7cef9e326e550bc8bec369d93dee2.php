<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>list</title>
<link type="text/css" rel="stylesheet" href="__APP__/Public/css/list.css" />
<style type="text/css">
	.copyright{
		border-top: 1px solid #CFD7C4;
		line-height: 36px;
		margin-top: 8px;
		font-family: Verdana,Geneva,sans-serif;
		text-align: center
	}
	.left{
		width:48%;
		float:left;
	}
	.right{
		width:48%;
		float:left;
		margin-left:10px;
	}
	.clear{
		clear: both;
	}
	.box{
		border: 1px solid #DADADA;
		margin:10px;
		width:98%;
		margin-left:20px;
	}
	.title{
		height:30px;
		background: #F3F3F3;
		border-bottom: 1px solid #DADADA;
		line-height:30px;
		padding-left:10px;
		font-weight:bold;
	}
	.list{
		padding:10px;
		line-height:25px;
	}
	.list ul,.list li{
		padding:0;
		margin:0;
	}
	.list li{
		margin-left:15px;
	}
	span.time{
		color:#666;
	}
</style>
<script type="text/javascript">
</script>
</head>
<body>
	<div class="list-main">
		<div class="list-top">
			<div class="position">
				您现在的位置：系统主页
			</div>
		</div>
		<div class="list-table">
			<div class="left">
				<div class="box">
					<div class="title">
						快捷操作
					</div>
					<div class="list">
						<table width="80%">
							<tr>
								<td>
								<a href="__APP__/index.php?m=Archives&a=main">文章管理</a>	
								</td>
								<td>
									<a href="__APP__/index.php?m=Archives&a=add">内容发布</a>
								</td>
								<td>
									<a href="__APP__/index.php?m=Arctype&a=main">栏目管理</a>
								</td>
								<td>
									<a href="__APP__/index.php?m=Sys&a=main">系统参数</a>
								</td>
							</tr>
						</table>
					</div>
				</div>
				<div class="box">
					<div class="title">
						程序团队
					</div>
					<div class="list">
						<table width="80%">
							<tr>
								<td width="100">
									主程序：
								</td>
								<td>
									<a href="http://www.minyifei.cn" target="_blank">闵益飞团队</a>
								</td>
							</tr>
							<tr>
								<td width="100">
									版本：
								</td>
								<td>
									<a href="http://www.minyifei.cn/version" title="查看最新版本" target="_blank"><?php echo ($version); ?></a>
								</td>
							</tr>
							<tr>
								<td width="100">
									交流论坛：
								</td>
								<td>
									<a href="http://bbs.minyifei.cn" target="_blank">交流论坛</a>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			<div class="right">
				<div class="box">
					<div class="title">
						信息统计
					</div>
					<div class="list">
						<table width="80%">
							<tr>
								<td width="80">管理员数：</td>
								<td align="left">
									<b><?php echo ($c_admin); ?></b>
								</td>
								<td width="50">文章数：</td>
								<td align="left">
									<b><?php echo ($c_arc); ?></b>
								</td>
							</tr>
						</table>
					</div>
				</div>
				
				<div class="box">
					<div class="title">
						最新文章
					</div>
					<div class="list">
						<ul>
							<?php if(is_array($arcs)): $i = 0; $__LIST__ = $arcs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
								<a href="javascript:void(0)" target="_blank"><?php echo ($vo["title"]); ?></a> <span class="time"><?php echo ($vo["sendtime"]); ?></span>
							</li><?php endforeach; endif; else: echo "" ;endif; ?>
						</ul>
					</div>
				</div>
			</div>
			<div class="clear"></div>
			<div class="copyright">
				Copyright © 2012 <a href="http://www.minyifei.cn" target="_blank"><u>MyfCMS</u></a>. 飞跃技术  版权所有
			</div>
		</div>
	</div>
</body>
</html>