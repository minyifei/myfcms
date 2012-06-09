<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>友情链接管理</title>
<link type="text/css" rel="stylesheet" href="__APP__/Public/css/list.css" />
<script type="text/javascript" src="__APP__/Public/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#btnNew").click(function(){
			window.location.href = "__APP__/index.php?m=Flink&a=add";
		})
		$("#btnAll").click(function(){
			$(".chkid").attr("checked","checked");
		})
		$("#btnCanel").click(function(){
			$(".chkid").attr("checked",false);
		})
		//删除
		$("#btnDelete").click(function(){
			var action = "__APP__/index.php?m=Flink&a=deletes";
			var num = 0;
			$(".chkid").each(function(i){
				if($(this).attr("checked")=="checked"){
					num++;
				}
			})
			if(num>0){
				if(confirm("删除后数据无法恢复！确认删除吗？")){
					$("#formLink").attr("action",action);
					$("#formLink").submit();
				}					
			}else{
				alert("请选择要删除的文章");
			}
		})
		
		$("#btnUpdateSort").click(function(){
			var action = "__APP__/index.php?m=Flink&a=sort_rank";
			$("#formLink").attr("action",action);
			$("#formLink").submit();
		})
	})
</script>
</head>
<body>
	<div class="list-main">
		<div class="list-top">
			<div class="position">
				您现在的位置：友情链接管理
			</div>
		</div>
			<form action="__APP__/index.php?m=Flink&a=sort_rank" method="post" id="formLink">
		<div class="list-btns">
			<input type="button" id="btnNew" class="btn" value="新建" />
			<input type="button" id="btnAll" class="btn" value="全选" />
			<input type="button" id="btnCanel" class="btn" value="取消" />
			<input type="submit" id="btnUpdateSort" class="bigbtn" value="更新排序" />
			<input type="button" id="btnDelete" class="bigbtn" value="批量删除" />
		</div>
		<div class="list-table">
			<table class="tbl" width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#CFCFCF" align="center">
				<tbody>
					<tr class="top" height="25">
						<th width="4%">选择</th>
						<th width="33%">网站名称</th>
						<th width="10%">网站logo</th>
						<th  width="6%">时间</th>
						<th width="12%">顺序</th>
						<th width="10%">操作</th>
					</tr>
					<?php if(is_array($links)): $i = 0; $__LIST__ = $links;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr align="center" bgcolor="#FFFFFF" height="26" onmousemove="javascript:this.bgColor='#fafafa';" onmouseout="javascript:this.bgColor='#FFFFFF';">
							<td><input type="checkbox" id="chkId<?php echo ($vo["id"]); ?>" class="chkid" name="linkId[]" value="<?php echo ($vo["id"]); ?>"/></td>
							<td align="left">
								<a href="<?php echo ($vo["url"]); ?>" target="_blank"><?php echo ($vo["webname"]); ?></a>
							</td>
							<td>
							<?php if(empty($vo["logo"])): ?>无图标
								<?php else: ?> 
								<img style="height:30px;" src="<?php echo ($vo["logo"]); ?>" /><?php endif; ?>
							</td>
							<td><div style="width:66px;height:11px;overflow:hidden" title="<?php echo ($vo["sendtime"]); ?>"><?php echo ($vo["dtime"]); ?></td>
							<td>
								<input type="text" value="<?php echo ($vo["sortrank"]); ?>" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')" name="sortrank_<?php echo ($vo["id"]); ?>" id="txtSortrank<?php echo ($vo["id"]); ?>" class="txtlit" />
							</td>
							<td>
								<a href="__APP__/index.php?m=Flink&a=update&id=<?php echo ($vo["id"]); ?>">[更改]</a>&nbsp;
								<a href="__APP__/index.php?m=Flink&a=delete&id=<?php echo ($vo["id"]); ?>"  onclick="return(confirm('确定删除?'))">[删除]</a>
							</td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
				</tbody>
			</table>
			</form>
		</div>
	</div>
	</form>
</body>
</html>