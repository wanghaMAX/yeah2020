<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>登录</title>
<link media="screen" href="style/admin.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery.js"></script>
</head>
<body>
<p class="log_p">&nbsp;</p>
<form id="form1" name="form1" method="post" action="index.php">
<table class="logbox mgat">
  <tr>
    <th colspan="2" scope="row" class="title f14">广告管理系统</th>
  </tr>
  <tr>
    <th width="80" scope="row">用户名</th>
    <td width="200"><input name="username" type="text" id="user" /></td>
  </tr>
  <tr>
    <th scope="row">密&nbsp;&nbsp;&nbsp;码</th>
    <td><input name="password" type="password" id="password" /></td>
  </tr>
  <tr>
    <th scope="row">验证码</th>
    <td>{$watercode}</td>
  </tr>
  <tr>
    <th colspan="2" scope="row"><input type="submit" name="Submit" value=" 登录 " />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="Submit2" value=" 重置 " /></th>
  </tr>
</table>
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
