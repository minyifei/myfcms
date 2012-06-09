<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>管理员管理</title>
<link type="text/css" rel="stylesheet" href="__APP__/Public/css/list.css" />
<script type="text/javascript" src="__APP__/Public/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#btnNew").click(function(){
			window.location.href = "__APP__/index.php?m=User&a=add";
		})
	})
</script>
</head>
<body>
	<div class="list-main">
		<div class="list-top">
			<div class="position">
				您现在的位置：管理员管理
			</div>
		</div>
		<div class="list-btns">
			<input type="button" id="btnNew" class="btn" value="新建" />
		</div>
		<div class="list-table">
			<table class="tbl" width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#CFCFCF" align="center">
				<tbody>
					<tr class="top" height="25">
						<th width="33%">登录ID</th>
						<th width="10%">笔名</th>
						<th width="12%">登录时间</th>
						<th width="12%">登录IP</th>
						<th width="12%">创建时间</th>
						<th width="10%">操作</th>
					</tr>
					<?php if(is_array($users)): $i = 0; $__LIST__ = $users;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr align="center" bgcolor="#FFFFFF" height="26" onmousemove="javascript:this.bgColor='#fafafa';" onmouseout="javascript:this.bgColor='#FFFFFF';">
							<td align="center">
								<?php echo ($vo["userid"]); ?>
							</td>
							<td>
							<?php echo ($vo["uname"]); ?>
							</td>
							<td>
								<?php echo ($vo["logintime"]); ?>
							</td>
							<td>
								<?php echo ($vo["loginip"]); ?>
							</td>
							<td>
								<?php echo ($vo["createtime"]); ?>
							</td>
							<td>
								<a href="__APP__/index.php?m=User&a=update&id=<?php echo ($vo["id"]); ?>">[更改]</a>&nbsp;
								<a href="__APP__/index.php?m=User&a=delete&id=<?php echo ($vo["id"]); ?>">[删除]</a>
							</td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
				</tbody>
			</table>
		</div>
	</div>
	</form>
</body>
</html>