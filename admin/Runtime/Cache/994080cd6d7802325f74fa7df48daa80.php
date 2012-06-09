<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>系统配置参数</title>
		<link type="text/css" rel="stylesheet" href="__APP__/Public/css/add.css" />
		<script type="text/javascript" src="__APP__/Public/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#btnNew").click(function(){
					window.location.href = "__APP__/index.php?m=Sys&a=add";
				})
				$("tr.c:even").addClass("even"); 
				$("tr.c").hover(function(){
					$(this).addClass("over");
				},function(){
					$(this).removeClass("over");
				})
			})
			
		</script>
		<style type="text/css">
			input[type="text"], input[type="password"] {
					border-width: 1px;
					border-style: solid;
					border-color: #707070 #CECECE #CECECE #707070;
					padding: 2px 4px;
					height: 18px;
					line-height: 18px;
					vertical-align: middle;
				}
				textarea {
					border-width: 1px;
					border-style: solid;
					border-color: #707070 #CECECE #CECECE #707070;
					padding: 2px 4px;
					vertical-align: middle;
					line-height: 16px;
					overflow: auto;
					font-size: 12px
				}
				.even{ 
					background-color:#F9FCEF; 
				} 
				.over{
				}
				.list-btns{
					padding:5px 10px;
				}
		</style>
	</head>
	<body>
		<div class="main">
			<div class="top">
				<div class="position">
					您现在的位置：系统配置参数
				</div>
			</div>
			<div class="list-btns">
				<input type="button" id="btnNew" class="btn" value="新建" />
			</div>
			<div class="center" style="padding:10px;padding-top:0">
				<form action="__APP__/index.php?m=Sys&a=update" method="post">
				<table width="100%" bgcolor="#CFCFCF" cellpadding="1" cellspacing="1">
					<tbody>
						<tr align="center" bgcolor="#fafafa" height="25">
							<td width="300">
								参数说明
							</td>
							<td>
								参数值
							</td>
							<td width="200">
								变量名称
							</td>
						</tr>
						<?php if(is_array($confs)): $i = 0; $__LIST__ = $confs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="c" align="center" bgcolor="#FFFFFF" height="30">
							<td><?php echo ($vo["info"]); ?>：</td>
							<td>
								<?php if(($vo["valuetype"]) == "text"): ?><textarea name="cfg_<?php echo ($vo["id"]); ?>" style="width:80%;height:50px"><?php echo ($vo["value"]); ?></textarea>
								<?php else: ?>
								<input type="text" name="cfg_<?php echo ($vo["id"]); ?>" value="<?php echo ($vo["value"]); ?>" style="width:80%" /><?php endif; ?>
							</td>
							<td><?php echo ($vo["name"]); ?></td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						<tr>
							<td height="28" colspan="3" bgcolor="#F9FCEF" style="padding-left:50px;padding-top:10px;padding-bottom: 10px" >
								<input type="submit" id="btnSubmit" class="btn" value="保存" />
							</td>
						</tr>
					</tbody>
				</table>
				</form>
			</div>
		</div>
		
	</body>
</html>