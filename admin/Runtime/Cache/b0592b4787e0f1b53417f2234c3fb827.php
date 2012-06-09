<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title>闵益飞内容管理系统-后台登陆</title>
		<meta name="description" content="" />
		<meta name="author" content="minyifei" />
		<link rel="shortcut icon" href="/favicon.ico" />
		<link type="text/css" rel="stylesheet" href="__APP__/Public/css/reset.css"/>
		<link type="text/css" rel="stylesheet" href="__APP__/Public/css/login.css"/>
		<script type="text/javascript" src="__APP__/Public/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript">
			function changeAuthCode(){
				 var picsrc =$("#vdimgck").attr("src");
				 $("#vdimgck").attr("src",picsrc);
			}
			
			$(document).ready(function(){
				$("#btnSubmit").click(function(){
					var userid = $("#txtUserid").val();
					if(userid==""){
						alert("用户名不能为空！");
						return false;
					}
					
					var pwd = $("#txtPwd").val();
					if(pwd==""){
						alert("密码不能为空！");
						return false;
					}
					
					var code = $("#vdcode").val();
					if(code==""){
						alert("验证码不能为空！");
						return false;
					}
				})
			})
		</script>
	</head>
	
	<body>
		<div class="login-box">
			<div class="login-top">
				<a href=".././">返回网站主页</a>
			</div>
			<div class="login-tips" style="text-align: center">
				感谢使用MyfCMS系统，中国第一款完全免费开源的PHPCMS系统！
			</div>
			<div class="login-main">
					<form name="form1" method="post" action="__APP__/index.php?m=Login&a=login_in">
					<dl>
						<dt>
							用户名：
						</dt>
						<dd>
							<input name="userid" id="txtUserid" type="text">
						</dd>
						<dt>
							密&nbsp;&nbsp;码：
						</dt>
						<dd>
							<input class="alltxt" id="txtPwd" name="pwd" type="password">
						</dd>
						<dt>
							验证码：
						</dt>
						<dd>
							<input id="vdcode" name="verify" style="text-transform: uppercase;" type="text">
							<img id="vdimgck" style="cursor: pointer;" alt="看不清？点击更换" src="__APP__/index.php?m=Login&a=verify" align="absmiddle">
							<a href="javascript:changeAuthCode()">看不清？ </a>
						</dd>
						<dt>
							&nbsp;
						</dt>
						<dd>
							<button type="submit" class="login-btn" id="btnSubmit">
								登录
							</button>
						</dd>
					</dl>
				</form>
			</div>
			<div class="login-copy">
				Powered by<a href="http://www.minyifei.cn" title="MyfCMS官网" target="_blank"><strong>MyfCMS 1.0</strong></a>&copy; 2012
			</div>
		</div>
	</body>
</html>