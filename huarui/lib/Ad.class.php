<?php
/**
 * 广告类
 *
 */

class Ad extends User {

	/**
	 * 文字广告
	 */
	const AD_CLASS_TEXT = 1;
	
	/**
	 * 图片广告
	 */
	const AD_CLASS_IMAGE = 2;
	
	/**
	 * 代码广告
	 */
	const AD_CLASS_CODE = 3;
	
	/**
	 * 广告类别
	 */
	private $_adClass = array(
						self::AD_CLASS_TEXT  =>    '文字',
						self::AD_CLASS_IMAGE =>    '图片',
						self::AD_CLASS_CODE  =>    '代码'
					);
					
	/**
	 * 待审核
	 */
	const AD_ORDER_STATE_NOPASS = 0;
	
	/**
	 * 审核通过
	 */
	const AD_ORDER_STATE_PASSED = 1;
	
	/**
	 * 获取私有变量
	 */				
	public function __get($name){
		return $this->$name;
	}
					
	/**
	 * 添加广告位
	 */				
	public function addAd($form,$user){
		$data = array(
					'name'    =>  str::moveHtml($form['name']),
					'width'   =>  ceil($form['width']),
					'height'  =>  ceil($form['height']),
					'price'   =>  $form['price'],
					'adduser' =>  $user,
					'addtime' =>  str::getNowTime()
					);
		if($adid = Db::open()->insert('aboc_ad',$data)){
			return $adid;
		} else {
			return false;
		}
	}

	/**
	 * 编辑广告位
	 */
	public function editAd($adid,$form){
		$where = Db::open()->quoteInto("adid=?",$adid);
		$data = array(
					'name'    =>  str::moveHtml($form['name']),
					'width'   =>  ceil($form['width']),
					'height'  =>  ceil($form['height']),
					'price'   =>  $form['price'],
					);
		if( Db::open()->update('aboc_ad',$data,$where) ){
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * 删除广告位
	 */
	public function delAd($adid){
		$where = Db::open()->quoteInto("adid=?",$adid);
		if( Db::open()->delete('aboc_ad',$where) ){
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * 获取所有的广告位名称
	 */
	public function getAdList(){
		$sql = "select adid,name,width,height,price from aboc_ad order by adid desc";
		$rows = Db::open()->fetchAll($sql);
		return $rows;
	}
	
	/**
	 * 获取某个广告位的信息
	 */
	public function getAdInfo($adid,$cacheTime=0){
		$where = Db::open()->quoteInto("adid=?",$adid);
		$sql = "select adid,width,height,name,price,adduser,addtime from aboc_ad where $where";
		$row = Db::open()->fetchRow($sql,$cacheTime);
		return $row;
	}
	
	/**
	 * 获取广告下订单数
	 */
	public function getAdOrderNum(){
		$sql = "select adid,count(orderid) as num from aboc_ad_order group by adid";
		$rows = Db::open()->fetchAll($sql);
		if(!empty($rows)){
			foreach ($rows as $row){
				$newrows[$row['adid']] = $row['num'];
			}
		}
		return $newrows;
	}
	
	/**
	 * 添加广告订单
	 */
	public function addOrder($form,$user){
		$data = array(
				'adid'      =>    ceil($form['adid']),
				'title'     =>    str::moveHtml($form['title']),
				'class'     =>    ceil($form['class']),
				'text'      =>    str::moveHtml($form['text']),
				'img'       =>    str::moveHtml($form['img']),
				'url'       =>    str::moveHtml($form['url']),
				'code'      =>    trim($form['code']),
				'price'     =>    round($form['price'],2),
				'state'     =>    $form['state'],
				'startdate' =>    $form['startdate'],
				'stopdate'  =>    $form['stopdate'],
				'adduser'   =>    $user,
				'addtime'   =>    str::getNowTime()
				);
		if( $orderid = Db::open()->insert('aboc_ad_order',$data) ){
			return $orderid;
		} else {
			return false;
		}
	}
	
	/**
	 * 编辑广告订单
	 */
	public function editOrder($orderid,$form){
		$where = Db::open()->quoteInto("orderid = ?",$orderid);
		$data = array(
				'adid'      =>    ceil($form['adid']),
				'title'     =>    str::moveHtml($form['title']),
				'class'     =>    ceil($form['class']),
				'text'      =>    str::moveHtml($form['text']),
				'img'       =>    str::moveHtml($form['img']),
				'url'       =>    str::moveHtml($form['url']),
				'code'      =>    trim($form['code']),
				'price'     =>    $form['price'],
				'state'     =>    $form['state'],
				'startdate' =>    $form['startdate'],
				'stopdate'  =>    $form['stopdate'],
				'addtime'   =>    str::getNowTime()
				);
		if( Db::open()->update('aboc_ad_order',$data,$where) ){
			return true;
		} else {
			return false;
		}		
	}
	
	/**
	 * 删除广告订单
	 */
	public function delOrder($orderid){
		$where = Db::open()->quoteInto("orderid = ?",$orderid);
		if( Db::open()->delete('aboc_ad_order',$where) ){
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * 获取某个广告订单的详情，含订单位
	 */
	public function getOrderInfo($orderid,$cacheTime=0){
		if(empty($orderid))return array();
		$sql = "select dao.orderid,dao.adid,dao.title,dao.class,dao.url,dao.text,dao.img,dao.code,dao.price,dao.bro,dao.click,dao.state,dao.startdate,dao.stopdate,dao.adduser,da.name,da.width,da.height,da.price from aboc_ad_order as dao left join aboc_ad as da on(dao.adid=da.adid) where dao.orderid=$orderid";
		$row = Db::open()->fetchRow($sql,$cacheTime);
		return $row;
	}

	/**
	 * 获取某个广告订单的详情
	 */
	public function getOrderDetail($orderid,$cacheTime=0){
		if(empty($orderid))return array();
		$sql = "select orderid,adid,title,class,url,text,img,code,price,bro,click,state,startdate,stopdate,adduser from aboc_ad_order where orderid=$orderid";
		$row = Db::open()->fetchRow($sql,$cacheTime=0);
		return $row;
	}

	/**
	 * 获取某个广告订单的详情/到首页
	 */
	public function getOrderDetailToIndex($orderid,$cacheTime=3600){
		if(empty($orderid))return array();
		$sql = "select dao.orderid,dao.adid,dao.title,dao.class,dao.url,dao.text,dao.img,dao.code,dao.price,dao.bro,dao.click,dao.state,dao.startdate,dao.stopdate,dao.adduser,da.name,da.width,da.height,da.price from aboc_ad_order as dao left join aboc_ad as da on(dao.adid=da.adid) where dao.orderid=$orderid";
		$row = Db::open()->fetchRow($sql,$cacheTime);
		return $row;
	}	
	
	/**
	 * 获取广告位下的广告订单
	 */
	public function getAdOrder( $adid ,$cacheTime=0){
		$sql = "select orderid,adid,title,class,url,text,img,code,price,bro,click,state,startdate,stopdate from aboc_ad_order where adid=$adid";
		$rows = Db::open()->fetchAll($sql,$cacheTime);
		return $rows;
	}

	/**
	 * 输出广告
	 */
	public function outputAd($adid,$cacheTime=3600){
		$sql = "select orderid from aboc_ad_order where startdate<=".str::getNowTime()." and stopdate>=".str::getNowTime()." and state=".self::AD_ORDER_STATE_PASSED." and adid=$adid";
		$rows = Db::open()->fetchAll($sql);
		$num = count($rows);
		if($num == 0){
			$adInfo = $this->getAdInfo($adid,$cacheTime);
			$ad = '<a href="" target="_blank">';
			$ad .= '<img src="'.SITEHOST.'ad'.$adInfo['width'].'_'.$adInfo['height'].'.gif" width='.$adInfo['width'].' height='.$adInfo['height'].' border="0">';
			$ad .= '</a>';
		}
		if($num == 1){
			$ad = $this->createOutput($rows[0]['orderid'],$cacheTime);
		}
		elseif($num>1){
			$newkey = array_rand($rows);
			$ad = $this->createOutput($rows[$newkey]['orderid'],$cacheTime);
		}
		return $ad;
	}	
	
	/**
	 * 获取某广告位的多少数量订单
	 */
	public function outputAllAd($adid,$limit=3,$cacheTime=3600){
		$sql = "select orderid from aboc_ad_order where startdate<=".str::getNowTime()." and stopdate>=".str::getNowTime()." and state=".self::AD_ORDER_STATE_PASSED." and adid=$adid order by lastclick desc limit $limit";
		$rows = Db::open()->fetchAll($sql,$cacheTime);
		$ad = array();
		foreach ($rows as $key=>$row){
			$ad[$key] = $this->createOutput($row['orderid'],$cacheTime);
		}
		return $ad;
	}
	
	/**
	 * 获取某个广告位的多少条广告订单到数组
	 * @param $adid 广告位
	 * @param $limit 多少个
	 * @param $hash 是否随机获取
	 */
	public function outputAdToArray($adid,$limit=1,$hash=false,$cacheTime=3600){
		$order = $hash?'lastclick desc':'rand()';
		$sql = "select orderid,title,url,text,img,code,class from aboc_ad_order where startdate<=".str::getNowTime()." and stopdate>=".str::getNowTime()." and state=".self::AD_ORDER_STATE_PASSED." and adid=$adid order by $order limit $limit";
		$rows = Db::open()->fetchAll($sql,$cacheTime);
		if(!empty($rows)){
			$orderids = array();
			foreach ($rows as $row){
				$orderids[] = $row['orderid'];
			}			
			$orderids = implode(',',$orderids);
			
			$sql = "update aboc_ad_order set bro=bro+1 where orderid in($orderids)";
			Db::open()->query($sql);
		}
		return $rows;
	}
	
	/**
	 * 输出广告订单
	 */
	private function createOutput($orderid,$cacheTime=0){
		$orderDetail = $this->getOrderDetailToIndex($orderid,$cacheTime);
//		print_r($orderDetail);
		switch ($orderDetail['class']){
			case self::AD_CLASS_TEXT:
				//$ad = '<span style="width:'.$orderDetail['width'].'px;height:'.$orderDetail['height'].'px">';
				$ad = '<a href="'.SITEHOST.'goto.php?id='.$orderDetail['orderid'].'" target="_blank">'.$orderDetail['title'].'</a>';
				//$ad .= '</span>';
				break;
			case self::AD_CLASS_IMAGE:
				//$ad = '<div id="ad_'.$orderDetail['orderid'].'">';
				$ad = '<a href="'.SITEHOST.'goto.php?id='.$orderDetail['orderid'].'" target="_blank">';
				$ad .= '<img src="'.SITEHOST.$orderDetail['img'].'" width='.$orderDetail['width'].' height='.$orderDetail['height'].' border="0">';
				$ad .= '</a>';
				//$ad .= '</div>';
				break;
			case self::AD_CLASS_CODE:
				//$ad = '<div id="ad_'.$orderDetail['orderid'].'" style="width:'.$orderDetail['width'].'px;height:'.$orderDetail['height'].'px">';
				$ad = $orderDetail['code'];
				//$ad .= '</div>';
				break;
			default:
				$ad = '<a href="" target="_blank">';
				$ad .= '<img src="'.SITEHOST.'upload/ad'.$orderDetail['width'].'_'.$orderDetail['height'].'.gif" width='.$orderDetail['width'].' height='.$orderDetail['height'].' border="0">';
				$ad .= '</a>';
				break;
		}
		$this->broAdd($orderid);
		return $ad;
	}
	
	/**
	 * 浏览量++
	 */
	private function broAdd($orderid){
		$where = Db::open()->quoteInto("orderid = ?",$orderid);
		$sql = "update aboc_ad_order set bro=bro+1 where $where";
		Db::open()->query($sql);
	}
	
	/**
	 * 点击量++
	 */
	public function clickAdd($orderid){
		$where = Db::open()->quoteInto("orderid = ?",$orderid);
		$sql = "update aboc_ad_order set click=click+1,lastclick=".time()." where $where";
		Db::open()->query($sql);
	}
	
	/**
	 * 获取企业链接
	 */
	public function getCompanyList($adid,$limit=10,$cacheTime=43200){
		$sql = "select orderid,title,img from aboc_ad_order where adid=$adid and state=".self::AD_ORDER_STATE_PASSED." order by orderid limit $limit";
		$rows = Db::open()->fetchAll($sql,$cacheTime);
		return $rows;
	}	
	
	
}

?>