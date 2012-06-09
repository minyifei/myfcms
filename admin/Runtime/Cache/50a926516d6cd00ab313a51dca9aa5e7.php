<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title>left</title>
		<link type="text/css" rel="stylesheet" href="__APP__/Public/css/left.css" />
		<script type="text/javascript" src="__APP__/Public/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript">
			function changeMenu(id){
				$(".menu-box").removeClass("hide").removeClass("show").addClass("hide");
				$("#menu_help").removeClass("hide").addClass("show");
				$("#menu_"+id).removeClass("hide").addClass("show");
				if(id=="sys"){
					$("#menu_admin").removeClass("hide").addClass("show");
				}
			}
		</script>
	</head>
	<body>
		<div class="left-box">
			<div class="menu-box hide" id="menu_type">
				<div class="menu-title">
					<a href="javascript:void(0)">栏目管理</a>
				</div>
				<div class="menu-list">
					<ul>
						<li>
							<a href="__APP__/index.php?m=Arctype&a=main" target="main">
								网站栏目管理
							</a>
						</li>
						<li>
							<a href="__APP__/index.php?m=Arctype&a=add" target="main">
								添加顶级栏目
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="menu-box show" id="menu_arc">
				<div class="menu-title">
					<a href="javascript:void(0)">文章管理</a>
				</div>
				<div class="menu-list">
					<ul>
						<li>
							<a href="__APP__/index.php?m=Archives&a=main" target="main">
								文章管理
							</a>
						</li>
						<li>
							<a href="__APP__/index.php?m=Archives&a=add" target="main">
								录入新文章
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="menu-box show" id="menu_html">
				<div class="menu-title">
					<a href="javascript:void(0)">生成HTML</a>
				</div>
				<div class="menu-list">
					<ul>
						<li>
							<a href="__APP__/index.php?m=Html&a=category" target="main">
								生成栏目HTML
							</a>
						</li>
						<li>
							<a href="__APP__/index.php?m=Html&a=archives" target="main">
								生成文章HTML
							</a>
						</li>
						<li>
							<a href="<?php echo ($htmlurl); ?>" target="_blank">
								生成首页HTML
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="menu-box hide" id="menu_pick">
				<div class="menu-title">
					<a href="javascript:void(0)">内容采集</a>
				</div>
				<div class="menu-list">
					<ul>
						<li>
							<a href="__APP__/index.php?m=Collect&a=main" target="main">
								采集节点管理
							</a>
						</li>
						<li>
							<a href="__APP__/index.php?m=Collect&a=add" target="main">
								添加新节点
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="menu-box hide" id="menu_flink">
				<div class="menu-title">
					<a href="javascript:void(0)">友情链接</a>
				</div>
				<div class="menu-list">
					<ul>
						<li>
							<a href="__APP__/index.php?m=Flink&a=main" target="main">
								友情链接管理
							</a>
						</li>
						<li>
							<a href="__APP__/index.php?m=Flink&a=add" target="main">
								添加新链接
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="menu-box hide" id="menu_tpl">
				<div class="menu-title">
					<a href="javascript:void(0)">模板管理</a>
				</div>
				<div class="menu-list">
					<ul>
						<li>
							<a href="__APP__/index.php?m=Moban&a=main&theme=default" target="main">
								默认模板管理
							</a>
						</li>
						<li>
							<a href="__APP__/index.php?m=Moban&a=main&theme=touch" target="main">
								触屏模板管理
							</a>
						</li>
						<li>
							<a href="__APP__/index.php?m=Moban&a=main&theme=3g" target="main">
								3G模板管理
							</a>
						</li>
						<!-- <li>
							<a href="__APP__/index.php?m=Moban&a=main&theme=2g" target="main">
								简版模板管理
							</a>
						</li> -->
					</ul>
				</div>
			</div>
			<div class="menu-box hide" id="menu_sys">
				<div class="menu-title">
					<a href="javascript:void(0)">系统设置</a>
				</div>
				<div class="menu-list">
					<ul>
						<li>
							<a href="__APP__/index.php?m=Sys&a=main" target="main">
								系统基本参数
							</a>
						</li>
						<li>
							<a href="__APP__/index.php?m=Db&a=index" target="main">
								数据库备份/还原
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="menu-box hide" id="menu_admin">
				<div class="menu-title">
					<a href="javascript:void(0)">管理员管理</a>
				</div>
				<div class="menu-list">
					<ul>
						<li>
							<a href="__APP__/index.php?m=User&a=main" target="main">
								管理员管理
							</a>
						</li>
						<li>
							<a href="__APP__/index.php?m=User&a=add" target="main">
								添加管理员
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="menu-box" id="menu_help">
				<div class="menu-title">
					<a href="javascript:void(0)">系统帮助</a>
				</div>
				<div class="menu-list">
					<ul>
						<li>
							<a href="http://www.minyifei.cn/help" target="_blank">
								参考文档
							</a>
						</li>
						<li>
							<a href="http://bbs.minyifei.cn/suggent" target="_blank">
								意见建议反馈
							</a>
						</li>
						<li>
							<a href="http://bbs.minyifei.cn" target="_blank">
								官方交流论坛
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</body>
</html>