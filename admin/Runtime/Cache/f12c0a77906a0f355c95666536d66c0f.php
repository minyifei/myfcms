<?php if (!defined('THINK_PATH')) exit();?><html lang="en">
	<title><?php echo ($sys["value"]); ?>-闵益飞内容管理系统</title>
	<frameset rows="100,*" frameborder="0">
		<frame scrolling="no" name="top" src="__APP__/index.php?m=Index&a=top">
		<frameset cols="160,*" frameborder="0">
			<frame name="left"  scrolling="no" src="__APP__/index.php?m=Index&a=left">
			<frame name="main" src="__APP__/index.php?m=Index&a=main">
		</frameset>
	</frameset>
</html>