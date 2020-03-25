<?php
/**
 * 字符操作的静态类,所有通用的静态函数都在此
 * @author Aboc QQ:9986584
 * @link http://hi.baidu.com/aboc
 *
 */
class str {
	
	/**
	 * 移除HTML标签(标题和留言用)
	 * @param string
	 * @return string
	 */
	public static function moveHtml($str,$length='') {
		
		if(is_array($str)){
			foreach ($str as $key=>$value){
				$str[$key] = self::moveHtml($value,$length);
			}
		} else {
			$tag = "";
			$str = strip_tags ( $str, $tag );
			$str = trim($str);
			$str = str_ireplace('<br />','',$str);
			//$str = trim($str,'　');//添加这个有乱码
			if(!empty($length)){
				$len = $length+1;
				if(isset($str[$len]))$str = self::substrSelf($str,0,$length);
			}
		}
		//$str = str_replace('　','',$str);
		//echo $str;exit;
		return $str;
	}
	
	/**
	 * 移除HTML标签(去除有害代码)
	 * @param string
	 * @return string
	 */
	public static function moveHtmlDetail($str,$moveimg=false,$movetable=true,$movediv=false,$movespan=false,$moveul=false,$moveh17=false) {
		if(is_array($str)) {
			foreach ($str as $key=>$value) {
				$str[$key]=self::moveHtmlDetail($value);
			}
		} else {
			$tag = "<b>,<i>,<font>,<strong>,<br>,<p>,<strike>,<pre>,<embed>,<hr>,<blockquote>";
			if(!$movediv)$tag .= "<div>";
			if(!$moveh17)$tag .= "<h1>,<h2>,<h3>,<h4>,<h5>,<h6>,<h7>";
			if(!$moveimg)$tag .= "<img>";
			if(!$movespan)$tag .= "<span>";
			if(!$movetable)$tag .= "<table>,<tbody>,<tr>,<th>,<td>";
			if(!$moveul)$tag .= "<ul>,<ol>,<li>";
			$tag .= strtoupper($tag);
			$str = strip_tags ( $str, $tag );
		}
		return $str;
	}
	
	/**
	 * 截取字符串
	 */
	public static function substrSelf($str_cut,$start=0,$length=80,$flag = '') {
		$str_cut=self::moveHtml($str_cut);//此处没用
		if (strlen($str_cut) > $length)	{ 
        	for($i=0; $i < $length; $i++) 
        		if (ord($str_cut[$i]) > 128)    $i++; 
        		$str_cut = substr($str_cut,$start,$i).$flag; 
    	} 
    	return $str_cut; 		
	}
	
	/**
	 * 将二维数组中某个字段截取某个长度
	 * 将原数据保留在 $keyname_old中
	 */
	public static function substrByArray($arraystr,$keyname,$length=80,$flag=''){
		if(is_array($arraystr)){
			foreach ($arraystr as $key=>$row){
				if(is_array($row)){
			        foreach ($row as $key2=>$value ){
			   	        if($key2 == $keyname){
			   	        	$arraystr[$key][$keyname]=self::substrSelf($value,0,$length,$flag);
			   	        	$arraystr[$key][$keyname.'_old']=$value;
			   	        }
			        } 
				} else{
				    if($key == $keyname){
				    	$arraystr[$keyname]=self::substrSelf($row,0,$length,$flag);	
				    	$arraystr[$keyname.'_old']=$value;
				    }
				}
			}			
		}
		return $arraystr;
	}
	
	/**
	 * 产生js的alert
	 */
	public static function alert($str) {
		echo '<script lanage="javascript">alert("' . $str . '")</script>';
	}
	
	/**
	 * 产生js的警告，并后退
	 */
	public static function back($str) {
		echo '<script lanage="javascript">alert("' . $str . '");' . 'history.back();</script>';
		exit;
	}
	
	/**
	 * 产生js警告，并转向到某个地址
	 */
	public static function jump($url, $str) {
		echo '<script lanage="javascript">alert("' . $str . '");' . 'window.location="' . $url . '"</script>';
		exit;
	}
	
	/**
	 * 转向到某地址
	 */
	public static function jumpUrl($url) {
		echo '<script lanage="javascript">window.location="' . $url . '"</script>';
		exit;
	}
	
	/**
	 * 警告后刷新回到上一页
	 */
	public static function refUrl($str) {
		echo '<script lanage="javascript">alert("' . $str . '");' . 'window.location="' . $_SERVER['HTTP_REFERER'] . '"</script>';
		exit;
	}
	
	/**
	 * 输出警告并有两个选项
	 *
	 * @param unknown_type $str
	 * @param unknown_type $yesUrl
	 * @param unknown_type $noUrl
	 */
	public static function alertYesNo($str,$yesUrl='',$noUrl='') {
		echo '<script lanage="javascript">'
			.'if(confirm("'.$str.'")){'
			.'window.location="'.$yesUrl.'";'
			.'}else{'
			.'window.location="'.$noUrl.'";'
			.'}</script>';
		exit;
	}
	
	
	/**
	 * 将Y-m-d换成unix时间
	 */
	public static function dateYmdToUnix($date){
		$newdate = explode('-',$date);
		if(empty($newdate)) return $_SERVER['REQUEST_TIME'];
		$unixdate = mktime(0,0,0,$newdate[1],$newdate[2],$newdate[0]);
		return $unixdate;
	}
	

	
	/**
	 * 输出水印代码
	 *
	 * @param unknown_type $name
	 * @param unknown_type $path
	 * @return unknown
	 */
	public static function water($name,$path='../watercode.php') {
		//点输入框出现验证码
		//return '<input name="watercode" type="text" id="watercode" size="4" maxlength="4" onclick="dm_water.src=\''.$path.'?t='. $name .'\'" /><img onclick="this.src=\''.$path.'?t='. $name .'&id=\'+Math.random()*5;" style="cursor:pointer;" id="dm_water" name="dm_water" alt="点击获取验证码"" align="absmiddle" />';
		return '<input name="watercode" type="text" id="watercode" size="4" maxlength="4" onfocus="if(this.value==\'\')dm_water.src=\''.$path.'?t='. $name .'\';dm_water.alt=\'看不清楚?点击换一个\';" dataType="Limit" min="1" msg="验证码不可为空" /><img onclick="this.src=\''.$path.'?t='. $name .'&id=\'+Math.random()*5;" style="cursor:pointer;" id="dm_water" name="dm_water" alt="点击获取验证码"" align="absmiddle" />';
	}
	
	/*
     * 判断验证码
     * $input 输入值
     * $codeName 验证码的变量
     * return bool
     */
    public static function checkWater($input,$codeName='watercode'){
    	if( @(md5(strtolower($input)) != md5($_SESSION[$codeName])) || empty($input) ) {
             $_SESSION[$codeName] = md5(rand(1000,4000));//重置
             return false;
        } else {
             $_SESSION[$codeName] = md5(rand(1000,4000));//重置
             return true;
        }
    }
	
    /**
     * 自定义加密
     */
	public static function md99($str){
		return md5($str.'9986584Aboc');
	}

    /**
     * 过滤get输入
     */
    public static function checkGet( $get ,$need = ''){
    	if(is_array($get)) {
			foreach ($get as $key => $value){
				$newget[$key] = self::checkGet($value,$key);
			}
		} else {
//			$newget = trim($get);
			if(isset($get[400])) {
				$newget = substr($get,0,400);
			} else {
				$newget = $get;
			}
			//已经自动过滤了,所以不需要了
			//$newget = str_replace('"','\"',$newget);
			//$newget = str_replace("'","\'",$newget);
			if( stripos($newget,'set') !== false ){
				$newget = str_ireplace(' set','',$newget);
				$newget = str_ireplace('set ','',$newget);
			}
			//if( !empty($need) && stripos($need,'id') !== false ) $newget = ceil($newget);
		}
		return $newget;		
    }
    

    
    /**
     * 编码转换
     */
    public static function myIconv($str,$inchar='utf-8',$outchar='gbk'){
    	if(is_array($str)){
    		$newstr = array();
    		foreach ($str as $key=>$row){
    			$newstr[$key] = self::myIconv($row,$inchar,$outchar);
    		}
    	}
    	else{
    		$newstr = iconv($inchar,$outchar,$str);
    	}
    	return $newstr;
    }
    
    /**
     * 获取当前时间
     */
    public static function getNowTime(){
    	return $_SERVER['REQUEST_TIME'];
    }
    
 
    /**
     * 获取当前URL地址
     *
     * @return unknown
     */
    public static function getThisUrl(){
    	$query = $_SERVER['QUERY_STRING'];
    	$q = !empty($query)?'?'.$query:'';
    	return "http://".$_SERVER ['HTTP_HOST'].$_SERVER['PHP_SELF'].$q;
    }
    
     /**
      * 将内容修改为js适合调用的格式
      *
      * @param unknown_type $str
      * @return unknown
      */
     public static function jsCode($str){
     	$str = str_replace(array('"',"'"),array('\"',"\'"),$str);
     	$str = explode("\r\n",$str);
     	if(!is_array($str))return;
     	$a = '';
     	foreach ($str as $row){
     		if(!empty($row))$a .= "document.writeln('$row');\r\n";
     	}
     	return $a;
     }

     
    

}