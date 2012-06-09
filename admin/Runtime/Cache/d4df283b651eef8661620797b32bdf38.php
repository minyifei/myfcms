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
			window.location.href = "__APP__/index.php?m=Collect&a=add";
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
		<div class="list-btns">
			<input type="button" id="btnNew" class="btn" value="新建" />
		</div>
		<div class="list-table">
			<table class="tbl" width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#CFCFCF" align="center">
				<tbody>
					<tr class="top" height="25">
						<th width="4%">编号</th>
						<th width="24%">节点名称</th>
						<th width="12%">最后采集时间</th>
						<th  width="12%">加入时间</th>
						<th width="6%">网址数</th>
						<th width="17%">操作</th>
					</tr>
					<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr align="center" bgcolor="#FFFFFF" height="26" onmousemove="javascript:this.bgColor='#fafafa';" onmouseout="javascript:this.bgColor='#FFFFFF';">
							<td><?php echo ($vo["id"]); ?></td>
							<td align="left">
								<?php echo ($vo["name"]); ?>
							</td>
							<td>
								<?php echo ($vo["lasttime"]); ?>
							</td>
							<td>
								<?php echo ($vo["createtime"]); ?>
							</td>
							<td>
								<?php echo ($vo["arccount"]); ?>
							</td>
							<td>
								<a href="__APP__/index.php?m=Collect&a=do_collect&id=<?php echo ($vo["id"]); ?>">[采集]</a>&nbsp;
								<a href="__APP__/index.php?m=Collect&a=do_export&id=<?php echo ($vo["id"]); ?>">[导出]</a>&nbsp;
								<a href="__APP__/index.php?m=Collect&a=update&id=<?php echo ($vo["id"]); ?>">[更改]</a>&nbsp;
								<a href="__APP__/index.php?m=Collect&a=cleardata&id=<?php echo ($vo["id"]); ?>"  onclick="return(confirm('确定要清空节点数据吗?'))">[清空]</a>
								<a href="__APP__/index.php?m=Collect&a=delete_handler&id=<?php echo ($vo["id"]); ?>"  onclick="return(confirm('确定删除?'))">[删除]</a>
							</td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					<tr bgcolor="#F9FCEF" height="25">
						<td colspan="8" align="center">
							<div class="pager">
								<?php echo ($page); ?>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	</form>
</body>
</html>