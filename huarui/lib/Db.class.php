<?php
require_once SITEROOT.'lib/DbMysql.class.php';
class Db {
	
	private static $_Db = NULL;
	
		
	/*
	 * 数据库配置
	 */
	protected static $_config=array(
					'dbhost'	=>	UC_DBHOST,
					'dbuser'	=>	UC_DBUSER,
					'dbpass'	=>	UC_DBPW,
					'dbname'	=>	UC_DBNAME
					);
    
    /**
     * 打开数据库连接
     * @return DbMysql
     */
    static public function open(){
    	if(self::$_Db == NULL){
    		self::$_Db = new DbMysql(self::$_config,1);
    	}
    	return self::$_Db;
    }


}

?>