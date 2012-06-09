<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>list</title>
<link type="text/css" rel="stylesheet" href="__APP__/Public/css/list.css" />
<script type="text/javascript" src="__APP__/Public/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#btnAddTop").click(function(){
			window.location.href = "__APP__/index.php?m=Arctype&a=add";
		})
		
		
	})
</script>
</head>
<body>
	<div class="list-main">
		<div class="list-top">
			<div class="position">
				您现在的位置：栏目管理
			</div>
		</div>
		<form action="__APP__/index.php?m=Arctype&a=sort_rank" method="post">
		<div class="list-btns">
			<input type="button" id="btnAddTop" class="bigbtn" value="增加顶级栏目" />
			<input type="submit" id="btnUpdateSort" class="bigbtn" value="更新排序" />
		</div>
		<div class="list-table">
			<table class="tbl" width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#CFCFCF" align="center">
				<tbody>
					<tr class="top" height="25">
						<th width="6%">ID</th>
						<th width="47%">栏目名称</th>
						<th width="15%">属性</th>
						<th width="30%">操作</th>
					</tr>
					<?php if(is_array($arctypes)): $i = 0; $__LIST__ = $arctypes;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$d): $mod = ($i % 2 );++$i;?><tr align="center" bgcolor="#fafafa" height="26">
							<td><?php echo ($d["id"]); ?></td>
							<td align="left"><?php echo ($d["typename"]); ?></td>
							<td>
								<?php if($d["typepro"] == 2): ?>外部连接
								<?php elseif($d["typepro"] == 1): ?>
								封面栏目
								<?php elseif($d["typepro"] == 3): ?>
								单页栏目
								<?php else: ?> 
								最终列表栏目<?php endif; ?>
							</td>
							<td>
								<?php if($d["typepro"] != 2): ?><a href="<?php echo ($weburl); ?>/index.php?m=<?php echo ($d["classname"]); ?>&a=<?php echo ($d["methodname"]); ?>&id=<?php echo ($d["id"]); ?>" target="_blank">预览</a><span class="split">|</span>
									<?php if(($d["typepro"] != 3)): ?><a href="__APP__/index.php?m=Archives&a=main&typeid=<?php echo ($d["id"]); ?>">内容</a><span class="split">|</span><?php endif; ?>
									<a href="__APP__/index.php?m=Arctype&a=add&topid=<?php echo ($d["id"]); ?>">增加子类</a><span class="split">|</span>
								<?php else: ?>
									<a href="<?php echo ($d["typedir"]); ?>" target="_blank">预览</a><span class="split">|</span>
									<a href="__APP__/index.php?m=Arctype&a=add&topid=<?php echo ($d["id"]); ?>">增加子类</a><span class="split">|</span><?php endif; ?>
								<a href="__APP__/index.php?m=Arctype&a=update&id=<?php echo ($d["id"]); ?>">更改</a><span class="split">|</span>
								<a href="__APP__/index.php?m=Arctype&a=delete_handler&id=<?php echo ($d["id"]); ?>"  onclick="return(confirm('确定删除?请确保要删除的栏目没有子栏目并且栏目下没有文章'))">删除</a> <span class="split"></span>
								<input type="text" value="<?php echo ($d["sortrank"]); ?>" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')" name="sortrank_<?php echo ($d["id"]); ?>" id="txtSortrank<?php echo ($d["id"]); ?>" class="txtlit" />
							</td>
						</tr>
						<?php if(is_array($d["childs"])): $i = 0; $__LIST__ = $d["childs"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$child): $mod = ($i % 2 );++$i;?><tr align="center" bgcolor="#FFFFFF" height="26" onmousemove="javascript:this.bgColor='#FAFAF1';" onmouseout="javascript:this.bgColor='#FFFFFF';">
							<td><?php echo ($child["id"]); ?></td>
							<td align="left">--<?php echo ($child["typename"]); ?></td>
							<td>
								<?php if($child["typepro"] == 2): ?>外部连接
								<?php elseif($child["typepro"] == 1): ?>
								封面栏目
								<?php elseif($child["typepro"] == 3): ?>
								单页栏目
								<?php else: ?> 
								最终列表栏目<?php endif; ?>
							</td>
							<td>
								<?php if(($child["typepro"] != 2)): ?><a href="<?php echo ($weburl); ?>/index.php?m=<?php echo ($child["classname"]); ?>&a=<?php echo ($child["methodname"]); ?>&id=<?php echo ($child["id"]); ?>" target="_blank">预览</a><span class="split">|</span>
									<?php if(($child["typepro"] != 3)): ?><a href="__APP__/index.php?m=Archives&a=main&typeid=<?php echo ($child["id"]); ?>">内容</a><span class="split">|</span><?php endif; ?>
									<?php else: ?>
									<a href="<?php echo ($child["typedir"]); ?>" target="_blank">预览</a><span class="split">|</span><?php endif; ?>
								<a href="__APP__/index.php?m=Arctype&a=update&id=<?php echo ($child["id"]); ?>">更改</a><span class="split">|</span>
								<a href="__APP__/index.php?m=Arctype&a=delete_handler&id=<?php echo ($child["id"]); ?>"  onclick="return(confirm('确定删除?请确保要删除的栏目没有子栏目并且栏目下没有文章'))">删除</a> <span class="split"></span>
								<input type="text" value="<?php echo ($child["sortrank"]); ?>" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')" name="sortrank_<?php echo ($child["id"]); ?>" id="txtSortrank<?php echo ($child["id"]); ?>" class="txtlit" />
							</td>
						</tr><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
				</tbody>
			</table>
		</div>
		</form>
		<div class="search">
		</div>
	</div>
</body>
</html>