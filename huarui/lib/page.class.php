<?php
/**
 * @what 分页类
 * @author Aboc  QQ:9986584
 * @version 2.0
 * @date 2009-1-1
 */
class page {
	/**
	 * 分页数据名称
	 *
	 * @var unknown_type
	 */
	var $page_name='page';
	
	/**
	 * 每页条数
	 *
	 * @var unknown_type
	 */
	var $page_size;

	/**
	 * 总页数
	 *
	 * @var unknown_type
	 */
	var $page_num;
	
	/**
	 * 当前页码
	 *
	 * @var unknown_type
	 */
	var $page=0;
	
	/**
	 * 数据总条数
	 *
	 * @var unknown_type
	 */
	var $num;
	
	/**
	 * 取得分页数据
	 *
	 * @param unknown_type $sql
	 * @param unknown_type $db
	 * @param unknown_type $page_size
	 * @return array;
	 */
	function getData($sql,&$db,$page_size=20,$cacheTime=0){
		$this->page_size = $page_size;
		if(strripos($sql,'limit') != false)die('SQL中不可出现limit');
		if( $page_size <= 0 )die('$page_size设置错误');
		$sql = trim($sql);
		$this->num = $db->fetchNum($sql);
		if($this->num <= $page_size){
			$this->page_num = 1;
		}else{
			$this->page_num = ceil($this->num/$page_size);
		}
		$tmp_page = isset($_GET[$this->page_name])?intval($_GET[$this->page_name]):1;
		if( $tmp_page < 1 ){
			$this->page = 1;
		}elseif($tmp_page > $this->page_num){
			$this->page = $this->page_num;
		}else{
			$this->page = $tmp_page;
		}
		$sql.=' limit '.(($this->page-1)*$page_size).','.$page_size;
		$row=$db->fetchAll($sql,$cacheTime);
		//echo $sql;
		return $row;		
	}
	
	/**
	 * 获取信息的总数目
	 *
	 * @return unknown
	 */
	function getNum() {
		return $this->num;
	}
	
	/**
	 * 返回去除$page_name之后的查询字串
	 *
	 * @return unknown
	 */
	private function getQuery(){
		$query=$_SERVER['QUERY_STRING'];
		if(empty($query)) return basename($_SERVER['PHP_SELF']).'?';
		if(($end=strpos($query,$this->page_name)) !== false){
			if($end==0) $end=1;
			$query=substr($query,0,$end-1);
		}
		//echo $query;
		return $this->getFilename().$query.'&';
	}
	
	/**
	 * 获取当前的url文件名并带上?
	 */
	private function getFilename() {
		//$filename = str_replace($_SERVER['QUERY_STRING'],'',basename($_SERVER["REQUEST_URI"]));
		$filename = str_replace($_SERVER['QUERY_STRING'],'',basename($_SERVER["REQUEST_URI"]));
		if( stripos($filename,'?') === false ) {
			$filename = $filename.'?';
		}
		return $filename;
	}
	
	/**
	 * 返回带分页名的连接字符
	 */
	private function returnPageLink( $page ){
		return $this->getQuery().$this->page_name.'='.$page;
	}

	
	/**
	 * 输出中文分页链接 上一页，下一页
	 *
	 * @return unknown
	 */
	function pagelist( $total='总共',$dataname='条',$now='当前',$page='页',$first='第一页',$last='尾页',$prev='上一页',$next='下一页' ){
		$query=$this->getquery();
		$total='<span>'.$total.$this->num.$dataname.' '.$now.($this->page).'/'.($this->page_num).$page.'</span>';
		$startpage='<a href="'.$this->returnPageLink(1).'">'.$first.'</a>';
		$endpage='<a href="'.$this->returnPageLink($this->page_num).'">'.$last.'</a>';
		if($this->page == 1){
			$prepage='<a>'.$prev.'</a>';
		}else{
			$prepage='<a href="'.$this->returnPageLink($this->page-1).'">'.$prev.'</a>';
		}
		if($this->page==$this->page_num){
			$nextpage='<a>'.$next.'</a>';
		}else{
			$nextpage='<a href="'.$this->returnPageLink($this->page+1).'">'.$next.'</a>';
		}
		if($this->num == 0)return '';
		return $total.' '.$startpage.' '.$prepage.' '.$nextpage.' '.$endpage;
	}
	
	/**
	 * 输出下拉框的列表
	 *
	 */
	function select() {
		$select = '<select name="pageselect" id="pageselect"  onchange="window.location=\''.$this->getQuery().$this->page_name.'=\'+pageselect.value">';
		$totalnum = $this->page_num;
		for($i=1;$i<=$totalnum;$i++) {
			if($this->page == $i){
				$str = ' selected="selected"';
			} else {
				$str = '';
			}
			$select .= '<option value="'.$i.'"'.$str.'>'.$i.'</option>';
		}
		$select .= '</select>';
		if($this->num == 0)$select = '';
		return $select;		
	}

	/**
	 * 输入页数到多少页
	 *
	 */
	function gotoPage($buttonname='到'){
		$string = '<input type="text" size="3" name="dm_pagenum"><input type="button" value="'.$buttonname.'" onclick="window.location=\''.$this->getQuery().$this->page_name.'=\'+dm_pagenum.value"> ';
		if($this->num == 0)$string = '';
		return $string;
	}
	
	/**
	 * 类似百度的分页
	 *
	 */
	function pageListBaidu($first='首页',$pre_page='上一页',$next_page='下一页',$last='尾页' ) {
		if($this->page_num == 1) return;
	    $query=$this->getquery();
	    $pagelink = '';
		if($this->page != 1) {
			$pagelink .= '[<a href="'.$this->returnPageLink(1).'">'.$first.'</a>]&nbsp;';
			$pagelink .= '[<a href="'.$this->returnPageLink($this->page-1).'">'.$pre_page.'</a>]&nbsp;';
		}
		for ($i=6;$i>=1;$i--) {
			$tmp_page = $this->page - $i;
			if( $tmp_page >= 1 ) {
				$pagelink .= '[<a href="'.$this->returnPageLink($tmp_page).'">'.$tmp_page.'</a>]&nbsp;';
			}
		}
		$pagelink .= $this->page.'&nbsp;';
		for ($i=1;$i<=6;$i++) {
			$tmp_page = $this->page + $i;
			if( $tmp_page <= $this->page_num ) {
				$pagelink .= '[<a href="'.$this->returnPageLink($tmp_page).'">'.$tmp_page.'</a>]&nbsp;';
			}
		}		
		
		if( $this->page != $this->page_num ){
			$pagelink .= '[<a href="'.$this->returnPageLink($this->page+1).'">'.$next_page.'</a>]&nbsp;';
			$pagelink .= '[<a href="'.$this->returnPageLink($this->page_num).'">'.$last.'</a>]';
		}
	    if($this->num == 0)$pagelink = '';
	    return $pagelink;   
	}
	
	/**
	 * 类似百度的分页2(无[]符号)
	 *
	 */
	function pageListBaidu2($first='首页',$pre_page='上一页',$next_page='下一页',$last='尾页' ) {
		if($this->page_num == 1) return;
	    $query=$this->getquery();
	    $pagelink = '';
		if($this->page != 1) {
			$pagelink .= '<a href="'.$this->returnPageLink(1).'">'.$first.'</a>';
			$pagelink .= '<a href="'.$this->returnPageLink($this->page-1).'">'.$pre_page.'</a>';
		}
		for ($i=6;$i>=1;$i--) {
			$tmp_page = $this->page - $i;
			if( $tmp_page >= 1 ) {
				$pagelink .= '<a href="'.$this->returnPageLink($tmp_page).'">'.$tmp_page.'</a>';
			}
		}
		$pagelink .= '<a class=cu>'.$this->page.'</a>';
		for ($i=1;$i<=6;$i++) {
			$tmp_page = $this->page + $i;
			if( $tmp_page <= $this->page_num ) {
				$pagelink .= '<a href="'.$this->returnPageLink($tmp_page).'">'.$tmp_page.'</a>';
			}
		}		
		
		if( $this->page != $this->page_num ){
			$pagelink .= '<a href="'.$this->returnPageLink($this->page+1).'">'.$next_page.'</a>';
			$pagelink .= '<a href="'.$this->returnPageLink($this->page_num).'">'.$last.'</a>';
		}
	    if($this->num == 0)$pagelink = '';
	    return $pagelink;   
	}	
	
	
} 
?>