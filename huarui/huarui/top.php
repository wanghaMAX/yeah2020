<?php
include 'manage.inc.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>无标题文档</title>
<link media="screen" href="style/admin.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery.js"></script>
</head>
<body id="topbox">
<div class="title cl">网站广告管理系统&nbsp;By 风子</div>
<div class="info cl">
<span>当前登录用户：<?php echo $user->username;?></span>，<a href="index.php?act=logout" target="_top">退出登录</a>
&nbsp;&nbsp;<a href="welcome.php" target="main">后台首页</a>
</div>
</body>
</html>