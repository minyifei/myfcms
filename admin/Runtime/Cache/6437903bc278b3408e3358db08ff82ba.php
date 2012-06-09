<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>模板管理</title>
<link type="text/css" rel="stylesheet" href="__APP__/Public/css/list.css" />
<script type="text/javascript" src="__APP__/Public/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#btnNew").click(function(){
			window.location.href = "__APP__/index.php?m=Moban&a=add&theme=<?php echo ($theme); ?>";
		})
	})
</script>
</head>
<body>
	<div class="list-main">
		<div class="list-top">
			<div class="position">
				您现在的位置：<?php echo ($name); ?>
			</div>
		</div>
		<div class="list-btns">
			<input type="button" id="btnNew" class="btn" value="新建" />
		</div>
		<div class="list-table">
			<form action="__APP__/index.php?m=Archives&a=update_pro" method="post" id="formArc">
			<table class="tbl" width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#CFCFCF" align="center">
				<tbody>
					<tr class="top" height="25">
						<th width="25%">文件名</th>
						<th width="25%">文件描述</th>
						<th width="25%">修改时间</th>
						<th width="25%">操作</th>
					</tr>
					<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr align="center" bgcolor="#FFFFFF" height="26" onmousemove="javascript:this.bgColor='#fafafa';" onmouseout="javascript:this.bgColor='#FFFFFF';">
						<td align="left">
							./Tpl/<?php echo ($vo["theme"]); ?>/<?php echo ($vo["pathname"]); ?>/<?php echo ($vo["filename"]); ?>.html
						</td>
						<td>
							<?php echo ($vo["info"]); ?>
						</td>
						<td>
							<?php echo ($vo["updatetime"]); ?>
						</td>
						<td>
							<a href="__APP__/index.php?m=Moban&a=update&id=<?php echo ($vo["id"]); ?>">修改</a>
							<?php if(($vo["themetype"]) == "0"): ?><a href="__APP__/index.php?m=Moban&a=delete&id=<?php echo ($vo["id"]); ?>&code=<?php echo ($code); ?>"   onclick="return(confirm('确定删除?删除后模板无法恢复'))">删除</a><?php endif; ?>
						</td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
				</tbody>
			</table>
			</form>
		</div>
		<div class="search">
		</div>
	</div>
</body>
</html>