<?php /* Smarty version 2.6.19, created on 2009-09-03 14:37:41
         compiled from manage_user_edit.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>编辑管理员</title>
<link media="screen" href="../style/admin.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/form.js"></script>
</head>
<body>
<table class="addurl">
	<tr>
		<td width="680" colspan="2"><div class="tb_title f14"><b>编辑管理员</b></div></td>
	</tr>
<form id="form1" name="form1" method="post" action="manage_user.php?act=edit&id=<?php echo $this->_tpl_vars['info']['uid']; ?>
" onSubmit="return Validator.Validate(this,3)">
	<tr>
		<td class="a_rt">用户名</td>
		<td><input name="username" type="text" id="username" value="<?php echo $this->_tpl_vars['info']['username']; ?>
" size="20" maxlength="20" readonly="readonly"  dataType="LimitB" min="3" max="20" msg="用户名3~20个字符之间" />（不可含有特殊字符）
		</td>
	</tr>
	<tr>
		<td class="a_rt">密码</td>
		<td><input name="password" type="text" id="password" size="20" maxlength="50" />（不修改请留空）</td>
	</tr>
	<tr>
		<td class="a_rt">电子邮件</td>
		<td><input name="email" type="text" id="email" size="30" value="<?php echo $this->_tpl_vars['info']['email']; ?>
" maxlength="100" /></td>
	</tr>
	<tr>
		<td class="a_rt">状态</td>
		<td> 
<?php $_from = $this->_tpl_vars['userState']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
<input name="state" type="radio" value="<?php echo $this->_tpl_vars['key']; ?>
"<?php if ($this->_tpl_vars['key'] == $this->_tpl_vars['info']['state']): ?> checked="checked"<?php endif; ?> />
<?php echo $this->_tpl_vars['item']; ?>

<?php endforeach; endif; unset($_from); ?>
</td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit" name="Submit" value="确认修改" /></td>
	</tr>
</table>
</form>
<p>&nbsp; </p>
</body>
</html>