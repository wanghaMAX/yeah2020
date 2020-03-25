<?php
/**
 * 功能说明:用户管理
 * @author 马银华 QQ:9986584 Site:www.phpec.org
 * @version 1.0   2009-5-26下午03:37:29
 */
include_once 'manage.inc.php';
$act = isset($_GET['act'])?trim($_GET['act']):'list';
$uid = isset($_GET['id'])?intval($_GET['id']):0; 

if($act=='list'){
	$smarty->assign('userList',$user->getUserList());
	$smarty->display('manage_user_list.tpl');
}
elseif ($act=='add'){
	if(!$_POST){
		$smarty->display('manage_user_add.tpl');
	} else {
		if(empty($_POST['username'])||empty($_POST['password']))str::back('用户名或密码不可为空');
		if( $site->addUser($_POST) )
		str::jump('manage_user.php?act=list','管理员添加成功');
		else
		str::back('添加失败,请稍后重试');
	}
}
elseif ($act=='edit'){
	if(empty($uid))str::back('参数错误');
	if(!$_POST){
		$smarty->assign('info',$user->getUserInfo($uid));
		$smarty->assign('userState',$user->userState);
		$smarty->display('manage_user_edit.tpl');
	} else {
		if(empty($_POST['username']))str::back('用户名或密码不可为空');
		if( $user->editUser($uid,$_POST) ){
			if(!empty($_POST['password'])){
				$user->editPassword($uid,$_POST['password']);
			}
			str::jump('manage_user.php?act=list','管理员编辑成功');
		}
		else
		str::back('编辑失败,请稍后重试');
	}	
}
elseif($act=='del'){
	str::back('不提供删除功能');
	if(empty($uid))str::back('参数错误');
	if($user->delUser($uid))
	str::refUrl('管理员删除成功');
	else 
	str::back('删除失败,请重试');
}