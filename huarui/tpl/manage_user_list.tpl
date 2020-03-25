<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>登录</title>
<link media="screen" href="style/admin.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/form.js"></script>
</head>
<body>
<table class="addurl">
	<tr>
		<td width="680"><div class="tb_title f14"><b>管理员列表</b></div></td>
	</tr>
</table>
<table class="urlist">
  <tr align="center" class="tr_title">
    <td width="50">ID</td>
    <td width="160">用户名</td>
    <td width="200">电子邮件</td>
    <td width="90">状态</td>
    <td width="120">操作</td>
  </tr>
  {foreach item=item from=$userList}
  <tr align="center">
    <td>{$item.uid}</td>
    <td align="left">{$item.username}</td>
    <td align="left">{$item.email}</td>
    <td>{$userState[$item.state]}</td>
    <td><a href="manage_user.php?act=edit&id={$item.uid}">编辑</a>&nbsp;&nbsp;<a href="manage_user.php?act=del&id={$item.uid}" onclick="return confirm('确定删除?')">删除</a></td>
  </tr>
  {/foreach}
</table>
<p>&nbsp; </p>
</body>
</html>
