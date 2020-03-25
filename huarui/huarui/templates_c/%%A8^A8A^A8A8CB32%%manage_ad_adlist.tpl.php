<?php /* Smarty version 2.6.19, created on 2017-03-14 11:16:19
         compiled from manage_ad_adlist.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'manage_ad_adlist.tpl', 30, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link media="screen" href="style/admin.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery.js"></script>
</head>
<body>
<table class="addurl">
	<tr>
		<td width="680" colspan="2"><div class="tb_title f14"><b>广告位列表</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="manage_ad.php?act=addad">［添加广告位］</a></div></td>
	</tr>
</table>
<table class="urlist">
  <tr align="center" class="tr_title">
    <td width="40">ID</td>
    <td width="230">广告位名称</td>
    <td width="90">售价/周</td>
    <td width="90">广告位尺寸</td>
    <td width="50">订单数</td>
    <td width="250">操作</td>
  </tr>
  <?php $_from = $this->_tpl_vars['adList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
  <tr align="center">
    <td><?php echo $this->_tpl_vars['item']['adid']; ?>
</td>
    <td align="left"><a href="manage_ad.php?act=viewad&adid=<?php echo $this->_tpl_vars['item']['adid']; ?>
"><?php echo $this->_tpl_vars['item']['name']; ?>
</a></td>
    <td><?php echo $this->_tpl_vars['item']['price']; ?>
</td>
    <td><?php echo $this->_tpl_vars['item']['width']; ?>
x<?php echo $this->_tpl_vars['item']['height']; ?>
</td>
    <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['adNum'][$this->_tpl_vars['item']['adid']])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
</td>
    <td><a href="manage_ad.php?act=delad&adid=<?php echo $this->_tpl_vars['item']['adid']; ?>
" onclick="if(!confirm('删除此广告位？'))return false;">删除</a>&nbsp;&nbsp;<a href="manage_ad.php?act=editad&adid=<?php echo $this->_tpl_vars['item']['adid']; ?>
">编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="manage_ad.php?act=addorder&adid=<?php echo $this->_tpl_vars['item']['adid']; ?>
">添加订单</a>&nbsp;&nbsp;<a href="manage_ad.php?act=viewad&adid=<?php echo $this->_tpl_vars['item']['adid']; ?>
">浏览订单</a>&nbsp;&nbsp;<a href="manage_ad.php?act=getad&adid=<?php echo $this->_tpl_vars['item']['adid']; ?>
">获取代码</a></td>
  </tr>
  <?php endforeach; endif; unset($_from); ?>
</table>
</body>
</html>