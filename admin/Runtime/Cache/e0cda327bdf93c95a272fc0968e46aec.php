<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>top</title>
		<link type="text/css" rel="stylesheet" href="__APP__/Public/css/top.css" />
		<script type="text/javascript" src="__APP__/Public/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript">
			function changeMenu(id) {
				$(".nav-box ul li").removeClass("on");
				$("#li_" + id).addClass("on");
				window.parent.frames["left"].changeMenu(id);
			}

			function changeTopMenu(id) {
				$(".nav-box ul li").removeClass("on");
				$("#li_" + id).addClass("on");
			}
		</script>
	</head>
	<body>
		<div class="top-box">
			<div class="logo">
				<a href="<?php echo ($backhome); ?>" target="_blank" title="返回网站"> <img src="__APP__/Public/images/logo.png" alt="myfcms-logo" /> </a>
			</div>
			<div class="login-info">
				<span class="admin"><?php echo ($user["userid"]); ?></span>&nbsp;您好！欢迎登陆在闵益飞内容管理系统！<a href="__APP__/index.php?m=Login&a=out" target="_parent">退出</a>
			</div>
			<div class="nav-box">
				<ul>
					<li id="li_type">
						<a href="__APP__/index.php?m=Arctype&a=main" onclick="changeMenu('type')" target="main">栏目管理</a>
					</li>
					<li class="on" id="li_arc">
						<a href="__APP__/index.php?m=Archives&a=main" onclick="changeMenu('arc')" target="main">文章管理</a>
					</li>
					<li id="li_html">
						<a href="__APP__/index.php?m=Html&a=category" onclick="changeMenu('html')" target="main">生成HTML</a>
					</li>
					<li id="li_pick">
						<a href="__APP__/index.php?m=Collect&a=main" onclick="changeMenu('pick')" target="main">内容采集</a>
					</li>
					<li id="li_flink">
						<a href="__APP__/index.php?m=Flink&a=main" onclick="changeMenu('flink')" target="main">友情链接</a>
					</li>
					<li id="li_tpl">
						<a href="__APP__/index.php?m=Moban&a=main&theme=default" onclick="changeMenu('tpl')" target="main">模板管理</a>
					</li>
					<li id="li_sys">
						<a href="__APP__/index.php?m=Sys&a=main" onclick="changeMenu('sys')" target="main">系统维护</a>
					</li>
				</ul>
			</div>
			<div class="menu-box">
				<div class="nowtime">
					<?php echo ($now); ?>
				</div>
				<div class="fast">
					<ul>
						<li>
							<a href="__APP__/index.php?m=Index&a=main" target="main"> 后台首页 </a>
						</li>
						<li>
							<a href="__APP__/index.php?m=Archives&a=add" onclick="changeMenu('arc')" target="main"> 添加文章 </a>
						</li>
						<li>
							<a href="__APP__/index.php?m=Archives&a=main" onclick="changeMenu('arc')" target="main"> 文章列表 </a>
						</li>
						<li>
							<a href="<?php echo ($htmlurl); ?>" target="_blank">生成首页 </a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</body>
</html>