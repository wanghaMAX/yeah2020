<?php
/**
 * 功能说明:广告管理
 * @author 马银华 QQ:9986584 Site:www.phpec.org
 * @version 1.0   2009-5-26下午03:37:29
 */
require_once dirname ( __FILE__ ) . '/manage.inc.php';
$act = isset ( $_GET ['act'] ) ? $_GET ['act'] : 'adlist';
$adid = isset ( $_GET ['adid'] ) ? $_GET ['adid'] : '';
$orderid = isset ( $_GET ['orderid'] ) ? $_GET ['orderid'] : '';
require_once SITEROOT.'lib/Ad.class.php';
$ad = new Ad();
//url列表


/**
 * 广告位列表
 */
if(empty($act) || $act == 'adlist' ){
	$adlist = $ad->getAdList();
	$adNum = $ad->getAdOrderNum();
	$smarty->assign('adNum',$adNum);
	$smarty->assign('adList',$adlist);
	$smarty->display('manage_ad_adlist.tpl');	
}
/**
 * 添加广告位
 */
elseif( $act == 'addad' ){
	//显示表
	if(!$_POST){		
		$smarty->display('manage_ad_addad.tpl');
	}
	//处理添加
	else{
		if(empty($_POST['name']) || empty($_POST['width'])|| empty($_POST['height'])|| empty($_POST['price'])) str::back('所有项目不可为空','back');
		if( $ad->addAd($_POST,$username)){
			str::jump('manage_ad.php?act=adlist','广告位添加成功');
		} else {
			str::back('广告位添加失败');
		}
	}
}
/**
 * 编辑广告位
 */
elseif( $act == 'editad' ){
	if(empty($adid)) str::back('参数错误');
	//显示表
	if(!$_POST){
		$adInfo = $ad->getAdInfo($adid);
		$smarty->assign('adInfo',$adInfo);
		$smarty->display('manage_ad_adedit.tpl');
	}
	//处理添加
	else{
		if(empty($_POST['name']) || empty($_POST['width'])|| empty($_POST['height'])|| empty($_POST['price'])) str::back('所有项目不可为空');
		if( $ad->editAd($adid,$_POST) ){
			str::jump('manage_ad.php?act=adlist','广告位编辑成功');
		} else {
			str::back('广告位编辑失败');
		}
	}
	
}
elseif ($act == 'getad'){
	if(empty($adid)) str::back('参数错误');
	$adInfo = $ad->getAdInfo($adid);
	if(empty($adInfo))str::back('广告位不存在');
	$smarty->assign('adInfo',$adInfo);
	$smarty->display('manage_ad_getad.tpl');
}
/**
 * 删除广告位
 */
elseif( $act == 'delad' ){
	if(empty($adid)) str::back('参数错误');
	str::back('广告位不可以删除,请尽量使用修改功能');
	if( $ad->delAd($adid) ){
			str::jump('manage_ad.php?act=adlist','广告位删除成功');
		} else {
			str::back('广告位删除失败');
		}
}
/**
 * 浏览广告位
 */
elseif( $act == 'viewad' ){
	$where = "where 1=1";
	if(!empty($adid) && $adid != -1) $where .= " and dao.adid=$adid";
	$sql = "select dao.*,da.name,da.width,da.height,da.price from aboc_ad_order as dao left join aboc_ad as da on(dao.adid=da.adid) $where";
	include_once SITEROOT.'lib/page.class.php';
	$page = new page();
	$list = $page->getData($sql,Db::open(),20,0);
	$smarty->assign('list',$list);
	$adlist = $ad->getAdList();
	$smarty->assign('pageList',$page->pagelist());
	$smarty->assign('adList',$adlist);
	$smarty->display('manage_ad_viewad.tpl');	
}
/**
 *　快到期订单
 */
elseif( $act == 'expire' ){
	$enddate = time()+30*3600*24;
	$where = "where dao.stopdate<=".$enddate;
	if(!empty($adid) && $adid != -1) $where .= " and dao.adid=$adid";
	$sql = "select dao.*,da.name,da.width,da.height,da.price from aboc_ad_order as dao left join aboc_ad as da on(dao.adid=da.adid) $where";
	include_once SITEROOT.'lib/page.class.php';
	$page = new page();
	$list = $page->getData($sql,Db::open(),20,0);
	$smarty->assign('list',$list);
	$adlist = $ad->getAdList();
	$smarty->assign('pageList',$page->pagelist());
	$smarty->assign('adList',$adlist);
	$smarty->display('manage_ad_viewad.tpl');	
}
/**
 * 添加广告订单
 */
elseif( $act == 'addorder' ){
	if(!$_POST){
		$smarty->assign('adList',$ad->getAdList());
		$smarty->assign('class',$ad->_adClass);
		$smarty->assign('startdate',date("Y-m-d",str::getNowTime()));
		$smarty->assign('stopdate',date("Y-m-d",str::getNowTime()+7*3600*24));
		$smarty->display('manage_ad_addorder.tpl');
	}
	//处理
	else{
		if(empty($_POST['title']))str::back('广告名称不可为空');
		if($_POST['class'] == Ad::AD_CLASS_TEXT &&(empty($_POST['text']) || empty($_POST['url'])))str::back('文字广告广告内容/广告地址不可为空');
		if($_POST['class'] == Ad::AD_CLASS_IMAGE &&(empty($_FILES['file']['tmp_name']) || empty($_POST['url'])))str::back('图片广告图片/广告地址不可为空');
		if($_POST['class'] == Ad::AD_CLASS_CODE && empty($_POST['code']) )str::back('js广告js不可为空');
		$_POST['img'] = '';
		if(!empty($_FILES['file']['tmp_name'])){
				include_once SITEROOT.'lib/image.class.php';
				$pic = new image();
		        $picpath = $pic->upImage('file',SITEROOT.'upload',200000,false,false,'images/water.gif');			
				if($picpath == -1) {
					str::back('非允许的图片格式');
				} else if ($picpath == -2) {
					str::back('图片大小超过200K');
				} else if (!$picpath) {
					str::back('未知错误,请返回重新上传');
				} else {
					$_POST['img'] = str_replace(SITEROOT,'',$picpath['big']);
					
				}
		}
		$_POST['startdate'] = str::dateYmdToUnix($_POST['startdate']);
		$_POST['stopdate'] = str::dateYmdToUnix($_POST['stopdate'])+24*3600;
		if( $ad->addOrder($_POST,$username) ){
			str::jump('manage_ad.php?act=viewad&adid=-1','广告订单添加成功');
		} else {
			str::back('广告订单添加错误');
		}
		
		
	}
}
/**
 * 编辑广告订单
 */
elseif( $act == 'editorder' ){
	if(empty($orderid)) str::back('参数错误');
	
	if(!$_POST){
		$smarty->assign('orderInfo',$orderInfo=$ad->getOrderDetail($orderid));
		$smarty->assign('adList',$ad->getAdList());
		$smarty->assign('class',$ad->_adClass);
		$smarty->assign('startdate',date("Y-m-d",$orderInfo['startdate']));
		$smarty->assign('stopdate',date("Y-m-d",$orderInfo['stopdate']));
		$smarty->display('manage_ad_editorder.tpl');
	}
	//处理
	else{
		if(empty($_POST['title']))str::back('广告名称不可为空');
		if($_POST['class'] == Ad::AD_CLASS_TEXT &&(empty($_POST['text']) || empty($_POST['url'])))str::back('文字广告广告内容/广告地址不可为空');
		if($_POST['class'] == Ad::AD_CLASS_IMAGE &&( empty($_POST['img']) && empty($_FILES['file']['tmp_name'] ) || empty($_POST['url'])))str::back('图片广告图片/广告地址不可为空');
		if($_POST['class'] == Ad::AD_CLASS_CODE && empty($_POST['code']) )str::back('js广告js不可为空');
		if(!empty($_FILES['file']['tmp_name'])){
			    include_once SITEROOT.'lib/image.class.php';
				$pic = new image();
		        $picpath = $pic->upImage('file',SITEROOT.'upload',200000,false,false,'images/water.gif');			
				if($picpath == -1) {
					str::back('非允许的图片格式');
				} else if ($picpath == -2) {
					str::back('图片大小超过200K');
				} else if (!$picpath) {
					str::back('未知错误,请返回重新上传');
				} else {
					$_POST['img'] = str_replace(SITEROOT,'',$picpath['big']);
					
				}
		}
		$_POST['startdate'] = str::dateYmdToUnix($_POST['startdate']);
		$_POST['stopdate'] = str::dateYmdToUnix($_POST['stopdate'])+24*3600;
		if( $ad->editOrder($orderid,$_POST) ){
			str::jump('manage_ad.php?act=viewad&adid=-1','广告订单编辑成功');
		} else {
			str::back('广告订单编辑错误');
		}
		
		
	}
	
	
}
/**
 * 删除广告订单
 */
elseif( $act == 'delorder' ){
	if(empty($orderid)) str::back('参数错误');
	if($ad->delOrder($orderid)){
		str::jump('manage_ad.php?act=viewad&adid=-1','广告订单删除成功');
	} else {
		str::back('广告订单删除失败');
	}
}