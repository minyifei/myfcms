<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title>MyfCMS安装</title>
		<meta name="description" content="" />
		<meta name="author" content="minyifei" />
		<meta name="viewport" content="width=device-width; initial-scale=1.0" />
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="apple-touch-icon" href="/apple-touch-icon.png" />
		<script type="text/javascript" src="__MYFCMSPUBLIC__/js/jquery.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				var url = location.href;
				var url = window.location.protocol+"//"+window.location.host;
				$("#txtBaseHost").val(url);
				
				$("#btnVerr").click(function(){
					$("#divInfo").html("");
					var dbhost = $("#txtDbhost").val();
					var dbport = $("#txtDbport").val();
					var dbname = $("#txtDbname").val();
					var dbuser = $("#txtDbuser").val();
					var dbpwd = $("#txtDbpwd").val();
					$.ajax({
						url:"__APP__/index.php?m=Install&a=check",
						type:"POST",
						data:{dbhost:dbhost,dbport:dbport,dbname:dbname,dbuser:dbuser,dbpwd:dbpwd},
						dataType:"json",
						success:function(d){
							$("#divInfo").html(d["msg"]);
						}
					})
				})
			})
		</script>
		<style type="text/css">
			.main{
				width:706px;
				margin:0 auto;
			}
			h1{
				text-align:center;
				font-size:24px;
				margin:5px;
				padding:0;
				margin-bottom:0;
			}
			h1 img{
				vertical-align: middle;
				width:50px;
				height:50px;
			}
			.box{
				margin-top:10px;
			}
			.title{
				height:30px;
				line-height:30px;
				font-size:12px;
				font-weight:bold;
			}
			table{
				width: 706px;
				border: 1px solid #CFDCC9;
				font-size: 12px;
				overflow: hidden;
				margin: 8px auto;
			}
			td{
				padding: 7px;
				border-bottom: 1px solid #F2F2F2;
				color: #333;
				vertical-align: top;
			}
			.left{
				width:100px;
				font-weight:bold;
				text-align:right;
				line-height:30px;
			}
			.txt{
				padding: 4px 8px 4px 6px;
				border: 1px solid #AAA;
				font-size: 12px;
				color: black;
				width: 200px;
			}
			.right{
				width:350px;
				line-height:30px;
				color: #888;
			}
			.btn{
				width:100px;
				height:30px;
			}
			.footer{
				text-align:center;
				font-family: arial;
			}
		</style>
	</head>
	<body>
			<div class="header">
				<h1>
					<img src="__APP__/Public/Images/logo.png" />
					MyfCMS安装</h1>
			</div>
		<div class="main">
			<div class="center">
				<form action="__APP__/index.php?m=Install&a=step" method="post">
					<div class="box">
						<div class="title">
							数据库设定
						</div>
					<table cellpadding="0" cellspacing="0">
						<tr>
							<td class="left">
								数据库主机：
							</td>
							<td>
								<input type="text" class="txt" name="dbhost" id="txtDbhost" value="localhost" />
							</td>
							<td class="right">
								一般为localhost
							</td>
						</tr>
						<tr>
							<td class="left">
								数据库端口：
							</td>
							<td>
								<input type="text" class="txt" name="dbport" id="txtDbport" value="3306" />
							</td>
							<td></td>
						</tr>
						<tr>
							<td class="left">
								数据库名称：
							</td>
							<td>
								<input type="text" class="txt" name="dbname" id="txtDbname" value="myfcmsv1" />
							</td>
							<td></td>
						</tr>
						<tr>
							<td class="left">
								数据库用户：
							</td>
							<td>
								<input type="text" class="txt" name="dbuser" id="txtDbuser" value="root" />
							</td>
							<td></td>
						</tr>
						<tr>
							<td class="left">
								数据库密码：
							</td>
							<td>
								<input type="text" class="txt" name="dbpwd" id="txtDbpwd" />
							</td>
							<td></td>
						</tr>
						<tr>
							<td>
							 &nbsp;&nbsp;	<input type="button" id="btnVerr" value="验证" />
							</td>
							<td colspan="2">
								<div id="divInfo"></div>
							</td>
						</tr>						
					</table>
					
					</div>
					<div class="box">
						<div class="title">
							管理员信息
						</div>
						<table cellpadding="0" cellspacing="0">
							<tr>
							<td class="left">
								用户名：
							</td>
							<td>
								<input type="text" class="txt" name="userid"  value="admin"/>
							</td>
							<td class="right">
								只能用'0-9'、'a-z'、'A-Z'、'.'、'@'、'_'、'-'
							</td>
						</tr>
						<tr>
							<td class="left">
								密码：
							</td>
							<td>
								<input type="text" class="txt" name="pwd"  value="admin"/>
							</td>
							<td></td>
						</tr>
						<tr>
							<td class="left">
								管理员邮箱：
							</td>
							<td>
								<input type="text" class="txt" name="adminemail"  value="admin@web.com"/>
							</td>
							<td></td>
						</tr>
						</table>
					</div>
					<div class="box">
						<div class="title">
							网站设置
						</div>
						<table cellpadding="0" cellspacing="0">
							<tr>
							<td class="left">
								网站名称：
							</td>
							<td>
								<input type="text" class="txt" name="webname"  value="我的网站"/>
							</td>
							<td></td>
						</tr>
						<tr>
							<td class="left">
								网站网址：
							</td>
							<td>
								<input type="text" class="txt" name="basehost"  id="txtBaseHost" value=""/>
							</td>
							<td></td>
						</tr>
						<tr>
							<td class="left">
								CMS安装目录：
							</td>
							<td>
								<input type="text" class="txt" name="indexurl" id="txtIndexUrl"  value="<?php echo ($indexurl); ?>"/>
							</td>
							<td class="right">
								在根目录安装时不必理会
							</td>
						</tr>
						</table>
					</div>
					<div class="bottom">
						<input type="submit" class="btn" value="提交" />
					</div>
				</form>
			</div>
			<div class="footer">
				<p>
					&copy; Copyright  by <a href="http://www.minyifei.cn" target="_blank">MyfCMS</a>
				</p>
			</div>
		</div>
	</body>
</html>