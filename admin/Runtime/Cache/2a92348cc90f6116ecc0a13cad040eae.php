<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>采集节点内容</title>
		<link type="text/css" rel="stylesheet" href="__APP__/Public/css/add.css" />
		<script type="text/javascript" src="__APP__/Public/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript">
			var tasks = [];
			var totalCount = 0;
			$(document).ready(function(){
				$("#btnSubmit").click(function(){
					var np = 0;
					$(".np").each(function(){
						if($(this).attr("checked") == "checked"){
							np = $(this).val();
						}
					})
					var id = $("#txtId").val();
					$("#divResult").html("正在处理，请稍后……");
					$.ajax({
						url:"__APP__/index.php?m=Collect&a=do_collect_handler",
						data:{id:id,npid:np},
						dataType:"json",
						success:function(msg){
							if(msg["code"]==0){
								$("#divResult").html(msg["info"]);
							}else{
								tasks = msg["info"];
								if(tasks){
									totalCount = tasks.length;
									if(totalCount>2){
										for(var i=0;i<3;i++){
											do_collect_arc();
										}
									}else{
										do_collect_arc();
									}
								}
							}
						}
					})
					return false;
				})
			})
			
			//执行采集任务
			function do_collect_arc(){
				if(tasks && tasks.length>0){
					var lastCount = tasks.length;
					var task = tasks.shift();
					var url = task["href"];
					var title = task["title"];
					var hid = task["hid"];
					
					var info = "总共需采集："+totalCount+"个种子,还剩"+lastCount+"个任务。<br/>";
					info += "下面将采集：<br/>";
					info += "title-->"+title+"<br/>";
					info += "url-->"+url;
					$("#divResult").html(info);
					
					$.ajax({
						url:"__APP__/index.php?m=Collect&a=collect_cohtml_handler",
						data:{hid:hid},
						success:function(msg){
							do_collect_arc();
						}
					})
				}else{
					$("#divResult").html(totalCount+"个种子采集完成");
				}
			}
			
		</script>
	</head>
	<body>
		<div class="main">
			<div class="top">
				<div class="position">
					您现在的位置：<a href="__APP__/index.php?m=Collect&a=main">节点管理</a><span class="split">&gt;</span>采集内容
				</div>
			</div>
			<div class="center">
				<form action="__APP__/index.php?m=Collect&a=main" method="post">
				<table width="100%">
					<tbody>
						<tr height="24" >
							<td class="bline">
								<table width="800" border="0" cellspacing="0" cellpadding="0">
						          <tbody>
						          	<tr>
						            <td width="140">&nbsp;节点名称：</td>
						            <td width="408">
						            	<?php echo ($node["name"]); ?>
						            </td>
						            <td width="262">
						            	<input type="hidden" name="id" id="txtId" value="<?php echo ($node["id"]); ?>" />
						            </td>
						          </tr>
						        </tbody>
						        </table>
							</td>
						</tr>
						<tr height="24" >
							<td class="bline">
								<table width="800" border="0" cellspacing="0" cellpadding="0">
						          <tbody>
						          	<tr>
						            <td width="140">&nbsp;种子网址数：</td>
						            <td width="408">
						            	<?php echo ($node["arccount"]); ?>
						            </td>
						            <td width="262"></td>
						          </tr>
						        </tbody>
						        </table>
							</td>
						</tr>
						<tr>
							<td class="bline">
								<table border="0" cellpadding="0" cellspacing="0" width="800">
						        <tbody><tr>
						          <td width="140">&nbsp;附加选项：</td>
						          <td width="408">
						          	  <input name="np" type="radio" class="np" value="1" checked="1">
								        监控采集模式(检测当前或所有节点是否有新内容)
								                <br>
								        <input name="np" type="radio" class="np" value="-1">
								      	重新下载全部内容
								      	<br>
								        <input name="np" type="radio" class="np" value="0">
								        下载种子网址的未下载内容
								        <br>
						          </td>
						          <td width="262"></td>
						        </tr>
						      </tbody></table>
							</td>
						</tr>
						<tr>
							<td height="28" bgcolor="#F9FCEF" class="bline3" >
								<input type="submit" id="btnSubmit" class="btn" value="开始采集" />
							</td>
						</tr>
						<tr>
							<td height="28" bgcolor="#F9FCEF"  class="bline3" style="padding-left:0px">
								&nbsp;内容采集结果显示区域
							</td>
						</tr>
						<tr>
							<td>
								<div id="divResult" style="padding:10px;height:150px;line-height: 25px;"></div>
							</td>
						</tr>
					</tbody>
				</table>
				</form>
				
			</div>
		</div>
		
	</body>
</html>