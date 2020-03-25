<?php
/**
 * 功能说明:后台首页
 * @author 马银华 QQ:9986584 Site:www.phpec.org
 * @version 1.0   2009-5-26下午02:15:52
 */
include_once 'common.php';
$act = isset($_GET['act'])?trim($_GET['act']):'';
$smarty->template_dir=SITEROOT.'tpl';
$user = new User();
if(empty($act)){
	if($user->isLogin()){
		str::jumpUrl('default.php');
	} else {
		if($_POST){
			if(empty($_POST['username'])||empty($_POST['password']))str::back('用户名或密码不可为空');
			if(!str::checkWater($_POST['watercode'],'login'))str::back('验证码错误');
			$flag=$user->checkUser($_POST['username'],$_POST['password']);
			if($flag<=0)str::back('用户名/密码不存在或不匹配');
        	if($flag>0)str::jumpUrl('default.php');
		} else {
			//显示登录页面
			$smarty->assign('watercode',str::water('login','watercode.php'));
			$smarty->display('index.tpl');
		}
	}
}
elseif($act == 'logout'){
	unset($_SESSION['uid']);
	unset($_SESSION['username']);
	str::jump('index.php','登出成功');
}