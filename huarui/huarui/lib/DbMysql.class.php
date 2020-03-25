<?php
/**
 * Mysql数据库操作类 v2.0
 * 2009.1.22 by Aboc QQ:9986584
 * 增加文件缓存
 *
 */
class DbMysql {
	/**
	 * 在数据库操作中,只对数据库操作有影响的字符做转义
	 * 当此类正常后,所有数据操作 @
	 */

	/*
	 * 数据库连接句柄
	 */
	private $_Db = NULL;

	/*
	 * 是否持续连接 0.1
	 */
	private $_pconnect = 0;

	/*
	 * 编码
	 */
	private $_charset = 'utf8';
	
	
	/*
	 *最后一次插入的ID
	 */
	 private $_lastId = 0;

	/*
	 * 默认数据库配置
	 */
	private $_config = array ('dbhost' => 'localhost', 'dbuser' => 'root', 'dbpass' => 'root', 'dbname' => 'test' );
	
	/**
	 * 缓存路径
	 */
	private $_cachePath = '';

	/**
	 * 初始连接数据库
	 */
	function __construct($config,$pconnect=0) {
		if (empty($config)) $config = array();
		$this->checkConfig ( $config );
		$this->_pconnect = $pconnect;
		$this->connect ();
		$this->query ( 'set names ' . $this->_charset ); //设置编码
		$this->queryA();
//		if(empty($this->_cachePath))$this->_cachePath = DM_ROOT.'cache/sql/';
	}

	/**
	 * 判断config变量
	 *
	 * @param unknown_type $config
	 */
	private function checkConfig($config) {
		foreach ( $config as $key => $value ) {
			$this->_config [$key] = empty ( $value ) ? $this->_config [$key] : $value;
		}
		//return $this->_config;
	}

	/*
	 * 连接数据库
	 */
	private function connect() {
//		print_r($this->_config);
		if ($this->_pconnect) {
			$this->_Db = mysql_pconnect ( $this->_config ['dbhost'], $this->_config ['dbuser'], $this->_config ['dbpass'] ) or die ( '数据库连接失败' . mysql_errno () );
		} else {
			$this->_Db = mysql_connect ( $this->_config ['dbhost'], $this->_config ['dbuser'], $this->_config ['dbpass'] ) or die ( '数据库连接失败' . mysql_errno () );
		}
		if ($this->_Db != NULL) {
			mysql_select_db ( $this->_config ['dbname'], $this->_Db ) or die ( '数据库' . $this->_config ['dbname'] . '不存在' );
		}
	}

	/**
	 * 将变量的单引号或双引号转义
	 *
	 * @param unknown_type $string
	 */
	private function strtag($string1) {
			if (is_array ( $string1 )) {
				foreach ( $string1 as $key => $value ) {
					$stringnew [$this->strtag ( $key )] = $this->strtag ( $value );
				}
			} else {
				//在此做转义,对单引号
				//TODO 好像 %也要转义吧?
				//$string = iconv("gbk","gbk",$string);
				$stringnew = mysql_real_escape_string ( $string1 );
//				$stringnew = get_magic_quotes_gpc()?$string:addslashes ( $string1 );
//				$stringnew=str_replace(array("'",'"'),array("\'",'\"'),$string1);
			}
		return $stringnew;
	}

	/**
	 * 将数组转化为SQL接受的条件样式
	 *
	 * @param unknown_type $array
	 */
	private function chageArray($array) {
		//MYSQL支持insert into joincart set session_id = 'dddd',product_id='44',number='7',jointime='456465'
		//所以更新和插入可以使用同一组数据
		$array = $this->strtag ( $array ); //转义
		$str = '';
		foreach ( $array as $key => $value ) {
			$value = is_numeric($value)?$value:"'$value'";
			$str .= empty ( $str ) ? '`' . $key . '`=' . $value : ', `' . $key . '`=' . $value;
		}
		return $str;
	}

	/**
	 * 执行查询语句
	 * @return bool
	 */
	public function query($sql) {
//		echo $sql.'<br>';
		if (! $result = mysql_query ( $sql, $this->_Db)) {
			echo $sql.'<br>';
			die ( 'Error:'.mysql_error ());
		} else {
			return $result;
		}
	}


	/**
	 * 插入记录
	 *
	 */
	public function insert($table, $array) {
		if(!is_array($array))return false;
		$array = $this->strtag ( $array ); //转义
		$str = '';
		$val = '';
		foreach ($array as $key=>$value){
			$value = is_numeric($value)?$value:"'$value'";
			$str .= ($str != '')?",`$key`":"`$key`";
			$val .= ($val != '')?",$value":"$value";
		}
		$sql = 'insert into `' . $table . '` ('.$str. ') values('.$val.')';
		if ($this->query ( $sql )) {
			$this->lastId();
			return $this->_lastId?$this->_lastId:true;
		} else {
			return false;
		}
	}

	/**
	 * 更新记录
	 *
	 */
	public function update($table, $array, $where = NULL) {
		if ($where == NULL) {
			$sql = 'update `' . $table . '` set ' . $this->chageArray ( $array );
		} else {
			$sql = 'update `' . $table . '` set ' . $this->chageArray ( $array ) . ' where ' . $where;
		}
		if ($this->query ( $sql )) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * 删除记录
	 *
	 */
	public function delete($table, $where = NULL) {
		if ($where == NULL) {
			$sql = 'delete from `' . $table . '`';
		} else {
			$sql = 'delete from `' . $table . '` where ' . $where;
		}
		if ($this->query ( $sql )) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * 获取一条记录
	 *
	 */
	public function fetchRow($sql,$cacheTime=0,$cacheId='') {
		if($content = $this->checkCache($sql,$cacheTime,$cacheId)){
			return $content;
		} else{
			$reult = $this->query ( $sql );
			$row = mysql_fetch_assoc ( $reult );
			if(!empty($row)){
				foreach ($row as $key=>$value){
					$row[$key] = stripslashes($value);
				}
			}
		if($cacheTime)$this->createCache($sql,$row,$cacheId);
		return $row;
		}
	}

	/**
	 * 获取所有记录/用的mysql_fetch_assoc循环
	 *
	 */
	public function fetchAll($sql,$cacheTime=0,$cacheId='') {
		if($content = $this->checkCache($sql,$cacheTime,$cacheId)){
			return $content;
		} else{
			$result = $this->query ( $sql );
			if ($result !== false) {
				$arr = array ();
				while ( $row = mysql_fetch_assoc ( $result ) ) {
					if(!empty($row)){
						foreach ($row as $key=>$value){
							$row[$key] = stripslashes($value);
						}
					}
					$arr [] = $row;
				}
				if($cacheTime)$this->createCache($sql,$arr,$cacheId);
				return $arr;
			} else {
				return array();
			}
		}
	}
	
	/**
	 * 获取最后一次影响的Id
	 *
	 */
	public function lastId() {
		$this->_lastId = mysql_insert_id ( $this->_Db );
		return $this->_lastId;
	}

	/**
	 * 获取符合条件的记录数
	 *
	 */
	public function fetchNum($sql) {
		$reult = $this->query ( $sql );
		$num = mysql_num_rows ( $reult );
		return $num;
	}

	/**
	 * 输出适合的where语句
	 */
	public function quoteInto($string,$value ) {
		$value = $this->strtag($value);
		if(is_numeric($value)){
			$string = str_replace('?',$value,$string);
		}else{
		    $string = str_replace('?',"'".$value."'",$string);
		}
		return $string;
	}
	
	/**
	 * 查询相关语句
	 */
	public function queryA(){

	}
	
	
	/**
	 * 判断缓存文件是否有效,如果有效，则返回缓存内容
	 */
	private function checkCache($sql,$cacheTime = 0,$cacheId=''){
		//个人版不提供
		
	}
	
	/**
	 * 生成缓存
	 */
	private function createCache($sql,$data,$cacheId=''){
		//个人版不提供
	}
	
	/**
	 * 根据sql语句生成文件名及路径
	 */
	private function createFilename($sql,$cacheId=''){
		//个人版不提供
	}
	
	/**
	 * 清除缓存
	 * 
	 * 条件为空则清除所有缓存
	 * 
	 * @return DbMysql
	 */
	public function clearCache($sql='',$cacheId=''){
		//个人版不提供
	}

	/**
	 * 遍历删除文件及目录
	 */
	private function clearFile($cachePath,$times){
		//个人版不提供	
	}

	

	/**
	 * 释放查询结果
	 */
	private function free() {
		mysql_free_result($this->_Db);
	}

	/**
	 *
	 */
	function __destruct() {
//		$this->free();
	}
}

?>
