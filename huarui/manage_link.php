<?php
	/**
 	 * 链接管理
 	 */
	require_once dirname(__FILE__).'/manage.inc.php';
	$act = isset($_GET['act'])?$_GET['act']:'';
	$id = isset($_GET['id'])?$_GET['id']:'';
	require_once PF_ROOT.'lib/Link.class.php';
	$link = new Link();
	
	$texturl = array (array ('text' => '链接列表', 'url' => 'manage_link.php' ) );
	/**
	 * 显示列表
	 */
	if($act == 'list' || empty($act)){
		include_once PF_ROOT.'lib/page.class.php';
		$sql = "select linkid,name,url,logo,class,state,display from pf_link order by linkid desc";
		$page = new page();
		$list = $page->getData($sql,Db::open(),20);
		$smarty->assign('linkList',$list);
		$smarty->assign('display',$link->display);
		$smarty->assign('pageList',$page->pagelist());
		$smarty->display('manage_link_list.tpl');
	}
	/**
	 * 添加链接
	 */
	elseif($act == 'add'){
		if(!$_POST){
			$smarty->assign('display',$link->display);
			$smarty->display('manage_link_add.tpl');
		}
		/**
		 * 处理添加
		 */
		elseif($_POST){
			if(empty($_POST['name']) || strlen($_POST['url'])<8) str::back('网站名称和网站地址不可为空');
			$_POST['logo'] = "";
			if(!empty($_FILES['file']['tmp_name'])){
				include_once PF_ROOT.'lib/image.class.php';
				$pic = new image();
		        $picpath = $pic->upImage('file',PF_ROOT.'upload',200000,false,false,'images/water.gif');			
				if($picpath == -1) {
					str::back('非允许的图片格式');
				} else if ($picpath == -2) {
					str::back('图片大小超过100K');
				} else if (!$picpath) {
					str::back('未知错误,请返回重新上传');
				} else {
					$_POST['logo'] = str_replace(PF_ROOT,'',$picpath['big']);
					
				}
			}
			if( $link->addLink($_POST,$username,$_POST['state']) ){
				str::jump('manage_link.php', '链接添加成功');
			} else {
				str::back('添加链接失败');
			}
			
		}
	}
	/**
	 * 编辑链接
	 */
	elseif($act == 'edit'){
		if(empty($id)) str::back('参数错误');
		if(!$_POST){
			$linkInfo = $link->getLinkInfo($id);
			if(empty($linkInfo)) str::back('此链接不存在');
			$smarty->assign('display',$link->display);
			$smarty->assign('link',$linkInfo);
			$smarty->display('manage_link_edit.tpl');
		}
		/**
		 * 处理编辑
		 */
		elseif($_POST){
			if(!empty($_FILES['file']['tmp_name'])){
				include_once PF_ROOT.'lib/image.class.php';
				$pic = new image();
		        $picpath = $pic->upImage('file',PF_ROOT.'upload',200000,false,false,'images/water.gif');			
				if($picpath == -1) {
					str::back('非允许的图片格式');
				} else if ($picpath == -2) {
					str::back('图片大小超过500K');
				} else if (!$picpath) {
					str::back('未知错误,请返回重新上传');
				} else {
					$_POST['logo'] = str_replace(PF_ROOT,'',$picpath['big']);
					
				}
			}
			if( $link->editLink($id,$_POST,$username) ){
				str::jump('manage_link.php', '链接编辑成功');
			} else{
				str::back('链接编辑失败');
			}
		}
	}
	/**
	 * 删除链接
	 */
	elseif($act == 'del'){
		if(empty($id)) str::back('参数错误');
		if( $link->delLink($id) ){
				str::jump('manage_link.php', '链接删除成功');
			} else{
				str::back('链接删除失败');
			}
	}
	/**
	 * 审核通过链接
	 */
	elseif($act == 'pass'){
		
	}
